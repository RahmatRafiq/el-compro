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
                <li key={index} className="step">
                  {listItem.textContent}
                </li>
              )
            );

            return (
              <div key={item.id} className="collapse collapse-arrow w-full">
                <input type="radio" name="general-information-accordion" />
                <div className="collapse-title text-xl font-medium">{item.name}</div>
                <div className="collapse-content overflow-hidden">
                  <ul className="steps steps-vertical">{listItems}</ul>
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
