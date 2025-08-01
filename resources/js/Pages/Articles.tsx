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

interface CategorySection {
    name: string;
    articles: Article[];
}

interface ArticlesPageProps {
    categories: CategorySection[];
    aboutApp: {
        title: string;
        contact_email: string;
        contact_phone: string;
        contact_address: string;
    };
}

const ArticlesPage: React.FC<ArticlesPageProps> = ({ categories, aboutApp }) => {
    return (
        <Layout aboutApp={aboutApp}>
            <div className="container mx-auto px-4 sm:px-6 lg:px-8 py-8">
                <section className="w-full space-y-10">
                    <h2 className="text-3xl font-bold text-center mb-6">Semua Artikel</h2>
                    {categories.filter(category => category.articles.length > 0).map((category) => (
                        <div key={category.name} className="mb-10 card bg-base-100 shadow-lg p-6">
                            <h3 className="text-2xl font-bold text-center mb-6">{category.name}</h3>
                            <div className="grid gap-4 sm:grid-cols-2 lg:grid-cols-4">
                                {category.articles.map((article) => (
                                    <div key={article.id} className="card bg-base-200 shadow-xl">
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
                                            <div className="text-sm text-base-content/70 mb-2">
                                                {article.view_count} kali dilihat
                                            </div>
                                            <div className="card-actions justify-end">
                                                <Link href={`/articles/${article.slug}`} className="btn btn-primary">
                                                    Baca Selengkapnya
                                                </Link>
                                            </div>
                                        </div>
                                    </div>
                                ))}
                            </div>
                            <div className="flex justify-center mt-8">
                                <Link href={`/articles/category/${category.name}`} className="btn btn-ghost">
                                    Lihat Berita {category.name} Lainnya
                                </Link>
                            </div>
                        </div>
                    ))}
                </section>
            </div>
        </Layout>
    );
};

export default ArticlesPage;
