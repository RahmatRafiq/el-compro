import React from 'react';
import Layout from '../Layouts/Layout';
import GeneralInformationSection from './Home/GeneralInformationSection';
import VirtualToursSection from './Home/VirtualToursSection';

interface HomeProps {
  generalInformationCategories: any[];
  generalInformationData: any[];
  virtualTours: any[];
}

const Home: React.FC<HomeProps> = ({ 
  generalInformationCategories, 
  generalInformationData, 
  virtualTours 
}) => {
  return (
    <Layout>
      <div className="space-y-8 px-6">
        <VirtualToursSection 
          virtualTours={virtualTours} 
        />
        <GeneralInformationSection 
          categories={generalInformationCategories} 
          data={generalInformationData} 
        />
      </div>
    </Layout>
  );
};

export default Home;
