import React, { useState } from "react";
import Header from "./Header";
import Footer from "./Footer";
import ThemeController from "./ThemeController";

interface LayoutProps {
  children: React.ReactNode;
  aboutApp: {
    title: string;
    contact_email: string;
    contact_phone: string;
    contact_address: string;
  };
}

const Layout: React.FC<LayoutProps> = ({ children, aboutApp }) => {
  const [isDropdownOpen, setIsDropdownOpen] = useState(false);

  const handleCloseDropdown = () => {
    if (isDropdownOpen) setIsDropdownOpen(false);
  };

  return (
    <div className="relative min-h-screen">
      <Header isDropdownOpen={isDropdownOpen} setIsDropdownOpen={setIsDropdownOpen} />

      <main
        className={`px-4 py-6 mt-20 transition-all duration-300 ${isDropdownOpen ? "blur-lg" : ""
          }`}
        onClick={handleCloseDropdown}
      >
        {children}
      </main>

      <Footer aboutApp={aboutApp} />
      <ThemeController />
    </div>
  );
};

export default Layout;
