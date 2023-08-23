<aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a href="index3.html" class="brand-link">
        <img src="http://placehold.co/128x128" alt="Airbt Logo" class="brand-image img-circle elevation-3"
            style="opacity: .8">
        <span class="brand-text font-weight-light">Airbft</span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">
        <!-- Sidebar user panel (optional) -->
        <div class="user-panel mt-3 pb-3 mb-3 d-flex">
            <div class="image">
                <img src="http://placehold.co/160x160" class="img-circle elevation-2" alt="User Image">
            </div>
            <div class="info">
                <a href="#" class="d-block">Admin</a>
            </div>
        </div>

        <!-- SidebarSearch Form -->
        <div class="form-inline">
            <div class="input-group" data-widget="sidebar-search">
                <input class="form-control form-control-sidebar" type="search" placeholder="Search"
                    aria-label="Search">
                <div class="input-group-append">
                    <button class="btn btn-sidebar">
                        <i class="fas fa-search fa-fw"></i>
                    </button>
                </div>
            </div>
        </div>

        <!-- Sidebar Menu -->
        <nav class="mt-2">
            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu"
                data-accordion="false">
                <!-- Add icons to the links using the .nav-icon class
       with font-awesome or any other icon font library -->
                {{-- <li class="nav-item">
                    <a href="/dashboard" class="nav-link">
                        <i class="nav-icon fas fa-th"></i>
                        <p>
                            Dashboard
                        </p>
                    </a>
                </li> --}}
                <li class="nav-item">
                    <a href="#" class="nav-link">
                        {{-- <i class="nav-icon fas fa-tachometer-alt"></i> --}}
                        <p>
                            Main Page
                            <i class="right fas fa-angle-left"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="{{ route('main_page', ['mainPage' => 'home']) }}" class="nav-link">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Home</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('main_page', ['mainPage' => 'about-us']) }}" class="nav-link">
                                <i class="far fa-circle nav-icon"></i>
                                <p>About-us</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('main_page', ['mainPage' => 'contact']) }}" class="nav-link">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Contact</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('main_page', ['mainPage' => 'portfolio']) }}" class="nav-link">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Portfolio</p>
                            </a>
                        </li>
                    </ul>
                </li>
                <li class="nav-item">
                    <a href="#" class="nav-link">
                        {{-- <i class="nav-icon fas fa-tachometer-alt"></i> --}}
                        <p>
                            Article
                            <i class="right fas fa-angle-left"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="{{ route('article.index') }}" class="nav-link">
                                <i class="far fa-circle nav-icon"></i>
                                <p>All Article</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="javascript:;" class="nav-link" data-toggle="modal" data-target="#modalAddArticle">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Add Article</p>
                            </a>
                        </li>
                    </ul>
                </li>
                <li class="nav-item">
                    <a href="{{ route('category-product.index') }}" class="nav-link">
                        {{-- <i class="nav-icon fas fa-tachometer-alt"></i> --}}
                        <p>
                            Category Product
                        </p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('product.index') }}" class="nav-link">
                        {{-- <i class="nav-icon fas fa-tachometer-alt"></i> --}}
                        <p>
                            Product
                        </p>
                    </a>
                </li>
                {{-- <li class="nav-item">
                    <a href="{{ route('article.index') }}" class="nav-link">
                        <i class="nav-icon fas fa-tachometer-alt"></i>
                        <p>
                            Article
                        </p>
                    </a>
                </li> --}}
                {{-- <li class="nav-header">EXAMPLES</li> --}}
            </ul>
        </nav>
        <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
</aside>
