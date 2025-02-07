import { Link } from "@inertiajs/react";
import React from "react";

const Header: React.FC = () => {
  return (
    <nav className="navbar bg-base-100 shadow-md">
      <div className="navbar-start">
        {/* Dropdown Mobile */}
        <div className="dropdown">
          <button tabIndex={0} className="btn btn-ghost lg:hidden">
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
          <ul
            tabIndex={0}
            className="menu menu-sm dropdown-content bg-base-100 rounded-box z-10 mt-3 w-52 p-2 shadow"
          >
            <li>
              <Link href="/">Beranda</Link>
            </li>
            <li>
              <Link href="/home/lecturers">Dosen Kami</Link>
            </li>
            <li>
              <details>
                <summary>Menu</summary>
                <ul className="p-2">
                  <li>
                    <a>Submenu 1</a>
                  </li>
                  <li>
                    <a>Submenu 2</a>
                  </li>
                </ul>
              </details>
            </li>
          </ul>
        </div>

        {/* Logo / Home */}
        <Link href="/home" className="btn btn-ghost text-xl">
          Nama Universitas
        </Link>
      </div>

      {/* Navbar Tengah (Desktop) */}
      <div className="navbar-center hidden lg:flex">
        <ul className="menu menu-horizontal px-1">
          <li>
            <Link href="/home">Beranda</Link>
          </li>
          <li>
            <Link href="/home/lecturers">Dosen Kami</Link>
          </li>
          <li>
            <details>
              <summary>Menu</summary>
              <ul className="p-2">
                <li>
                  <a>Submenu 1</a>
                </li>
                <li>
                  <a>Submenu 2</a>
                </li>
              </ul>
            </details>
          </li>
        </ul>
      </div>

      {/* Navbar End (Login/Register) */}
      <div className="navbar-end">
        <Link href="/login" className="btn btn-primary">
          Masuk
        </Link>
      </div>
    </nav>
  );
};

export default Header;
