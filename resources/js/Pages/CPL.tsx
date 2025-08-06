import React, { useState } from "react";
import Layout from "@/Layouts/Layout";

export interface GraduateLearningOutcome {
  id: number;
  concentration: string;
  name: string;
  description: string;
}

interface CPLProps {
  graduateLearningOutcomes: GraduateLearningOutcome[];
  aboutApp: any;
}

const CPL: React.FC<CPLProps> = ({ graduateLearningOutcomes, aboutApp }) => {
  if (!graduateLearningOutcomes || graduateLearningOutcomes.length === 0) return null;

  // Group CPL by concentration
  const grouped = graduateLearningOutcomes.reduce<Record<string, GraduateLearningOutcome[]>>((acc, outcome) => {
    if (!acc[outcome.concentration]) acc[outcome.concentration] = [];
    acc[outcome.concentration].push(outcome);
    return acc;
  }, {});

  const concentrations = Object.keys(grouped);
  const [activeTab, setActiveTab] = useState<string>(concentrations[0] || "");

  // Render table for CPL per concentration
  const renderCPLTable = (items: GraduateLearningOutcome[]) => (
    <div className="overflow-x-auto">
      <table className="table w-full">
        <thead>
          <tr className="border-base-300">
            <th className="text-base-content px-4 py-2 w-1/4">Nama CPL</th>
            <th className="text-base-content px-4 py-2">Deskripsi</th>
          </tr>
        </thead>
        <tbody>
          {items.map((outcome, idx) => (
            <tr key={outcome.id} className="hover:bg-base-200 border-base-300">
              <td className="align-top px-4 py-2 font-bold text-primary">{outcome.name}</td>
              <td className="align-top px-4 py-2">
                <div
                  className="text-base-content whitespace-pre-line"
                  dangerouslySetInnerHTML={{ __html: outcome.description }}
                ></div>
              </td>
            </tr>
          ))}
        </tbody>
      </table>
    </div>
  );

  return (
    <Layout aboutApp={aboutApp}>
      <div className="w-full">
        {/* Header Section */}
        <div className="container mx-auto px-4 sm:px-6 lg:px-8 py-8">
          <div className="text-center space-y-4">
            <h1 className="text-2xl sm:text-3xl lg:text-4xl font-bold text-base-content">
              Capaian Pembelajaran Lulusan
            </h1>
            <p className="text-base-content/70 text-sm sm:text-base max-w-2xl mx-auto">
              Daftar CPL Program Studi Teknik Elektro berdasarkan konsentrasi keahlian.
            </p>
          </div>
        </div>

        {/* Card Section */}
        <div className="container mx-auto px-4 sm:px-6 lg:px-8 pb-8">
          <div className="card bg-base-100 shadow-xl border border-base-300">
            <div className="card-header bg-base-200 px-6 py-4 border-b border-base-300">
              <h2 className="card-title text-xl text-base-content flex items-center">
                <svg className="w-5 h-5 mr-2 text-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path strokeLinecap="round" strokeLinejoin="round" strokeWidth={2} d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.746 0 3.332.477 4.5 1.253v13C20.832 18.477 19.246 18 17.5 18c-1.746 0-3.332.477-4.5 1.253" />
                </svg>
                CPL PER KONSENTRASI
              </h2>
            </div>
            <div className="card-body p-6">
              {/* Tabs Section */}
              <div className="flex justify-center mb-8">
                <div className="tabs tabs-boxed bg-base-200 p-2 rounded-xl max-w-3xl w-full">
                  {concentrations.map(conc => (
                    <button
                      key={conc}
                      className={`tab flex-1 text-sm sm:text-base font-semibold rounded-lg transition-all duration-200 min-h-[60px] sm:min-h-[70px] border border-base-300 ${
                        activeTab === conc
                          ? "tab-active bg-primary text-primary-content shadow-lg"
                          : "bg-base-100  text-primary-content hover:bg-base-300 " 
                      }`}
                      onClick={() => setActiveTab(conc)}
                    >
                      <span className="text-xs sm:text-sm font-medium leading-tight text-center">
                        {conc.replace(/_/g, " ").toUpperCase()}
                      </span>
                    </button>
                  ))}
                </div>
              </div>
              {/* Tab Content */}
              <div className="min-h-[300px]">
                {activeTab && renderCPLTable(grouped[activeTab])}
              </div>
            </div>
          </div>
        </div>
      </div>
    </Layout>
  );
};

export default CPL;
