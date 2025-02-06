export interface User {
    id: number;
    name: string;
    email: string;
    username: string;
    email_verified_at?: string;
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
