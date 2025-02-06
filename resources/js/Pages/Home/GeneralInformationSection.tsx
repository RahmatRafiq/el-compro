import React from 'react';

interface GeneralInformationSectionProps {
  categories: any[];
  data: any[];
}

const GeneralInformationSection: React.FC<GeneralInformationSectionProps> = ({ categories, data }) => {
  return (
    <section className="w-full py-8">
      <h2 className="text-2xl font-bold text-center mb-6">General Information</h2>
      <div className="w-full grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        {categories.map((category) => {
          const categoryData = data.find(item => item.name === category.name);
          return (
            <div key={category.id} className="w-full p-6 border rounded-lg shadow-lg hover:shadow-xl transition">
              <h3 className="text-xl font-semibold mb-4">{category.name}</h3>
              <p className="text-sm text-gray-600">{categoryData ? categoryData.description : "No description available"}</p>
            </div>
          );
        })}
      </div>
    </section>
  );
};

export default GeneralInformationSection;
