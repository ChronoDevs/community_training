<div class="sidebar">
    <ul class="sidebar-list">
        <li>
            <a href="{{ route('home.index') }}" class="{{ request()->routeIs('home.*') ? 'active' : '' }}">
                <i class="fas fa-home"></i> Home
            </a>
        </li>
        <li>
            <a href="{{ route('listings.index') }}" class="{{ request()->routeIs('listings.*') ? 'active' : '' }}">
                <i class="fas fa-list"></i> Listings
            </a>
        </li>
        <li>
            <a href="{{ route('tags.index') }}" class="{{ request()->routeIs('tags.*') ? 'active' : '' }}">
                <i class="fas fa-tags"></i> Tags
            </a>
        </li>
        <li>
            <a href="{{ route('faqs.index') }}" class="{{ request()->routeIs('faqs.*') ? 'active' : '' }}">
                <i class="fas fa-question-circle"></i> FAQs
            </a>
        </li>
        <li>
            <a href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                <i class="fas fa-sign-out-alt"></i> Logout
            </a>
            <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none"></form>
        </li>
    </ul>
</div>
