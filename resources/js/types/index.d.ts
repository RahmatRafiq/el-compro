export interface User {
    id: number;
    name: string;
    email: string;
    username: string;
    email_verified_at?: string;
}

export interface VirtualTour {
    id: number;
    name: string;
    url_embed: string;
    description: string;
}

export interface Lecturer {
    id: number;
    name: string;
    about: string;
    email: string;
    image: string;
    courses: Course[];
}

export interface Course {
    id: number;
    course_code: string;
    name: string;
    credits: number;
    semester?: string;
    major_concentration: string;
}

export interface Article {
    id: number;
    title: string;
    content?: string;
    image: string;
    slug: string;
    view_count: number;
    created_at?: string;
    category?: Category;
}

export interface Category {
    id: number;
    name: string;
    slug: string;
}

export interface AboutApp {
    title: string;
    contact_email: string;
    contact_phone: string;
    contact_address: string;
}

export interface GraduateLearningOutcome {
    id: number;
    concentration: string;
    name: string;
    description: string;
}

export interface GeneralInformation {
    id: number;
    name: string;
    description: string;
    content?: string;
    image?: string;
}

export type PageProps<
    T extends object = object
> = {
    auth: {
        user: User;
    };
    item?: T;
    data?: {
        data?: T[];
        total?: number;
    };
    extra?: {
        [key: string]: unknown;
    }
};
