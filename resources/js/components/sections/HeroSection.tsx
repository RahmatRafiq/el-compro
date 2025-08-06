import { Link } from '@inertiajs/react';
import React, { useState, useEffect, useRef } from 'react';
import { FaChevronLeft, FaChevronRight } from 'react-icons/fa';

interface HeroSlide {
    id: number;
    image: string;
    title: string;
    description: string;
    gradient: string;
}

const HeroSection: React.FC = () => {
    const [currentSlide, setCurrentSlide] = useState(0);
    const [isAutoPlay, setIsAutoPlay] = useState(true);
    const touchStartX = useRef(0);
    const touchEndX = useRef(0);
    const autoAdvanceTimer = useRef<number | null>(null);

    const slides: HeroSlide[] = [
        {
            id: 1,
            image: '/assets/images/hero/hero3.jpg',
            title: 'Program Studi Teknik Elektro',
            description: 'Membangun masa depan dengan teknologi elektro yang inovatif dan berkelanjutan untuk kemajuan bangsa.',
            gradient: 'from-primary/40 to-secondary/40'
        },
        {
            id: 2,
            image: '/assets/images/hero/hero2.jpg',
            title: '',
            description: '',
            gradient: 'from-secondary/20 to-accent/20'
        },
        {
            id: 3,
            image: '/assets/images/hero/hero1.jpg',
            title: '',
            description: '',
            gradient: 'from-accent/20 to-primary/20'
        },

    ];

    // Auto advance functionality
    const resetAutoAdvance = () => {
        if (autoAdvanceTimer.current) {
            clearInterval(autoAdvanceTimer.current);
        }
        if (isAutoPlay) {
            autoAdvanceTimer.current = window.setInterval(() => {
                nextSlide();
            }, 5000);
        }
    };

    const nextSlide = () => {
        setCurrentSlide((prev) => (prev + 1) % slides.length);
    };

    const prevSlide = () => {
        setCurrentSlide((prev) => (prev - 1 + slides.length) % slides.length);
    };

    const goToSlide = (index: number) => {
        setCurrentSlide(index);
    };

    // Touch/swipe handlers
    const handleTouchStart = (e: React.TouchEvent) => {
        touchStartX.current = e.changedTouches[0].screenX;
    };

    const handleTouchEnd = (e: React.TouchEvent) => {
        touchEndX.current = e.changedTouches[0].screenX;
        handleSwipe();
    };

    const handleSwipe = () => {
        const swipeThreshold = 50;
        const diff = touchStartX.current - touchEndX.current;

        if (Math.abs(diff) > swipeThreshold) {
            if (diff > 0) {
                nextSlide();
            } else {
                prevSlide();
            }
        }
    };

    // Keyboard navigation
    useEffect(() => {
        const handleKeyPress = (e: KeyboardEvent) => {
            if (e.key === 'ArrowLeft') {
                prevSlide();
            } else if (e.key === 'ArrowRight') {
                nextSlide();
            }
        };

        window.addEventListener('keydown', handleKeyPress);
        return () => window.removeEventListener('keydown', handleKeyPress);
    }, []);

    // Auto advance setup
    useEffect(() => {
        resetAutoAdvance();
        return () => {
            if (autoAdvanceTimer.current) {
                clearInterval(autoAdvanceTimer.current);
            }
        };
    }, [currentSlide, isAutoPlay]);

    const getSlideClass = (index: number) => {
        const baseClass = "carousel-item absolute top-0 left-0 w-full h-full transition-all duration-500 ease-out";

        if (index === currentSlide) {
            return `${baseClass} opacity-100 scale-100 translate-x-0 z-10`;
        } else if (index === (currentSlide + 1) % slides.length) {
            return `${baseClass} opacity-0 sm:opacity-70 scale-80 sm:scale-90 translate-x-full sm:translate-x-full z-0`;
        } else if (index === (currentSlide - 1 + slides.length) % slides.length) {
            return `${baseClass} opacity-0 sm:opacity-70 scale-80 sm:scale-90 -translate-x-full sm:-translate-x-full z-0`;
        } else {
            return `${baseClass} opacity-0 scale-75 translate-x-0 z-0`;
        }
    };

    return (
        <div className="relative w-full h-[50vh] sm:h-[60vh] md:h-[75vh] lg:h-screen overflow-hidden bg-base-300">
            {/* Background effects */}
            <div className="fixed inset-0 -z-20">
                <div className="absolute inset-0 bg-gradient-to-br from-base-300/20 via-base-200/20 to-base-100/20"></div>
                <div className="absolute top-1/4 left-1/4 w-48 h-48 sm:w-96 sm:h-96 bg-primary/10 rounded-full filter blur-3xl animate-pulse"></div>
                <div className="absolute bottom-1/4 right-1/4 w-48 h-48 sm:w-96 sm:h-96 bg-secondary/10 rounded-full filter blur-3xl animate-pulse delay-1000"></div>
            </div>

            {/* Main carousel container */}
            <div
                className="carousel-container relative w-full h-full"
                style={{ perspective: '1000px' }}
                onTouchStart={handleTouchStart}
                onTouchEnd={handleTouchEnd}
                onMouseEnter={() => setIsAutoPlay(false)}
                onMouseLeave={() => setIsAutoPlay(true)}
            >
                {/* Progress bar */}
                <div className="absolute top-0 left-0 right-0 h-1 bg-base-content/10 rounded-full overflow-hidden z-30">
                    <div
                        className="absolute top-0 left-0 h-full bg-gradient-to-r from-primary to-secondary transition-all duration-500 ease-out"
                        style={{ width: `${((currentSlide + 1) / slides.length) * 100}%` }}
                    ></div>
                </div>

                {/* Navigation buttons */}
                <button
                    onClick={prevSlide}
                    className="absolute left-2 sm:left-4 top-1/2 -translate-y-1/2 w-8 h-8 sm:w-10 sm:h-10 md:w-12 md:h-12 rounded-full flex items-center justify-center z-30 text-base-content bg-base-100/10 backdrop-blur-md hover:bg-base-100/20 hover:scale-110 active:scale-95 transition-all duration-300 border border-base-content/20"
                    title="Previous slide"
                >
                    <FaChevronLeft className="w-3 h-3 sm:w-4 sm:h-4 md:w-5 md:h-5" />
                </button>

                <button
                    onClick={nextSlide}
                    className="absolute right-2 sm:right-4 top-1/2 -translate-y-1/2 w-8 h-8 sm:w-10 sm:h-10 md:w-12 md:h-12 rounded-full flex items-center justify-center z-30 text-base-content bg-base-100/10 backdrop-blur-md hover:bg-base-100/20 hover:scale-110 active:scale-95 transition-all duration-300 border border-base-content/20"
                    title="Next slide"
                >
                    <FaChevronRight className="w-5 h-5" />
                </button>

                {/* Carousel track */}
                <div className="relative w-full h-full overflow-hidden">
                    {slides.map((slide, index) => (
                        <div
                            key={slide.id}
                            className={getSlideClass(index)}
                            style={{
                                transformStyle: 'preserve-3d',
                                backfaceVisibility: 'hidden'
                            }}
                        >
                            <div className="absolute inset-0 w-full h-full">
                                {/* Image - Full Screen */}
                                <img
                                    src={slide.image}
                                    alt={slide.title || `Hero ${slide.id}`}
                                    className="absolute inset-0 w-full h-full object-cover transition-transform duration-700 group-hover:scale-110"
                                />

                                {/* Gradient overlay */}
                                <div className={`absolute inset-0 bg-gradient-to-br ${slide.gradient} mix-blend-overlay`}></div>

                                {/* Content - Only for first slide */}
                                {index === 0 && slide.title && (
                                    <div className="absolute inset-0 flex flex-col justify-center items-center text-center">
                                        {/* Background blur gelap untuk meningkatkan keterbacaan text */}
                                        <div className="absolute inset-0 bg-black/20 backdrop-blur-md"></div>
                                        {/* Text content dengan background gelap semi-transparan */}
                                        <div className="relative z-10 p-6 sm:p-8 md:p-12 m-4 sm:m-6 md:m-8 max-w-4xl mx-auto">
                                            <h1 className="text-white text-2xl sm:text-3xl md:text-4xl lg:text-5xl xl:text-6xl font-bold mb-3 sm:mb-4 md:mb-6 leading-tight animate-fadeInUp drop-shadow-lg">
                                                {slide.title}
                                            </h1>
                                            <p className="text-white/95 text-base sm:text-lg md:text-xl lg:text-2xl max-w-3xl mx-auto leading-relaxed animate-fadeInUp animation-delay-200 mb-6 sm:mb-8 drop-shadow-md">
                                                {slide.description}
                                            </p>

                                            <div className="animate-fadeInUp animation-delay-400">
                                                <Link
                                                    href="/courses"
                                                    className="btn btn-primary btn-sm sm:btn-md lg:btn-lg gap-2 sm:gap-3 hover:scale-105 transition-all duration-300 shadow-lg hover:shadow-xl"
                                                >
                                                    <span className="text-sm sm:text-base">Jelajahi Program Kami</span>
                                                    <FaChevronRight className="w-3 h-3 sm:w-4 sm:h-4" />
                                                </Link>
                                            </div>
                                        </div>
                                    </div>
                                )}
                            </div>
                        </div>
                    ))}
                </div>

                {/* Indicators */}
                <div className="absolute bottom-4 sm:bottom-6 left-1/2 -translate-x-1/2 flex gap-1 sm:gap-2 z-30">
                    {slides.map((_, index) => (
                        <button
                            key={index}
                            onClick={() => goToSlide(index)}
                            className={`w-6 sm:w-8 md:w-12 h-1 sm:h-1.5 rounded-full transition-all duration-300 ${index === currentSlide
                                    ? 'bg-primary/60 scale-110'
                                    : 'bg-base-content/20 hover:bg-base-content/40'
                                }`}
                            title={`Go to slide ${index + 1}`}
                        />
                    ))}
                </div>
            </div>
        </div>
    );
};

export default HeroSection;