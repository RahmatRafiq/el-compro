// resources/js/Layouts/Layout.tsx
import React from 'react';
import Header from './Header';
import Footer from './Footer';
import ThemeController from './ThemeController';

interface LayoutProps {
    children: React.ReactNode;
}

const Layout: React.FC<LayoutProps> = ({ children }) => {
    return (
        <div className="min-h-screen">
            <Header />
            <main className="px-4 py-6">{children}</main>
            <Footer />
            {/* <ThemeController /> */}
        </div>
    );
};

export default Layout;
