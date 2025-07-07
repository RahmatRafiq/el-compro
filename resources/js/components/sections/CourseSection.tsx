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
    <div className="rounded-lg w-full py-8">
      <h2 className="text-3xl font-bold text-center mb-6">Mata Kuliah</h2>

      <div role="tablist" className="tabs tabs-lifted flex justify-center mb-6">
        <button
          role="tab"
          className={`tab px-6 py-3 text-lg font-semibold ${activeTab === "teknik_tenaga_listrik" ? "tab-active text-primary border-b-2 border-primary" : ""
            }`}
          onClick={() => setActiveTab("teknik_tenaga_listrik")}
        >
          TEKNIK TENAGA LISTRIK
        </button>
        <button
          role="tab"
          className={`tab px-6 py-3 text-lg font-semibold ${activeTab === "teknik_telekomunikasi" ? "tab-active text-primary border-b-2 border-primary" : ""
            }`}
          onClick={() => setActiveTab("teknik_telekomunikasi")}
        >
          TEKNIK TELEKOMUNIKASI
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
