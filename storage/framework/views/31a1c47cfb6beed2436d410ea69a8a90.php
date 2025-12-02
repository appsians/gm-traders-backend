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
    <meta name="csrf-token" content="<?php echo e(csrf_token()); ?>">


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
	<link rel="stylesheet" href="<?php echo e(asset('assets/vendors/core/core.css')); ?>">
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

  <link href="<?php echo e(asset('web/images/logo/GMtraders.svg')); ?>" rel="icon">
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
            <a href="<?php echo e(url('/dashboard')); ?>" class="nav-link">

   <i class="fa-solid fa-gauge link-icon"></i>
              <span class="link-title">Dashboard</span>
            </a>
          </li>
           <li class="nav-item nav-category">Products</li>

      
      <li class="nav-item">
        <a class="nav-link <?php echo e(request()->routeIs('add_fruits','all_fruits') ? '' : 'collapsed'); ?>" data-bs-toggle="collapse"
           href="#fruitMenu" role="button"
           aria-expanded="<?php echo e(request()->routeIs('add_fruits','all_fruits') ? 'true' : 'false'); ?>"
           aria-controls="fruitMenu">
      <i class="fa-solid fa-apple-whole ink-icon"></i>
          <span class="link-title">Fruits</span>
          <i class="link-arrow" data-feather="chevron-down"></i>
        </a>
        <div class="collapse <?php echo e(request()->routeIs('add_fruits','all_fruits') ? 'show' : ''); ?>" id="fruitMenu" data-bs-parent="#sidebarMenu"
>
          <ul class="nav sub-menu">
            <li class="nav-item">
              <a href="<?php echo e(route('add_fruits')); ?>" class="nav-link <?php echo e(request()->routeIs('add_fruits') ? 'active' : ''); ?>">Create</a>
            </li>
            <li class="nav-item">
              <a href="<?php echo e(route('all_fruits')); ?>" class="nav-link <?php echo e(request()->routeIs('all_fruits') ? 'active' : ''); ?>">All Fruits</a>
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
              <a href="<?php echo e(route('add_banner')); ?>" class="nav-link <?php echo e(request()->routeIs('add_banner') ? 'active' : ''); ?>">Create</a>
            </li>
            <li class="nav-item">
              <a href="<?php echo e(route('all_banner')); ?>" class="nav-link <?php echo e(request()->routeIs('all_banner') ? 'active' : ''); ?>">All Banners</a>
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
              <a href="<?php echo e(route('add_plant')); ?>" class="nav-link <?php echo e(request()->routeIs('add_plant') ? 'active' : ''); ?>">Create</a>
            </li>
            <li class="nav-item">
              <a href="<?php echo e(route('all_plant')); ?>" class="nav-link <?php echo e(request()->routeIs('all_plant') ? 'active' : ''); ?>">All Plants</a>
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
    <span class="link-title">Trills Materials</span>
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
           All Materials
        </a>
      </li>
    </ul>
  </div>
</li>



          <li class="nav-item nav-category">Packages</li>
       <li class="nav-item">
        <a class="nav-link <?php echo e(request()->routeIs('admin.reservation','plant.reservation.all') ? '' : 'collapsed'); ?>" data-bs-toggle="collapse"
          href="#gradingMenu" role="button"
          aria-expanded="<?php echo e(request()->routeIs('admin.reservation','plant.reservation.all') ? 'true' : 'false'); ?>"
          aria-controls="gradingMenu">
             <i class="fa-solid fa-clipboard-check link-icon"></i>
          <span class="link-title">Grading</span>
          <i class="link-arrow" data-feather="chevron-down"></i>
        </a>

            <div class="collapse <?php echo e(request()->routeIs('admin.reservation','plant.reservation.all') ? 'show' : ''); ?>" id="gradingMenu">
              <ul class="nav sub-menu">
                <li class="nav-item">
                  <a href="<?php echo e(route('admin.reservation')); ?>" class="nav-link <?php echo e(request()->routeIs('admin.reservation') ? 'active' : ''); ?>" class="nav-link">Add</a>
                </li>
                <li class="nav-item">
                  <a href="<?php echo e(route('plant.reservation.all')); ?>" class="nav-link <?php echo e(request()->routeIs('plant.reservation.all') ? 'active' : ''); ?>" class="nav-link">All Grading</a>
                </li>
                
              </ul>
            </div>
          </li>

          <li class="nav-item nav-category">Orders</li>

          <li class="nav-item">


          <li class="nav-item">
            <a href="<?php echo e(url('Order/all')); ?>" class="nav-link <?php echo e(request()->is('Order/all') ? 'active' : ''); ?>" class="nav-link">
              <i class="fa-solid fa-box link-icon"></i>
              <span class="link-title">All Orders</span>
            </a>
          </li>
            <li class="nav-item">
            <a href="<?php echo e(url('Order/pending')); ?>" class="nav-link <?php echo e(request()->is('Order/pending') ? 'active' : ''); ?>" class="nav-link">
            <i class="fa-solid fa-clock link-icon"></i>
              <span class="link-title">Pending Order</span>
            </a>
          </li>
           <li class="nav-item">
            <a href="<?php echo e(url('Order/complete')); ?>" class="nav-link <?php echo e(request()->is('Order/complete') ? 'active' : ''); ?>" class="nav-link">
              <i class="fa-solid fa-check-circle link-icon"></i>
              <span class="link-title">Complete Order</span>
            </a>
          </li>




              <li class="nav-item nav-category">Communication</li>
          
          <li class="nav-item">


          <li class="nav-item">
            <a href="<?php echo e(url('/admin/consultancy')); ?>" class="nav-link <?php echo e(request()->is('admin/consultancy') ? 'active' : ''); ?>" class="nav-link">
                <i class="fa-solid fa-headset link-icon"></i>

              <span class="link-title">Users Consult</span>
            </a>
          </li>
            <li class="nav-item">
            <a href="<?php echo e(url('chatsystem')); ?>" class="nav-link <?php echo e(request()->is('chatsystem') ? 'active' : ''); ?>" class="nav-link">
             <i class="fa-solid fa-comments link-icon"></i>
              <span class="link-title">Chat Suppoort</span>
            </a>
          </li>


           <li class="nav-item">
            <a href="<?php echo e(url('billing')); ?>" class="nav-link <?php echo e(request()->is('billing') ? 'active' : ''); ?>" class="nav-link">
       <i class="fa-solid fa-credit-card link-icon"></i>

              <span class="link-title">Billing Addres</span>
            </a>
          </li>
            
            <div class="collapse" id="authPages">
              <ul class="nav sub-menu">
                
          



      </div>
    </nav>


		<!-- partial -->

		<div class="page-wrapper">

			<!-- partial:../../partials/_navbar.html -->
			 
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
                          
                          
                        </ul>
                        <div class="tab-content mt-3">
                          <div class="tab-pane fade show active" id="chats" role="tabpanel" aria-labelledby="chats-tab">
                            <div>
                              
                               <ul class="list-unstyled chat-list px-1">
                                <li class="chat-item pe-1">
                                  <a href="javascript:;" class="d-flex align-items-center">
                                    
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
                                
                              </ul>

                              <ul class="list-unstyled chat-list px-1 ">
           <?php $__empty_1 = true; $__currentLoopData = $chatUsers; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $user): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>


           <li class="chat-item pe-1 mb-2"     data-id="<?php echo e($user['id']); ?>"
            data-first_name="<?php echo e($user['first_name']); ?>"
            data-image="<?php echo e($user['profile_image']); ?>">
            <a href="javascript:;" class="d-flex align-items-center">
                <!--<figure class="mb-0 me-2 position-relative">-->
                <!--    -->
                <!--    <img src="<?php echo e($user['profile_image'] ?? 'https://via.placeholder.com/37x37'); ?>"-->
                <!--         class="img-xs rounded-circle"-->
                <!--         alt="<?php echo e($user['first_name']); ?>">-->
                <!--    <div class="status online"></div>-->
                <!--</figure>-->
                

                <div class="d-flex align-items-center justify-content-between flex-grow-1 border-bottom pb-2">
                    <div>

                        
                        <p class="text-body fw-bold mb-1"><?php echo e($user['first_name']); ?></p>

                        
                        <p class="text-muted small mb-1">
                            <?php echo e(Str::limit($user['last_message'], 40)); ?>

                        </p>

                        
                        <div class="d-flex align-items-center">
                            <i data-feather="clock" class="icon-sm text-success me-1"></i>
                            <p class="text-muted tx-13 mb-0"><?php echo e($user['last_message_time']); ?></p>
                        </div>
                    </div>

                    <div class="d-flex flex-column align-items-end">
                        
                        
                        <i data-feather="message-square" class="text-primary icon-md"></i>
                    </div>
                </div>
            </a>
        </li>
    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
        <li class="text-center text-muted">No chat users found</li>
    <?php endif; ?>
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
            url: "<?php echo e(url('/admin/chat/messages')); ?>/" + receiverId,
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
                    let side = msg.sender_id == <?php echo e(Auth::id()); ?> ? 'me' : 'friend';
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


<?php /**PATH /home/zbas2urw91oa/public_html/resources/views/Admin/chat/index.blade.php ENDPATH**/ ?>