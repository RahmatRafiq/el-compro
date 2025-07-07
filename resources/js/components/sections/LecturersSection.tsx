import React from 'react';
import { router } from '@inertiajs/react';
import type { Lecturer } from '@/types';

interface LecturersSectionProps {
  lecturers: Lecturer[];
}

const LecturersSection: React.FC<LecturersSectionProps> = ({ lecturers }) => {
  return (
    <section className="container mx-auto px-4 sm:px-6 lg:px-8 py-12">
      <div className="text-center space-y-4 mb-8">
        <h2 className="text-2xl sm:text-3xl lg:text-4xl font-bold text-base-content">Dosen Kami</h2>
        <p className="text-base-content/70 text-sm sm:text-base max-w-2xl mx-auto">
          Tim dosen berpengalaman yang siap membimbing mahasiswa dalam perjalanan akademik mereka.
        </p>
      </div>

      <div className="grid grid-cols-1 lg:grid-cols-2 xl:grid-cols-3 gap-6">
        {lecturers.slice(0, 5).map((lecturer) => (
          <div key={lecturer.id} className="card bg-base-100 shadow-xl hover:shadow-2xl transition-all duration-300 transform hover:-translate-y-1">
            {/* Mobile: Vertical Layout */}
            <div className="block sm:hidden">
              <figure className="h-48 overflow-hidden">
                <img
                  src={lecturer.image}
                  alt={lecturer.name}
                  className="w-full h-full object-cover"
                />
              </figure>
              <div className="card-body p-4 space-y-3">
                <h3 className="card-title text-lg text-base-content">{lecturer.name}</h3>
                {lecturer.courses.length > 0 && (
                  <p className="text-sm text-primary font-medium">
                    Mengajar: {lecturer.courses.map(course => course.name).join(", ")}
                  </p>
                )}
                {lecturer.about && (
                  <p className="text-sm text-base-content/70 line-clamp-3">
                    {lecturer.about}
                  </p>
                )}
              </div>
            </div>

            {/* Desktop/Tablet: Horizontal Layout */}
            <div className="hidden sm:flex">
              <figure className="w-32 h-32 lg:w-36 lg:h-36 flex-shrink-0 overflow-hidden">
                <img
                  src={lecturer.image}
                  alt={lecturer.name}
                  className="w-full h-full object-cover"
                />
              </figure>
              <div className="card-body flex-1 p-4 space-y-2">
                <h3 className="card-title text-lg lg:text-xl text-base-content leading-tight">{lecturer.name}</h3>
                {lecturer.courses.length > 0 && (
                  <p className="text-xs lg:text-sm text-primary font-medium">
                    Mengajar: {lecturer.courses.map(course => course.name).join(", ")}
                  </p>
                )}
                {lecturer.about && (
                  <p className="text-xs lg:text-sm text-base-content/70 line-clamp-2 lg:line-clamp-3">
                    {lecturer.about}
                  </p>
                )}
              </div>
            </div>
          </div>
        ))}

        {/* Card "Lihat Semua" */}
        <div
          className="card bg-base-200 border-2 border-dashed border-primary/30 hover:shadow-xl cursor-pointer transition-all duration-300 transform hover:-translate-y-1 group"
          onClick={() => router.visit('/lecturers')}
        >
          {/* Mobile: Vertical Layout */}
          <div className="block sm:hidden h-full">
            <figure className="h-48 flex items-center justify-center bg-base-300">
              <div className="text-center">
                <div className="w-16 h-16 bg-primary rounded-full flex items-center justify-center mx-auto mb-3 group-hover:scale-110 transition-transform">
                  <svg className="w-8 h-8 text-primary-content" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path strokeLinecap="round" strokeLinejoin="round" strokeWidth={2} d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                  </svg>
                </div>
                <span className="text-primary font-semibold text-sm">Lihat Semua</span>
              </div>
            </figure>
            <div className="card-body p-4 text-center">
              <button className="btn btn-primary w-full">
                Lihat Semua Dosen
              </button>
            </div>
          </div>

          {/* Desktop/Tablet: Horizontal Layout */}
          <div className="hidden sm:flex h-full items-center">
            <figure className="w-32 h-32 lg:w-36 lg:h-36 flex-shrink-0 flex items-center justify-center bg-base-300">
              <div className="w-12 h-12 lg:w-16 lg:h-16 bg-primary rounded-full flex items-center justify-center group-hover:scale-110 transition-transform">
                <svg className="w-6 h-6 lg:w-8 lg:h-8 text-primary-content" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path strokeLinecap="round" strokeLinejoin="round" strokeWidth={2} d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                </svg>
              </div>
            </figure>
            <div className="card-body flex-1 p-4 flex flex-col justify-center">
              <h3 className="card-title text-lg lg:text-xl text-base-content mb-2">Lihat Semua Dosen</h3>
              <p className="text-xs lg:text-sm text-base-content/70 mb-3">Temukan seluruh tim pengajar kami</p>
              <button className="btn btn-primary self-start text-sm">
                Selengkapnya →
              </button>
            </div>
          </div>
        </div>
      </div>
    </section>
  );
};

export default LecturersSection;
