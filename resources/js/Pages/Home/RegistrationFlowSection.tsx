import React from 'react';

interface RegistrationFlowSectionProps {
  registrationFlowData: any;
}

const RegistrationFlowSection: React.FC<RegistrationFlowSectionProps> = ({ registrationFlowData }) => {
  if (!registrationFlowData) return null;

  const parser = new DOMParser();
  const parsedHtml = parser.parseFromString(registrationFlowData.description, "text/html");
  const listItems = Array.from(parsedHtml.querySelectorAll("li")).map((item, index) => (
    <li key={index} className="step">{item.textContent}</li>
  ));

  return (
    <section className="rounded-lg w-full py-8 bg-neutral text-neutral-content">
      <h2 className="text-2xl font-bold text-center mb-6">Informasi dan Alur Pendaftaran</h2>
      <ul className="steps steps-vertical">{listItems}</ul>
    </section>
  );
};

export default RegistrationFlowSection;
