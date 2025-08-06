import React from 'react';
import { Layout } from '@/Layouts';
import {
  GeneralInformationSection,
  VirtualToursSection,
  LecturersSection,
  ConcentrationTabs,
  CoursesSection,
  ArticlesSection,
  AnnouncementSection
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
      <div className="container mx-auto px-4 sm:px-6 lg:px-8 space-y-8">
        <VirtualToursSection virtualTours={virtualTours} />

        <AnnouncementSection announcements={articles} />
        <div className="divider"></div>

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
