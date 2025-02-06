// VirtualToursSection.tsx
import React from "react";

interface VirtualTour {
  id: number;
  name: string;
  url_embed: string;
  description: string;
  category: {
    id: number;
    name: string;
  };
}

interface VirtualToursSectionProps {
  virtualTours: VirtualTour[];
}

const VirtualToursSection: React.FC<VirtualToursSectionProps> = ({ virtualTours }) => {
  return (
    <section className="virtual-tours p-6 bg-neutral rounded-lg shadow-lg">
      <h2 className="text-2xl font-bold mb-4 text-center text-primary">Virtual Tours</h2>

      {/* DaisyUI Carousel */}
      <div className="carousel w-full overflow-hidden rounded-lg shadow-md">
        {virtualTours.map((tour, index) => (
          <div key={tour.id} id={`item${index + 1}`} className="carousel-item w-full">
            <iframe
              src={tour.url_embed}
              title={tour.name}
              className="w-full h-[500px] border-none rounded-lg"
              allowFullScreen
            ></iframe>
          </div>
        ))}
      </div>

      {/* Navigasi Tombol */}
      <div className="flex w-full justify-center gap-2 py-4">
        {virtualTours.map((tour, index) => (
          <a key={tour.id} href={`#item${index + 1}`} className="btn btn-xs btn-primary">
            {index + 1}
          </a>
        ))}
      </div>
    </section>
  );
};

export default VirtualToursSection;
