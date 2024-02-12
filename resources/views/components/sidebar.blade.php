<div class="main-sidebar sidebar-style-2">
    <aside id="sidebar-wrapper">
        <div class="sidebar-brand">
            <a href="{{ route('home') }}">
                <i class="fa fa-shop"></i> TOKOKU
            </a>
        </div>
        <div class="sidebar-brand sidebar-brand-sm">
            <a href="{{ route('home') }}">
                <i class="fa fa-shop"></i>
            </a>
        </div>
        <ul class="sidebar-menu">
            <li class="menu-header">Dashboard</li>
            <li class="{{ Request::is('home') ? 'active' : '' }}">
                <a href="{{ url('/home') }}">
                    <i class="fas fa-dashboard"></i><span>Dashboard</span>
                </a>
            </li>
            <li class="menu-header">Master</li>
            <li class="nav-item dropdown {{ Request::is('users*') ? 'active' : '' }}">
                <a href="#" class="nav-link has-dropdown"
                    data-toggle="dropdown"><i class="fas fa-users"></i>
                    <span>Users</span>
                </a>
                <ul class="dropdown-menu">
                    <li class="{{ Request::is('users') ? 'active' : '' }}">
                        <a class="nav-link" href="{{ route('users.index') }}">List Users</a>
                    </li>
                    <li class="{{ Request::is('users/create') ? 'active' : '' }}">
                        <a class="nav-link" href="{{ route('users.create') }}">Create User</a>
                    </li>
                </ul>
            </li>
            <li class="nav-item dropdown {{ Request::is('products*') ? 'active' : '' }}">
                <a href="#" class="nav-link has-dropdown"
                    data-toggle="dropdown"><i class="fas fa-box"></i>
                    <span>Products</span>
                </a>
                <ul class="dropdown-menu">
                    <li class="{{ Request::is('products') ? 'active' : '' }}">
                        <a class="nav-link" href="{{ route('products.index') }}">List Products</a>
                    </li>
                    <li class="{{ Request::is('products/create') ? 'active' : '' }}">
                        <a class="nav-link" href="{{ route('products.create') }}">Create Products</a>
                    </li>
                </ul>
            </li>
            <li class="nav-item dropdown {{ Request::is('categories*') ? 'active' : '' }}">
                <a href="#" class="nav-link has-dropdown"
                    data-toggle="dropdown"><i class="fas fa-list"></i>
                    <span>Category</span>
                </a>
                <ul class="dropdown-menu">
                    <li class="{{ Request::is('categories') ? 'active' : '' }}">
                        <a class="nav-link" href="{{ route('categories.index') }}">List category</a>
                    </li>
                    <li class="{{ Request::is('categories/create') ? 'active' : '' }}">
                        <a class="nav-link" href="{{ route('categories.create') }}">Create Category</a>
                    </li>
                </ul>
            </li>
        </ul>
    </aside>
</div>
