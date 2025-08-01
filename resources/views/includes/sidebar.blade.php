<nav id="sidebar" class="sidebar-wrapper">
    <div class="sidebarMenuScroll custom-scrollbar">
        <ul class="sidebar-menu">
            <li class="{{ request()->routeIs('dashboard') ? 'active current-page' : '' }}">
                <a href="{{ route('dashboard') }}">
                    <i class="bi bi-speedometer2"></i>
                    <span class="menu-text">Beranda</span>
                </a>
            </li>

            <!-- Manajemen Pengguna dengan Treeview -->
            <li class="treeview {{ request()->is('admin/role-permissions*') ? 'active current-page open' : '' }}">
                <a href="#" class="treeview-toggle">
                    <i class="bi bi-person-gear"></i>
                    <span class="menu-text">Manajemen Pengguna</span>
                </a>
                <ul class="treeview-menu"
                    style="{{ request()->is('admin/role-permissions*') ? 'display: block;' : 'display: none;' }}">
                    <li class="{{ request()->routeIs('permission.index') ? 'active-sub' : '' }}">
                        <a href="{{ route('permission.index') }}">Izin Akses</a>
                    </li>
                    <li class="{{ request()->routeIs('role.index') ? 'active-sub' : '' }}">
                        <a href="{{ route('role.index') }}">Peran</a>
                    </li>
                    <li class="{{ request()->routeIs('user.index') ? 'active-sub' : '' }}">
                        <a href="{{ route('user.index') }}">Pengguna</a>
                    </li>
                    <li class="{{ request()->routeIs('about-app.index') ? 'active-sub' : '' }}">
                        <a href="{{ route('about-app.index') }}">Tentang Aplikasi</a>
                    </li>
                </ul>
            </li>
            <li class="{{ request()->routeIs('profile.edit') ? 'active current-page' : '' }}">
                <a href="{{ route('profile.edit') }}">
                    <i class="bi bi-person"></i>
                    <span class="menu-text">Profil Saya</span>
                </a>
            </li>
            <li class="{{ request()->routeIs('courses.index') ? 'active current-page' : '' }}">
                <a href="{{ route('courses.index') }}">
                    <i class="bi bi-book"></i>
                    <span class="menu-text">Mata Kuliah</span>
                </a>
            </li>
            <li class="{{ request()->routeIs('lecturers.index') ? 'active current-page' : '' }}">
                <a href="{{ route('lecturers.index') }}">
                    <i class="bi bi-person-badge"></i>
                    <span class="menu-text">Dosen</span>
                </a>
            </li>
            <li class="{{ request()->routeIs('general_information.index') ? 'active current-page' : '' }}">
                <a href="{{ route('general_information.index') }}">
                    <i class="bi bi-info-square"></i>
                    <span class="menu-text">Informasi Umum</span>
                </a>
            </li>
            <li class="{{ request()->routeIs('graduate_learning_outcomes.index') ? 'active current-page' : '' }}">
                <a href="{{ route('graduate_learning_outcomes.index') }}">
                    <i class="bi bi-mortarboard"></i>
                    <span class="menu-text">Capaian Pembelajaran Lulusan</span>
                </a>
            </li>
            <li class="{{ request()->routeIs('virtuals.index') ? 'active current-page' : '' }}">
                <a href="{{ route('virtuals.index') }}">
                    <i class="bi bi-camera-video"></i>
                    <span class="menu-text">Konten Virtual</span>
                </a>
            </li>
            <li class="{{ request()->routeIs('categories.index') ? 'active current-page' : '' }}">
                <a href="{{ route('categories.index') }}">
                    <i class="bi bi-list-check"></i>
                    <span class="menu-text">Kategori</span>
                </a>
            </li>
            <li class="{{ request()->routeIs('articles.index') ? 'active current-page' : '' }}">
                <a href="{{ route('articles.index') }}">
                    <i class="bi bi-file-earmark-text"></i>
                    <span class="menu-text">Artikel</span>
                </a>
            </li>
        </ul>
    </div>
</nav>