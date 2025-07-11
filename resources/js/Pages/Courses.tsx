import { Layout } from "@/Layouts";
import { Link } from "@inertiajs/react";
import React, { useState, useEffect } from "react";
import type { Course as CourseType, AboutApp } from '@/types';

interface CoursesProps {
  courses: CourseType[];
  aboutApp: AboutApp;
}

const Courses: React.FC<CoursesProps> = ({ courses, aboutApp }) => {
  const [activeTab, setActiveTab] = useState<string>("teknik_tenaga_listrik");

  const [baseCoursesToShow, setBaseCoursesToShow] = useState(10); // 10 mata kuliah pertama
  const [tenagaListrikCoursesToShow, setTenagaListrikCoursesToShow] = useState(10);
  const [telekomunikasiCoursesToShow, setTelekomunikasiCoursesToShow] = useState(10);

  useEffect(() => {
    console.log("Courses received:", courses);
  }, [courses]);

  const baseCourses = courses.filter(
    (course) => course.major_concentration === "mata_kuliah_dasar"
  );
  const tenagaListrikCourses = courses.filter(
    (course) =>
      course.major_concentration === "teknik_tenaga_listrik" ||
      course.major_concentration === "semua_konsentrasi"
  );

  const telekomunikasiCourses = courses.filter(
    (course) =>
      course.major_concentration === "teknik_telekomunikasi" ||
      course.major_concentration === "semua_konsentrasi"
  );

  // Fungsi render tabel kursus, menambahkan badge "Umum" untuk kursus universal
  const renderCoursesTable = (
    courseList: CourseType[],
    coursesToShow: number,
    setCoursesToShow: React.Dispatch<React.SetStateAction<number>>
  ) => (
    <div className="w-full">
      {/* Mobile: Card Layout */}
      <div className="block lg:hidden space-y-4">
        {courseList.slice(0, coursesToShow).map((course, index) => (
          <div key={course.id} className="card bg-base-100 shadow-lg border border-base-300">
            <div className="card-body p-4">
              <div className="flex justify-between items-start mb-2">
                <h3 className="card-title text-base text-base-content">{course.name}</h3>
                {course.major_concentration === "semua_konsentrasi" && (
                  <span className="badge badge-primary badge-sm">Umum</span>
                )}
              </div>
              <div className="space-y-2 text-sm">
                <div className="flex justify-between">
                  <span className="text-base-content/70">Kode:</span>
                  <span className="font-medium text-base-content">{course.course_code}</span>
                </div>
                <div className="flex justify-between">
                  <span className="text-base-content/70">SKS:</span>
                  <span className="font-medium text-base-content">{course.credits}</span>
                </div>
                {course.semester && (
                  <div className="flex justify-between">
                    <span className="text-base-content/70">Semester:</span>
                    <span className="font-medium text-base-content">{course.semester}</span>
                  </div>
                )}
                {course.lecturers && course.lecturers.length > 0 && (
                  <div className="pt-2 border-t border-base-300">
                    <span className="text-base-content/70 text-xs">Dosen:</span>
                    <p className="text-base-content text-sm mt-1">
                      {course.lecturers.map((lecturer: any) => lecturer.name).join(", ")}
                    </p>
                  </div>
                )}
              </div>
            </div>
          </div>
        ))}
      </div>

      {/* Desktop: Table Layout */}
      <div className="hidden lg:block overflow-x-auto">
        <table className="table w-full">
          <thead>
            <tr className="border-base-300">
              <th className="text-base-content">#</th>
              <th className="text-base-content">Kode Mata Kuliah</th>
              <th className="text-base-content">Nama Mata Kuliah</th>
              <th className="text-base-content">SKS</th>
              {courseList.some(c => c.semester) && <th className="text-base-content">Semester</th>}
              <th className="text-base-content">Dosen Pengajar</th>
            </tr>
          </thead>
          <tbody>
            {courseList.slice(0, coursesToShow).map((course, index) => (
              <tr key={course.id} className="hover:bg-base-200 border-base-300">
                <td className="text-base-content">{index + 1}</td>
                <td className="text-base-content font-medium">{course.course_code}</td>
                <td className="text-base-content">
                  <div className="flex items-center gap-2">
                    <span>{course.name}</span>
                    {course.major_concentration === "semua_konsentrasi" && (
                      <span className="badge badge-primary badge-sm">Umum</span>
                    )}
                  </div>
                </td>
                <td className="text-base-content">{course.credits}</td>
                {courseList.some(c => c.semester) && (
                  <td className="text-base-content">{course.semester || "-"}</td>
                )}
                <td className="text-base-content">
                  {course.lecturers && course.lecturers.length > 0
                    ? course.lecturers.map((lecturer: any) => lecturer.name).join(", ")
                    : "Belum ada dosen"}
                </td>
              </tr>
            ))}
          </tbody>
        </table>
      </div>

      {courseList.length > coursesToShow && (
        <div className="text-center mt-6">
          <button
            className="btn btn-primary"
            onClick={() => setCoursesToShow(coursesToShow + 5)}
          >
            Lihat Lebih Banyak ({courseList.length - coursesToShow} tersisa)
          </button>
        </div>
      )}
    </div>
  );

  return (
    <Layout aboutApp={aboutApp}>
      <div className="w-full">
        {/* Header Section */}
        <div className="container mx-auto px-4 sm:px-6 lg:px-8 py-8">
          <div className="text-center space-y-4">
            <h1 className="text-2xl sm:text-3xl lg:text-4xl font-bold text-base-content">
              Daftar Mata Kuliah
            </h1>
            <p className="text-base-content/70 text-sm sm:text-base max-w-2xl mx-auto">
              Kurikulum lengkap Program Studi Teknik Elektro dengan berbagai konsentrasi keahlian.
            </p>
          </div>
        </div>

        {/* Mata Kuliah Dasar Section */}
        <div className="container mx-auto px-4 sm:px-6 lg:px-8 pb-8">
          <div className="card bg-base-100 shadow-xl border border-base-300 mb-8">
            <div className="card-header bg-base-200 px-6 py-4 border-b border-base-300">
              <h2 className="card-title text-xl text-base-content flex items-center">
                <svg className="w-5 h-5 mr-2 text-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path strokeLinecap="round" strokeLinejoin="round" strokeWidth={2} d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.746 0 3.332.477 4.5 1.253v13C20.832 18.477 19.246 18 17.5 18c-1.746 0-3.332.477-4.5 1.253" />
                </svg>
                MATA KULIAH DASAR
              </h2>
            </div>
            <div className="card-body p-6">
              {renderCoursesTable(baseCourses, baseCoursesToShow, setBaseCoursesToShow)}
            </div>
          </div>

          {/* Tabs Section */}
          <div className="card bg-base-100 shadow-xl border border-base-300">
            <div className="card-header bg-base-200 px-6 py-4 border-b border-base-300">
              <h2 className="card-title text-xl text-base-content flex items-center">
                <svg className="w-5 h-5 mr-2 text-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path strokeLinecap="round" strokeLinejoin="round" strokeWidth={2} d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10" />
                </svg>
                MATA KULIAH KONSENTRASI
              </h2>
            </div>
            
            {/* Responsive Tabs - Centered */}
            <div className="p-6">
              <div className="flex justify-center mb-8">
                <div className="tabs tabs-boxed bg-base-200 p-2 rounded-xl max-w-3xl w-full">
                  <button
                    className={`tab flex-1 text-sm sm:text-base font-semibold rounded-lg transition-all duration-200 min-h-[80px] sm:min-h-[90px] ${
                      activeTab === "teknik_tenaga_listrik" 
                        ? "tab-active bg-primary text-primary-content shadow-lg" 
                        : "hover:bg-base-300 text-base-content"
                    }`}
                    onClick={() => setActiveTab("teknik_tenaga_listrik")}
                  >
                    <div className="flex flex-col items-center justify-center py-3 px-2">
                      <svg className="w-6 h-6 sm:w-7 sm:h-7 mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path strokeLinecap="round" strokeLinejoin="round" strokeWidth={2} d="M13 10V3L4 14h7v7l9-11h-7z" />
                      </svg>
                      <span className="text-xs sm:text-sm font-medium leading-tight text-center">
                        <span className="hidden sm:block">TEKNIK TENAGA</span>
                        <span className="hidden sm:block">LISTRIK</span>
                        <span className="sm:hidden">TENAGA LISTRIK</span>
                      </span>
                    </div>
                  </button>
                  <button
                    className={`tab flex-1 text-sm sm:text-base font-semibold rounded-lg transition-all duration-200 min-h-[80px] sm:min-h-[90px] ${
                      activeTab === "teknik_telekomunikasi" 
                        ? "tab-active bg-primary text-primary-content shadow-lg" 
                        : "hover:bg-base-300 text-base-content"
                    }`}
                    onClick={() => setActiveTab("teknik_telekomunikasi")}
                  >
                    <div className="flex flex-col items-center justify-center py-3 px-2">
                      <svg className="w-6 h-6 sm:w-7 sm:h-7 mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path strokeLinecap="round" strokeLinejoin="round" strokeWidth={2} d="M8.111 16.404a5.5 5.5 0 017.778 0M12 20h.01m-7.08-7.071c3.904-3.905 10.236-3.905 14.141 0M1.394 9.393c5.857-5.857 15.355-5.857 21.213 0" />
                      </svg>
                      <span className="text-xs sm:text-sm font-medium leading-tight text-center">
                        <span className="hidden sm:block">TEKNIK</span>
                        <span className="hidden sm:block">TELEKOMUNIKASI</span>
                        <span className="sm:hidden">TELEKOMUNIKASI</span>
                      </span>
                    </div>
                  </button>
                </div>
              </div>

              {/* Tab Content */}
              <div className="min-h-[300px]">
                {activeTab === "teknik_tenaga_listrik"
                  ? renderCoursesTable(tenagaListrikCourses, tenagaListrikCoursesToShow, setTenagaListrikCoursesToShow)
                  : renderCoursesTable(telekomunikasiCourses, telekomunikasiCoursesToShow, setTelekomunikasiCoursesToShow)}
              </div>
            </div>
          </div>
        </div>

        {/* Call to Action */}
        <div className="container mx-auto px-4 sm:px-6 lg:px-8 py-8">
          <div className="text-center">
            <div className="alert alert-info max-w-2xl mx-auto">
              <svg className="w-6 h-6 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path strokeLinecap="round" strokeLinejoin="round" strokeWidth={2} d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
              </svg>
              <div>
                <h3 className="font-semibold">Ingin Tahu Lebih Lanjut?</h3>
                <p className="text-sm mt-1">Hubungi kami untuk informasi detail tentang kurikulum dan mata kuliah.</p>
              </div>
            </div>
          </div>
        </div>
      </div>
    </Layout>
  );
};

export default Courses;
