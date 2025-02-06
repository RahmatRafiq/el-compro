import React from 'react';

interface GeneralInformationSectionProps {
  categories: any[];
  data: any[];
}

const GeneralInformationSection: React.FC<GeneralInformationSectionProps> = ({ categories, data }) => {
  return (
    <section className="rounded-lg w-full py-8 bg-neutral text-neutral-content">
      <h2 className="text-2xl font-bold text-center mb-6">General Information</h2>
      <div className="w-full ">
        {categories.map((category) => {
          const categoryData = data.find(item => item.name === category.name);
          return (
            <div key={category.id} className="collapse collapse-arrow  w-full ">
              <input type="radio" name="category-accordion" />
              <div className="collapse-title text-xl font-medium">{category.name}</div>
              <div className="collapse-content overflow-hidden max-h-20">
                <p className="text-sm">
                  {categoryData ? categoryData.description : "No description available"}
                </p>
              </div>
            </div>
          );
        })}
      </div>
    </section>
  );
};

export default GeneralInformationSection;
