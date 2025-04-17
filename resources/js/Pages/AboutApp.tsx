import Layout from "@/Layouts/Layout";
import React from "react";
import { FaEnvelope, FaPhone, FaMapMarkerAlt } from "react-icons/fa";

interface AboutAppData {
  title: string;
  description: string;
  greeting: string;
  vision_mission: string;
  history: string;
  contact_email: string;
  contact_phone: string;
  contact_address: string;
  image?: string | null;
}

interface AboutAppPageProps {
  aboutApp: AboutAppData;
}

const AboutAppPage: React.FC<AboutAppPageProps> = ({ aboutApp }) => {
  return (
    <Layout aboutApp={aboutApp}>
      <div className="max-w-6xl mx-auto px-4 md:px-8 py-16 space-y-16">

        {/* Hero Header */}
        <div className="hero bg-base-200 rounded-xl shadow-md py-10">
          <div className="hero-content text-center flex-col">
            <h1 className="text-5xl font-bold text-primary">{aboutApp.title}</h1>
            <p className="py-4 max-w-2xl text-gray-600">{aboutApp.description}</p>
          </div>
        </div>

        {/* Struktur Organisasi */}
        {aboutApp.image && (
          <div className="flex justify-center">
            <figure className="rounded-2xl shadow-lg overflow-hidden border border-base-300 max-w-4xl">
              <img
                src={aboutApp.image}
                alt="Struktur Organisasi"
                className="w-full object-contain"
              />
              <figcaption className="bg-base-100 text-center text-sm text-gray-500 py-2">
                STRUKTUR ORGANISASI
              </figcaption>
            </figure>
          </div>
        )}


        {/* Konten Section */}
        <div className="bg-base-200 px-4 py-8 rounded-xl shadow-md">
          <div className="max-w-4xl mx-auto space-y-8">
            <CollapseCard title="SEKAPUR SIRIH" content={aboutApp.greeting} />
            <CollapseCard title="VISI & MISI" content={aboutApp.vision_mission} />
            <CollapseCard title="SEJARAH SINGKAT" content={aboutApp.history} />
          </div>
        </div>


        {/* Kontak Section */}
        <div className="card bg-base-300 shadow-xl">
          <div className="card-body space-y-4">
            <h2 className="card-title text-2xl">Kontak</h2>
            <div className="grid md:grid-cols-3 gap-6 text-base-content">
              <ContactItem icon={<FaEnvelope />} label="Email" value={aboutApp.contact_email} href={`mailto:${aboutApp.contact_email}`} />
              <ContactItem icon={<FaPhone />} label="Telepon" value={aboutApp.contact_phone} href={`tel:${aboutApp.contact_phone}`} />
              <ContactItem icon={<FaMapMarkerAlt />} label="Alamat" value={aboutApp.contact_address} />
            </div>
            {/* Embed Google Maps */}
            {aboutApp.contact_address && (
              <div className="mt-6 rounded-lg overflow-hidden shadow-md">
                <iframe
                  title="Lokasi"
                  src={`https://www.google.com/maps?q=${encodeURIComponent(aboutApp.contact_address)}&output=embed`}
                  width="100%"
                  height="300"
                  style={{ border: 0 }}
                  allowFullScreen
                  loading="lazy"
                  referrerPolicy="no-referrer-when-downgrade"
                ></iframe>
              </div>
            )}
          </div>
        </div>
      </div>
    </Layout>
  );
};

// Collapse style card
const CollapseCard: React.FC<{ title: string; content: string }> = ({
  title,
  content,
}) => (
  <div className="collapse collapse-arrow bg-base-100 shadow border border-base-200">
    <input type="checkbox" />
    <div className="collapse-title text-xl font-medium text-primary text-center">
      {title}
    </div>
    <div className="collapse-content">
      <p className="whitespace-pre-line leading-relaxed text-gray-700">{content}</p>
    </div>
  </div>
);


// Contact item block
const ContactItem: React.FC<{
  icon: React.ReactNode;
  label: string;
  value: string;
  href?: string;
}> = ({ icon, label, value, href }) => {
  return (
    <div className="flex items-start gap-3">
      <div className="text-xl text-primary mt-1">{icon}</div>
      <div>
        <p className="font-semibold">{label}</p>
        {href ? (
          <a href={href} className="link link-hover text-sm">
            {value}
          </a>
        ) : (
          <p className="text-sm">{value}</p>
        )}
      </div>
    </div>
  );
};

export default AboutAppPage;
