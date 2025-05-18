 <aside class="main-sidebar sidebar-dark-primary elevation-4">
     <a href="#" class="brand-link">
         <span class="brand-text font-weight-light">My Blog Admin</span>
     </a>

     <div class="sidebar">
         <nav class="mt-2">
             <ul class="nav nav-pills nav-sidebar flex-column" role="menu">
                 <li class="nav-item">
                     <a href="{{ url('/') }}" class="nav-link">
                         <i class="nav-icon fas fa-home"></i>
                         <p>Home</p>
                     </a>
                 </li>
                 @auth
                     @can('categories')
                         <li class="nav-item">
                             <a href="{{ route('categories.index') }}"
                                 class="nav-link {{ request()->is('categories*') ? 'active' : '' }}">
                                 <i class="nav-icon fas fa-folder-open"></i>
                                 <p>Categories</p>
                             </a>
                         </li>
                     @endcan

                     @can('posts')
                         <li class="nav-item">
                             <a href="{{ route('posts.index') }}"
                                 class="nav-link {{ request()->is('posts*') ? 'active' : '' }}">
                                 <i class="nav-icon fas fa-file-alt"></i>
                                 <p>Posts</p>
                             </a>
                         </li>
                     @endcan
                     @can('users')
                         <li class="nav-item">
                             <a href="{{ route('users.index') }}"
                                 class="nav-link {{ request()->routeIs('users.*') && !request()->routeIs('users.archived') ? 'active' : '' }}">
                                 <i class="nav-icon fas fa-users-cog"></i>
                                 <p>Users</p>
                             </a>
                         </li>
                     @endcan

                     @can('archivedUsers')
                         <li class="nav-item">
                             <a href="{{ route('users.archived') }}"
                                 class="nav-link {{ request()->routeIs('users.archived') ? 'active' : '' }}">
                                 <i class="nav-icon fas fa-box-open"></i>
                                 <p>Archived Users</p>
                             </a>
                         </li>
                     @endcan
                     @can('permissions')
                         <li class="nav-item">
                             <a href="{{ route('permissions.index') }}"
                                 class="nav-link {{ request()->is('permissions*') ? 'active' : '' }}">
                                 <i class="nav-icon fas fa-shield-alt"></i>
                                 <p>Permissions</p>
                             </a>
                         </li>
                     @endcan

                     @can('roles')
                         <li class="nav-item">
                             <a href="{{ route('roles.index') }}"
                                 class="nav-link {{ request()->is('roles*') ? 'active' : '' }}">
                                 <i class="nav-icon fas fa-user-shield"></i>
                                 <p>Roles</p>
                             </a>
                         </li>
                     @endcan


                 @endauth

             </ul>
         </nav>
     </div>
 </aside>
