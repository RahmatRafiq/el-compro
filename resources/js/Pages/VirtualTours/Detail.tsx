import React, { useState, useRef } from "react";
import { usePage } from "@inertiajs/react";
import { Layout } from "@/Layouts";
import parse from "html-react-parser";
import type { VirtualTour, AboutApp } from '@/types';

interface VirtualTourDetailProps {
  virtualTour: VirtualTour;
  aboutApp: AboutApp;
}

const VirtualTourDetail: React.FC<VirtualTourDetailProps> = ({ virtualTour, aboutApp }) => {
  const [isLoading, setIsLoading] = useState(true);
  const [isFullscreen, setIsFullscreen] = useState(false);
  const iframeRef = useRef<HTMLIFrameElement>(null);

  const handleIframeLoad = () => {
    setIsLoading(false);
  };

  const toggleFullscreen = async () => {
    try {
      if (!document.fullscreenElement) {
        // Enter fullscreen
        if (iframeRef.current?.requestFullscreen) {
          await iframeRef.current.requestFullscreen();
        }
      } else {
        // Exit fullscreen
        await document.exitFullscreen();
      }
    } catch (error) {
      console.error('Fullscreen error:', error);
    }
  };

  // Listen for fullscreen changes
  React.useEffect(() => {
    const handleFullscreenChange = () => {
      setIsFullscreen(!!document.fullscreenElement);
    };

    const handleKeyDown = (event: KeyboardEvent) => {
      if (event.key === 'Escape' && document.fullscreenElement) {
        setIsFullscreen(false);
      }
    };

    document.addEventListener('fullscreenchange', handleFullscreenChange);
    document.addEventListener('webkitfullscreenchange', handleFullscreenChange);
    document.addEventListener('mozfullscreenchange', handleFullscreenChange);
    document.addEventListener('MSFullscreenChange', handleFullscreenChange);
    document.addEventListener('keydown', handleKeyDown);

    return () => {
      document.removeEventListener('fullscreenchange', handleFullscreenChange);
      document.removeEventListener('webkitfullscreenchange', handleFullscreenChange);
      document.removeEventListener('mozfullscreenchange', handleFullscreenChange);
      document.removeEventListener('MSFullscreenChange', handleFullscreenChange);
      document.removeEventListener('keydown', handleKeyDown);
    };
  }, []);


  if (!virtualTour) {
    return <div className="text-center py-10">Virtual Tour tidak ditemukan.</div>;
  }

  return (
    <Layout aboutApp={aboutApp}>
      {/* Full width container tanpa padding horizontal */}
      <div className="w-full">
        {/* Header section dengan container terbatas */}
        <div className="container mx-auto px-4 sm:px-6 lg:px-8 py-8">
          <div className="text-center space-y-4">
            <h1 className="text-2xl sm:text-3xl lg:text-4xl font-bold text-base-content leading-tight">
              {virtualTour.name}
            </h1>
            <p className="text-base-content/70 text-sm sm:text-base max-w-2xl mx-auto">
              Jelajahi virtual tour interaktif ini dengan kualitas tinggi. Gunakan mouse atau sentuhan untuk navigasi.
            </p>
          </div>
        </div>

        {/* Virtual tour iframe - full width dengan kontrol */}
        <div className="w-full bg-base-200 relative">
          {/* Loading overlay */}
          {isLoading && (
            <div className="absolute inset-0 flex items-center justify-center bg-base-200 z-10">
              <div className="text-center space-y-4">
                <div className="loading loading-spinner loading-lg text-primary"></div>
                <p className="text-base-content/70">Memuat virtual tour...</p>
              </div>
            </div>
          )}

          {/* Kontrol toolbar */}
          <div className="absolute top-4 right-4 z-20 flex space-x-2">
            <button
              onClick={toggleFullscreen}
              className="btn btn-ghost bg-base-content/70 hover:bg-base-content/90 text-base-100 p-3 rounded-lg transition-all duration-200 backdrop-blur-sm shadow-lg group border-0"
              title={isFullscreen ? "Keluar dari Fullscreen (ESC)" : "Masuk Fullscreen"}
            >
              {isFullscreen ? (
                <svg className="w-5 h-5 group-hover:scale-110 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path strokeLinecap="round" strokeLinejoin="round" strokeWidth={2} d="M6 18L18 6M6 6l12 12" />
                </svg>
              ) : (
                <svg className="w-5 h-5 group-hover:scale-110 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path strokeLinecap="round" strokeLinejoin="round" strokeWidth={2} d="M4 8V4m0 0h4M4 4l5 5m11-1V4m0 0h-4m4 0l-5 5M4 16v4m0 0h4m-4 0l5-5m11 5l-5-5m5 5v-4m0 4h-4" />
                </svg>
              )}
            </button>
          </div>

          <iframe
            ref={iframeRef}
            src={virtualTour.url_embed}
            title={virtualTour.name}
            className="w-full h-64 sm:h-80 md:h-96 lg:h-[500px] xl:h-[600px] border-0 shadow-lg"
            allowFullScreen
            onLoad={handleIframeLoad}
            allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share"
          ></iframe>
        </div>

        {/* Description section dengan container terbatas */}
        <div className="container mx-auto px-4 sm:px-6 lg:px-8 py-12">
          <div className="max-w-4xl mx-auto">
            <div className="card bg-base-100 shadow-xl border border-base-300">
              <div className="card-header bg-base-200 px-6 py-4 border-b border-base-300">
                <h2 className="card-title text-xl text-base-content flex items-center">
                  <svg className="w-5 h-5 mr-2 text-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path strokeLinecap="round" strokeLinejoin="round" strokeWidth={2} d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                  </svg>
                  Deskripsi Virtual Tour
                </h2>
              </div>
              <div className="card-body p-6 md:p-8">
                <div className="prose prose-lg max-w-none text-base-content leading-relaxed">
                  {parse(virtualTour.description)}
                </div>
              </div>
            </div>

            {/* Tips penggunaan */}
            <div className="mt-8 alert alert-info">
              <svg className="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path strokeLinecap="round" strokeLinejoin="round" strokeWidth={2} d="M9.663 17h4.673M12 3v1m6.364 1.636l-.707.707M21 12h-1M4 12H3m3.343-5.657l-.707-.707m2.828 9.9a5 5 0 117.072 0l-.548.547A3.374 3.374 0 0014 18.469V19a2 2 0 11-4 0v-.531c0-.895-.356-1.754-.988-2.386l-.548-.547z" />
              </svg>
              <div>
                <h3 className="font-semibold text-lg mb-3">Tips Navigasi</h3>
                <ul className="space-y-2 text-sm">
                  <li className="flex items-start">
                    <span className="w-2 h-2 bg-current rounded-full mt-2 mr-3 flex-shrink-0 opacity-60"></span>
                    Gunakan mouse untuk melihat ke segala arah
                  </li>
                  <li className="flex items-start">
                    <span className="w-2 h-2 bg-current rounded-full mt-2 mr-3 flex-shrink-0 opacity-60"></span>
                    Klik tombol fullscreen untuk pengalaman immersive
                  </li>
                  <li className="flex items-start">
                    <span className="w-2 h-2 bg-current rounded-full mt-2 mr-3 flex-shrink-0 opacity-60"></span>
                    Tekan ESC atau klik tombol X untuk keluar dari fullscreen
                  </li>
                  <li className="flex items-start">
                    <span className="w-2 h-2 bg-current rounded-full mt-2 mr-3 flex-shrink-0 opacity-60"></span>
                    Cari hotspot interaktif untuk informasi lebih detail
                  </li>
                </ul>
              </div>
            </div>
          </div>
        </div>
      </div>
    </Layout>
  );
};

export default VirtualTourDetail;
