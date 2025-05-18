<aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a href="{{ url('/') }}" class="brand-link">
        <i class="fas fa-cogs ml-3 mr-2"></i>
        <span class="brand-text font-weight-light">My Admin Panel</span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">

        <!-- Sidebar Menu -->
        <nav class="mt-2">
            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">

                <!-- Dashboard -->
                <li class="nav-item">
                    <a href="{{ url('/') }}" class="nav-link {{ request()->is('/') ? 'active' : '' }}">
                        <i class="nav-icon fas fa-home"></i>
                        <p>Dashboard</p>
                    </a>
                </li>
                @auth
                    <!-- Content Management -->
                    @can('contentManagement')
                        <li
                            class="nav-item has-treeview {{ request()->is('posts*') || request()->is('categories*') ? 'menu-open' : '' }}">
                            <a href="#"
                                class="nav-link {{ request()->is('posts*') || request()->is('categories*') ? 'active' : '' }}">
                                <i class="nav-icon fas fa-folder-open"></i>
                                <p>
                                    Content Management
                                    <i class="right fas fa-angle-left"></i>
                                </p>
                            </a>
                            <ul class="nav nav-treeview">
                                @can('posts')
                                    <li class="nav-item">
                                        <a href="{{ route('posts.index') }}"
                                            class="nav-link {{ request()->is('posts*') ? 'active' : '' }}">
                                            <i class="far fa-file-alt nav-icon"></i>
                                            <p>Posts</p>
                                        </a>
                                    </li>
                                @endcan

                                @can('categories')
                                    <li class="nav-item">
                                        <a href="{{ route('categories.index') }}"
                                            class="nav-link {{ request()->is('categories*') ? 'active' : '' }}">
                                            <i class="far fa-list-alt nav-icon"></i>
                                            <p>Categories</p>
                                        </a>
                                    </li>
                                @endcan

                            </ul>
                        </li>
                    @endcan


                    <!-- Access Control -->
                    @can('accessControl')
                        <li
                            class="nav-item has-treeview {{ request()->is('roles*') || request()->is('permissions*') ? 'menu-open' : '' }}">
                            <a href="#"
                                class="nav-link {{ request()->is('roles*') || request()->is('permissions*') ? 'active' : '' }}">
                                <i class="nav-icon fas fa-shield-alt"></i>
                                <p>
                                    Access Control
                                    <i class="right fas fa-angle-left"></i>
                                </p>
                            </a>
                            <ul class="nav nav-treeview">
                                @can('roles')
                                    <li class="nav-item">
                                        <a href="{{ route('roles.index') }}"
                                            class="nav-link {{ request()->is('roles*') ? 'active' : '' }}">
                                            <i class="fas fa-user-shield nav-icon"></i>
                                            <p>Roles</p>
                                        </a>
                                    </li>
                                @endcan
                                @can('permissions')
                                    <li class="nav-item">
                                        <a href="{{ route('permissions.index') }}"
                                            class="nav-link {{ request()->is('permissions*') ? 'active' : '' }}">
                                            <i class="fas fa-lock nav-icon"></i>
                                            <p>Permissions</p>
                                        </a>
                                    </li>
                                @endcan
                            </ul>
                        </li>
                    @endcan


                    <!-- User Management -->
                    @can('userManagement')
                        <li class="nav-item has-treeview {{ request()->is('users*') ? 'menu-open' : '' }}">
                            <a href="#" class="nav-link {{ request()->is('users*') ? 'active' : '' }}">
                                <i class="nav-icon fas fa-users"></i>
                                <p>
                                    User Management
                                    <i class="right fas fa-angle-left"></i>
                                </p>
                            </a>
                            <ul class="nav nav-treeview">
                                @can('users')
                                    <li class="nav-item">
                                        <a href="{{ route('users.index') }}"
                                            class="nav-link {{ request()->is('users') ? 'active' : '' }}">
                                            <i class="fas fa-user nav-icon"></i>
                                            <p>Activated Users</p>
                                        </a>
                                    </li>
                                @endcan
                                @can('archivedUsers')
                                    <li class="nav-item">
                                        <a href="{{ route('users.archived') }}"
                                            class="nav-link {{ request()->is('users/archived') ? 'active' : '' }}">
                                            <i class="fas fa-archive nav-icon"></i>
                                            <p>Archived Users</p>
                                        </a>
                                    </li>
                                @endcan
                                <li class="nav-item">
                                    <a href="{{ route('users.all-with-status') }}"
                                        class="nav-link {{ request()->is('users/all-with-status') ? 'active' : '' }}">
                                        <i class="fas fa-users nav-icon"></i>
                                        <p>All Users</p>
                                    </a>
                                </li>

                            </ul>
                        </li>
                    @endcan
                    @can('activityLogs')
                        <li
                            class="nav-item has-treeview {{ request()->is('logs/posts') || request()->is('logs/users') ? 'menu-open' : '' }}">
                            <a href="#"
                                class="nav-link {{ request()->is('logs/posts') || request()->is('logs/users') ? 'active' : '' }}">
                                <i class="nav-icon fas fa-clipboard-list"></i>
                                <p>
                                    Activity Logs
                                    <i class="right fas fa-angle-left"></i>
                                </p>
                            </a>

                            <ul class="nav nav-treeview">
                                @can('postsLogs')
                                    <li class="nav-item">
                                        <a href="{{ route('logs.posts') }}"
                                            class="nav-link {{ request()->is('logs/posts') ? 'active' : '' }}">
                                            <i class="fas fa-file-alt nav-icon"></i>
                                            <p>Posts Logs</p>
                                        </a>
                                    </li>
                                @endcan
                                @can('usersLogs')
                                    <li class="nav-item">
                                        <a href="{{ route('logs.users') }}"
                                            class="nav-link {{ request()->is('logs/users') ? 'active' : '' }}">
                                            <i class="fas fa-user-check nav-icon"></i>
                                            <p>Users Logs</p>
                                        </a>
                                    </li>
                                @endcan
                                @can('rolesLogs')
                                    <li class="nav-item">
                                        <a href="{{ route('logs.roles') }}"
                                            class="nav-link {{ request()->is('logs/roles') ? 'active' : '' }}">
                                            <i class="fas fa-user-tag nav-icon"></i>
                                            <p>Roles Logs</p>
                                        </a>
                                    </li>
                                @endcan


                            </ul>
                        </li>
                    @endcan


                    <!-- Logout -->

                    <li class="nav-item">
                        <a href="{{ route('logout') }}"
                            onclick="event.preventDefault(); document.getElementById('logout-form').submit();"
                            class="nav-link text-danger">
                            <i class="nav-icon fas fa-sign-out-alt"></i>
                            <p>Logout</p>
                        </a>
                        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                            @csrf
                        </form>
                    </li>
                @endauth

            </ul>
        </nav>
    </div>
</aside>
