<nav id="sidebar" class="sidebar-wrapper">
    <div class="sidebarMenuScroll custom-scrollbar">
        <ul class="sidebar-menu">
            <li class="{{ request()->routeIs('dashboard') ? 'active current-page' : '' }}">
                <a href="{{ route('dashboard') }}">
                    <i class="bi bi-speedometer2"></i>
                    <span class="menu-text">Dashboard</span>
                </a>
            </li>
            <li class="treeview {{ request()->is('mbkm/admin/role-permissions*') ? 'active current-page open' : '' }}">
                <a href="#" class="treeview-toggle">
                    <i class="bi bi-person-gear"></i>
                    <span class="menu-text">Manajemen Pengguna</span>
                </a>
                <ul class="treeview-menu"
                    style="{{ request()->is('admin/role-permissions*') ? 'display: block;' : 'display: none;' }}">
                    <li class="{{ request()->routeIs('permission.index') ? 'active-sub' : '' }}">
                        <a href="{{ route('permission.index') }}">Permissions</a>
                    </li>
                    <li class="{{ request()->routeIs('role.index') ? 'active-sub' : '' }}">
                        <a href="{{ route('role.index') }}">Role</a>
                    </li>
                    <li class="{{ request()->routeIs('user.index') ? 'active-sub' : '' }}">
                        <a href="{{ route('user.index') }}">Users</a>
                    </li>
                    <li class="{{ request()->routeIs('about-app.index') ? 'active-sub' : '' }}">
                        <a href="{{ route('about-app.index') }}">Tentang Aplikasi</a>
                    </li>
                </ul>
                <li class="{{ request()->routeIs('profile.edit') ? 'active current-page' : '' }}">
                    <a href="{{ route('profile.edit') }}">
                        <i class="bi bi-person"></i>
                        <span class="menu-text">Manajemen Profil</span>
                    </a>
                </li>
            </li>
            <li class="treeview {{ request()->is('courses*') ? 'active current-page open' : '' }}">
                <a href="#" class="treeview-toggle">
                    <i class="bi bi-book"></i>
                    <span class="menu-text">Manajemen Mata Kuliah</span>
                </a>
                <ul class="treeview-menu"
                    style="{{ request()->is('courses*') ? 'display: block;' : 'display: none;' }}">
                    <li class="{{ request()->routeIs('courses.index') ? 'active-sub' : '' }}">
                        <a href="{{ route('courses.index') }}">Daftar Mata Kuliah</a>
                    </li>
                    <li class="{{ request()->routeIs('courses.create') ? 'active-sub' : '' }}">
                        <a href="{{ route('courses.create') }}">Tambah Mata Kuliah</a>
                    </li>
                </ul>
            </li>
            <li class="treeview {{ request()->is('lecturers*') ? 'active current-page open' : '' }}">
                <a href="#" class="treeview-toggle">
                    <i class="bi bi-person"></i>
                    <span class="menu-text">Manajemen Dosen</span>
                </a>
                <ul class="treeview-menu"
                    style="{{ request()->is('lecturers*') ? 'display: block;' : 'display: none;' }}">
                    <li class="{{ request()->routeIs('lecturers.index') ? 'active-sub' : '' }}">
                        <a href="{{ route('lecturers.index') }}">Daftar Dosen</a>
                    </li>
                    <li class="{{ request()->routeIs('lecturers.create') ? 'active-sub' : '' }}">
                        <a href="{{ route('lecturers.create') }}">Tambah Dosen</a>
                    </li>
                </ul>
            </li>
            <li class="treeview {{ request()->is('general-information*') ? 'active current-page open' : '' }}">
                <a href="#" class="treeview-toggle">
                    <i class="bi bi-info-circle"></i>
                    <span class="menu-text">Informasi Umum</span>
                </a>
                <ul class="treeview-menu"
                    style="{{ request()->is('general_information*') ? 'display: block;' : 'display: none;' }}">
                    <li class="{{ request()->routeIs('general_information.index') ? 'active-sub' : '' }}">
                        <a href="{{ route('general_information.index') }}">Daftar Informasi Umum</a>
                    </li>
                    <li class="{{ request()->routeIs('general-information.create') ? 'active-sub' : '' }}">
                        <a href="{{ route('general_information.create') }}">Tambah Informasi Umum</a>
                    </li>
                </ul>
            </li>
            <li class="treeview {{ request()->is('virtuals*') ? 'active current-page open' : '' }}">
                <a href="#" class="treeview-toggle">
                    <i class="bi bi-camera-video"></i>
                    <span class="menu-text">Virtual Content</span>
                </a>
                <ul class="treeview-menu"
                    style="{{ request()->is('virtuals*') ? 'display: block;' : 'display: none;' }}">
                    <li class="{{ request()->routeIs('virtuals.index') ? 'active-sub' : '' }}">
                        <a href="{{ route('virtuals.index') }}">List Virtual Content</a>
                    </li>
                    <li class="{{ request()->routeIs('virtuals.create') ? 'active-sub' : '' }}">
                        <a href="{{ route('virtuals.create') }}">Add Virtual Content</a>
                    </li>
                </ul>
            </li>
            <li class="treeview {{ request()->is('categories*') ? 'active current-page open' : '' }}">
                <a href="#" class="treeview-toggle">
                    <i class="bi bi-list-check"></i>
                    <span class="menu-text">Categories</span>
                </a>
                <ul class="treeview-menu"
                    style="{{ request()->is('categories*') ? 'display: block;' : 'display: none;' }}">
                    <li class="{{ request()->routeIs('categories.index') ? 'active-sub' : '' }}">
                        <a href="{{ route('categories.index') }}">List Categories</a>
                    </li>
                    <li class="{{ request()->routeIs('categories.create') ? 'active-sub' : '' }}">
                        <a href="{{ route('categories.create') }}">Add Category</a>
                    </li>
                </ul>
            </li>
            <li class="treeview {{ request()->is('articles*') ? 'active current-page open' : '' }}">
                <a href="#" class="treeview-toggle">
                    <i class="bi bi-file-earmark-text"></i>
                    <span class="menu-text">Articles</span>
                </a>
                <ul class="treeview-menu"
                    style="{{ request()->is('articles*') ? 'display: block;' : 'display: none;' }}">
                    <li class="{{ request()->routeIs('articles.index') ? 'active-sub' : '' }}">
                        <a href="{{ route('articles.index') }}">List Articles</a>
                    </li>
                    <li class="{{ request()->routeIs('articles.create') ? 'active-sub' : '' }}">
                        <a href="{{ route('articles.create') }}">Add Articles</a>
                    </li>
                </ul>
            </li>
        </ul>

    </div>
    <!-- Sidebar menu ends -->
</nav>