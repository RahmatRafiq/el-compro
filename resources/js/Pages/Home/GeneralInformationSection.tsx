import React from "react";
import { FaInfoCircle } from "react-icons/fa";

interface GeneralInformation {
  id: number;
  name: string;
  description: string;
}

interface GeneralInformationSectionProps {
  generalInformationData: GeneralInformation[];
}

const GeneralInformationSection: React.FC<GeneralInformationSectionProps> = ({ generalInformationData }) => {
  const flowInfo = generalInformationData.find(item => item.name === "Informasi dan Alur Pendaftaran");
  const otherInfo = generalInformationData.filter(item => item.name !== "Informasi dan Alur Pendaftaran");

  return (
    <div className="w-full space-y-6">
      {flowInfo && (
        <section className="rounded-lg w-full py-8 card bg-base-200 shadow-lg">
          <h2 className="text-3xl font-bold text-center  mb-6">{flowInfo.name}</h2>
          <div className="w-full px-6">
            <ul className="timeline timeline-vertical">
              {(() => {
                const parser = new DOMParser();
                const parsedHtml = parser.parseFromString(flowInfo.description, "text/html");
                return Array.from(parsedHtml.querySelectorAll("li")).map((listItem, index) => (
                  <li key={index} className="relative pb-4">
                    {index !== 0 && <hr />}
                    <div className={`timeline-${index % 2 === 0 ? "start" : "end"} timeline-box`}>
                      {listItem.textContent}
                    </div>
                    <div className="timeline-middle">
                      <svg
                        xmlns="http://www.w3.org/2000/svg"
                        viewBox="0 0 20 20"
                        fill="currentColor"
                        className="h-5 w-5"
                      >
                        <path
                          fillRule="evenodd"
                          d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.857-9.809a.75.75 0 00-1.214-.882l-3.483 4.79-1.88-1.88a.75.75 0 10-1.06 1.061l2.5 2.5a.75.75 0 001.137-.089l4-5.5z"
                          clipRule="evenodd"
                        />
                      </svg>
                    </div>
                  </li>
                ));
              })()}
            </ul>
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
