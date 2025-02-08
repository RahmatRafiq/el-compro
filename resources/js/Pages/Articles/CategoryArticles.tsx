import Layout from "@/Layouts/Layout";
import { Link } from "@inertiajs/react";
import React from "react";

interface Article {
    id: number;
    title: string;
    image: string | null;
    view_count: number;
    slug: string;
}

interface PaginatedData<T> {
    data: T[];
    current_page: number;
    last_page: number;
    per_page: number;
    total: number;
}

interface CategoryArticlesPageProps {
    category: {
        name: string;
    };
    articles: PaginatedData<Article>;
    aboutApp: {
        title: string;
        contact_email: string;
        contact_phone: string;
        contact_address: string;
    };
}

const CategoryArticlesPage: React.FC<CategoryArticlesPageProps> = ({ category, articles, aboutApp }) => {
    return (
        <Layout aboutApp={aboutApp}>
            <div className="space-y-8 px-6">
                {/* Heading */}
                <h2 className="text-3xl font-bold text-center mb-6">
                    Daftar Semua Artikel Kategori {category.name}
                </h2>

                {/* Grid Artikel */}
                <div className="grid gap-4 sm:grid-cols-2 lg:grid-cols-5">
                    {articles.data.length > 0 ? (
                        articles.data.map((article) => (
                            <div key={article.id} className="card bg-base-100 shadow-xl">
                                <figure className="aspect-[4/3] overflow-hidden bg-gray-300 flex items-center justify-center">
                                    {article.image ? (
                                        <img
                                            src={article.image}
                                            alt={article.title}
                                            className="object-cover w-full h-full"
                                            onError={(e) => (e.currentTarget.style.display = "none")}
                                        />
                                    ) : (
                                        <div className="w-full h-full bg-gray-300 animate-pulse flex items-center justify-center">
                                            <span className="text-gray-500 text-lg font-semibold">Gambar Tidak Tersedia</span>
                                        </div>
                                    )}
                                </figure>
                                <div className="card-body">
                                    <h2 className="card-title">{article.title}</h2>
                                    <p>{article.view_count} kali dilihat</p>
                                    <div className="card-actions justify-end">
                                        <Link href={`/articles/${article.slug}`} className="btn btn-primary">
                                            Baca Selengkapnya
                                        </Link>
                                    </div>
                                </div>
                            </div>
                        ))
                    ) : (
                        <p className="text-center text-gray-500">Belum ada artikel dalam kategori ini.</p>
                    )}
                </div>

                <div className="flex justify-center mt-8 space-x-4">
                    {articles.current_page > 1 && (
                        <Link
                            href={`?page=${articles.current_page - 1}`}
                            className="btn btn-secondary"
                        >
                            Sebelumnya
                        </Link>
                    )}

                    {articles.current_page < articles.last_page && (
                        <Link
                            href={`?page=${articles.current_page + 1}`}
                            className="btn btn-secondary"
                        >
                            Selanjutnya
                        </Link>
                    )}
                </div>

                <div className="flex justify-center mt-8">
                    <Link href="/categories" className="btn btn-outline">
                        Lihat Kategori Lainnya
                    </Link>
                </div>
            </div>
        </Layout>
    );
};

export default CategoryArticlesPage;
