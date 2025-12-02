<!DOCTYPE html>
<!--
Template Name: NobleUI - HTML Bootstrap 5 Admin Dashboard Template
Author: NobleUI
Website: https://www.nobleui.com
Portfolio: https://themeforest.net/user/nobleui/portfolio
Contact: nobleui123@gmail.com
Purchase: https://1.envato.market/nobleui_admin
License: For each use you must have a valid license purchased only from above link in order to legally use the theme for your project.
-->
<html lang="en">
<head>
    <meta name="csrf-token" content="{{ csrf_token() }}">


	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<meta http-equiv="X-UA-Compatible" content="ie=edge">
  <meta name="description" content="Responsive HTML Admin Dashboard Template based on Bootstrap 5">
	<meta name="author" content="NobleUI">
	<meta name="keywords" content="nobleui, bootstrap, bootstrap 5, bootstrap5, admin, dashboard, template, responsive, css, sass, html, theme, front-end, ui kit, web">

	<title>NobleUI - HTML Bootstrap 5 Admin Dashboard Template</title>

  <!-- Fonts -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@300;400;500;700;900&display=swap" rel="stylesheet">
  <!-- End fonts -->

	<!-- core:css -->
	<link rel="stylesheet" href="{{asset('assets/vendors/core/core.css')}}">
	<!-- endinject -->

	<!-- Plugin css for this page -->
	<!-- End plugin css for this page -->

	<!-- inject:css -->
	<link rel="stylesheet" href="../../../assets/fonts/feather-font/css/iconfont.css">
	<link rel="stylesheet" href="../../../assets/vendors/flag-icon-css/css/flag-icon.min.css">
	<!-- endinject -->

  <!-- Layout styles -->
	<link rel="stylesheet" href="../../../assets/css/demo1/style.css">
  <!-- End layout styles -->

  <link href="{{asset('web/images/logo/GMtraders.svg')}}" rel="icon">
</head>
<body>
	<div class="main-wrapper">

		<!-- partial:../../partials/_sidebar.html -->

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
        <a class="nav-link {{ request()->routeIs('add_fruits','all_fruits') ? '' : 'collapsed' }}" data-bs-toggle="collapse"
           href="#fruitMenu" role="button"
           aria-expanded="{{ request()->routeIs('add_fruits','all_fruits') ? 'true' : 'false' }}"
           aria-controls="fruitMenu">
      <i class="fa-solid fa-apple-whole ink-icon"></i>
          <span class="link-title">Fruits</span>
          <i class="link-arrow" data-feather="chevron-down"></i>
        </a>
        <div class="collapse {{ request()->routeIs('add_fruits','all_fruits') ? 'show' : '' }}" id="fruitMenu" data-bs-parent="#sidebarMenu"
>
          <ul class="nav sub-menu">
            <li class="nav-item">
              <a href="{{ route('add_fruits') }}" class="nav-link {{ request()->routeIs('add_fruits') ? 'active' : '' }}">Create</a>
            </li>
            <li class="nav-item">
              <a href="{{ route('all_fruits') }}" class="nav-link {{ request()->routeIs('all_fruits') ? 'active' : '' }}">All Fruits</a>
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
              <a href="{{ route('add_banner') }}" class="nav-link {{ request()->routeIs('add_banner') ? 'active' : '' }}">Create</a>
            </li>
            <li class="nav-item">
              <a href="{{ route('all_banner') }}" class="nav-link {{ request()->routeIs('all_banner') ? 'active' : '' }}">All Banners</a>
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
              <a href="{{ route('add_plant') }}" class="nav-link {{ request()->routeIs('add_plant') ? 'active' : '' }}">Create</a>
            </li>
            <li class="nav-item">
              <a href="{{ route('all_plant') }}" class="nav-link {{ request()->routeIs('all_plant') ? 'active' : '' }}">All Plants</a>
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
    <span class="link-title">Trills Materials</span>
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
           All Materials
        </a>
      </li>
    </ul>
  </div>
</li>



          <li class="nav-item nav-category">Packages</li>
       <li class="nav-item">
        <a class="nav-link {{ request()->routeIs('admin.reservation','plant.reservation.all') ? '' : 'collapsed' }}" data-bs-toggle="collapse"
          href="#gradingMenu" role="button"
          aria-expanded="{{ request()->routeIs('admin.reservation','plant.reservation.all') ? 'true' : 'false' }}"
          aria-controls="gradingMenu">
             <i class="fa-solid fa-clipboard-check link-icon"></i>
          <span class="link-title">Grading</span>
          <i class="link-arrow" data-feather="chevron-down"></i>
        </a>

            <div class="collapse {{ request()->routeIs('admin.reservation','plant.reservation.all') ? 'show' : '' }}" id="gradingMenu">
              <ul class="nav sub-menu">
                <li class="nav-item">
                  <a href="{{ route('admin.reservation') }}" class="nav-link {{ request()->routeIs('admin.reservation') ? 'active' : '' }}" class="nav-link">Add</a>
                </li>
                <li class="nav-item">
                  <a href="{{ route('plant.reservation.all') }}" class="nav-link {{ request()->routeIs('plant.reservation.all') ? 'active' : '' }}" class="nav-link">All Grading</a>
                </li>
                {{-- <li class="nav-item">
                  <a href="pages/ui-components/badges.html" class="nav-link">Badges</a>
                </li>
                <li class="nav-item">
                  <a href="pages/ui-components/breadcrumbs.html" class="nav-link">Breadcrumbs</a>
                </li>
                <li class="nav-item">
                  <a href="pages/ui-components/buttons.html" class="nav-link">Buttons</a>
                </li>
                <li class="nav-item">
                  <a href="pages/ui-components/button-group.html" class="nav-link">Button group</a>
                </li>
                <li class="nav-item">
                  <a href="pages/ui-components/cards.html" class="nav-link">Cards</a>
                </li>
                <li class="nav-item">
                  <a href="pages/ui-components/carousel.html" class="nav-link">Carousel</a>
                </li>
                <li class="nav-item">
                    <a href="pages/ui-components/collapse.html" class="nav-link">Collapse</a>
                  </li>
                <li class="nav-item">
                  <a href="pages/ui-components/dropdowns.html" class="nav-link">Dropdowns</a>
                </li>
                <li class="nav-item">
                  <a href="pages/ui-components/list-group.html" class="nav-link">List group</a>
                </li>
                <li class="nav-item">
                  <a href="pages/ui-components/media-object.html" class="nav-link">Media object</a>
                </li>
                <li class="nav-item">
                  <a href="pages/ui-components/modal.html" class="nav-link">Modal</a>
                </li>
                <li class="nav-item">
                  <a href="pages/ui-components/navs.html" class="nav-link">Navs</a>
                </li>
                <li class="nav-item">
                  <a href="pages/ui-components/navbar.html" class="nav-link">Navbar</a>
                </li>
                <li class="nav-item">
                  <a href="pages/ui-components/pagination.html" class="nav-link">Pagination</a>
                </li>
                <li class="nav-item">
                  <a href="pages/ui-components/popover.html" class="nav-link">Popovers</a>
                </li>
                <li class="nav-item">
                  <a href="pages/ui-components/progress.html" class="nav-link">Progress</a>
                </li>
                <li class="nav-item">
                  <a href="pages/ui-components/scrollbar.html" class="nav-link">Scrollbar</a>
                </li>
                <li class="nav-item">
                  <a href="pages/ui-components/scrollspy.html" class="nav-link">Scrollspy</a>
                </li>
                <li class="nav-item">
                  <a href="pages/ui-components/spinners.html" class="nav-link">Spinners</a>
                </li>
                <li class="nav-item">
                  <a href="pages/ui-components/tabs.html" class="nav-link">Tabs</a>
                </li>
                <li class="nav-item">
                  <a href="pages/ui-components/tooltips.html" class="nav-link">Tooltips</a>
                </li>
              </ul>
            </div>
          </li>
          <li class="nav-item">
            <a class="nav-link" data-bs-toggle="collapse" href="#advancedUI" role="button" aria-expanded="false" aria-controls="advancedUI">
              <i class="link-icon" data-feather="anchor"></i>
              <span class="link-title">Advanced UI</span>
              <i class="link-arrow" data-feather="chevron-down"></i>
            </a>
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
            <a href="{{ url('Order/all') }}" class="nav-link {{ request()->is('Order/all') ? 'active' : '' }}" class="nav-link">
              <i class="fa-solid fa-box link-icon"></i>
              <span class="link-title">All Orders</span>
            </a>
          </li>
            <li class="nav-item">
            <a href="{{ url('Order/pending') }}" class="nav-link {{ request()->is('Order/pending') ? 'active' : '' }}" class="nav-link">
            <i class="fa-solid fa-clock link-icon"></i>
              <span class="link-title">Pending Order</span>
            </a>
          </li>
           <li class="nav-item">
            <a href="{{ url('Order/complete') }}" class="nav-link {{ request()->is('Order/complete') ? 'active' : '' }}" class="nav-link">
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
            <a href="{{ url('/admin/consultancy') }}" class="nav-link {{ request()->is('admin/consultancy') ? 'active' : '' }}" class="nav-link">
                <i class="fa-solid fa-headset link-icon"></i>

              <span class="link-title">Users Consult</span>
            </a>
          </li>
            <li class="nav-item">
            <a href="{{ url('chatsystem') }}" class="nav-link {{ request()->is('chatsystem') ? 'active' : '' }}" class="nav-link">
             <i class="fa-solid fa-comments link-icon"></i>
              <span class="link-title">Chat Suppoort</span>
            </a>
          </li>


           <li class="nav-item">
            <a href="{{ url('billing') }}" class="nav-link {{ request()->is('billing') ? 'active' : '' }}" class="nav-link">
       <i class="fa-solid fa-credit-card link-icon"></i>

              <span class="link-title">Billing Addres</span>
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


		<!-- partial -->

		<div class="page-wrapper">

			<!-- partial:../../partials/_navbar.html -->
			 {{-- <nav class="navbar">
				<a href="#" class="sidebar-toggler">
					<i data-feather="menu"></i>
				</a>
				<div class="navbar-content">
					<form class="search-form">
						<div class="input-group">
              <div class="input-group-text">
                <i data-feather="search"></i>
              </div>
							<input type="text" class="form-control" id="navbarForm" placeholder="Search here...">
						</div>
					</form>
					<ul class="navbar-nav">
						<li class="nav-item dropdown">
							<a class="nav-link dropdown-toggle" href="#" id="languageDropdown" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
								<i class="flag-icon flag-icon-us mt-1" title="us"></i> <span class="ms-1 me-1 d-none d-md-inline-block">English</span>
							</a>
							<div class="dropdown-menu" aria-labelledby="languageDropdown">
                <a href="javascript:;" class="dropdown-item py-2"><i class="flag-icon flag-icon-us" title="us" id="us"></i> <span class="ms-1"> English </span></a>
                <a href="javascript:;" class="dropdown-item py-2"><i class="flag-icon flag-icon-fr" title="fr" id="fr"></i> <span class="ms-1"> French </span></a>
                <a href="javascript:;" class="dropdown-item py-2"><i class="flag-icon flag-icon-de" title="de" id="de"></i> <span class="ms-1"> German </span></a>
                <a href="javascript:;" class="dropdown-item py-2"><i class="flag-icon flag-icon-pt" title="pt" id="pt"></i> <span class="ms-1"> Portuguese </span></a>
                <a href="javascript:;" class="dropdown-item py-2"><i class="flag-icon flag-icon-es" title="es" id="es"></i> <span class="ms-1"> Spanish </span></a>
							</div>
            </li>
						<li class="nav-item dropdown">
							<a class="nav-link dropdown-toggle" href="#" id="appsDropdown" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
								<i data-feather="grid"></i>
							</a>
							<div class="dropdown-menu p-0" aria-labelledby="appsDropdown">
                <div class="px-3 py-2 d-flex align-items-center justify-content-between border-bottom">
									<p class="mb-0 fw-bold">Web Apps</p>
									<a href="javascript:;" class="text-muted">Edit</a>
								</div>
                <div class="row g-0 p-1">
                  <div class="col-3 text-center">
                    <a href="../../pages/apps/chat.html" class="dropdown-item d-flex flex-column align-items-center justify-content-center wd-70 ht-70"><i data-feather="message-square" class="icon-lg mb-1"></i><p class="tx-12">Chat</p></a>
                  </div>
                  <div class="col-3 text-center">
                    <a href="../../pages/apps/calendar.html" class="dropdown-item d-flex flex-column align-items-center justify-content-center wd-70 ht-70"><i data-feather="calendar" class="icon-lg mb-1"></i><p class="tx-12">Calendar</p></a>
                  </div>
                  <div class="col-3 text-center">
                    <a href="../../pages/email/inbox.html" class="dropdown-item d-flex flex-column align-items-center justify-content-center wd-70 ht-70"><i data-feather="mail" class="icon-lg mb-1"></i><p class="tx-12">Email</p></a>
                  </div>
                  <div class="col-3 text-center">
                    <a href="../../pages/general/profile.html" class="dropdown-item d-flex flex-column align-items-center justify-content-center wd-70 ht-70"><i data-feather="instagram" class="icon-lg mb-1"></i><p class="tx-12">Profile</p></a>
                  </div>
                </div>
								<div class="px-3 py-2 d-flex align-items-center justify-content-center border-top">
									<a href="javascript:;">View all</a>
								</div>
							</div>
						</li>
						<li class="nav-item dropdown">
							<a class="nav-link dropdown-toggle" href="#" id="messageDropdown" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
								<i data-feather="mail"></i>
							</a>
							<div class="dropdown-menu p-0" aria-labelledby="messageDropdown">
								<div class="px-3 py-2 d-flex align-items-center justify-content-between border-bottom">
									<p>9 New Messages</p>
									<a href="javascript:;" class="text-muted">Clear all</a>
								</div>
                <div class="p-1">
                  <a href="javascript:;" class="dropdown-item d-flex align-items-center py-2">
                    <div class="me-3">
                      <img class="wd-30 ht-30 rounded-circle" src="https://via.placeholder.com/30x30" alt="userr">
                    </div>
                    <div class="d-flex justify-content-between flex-grow-1">
                      <div class="me-4">
                        <p>Leonardo Payne</p>
                        <p class="tx-12 text-muted">Project status</p>
                      </div>
                      <p class="tx-12 text-muted">2 min ago</p>
                    </div>
                  </a>
                  <a href="javascript:;" class="dropdown-item d-flex align-items-center py-2">
                    <div class="me-3">
                      <img class="wd-30 ht-30 rounded-circle" src="https://via.placeholder.com/30x30" alt="userr">
                    </div>
                    <div class="d-flex justify-content-between flex-grow-1">
                      <div class="me-4">
                        <p>Carl Henson</p>
                        <p class="tx-12 text-muted">Client meeting</p>
                      </div>
                      <p class="tx-12 text-muted">30 min ago</p>
                    </div>
                  </a>
                  <a href="javascript:;" class="dropdown-item d-flex align-items-center py-2">
                    <div class="me-3">
                      <img class="wd-30 ht-30 rounded-circle" src="https://via.placeholder.com/30x30" alt="userr">
                    </div>
                    <div class="d-flex justify-content-between flex-grow-1">
                      <div class="me-4">
                        <p>Jensen Combs</p>
                        <p class="tx-12 text-muted">Project updates</p>
                      </div>
                      <p class="tx-12 text-muted">1 hrs ago</p>
                    </div>
                  </a>
                  <a href="javascript:;" class="dropdown-item d-flex align-items-center py-2">
                    <div class="me-3">
                      <img class="wd-30 ht-30 rounded-circle" src="https://via.placeholder.com/30x30" alt="userr">
                    </div>
                    <div class="d-flex justify-content-between flex-grow-1">
                      <div class="me-4">
                        <p>Amiah Burton</p>
                        <p class="tx-12 text-muted">Project deatline</p>
                      </div>
                      <p class="tx-12 text-muted">2 hrs ago</p>
                    </div>
                  </a>
                  <a href="javascript:;" class="dropdown-item d-flex align-items-center py-2">
                    <div class="me-3">
                      <img class="wd-30 ht-30 rounded-circle" src="https://via.placeholder.com/30x30" alt="userr">
                    </div>
                    <div class="d-flex justify-content-between flex-grow-1">
                      <div class="me-4">
                        <p>Yaretzi Mayo</p>
                        <p class="tx-12 text-muted">New record</p>
                      </div>
                      <p class="tx-12 text-muted">5 hrs ago</p>
                    </div>
                  </a>
                </div>
								<div class="px-3 py-2 d-flex align-items-center justify-content-center border-top">
									<a href="javascript:;">View all</a>
								</div>
							</div>
						</li>
						<li class="nav-item dropdown">
							<a class="nav-link dropdown-toggle" href="#" id="notificationDropdown" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
								<i data-feather="bell"></i>
								<div class="indicator">
									<div class="circle"></div>
								</div>
							</a>
							<div class="dropdown-menu p-0" aria-labelledby="notificationDropdown">
								<div class="px-3 py-2 d-flex align-items-center justify-content-between border-bottom">
									<p>6 New Notifications</p>
									<a href="javascript:;" class="text-muted">Clear all</a>
								</div>
                <div class="p-1">
                  <a href="javascript:;" class="dropdown-item d-flex align-items-center py-2">
                    <div class="wd-30 ht-30 d-flex align-items-center justify-content-center bg-primary rounded-circle me-3">
											<i class="icon-sm text-white" data-feather="gift"></i>
                    </div>
                    <div class="flex-grow-1 me-2">
											<p>New Order Recieved</p>
											<p class="tx-12 text-muted">30 min ago</p>
                    </div>
                  </a>
                  <a href="javascript:;" class="dropdown-item d-flex align-items-center py-2">
                    <div class="wd-30 ht-30 d-flex align-items-center justify-content-center bg-primary rounded-circle me-3">
											<i class="icon-sm text-white" data-feather="alert-circle"></i>
                    </div>
                    <div class="flex-grow-1 me-2">
											<p>Server Limit Reached!</p>
											<p class="tx-12 text-muted">1 hrs ago</p>
                    </div>
                  </a>
                  <a href="javascript:;" class="dropdown-item d-flex align-items-center py-2">
                    <div class="wd-30 ht-30 d-flex align-items-center justify-content-center bg-primary rounded-circle me-3">
                      <img class="wd-30 ht-30 rounded-circle" src="https://via.placeholder.com/30x30" alt="userr">
                    </div>
                    <div class="flex-grow-1 me-2">
											<p>New customer registered</p>
											<p class="tx-12 text-muted">2 sec ago</p>
                    </div>
                  </a>
                  <a href="javascript:;" class="dropdown-item d-flex align-items-center py-2">
                    <div class="wd-30 ht-30 d-flex align-items-center justify-content-center bg-primary rounded-circle me-3">
											<i class="icon-sm text-white" data-feather="layers"></i>
                    </div>
                    <div class="flex-grow-1 me-2">
											<p>Apps are ready for update</p>
											<p class="tx-12 text-muted">5 hrs ago</p>
                    </div>
                  </a>
                  <a href="javascript:;" class="dropdown-item d-flex align-items-center py-2">
                    <div class="wd-30 ht-30 d-flex align-items-center justify-content-center bg-primary rounded-circle me-3">
											<i class="icon-sm text-white" data-feather="download"></i>
                    </div>
                    <div class="flex-grow-1 me-2">
											<p>Download completed</p>
											<p class="tx-12 text-muted">6 hrs ago</p>
                    </div>
                  </a>
                </div>
								<div class="px-3 py-2 d-flex align-items-center justify-content-center border-top">
									<a href="javascript:;">View all</a>
								</div>
							</div>
						</li>
						<li class="nav-item dropdown">
							<a class="nav-link dropdown-toggle" href="#" id="profileDropdown" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
								<img class="wd-30 ht-30 rounded-circle" src="https://via.placeholder.com/30x30" alt="profile">
							</a>
							<div class="dropdown-menu p-0" aria-labelledby="profileDropdown">
								<div class="d-flex flex-column align-items-center border-bottom px-5 py-3">
									<div class="mb-3">
										<img class="wd-80 ht-80 rounded-circle" src="https://via.placeholder.com/80x80" alt="">
									</div>
									<div class="text-center">
										<p class="tx-16 fw-bolder">Amiah Burton</p>
										<p class="tx-12 text-muted">amiahburton@gmail.com</p>
									</div>
								</div>
                <ul class="list-unstyled p-1">
                  <li class="dropdown-item py-2">
                    <a href="../../pages/general/profile.html" class="text-body ms-0">
                      <i class="me-2 icon-md" data-feather="user"></i>
                      <span>Profile</span>
                    </a>
                  </li>
                  <li class="dropdown-item py-2">
                    <a href="javascript:;" class="text-body ms-0">
                      <i class="me-2 icon-md" data-feather="edit"></i>
                      <span>Edit Profile</span>
                    </a>
                  </li>
                  <li class="dropdown-item py-2">
                    <a href="javascript:;" class="text-body ms-0">
                      <i class="me-2 icon-md" data-feather="repeat"></i>
                      <span>Switch User</span>
                    </a>
                  </li>
                  <li class="dropdown-item py-2">
                    <a href="javascript:;" class="text-body ms-0">
                      <i class="me-2 icon-md" data-feather="log-out"></i>
                      <span>Log Out</span>
                    </a>
                  </li>
                </ul>
							</div>
						</li>
					</ul>
				</div>
			</nav> --}}
			<!-- partial -->

			<div class="page-content">

				<div class="row chat-wrapper">
					<div class="col-md-12">
            <div class="card">
              <div class="card-body">
                <div class="row position-relative">
                  <div class="col-lg-4 chat-aside border-end-lg">
                    <div class="aside-content">
                      <div class="aside-header">
                        <div class="d-flex justify-content-between align-items-center pb-2 mb-2">
                          <div class="d-flex align-items-center">
                            <figure class="me-2 mb-0">
                              <!--<img src="https://via.placeholder.com/43x43" class="img-sm rounded-circle" alt="profile">-->
                              <div class="status online"></div>
                            </figure>
                            <div>
                              <h6>BGM Trader</h6>
                              <p class="text-muted tx-13">Trader</p>
                            </div>
                          </div>
                          <div class="dropdown">
                            <button class="btn p-0" type="button" id="dropdownMenuButton" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                              <!--<i class="icon-lg text-muted pb-3px" data-feather="settings" data-bs-toggle="tooltip" title="Settings"></i>-->
                            </button>
                            <!--<div class="dropdown-menu" aria-labelledby="dropdownMenuButton">-->
                            <!--  <a class="dropdown-item d-flex align-items-center" href="javascript:;"><i data-feather="eye" class="icon-sm me-2"></i> <span class="">View Profile</span></a>-->
                            <!--  <a class="dropdown-item d-flex align-items-center" href="javascript:;"><i data-feather="edit-2" class="icon-sm me-2"></i> <span class="">Edit Profile</span></a>-->
                            <!--  <a class="dropdown-item d-flex align-items-center" href="javascript:;"><i data-feather="aperture" class="icon-sm me-2"></i> <span class="">Add status</span></a>-->
                            <!--  <a class="dropdown-item d-flex align-items-center" href="javascript:;"><i data-feather="settings" class="icon-sm me-2"></i> <span class="">Settings</span></a>-->
                            <!--</div>-->
                          </div>
                        </div>
                        <!--<form class="search-form">-->
                        <!--  <div class="input-group">-->
                        <!--    <span class="input-group-text">-->
                        <!--      <i data-feather="search" class="cursor-pointer"></i>-->
                        <!--    </span>-->
                        <!--    <input type="text" class="form-control" id="searchForm" placeholder="Search here...">-->
                        <!--  </div>-->
                        <!--</form>-->
                      </div>
                      <div class="aside-body">
                        <!--<ul class="nav nav-tabs nav-fill mt-3" role="tablist">-->
                          <!--<li class="nav-item">-->
                          <!--  <a class="nav-link active" id="chats-tab" data-bs-toggle="tab" data-bs-target="#chats" role="tab" aria-controls="chats" aria-selected="true">-->
                          <!--    <div class="d-flex flex-row flex-lg-column flex-xl-row align-items-center justify-content-center">-->
                          <!--      <i data-feather="message-square" class="icon-sm me-sm-2 me-lg-0 me-xl-2 mb-md-1 mb-xl-0"></i>-->
                          <!--      <p class="d-none d-sm-block">Chats</p>-->
                          <!--    </div>-->
                          <!--  </a>-->
                          <!--</li>-->
                          {{-- <li class="nav-item">
                            <a class="nav-link" id="calls-tab" data-bs-toggle="tab" data-bs-target="#calls" role="tab" aria-controls="calls" aria-selected="false">
                              <div class="d-flex flex-row flex-lg-column flex-xl-row align-items-center justify-content-center">
                                <i data-feather="phone-call" class="icon-sm me-sm-2 me-lg-0 me-xl-2 mb-md-1 mb-xl-0"></i>
                                <p class="d-none d-sm-block">Calls</p>
                              </div>
                            </a>
                          </li> --}}
                          {{-- <li class="nav-item">
                            <a class="nav-link" id="contacts-tab" data-bs-toggle="tab" data-bs-target="#contacts" role="tab" aria-controls="contacts" aria-selected="false">
                              <div class="d-flex flex-row flex-lg-column flex-xl-row align-items-center justify-content-center">
                                <i data-feather="users" class="icon-sm me-sm-2 me-lg-0 me-xl-2 mb-md-1 mb-xl-0"></i>
                                <p class="d-none d-sm-block">Contacts</p>
                              </div>
                            </a>
                          </li> --}}
                        </ul>
                        <div class="tab-content mt-3">
                          <div class="tab-pane fade show active" id="chats" role="tabpanel" aria-labelledby="chats-tab">
                            <div>
                              {{-- <p class="text-muted mb-1">Recent chats</p> --}}
                               <ul class="list-unstyled chat-list px-1">
                                <li class="chat-item pe-1">
                                  <a href="javascript:;" class="d-flex align-items-center">
                                    {{-- <figure class="mb-0 me-2">
                                      <img src="" class="img-xs rounded-circle" alt="">
                                      <div class="status online"></div>
                                    </figure> --}}
                                    <div class="d-flex justify-content-between flex-grow-1 border-bottom">
                                      <div>
                                        <p class="text-body fw-bolder"></p>
                                        <p class="text-muted tx-13"></p>
                                      </div>
                                      <div class="d-flex flex-column align-items-end">
                                        <p class="text-muted tx-13 mb-1"></p>
                                        <div class="badge rounded-pill bg-primary ms-auto"></div>
                                      </div>
                                    </div>
                                  </a>
                                </li>
                                {{-- <li class="chat-item pe-1">
                                  <a href="javascript:;" class="d-flex align-items-center">
                                    <figure class="mb-0 me-2">
                                      <!--<img src="https://via.placeholder.com/37x37" class="img-xs rounded-circle" alt="user">-->
                                      <div class="status offline"></div>
                                    </figure>
                                    <div class="d-flex justify-content-between flex-grow-1 border-bottom">
                                      <div>
                                        <p class="text-body fw-bolder">Carl Henson</p>
                                        <div class="d-flex align-items-center">
                                          <i data-feather="image" class="text-muted icon-md mb-2px"></i>
                                          <p class="text-muted ms-1">Photo</p>
                                        </div>
                                      </div>
                                      <div class="d-flex flex-column align-items-end">
                                        <p class="text-muted tx-13 mb-1">05:24 PM</p>
                                        <div class="badge rounded-pill bg-danger ms-auto">3</div>
                                      </div>
                                    </div>
                                  </a>
                                </li>
                                <li class="chat-item pe-1">
                                  <a href="javascript:;" class="d-flex align-items-center">
                                    <figure class="mb-0 me-2">
                                      <!--<img src="https://via.placeholder.com/37x37" class="img-xs rounded-circle" alt="user">-->
                                      <div class="status offline"></div>
                                    </figure>
                                    <div class="d-flex justify-content-between flex-grow-1 border-bottom">
                                      <div>
                                        <p class="text-body">John Doe</p>
                                        <p class="text-muted tx-13">Hi, How are you?</p>
                                      </div>
                                      <div class="d-flex flex-column align-items-end">
                                        <p class="text-muted tx-13 mb-1">Yesterday</p>
                                      </div>
                                    </div>
                                  </a>
                                </li>
                                <li class="chat-item pe-1">
                                  <a href="javascript:;" class="d-flex align-items-center">
                                    <figure class="mb-0 me-2">
                                      <!--<img src="https://via.placeholder.com/37x37" class="img-xs rounded-circle" alt="user">-->
                                      <div class="status online"></div>
                                    </figure>
                                    <div class="d-flex justify-content-between flex-grow-1 border-bottom">
                                      <div>
                                        <p class="text-body">Jensen Combs</p>
                                        <div class="d-flex align-items-center">
                                          <i data-feather="video" class="text-muted icon-md mb-2px"></i>
                                          <p class="text-muted ms-1">Video</p>
                                        </div>
                                      </div>
                                      <div class="d-flex flex-column align-items-end">
                                        <p class="text-muted tx-13 mb-1">2 days ago</p>
                                      </div>
                                    </div>
                                  </a>
                                </li>
                                <li class="chat-item pe-1">
                                  <a href="javascript:;" class="d-flex align-items-center">
                                    <figure class="mb-0 me-2">
                                      <img src="https://via.placeholder.com/37x37" class="img-xs rounded-circle" alt="user">
                                      <div class="status offline"></div>
                                    </figure>
                                    <div class="d-flex justify-content-between flex-grow-1 border-bottom">
                                      <div>
                                        <p class="text-body">Yaretzi Mayo</p>
                                        <p class="text-muted tx-13">Hi, How are you?</p>
                                      </div>
                                      <div class="d-flex flex-column align-items-end">
                                        <p class="text-muted tx-13 mb-1">4 week ago</p>
                                      </div>
                                    </div>
                                  </a>
                                </li>
                                <li class="chat-item pe-1">
                                  <a href="javascript:;" class="d-flex align-items-center">
                                    <figure class="mb-0 me-2">
                                      <img src="https://via.placeholder.com/37x37" class="img-xs rounded-circle" alt="user">
                                      <div class="status offline"></div>
                                    </figure>
                                    <div class="d-flex justify-content-between flex-grow-1 border-bottom">
                                      <div>
                                        <p class="text-body fw-bolder">John Doe</p>
                                        <p class="text-muted tx-13">Hi, How are you?</p>
                                      </div>
                                      <div class="d-flex flex-column align-items-end">
                                        <p class="text-muted tx-13 mb-1">4:32 PM</p>
                                        <div class="badge rounded-pill bg-primary ms-auto">5</div>
                                      </div>
                                    </div>
                                  </a>
                                </li>
                                <li class="chat-item pe-1">
                                  <a href="javascript:;" class="d-flex align-items-center">
                                    <figure class="mb-0 me-2">
                                      <img src="https://via.placeholder.com/37x37" class="img-xs rounded-circle" alt="user">
                                      <div class="status online"></div>
                                    </figure>
                                    <div class="d-flex justify-content-between flex-grow-1 border-bottom">
                                      <div>
                                        <p class="text-body fw-bolder">Leonardo Payne</p>
                                        <div class="d-flex align-items-center">
                                          <i data-feather="image" class="text-muted icon-md mb-2px"></i>
                                          <p class="text-muted ms-1">Photo</p>
                                        </div>
                                      </div>
                                      <div class="d-flex flex-column align-items-end">
                                        <p class="text-muted tx-13 mb-1">6:11 PM</p>
                                        <div class="badge rounded-pill bg-danger ms-auto">3</div>
                                      </div>
                                    </div>
                                  </a>
                                </li>
                                <li class="chat-item pe-1">
                                  <a href="javascript:;" class="d-flex align-items-center">
                                    <figure class="mb-0 me-2">
                                      <img src="https://via.placeholder.com/37x37" class="img-xs rounded-circle" alt="user">
                                      <div class="status online"></div>
                                    </figure>
                                    <div class="d-flex justify-content-between flex-grow-1 border-bottom">
                                      <div>
                                        <p class="text-body">John Doe</p>
                                        <p class="text-muted tx-13">Hi, How are you?</p>
                                      </div>
                                      <div class="d-flex flex-column align-items-end">
                                        <p class="text-muted tx-13 mb-1">Yesterday</p>
                                      </div>
                                    </div>
                                  </a>
                                </li>
                                <li class="chat-item pe-1">
                                  <a href="javascript:;" class="d-flex align-items-center">
                                    <figure class="mb-0 me-2">
                                      <img src="https://via.placeholder.com/37x37" class="img-xs rounded-circle" alt="user">
                                      <div class="status online"></div>
                                    </figure>
                                    <div class="d-flex justify-content-between flex-grow-1 border-bottom">
                                      <div>
                                        <p class="text-body">Leonardo Payne</p>
                                        <div class="d-flex align-items-center">
                                          <i data-feather="video" class="text-muted icon-md mb-2px"></i>
                                          <p class="text-muted ms-1">Video</p>
                                        </div>
                                      </div>
                                      <div class="d-flex flex-column align-items-end">
                                        <p class="text-muted tx-13 mb-1">2 days ago</p>
                                      </div>
                                    </div>
                                  </a>
                                </li>
                                <li class="chat-item pe-1">
                                  <a href="javascript:;" class="d-flex align-items-center">
                                    <figure class="mb-0 me-2">
                                      <img src="https://via.placeholder.com/37x37" class="img-xs rounded-circle" alt="user">
                                      <div class="status online"></div>
                                    </figure>
                                    <div class="d-flex justify-content-between flex-grow-1 border-bottom">
                                      <div>
                                        <p class="text-body">John Doe</p>
                                        <p class="text-muted tx-13">Hi, How are you?</p>
                                      </div>
                                      <div class="d-flex flex-column align-items-end">
                                        <p class="text-muted tx-13 mb-1">4 week ago</p>
                                      </div>
                                    </div>
                                  </a>
                                </li> --}}
                              </ul>

                              <ul class="list-unstyled chat-list px-1 ">
           @forelse($chatUsers as $user)


           <li class="chat-item pe-1 mb-2"     data-id="{{ $user['id'] }}"
            data-first_name="{{ $user['first_name'] }}"
            data-image="{{ $user['profile_image'] }}">
            <a href="javascript:;" class="d-flex align-items-center">
                <!--<figure class="mb-0 me-2 position-relative">-->
                <!--    {{-- Profile image (use your accessor if available) --}}-->
                <!--    <img src="{{ $user['profile_image'] ?? 'https://via.placeholder.com/37x37' }}"-->
                <!--         class="img-xs rounded-circle"-->
                <!--         alt="{{ $user['first_name'] }}">-->
                <!--    <div class="status online"></div>-->
                <!--</figure>-->
                {{-- @dd( $user['profile_image']); --}}

                <div class="d-flex align-items-center justify-content-between flex-grow-1 border-bottom pb-2">
                    <div>

                        {{-- User name --}}
                        <p class="text-body fw-bold mb-1">{{ $user['first_name'] }}</p>

                        {{-- Last message --}}
                        <p class="text-muted small mb-1">
                            {{ Str::limit($user['last_message'], 40) }}
                        </p>

                        {{-- Time --}}
                        <div class="d-flex align-items-center">
                            <i data-feather="clock" class="icon-sm text-success me-1"></i>
                            <p class="text-muted tx-13 mb-0">{{ $user['last_message_time'] }}</p>
                        </div>
                    </div>

                    <div class="d-flex flex-column align-items-end">
                        {{-- Message count badge --}}
                        {{-- @if($user['message_count'] > 0)
                            <span class="badge bg-primary mb-1">{{ $user['message_count'] }}</span>
                        @endif --}}
                        <i data-feather="message-square" class="text-primary icon-md"></i>
                    </div>
                </div>
            </a>
        </li>
    @empty
        <li class="text-center text-muted">No chat users found</li>
    @endforelse
</ul>

                            </div>
                          </div>


                        </div>
                      </div>
                    </div>
                  </div>
                  <div class="col-lg-8 chat-content">
                    <div class="chat-header border-bottom pb-2">
                      <div class="d-flex justify-content-between">
                        <div class="d-flex align-items-center">
                          <i data-feather="corner-up-left" id="backToChatList" class="icon-lg me-2 ms-n2 text-muted d-lg-none"></i>
                          <figure class="mb-0 me-2">
                            <!--<img src="https://via.placeholder.com/43x43" class="img-sm rounded-circle" alt="image">-->
                            <div class="status online"></div>
                            <div class="status online"></div>
                          </figure>
                          <div>
                            <p></p>
                            <p class="text-muted tx-13">User</p>
                          </div>
                        </div>
                        {{-- <div class="d-flex align-items-center me-n1">
                          <a href="#">
                            <i data-feather="video" class="icon-lg text-muted me-3" data-bs-toggle="tooltip" title="Start video call"></i>
                          </a>
                          <a href="#">
                            <i data-feather="phone-call" class="icon-lg text-muted me-0 me-sm-3" data-bs-toggle="tooltip" title="Start voice call"></i>
                          </a>
                          <a href="#" class="d-none d-sm-block">
                            <i data-feather="user-plus" class="icon-lg text-muted" data-bs-toggle="tooltip" title="Add to contacts"></i>
                          </a>
                        </div> --}}
                      </div>
                    </div>
                    <div class="chat-body">
                      <ul class="messages">
                        <li class="message-item friend">
                          <img >
                          <div class="content">
                            <div class="message">
                              <div class="">
                                <p></p>
                              </div>
                              <span></span>
                            </div>
                          </div>
                        </li>
                        {{-- <li class="message-item me">
                          <img src="https://via.placeholder.com/36x36" class="img-xs rounded-circle" alt="avatar">
                          <div class="content">
                            <div class="message">
                              <div class="">
                                <p></p>
                              </div>
                            </div>
                            <div class="message">
                              <div class="bubble">
                                {{-- <p>Lorem Ipsum.</p>
                              </div>
                              <span>8:13 PM</span>
                            </div>
                          </div>
                        </li>
                        <li class="message-item friend">
                          <img src="https://via.placeholder.com/36x36" class="img-xs rounded-circle" alt="avatar">
                          <div class="content">
                            <div class="message">
                              <div class="bubble">
                                <p>Lorem Ipsum is simply dummy text of the printing and typesetting industry.</p>
                              </div>
                              <span>8:15 PM</span>
                            </div>
                          </div>
                        </li>
                        <li class="message-item me">
                          <img src="https://via.placeholder.com/36x36" class="img-xs rounded-circle" alt="avatar">
                          <div class="content">
                            <div class="message">
                              <div class="bubble">
                                <p>Lorem Ipsum is simply dummy text of the printing and typesetting industry printing and typesetting industry.</p>
                              </div>
                              <span>8:15 PM</span>
                            </div>
                          </div>
                        </li>
                        <li class="message-item friend">
                          <img src="https://via.placeholder.com/36x36" class="img-xs rounded-circle" alt="avatar">
                          <div class="content">
                            <div class="message">
                              <div class="bubble">
                                <p>Lorem Ipsum is simply dummy text of the printing and typesetting industry.</p>
                              </div>
                              <span>8:17 PM</span>
                            </div>
                          </div>
                        </li>
                        <li class="message-item me">
                          <img src="https://via.placeholder.com/36x36" class="img-xs rounded-circle" alt="avatar">
                          <div class="content">
                            <div class="message">
                              <div class="bubble">
                                <p>Lorem Ipsum is simply dummy text of the printing and typesetting industry printing and typesetting industry.</p>
                              </div>
                            </div>
                            <div class="message">
                              <div class="bubble">
                                <p>Lorem Ipsum.</p>
                              </div>
                              <span>8:18 PM</span>
                            </div>
                          </div>
                        </li>
                        <li class="message-item friend">
                          <img src="https://via.placeholder.com/36x36" class="img-xs rounded-circle" alt="avatar">
                          <div class="content">
                            <div class="message">
                              <div class="bubble">
                                <p>Lorem Ipsum is simply dummy text of the printing and typesetting industry.</p>
                              </div>
                              <span>8:22 PM</span>
                            </div>
                          </div>
                        </li>
                        <li class="message-item me">
                          <img src="https://via.placeholder.com/36x36" class="img-xs rounded-circle" alt="avatar">
                          <div class="content">
                            <div class="message">
                              <div class="bubble">
                                <p>Lorem Ipsum is simply dummy text of the printing and typesetting industry printing and typesetting industry.</p>
                              </div>
                              <span>8:30 PM</span>
                            </div>
                          </div>
                        </li> --}}
                      </ul>
                    </div>
                    <div class="chat-footer d-flex">
                      <!--<div>-->
                      <!--  <button type="button" class="btn border btn-icon rounded-circle me-2" data-bs-toggle="tooltip" title="Emoji">-->
                      <!--    <i data-feather="smile" class="text-muted"></i>-->
                      <!--  </button>-->
                      <!--</div>-->
                      <!--<div class="d-none d-md-block">-->
                      <!--  <button type="button" class="btn border btn-icon rounded-circle me-2" data-bs-toggle="tooltip" title="Attatch files">-->
                      <!--    <i data-feather="paperclip" class="text-muted"></i>-->
                      <!--  </button>-->
                      <!--</div>-->
                      <!--<div class="d-none d-md-block">-->
                      <!--  <button type="button" class="btn border btn-icon rounded-circle me-2" data-bs-toggle="tooltip" title="Record you voice">-->
                      <!--    <i data-feather="mic" class="text-muted"></i>-->
                      <!--  </button>-->
                      <!--</div>-->
                      <form class="search-form flex-grow-1 me-2">
                        <div class="input-group">

                          <input type="text" class="form-control rounded-pill" id="messageInput" placeholder="Type a message">
                        </div>
                      </form>
                      <div>
                        <button type="button" class="btn btn-primary btn-icon rounded-circle" id="sendBtn">
                          <i data-feather="send"></i>
                        </button>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
					</div>
				</div>
			</div>

			<!-- partial:../../partials/_footer.html -->
			{{-- <footer class="footer d-flex flex-column flex-md-row align-items-center justify-content-between px-4 py-3 border-top small">
				<p class="text-muted mb-1 mb-md-0">Copyright © 2022 <a href="https://www.nobleui.com" target="_blank">NobleUI</a>.</p>
				<p class="text-muted">Handcrafted With <i class="mb-1 text-primary ms-1 icon-sm" data-feather="heart"></i></p>
			</footer> --}}
			<!-- partial -->

		</div>
	</div>

	<!-- core:js -->
	<script src="../../../assets/vendors/core/core.js"></script>
	<!-- endinject -->

	<!-- Plugin js for this page -->
	<!-- End plugin js for this page -->

	<!-- inject:js -->
	<script src="../../../assets/vendors/feather-icons/feather.min.js"></script>
	<script src="../../../assets/js/template.js"></script>
	<!-- endinject -->

	<!-- Custom js for this page -->
  <script src="../../../assets/js/chat.js"></script>
	<!-- End custom js for this page -->

</body>
</html>








<script>
$(document).ready(function() {

    // 🌍 Make receiverId global
    let receiverId = null;

    // ⚡ 1️⃣ When admin clicks a user in the list
    $('.chat-item').on('click', function() {
        receiverId = $(this).data('id'); // ✅ store globally
        const name = $(this).data('first_name');
        const image = $(this).data('image');

        // Update header UI
        $('.chat-header p:first').text(name);
        $('.chat-header img').attr('src', image);
        $('.messages').empty();

        // Fetch previous messages
        $.ajax({
            url: "{{ url('/admin/chat/messages') }}/" + receiverId,
            type: 'GET',
            data: {
                _token: $('meta[name="csrf-token"]').attr('content'),
                receiver_id: receiverId
            },
            success: function(res) {
                if (res.data.length === 0) {
                    $('.messages').html('<li class="text-center text-muted">No messages yet</li>');
                    return;
                }

                res.data.forEach(msg => {
                    let side = msg.sender_id == {{ Auth::id() }} ? 'me' : 'friend';
                    $('.messages').append(`
                        <li class="message-item ${side}">
                            <div class="content">
                                <div class="message">
                                    <div class="bubble">
                                        <p>${msg.message}</p>
                                    </div>
                                    <span>${msg.time}</span>
                                </div>
                            </div>
                        </li>
                    `);
                });

                scrollToBottom();
            }
        });
    });

    // ⚡ 2️⃣ Send message instantly
    $('#sendBtn').on('click', function() {
        let message = $('#messageInput').val().trim();

        if (!receiverId) {
            alert('Select a user first!');
            return;
        }

        if (!message) {
            alert('Type a message before sending.');
            return;
        }

        // Instantly show message in chat window
        $('.messages').append(`
            <li class="message-item me">
                <div class="content">
                    <div class="message">
                        <div class="bubble bg-primary text-white">
                            <p>${message}</p>
                        </div>
                    </div>
                </div>
            </li>
        `);

        $('#messageInput').val('');
        scrollToBottom();

        // Send message to backend
        $.ajax({
            url: '/chat/send',
            type: 'POST',
            data: {
                _token: $('meta[name="csrf-token"]').attr('content'),
                receiver_id: receiverId,
                message: message
            },
            success: function(res) {
                console.log('Message stored in DB:', res.data);
            },
            error: function(err) {
                console.error('Error sending message:', err);
            }
        });
    });

    // 🌀 Auto scroll
    function scrollToBottom() {
        let chatBody = $('.chat-body');
        chatBody.scrollTop(chatBody[0].scrollHeight);
    }
});
</script>


