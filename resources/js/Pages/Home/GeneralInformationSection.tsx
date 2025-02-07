import React from "react";

interface GeneralInformation {
  id: number;
  name: string;
  description: string;
}

interface GeneralInformationSectionProps {
  generalInformationData: GeneralInformation[];
}

const GeneralInformationSection: React.FC<GeneralInformationSectionProps> = ({
  generalInformationData,
}) => {
  return (
    <section className="rounded-lg w-full py-8 bg-neutral text-neutral-content">
      <h2 className="text-2xl font-bold text-center mb-6">General Information</h2>
      <div className="w-full">
        {generalInformationData.map((item) => {
          if (item.name === "Informasi dan Alur Pendaftaran") {
            // Parsing khusus untuk daftar langkah (steps)
            const parser = new DOMParser();
            const parsedHtml = parser.parseFromString(item.description, "text/html");
            const listItems = Array.from(parsedHtml.querySelectorAll("li")).map(
              (listItem, index) => (
                <li key={index}>
                  {index !== 0 && <hr />} {/* Garis pemisah */}
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
              )
            );

            return (
              <div key={item.id} className="collapse collapse-arrow w-full">
                <input type="radio" name="general-information-accordion" />
                <div className="collapse-title text-xl font-medium">{item.name}</div>
                <div className="collapse-content overflow-hidden">
                  <ul className="timeline timeline-vertical text-gray-500">{listItems}</ul>
                </div>
              </div>
            );
          }

          return (
            <div key={item.id} className="collapse collapse-arrow w-full">
              <input type="radio" name="general-information-accordion" />
              <div className="collapse-title text-xl font-medium">{item.name}</div>
              <div
                className="collapse-content overflow-hidden text-sm"
                dangerouslySetInnerHTML={{ __html: item.description }}
              />
            </div>
          );
        })}
      </div>
    </section>
  );
};

export default GeneralInformationSection;
