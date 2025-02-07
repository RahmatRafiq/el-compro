import React from "react";
import { Swiper, SwiperSlide } from "swiper/react";
import { Pagination, Navigation, Autoplay } from "swiper/modules";
import "swiper/css";
import "swiper/css/pagination";
import "swiper/css/navigation";

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
    <section className="p-8 bg-base-300 rounded-lg shadow-xl">
      <h2 className="text-3xl font-bold text-center  mb-6">Virtual Tours</h2>

      {/* Swiper Carousel */}
      <Swiper
        spaceBetween={20}
        centeredSlides={true}
        autoplay={{ delay: 5000, disableOnInteraction: false }}
        pagination={{ clickable: true }}
        navigation={true}
        modules={[Autoplay, Pagination, Navigation]}
        className="rounded-lg shadow-lg"
      >
        {virtualTours.map((tour) => (
          <SwiperSlide key={tour.id}>
            <div className="relative">
              <iframe
                src={tour.url_embed}
                title={tour.name}
                className="w-full h-[450px] md:h-[500px] border-none rounded-lg"
                allowFullScreen
              ></iframe>

              {/* Overlay Blur Background */}
              <div className="absolute bottom-0 left-0 w-full bg-gradient-to-t from-black/80 to-transparent p-4 rounded-b-lg">
                <div className="backdrop-blur-md bg-white/20 p-3 rounded-md shadow-lg">
                  <h3 className="text-lg font-semibold">{tour.name}</h3>
                  <div
                    className="text-sm opacity-90"
                    dangerouslySetInnerHTML={{ __html: tour.description }}
                  />
                </div>
              </div>
            </div>
          </SwiperSlide>
        ))}
      </Swiper>
    </section>
  );
};

export default VirtualToursSection;
