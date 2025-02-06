import React from 'react';

const Home: React.FC = () => {
    return (
        <div>
            <h1>Welcome to the Home Page</h1>
            <div className="flex justify-center items-center min-h-screen bg-gray-100">
                <button className="btn btn-primary">Click Me</button>
            </div>
        </div>

    );
};

export default Home;