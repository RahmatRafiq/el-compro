// resources/js/Layouts/Layout.tsx
import React from 'react';
import Header from './Header';
import Footer from './Footer';
import ThemeController from './ThemeController';

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
    return (
        <div className="min-h-screen">
            <Header />
            <main className="px-4 py-6 mt-20">{children}</main>
            <Footer aboutApp={aboutApp} />
            <ThemeController />
        </div>
    );
};

export default Layout;
