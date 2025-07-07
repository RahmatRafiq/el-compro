import React from "react";
import { Link } from "@inertiajs/react";

interface AboutApp {
  title?: string;
  description?: string;
  contact_email?: string;
  contact_phone?: string;
  contact_address?: string;
}

interface FooterProps {
  aboutApp?: AboutApp;
}

const Footer: React.FC<FooterProps> = ({ aboutApp }) => {
  return (
    <footer className="footer bg-neutral text-neutral-content p-10">
      <aside>
        <a href="https://unifa.ac.id/" target="_blank" rel="noopener noreferrer">
          <img
            src="/assets/images/logo-sm.png"
            alt="Logo"
            width="100"
            height="100"
          />
        </a>

        {aboutApp?.title && (
          <div className="mt-4">
            <p className="mb-2">
              {aboutApp.title}
              {aboutApp.description && <><br />{aboutApp.description}</>}
            </p>

            <Link
              href="/about-us"
              className="btn btn-sm btn-outline btn-accent mt-2"
            >
              Selengkapnya
            </Link>
          </div>
        )}
      </aside>

      <nav>
        <h6 className="footer-title">Contact</h6>
        <div className="grid grid-flow-row gap-2">
          {aboutApp?.contact_email && (
            <p>
              Email:{" "}
              <a href={`mailto:${aboutApp.contact_email}`}>
                {aboutApp.contact_email}
              </a>
            </p>
          )}
          {aboutApp?.contact_phone && (
            <p>
              Phone:{" "}
              <a href={`tel:${aboutApp.contact_phone}`}>
                {aboutApp.contact_phone}
              </a>
            </p>
          )}
          {aboutApp?.contact_address && (
            <div className="mt-4">
              <iframe
                title="Lokasi"
                src={`https://www.google.com/maps?q=${encodeURIComponent(aboutApp.contact_address)}&output=embed`}
                width="100%"
                height="200"
                style={{ border: 0 }}
                allowFullScreen
                loading="lazy"
                referrerPolicy="no-referrer-when-downgrade"
                className="rounded-lg shadow-md"
              ></iframe>
            </div>
          )}

        </div>
      </nav>
    </footer>
  );
};

export default Footer;
