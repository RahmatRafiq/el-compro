import Layout from "@/Layouts/Layout";
import { Link } from "@inertiajs/react";
import React from "react";
import parse from "html-react-parser";

interface Article {
    id: number;
    title: string;
    content: string;
    image: string | null;
    view_count: number;
    created_at: string;
}

interface ArticleSummary {
    id: number;
    slug: string;
    title: string;
    created_at: string;
    view_count?: number;
    image?: string | null;
}

interface ArticleDetailProps {
    article: Article;
    aboutApp: {
        title: string;
        contact_email: string;
        contact_phone: string;
        contact_address: string;
    };
    popularArticles: ArticleSummary[];
    latestArticles: ArticleSummary[];
}

const ArticleDetail: React.FC<ArticleDetailProps> = ({ article, aboutApp, popularArticles, latestArticles }) => {
    return (
        <Layout aboutApp={aboutApp}>
            <div className="container mx-auto px-6 py-10">
                <div className="grid grid-cols-1 md:grid-cols-3 gap-8">
                    <div className="md:col-span-2 space-y-6">
                        <h1 className="text-4xl font-bold">{article.title}</h1>
                        <p className="text-gray-500 text-sm">
                            Dipublikasikan pada {article.created_at} | {article.view_count} kali dilihat
                        </p>

                        <figure className="w-full aspect-[16/9] overflow-hidden rounded-lg bg-gray-300 flex items-center justify-center">
                            {article.image ? (
                                <img
                                    src={article.image}
                                    alt={article.title}
                                    className="object-cover w-full h-full"
                                    onError={(e) => (e.currentTarget.style.display = "none")}
                                />
                            ) : (
                                <div className="w-full h-full bg-gray-300 animate-pulse flex items-center justify-center">
                                    <span className="text-gray-500">Gambar Tidak Tersedia</span>
                                </div>
                            )}
                        </figure>

                        <article className="text-lg leading-relaxed">{parse(article.content)}</article>

                        <div className="mt-6">
                            <Link href="/home/articles" className="btn btn-secondary">
                                Kembali ke Artikel
                            </Link>
                        </div>
                    </div>

                    <aside className="hidden md:block space-y-8">
                        <section>
                            <h2 className="text-xl font-semibold border-b pb-2">Berita Paling Populer</h2>
                            <ul className="mt-4 space-y-3">
                                {popularArticles.map((item) => (
                                    <li key={item.id} className="flex items-center space-x-3 border-b pb-2">
                                        <div className="w-16 h-16 bg-gray-300 rounded overflow-hidden">
                                            {item.image ? (
                                                <img
                                                    src={item.image}
                                                    alt={item.title}
                                                    className="object-cover w-full h-full"
                                                    onError={(e) => (e.currentTarget.style.display = "none")}
                                                />
                                            ) : (
                                                <div className="w-full h-full bg-gray-200 flex items-center justify-center text-xs text-gray-500">
                                                    No Image
                                                </div>
                                            )}
                                        </div>

                                        <div className="flex-1">
                                            <Link href={`/home/articles/${item.slug}`} className="hover:underline text-blue-600">
                                                {item.title}
                                            </Link>
                                            <p className="text-gray-500 text-xs">{item.view_count}x dilihat</p>
                                        </div>
                                    </li>
                                ))}
                            </ul>
                        </section>

                        <section>
                            <h2 className="text-xl font-semibold border-b pb-2">Berita Terbaru</h2>
                            <ul className="mt-4 space-y-3">
                                {latestArticles.map((item) => (
                                    <li key={item.id} className="flex items-center space-x-3 border-b pb-2">
                                        <div className="w-16 h-16 bg-gray-300 rounded overflow-hidden">
                                            {item.image ? (
                                                <img
                                                    src={item.image}
                                                    alt={item.title}
                                                    className="object-cover w-full h-full"
                                                    onError={(e) => (e.currentTarget.style.display = "none")}
                                                />
                                            ) : (
                                                <div className="w-full h-full bg-gray-200 flex items-center justify-center text-xs text-gray-500">
                                                    No Image
                                                </div>
                                            )}
                                        </div>

                                        <div className="flex-1">
                                            <Link href={`/home/articles/${item.slug}`} className="hover:underline text-blue-600">
                                                {item.title}
                                            </Link>
                                            <p className="text-gray-500 text-xs">{item.created_at}</p>
                                        </div>
                                    </li>
                                ))}
                            </ul>
                        </section>
                    </aside>

                </div>
            </div>
        </Layout>
    );
};

export default ArticleDetail;
