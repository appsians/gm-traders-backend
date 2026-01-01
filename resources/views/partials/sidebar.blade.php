<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

<nav class="sidebar">
    <div class="sidebar-header">
        <a href="#" class="sidebar-brand">
            BGM<span>Traders</span>
        </a>
        <div class="sidebar-toggler not-active">
            <span></span>
            <span></span>
            <span></span>
        </div>
    </div>
    <div class="sidebar-body" id="sidebarMenu">
        <ul class="nav">
            {{-- Dashboard --}}
            <li class="nav-item {{ request()->routeIs('dashboard') ? 'active' : '' }}">
                <a href="{{ route('dashboard') }}" class="nav-link">
                    <i class="fa-solid fa-gauge link-icon"></i>
                    <span class="link-title">Dashboard</span>
                </a>
            </li>


                <li class="nav-item {{ request()->routeIs('users') ? 'active' : '' }}">
                <a href="{{ route('users') }}" class="nav-link">
                    <i class="fa-solid fa-users"></i>
                    <span class="link-title">Users</span>
                </a>
            </li>

            {{-- Products Category --}}
            <li class="nav-item nav-category">Products</li>

            {{-- Fruits --}}
            @php
                $isFruitRoute = request()->routeIs('add_fruits') || request()->routeIs('all_fruits') || request()->routeIs('edit_fruit');
            @endphp
            <li class="nav-item {{ $isFruitRoute ? 'active' : '' }}">
                <a class="nav-link {{ $isFruitRoute ? '' : 'collapsed' }}"
                   data-bs-toggle="collapse"
                   href="#fruitMenu"
                   role="button"
                   aria-expanded="{{ $isFruitRoute ? 'true' : 'false' }}"
                   aria-controls="fruitMenu">
                    <i class="fa-solid fa-apple-whole link-icon"></i>
                    <span class="link-title">Fruits</span>
                    <i class="link-arrow" data-feather="chevron-down"></i>
                </a>
                <div class="collapse {{ $isFruitRoute ? 'show' : '' }}" id="fruitMenu">
                    <ul class="nav sub-menu">
                        <li class="nav-item">
                            <a href="{{ route('add_fruits') }}" class="nav-link {{ request()->routeIs('add_fruits') ? 'active' : '' }}">Create</a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('all_fruits') }}" class="nav-link {{ request()->routeIs('all_fruits') || request()->routeIs('edit_fruit') ? 'active' : '' }}">All Fruits</a>
                        </li>
                    </ul>
                </div>
            </li>

            {{-- Banners --}}
            @php
                $isBannerRoute = request()->routeIs('add_banner') || request()->routeIs('all_banner') || request()->routeIs('edit_banner');
            @endphp
            <li class="nav-item {{ $isBannerRoute ? 'active' : '' }}">
                <a class="nav-link {{ $isBannerRoute ? '' : 'collapsed' }}"
                   data-bs-toggle="collapse"
                   href="#bannerMenu"
                   role="button"
                   aria-expanded="{{ $isBannerRoute ? 'true' : 'false' }}"
                   aria-controls="bannerMenu">
                    <i class="fa-solid fa-image link-icon"></i>
                    <span class="link-title">Banner Ads</span>
                    <i class="link-arrow" data-feather="chevron-down"></i>
                </a>
                <div class="collapse {{ $isBannerRoute ? 'show' : '' }}" id="bannerMenu">
                    <ul class="nav sub-menu">
                        <li class="nav-item">
                            <a href="{{ route('add_banner') }}" class="nav-link {{ request()->routeIs('add_banner') ? 'active' : '' }}">Create</a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('all_banner') }}" class="nav-link {{ request()->routeIs('all_banner') || request()->routeIs('edit_banner') ? 'active' : '' }}">All Banners</a>
                        </li>
                    </ul>
                </div>
            </li>

            {{-- Plants --}}
            @php
                $isPlantRoute = request()->routeIs('add_plant') || request()->routeIs('all_plant') || request()->routeIs('edit_plant');
            @endphp
            <li class="nav-item {{ $isPlantRoute ? 'active' : '' }}">
                <a class="nav-link {{ $isPlantRoute ? '' : 'collapsed' }}"
                   data-bs-toggle="collapse"
                   href="#plantMenu"
                   role="button"
                   aria-expanded="{{ $isPlantRoute ? 'true' : 'false' }}"
                   aria-controls="plantMenu">
                    <i class="fa-solid fa-leaf link-icon"></i>
                    <span class="link-title">Plants</span>
                    <i class="link-arrow" data-feather="chevron-down"></i>
                </a>
                <div class="collapse {{ $isPlantRoute ? 'show' : '' }}" id="plantMenu">
                    <ul class="nav sub-menu">
                        <li class="nav-item">
                            <a href="{{ route('add_plant') }}" class="nav-link {{ request()->routeIs('add_plant') ? 'active' : '' }}">Create</a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('all_plant') }}" class="nav-link {{ request()->routeIs('all_plant') || request()->routeIs('edit_plant') ? 'active' : '' }}">All Plants</a>
                        </li>
                    </ul>
                </div>
            </li>

            {{-- Trellis Materials --}}
            @php
                $isTrillsRoute = request()->is('trills/*');
            @endphp
            <li class="nav-item {{ $isTrillsRoute ? 'active' : '' }}">
                <a class="nav-link {{ $isTrillsRoute ? '' : 'collapsed' }}"
                   data-bs-toggle="collapse"
                   href="#trillsMenu"
                   role="button"
                   aria-expanded="{{ $isTrillsRoute ? 'true' : 'false' }}"
                   aria-controls="trillsMenu">
                    <i class="fa-solid fa-seedling link-icon"></i>
                    <span class="link-title">Trellis Materials</span>
                    <i class="link-arrow" data-feather="chevron-down"></i>
                </a>
                <div class="collapse {{ $isTrillsRoute ? 'show' : '' }}" id="trillsMenu">
                    <ul class="nav sub-menu">
                        <li class="nav-item">
                            <a href="{{ url('trills/add') }}" class="nav-link {{ request()->is('trills/add') ? 'active' : '' }}">Create</a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ url('trills/all') }}" class="nav-link {{ request()->is('trills/all') || request()->is('trills/edit/*') ? 'active' : '' }}">All Trellis Materials</a>
                        </li>
                    </ul>
                </div>
            </li>

            {{-- Packages Category --}}
            <li class="nav-item nav-category">Packages</li>

            {{-- Grading --}}
            @php
                $isGradingRoute = request()->routeIs('admin.reservation') || request()->routeIs('plant.reservation.all');
            @endphp
            <li class="nav-item {{ $isGradingRoute ? 'active' : '' }}">
                <a class="nav-link {{ $isGradingRoute ? '' : 'collapsed' }}"
                   data-bs-toggle="collapse"
                   href="#gradingMenu"
                   role="button"
                   aria-expanded="{{ $isGradingRoute ? 'true' : 'false' }}"
                   aria-controls="gradingMenu">
                    <i class="fa-solid fa-clipboard-check link-icon"></i>
                    <span class="link-title">Grading</span>
                    <i class="link-arrow" data-feather="chevron-down"></i>
                </a>
                <div class="collapse {{ $isGradingRoute ? 'show' : '' }}" id="gradingMenu">
                    <ul class="nav sub-menu">
                        <li class="nav-item">
                            <a href="{{ route('admin.reservation') }}" class="nav-link {{ request()->routeIs('admin.reservation') ? 'active' : '' }}">Add</a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('plant.reservation.all') }}" class="nav-link {{ request()->routeIs('plant.reservation.all') ? 'active' : '' }}">All Grading</a>
                        </li>
                    </ul>
                </div>
            </li>

            {{-- Orders Category --}}
            <li class="nav-item nav-category">Orders</li>

            {{-- All Orders --}}
            @php
                $isAllOrdersRoute = request()->routeIs('all_Order') || request()->is('Order/all') || request()->routeIs('order.detail');
            @endphp
            <li class="nav-item {{ $isAllOrdersRoute ? 'active' : '' }}">
                <a href="{{ url('Order/all') }}" class="nav-link">
                    <i class="fa-solid fa-box link-icon"></i>
                    <span class="link-title">All Orders</span>
                </a>
            </li>
             {{-- Order Replacements --}}
            @php
                $isReplacementsRoute = request()->routeIs('order.replacements');
            @endphp
            <li class="nav-item {{ $isReplacementsRoute ? 'active' : '' }}">
                <a href="{{ route('order.replacements') }}" class="nav-link">
                    <i class="fa-solid fa-exchange-alt link-icon"></i>
                    <span class="link-title">Order Replacements</span>
                </a>
            </li>
            
   @php
                $isReasonsRoute = request()->routeIs('replace');
            @endphp
            <li class="nav-item {{ $isReasonsRoute ? 'active' : '' }}">
                <a href="{{ route('replace') }}" class="nav-link">
                    <i class="fa-solid fa-exchange-alt link-icon"></i>
                    <span class="link-title">Reasons</span>
                </a>
            </li>
            {{-- Communication Category --}}
            <li class="nav-item nav-category">Consultancy</li>

            {{-- Users Consult --}}
            @php
                $isConsultancyRoute = request()->is('admin/consultancy');
            @endphp
            <li class="nav-item {{ $isConsultancyRoute ? 'active' : '' }}">
                <a href="{{ url('/admin/consultancy') }}" class="nav-link">
                    <i class="fa-solid fa-users link-icon"></i>
                    <span class="link-title">Users Consult</span>
                </a>
            </li>
            
              @php
                $isConsultancyRoute = request()->is('add/consultancy');
            @endphp
            <li class="nav-item {{ $isConsultancyRoute ? 'active' : '' }}">
                <a href="{{ url('/add/consultancy') }}" class="nav-link">
                    <i class="fa-solid fa-circle-plus link-icon"></i>
                    <span class="link-title">Add Consultancy</span>
                </a>
            </li>

        {{-- Chat Section Heading --}}
<li class="nav-item nav-category">CHAT</li>

{{-- Chat Support --}}
@php
    $isChatRoute = request()->is('chatsystem') || request()->is('chatsystem/*');
@endphp
<li class="nav-item {{ $isChatRoute ? 'active' : '' }}">
    <a href="{{ url('chatsystem') }}" class="nav-link">
        <i class="fa-solid fa-comments link-icon"></i>
        <span class="link-title">Chat Support</span>
    </a>
</li>

<li class="nav-item nav-category">Prompt</li>

@php
    $isChatRoute = request()->is('prompt') || request()->is('prompt/*');
@endphp
<li class="nav-item {{ $isChatRoute ? 'active' : '' }}">
    <a href="{{ url('/prompt') }}" class="nav-link">
        <i class="fa-solid fa-comments link-icon"></i>
        <span class="link-title">Add Prompt</span>
    </a>
</li>
            
            

        
        </ul>
        
        
        
    </div>
</nav>
