<nav class="navbar navbar-expand-lg navbar-dark bg-primary">
    <div class="container">
        <a class="navbar-brand" href="{{ url('/site') }}">MyBlog</a>

        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarNav">

            {{-- Left side --}}
            <ul class="navbar-nav me-auto">
                {{-- Categories Dropdown --}}
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button"
                        data-bs-toggle="dropdown">
                        Categories
                    </a>
                    <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
                        @foreach ($siteCategories as $category)
                            <li>
                                <a class="dropdown-item" href="{{ route('site.category.show', $category->name) }}">
                                    {{ $category->name }}
                                </a>
                            </li>
                        @endforeach
                    </ul>
                </li>

                {{-- Posts link --}}
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('site.posts.index') }}">Posts</a>
                </li>
            </ul>

            {{-- Right side --}}
            <ul class="navbar-nav ms-auto">
                @guest('site')
                    <!-- if NOT logged in -->
                    <li class="nav-item">
                        <a href="{{ route('site.login') }}" class="btn btn-light me-2">Login</a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('site.register') }}" class="btn btn-outline-light">Register</a>
                    </li>
                @else
                    <!-- if LOGGED in -->
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button"
                            data-bs-toggle="dropdown">
                            {{ auth('site')->user()->name }}
                        </a>
                        <ul class="dropdown-menu dropdown-menu-end shadow" aria-labelledby="userDropdown">
                            <!-- View Profile -->
                            <li>
                                <a class="dropdown-item d-flex align-items-center" href="{{ route('profile.show') }}">
                                    <i class="bi bi-person-circle me-2"></i> View Profile
                                </a>
                            </li>

                            <!-- Change Password -->
                            <li>
                                <a class="dropdown-item d-flex align-items-center"
                                    href="{{ route('profile.password.form') }}">
                                    <i class="bi bi-shield-lock me-2"></i> Change Password
                                </a>
                            </li>

                            <li>
                                <hr class="dropdown-divider">
                            </li>

                            <!-- Logout -->
                            <li>
                                <form action="{{ route('site.logout') }}" method="POST" class="d-inline">
                                    @csrf
                                    <button type="submit"
                                        class="dropdown-item d-flex align-items-center text-danger fw-bold">
                                        <i class="bi bi-box-arrow-right me-2"></i> Logout
                                    </button>
                                </form>
                            </li>
                        </ul>

                    </li>
                @endguest
            </ul>
        </div>
    </div>
</nav>
