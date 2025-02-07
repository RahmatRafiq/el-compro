import React, { useState } from "react";

interface Concentration {
  id: number;
  name: string;
  description: string;
}

interface Props {
  concentrationData: Concentration[];
}

const ConcentrationTabs: React.FC<Props> = ({ concentrationData }) => {
  const [activeTab, setActiveTab] = useState(0);

  if (concentrationData.length === 0) {
    return <p className="text-center text-gray-500">Loading data...</p>;
  }

  return (
    <section className="rounded-lg w-full py-8">
      <h2 className="text-3xl font-bold text-center  mb-6">Konsentrasi</h2>

      <div role="tablist" className="tabs tabs-lifted flex justify-center">
        {concentrationData.map((concentration, index) => (
          <button
            key={concentration.id}
            role="tab"
            className={`tab px-6 py-3 text-lg font-semibold ${activeTab === index ? "tab-active text-primary border-b-2 border-primary" : ""
              }`}
            onClick={() => setActiveTab(index)}
          >
            {concentration.name}
          </button>
        ))}
      </div>

      <div className="p-6 bg-base-100 shadow-lg rounded-lg mt-6 border border-gray-200">
        <h3 className="text-xl font-semibold text-primary mb-3">
          {concentrationData[activeTab]?.name}
        </h3>
        <p
          className="text-gray-500 leading-relaxed"
          dangerouslySetInnerHTML={{ __html: concentrationData[activeTab]?.description || "" }}
        ></p>
      </div>
    </section>
  );
};

export default ConcentrationTabs;
