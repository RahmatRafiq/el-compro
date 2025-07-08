import React from "react";
import { Link } from "@inertiajs/react";
import { Swiper, SwiperSlide } from "swiper/react";
import { Pagination, Navigation, Autoplay } from "swiper/modules";
import "swiper/css";
import "swiper/css/pagination";
import "swiper/css/navigation";
import parse from "html-react-parser";
import type { VirtualTour } from '@/types';

interface VirtualToursSectionProps {
  virtualTours: VirtualTour[];
}

const VirtualToursSection: React.FC<VirtualToursSectionProps> = ({ virtualTours }) => {
  return (
      <div className="w-full py-8">
        <h2 className="text-3xl font-bold text-center mb-6">Virtual Tours</h2>

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
                <div className="absolute bottom-0 left-0 w-full bg-gradient-to-t from-black/80 to-transparent p-4 rounded-b-lg">
                  <div className="backdrop-blur-md  p-3 rounded-md shadow-lg">
                    <h3 className="text-lg font-bold text-white">{tour.name}</h3>
                    <div className="text-sm text-white">{parse(tour.description.length > 50 ? tour.description.substring(0, 50) + "..." : tour.description)}</div>
                    <div className="mt-3">
                      <Link
                        href={`/virtual-tours/${encodeURIComponent(tour.name.replace(/\s+/g, "-").toLowerCase())}`}
                        className="bg-primary text-white px-4 py-2 rounded-md inline-block hover:bg-primary-dark transition"
                      >
                        Lihat Detail
                      </Link>
                    </div>
                  </div>
                </div>
              </div>
            </SwiperSlide>
          ))}
        </Swiper>
        <div className="divider divider-vertical divider-end mt-8">
          <Link href="/virtual-tours" className="btn btn-secondary">
            Lihat Semua Virtual Tour
          </Link>
        </div>
      </div>
  
  );
};

export default VirtualToursSection;
