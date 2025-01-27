# Job Applicant Rank PSI  
This is a job applicant ranking system that allows users to rank job applicants based on their qualifications. The system allows users to create job postings, add applicants to job postings, and rank applicants based on their qualifications. The system also allows users to view the ranking of applicants for a specific job posting.

## Table of Contents
1. [Clone the repository](#clone-the-repository)
2. [Install dependencies](#install-dependencies)
3. [Copy the example environment file and configure the environment](#copy-the-example-environment-file-and-configure-the-environment)
4. [Generate an application key](#generate-an-application-key)
5. [Set up the database](#set-up-the-database)
6. [Install front-end dependencies](#install-front-end-dependencies)
7. [Serve the application](#serve-the-application)
8. [Update code when there is a new update on the repository](#update-code-when-there-is-a-new-update-on-the-repository)

## Clone the repository

Follow these steps to install the Laravel project from the GitHub repository:

1. **Clone the repository:**
    ```bash
    git clone https://github.com/Dzyfhuba/job-applicant-rank-psi.git
    cd job-applicant-rank-psi
    ```

## Install dependencies
2. **Install dependencies:**
    ```bash
    composer install
    ```

## Copy the example environment file and configure the environment
3. **Copy the example environment file and configure the environment:**
    ```bash
    cp .env.example .env
    ```

## Generate an application key
4. **Generate an application key:**
    ```bash
    php artisan key:generate
    ```

## Set up the database
5. **Set up the database:**
    - Update the `.env` file with your database credentials.
    - Run the migrations:
        ```bash
        php artisan migrate
        ```

## Install front-end dependencies
6. **Install front-end dependencies:**
    ```bash
    npm install
    npm run dev
    ```

    - **Optional: If you want to build for production:**
        ```bash
        npm run build
        ```

## Serve the application
7. **Serve the application:**
    ```bash
    php artisan serve
    ```

## Update code when there is a new update on the repository
8. **Update code when there is a new update on the repository:**
    ```bash
    git pull origin main
    composer install
    php artisan migrate
    npm install
    npm run dev
    ```

Your Laravel application should now be up and running. Open your browser and navigate to `http://localhost:8000`.

For more information, refer to the [Laravel documentation](https://laravel.com/docs).#   e l - c o m p r o  
 