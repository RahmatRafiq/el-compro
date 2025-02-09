import React from 'react';
import Layout from '../Layouts/Layout';
import GeneralInformationSection from './Home/GeneralInformationSection';
import VirtualToursSection from './Home/VirtualToursSection';
import RegistrationFlowSection from './Home/RegistrationFlowSection';
import LecturersSection from './Home/LecturersSection';
import ConcentrationTabs from './Home/ConcentrationTabs';
import CoursesSection from './Home/CourseSection';
import ArticlesSection from './Home/ArticleSections';

interface Course {
  id: number;
  course_code: string;
  name: string;
  credits: number;
}

interface HomeProps {
  generalInformationData: any[];
  virtualTours: any[];
  lecturers: any[];
  concentrationData: any[];
  courses: Course[]; 
  aboutApp: {
    title: string;
    contact_email: string;
    contact_phone: string;
    contact_address: string;
  };
  articles: any[];
}

const Home: React.FC<HomeProps> = ({
  generalInformationData,
  virtualTours,
  lecturers,
  concentrationData,
  courses,
  aboutApp,
  articles,
}) => {
  const registrationFlowData = generalInformationData.find(item => item.name === "Informasi dan Alur Pendaftaran");
  return (
    <Layout aboutApp={aboutApp}> 
      <div className="space-y-8 px-6">
        <VirtualToursSection virtualTours={virtualTours} />
        <div className="divider"></div>

        <GeneralInformationSection generalInformationData={generalInformationData} />
        <div className="divider"></div>

        <ArticlesSection articles={articles} />
        {/* <div className="divider"></div> */}

        <LecturersSection lecturers={lecturers} />
        <div className="divider"></div>

        <ConcentrationTabs concentrationData={concentrationData} />
        <div className="divider"></div>

        <CoursesSection courses={courses} />
      </div>
    </Layout>
  );
};

export default Home;
