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

interface ArticleDetailProps {
    article: Article;
    aboutApp: {
        title: string;
        contact_email: string;
        contact_phone: string;
        contact_address: string;
    };
}

const ArticleDetail: React.FC<ArticleDetailProps> = ({ article, aboutApp }) => {
    return (
        <Layout aboutApp={aboutApp}>
            <div className="space-y-8 px-6">
                <section className="max-w-3xl mx-auto py-10">
                    <h1 className="text-4xl font-bold text-center mb-4">{article.title}</h1>
                    <p className="text-gray-500 text-center mb-6">
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

                    <article className="mt-6 text-lg leading-relaxed">
                        {parse(article.content)} 
                    </article>

                    <div className="mt-6">
                        <Link href="/home/articles" className="btn btn-secondary">
                            Kembali ke Artikel
                        </Link>
                    </div>
                </section>
            </div>
        </Layout>
    );
};

export default ArticleDetail;
