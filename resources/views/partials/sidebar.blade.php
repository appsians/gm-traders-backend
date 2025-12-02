
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

          <li class="nav-item">
            <a href="{{url('/dashboard')}}" class="nav-link">

   <i class="fa-solid fa-gauge link-icon"></i>
              <span class="link-title">Dashboard</span>
            </a>
          </li>
           <li class="nav-item nav-category">Products</li>

      {{-- Fruits --}}
      <li class="nav-item">
        <a class="nav-link {{ request()->routeIs(['add_fruits','all_fruits']) ? '' : 'collapsed' }}" data-bs-toggle="collapse"
           href="#fruitMenu" role="button"
           aria-expanded="{{ request()->routeIs(['add_fruits','all_fruits']) ? 'true' : 'false' }}"
           aria-controls="fruitMenu">
      <i class="fa-solid fa-apple-whole ink-icon"></i>
          <span class="link-title">Fruits</span>
          <i class="link-arrow" data-feather="chevron-down"></i>
        </a>
        <div class="collapse {{ request()->routeIs(['add_fruits','all_fruits']) ? 'show' : '' }}" id="fruitMenu"
>
          <ul class="nav sub-menu">
            <li class="nav-item">
              <a href="{{ route('add_fruits') }}" class="nav-link {{ request()->routeIs('add_fruits') ? '' : '' }}">Create</a>
            </li>
            <li class="nav-item">
              <a href="{{ route('all_fruits') }}" class="nav-link {{ request()->routeIs('all_fruits') ? '' : '' }}">All Fruits</a>
            </li>
          </ul>
        </div>
      </li>

      {{-- Banners --}}
      <li class="nav-item">
        <a class="nav-link {{ request()->routeIs('add_banner','all_banner') ? '' : 'collapsed' }}" data-bs-toggle="collapse"
           href="#bannerMenu" role="button"
           aria-expanded="{{ request()->routeIs('add_banner','all_banner') ? 'true' : 'false' }}"
           aria-controls="bannerMenu">
        <i class="fa-solid fa-image link-icon"></i>
          <span class="link-title">Banners</span>
          <i class="link-arrow" data-feather="chevron-down"></i>
        </a>
        <div class="collapse {{ request()->routeIs('add_banner','all_banner') ? 'show' : '' }}" id="bannerMenu">
          <ul class="nav sub-menu">
            <li class="nav-item">
              <a href="{{ route('add_banner') }}" class="nav-link {{ request()->routeIs('add_banner') ? '' : '' }}">Create</a>
            </li>
            <li class="nav-item">
              <a href="{{ route('all_banner') }}" class="nav-link {{ request()->routeIs('all_banner') ? '' : '' }}">All Banners</a>
            </li>
          </ul>
        </div>
      </li>

      {{-- Plants --}}
      <li class="nav-item">
        <a class="nav-link {{ request()->routeIs('add_plant','all_plant') ? '' : 'collapsed' }}" data-bs-toggle="collapse"
           href="#plantMenu" role="button"
           aria-expanded="{{ request()->routeIs('add_plant','all_plant') ? 'true' : 'false' }}"
           aria-controls="plantMenu">
         <i class="fa-solid fa-leaf link-icon"></i>
          <span class="link-title">Plants</span>
          <i class="link-arrow" data-feather="chevron-down"></i>
        </a>
        <div class="collapse {{ request()->routeIs('add_plant','all_plant') ? 'show' : '' }}" id="plantMenu">
          <ul class="nav sub-menu">
            <li class="nav-item">
              <a href="{{ route('add_plant') }}" class="nav-link {{ request()->routeIs('add_plant') ? '' : '' }}">Create</a>
            </li>
            <li class="nav-item">
              <a href="{{ route('all_plant') }}" class="nav-link {{ request()->routeIs('all_plant') ? '' : '' }}">All Plants</a>
            </li>
          </ul>
        </div>
      </li>
          {{-- <li class="nav-item">
            <a href="pages/apps/chat.html" class="nav-link">
              <i class="link-icon" data-feather="message-square"></i>
              <span class="link-title">Plants</span>
            </a>
          </li> --}}


           <li class="nav-item">
  <a class="nav-link {{ request()->is('trills/*') ? '' : 'collapsed' }}"
     data-bs-toggle="collapse"
     href="#trillsMenu"
     role="button"
     aria-expanded="{{ request()->is('trills/*') ? 'true' : 'false' }}"
     aria-controls="trillsMenu">
       <i class="fa-solid fa-seedling link-icon"></i>
    <span class="link-title">Trellis Materials</span>
    <i class="link-arrow" data-feather="chevron-down"></i>
  </a>

  <div class="collapse {{ request()->is('trills/*') ? 'show' : '' }}" id="trillsMenu">
    <ul class="nav sub-menu">
      <li class="nav-item">
        <a href="{{ url('trills/add') }}"
           class="nav-link {{ request()->is('trills/add') ? 'active' : '' }}">
           Create
        </a>
      </li>
      <li class="nav-item">
        <a href="{{ url('trills/all') }}"
           class="nav-link {{ request()->is('trills/all') ? 'active' : '' }}">
           All Trellis Materials
        </a>
      </li>
    </ul>
  </div>
</li> 





<li class="nav-item nav-category">Packages</li>

<li class="nav-item">
    <a class="nav-link {{ request()->routeIs('admin.reservation','plant.reservation.all') ? '' : 'collapsed' }}"
       data-bs-toggle="collapse"
       href="#gradingMenu"
       role="button"
       aria-expanded="{{ request()->routeIs('admin.reservation','plant.reservation.all') ? 'true' : 'false' }}"
       aria-controls="gradingMenu">
        <i class="fa-solid fa-clipboard-check link-icon"></i>
        <span class="link-title">Grading</span>
        <i class="link-arrow" data-feather="chevron-down"></i>
    </a>

    <div class="collapse {{ request()->routeIs('admin.reservation','plant.reservation.all') ? 'show' : '' }}"
         id="gradingMenu">
        <ul class="nav sub-menu">
            <li class="nav-item">
                <a href="{{ route('admin.reservation') }}"
                   class="nav-link {{ request()->routeIs('admin.reservation') ? '' : '' }}">
                   Add
                </a>
            </li>

            <li class="nav-item">
                <a href="{{ route('plant.reservation.all') }}"
                   class="nav-link {{ request()->routeIs('plant.reservation.all') ? '' : '' }}">
                   All Grading
                </a>
            </li>
        </ul>
    </div>
</li>
          <!--</li>-->
          <li class="nav-item">
            <!--<a class="nav-link" data-bs-toggle="collapse" href="#advancedUI" role="button" aria-expanded="false" aria-controls="advancedUI">-->
            <!--  <i class="link-icon" data-feather="anchor"></i>-->
            <!--  <span class="link-title">Advanced UI</span>-->
            <!--  <i class="link-arrow" data-feather="chevron-down"></i>-->
            <!--</a>-->
            <div class="collapse" id="advancedUI">
              <ul class="nav sub-menu">
                <li class="nav-item">
                  <a href="pages/advanced-ui/cropper.html" class="nav-link">Cropper</a>
                </li>
                <li class="nav-item">
                  <a href="pages/advanced-ui/owl-carousel.html" class="nav-link">Owl carousel</a>
                </li>
                <li class="nav-item">
                  <a href="pages/advanced-ui/sortablejs.html" class="nav-link">SortableJs</a>
                </li>
                <li class="nav-item">
                  <a href="pages/advanced-ui/sweet-alert.html" class="nav-link">Sweet Alert</a>
                </li> --}}
              </ul>
            </div>
          </li>

          <li class="nav-item nav-category">Orders</li>

          <li class="nav-item">


          <li class="nav-item">
            <a href="{{ url('Order/all') }}" class="nav-link {{ request()->is('Order/all') ? '' : '' }}" class="nav-link">
              <i class="fa-solid fa-box link-icon"></i>
              <span class="link-title">All Orders</span>
            </a>
          </li>
            <li class="nav-item">
            <a href="{{ url('Order/pending') }}" class="nav-link {{ request()->is('Order/pending') ? '' : '' }}" class="nav-link">
            <i class="fa-solid fa-clock link-icon"></i>
              <span class="link-title">Pending Order</span>
            </a>
          </li>
           <li class="nav-item">
            <a href="{{ url('Order/complete') }}" class="nav-link {{ request()->is('Order/complete') ? '' : '' }}" class="nav-link">
              <i class="fa-solid fa-check-circle link-icon"></i>
              <span class="link-title">Complete Order</span>
            </a>
          </li>




              <li class="nav-item nav-category">Communication</li>
          {{-- <li class="nav-item">
            <a class="nav-link" data-bs-toggle="collapse" href="" role="button" aria-expanded="false" aria-controls="general-pages">
                <i class="fa-solid fa-user-headset link-icon"></i>
              <span class="link-title">User_Consult</span>
              <i class="link-arrow" data-feather="chevron-down"></i>
            </a>
            <div class="collapse" id="general-pages">
              <ul class="nav sub-menu">
                <li class="nav-item">
                  <a href="pages/general/blank-page.html" class="nav-link">Blank page</a>
                </li>
                <li class="nav-item">
                  <a href="pages/general/faq.html" class="nav-link">Faq</a>
                </li>
                <li class="nav-item">
                  <a href="pages/general/invoice.html" class="nav-link">Invoice</a>
                </li>
                <li class="nav-item">
                  <a href="pages/general/profile.html" class="nav-link">Profile</a>
                </li>
                <li class="nav-item">
                  <a href="pages/general/pricing.html" class="nav-link">Pricing</a>
                </li>
                <li class="nav-item">
                  <a href="pages/general/timeline.html" class="nav-link">Timeline</a>
                </li>
              </ul>
            </div>
          </li> --}}
          <li class="nav-item">


          <li class="nav-item">
            <a href="{{ url('/admin/consultancy') }}" class="nav-link {{ request()->is('admin/consultancy') ? '' : '' }}" class="nav-link">
                <i class="fa-solid fa-headset link-icon"></i>

              <span class="link-title">Users Consult</span>
            </a>
          </li>
            <li class="nav-item">
            <a href="{{ url('chatsystem') }}" class="nav-link {{ request()->is('chatsystem') ? '' : '' }}" class="nav-link">
             <i class="fa-solid fa-comments link-icon"></i>
              <span class="link-title">Chat Suppoort</span>
            </a>
          </li>


           <li class="nav-item">
            <a href="{{ url('billing') }}" class="nav-link {{ request()->is('billing') ? 'active' : '' }}" class="nav-link">
       <i class="fa-solid fa-credit-card link-icon"></i>

              <span class="link-title">billing</span>
            </a>
          </li>
            {{-- <a class="nav-link" data-bs-toggle="collapse" href="#authPages" role="button" aria-expanded="false" aria-controls="authPages">
              <i class="link-icon" data-feather="unlock"></i>
              <span class="link-title">Chat_Support</span>
              <i class="link-arrow" data-feather="chevron-down"></i>
            </a>
              <a class="nav-link" data-bs-toggle="collapse" href="#authPages" role="button" aria-expanded="false" aria-controls="authPages">
                   <i class="fa-solid fa-user-headset link-icon"></i>
              <span class="link-title">User Consult</span>
              <i class="link-arrow" data-feather="chevron-down"></i>
            </a> --}}
            <div class="collapse" id="authPages">
              <ul class="nav sub-menu">
                {{-- {{-- <li class="nav-item">
                  <a href="pages/auth/login.html" class="nav-link">Login</a>
                </li>
                <li class="nav-item">
                  <a href="pages/auth/register.html" class="nav-link">Register</a>
                </li>
              </ul>
            </div>
          </li> --}}
          {{-- <li class="nav-item">
            <a class="nav-link" data-bs-toggle="collapse" href="#errorPages" role="button" aria-expanded="false" aria-controls="errorPages">
              <i class="link-icon" data-feather="cloud-off"></i>
              <span class="link-title">Error</span>
              <i class="link-arrow" data-feather="chevron-down"></i>
            </a>
            <div class="collapse" id="errorPages">
              <ul class="nav sub-menu">
                <li class="nav-item">
                  <a href="pages/error/404.html" class="nav-link">404</a>
                </li>
                <li class="nav-item">
                  <a href="pages/error/500.html" class="nav-link">500</a>
                </li>
              </ul>
            </div>
          </li>
          <li class="nav-item nav-category">Docs</li>
          <li class="nav-item">
            <a href="https://www.nobleui.com/html/documentation/docs.html" target="_blank" class="nav-link">
              <i class="link-icon" data-feather="hash"></i>
              <span class="link-title">Documentation</span>
            </a>
          </li>
        </ul> --}}



      </div>
    </nav>




<!-- jQuery (optional, if not already loaded) -->
<!--<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>-->

<!-- Bootstrap JS (required for collapse toggle) -->
<!--<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>-->

<!-- Feather Icons -->
