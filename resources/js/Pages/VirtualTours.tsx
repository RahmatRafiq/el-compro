import React from "react";
import { Link } from "@inertiajs/react";
import Layout from "@/Layouts/Layout";
import parse from "html-react-parser";

interface VirtualTour {
  id: number;
  name: string;
  url_embed: string;
  description: string;
}

interface VirtualTourPageProps {
  virtualTours: VirtualTour[];
  aboutApp: {
    title: string;
    contact_email: string;
    contact_phone: string;
    contact_address: string;
  };
}

const VirtualTourPage: React.FC<VirtualTourPageProps> = ({ virtualTours, aboutApp }) => {
  return (
    <Layout aboutApp={aboutApp}>
      <div className="space-y-8 px-6">
        <div className="p-8">
          <h1 className="text-3xl font-bold text-center mb-6">Semua Virtual Tours</h1>

          <div className="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            {virtualTours.map((tour) => (
              <div key={tour.id} className="shadow-lg rounded-lg overflow-hidden">
                <iframe
                  src={tour.url_embed}
                  title={tour.name}
                  className="w-full h-48 md:h-64"
                  allowFullScreen
                ></iframe>
                <div className="p-4">
                  <h2 className="text-xl font-semibold">{tour.name}</h2>
                    <p>{parse(tour.description.length > 100 ? tour.description.substring(0, 100) + "..." : tour.description)}</p>

                  <Link
                    href={`/virtual-tours/${encodeURIComponent(tour.name.replace(/\s+/g, "-").toLowerCase())}`}
                    className="mt-3 inline-block bg-primary text-white px-4 py-2 rounded-md hover:bg-primary-dark transition"
                  >
                    Lihat Detail
                  </Link>
                </div>
              </div>
            ))}
          </div>
        </div>
      </div>
    </Layout>
  );
};

export default VirtualTourPage;
