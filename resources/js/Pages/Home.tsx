import React from 'react';
import Layout from '../Layouts/Layout';
import GeneralInformationSection from './Home/GeneralInformationSection';
import VirtualToursSection from './Home/VirtualToursSection';
import RegistrationFlowSection from './Home/RegistrationFlowSection';
import LecturersSection from './Home/LecturersSection';
import ConcentrationTabs from './Home/ConcentrationTabs';
import CoursesSection from './Home/CourseSection';

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
  courses: Course[]; // Tambahkan courses ke props
}

const Home: React.FC<HomeProps> = ({
  generalInformationData,
  virtualTours,
  lecturers,
  concentrationData,
  courses
}) => {
  const registrationFlowData = generalInformationData.find(item => item.name === "Informasi dan Alur Pendaftaran");

  return (
    <Layout>
      <div className="space-y-8 px-6">
        <VirtualToursSection virtualTours={virtualTours} />
        <GeneralInformationSection generalInformationData={generalInformationData} />
        <LecturersSection lecturers={lecturers} />
        <ConcentrationTabs concentrationData={concentrationData} />
        <CoursesSection courses={courses} /> {/* Tambahkan komponen CoursesSection */}
      </div>
    </Layout>
  );
};

export default Home;
