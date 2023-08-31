<div class="sidebar">
    <ul class="sidebar-list">
        <li><a href="{{ route('home.index') }}" class="{{ request()->routeIs('home.*') ? 'active' : '' }}"><i class="fas fa-home"></i> Home</a></li>
        <li>
            <a href="{{ route('logout') }}"
               onclick="event.preventDefault(); document.getElementById('logout-form').submit();"><i class="fas fa-sign-out-alt"></i>
                {{ __('Logout') }}
            </a>
            <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
        </li>
    </ul>
</div>
