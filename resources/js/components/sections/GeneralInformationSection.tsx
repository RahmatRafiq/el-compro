import React from "react";
import { FaInfoCircle } from "react-icons/fa";
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
  const otherInfo = generalInformationData.filter(item => item.name !== "Informasi dan Alur Pendaftaran");

  return (
    <div className="w-full py-8">
      {flowInfo && (
        <section className="rounded-lg w-full py-8 card bg-base-200 shadow-lg">
          <h2 className="text-3xl font-bold text-center mb-6">{flowInfo.name}</h2>
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
        </section>
      )}


      <section className="rounded-lg w-full py-8 card bg-base-200 shadow-lg">
        <h2 className="text-3xl font-bold text-center mb-6">Informasi Umum</h2>
        <div className="w-full">
          {otherInfo.map((item) => (
            <div key={item.id} className="collapse collapse-arrow w-full">
              <input type="radio" name="general-information-accordion" />
              <div className="collapse-title text-xl font-medium flex items-center">
                <FaInfoCircle className="text-blue-500 mr-2" />
                {item.name}
              </div>
              <div className="collapse-content space-y-4 p-4 bg-secondary rounded-lg">
                {(() => {
                  const parser = new DOMParser();
                  const parsedHtml = parser.parseFromString(item.description, "text/html");
                  const paragraphs = Array.from(parsedHtml.querySelectorAll("p"));

                  return paragraphs.map((p, index) => (
                    <div key={index} className="card shadow-md p-4 rounded-lg">
                      <p className="text-white">{p.textContent}</p>
                    </div>
                  ));
                })()}
              </div>
            </div>
          ))}
        </div>
      </section>

    </div>
  );
};

export default GeneralInformationSection;
