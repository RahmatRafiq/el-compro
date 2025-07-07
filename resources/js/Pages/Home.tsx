import React from 'react';
import { Layout } from '@/Layouts';
import {
  GeneralInformationSection,
  VirtualToursSection,
  LecturersSection,
  ConcentrationTabs,
  CoursesSection,
  ArticlesSection
} from '@/components/sections';
import type { 
  Course as CourseType, 
  VirtualTour, 
  Lecturer, 
  AboutApp, 
  GeneralInformation, 
  Article 
} from '@/types';

interface HomeProps {
  generalInformationData: GeneralInformation[];
  virtualTours: VirtualTour[];
  lecturers: Lecturer[];
  concentrationData: any[];
  courses: CourseType[]; 
  aboutApp: AboutApp;
  articles: Article[];
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

        <GeneralInformationSection generalInformationData={generalInformationData} />
        <div className="divider"></div>

        <ArticlesSection articles={articles} />

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
