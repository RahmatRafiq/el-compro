// resources/js/Pages/Home.tsx
import React from 'react';
import Layout from '../Layouts/Layout';
import DenahLaboratorium from './Home/DenahLaboratorium';

const Home: React.FC = () => {
  return (
    <Layout>
      <div className="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        <section className="bg-white shadow-md rounded-lg p-6 text-center">
          <h2 className="text-2xl font-semibold">Denah Laboratorium</h2>
          <DenahLaboratorium />
        </section>

        <section className="bg-white shadow-md rounded-lg p-6 text-center">
          <h2 className="text-2xl font-semibold">Konsentrasi</h2>
          <p>Some details about Konsentrasi...</p>
        </section>

        <section className="bg-white shadow-md rounded-lg p-6 text-center">
          <h2 className="text-2xl font-semibold">Prospek Karir</h2>
          <p>Some details about Prospek Karir...</p>
        </section>
      </div>
    </Layout>
  );
};

export default Home;
