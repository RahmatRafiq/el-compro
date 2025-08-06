import React from "react";
import { FaMedal, FaTrophy, FaCertificate, FaStar, FaUserGraduate, FaArrowRight } from "react-icons/fa";
import type { GeneralInformation } from '@/types';

interface GeneralInformationSectionProps {
  generalInformationData: GeneralInformation[];
}

const getYoutubeEmbedUrl = (url: string): string => {
  try {
    const ytRegex =
      /(?:https?:\/\/)?(?:www\.)?(?:youtube\.com\/(?:watch\?v=|embed\/)|youtu\.be\/)([\w-]{11})/;
    const match = url.match(ytRegex);
    return match ? `https://www.youtube.com/embed/${match[1]}` : "";
  } catch {
    return "";
  }
};

const GeneralInformationSection: React.FC<GeneralInformationSectionProps> = ({ generalInformationData }) => {
  const flowInfo = generalInformationData.find(item => item.name === "Informasi dan Alur Pendaftaran");
  const achievementInfo = generalInformationData.find(item => 
    item.name.toLowerCase().includes("capaian prestasi")
  );

  const renderAchievementCard = (text: string, index: number) => {
    const isAccreditation = text.toLowerCase().includes('akreditasi');
    const gradeMatch = text.match(/akreditasi\s+([A-Za-z])/i);
    const grade = gradeMatch ? gradeMatch[1].toUpperCase() : null;
    
    if (isAccreditation && grade) {
      return (
        <div key={index} className="card bg-gradient-to-br from-yellow-100 to-orange-100 dark:from-yellow-900/30 dark:to-orange-900/30 shadow-xl p-6 border-2 border-yellow-300 dark:border-yellow-600">
          <div className="flex items-center justify-center space-x-4">
            <div className="relative">
              <FaCertificate className="text-6xl text-yellow-600 dark:text-yellow-400" />
              <div className="absolute inset-0 flex items-center justify-center">
                <span className="text-xl font-bold text-yellow-800 dark:text-yellow-200">{grade}</span>
              </div>
            </div>
            <div className="text-center">
              <h3 className="text-2xl font-bold text-yellow-800 dark:text-yellow-200 mb-2">
                🏆 AKREDITASI {grade}
              </h3>
              <p className="text-yellow-700 dark:text-yellow-300 font-medium">
                {text}
              </p>
              <div className="flex justify-center space-x-1 mt-2">
                {[1,2,3,4,5].map(star => (
                  <FaStar key={star} className="text-yellow-500" />
                ))}
              </div>
            </div>
          </div>
        </div>
      );
    }
    
    return (
      <div key={index} className="card bg-gradient-to-br from-blue-100 to-purple-100 dark:from-blue-900/30 dark:to-purple-900/30 shadow-lg p-4 border border-blue-200 dark:border-blue-600">
        <div className="flex items-center space-x-3">
          <FaTrophy className="text-3xl text-blue-600 dark:text-blue-400" />
          <div>
            <p className="text-blue-800 dark:text-blue-200 font-medium">{text}</p>
          </div>
        </div>
      </div>
    );
  };

  return (
    <div className="w-full py-8">
      {flowInfo && (
        <section className="rounded-lg w-full py-8 card bg-base-200 shadow-lg mb-8">
          <h2 className="text-3xl font-bold text-center mb-6 text-base-content">{flowInfo.name}</h2>
          <div className="w-full px-4 md:px-8 flex justify-center">
            <div className="w-full max-w-3xl aspect-video rounded-xl overflow-hidden shadow">
              <iframe
                className="w-full h-full"
                src={getYoutubeEmbedUrl(flowInfo.description)}
                title="Flow Video"
                frameBorder="0"
                allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture"
                allowFullScreen
              ></iframe>
            </div>
          </div>
          
          {/* Tombol Pendaftaran */}
          <div className="flex justify-center mt-8">
            <a
              href="https://simba.unifa.ac.id/"
              target="_blank"
              rel="noopener noreferrer"
              className="btn btn-primary btn-lg gap-3 group hover:scale-105 transition-all duration-300 shadow-lg hover:shadow-xl"
            >
              <FaUserGraduate className="text-xl group-hover:animate-bounce" />
              <span className="font-bold">Ingin Mendaftar?</span>
              <FaArrowRight className="text-lg group-hover:translate-x-1 transition-transform duration-300" />
            </a>
          </div>
        </section>
      )}

      {achievementInfo && (
        <section className="rounded-lg w-full py-8 card bg-base-200 shadow-lg mb-8">
          <div className="text-center mb-6">
            <h2 className="text-3xl font-bold text-base-content mb-4 flex items-center justify-center gap-2">
              <FaMedal className="text-yellow-500" />
              {achievementInfo.name}
            </h2>
            <p className="text-base-content/70">Prestasi dan pencapaian Program Studi Teknik Elektro</p>
          </div>
          
          <div className="space-y-6 px-4">
            {(() => {
              const parser = new DOMParser();
              const parsedHtml = parser.parseFromString(achievementInfo.description, "text/html");
              const paragraphs = Array.from(parsedHtml.querySelectorAll("p"));
              
              return paragraphs.map((p, index) => renderAchievementCard(p.textContent || "", index));
            })()}
          </div>
        </section>
      )}

    </div>
  );
};

export default GeneralInformationSection;
