import { Link } from "@inertiajs/react";
import React, { useEffect, useState } from "react";

interface HeaderProps {
  isDropdownOpen: boolean;
  setIsDropdownOpen: (open: boolean) => void;
}

const Header: React.FC<HeaderProps> = ({ isDropdownOpen, setIsDropdownOpen }) => {
  const [isScrolled, setIsScrolled] = useState(false);

  useEffect(() => {
    const handleScroll = () => {
      setIsScrolled(window.scrollY > 50);
    };

    const handleKeyPress = (event: KeyboardEvent) => {
      if (isDropdownOpen) {
        setIsDropdownOpen(false);
      }
    };

    window.addEventListener("scroll", handleScroll);
    window.addEventListener("keydown", handleKeyPress);

    return () => {
      window.removeEventListener("scroll", handleScroll);
      window.removeEventListener("keydown", handleKeyPress);
    };
  }, [isDropdownOpen, setIsDropdownOpen]);

  return (
    <nav
      className={`navbar text-neutral-content shadow-md fixed top-0 left-0 w-full z-50 transition-all duration-300 ${isScrolled ? "backdrop-blur-lg bg-opacity-70 bg-neutral" : "bg-neutral"}`}
    >
      <div className="navbar-start">
        <div className="dropdown">
          <button
            tabIndex={0}
            className="btn btn-ghost lg:hidden"
            onClick={() => setIsDropdownOpen(!isDropdownOpen)}
          >
            <svg
              xmlns="http://www.w3.org/2000/svg"
              className="h-5 w-5"
              fill="none"
              viewBox="0 0 24 24"
              stroke="currentColor"
            >
              <path
                strokeLinecap="round"
                strokeLinejoin="round"
                strokeWidth="2"
                d="M4 6h16M4 12h8m-8 6h16"
              />
            </svg>
          </button>
          {isDropdownOpen && (
            <ul
              tabIndex={0}
              className="menu menu-sm dropdown-content bg-base-100 rounded-box z-10 mt-3 w-52 p-2 shadow"
            >
              <li>
                <Link
                  href="/"
                  onClick={() => setIsDropdownOpen(false)}
                  className="mb-1 btn btn-ghost text-primary font-bold"
                >
                  Beranda
                </Link>
              </li>
              <li>
                <Link
                  href="/lecturers"
                  onClick={() => setIsDropdownOpen(false)}
                  className="mb-1 btn btn-ghost text-primary"
                >
                  Pengajar Kami
                </Link>
              </li>
              <li>
                <Link
                  href="/courses"
                  onClick={() => setIsDropdownOpen(false)}
                  className="mb-1 btn btn-ghost text-primary"
                >
                  Peta Kurikulum
                </Link>
              </li>
              <li>
                <Link
                  href="/virtual-tours"
                  onClick={() => setIsDropdownOpen(false)}
                  className="mb-1 btn btn-ghost text-primary"
                >
                  Virtual Tours
                </Link>
              </li>
              <li>
                <Link
                  href="/articles"
                  onClick={() => setIsDropdownOpen(false)}
                  className="mb-1 btn btn-ghost text-primary"
                >
                  Artikel
                </Link>
              </li>
              <li>
                <a
                  href="https://journal.unifa.ac.id/"
                  target="_blank"
                  rel="noopener noreferrer"
                  onClick={() => setIsDropdownOpen(false)}
                  className="mb-1 btn btn-ghost text-primary"
                >
                  E-Journal
                </a>
              </li>
              {/* Tambahkan Tentang Kami */}
              <li>
                <Link
                  href="/about-us"
                  onClick={() => setIsDropdownOpen(false)}
                  className="mb-1 btn btn-ghost text-primary"
                >
                  Tentang Kami
                </Link>
              </li>
              <li>
                <a
                  href="https://simba.unifa.ac.id/"
                  target="_blank"
                  rel="noopener noreferrer"
                  onClick={() => setIsDropdownOpen(false)}
                  className="mb-1 btn btn-ghost text-primary"
                >
                  Pendaftaran Maba
                </a>
              </li>
            </ul>
          )}
        </div>

        <Link href="/" className="btn btn-ghost text-xl flex items-center p-0 bg-white">
          <img
            src="/assets/images/logo.png"
            alt="Logo"
            className="h-10 w-auto object-contain"
          />
        </Link>
      </div>

      <div className="navbar-center hidden lg:flex">
        <ul className="menu menu-horizontal px-1">
          <li>
            <Link href="/" className="btn btn-ghost text-primary">Beranda</Link>
          </li>
          <li>
            <Link href="/lecturers" className="btn btn-ghost text-primary">Dosen Kami</Link>
          </li>
          <li>
            <Link href="/courses" className="btn btn-ghost text-primary">Peta Kurikulum</Link>
          </li>
          <li>
            <Link href="/virtual-tours" className="btn btn-ghost text-primary">Virtual Tours</Link>
          </li>
          <li>
            <Link href="/articles" className="btn btn-ghost text-primary">Artikel</Link>
          </li>
          <li>
            <a href="https://journal.unifa.ac.id/" target="_blank" rel="noopener noreferrer" className="btn btn-ghost text-primary">E-Journal</a>
          </li>
          {/* Tambahkan Tentang Kami */}
          <li>
            <Link href="/about-us" className="btn btn-ghost text-primary">Tentang Kami</Link>
          </li>
          <li>
            <a href="https://simba.unifa.ac.id/" target="_blank" rel="noopener noreferrer" className="btn btn-ghost text-primary">Pendaftaran Maba</a>
          </li>
        </ul>
      </div>
    </nav>
  );
};

export default Header;
