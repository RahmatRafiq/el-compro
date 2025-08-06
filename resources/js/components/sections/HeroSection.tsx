import React, { useState, useEffect, useRef } from 'react';
import { Link } from '@inertiajs/react';
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
        const baseClass = "carousel-item absolute top-0 left-0 w-full h-full";

        if (index === currentSlide) {
            return `${baseClass} active`;
        } else if (index === (currentSlide + 1) % slides.length) {
            return `${baseClass} next`;
        } else if (index === (currentSlide - 1 + slides.length) % slides.length) {
            return `${baseClass} prev`;
        } else {
            return `${baseClass} hidden`;
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

            {/* Main container */}
            <div className="w-full h-full">
                {/* Carousel container */}
                <div 
                    className="carousel-container relative w-full h-full"
                    onTouchStart={handleTouchStart}
                    onTouchEnd={handleTouchEnd}
                    onMouseEnter={() => setIsAutoPlay(false)}
                    onMouseLeave={() => setIsAutoPlay(true)}
                >
                    {/* Progress bar */}
                    <div className="absolute top-0 left-0 right-0 h-1 bg-base-content/10 rounded-full overflow-hidden z-20">
                        <div 
                            className="progress-bar absolute top-0 left-0 h-full bg-gradient-to-r from-primary to-secondary"
                            style={{ width: `${((currentSlide + 1) / slides.length) * 100}%` }}
                        ></div>
                    </div>

                    {/* Navigation buttons */}
                    <button 
                        className="nav-button absolute left-2 sm:left-4 top-1/2 -translate-y-1/2 w-10 h-10 sm:w-12 sm:h-12 rounded-full flex items-center justify-center z-20 text-base-content touch-manipulation" 
                        onClick={prevSlide} 
                        title="Previous slide"
                    >
                        <FaChevronLeft className="w-5 h-5 sm:w-6 sm:h-6" />
                    </button>
                    
                    <button 
                        className="nav-button absolute right-2 sm:right-4 top-1/2 -translate-y-1/2 w-10 h-10 sm:w-12 sm:h-12 rounded-full flex items-center justify-center z-20 text-base-content touch-manipulation" 
                        onClick={nextSlide} 
                        title="Next slide"
                    >
                        <FaChevronRight className="w-5 h-5 sm:w-6 sm:h-6" />
                    </button>

                    {/* Carousel track */}
                    <div className="carousel-track relative h-full overflow-hidden">
                        {/* Carousel items */}
                        {slides.map((slide, index) => (
                            <div key={slide.id} className={getSlideClass(index)}>
                                <div className="w-full h-full p-4 sm:p-8">
                                    <div className="w-full h-full rounded-xl sm:rounded-2xl overflow-hidden relative group">
                                        <img 
                                            src={slide.image} 
                                            alt={slide.title || `Hero ${slide.id}`} 
                                            className="absolute inset-0 w-full h-full object-cover transition-transform duration-500 group-hover:scale-110" 
                                        />
                                        <div className={`absolute inset-0 bg-gradient-to-br ${slide.gradient} mix-blend-overlay`}></div>
                                        
                                        {/* Content - Only for first slide */}
                                        {index === 0 && slide.title && (
                                            <div className="absolute inset-x-0 bottom-0 p-4 sm:p-8 bg-gradient-to-t from-black/80 via-black/40 to-transparent">
                                                <h3 className="text-white text-xl sm:text-2xl md:text-3xl lg:text-4xl font-bold mb-2 sm:mb-3">
                                                    {slide.title}
                                                </h3>
                                                <p className="text-gray-200 text-sm sm:text-base md:text-lg lg:text-xl max-w-2xl mb-4 sm:mb-6">
                                                    {slide.description}
                                                </p>
                                                <Link
                                                    href="/courses"
                                                    className="btn btn-primary btn-sm sm:btn-md gap-2 hover:scale-105 transition-all duration-300 shadow-lg hover:shadow-xl"
                                                >
                                                    <span className="text-sm sm:text-base">Jelajahi Program Kami</span>
                                                    <FaChevronRight className="w-3 h-3 sm:w-4 sm:h-4" />
                                                </Link>
                                            </div>
                                        )}
                                    </div>
                                </div>
                            </div>
                        ))}
                    </div>

                    {/* Indicators */}
                    <div className="absolute bottom-2 sm:bottom-4 left-1/2 -translate-x-1/2 flex gap-1 sm:gap-2 z-20">
                        {slides.map((_, index) => (
                            <button 
                                key={index}
                                className={`w-8 sm:w-12 h-1 sm:h-1.5 rounded-full transition-colors ${
                                    index === currentSlide ? 'bg-primary/60' : 'bg-base-content/20'
                                } hover:bg-primary/40`} 
                                onClick={() => goToSlide(index)}
                                title={`Go to slide ${index + 1}`}
                            />
                        ))}
                    </div>
                </div>
            </div>

            {/* Custom CSS untuk carousel effects */}
            <style dangerouslySetInnerHTML={{
                __html: `
                    .carousel-container {
                        perspective: 1000px;
                        touch-action: pan-y pinch-zoom;
                    }

                    .carousel-track {
                        transform-style: preserve-3d;
                        transition: transform 0.5s cubic-bezier(0.23, 1, 0.32, 1);
                    }

                    .carousel-item {
                        backface-visibility: hidden;
                        transition: all 0.5s cubic-bezier(0.23, 1, 0.32, 1);
                    }

                    .carousel-item.active {
                        opacity: 1;
                        transform: scale(1) translateZ(0);
                    }

                    @media (max-width: 640px) {
                        .carousel-item.prev {
                            opacity: 0;
                            transform: scale(0.8) translateX(-50%) translateZ(-100px);
                        }

                        .carousel-item.next {
                            opacity: 0;
                            transform: scale(0.8) translateX(50%) translateZ(-100px);
                        }
                    }

                    @media (min-width: 641px) {
                        .carousel-item.prev {
                            opacity: 0.7;
                            transform: scale(0.9) translateX(-100%) translateZ(-100px);
                        }

                        .carousel-item.next {
                            opacity: 0.7;
                            transform: scale(0.9) translateX(100%) translateZ(-100px);
                        }
                    }

                    .carousel-item.hidden {
                        opacity: 0;
                        transform: scale(0.8) translateZ(-200px);
                    }

                    .nav-button {
                        transition: all 0.3s;
                        background: rgba(255, 255, 255, 0.1);
                        backdrop-filter: blur(8px);
                        -webkit-backdrop-filter: blur(8px);
                        border: 1px solid rgba(255, 255, 255, 0.2);
                    }

                    @media (hover: hover) {
                        .nav-button:hover {
                            background: rgba(255, 255, 255, 0.2);
                            transform: scale(1.1);
                        }
                    }

                    .nav-button:active {
                        transform: scale(0.95);
                    }

                    .progress-bar {
                        transition: width 0.5s cubic-bezier(0.23, 1, 0.32, 1);
                    }
                `
            }} />
        </div>
    );
};

export default HeroSection;