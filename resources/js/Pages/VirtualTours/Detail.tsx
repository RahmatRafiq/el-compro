import React from "react";
import { usePage } from "@inertiajs/react";
import Layout from "@/Layouts/Layout";
import parse from "html-react-parser";
interface VirtualTour {
  id: number;
  name: string;
  url_embed: string;
  description: string;
}

interface VirtualTourDetailProps {
  virtualTour: VirtualTour;
  aboutApp: {
    title: string;
    contact_email: string;
    contact_phone: string;
    contact_address: string;
  };
}

const VirtualTourDetail: React.FC<VirtualTourDetailProps> = ({ virtualTour, aboutApp }) => {


  if (!virtualTour) {
    return <div className="text-center py-10">Virtual Tour tidak ditemukan.</div>;
  }

  return (
    <Layout aboutApp={aboutApp}>
      <div className="space-y-8 px-6">
        <div className="p-8">
          <h1 className="text-3xl font-bold text-center mb-6">{virtualTour.name}</h1>

          <div className="max-w-4xl mx-auto shadow-lg rounded-lg overflow-hidden">
            <iframe
              src={virtualTour.url_embed}
              title={virtualTour.name}
              className="w-full h-64 md:h-96"
              allowFullScreen
            ></iframe>

            <div className="p-6">
              <p className="text-lg">{parse(virtualTour.description)}</p>
            </div>
          </div>
        </div>
      </div>
    </Layout>
  );
};

export default VirtualTourDetail;
