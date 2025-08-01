import React from "react";
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

  const grouped = graduateLearningOutcomes.reduce<Record<string, GraduateLearningOutcome[]>>((acc, outcome) => {
    if (!acc[outcome.concentration]) acc[outcome.concentration] = [];
    acc[outcome.concentration].push(outcome);
    return acc;
  }, {});

  return (
    <Layout aboutApp={aboutApp}>
      <div className="container mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <section className="bg-base-200 rounded-xl shadow-md p-8 mb-8">
          <h2 className="text-3xl font-bold text-primary mb-6 text-center">Capaian Pembelajaran Lulusan</h2>
          {Object.entries(grouped).map(([concentration, items]) => (
            <div key={concentration} className="mb-8">
              <h3 className="text-2xl font-semibold text-secondary mb-4">{concentration}</h3>
              <div className="overflow-x-auto">
                <table className="table w-full bg-base-100 rounded-lg shadow border border-base-300">
                  <thead>
                    <tr>
                      <th className="text-left px-4 py-2 w-1/4">Nama CPL</th>
                      <th className="text-left px-4 py-2">Deskripsi</th>
                    </tr>
                  </thead>
                  <tbody>
                    {items.map(outcome => (
                      <tr key={outcome.id}>
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
            </div>
          ))}
        </section>
      </div>
    </Layout>
  );
};

export default CPL;
