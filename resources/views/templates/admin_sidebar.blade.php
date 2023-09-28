<div class="card sidebar-card">
    <div class="card-body sidebar-body">
        <ul class="sidebar-menu">
            <li class="sidebar-item {{ Route::currentRouteName() == 'admin.dashboard.index' ? 'active' : '' }}" onclick="window.location.href='{{ route('admin.dashboard.index') }}'">
                <button type="button" class="sidebar-button">
                    <i class="fa fa-home"></i> Dashboard
                </button>
            </li>
            <li class="sidebar-item {{ Route::currentRouteName() == 'admin.users.index' ? 'active' : '' }}" onclick="window.location.href='{{ route('admin.users.index') }}'">
                <button type="button" class="sidebar-button">
                    <i class="fa fa-user"></i> Users
                </button>
            </li>
            <li class="sidebar-item {{ Route::currentRouteName() == 'admin.posts.index' ? 'active' : '' }}" onclick="window.location.href='{{ route('admin.posts.index') }}'">
                <button type="button" class="sidebar-button">
                    <i class="fa fa-clipboard"></i> Posts
                </button>
            </li>
            <li class="sidebar-item {{ Route::currentRouteName() == 'admin.category.index' ? 'active' : '' }}" onclick="window.location.href='{{ route('admin.category.index') }}'">
                <button type="button" class="sidebar-button">
                    <i class="fa fa-tags"></i> Category
                </button>
            </li>
            <li class="sidebar-item {{ Route::currentRouteName() == 'admin.tags.index' ? 'active' : '' }}" onclick="window.location.href='{{ route('admin.tags.index') }}'">
                <button type="button" class="sidebar-button">
                    <i class="fa fa-tag"></i> Tags
                </button>
            </li>
            <li class="sidebar-item" onclick="document.querySelector('.sidebar-form').submit();">
                <form method="POST" action="{{ route('admin.logout') }}" class="sidebar-form">
                    @csrf
                    <button type="submit" class="sidebar-button">
                        <i class="fa fa-sign-out"></i> Log Out
                    </button>
                </form>
            </li>
        </ul>
    </div>
</div>
