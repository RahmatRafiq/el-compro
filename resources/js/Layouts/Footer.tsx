import React from "react";

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
        <img
          src="assets/images/logo-sm.png"
          alt="Logo"
          width="100"
          height="100"
        />
        {aboutApp?.title && (
          <p>
            {aboutApp.title}
            {aboutApp.description && <br />}
            {aboutApp.description}
          </p>
        )}
      </aside>
      <nav>
        <h6 className="footer-title">Contact</h6>
        <div className="grid grid-flow-row gap-2">
          {aboutApp?.contact_email && (
            <p>Email: <a href={`mailto:${aboutApp.contact_email}`}>{aboutApp.contact_email}</a></p>
          )}
          {aboutApp?.contact_phone && (
            <p>Phone: <a href={`tel:${aboutApp.contact_phone}`}>{aboutApp.contact_phone}</a></p>
          )}
            {aboutApp?.contact_address && (
            <p>
              Address: <a href={`https://www.google.com/maps/search/?api=1&query=${encodeURIComponent(aboutApp.contact_address)}`} target="_blank" rel="noopener noreferrer">
              {aboutApp.contact_address}
              </a>
            </p>
            )}
        </div>
      </nav>
    </footer>
  );
};

export default Footer;
