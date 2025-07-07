import React from "react";
import { Head, usePage } from "@inertiajs/react";
import { PageProps as InertiaPageProps } from '@inertiajs/core';
import Layout from "@/Layouts/Layout";

interface Lecturer {
    id: number;
    name: string;
    about: string;
    email: string;
    image: string;
    courses: { id: number; name: string }[];
}


interface LecturersProps extends InertiaPageProps {
    lecturers: Lecturer[];
    aboutApp: {
        title: string;
        contact_email: string;
        contact_phone: string;
        contact_address: string;
      };
}

const Lecturers: React.FC<LecturersProps> = ({ lecturers, aboutApp }) => {

    return (
        <>
        <Layout aboutApp={aboutApp}> 
        <div className="w-full">
                    <Head title="Dosen Kami" />
                    {/* Header Section */}
                    <div className="container mx-auto px-4 sm:px-6 lg:px-8 py-8">
                        <div className="text-center space-y-4">
                            <h1 className="text-2xl sm:text-3xl lg:text-4xl font-bold text-base-content">Dosen Kami</h1>
                            <p className="text-base-content/70 text-sm sm:text-base max-w-2xl mx-auto">
                                Tim dosen berpengalaman dan berkualitas tinggi yang siap membimbing mahasiswa dalam perjalanan akademik mereka.
                            </p>
                        </div>
                    </div>

                    {/* Lecturers Grid */}
                    <div className="container mx-auto px-4 sm:px-6 lg:px-8 pb-12">
                        <div className="grid grid-cols-1 lg:grid-cols-2 xl:grid-cols-3 gap-6">
                            {lecturers.map((lecturer) => (
                                <div
                                key={lecturer.id}
                                className="card bg-base-100 shadow-xl hover:shadow-2xl transition-all duration-300 transform hover:-translate-y-1"
                            >
                                {/* Mobile: Vertical Layout */}
                                <div className="block sm:hidden">
                                    <figure className="h-48 overflow-hidden">
                                        <img
                                            src={lecturer.image}
                                            alt={lecturer.name}
                                            className="w-full h-full object-cover"
                                        />
                                    </figure>
                                    <div className="card-body p-4 space-y-3">
                                        <h3 className="card-title text-lg text-base-content">{lecturer.name}</h3>
                                        {lecturer.courses.length > 0 && (
                                            <p className="text-sm text-primary font-medium">
                                                Mengajar: {lecturer.courses.map((course) => course.name).join(", ")}
                                            </p>
                                        )}
                                        {lecturer.about && (
                                            <p className="text-sm text-base-content/70 line-clamp-3">
                                                {lecturer.about}
                                            </p>
                                        )}
                                        {lecturer.email && (
                                            <div className="pt-2 border-t border-base-300">
                                                <a 
                                                    href={`mailto:${lecturer.email}`} 
                                                    className="text-sm text-primary hover:text-primary-focus font-medium flex items-center"
                                                >
                                                    <svg className="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path strokeLinecap="round" strokeLinejoin="round" strokeWidth={2} d="M3 8l7.89 7.89a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                                                    </svg>
                                                    {lecturer.email}
                                                </a>
                                            </div>
                                        )}
                                    </div>
                                </div>

                                {/* Desktop/Tablet: Horizontal Layout */}
                                <div className="hidden sm:flex">
                                    <figure className="w-32 h-32 lg:w-36 lg:h-36 flex-shrink-0 overflow-hidden">
                                        <img
                                            src={lecturer.image}
                                            alt={lecturer.name}
                                            className="w-full h-full object-cover"
                                        />
                                    </figure>
                                    <div className="card-body flex-1 p-4 space-y-2">
                                        <h3 className="card-title text-lg lg:text-xl text-base-content leading-tight">{lecturer.name}</h3>
                                        {lecturer.courses.length > 0 && (
                                            <p className="text-xs lg:text-sm text-primary font-medium">
                                                Mengajar: {lecturer.courses.map((course) => course.name).join(", ")}
                                            </p>
                                        )}
                                        {lecturer.about && (
                                            <p className="text-xs lg:text-sm text-base-content/70 line-clamp-2 lg:line-clamp-3">
                                                {lecturer.about}
                                            </p>
                                        )}
                                        {lecturer.email && (
                                            <div className="pt-1">
                                                <a 
                                                    href={`mailto:${lecturer.email}`} 
                                                    className="text-xs lg:text-sm text-primary hover:text-primary-focus font-medium flex items-center"
                                                >
                                                    <svg className="w-3 h-3 lg:w-4 lg:h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path strokeLinecap="round" strokeLinejoin="round" strokeWidth={2} d="M3 8l7.89 7.89a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                                                    </svg>
                                                    {lecturer.email}
                                                </a>
                                            </div>
                                        )}
                                    </div>
                                </div>
                            </div>
                            
                            ))}
                        </div>
                    </div>
                </div>
            </Layout>
        </>
    );
};

export default Lecturers;
