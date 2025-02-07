import React from "react";
import { Head, usePage } from "@inertiajs/react";
import { PageProps as InertiaPageProps } from '@inertiajs/core';
import Layout from "@/Layouts/Layout";

interface Lecturer {
    id: number;
    name: string;
    image: string;
    courses: { id: number; name: string }[];
}


interface PageProps extends InertiaPageProps {
    lecturers: Lecturer[];
}

const Lecturers: React.FC = () => {
    const { lecturers } = usePage<PageProps>().props;

    return (
        <>
            <Layout>
                <div className="space-y-8 px-6">
                    <Head title="Dosen Kami" />
                    <section className="rounded-lg w-full py-8 bg-base-100 shadow-xl">
                        <h2 className="text-2xl font-bold text-center mb-6">Dosen Kami</h2>
                        <div className="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                            {lecturers.map((lecturer) => (
                                <div
                                    key={lecturer.id}
                                    className="card card-side bg-base-100 shadow-xl flex bg-base-200"
                                >
                                    <figure className="w-40 h-40 flex-shrink-0 overflow-hidden rounded-lg">
                                        <img
                                            src={lecturer.image}
                                            alt={lecturer.name}
                                            className="w-full h-full object-cover"
                                        />
                                    </figure>
                                    <div className="card-body bg-base-200">
                                        <h2 className="card-title">{lecturer.name}</h2>
                                        <p className="text-sm text-gray-500">
                                            {lecturer.courses.length > 0
                                                ? `Mengajar: ${lecturer.courses.map((course) => course.name).join(", ")}`
                                                : "Belum ada mata kuliah"}
                                        </p>
                                    </div>
                                </div>
                            ))}
                        </div>
                    </section>
                </div>
            </Layout>
        </>
    );
};

export default Lecturers;
