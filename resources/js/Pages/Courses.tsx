import Layout from "@/Layouts/Layout";
import { Link } from "@inertiajs/react";
import React, { useState, useEffect } from "react";

interface Course {
    id: number;
    course_code: string;
    name: string;
    credits: number;
    major_concentration: string;
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
    const [activeTab, setActiveTab] = useState<string>("teknik_tenaga_listrik");

    const [baseCoursesToShow, setBaseCoursesToShow] = useState(10); // 10 mata kuliah pertama
    const [tenagaListrikCoursesToShow, setTenagaListrikCoursesToShow] = useState(10);
    const [telekomunikasiCoursesToShow, setTelekomunikasiCoursesToShow] = useState(10);

    useEffect(() => {
        console.log("Courses received:", courses);
    }, []);

    const baseCourses = courses.filter((course) => course.major_concentration === "mata_kuliah_dasar");
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

    const renderCoursesTable = (
        courseList: Course[],
        coursesToShow: number,
        setCoursesToShow: React.Dispatch<React.SetStateAction<number>>
    ) => (
        <div>
            <table className="table table-zebra w-full mb-8">
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
                    {courseList.slice(0, coursesToShow).map((course, index) => (
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
            {courseList.length > coursesToShow && (
                <button
                    className="btn btn-primary"
                    onClick={() => setCoursesToShow(coursesToShow + 5)} // Menambah 5 data setiap kali tombol ditekan
                >
                    Lihat Lebih Banyak
                </button>
            )}
        </div>
    );

    return (
        <Layout aboutApp={aboutApp}>
            <div className="space-y-8 px-6">
                <div className="container mx-auto p-6">
                    <h1 className="text-3xl font-bold text-center mb-6">Daftar Mata Kuliah</h1>
                    <div className="overflow-x-auto">
                        <h2 className="text-xl font-semibold text-center mb-4">MATA KULIAH DASAR</h2>
                        {renderCoursesTable(baseCourses, baseCoursesToShow, setBaseCoursesToShow)}
                    </div>
                    <div className="tabs tabs-lifted flex justify-center mb-6">
                        <button
                            className={`tab px-6 py-3 text-lg font-semibold ${activeTab === "teknik_tenaga_listrik" ? "tab-active text-primary border-b-2 border-primary" : ""}`}
                            onClick={() => setActiveTab("teknik_tenaga_listrik")}
                        >
                            TEKNIK TENAGA LISTRIK
                        </button>
                        <button
                            className={`tab px-6 py-3 text-lg font-semibold ${activeTab === "teknik_telekomunikasi" ? "tab-active text-primary border-b-2 border-primary" : ""}`}
                            onClick={() => setActiveTab("teknik_telekomunikasi")}
                        >
                            TEKNIK TELEKOMUNIKASI
                        </button>
                    </div>
                    <div className="overflow-x-auto">
                        {activeTab === "teknik_tenaga_listrik"
                            ? renderCoursesTable(tenagaListrikCourses, tenagaListrikCoursesToShow, setTenagaListrikCoursesToShow)
                            : renderCoursesTable(telekomunikasiCourses, telekomunikasiCoursesToShow, setTelekomunikasiCoursesToShow)}
                    </div>
                </div>
            </div>
        </Layout>
    );
};

export default Courses;
