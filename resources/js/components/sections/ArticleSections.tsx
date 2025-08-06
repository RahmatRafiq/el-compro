import { Link } from "@inertiajs/react";
import React from "react";
import type { Article } from '@/types';

interface ArticlesSectionProps {
    articles: Article[];
}

const ArticlesSection: React.FC<ArticlesSectionProps> = ({ articles }) => {
    // Filter artikel yang bukan kategori "Pengumuman" karena pengumuman ditampilkan di section terpisah
    const filteredArticles = articles.filter(
        article => {
            const categoryName = article.category?.name?.toLowerCase();
            return categoryName !== 'pengumuman';
        }
    );

    if (filteredArticles.length === 0) {
        return (
            <section className="w-full py-8">
                <h2 className="text-3xl font-bold text-center mb-6">Artikel Terbaru</h2>
                <div className="text-center py-8">
                    <p className="text-base-content/60">Belum ada artikel tersedia.</p>
                </div>
            </section>
        );
    }

    return (
        <section className="w-full py-8">
            <h2 className="text-3xl font-bold text-center mb-6">Artikel Terbaru</h2>

            <div className="grid gap-4 sm:grid-cols-2 lg:grid-cols-4 auto-rows-[1fr]">
                {filteredArticles.map((article, index) => (
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


            </div>
            <div className="divider divider-vertical divider-end mt-8">
                <Link href="/articles" className="btn btn-secondary">
                    Lihat Semua Artikel 
                </Link>
            </div>
        </section>
    );
};

export default ArticlesSection;
