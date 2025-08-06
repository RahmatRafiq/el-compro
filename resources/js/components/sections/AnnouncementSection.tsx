import { Link } from "@inertiajs/react";
import React from "react";
import { HiSpeakerphone, HiExclamation } from "react-icons/hi";
import type { Article } from '@/types';

interface AnnouncementSectionProps {
  announcements?: Article[];
}

const AnnouncementSection: React.FC<AnnouncementSectionProps> = ({ announcements = [] }) => {
  // Filter announcements yang memiliki kategori "pengumuman"
  const filteredAnnouncements = announcements.filter(
    article => article.category?.name?.toLowerCase() === 'pengumuman'
  ).slice(0, 3); // Ambil maksimal 3 pengumuman terbaru

  if (filteredAnnouncements.length === 0) {
    return (
      <div className="w-full py-8">
        <div className="text-center">
          <div className="max-w-md mx-auto bg-base-100 border border-base-300 rounded-lg p-8 shadow-sm">
            <div className="text-center">
              <HiExclamation className="w-16 h-16 mx-auto text-base-content/30 mb-4" />
              <h3 className="text-lg font-semibold text-base-content mb-2">
                Belum Ada Pengumuman
              </h3>
              <p className="text-base-content/60 text-sm">
                Saat ini belum ada pengumuman yang tersedia. Silakan cek kembali nanti.
              </p>
            </div>
          </div>
        </div>
      </div>
    );
  }

  return (
    <div className="w-full py-8">
      <div className="text-center mb-8">
        <h2 className="text-2xl sm:text-3xl font-bold text-base-content mb-4 flex items-center justify-center gap-2">
          <HiSpeakerphone className="text-primary" />
          Pengumuman Terbaru
        </h2>
        <p className="text-base-content/70 max-w-2xl mx-auto">
          Informasi terbaru dan pengumuman penting dari Program Studi Teknik Elektro
        </p>
      </div>

      <div className="grid gap-6 sm:grid-cols-2 lg:grid-cols-3">
        {filteredAnnouncements.map((announcement) => (
          <div key={announcement.id} className="card bg-base-100 shadow-lg hover:shadow-xl transition-shadow duration-300 border border-base-300">
            <figure className="aspect-[4/3] overflow-hidden bg-base-200">
              {announcement.image ? (
                <img
                  src={announcement.image}
                  alt={announcement.title}
                  className="object-cover w-full h-full hover:scale-105 transition-transform duration-300"
                  onError={(e) => {
                    e.currentTarget.style.display = "none";
                    e.currentTarget.nextElementSibling?.classList.remove('hidden');
                  }}
                />
              ) : null}
              <div className={`w-full h-full bg-gradient-to-br from-primary/20 to-secondary/20 flex items-center justify-center ${announcement.image ? 'hidden' : ''}`}>
                <div className="text-center p-4">
                  <HiSpeakerphone className="w-12 h-12 mx-auto mb-2 text-primary" />
                  <span className="text-sm text-base-content/70 font-medium">Pengumuman</span>
                </div>
              </div>
            </figure>

            <div className="card-body p-4">
              <div className="flex items-center gap-2 mb-2">
                <div className="badge badge-primary badge-sm flex items-center gap-1">
                  <HiSpeakerphone className="w-3 h-3" />
                  Pengumuman
                </div>
                <div className="text-xs text-base-content/60">
                  {announcement.view_count} kali dilihat
                </div>
              </div>
              
              <h3 className="card-title text-base font-semibold line-clamp-2 leading-tight">
                {announcement.title}
              </h3>
              
              {announcement.created_at && (
                <div className="text-xs text-base-content/50 mt-2">
                  {new Date(announcement.created_at).toLocaleDateString('id-ID', {
                    year: 'numeric',
                    month: 'long',
                    day: 'numeric'
                  })}
                </div>
              )}
              
              <div className="card-actions justify-end mt-4">
                <Link 
                  href={`/articles/${announcement.slug}`} 
                  className="btn btn-primary btn-sm"
                >
                  Baca Selengkapnya
                </Link>
              </div>
            </div>
          </div>
        ))}
      </div>

      {/* Link untuk lihat semua pengumuman */}
      <div className="text-center mt-8">
        <Link 
          href="/articles" 
          className="btn btn-outline btn-primary"
        >
          Lihat Semua Pengumuman
        </Link>
      </div>
    </div>
  );
};

export default AnnouncementSection;
