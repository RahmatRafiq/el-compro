import { Link } from "@inertiajs/react";
import React from "react";

interface Article {
    id: number;
    title: string;
    image: string;
    view_count: number;
    slug: string;
}

interface ArticlesSectionProps {
    articles: Article[];
}

const ArticlesSection: React.FC<ArticlesSectionProps> = ({ articles }) => {
    return (
        <section className="rounded-lg w-full py-8 shadow-xl">
            <h2 className="text-3xl font-bold text-center  mb-6">Artikel Terbaru</h2>

            <div className="grid gap-4 sm:grid-cols-2 lg:grid-cols-4 auto-rows-[1fr]">
                {articles.map((article, index) => (
                    <div
                        key={article.id}
                        className="card bg-base-100 image-full shadow-xl break-inside-avoid"
                        style={{ gridRowEnd: `span ${Math.floor(Math.random() * 2) + 1}` }}
                    >
                        <figure>
                            <img
                                src={article.image}
                                alt={article.title}
                                className="object-cover w-full h-full"
                            />
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
                ))}

                <div
                    className="card bg-base-100 image-full shadow-xl break-inside-avoid cursor-pointer"
                    style={{ gridRowEnd: `span 2` }}
                >
                    <figure className="w-full h-full overflow-hidden rounded-lg bg-gray-300 animate-pulse flex items-center justify-center">
                        <span className="text-gray-500 text-lg font-semibold">+</span>
                    </figure>
                    <div className="card-body flex justify-center items-center">
                        <Link
                            href="/articles"
                            className="btn btn-primary w-full"
                        >
                            Lihat Semua Artikel
                        </Link>
                    </div>
                </div>
            </div>
        </section>
    );
};

export default ArticlesSection;
