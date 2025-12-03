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
            
            <li class="nav-item <?php echo e(request()->routeIs('dashboard') ? 'active' : ''); ?>">
                <a href="<?php echo e(route('dashboard')); ?>" class="nav-link">
                    <i class="fa-solid fa-gauge link-icon"></i>
                    <span class="link-title">Dashboard</span>
                </a>
            </li>

            
            <li class="nav-item nav-category">Products</li>

            
            <?php
                $isFruitRoute = request()->routeIs('add_fruits') || request()->routeIs('all_fruits') || request()->routeIs('edit_fruit');
            ?>
            <li class="nav-item <?php echo e($isFruitRoute ? 'active' : ''); ?>">
                <a class="nav-link <?php echo e($isFruitRoute ? '' : 'collapsed'); ?>"
                   data-bs-toggle="collapse"
                   href="#fruitMenu"
                   role="button"
                   aria-expanded="<?php echo e($isFruitRoute ? 'true' : 'false'); ?>"
                   aria-controls="fruitMenu">
                    <i class="fa-solid fa-apple-whole link-icon"></i>
                    <span class="link-title">Fruits</span>
                    <i class="link-arrow" data-feather="chevron-down"></i>
                </a>
                <div class="collapse <?php echo e($isFruitRoute ? 'show' : ''); ?>" id="fruitMenu">
                    <ul class="nav sub-menu">
                        <li class="nav-item">
                            <a href="<?php echo e(route('add_fruits')); ?>" class="nav-link <?php echo e(request()->routeIs('add_fruits') ? 'active' : ''); ?>">Create</a>
                        </li>
                        <li class="nav-item">
                            <a href="<?php echo e(route('all_fruits')); ?>" class="nav-link <?php echo e(request()->routeIs('all_fruits') || request()->routeIs('edit_fruit') ? 'active' : ''); ?>">All Fruits</a>
                        </li>
                    </ul>
                </div>
            </li>

            
            <?php
                $isBannerRoute = request()->routeIs('add_banner') || request()->routeIs('all_banner') || request()->routeIs('edit_banner');
            ?>
            <li class="nav-item <?php echo e($isBannerRoute ? 'active' : ''); ?>">
                <a class="nav-link <?php echo e($isBannerRoute ? '' : 'collapsed'); ?>"
                   data-bs-toggle="collapse"
                   href="#bannerMenu"
                   role="button"
                   aria-expanded="<?php echo e($isBannerRoute ? 'true' : 'false'); ?>"
                   aria-controls="bannerMenu">
                    <i class="fa-solid fa-image link-icon"></i>
                    <span class="link-title">Banners</span>
                    <i class="link-arrow" data-feather="chevron-down"></i>
                </a>
                <div class="collapse <?php echo e($isBannerRoute ? 'show' : ''); ?>" id="bannerMenu">
                    <ul class="nav sub-menu">
                        <li class="nav-item">
                            <a href="<?php echo e(route('add_banner')); ?>" class="nav-link <?php echo e(request()->routeIs('add_banner') ? 'active' : ''); ?>">Create</a>
                        </li>
                        <li class="nav-item">
                            <a href="<?php echo e(route('all_banner')); ?>" class="nav-link <?php echo e(request()->routeIs('all_banner') || request()->routeIs('edit_banner') ? 'active' : ''); ?>">All Banners</a>
                        </li>
                    </ul>
                </div>
            </li>

            
            <?php
                $isPlantRoute = request()->routeIs('add_plant') || request()->routeIs('all_plant') || request()->routeIs('edit_plant');
            ?>
            <li class="nav-item <?php echo e($isPlantRoute ? 'active' : ''); ?>">
                <a class="nav-link <?php echo e($isPlantRoute ? '' : 'collapsed'); ?>"
                   data-bs-toggle="collapse"
                   href="#plantMenu"
                   role="button"
                   aria-expanded="<?php echo e($isPlantRoute ? 'true' : 'false'); ?>"
                   aria-controls="plantMenu">
                    <i class="fa-solid fa-leaf link-icon"></i>
                    <span class="link-title">Plants</span>
                    <i class="link-arrow" data-feather="chevron-down"></i>
                </a>
                <div class="collapse <?php echo e($isPlantRoute ? 'show' : ''); ?>" id="plantMenu">
                    <ul class="nav sub-menu">
                        <li class="nav-item">
                            <a href="<?php echo e(route('add_plant')); ?>" class="nav-link <?php echo e(request()->routeIs('add_plant') ? 'active' : ''); ?>">Create</a>
                        </li>
                        <li class="nav-item">
                            <a href="<?php echo e(route('all_plant')); ?>" class="nav-link <?php echo e(request()->routeIs('all_plant') || request()->routeIs('edit_plant') ? 'active' : ''); ?>">All Plants</a>
                        </li>
                    </ul>
                </div>
            </li>

            
            <?php
                $isTrillsRoute = request()->is('trills/*');
            ?>
            <li class="nav-item <?php echo e($isTrillsRoute ? 'active' : ''); ?>">
                <a class="nav-link <?php echo e($isTrillsRoute ? '' : 'collapsed'); ?>"
                   data-bs-toggle="collapse"
                   href="#trillsMenu"
                   role="button"
                   aria-expanded="<?php echo e($isTrillsRoute ? 'true' : 'false'); ?>"
                   aria-controls="trillsMenu">
                    <i class="fa-solid fa-seedling link-icon"></i>
                    <span class="link-title">Trellis Materials</span>
                    <i class="link-arrow" data-feather="chevron-down"></i>
                </a>
                <div class="collapse <?php echo e($isTrillsRoute ? 'show' : ''); ?>" id="trillsMenu">
                    <ul class="nav sub-menu">
                        <li class="nav-item">
                            <a href="<?php echo e(url('trills/add')); ?>" class="nav-link <?php echo e(request()->is('trills/add') ? 'active' : ''); ?>">Create</a>
                        </li>
                        <li class="nav-item">
                            <a href="<?php echo e(url('trills/all')); ?>" class="nav-link <?php echo e(request()->is('trills/all') || request()->is('trills/edit/*') ? 'active' : ''); ?>">All Trellis Materials</a>
                        </li>
                    </ul>
                </div>
            </li>

            
            <li class="nav-item nav-category">Packages</li>

            
            <?php
                $isGradingRoute = request()->routeIs('admin.reservation') || request()->routeIs('plant.reservation.all');
            ?>
            <li class="nav-item <?php echo e($isGradingRoute ? 'active' : ''); ?>">
                <a class="nav-link <?php echo e($isGradingRoute ? '' : 'collapsed'); ?>"
                   data-bs-toggle="collapse"
                   href="#gradingMenu"
                   role="button"
                   aria-expanded="<?php echo e($isGradingRoute ? 'true' : 'false'); ?>"
                   aria-controls="gradingMenu">
                    <i class="fa-solid fa-clipboard-check link-icon"></i>
                    <span class="link-title">Grading</span>
                    <i class="link-arrow" data-feather="chevron-down"></i>
                </a>
                <div class="collapse <?php echo e($isGradingRoute ? 'show' : ''); ?>" id="gradingMenu">
                    <ul class="nav sub-menu">
                        <li class="nav-item">
                            <a href="<?php echo e(route('admin.reservation')); ?>" class="nav-link <?php echo e(request()->routeIs('admin.reservation') ? 'active' : ''); ?>">Add</a>
                        </li>
                        <li class="nav-item">
                            <a href="<?php echo e(route('plant.reservation.all')); ?>" class="nav-link <?php echo e(request()->routeIs('plant.reservation.all') ? 'active' : ''); ?>">All Grading</a>
                        </li>
                    </ul>
                </div>
            </li>

            
            <li class="nav-item nav-category">Orders</li>

            
            <?php
                $isAllOrdersRoute = request()->routeIs('all_Order') || request()->is('Order/all') || request()->routeIs('order.detail');
            ?>
            <li class="nav-item <?php echo e($isAllOrdersRoute ? 'active' : ''); ?>">
                <a href="<?php echo e(url('Order/all')); ?>" class="nav-link">
                    <i class="fa-solid fa-box link-icon"></i>
                    <span class="link-title">All Orders</span>
                </a>
            </li>

            
            <li class="nav-item nav-category">Communication</li>

            
            <?php
                $isConsultancyRoute = request()->is('admin/consultancy');
            ?>
            <li class="nav-item <?php echo e($isConsultancyRoute ? 'active' : ''); ?>">
                <a href="<?php echo e(url('/admin/consultancy')); ?>" class="nav-link">
                    <i class="fa-solid fa-headset link-icon"></i>
                    <span class="link-title">Users Consult</span>
                </a>
            </li>

            
            <?php
                $isChatRoute = request()->is('chatsystem') || request()->is('chatsystem/*');
            ?>
            <li class="nav-item <?php echo e($isChatRoute ? 'active' : ''); ?>">
                <a href="<?php echo e(url('chatsystem')); ?>" class="nav-link">
                    <i class="fa-solid fa-comments link-icon"></i>
                    <span class="link-title">Chat Support</span>
                </a>
            </li>

            
            <?php
                $isBillingRoute = request()->routeIs('billing.show') || request()->is('billing');
            ?>
            <li class="nav-item <?php echo e($isBillingRoute ? 'active' : ''); ?>">
                <a href="<?php echo e(route('billing.show')); ?>" class="nav-link">
                    <i class="fa-solid fa-credit-card link-icon"></i>
                    <span class="link-title">Billing</span>
                </a>
            </li>
        </ul>
    </div>
</nav>
<?php /**PATH /Users/appsians/gm-traders-backend/resources/views/partials/sidebar.blade.php ENDPATH**/ ?>