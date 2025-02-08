import { Link } from "@inertiajs/react";
import React from "react";

interface Course {
  id: number;
  course_code: string;
  name: string;
  credits: number;
}

interface CoursesSectionProps {
  courses?: Course[];
}

const CoursesSection: React.FC<CoursesSectionProps> = ({ courses = [] }) => {
  return (
    <div className="rounded-lg w-full py-8 shadow-xl">
      <h2 className="text-3xl font-bold text-center  mb-6">Mata Kuliah</h2>
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
            {courses.length > 0 ? (
              courses.map((course, index) => (
                <tr key={course.id}>
                  <td>{index + 1}</td>
                  <td>{course.course_code}</td>
                  <td>{course.name}</td>
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
      <div className="mt-4 text-right">
        <Link href="/courses" className="btn btn-primary">
          Lihat Semua
        </Link>
      </div>
    </div>
  );
};

export default CoursesSection;
