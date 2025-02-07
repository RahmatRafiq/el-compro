import React from 'react';

interface Lecturer {
  id: number;
  name: string;
  image: string;
  courses: { id: number; name: string }[];
}

interface LecturersSectionProps {
  lecturers: Lecturer[];
}

const LecturersSection: React.FC<LecturersSectionProps> = ({ lecturers }) => {
  return (
    <section className="rounded-lg w-full py-8 bg-base-100 shadow-xl">
      <h2 className="text-2xl font-bold text-center mb-6">Dosen Kami</h2>
      <div className="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        {lecturers.map((lecturer) => (
          <div key={lecturer.id} className="card card-side bg-base-100 shadow-xl flex bg-base-200">
            <figure className="w-40 h-40 flex-shrink-0 overflow-hidden rounded-lg ">
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
                  ? `Teaches: ${lecturer.courses.map(course => course.name).join(", ")}`
                  : "No courses assigned"}
              </p>
            </div>
          </div>
        ))}
      </div>
    </section>
  );
};

export default LecturersSection;
