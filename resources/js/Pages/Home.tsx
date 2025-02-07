import React from 'react';
import Layout from '../Layouts/Layout';
import GeneralInformationSection from './Home/GeneralInformationSection';
import VirtualToursSection from './Home/VirtualToursSection';
import RegistrationFlowSection from './Home/RegistrationFlowSection';
import LecturersSection from './Home/LecturersSection';

interface HomeProps {
  generalInformationCategories: any[];
  generalInformationData: any[];
  virtualTours: any[];
  lecturers: any[];
}

const Home: React.FC<HomeProps> = ({ 
  generalInformationCategories, 
  generalInformationData, 
  virtualTours,
  lecturers
}) => {
  const registrationFlowData = generalInformationData.find(item => item.name === "Informasi dan Alur Pendaftaran");

  return (
    <Layout>
      <div className="space-y-8 px-6">
        <VirtualToursSection virtualTours={virtualTours} />
        {/* <GeneralInformationSection categories={generalInformationCategories} data={generalInformationData} /> */}
        {registrationFlowData && <RegistrationFlowSection registrationFlowData={registrationFlowData} />}
        <LecturersSection lecturers={lecturers} />
      </div>
    </Layout>
  );
};

export default Home;
