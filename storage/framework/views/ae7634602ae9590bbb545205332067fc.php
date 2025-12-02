
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
            <a href="<?php echo e(url('/dashboard')); ?>" class="nav-link">

   <i class="fa-solid fa-gauge link-icon"></i>
              <span class="link-title">Dashboard</span>
            </a>
          </li>
           <li class="nav-item nav-category">Products</li>

      
      <li class="nav-item">
        <a class="nav-link <?php echo e(request()->routeIs(['add_fruits','all_fruits']) ? '' : 'collapsed'); ?>" data-bs-toggle="collapse"
           href="#fruitMenu" role="button"
           aria-expanded="<?php echo e(request()->routeIs(['add_fruits','all_fruits']) ? 'true' : 'false'); ?>"
           aria-controls="fruitMenu">
      <i class="fa-solid fa-apple-whole ink-icon"></i>
          <span class="link-title">Fruits</span>
          <i class="link-arrow" data-feather="chevron-down"></i>
        </a>
        <div class="collapse <?php echo e(request()->routeIs(['add_fruits','all_fruits']) ? 'show' : ''); ?>" id="fruitMenu"
>
          <ul class="nav sub-menu">
            <li class="nav-item">
              <a href="<?php echo e(route('add_fruits')); ?>" class="nav-link <?php echo e(request()->routeIs('add_fruits') ? '' : ''); ?>">Create</a>
            </li>
            <li class="nav-item">
              <a href="<?php echo e(route('all_fruits')); ?>" class="nav-link <?php echo e(request()->routeIs('all_fruits') ? '' : ''); ?>">All Fruits</a>
            </li>
          </ul>
        </div>
      </li>

      
      <li class="nav-item">
        <a class="nav-link <?php echo e(request()->routeIs('add_banner','all_banner') ? '' : 'collapsed'); ?>" data-bs-toggle="collapse"
           href="#bannerMenu" role="button"
           aria-expanded="<?php echo e(request()->routeIs('add_banner','all_banner') ? 'true' : 'false'); ?>"
           aria-controls="bannerMenu">
        <i class="fa-solid fa-image link-icon"></i>
          <span class="link-title">Banners</span>
          <i class="link-arrow" data-feather="chevron-down"></i>
        </a>
        <div class="collapse <?php echo e(request()->routeIs('add_banner','all_banner') ? 'show' : ''); ?>" id="bannerMenu">
          <ul class="nav sub-menu">
            <li class="nav-item">
              <a href="<?php echo e(route('add_banner')); ?>" class="nav-link <?php echo e(request()->routeIs('add_banner') ? '' : ''); ?>">Create</a>
            </li>
            <li class="nav-item">
              <a href="<?php echo e(route('all_banner')); ?>" class="nav-link <?php echo e(request()->routeIs('all_banner') ? '' : ''); ?>">All Banners</a>
            </li>
          </ul>
        </div>
      </li>

      
      <li class="nav-item">
        <a class="nav-link <?php echo e(request()->routeIs('add_plant','all_plant') ? '' : 'collapsed'); ?>" data-bs-toggle="collapse"
           href="#plantMenu" role="button"
           aria-expanded="<?php echo e(request()->routeIs('add_plant','all_plant') ? 'true' : 'false'); ?>"
           aria-controls="plantMenu">
         <i class="fa-solid fa-leaf link-icon"></i>
          <span class="link-title">Plants</span>
          <i class="link-arrow" data-feather="chevron-down"></i>
        </a>
        <div class="collapse <?php echo e(request()->routeIs('add_plant','all_plant') ? 'show' : ''); ?>" id="plantMenu">
          <ul class="nav sub-menu">
            <li class="nav-item">
              <a href="<?php echo e(route('add_plant')); ?>" class="nav-link <?php echo e(request()->routeIs('add_plant') ? '' : ''); ?>">Create</a>
            </li>
            <li class="nav-item">
              <a href="<?php echo e(route('all_plant')); ?>" class="nav-link <?php echo e(request()->routeIs('all_plant') ? '' : ''); ?>">All Plants</a>
            </li>
          </ul>
        </div>
      </li>
          


           <li class="nav-item">
  <a class="nav-link <?php echo e(request()->is('trills/*') ? '' : 'collapsed'); ?>"
     data-bs-toggle="collapse"
     href="#trillsMenu"
     role="button"
     aria-expanded="<?php echo e(request()->is('trills/*') ? 'true' : 'false'); ?>"
     aria-controls="trillsMenu">
       <i class="fa-solid fa-seedling link-icon"></i>
    <span class="link-title">Trellis Materials</span>
    <i class="link-arrow" data-feather="chevron-down"></i>
  </a>

  <div class="collapse <?php echo e(request()->is('trills/*') ? 'show' : ''); ?>" id="trillsMenu">
    <ul class="nav sub-menu">
      <li class="nav-item">
        <a href="<?php echo e(url('trills/add')); ?>"
           class="nav-link <?php echo e(request()->is('trills/add') ? 'active' : ''); ?>">
           Create
        </a>
      </li>
      <li class="nav-item">
        <a href="<?php echo e(url('trills/all')); ?>"
           class="nav-link <?php echo e(request()->is('trills/all') ? 'active' : ''); ?>">
           All Trellis Materials
        </a>
      </li>
    </ul>
  </div>
</li> 





<li class="nav-item nav-category">Packages</li>

<li class="nav-item">
    <a class="nav-link <?php echo e(request()->routeIs('admin.reservation','plant.reservation.all') ? '' : 'collapsed'); ?>"
       data-bs-toggle="collapse"
       href="#gradingMenu"
       role="button"
       aria-expanded="<?php echo e(request()->routeIs('admin.reservation','plant.reservation.all') ? 'true' : 'false'); ?>"
       aria-controls="gradingMenu">
        <i class="fa-solid fa-clipboard-check link-icon"></i>
        <span class="link-title">Grading</span>
        <i class="link-arrow" data-feather="chevron-down"></i>
    </a>

    <div class="collapse <?php echo e(request()->routeIs('admin.reservation','plant.reservation.all') ? 'show' : ''); ?>"
         id="gradingMenu">
        <ul class="nav sub-menu">
            <li class="nav-item">
                <a href="<?php echo e(route('admin.reservation')); ?>"
                   class="nav-link <?php echo e(request()->routeIs('admin.reservation') ? '' : ''); ?>">
                   Add
                </a>
            </li>

            <li class="nav-item">
                <a href="<?php echo e(route('plant.reservation.all')); ?>"
                   class="nav-link <?php echo e(request()->routeIs('plant.reservation.all') ? '' : ''); ?>">
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
            <a href="<?php echo e(url('Order/all')); ?>" class="nav-link <?php echo e(request()->is('Order/all') ? '' : ''); ?>" class="nav-link">
              <i class="fa-solid fa-box link-icon"></i>
              <span class="link-title">All Orders</span>
            </a>
          </li>
            <li class="nav-item">
            <a href="<?php echo e(url('Order/pending')); ?>" class="nav-link <?php echo e(request()->is('Order/pending') ? '' : ''); ?>" class="nav-link">
            <i class="fa-solid fa-clock link-icon"></i>
              <span class="link-title">Pending Order</span>
            </a>
          </li>
           <li class="nav-item">
            <a href="<?php echo e(url('Order/complete')); ?>" class="nav-link <?php echo e(request()->is('Order/complete') ? '' : ''); ?>" class="nav-link">
              <i class="fa-solid fa-check-circle link-icon"></i>
              <span class="link-title">Complete Order</span>
            </a>
          </li>




              <li class="nav-item nav-category">Communication</li>
          
          <li class="nav-item">


          <li class="nav-item">
            <a href="<?php echo e(url('/admin/consultancy')); ?>" class="nav-link <?php echo e(request()->is('admin/consultancy') ? '' : ''); ?>" class="nav-link">
                <i class="fa-solid fa-headset link-icon"></i>

              <span class="link-title">Users Consult</span>
            </a>
          </li>
            <li class="nav-item">
            <a href="<?php echo e(url('chatsystem')); ?>" class="nav-link <?php echo e(request()->is('chatsystem') ? '' : ''); ?>" class="nav-link">
             <i class="fa-solid fa-comments link-icon"></i>
              <span class="link-title">Chat Suppoort</span>
            </a>
          </li>


           <li class="nav-item">
            <a href="<?php echo e(url('billing')); ?>" class="nav-link <?php echo e(request()->is('billing') ? 'active' : ''); ?>" class="nav-link">
       <i class="fa-solid fa-credit-card link-icon"></i>

              <span class="link-title">billing</span>
            </a>
          </li>
            
            <div class="collapse" id="authPages">
              <ul class="nav sub-menu">
                
          



      </div>
    </nav>




<!-- jQuery (optional, if not already loaded) -->
<!--<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>-->

<!-- Bootstrap JS (required for collapse toggle) -->
<!--<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>-->

<!-- Feather Icons -->
<?php /**PATH C:\Users\chsan\Downloads\public_html (1)\public_html\resources\views/partials/sidebar.blade.php ENDPATH**/ ?>