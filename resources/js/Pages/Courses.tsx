import Layout from "@/Layouts/Layout";
import { Link } from "@inertiajs/react";
import React from "react";

interface Course {
    id: number;
    course_code: string;
    name: string;
    credits: number;
    lecturers: { id: number; name: string }[];

}

interface CoursesProps {
    courses: Course[];
    aboutApp: {
        title: string;
        contact_email: string;
        contact_phone: string;
        contact_address: string;
      };
}

const Courses: React.FC<CoursesProps> = ({ courses, aboutApp }) => {
    return (
        <Layout aboutApp={aboutApp}> 
            <div className="space-y-8 px-6">
                <div className="container mx-auto p-6">
                    <h1 className="text-3xl font-bold text-center mb-6">Daftar Mata Kuliah</h1>
                    <div className="overflow-x-auto">
                        <table className="table table-zebra w-full">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Kode Mata Kuliah</th>
                                    <th>Nama Mata Kuliah</th>
                                    <th>SKS</th>
                                    <th>Dosen Pengajar</th>
                                </tr>
                            </thead>
                            <tbody>
                                {courses.map((course, index) => (
                                    <tr key={course.id}>
                                        <td>{index + 1}</td>
                                        <td>{course.course_code}</td>
                                        <td>{course.name}</td>
                                        <td>{course.credits}</td>
                                        <td>
                                            {course.lecturers.length > 0
                                                ? course.lecturers.map((lecturer) => lecturer.name).join(", ")
                                                : "Belum ada dosen"}
                                        </td>
                                    </tr>
                                ))}
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </Layout>
    );
};

export default Courses;
