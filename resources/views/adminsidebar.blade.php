<div class="card sidebar-card">
    <div class="card-body sidebar-body">
        <ul class="sidebar-menu">
        <li class="sidebar-item {{ Route::currentRouteName() == 'admin.dashboard.index' ? 'active' : '' }}"><a href="{{ route('admin.dashboard.index') }}" class="sidebar-link"><i class="fa fa-home"></i> Dashboard</a></li>
            <li class="sidebar-item {{ Route::currentRouteName() == 'admin.users.index' ? 'active' : '' }}"><a href="{{ route('admin.users.index') }}" class="sidebar-link"><i class="fa fa-user"></i> Users</a></li>
            <li class="sidebar-item {{ Route::currentRouteName() == 'admin.posts.index' ? 'active' : '' }}"><a href="{{ route('admin.posts.index') }}" class="sidebar-link"><i class="fa fa-clipboard"></i> Posts</a></li>
            <li class="sidebar-item {{ Route::currentRouteName() == 'admin.category.index' ? 'active' : '' }}"><a href="{{ route('admin.category.index') }}" class="sidebar-link"><i class="fa fa-tags"></i> Category</a></li>
            <li class="sidebar-item {{ Route::currentRouteName() == 'admin.tags.index' ? 'active' : '' }}"><a href="{{ route('admin.tags.index') }}" class="sidebar-link"><i class="fa fa-tag"></i> Tags</a></li>
            <li class="sidebar-item"><a href="#" class="sidebar-link"><i class="fa fa-sign-out"></i> Log Out</a></li>
        </ul>
    </div>
</div>
