<div class="card sidebar-card">
    <div class="card-body sidebar-body">
        <ul class="sidebar-menu">
        <li class="sidebar-item {{ Route::currentRouteName() == 'admin.home' ? 'active' : '' }}"><a href="{{ route('admin.home') }}" class="sidebar-link"><i class="fa fa-home"></i> Dashboard</a></li>
            <li class="sidebar-item {{ Route::currentRouteName() == 'admin.users' ? 'active' : '' }}"><a href="{{ route('admin.users') }}" class="sidebar-link"><i class="fa fa-user"></i> Users</a></li>
            <li class="sidebar-item {{ Route::currentRouteName() == 'admin.posts' ? 'active' : '' }}"><a href="{{ route('admin.posts') }}" class="sidebar-link"><i class="fa fa-clipboard"></i> Posts</a></li>
            <li class="sidebar-item {{ Route::currentRouteName() == 'admin.categories' ? 'active' : '' }}"><a href="{{ route('admin.categories') }}" class="sidebar-link"><i class="fa fa-tags"></i> Category</a></li>
            <li class="sidebar-item {{ Route::currentRouteName() == 'admin.tags' ? 'active' : '' }}"><a href="{{ route('admin.tags') }}" class="sidebar-link"><i class="fa fa-tag"></i> Tags</a></li>
            <li class="sidebar-item"><a href="#" class="sidebar-link"><i class="fa fa-sign-out"></i> Log Out</a></li>
        </ul>
    </div>
</div>
