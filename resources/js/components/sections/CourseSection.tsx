import { Link } from "@inertiajs/react";
import React, { useState, useEffect } from "react";
import type { Course } from '@/types';

interface CoursesSectionProps {
  courses?: Course[];
}

const CoursesSection: React.FC<CoursesSectionProps> = ({ courses = [] }) => {
  const [activeTab, setActiveTab] = useState<string>("teknik_tenaga_listrik");
  const [filteredCourses, setFilteredCourses] = useState<Course[]>([]);

  useEffect(() => {
    const universalCourses = courses
      .filter(course => course.major_concentration === "semua_konsentrasi")
      .slice(0, 5);

    const specializedCourses = courses
      .filter(course => course.major_concentration === activeTab)
      .slice(0, 10);

    setFilteredCourses([...universalCourses, ...specializedCourses]);
  }, [activeTab, courses]);

  return (
    <div className="w-full py-8">
      <h2 className="text-3xl font-bold text-center mb-6">Mata Kuliah</h2>

      {/* Mobile-first responsive tabs - horizontal di mobile */}
      <div role="tablist" className="tabs tabs-lifted flex flex-row justify-center mb-6 w-full">
        <button
          role="tab"
          className={`tab px-2 sm:px-6 py-3 sm:py-5 text-xs sm:text-lg font-semibold min-h-[50px] sm:min-h-[60px] flex items-center justify-center gap-1 sm:gap-2 flex-1 ${
            activeTab === "teknik_tenaga_listrik" ? "tab-active text-primary border-b-2 border-primary" : ""
          }`}
          onClick={() => setActiveTab("teknik_tenaga_listrik")}
        >
          <svg className="w-4 h-4 sm:w-5 sm:h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path strokeLinecap="round" strokeLinejoin="round" strokeWidth={2} d="M13 10V3L4 14h7v7l9-11h-7z" />
          </svg>
          <span className="text-center leading-tight whitespace-nowrap">
            <span className="hidden sm:inline">TEKNIK TENAGA LISTRIK</span>
            <span className="sm:hidden text-xs font-medium">TEKNIK<br/>TENAGA LISTRIK</span>
          </span>
        </button>
        <button
          role="tab"
          className={`tab px-2 sm:px-6 py-3 sm:py-5 text-xs sm:text-lg font-semibold min-h-[50px] sm:min-h-[60px] flex items-center justify-center gap-1 sm:gap-2 flex-1 ${
            activeTab === "teknik_telekomunikasi" ? "tab-active text-primary border-b-2 border-primary" : ""
          }`}
          onClick={() => setActiveTab("teknik_telekomunikasi")}
        >
          <svg className="w-4 h-4 sm:w-5 sm:h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path strokeLinecap="round" strokeLinejoin="round" strokeWidth={2} d="M8.111 16.404a5.5 5.5 0 017.778 0M12 20h.01m-7.08-7.071c3.904-3.905 10.236-3.905 14.141 0M1.394 9.393c5.857-5.857 15.355-5.857 21.213 0" />
          </svg>
          <span className="text-center leading-tight whitespace-nowrap">
            <span className="hidden sm:inline">TEKNIK TELEKOMUNIKASI</span>
            <span className="sm:hidden text-xs font-medium">TEKNIK<br/>TELEKOMUNIKASI</span>
          </span>
        </button>
      </div>

      <div className="overflow-x-auto">
        <table className="table table-zebra w-full">
          <thead>
            <tr>
              <th>#</th>
              <th>Kode</th>
              <th>Nama Mata Kuliah</th>
              <th>SKS</th>
            </tr>
          </thead>
          <tbody>
            {filteredCourses.length > 0 ? (
              filteredCourses.map((course, index) => (
                <tr key={course.id}>
                  <td>{index + 1}</td>
                  <td>{course.course_code}</td>
                  <td>
                    {course.name}
                    {course.major_concentration === "semua_konsentrasi" && (
                      <span className="ml-2 text-xs text-white bg-blue-500 px-2 py-1 rounded-full">
                        Umum
                      </span>
                    )}
                  </td>
                  <td>{course.credits}</td>
                </tr>
              ))
            ) : (
              <tr>
                <td colSpan={4} className="text-center text-gray-500">
                  Tidak ada mata kuliah tersedia
                </td>
              </tr>
            )}
          </tbody>
        </table>
      </div>

      <div className="divider divider-vertical divider-end">
        <Link href="/courses" className="btn btn-secondary">
          Lihat Semua Mata Kuliah
        </Link>
      </div>
    </div>
  );
};

export default CoursesSection;
