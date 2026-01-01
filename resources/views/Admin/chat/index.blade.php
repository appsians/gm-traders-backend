@extends('layouts.app')

@section('content')
<style>
    .chat-wrapper {
        height: calc(100vh - 200px);
        min-height: 600px;
        background: #ffffff;
    }

    .chat-aside {
        border-right: 1px solid #e8ecf0;
        height: 100%;
        display: flex;
        flex-direction: column;
        background: #fafbfc;
    }

    .aside-content {
        display: flex;
        flex-direction: column;
        height: 100%;
    }

    .aside-header {
        padding: 20px;
        border-bottom: 1px solid #e8ecf0;
        flex-shrink: 0;
        background: #ffffff;
    }

    .aside-header h5 {
        font-weight: 600;
        color: #1a1a1a;
        font-size: 18px;
        margin-bottom: 4px;
    }

    .aside-header p {
        font-size: 13px;
        color: #6b7280;
        margin: 0;
    }

    .aside-body {
        flex: 1;
        overflow-y: auto;
        padding: 12px;
        background: #fafbfc;
    }

    .aside-body::-webkit-scrollbar {
        width: 6px;
    }

    .aside-body::-webkit-scrollbar-track {
        background: transparent;
    }

    .aside-body::-webkit-scrollbar-thumb {
        background: #d1d5db;
        border-radius: 3px;
    }

    .aside-body::-webkit-scrollbar-thumb:hover {
        background: #9ca3af;
    }

    .chat-list {
        max-height: 100%;
        overflow-y: auto;
    }

    .chat-item {
        cursor: pointer;
        transition: all 0.2s ease;
        border-radius: 12px;
        padding: 12px;
        margin-bottom: 6px;
        background: #ffffff;
        border: 1px solid transparent;
    }

    .chat-item:hover {
        background: #f3f4f6;
        border-color: #e5e7eb;
        transform: translateX(2px);
    }

    .chat-item.active {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        border-color: #667eea;
        box-shadow: 0 4px 12px rgba(102, 126, 234, 0.15);
    }

    .chat-item.active * {
        color: #ffffff !important;
    }

    .chat-item.active .text-muted {
        color: rgba(255, 255, 255, 0.8) !important;
    }

    .chat-content {
        height: 100%;
        display: flex;
        flex-direction: column;
        background: #ffffff;
    }

    .chat-header {
        padding: 16px 24px;
        flex-shrink: 0;
        background: #ffffff;
        border-bottom: 1px solid #e8ecf0;
        box-shadow: 0 1px 3px rgba(0, 0, 0, 0.05);
    }

    .chat-header h6 {
        font-weight: 600;
        color: #1a1a1a;
        font-size: 16px;
        margin: 0;
    }

    .chat-body {
        flex: 1;
        overflow-y: auto;
        padding: 16px 20px;
        background: #fafbfc;
        position: relative;
    }

    .chat-body::-webkit-scrollbar {
        width: 6px;
    }

    .chat-body::-webkit-scrollbar-track {
        background: transparent;
    }

    .chat-body::-webkit-scrollbar-thumb {
        background: #d1d5db;
        border-radius: 3px;
    }

    .chat-body::-webkit-scrollbar-thumb:hover {
        background: #9ca3af;
    }

    .chat-footer {
        padding: 16px 24px;
        flex-shrink: 0;
        background: #ffffff;
        border-top: 1px solid #e8ecf0;
    }

    .chat-footer .form-control {
        border-radius: 24px;
        border: 1px solid #e5e7eb;
        padding: 10px 20px;
        font-size: 14px;
        transition: all 0.2s ease;
    }

    .chat-footer .form-control:focus {
        border-color: #667eea;
        box-shadow: 0 0 0 3px rgba(102, 126, 234, 0.1);
    }

    .chat-footer .btn {
        border-radius: 50%;
        width: 44px;
        height: 44px;
        display: flex;
        align-items: center;
        justify-content: center;
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        border: none;
        transition: all 0.2s ease;
    }

    .chat-footer .btn:hover {
        transform: scale(1.05);
        box-shadow: 0 4px 12px rgba(102, 126, 234, 0.3);
    }

    .messages {
        list-style: none;
        padding: 0;
        margin: 0;
    }

    .message-item {
        display: flex;
        margin-bottom: 6px;
        align-items: flex-end;
        animation: fadeIn 0.3s ease;
    }

    @keyframes fadeIn {
        from {
            opacity: 0;
            transform: translateY(10px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    .message-item.me {
        justify-content: flex-end;
    }

    .message-item.friend {
        justify-content: flex-start;
    }

    .message-item .avatar {
        width: 36px;
        height: 36px;
        border-radius: 50%;
        margin: 0 8px;
        flex-shrink: 0;
        object-fit: cover;
        border: 2px solid #ffffff;
        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
    }

    .message-item.me .avatar {
        order: 2;
    }

    .message-item .content {
        max-width: 75%;
        display: flex;
        flex-direction: column;
    }

    .message-item.me .content {
        align-items: flex-end;
    }

    .message-item.friend .content {
        align-items: flex-start;
    }

    .bubble {
        padding: 8px 12px;
        border-radius: 12px;
        word-wrap: break-word;
        word-break: break-word;
        position: relative;

        max-width: 100%;
        box-shadow: 0 1px 1px rgba(0, 0, 0, 0.05);
        transition: all 0.15s ease;
        display: inline-block;
    }

    .message-item.me .bubble {
        background: #dcfce7;
        color: #166534;
        border-bottom-right-radius: 3px;
    }

    .message-item.friend .bubble {
        background: #f3f4f6;
        color: #1f2937;
        border-bottom-left-radius: 3px;
        border: none;
    }

    .message-item .bubble p {
        margin: 0;
        line-height: 1.4;
        white-space: pre-wrap;
        word-wrap: break-word;
        color: inherit;
        font-size: 13px;
        font-weight: 400;
    }

    .message-time {
        font-size: 10px;
        color: #9ca3af;
        margin-top: 3px;
        padding: 0 4px;
        font-weight: 400;
        letter-spacing: 0.2px;
    }

    .empty-state {
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        height: 100%;
        text-align: center;
        padding: 60px 40px;
    }

    .empty-state-icon {
        font-size: 80px;
        color: #d1d5db;
        margin-bottom: 24px;
        opacity: 0.6;
    }

    .empty-state h4 {
        color: #374151;
        margin-bottom: 8px;
        font-weight: 600;
        font-size: 20px;
    }

    .empty-state p {
        color: #6b7280;
        font-size: 14px;
    }

    .user-avatar {
        width: 44px;
        height: 44px;
        border-radius: 50%;
        object-fit: cover;
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        border: 2px solid #ffffff;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
    }

    .user-search {
        margin-bottom: 0;
    }

    .user-search .form-control {
        border-radius: 12px;
        border: 1px solid #e5e7eb;
        padding: 10px 16px 10px 42px;
        font-size: 14px;
        background: #f9fafb;
        transition: all 0.2s ease;
    }

    .user-search .form-control:focus {
        background: #ffffff;
        border-color: #667eea;
        box-shadow: 0 0 0 3px rgba(102, 126, 234, 0.1);
    }

    .chat-item-avatar {
        position: relative;
        margin-right: 12px;
    }

    .search-input-wrapper {
        position: relative;
    }

    .search-input-wrapper svg,
    .search-input-wrapper i[data-feather] {
        position: absolute;
        left: 14px;
        top: 50%;
        transform: translateY(-50%);
        color: #9ca3af;
        z-index: 10;
        width: 16px;
        height: 16px;
        pointer-events: none;
    }

    .search-input-wrapper svg {
        stroke: #9ca3af;
        fill: none;
        position: absolute;
        left: 14px;
        top: 50%;
        transform: translateY(-50%);
        z-index: 10;
        width: 16px;
        height: 16px;
    }

    .action-menu-btn {
        background: none;
        border: none;
        padding: 8px;
        cursor: pointer;
        color: #6b7280;
        font-size: 18px;
        border-radius: 8px;
        transition: all 0.2s ease;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .action-menu-btn:hover {
        color: #667eea;
        background: #f3f4f6;
    }

    .customer-data-modal .modal-body {
        max-height: 60vh;
        overflow-y: auto;
    }

    .customer-data-modal .modal-body::-webkit-scrollbar {
        width: 6px;
    }

    .customer-data-modal .modal-body::-webkit-scrollbar-track {
        background: #f9fafb;
    }

    .customer-data-modal .modal-body::-webkit-scrollbar-thumb {
        background: #d1d5db;
        border-radius: 3px;
    }

    .data-table {
        font-size: 14px;
    }

    .data-table th {
        background: #f9fafb;
        font-weight: 600;
        color: #374151;
        border-bottom: 2px solid #e5e7eb;
    }

    .data-table td {
        color: #1f2937;
        vertical-align: middle;
    }

    .chat-item .flex-grow-1 h6 {
        font-weight: 600;
        color: #1a1a1a;
        font-size: 15px;
        margin-bottom: 4px;
    }

    .chat-item .flex-grow-1 small {
        font-size: 12px;
        color: #6b7280;
    }

    .chat-item .flex-grow-1 p {
        font-size: 13px;
        color: #6b7280;
        margin: 0;
        line-height: 1.4;
    }

    .chat-item.active .flex-grow-1 h6,
    .chat-item.active .flex-grow-1 small,
    .chat-item.active .flex-grow-1 p {
        color: #ffffff !important;
    }
</style>

<div class="page-content">
    <div class="d-flex justify-content-between align-items-center flex-wrap grid-margin mb-4">
        <div>
            <h4 class="mb-3 mb-md-0">Chat Support</h4>
            <nav class="page-breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Chat Support</li>
                </ol>
            </nav>
        </div>
    </div>

    <div class="row chat-wrapper">
        <div class="col-md-12">
            <div class="card" style="height: 100%;">
                <div class="card-body p-0" style="height: 100%; display: flex;">
                    <!-- Chat Sidebar -->
                    <div class="col-lg-4 chat-aside">
                        <div class="aside-content">
                            <div class="aside-header">
                                <div class="d-flex justify-content-between align-items-center mb-3">
                                    <div>
                                        <h5 class="mb-0">Messages</h5>
                                        <p class="text-muted small mb-0">Chat with customers</p>
                                    </div>
                                </div>
                                <div class="user-search">
                                    <div class="search-input-wrapper">
                                        <i data-feather="search" class="icon-sm"></i>
                                        <input type="text" class="form-control" id="userSearch" placeholder="Search users...">
                                    </div>
                                </div>
                            </div>
                            <div class="aside-body">
                                <ul class="list-unstyled chat-list" id="chatUserList">
                                    @forelse($chatUsers as $user)
                                        <li class="chat-item" 
                                            data-id="{{ $user['id'] }}"
                                            data-first_name="{{ $user['first_name'] }}"
                                            data-image="{{ $user['profile_image'] }}"
                                            data-search="{{ strtolower($user['first_name']) }}">
                                            <a href="javascript:;" class="d-flex align-items-center text-decoration-none">
                                                <div class="chat-item-avatar position-relative">
                                                    @php
                                                        $avatarUrl = $user['profile_image'] ?? null;
                                                        $placeholderUrl = 'https://ui-avatars.com/api/?name=' . urlencode($user['first_name']) . '&background=2196f3&color=fff&size=40';
                                                    @endphp
                                                    <img src="{{ $avatarUrl ?: $placeholderUrl }}" 
                                                         class="user-avatar" 
                                                         alt="{{ $user['first_name'] }}"
                                                         onerror="this.src='{{ $placeholderUrl }}'">
                                                </div>
                                                <div class="flex-grow-1">
                                                    <div class="d-flex justify-content-between align-items-start mb-1">
                                                        <h6 class="mb-0 fw-bold">{{ $user['first_name'] }}</h6>
                                                        <small class="text-muted">{{ $user['last_message_time'] }}</small>
                                                    </div>
                                                    <p class="text-muted small mb-0 text-truncate" style="max-width: 200px;">
                                                        {{ $user['last_message'] }}
                                                    </p>
                                                </div>
                                            </a>
                                        </li>
                                    @empty
                                        <li class="text-center text-muted py-4">
                                            <i data-feather="message-circle" class="icon-lg mb-2"></i>
                                            <p>No conversations yet</p>
                                        </li>
                                    @endforelse
                                </ul>
                            </div>
                        </div>
                    </div>

                    <!-- Chat Content -->
                    <div class="col-lg-8 chat-content" id="chatContentArea">
                        <!-- Empty State -->
                        <div class="empty-state" id="emptyState">
                            <div class="empty-state-icon">
                                <i data-feather="message-circle"></i>
                            </div>
                            <h4>Select a conversation</h4>
                            <p>Choose a user from the list to start chatting</p>
                        </div>

                        <!-- Active Chat (hidden by default) -->
                        <div id="activeChat" style="display: none; height: 100%; flex-direction: column;">
                            <div class="chat-header border-bottom">
                                <div class="d-flex justify-content-between align-items-center">
                                    <div class="d-flex align-items-center">
                                        <i data-feather="corner-up-left" id="backToChatList" class="icon-lg me-2 ms-n2 text-muted d-lg-none"></i>
                                        <div class="dropdown me-2">
                                            <button class="action-menu-btn" type="button" id="customerActionMenu" data-bs-toggle="dropdown" aria-expanded="false">
                                                <i data-feather="more-vertical"></i>
                                            </button>
                                            <ul class="dropdown-menu" aria-labelledby="customerActionMenu">
                                                <li><a class="dropdown-item" href="javascript:;" id="viewAllOrders"><i data-feather="shopping-bag" class="icon-sm me-2"></i> All Orders</a></li>
                                                <li><a class="dropdown-item" href="javascript:;" id="viewRecentOrder"><i data-feather="package" class="icon-sm me-2"></i> Most Recent Order</a></li>
                                                <li><a class="dropdown-item" href="javascript:;" id="viewConsultancy"><i data-feather="help-circle" class="icon-sm me-2"></i> Consultancy</a></li>
                                            </ul>
                                        </div>
                                        <div>
                                            <h6 class="mb-0" id="chatUserName">User Name</h6>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="chat-body" id="chatBody">
                                <ul class="messages" id="messagesList">
                                    <!-- Messages will be loaded here -->
                                </ul>
                            </div>

                            <div class="chat-footer">
                                <form id="messageForm" class="d-flex align-items-center">
                                    <input type="text" 
                                           class="form-control" 
                                           id="messageInput" 
                                           placeholder="Type a message..." 
                                           autocomplete="off">
                                    <button type="submit" class="btn btn-primary ms-2" id="sendBtn">
                                        <i data-feather="send"></i>
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Customer Data Modal -->
<div class="modal fade customer-data-modal" id="customerDataModal" tabindex="-1" aria-labelledby="customerDataModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="customerDataModalLabel">Customer Information</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body" id="customerDataBody">
                <!-- Content will be loaded here -->
            </div>
        </div>
    </div>
</div>

@endsection

@section('scripts')
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
$(document).ready(function() {
    // Initialize feather icons
    if (typeof feather !== 'undefined') {
        feather.replace();
        // Re-initialize after a short delay to ensure all icons are rendered
        setTimeout(function() {
            feather.replace();
        }, 100);
    }

    let receiverId = null;
    let currentChatItem = null;
    let messagePolling = null;
    let lastMessageId = null;
    let isUserScrolling = false;

    // User search functionality
    $('#userSearch').on('input', function() {
        const searchTerm = $(this).val().toLowerCase().trim();
        if (searchTerm === '') {
            $('.chat-item').show();
            return;
        }
        
        $('.chat-item').each(function() {
            const searchText = $(this).data('search') || '';
            if (searchText.includes(searchTerm)) {
                $(this).show();
            } else {
                $(this).hide();
            }
        });
    });

    // Chat item click handler
    $(document).on('click', '.chat-item', function() {
        receiverId = $(this).data('id');
        const name = $(this).data('first_name');
        const image = $(this).data('image');
        const placeholderUrl = 'https://ui-avatars.com/api/?name=' + encodeURIComponent(name) + '&background=2196f3&color=fff&size=40';
        const avatarUrl = image || placeholderUrl;

        // Update active state
        $('.chat-item').removeClass('active');
        $(this).addClass('active');
        currentChatItem = $(this);

        // Update chat header
        $('#chatUserName').text(name);

        // Show active chat, hide empty state
        $('#emptyState').hide();
        $('#activeChat').show();

        // Reset last message ID and load messages
        lastMessageId = null;
        loadMessages(true);

        // Start polling for new messages
        startMessagePolling();
    });

    // Load messages
    function loadMessages(initialLoad = false) {
        if (!receiverId) return;

        $.ajax({
            url: "{{ url('/admin/chat/messages') }}/" + receiverId,
            type: 'GET',
            data: {
                _token: '{{ csrf_token() }}',
                receiver_id: receiverId,
                last_message_id: lastMessageId
            },
            success: function(res) {
                if (initialLoad || !lastMessageId) {
                    // Initial load - replace all messages
                    $('#messagesList').empty();
                    
                    if (!res.data || res.data.length === 0) {
                        $('#messagesList').html(`
                            <li class="text-center text-muted py-4">
                                <p>No messages yet. Start the conversation!</p>
                            </li>
                        `);
                        lastMessageId = null;
                        return;
                    }

                    res.data.forEach(msg => {
                        const isMe = msg.sender_id == {{ Auth::id() }};
                        const side = isMe ? 'me' : 'friend';
                        
                        const messageHtml = `
                            <li class="message-item ${side}" data-message-id="${msg.id || ''}">
                                <div class="content">
                                    <div class="bubble">
                                        <p>${escapeHtml(msg.message)}</p>
                                    </div>
                                    <span class="message-time">${msg.time}</span>
                                </div>
                            </li>
                        `;
                        $('#messagesList').append(messageHtml);
                        if (msg.id) {
                            lastMessageId = msg.id;
                        }
                    });

                    scrollToBottom();
                } else {
                    // Polling - only add new messages
                    if (res.data && res.data.length > 0) {
                        const existingIds = new Set();
                        $('#messagesList li[data-message-id]').each(function() {
                            const id = $(this).data('message-id');
                            if (id) existingIds.add(id.toString());
                        });

                        let hasNewMessages = false;
                        res.data.forEach(msg => {
                            const msgId = msg.id ? msg.id.toString() : null;
                            if (msgId && !existingIds.has(msgId)) {
                                const isMe = msg.sender_id == {{ Auth::id() }};
                                const side = isMe ? 'me' : 'friend';
                                
                                const messageHtml = `
                                    <li class="message-item ${side}" data-message-id="${msgId}">
                                        <div class="content">
                                            <div class="bubble">
                                                <p>${escapeHtml(msg.message)}</p>
                                            </div>
                                            <span class="message-time">${msg.time}</span>
                                        </div>
                                    </li>
                                `;
                                $('#messagesList').append(messageHtml);
                                lastMessageId = msg.id;
                                hasNewMessages = true;
                            }
                        });

                        // Only auto-scroll if user is near bottom or sent a message
                        if (hasNewMessages) {
                            const chatBody = $('#chatBody');
                            const isNearBottom = chatBody[0].scrollHeight - chatBody.scrollTop() - chatBody.height() < 100;
                            if (isNearBottom || isUserScrolling) {
                                scrollToBottom();
                            }
                        }
                    }
                }
                
                // Reinitialize feather icons for new content
                if (typeof feather !== 'undefined') {
                    feather.replace();
                }
            },
            error: function(xhr) {
                console.error('Error loading messages:', xhr);
            }
        });
    }

    // Send message
    $('#messageForm').on('submit', function(e) {
        e.preventDefault();
        sendMessage();
    });

    $('#sendBtn').on('click', function(e) {
        e.preventDefault();
        sendMessage();
    });

    // Send on Enter
    $('#messageInput').on('keypress', function(e) {
        if (e.which === 13 && !e.shiftKey) {
            e.preventDefault();
            sendMessage();
        }
    });

    function sendMessage() {
        const message = $('#messageInput').val().trim();

        if (!receiverId) {
            alert('Please select a user first!');
            return;
        }

        if (!message) {
            return;
        }

        // Add message to UI immediately (optimistic update)
        const tempId = 'temp-' + Date.now();
        const messageHtml = `
            <li class="message-item me" data-message-id="${tempId}">
                <div class="content">
                    <div class="bubble">
                        <p>${escapeHtml(message)}</p>
                    </div>
                    <span class="message-time">Just now</span>
                </div>
            </li>
        `;
        $('#messagesList').append(messageHtml);
        $('#messageInput').val('');
        scrollToBottom();
        isUserScrolling = true; // Mark that we should auto-scroll for new messages

        // Send to server
        $.ajax({
            url: '/chat/send',
            type: 'POST',
            data: {
                _token: '{{ csrf_token() }}',
                receiver_id: receiverId,
                message: message
            },
            success: function(res) {
                // Update the "Just now" message with actual time and ID
                if (res.data) {
                    if (res.data.id) {
                        lastMessageId = res.data.id;
                        // Update temp message with real ID
                        $(`li[data-message-id="${tempId}"]`).attr('data-message-id', res.data.id);
                    }
                    if (res.data.created_at) {
                        const time = new Date(res.data.created_at).toLocaleTimeString('en-US', {
                            hour: 'numeric',
                            minute: '2-digit'
                        });
                        $(`li[data-message-id="${tempId}"] .message-time`).text(time);
                    }
                }
                
                // Reinitialize feather icons
                if (typeof feather !== 'undefined') {
                    feather.replace();
                }
            },
            error: function(xhr) {
                console.error('Error sending message:', xhr);
                // Remove the optimistic message on error
                $('#messagesList li:last').remove();
                alert('Failed to send message. Please try again.');
            }
        });
    }

    // Scroll to bottom
    function scrollToBottom() {
        const chatBody = $('#chatBody');
        chatBody.animate({
            scrollTop: chatBody[0].scrollHeight
        }, 200);
    }

    // Track user scrolling to determine if we should auto-scroll
    $('#chatBody').on('scroll', function() {
        const chatBody = $(this);
        const isNearBottom = chatBody[0].scrollHeight - chatBody.scrollTop() - chatBody.height() < 100;
        isUserScrolling = isNearBottom;
    });

    // Start polling for new messages
    function startMessagePolling() {
        if (messagePolling) {
            clearInterval(messagePolling);
        }
        
        messagePolling = setInterval(function() {
            if (receiverId) {
                loadMessages(false);
            }
        }, 3000); // Poll every 3 seconds for real-time feel
    }

    // Stop polling when switching chats
    function stopMessagePolling() {
        if (messagePolling) {
            clearInterval(messagePolling);
            messagePolling = null;
        }
    }

    // Escape HTML to prevent XSS
    function escapeHtml(text) {
        const map = {
            '&': '&amp;',
            '<': '&lt;',
            '>': '&gt;',
            '"': '&quot;',
            "'": '&#039;'
        };
        return text.replace(/[&<>"']/g, m => map[m]);
    }

    // Back to chat list (mobile)
    $('#backToChatList').on('click', function() {
        $('#emptyState').show();
        $('#activeChat').hide();
        stopMessagePolling();
        receiverId = null;
    });

    // View All Orders
    $('#viewAllOrders').on('click', function() {
        if (!receiverId) return;
        
        $.ajax({
            url: "{{ route('chat.user.orders', ':id') }}".replace(':id', receiverId),
            type: 'GET',
            success: function(response) {
                if (response.status && response.data.length > 0) {
                    let html = `
                        <h6 class="mb-3">All Orders</h6>
                        <div class="table-responsive">
                            <table class="table table-bordered data-table">
                                <thead>
                                    <tr>
                                        <th>Order ID</th>
                                        <th>Status</th>
                                        <th>Amount Paid</th>
                                        <th>Placed Date</th>
                                        <th>Delivery Date</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                    `;
                    
                    response.data.forEach(order => {
                        const statusBadge = order.status === 'completed' ? 'bg-success' : 
                                          order.status === 'pending' ? 'bg-warning' : 
                                          order.status === 'cancelled' ? 'bg-danger' : 'bg-secondary';
                        html += `
                            <tr>
                                <td>${order.order_id}</td>
                                <td><span class="badge ${statusBadge}">${order.status}</span></td>
                                <td>₹${parseFloat(order.amount_paid || 0).toLocaleString('en-IN')}</td>
                                <td>${order.placed_date}</td>
                                <td>${order.deliver_date || '-'}</td>
                                <td>
                                    <button class="btn btn-sm btn-info view-order-detail-btn" data-order-id="${order.id}">
                                        <i data-feather="eye" class="icon-sm"></i> View
                                    </button>
                                </td>
                            </tr>
                        `;
                    });
                    
                    html += `
                                </tbody>
                            </table>
                        </div>
                    `;
                    
                    $('#customerDataModalLabel').text('All Orders');
                    $('#customerDataBody').html(html);
                    $('#customerDataModal').modal('show');
                    
                    // Reinitialize feather icons
                    if (typeof feather !== 'undefined') {
                        feather.replace();
                    }
                } else {
                    $('#customerDataModalLabel').text('All Orders');
                    $('#customerDataBody').html('<p class="text-muted text-center py-4">No orders found for this customer.</p>');
                    $('#customerDataModal').modal('show');
                }
            },
            error: function(xhr) {
                alert('Failed to load orders. Please try again.');
            }
        });
    });

    // View Most Recent Order
    $('#viewRecentOrder').on('click', function() {
        if (!receiverId) return;
        
        $.ajax({
            url: "{{ route('chat.user.orders', ':id') }}".replace(':id', receiverId),
            type: 'GET',
            success: function(response) {
                if (response.status && response.data.length > 0) {
                    const order = response.data[0]; // Most recent is first
                    showOrderDetails(order);
                } else {
                    $('#customerDataModalLabel').text('Most Recent Order');
                    $('#customerDataBody').html('<p class="text-muted text-center py-4">No orders found for this customer.</p>');
                    $('#customerDataModal').modal('show');
                }
            },
            error: function(xhr) {
                alert('Failed to load order. Please try again.');
            }
        });
    });

    // View order detail button handler
    $(document).on('click', '.view-order-detail-btn', function() {
        const orderId = $(this).data('order-id');
        
        $.ajax({
            url: "{{ route('chat.user.orders', ':id') }}".replace(':id', receiverId),
            type: 'GET',
            success: function(response) {
                if (response.status && response.data.length > 0) {
                    const order = response.data.find(o => o.id == orderId);
                    if (order) {
                        showOrderDetails(order);
                    }
                }
            },
            error: function(xhr) {
                alert('Failed to load order details. Please try again.');
            }
        });
    });

    // Function to show order details
    function showOrderDetails(order) {
        const statusBadge = order.status === 'completed' ? 'bg-success' : 
                          order.status === 'pending' ? 'bg-warning' : 
                          order.status === 'cancelled' ? 'bg-danger' : 'bg-secondary';
        
        let html = `
            <div class="row">
                <div class="col-md-6">
                    <h6 class="mb-3">Order Information</h6>
                    <table class="table table-bordered">
                        <tr>
                            <th width="40%">Order ID:</th>
                            <td>${order.order_id}</td>
                        </tr>
                        <tr>
                            <th>Customer Name:</th>
                            <td>${order.name || '-'}</td>
                        </tr>
                        <tr>
                            <th>Location:</th>
                            <td>${order.location || '-'}</td>
                        </tr>
                        <tr>
                            <th>Placed Date:</th>
                            <td>${order.placed_date}</td>
                        </tr>
                        <tr>
                            <th>Delivery Date:</th>
                            <td>${order.deliver_date || 'Not set'}</td>
                        </tr>
                        <tr>
                            <th>Delivered Date:</th>
                            <td>${order.delivered_date || 'Not delivered'}</td>
                        </tr>
                        <tr>
                            <th>Status:</th>
                            <td><span class="badge ${statusBadge}">${order.status}</span></td>
                        </tr>
                    </table>
                </div>
                <div class="col-md-6">
                    <h6 class="mb-3">Payment Information</h6>
                    <table class="table table-bordered">
                        <tr>
                            <th width="40%">Amount Paid:</th>
                            <td>₹${parseFloat(order.amount_paid || 0).toLocaleString('en-IN')}</td>
                        </tr>
                        <tr>
                            <th>Amount Remaining:</th>
                            <td>₹${parseFloat(order.amount_remaining || 0).toLocaleString('en-IN')}</td>
                        </tr>
                        <tr>
                            <th>Subtotal:</th>
                            <td>₹${parseFloat(order.subtotal || 0).toLocaleString('en-IN')}</td>
                        </tr>
                        <tr>
                            <th>Delivery Fee:</th>
                            <td>₹${parseFloat(order.delivery_fee || 0).toLocaleString('en-IN')}</td>
                        </tr>
                        <tr>
                            <th>Total Amount:</th>
                            <td><strong>₹${parseFloat(order.total_amount || 0).toLocaleString('en-IN')}</strong></td>
                        </tr>
                    </table>
                </div>
            </div>
        `;

        if (order.billing) {
            html += `
                <div class="mt-3">
                    <h6 class="mb-3">Billing Address</h6>
                    <div class="bg-light p-3 rounded">
                        <p class="mb-1"><strong>Name:</strong> ${order.billing.full_name || '-'}</p>
                        <p class="mb-1"><strong>Phone:</strong> ${order.billing.phone || '-'}</p>
                        <p class="mb-1"><strong>Address:</strong> ${order.billing.address || '-'}</p>
                        <p class="mb-0"><strong>City:</strong> ${order.billing.city || '-'}, <strong>State:</strong> ${order.billing.state || '-'}</p>
                    </div>
                </div>
            `;
        }

        if (order.items && order.items.length > 0) {
            html += `
                <div class="mt-3">
                    <h6 class="mb-3">Order Items</h6>
                    <div class="table-responsive">
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Product ID</th>
                                    <th>Variety</th>
                                    <th>Quality</th>
                                    <th>Price</th>
                                    <th>Quantity</th>
                                    <th>Total Price</th>
                                </tr>
                            </thead>
                            <tbody>
            `;
            
            order.items.forEach((item, index) => {
                html += `
                    <tr>
                        <td>${index + 1}</td>
                        <td>${item.product_id}</td>
                        <td>${item.variety}</td>
                        <td>${item.quality}</td>
                        <td>₹${parseFloat(item.price || 0).toLocaleString('en-IN')}</td>
                        <td>${item.quantity || 0}</td>
                        <td>₹${parseFloat(item.total_price || 0).toLocaleString('en-IN')}</td>
                    </tr>
                `;
            });
            
            html += `
                            </tbody>
                        </table>
                    </div>
                </div>
            `;
        }

        html += `
            <div class="mt-4 d-flex gap-2 flex-wrap">
                ${order.status !== 'completed' ? `
                    <button class="btn btn-success confirm-order-action-btn" data-order-id="${order.id}">
                        <i data-feather="check"></i> Confirm Order
                    </button>
                ` : ''}
                ${order.status !== 'cancelled' ? `
                    <button class="btn btn-warning cancel-order-action-btn" data-order-id="${order.id}">
                        <i data-feather="x"></i> Cancel Order
                    </button>
                ` : ''}
                <button class="btn btn-primary change-status-action-btn" data-order-id="${order.id}" data-current-status="${order.status}">
                    <i data-feather="edit"></i> Change Status
                </button>
                <button class="btn btn-info set-delivery-date-action-btn" data-order-id="${order.id}" data-current-date="${order.deliver_date_raw || ''}">
                    <i data-feather="calendar"></i> Set Delivery Date
                </button>
                <button class="btn btn-danger delete-order-action-btn" data-order-id="${order.id}">
                    <i data-feather="trash"></i> Delete Order
                </button>
            </div>
        `;
        
        $('#customerDataModalLabel').text(`Order Details - ${order.order_id}`);
        $('#customerDataBody').html(html);
        $('#customerDataModal').modal('show');
        
        // Reinitialize feather icons
        if (typeof feather !== 'undefined') {
            feather.replace();
        }
    }

    // View Consultancy
    $('#viewConsultancy').on('click', function() {
        if (!receiverId) return;
        
        $.ajax({
            url: "{{ route('chat.user.consultancy', ':id') }}".replace(':id', receiverId),
            type: 'GET',
            success: function(response) {
                if (response.status && response.data.length > 0) {
                    let html = `
                        <h6 class="mb-3">Consultancy Records</h6>
                        <div class="table-responsive">
                            <table class="table table-bordered data-table">
                                <thead>
                                    <tr>
                                        <th>Consultancy</th>
                                        <th>Sub Consultancy</th>
                                        <th>Date</th>
                                    </tr>
                                </thead>
                                <tbody>
                    `;
                    
                    response.data.forEach(consult => {
                        html += `
                            <tr>
                                <td>${consult.consultancy || '-'}</td>
                                <td>${consult.sub_consultancy || '-'}</td>
                                <td>${consult.created_at}</td>
                            </tr>
                        `;
                    });
                    
                    html += `
                                </tbody>
                            </table>
                        </div>
                    `;
                    
                    $('#customerDataModalLabel').text('Consultancy Records');
                    $('#customerDataBody').html(html);
                    $('#customerDataModal').modal('show');
                } else {
                    $('#customerDataModalLabel').text('Consultancy Records');
                    $('#customerDataBody').html('<p class="text-muted text-center py-4">No consultancy records found for this customer.</p>');
                    $('#customerDataModal').modal('show');
                }
            },
            error: function(xhr) {
                alert('Failed to load consultancy records. Please try again.');
            }
        });
    });

    // Order actions handlers
    $(document).on('click', '.confirm-order-action-btn', function() {
        const orderId = $(this).data('order-id');
        
        Swal.fire({
            title: 'Confirm Order?',
            text: 'Are you sure you want to confirm this order?',
            icon: 'question',
            showCancelButton: true,
            confirmButtonColor: '#28a745',
            cancelButtonColor: '#6c757d',
            confirmButtonText: 'Yes, confirm it!'
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: "{{ route('confirm_order', ':orderId') }}".replace(':orderId', orderId),
                    type: 'POST',
                    data: {
                        _token: '{{ csrf_token() }}'
                    },
                    success: function(response) {
                        if (response.status) {
                            Swal.fire({
                                icon: 'success',
                                title: 'Success',
                                text: response.message || 'Order confirmed successfully'
                            });
                            $('#customerDataModal').modal('hide');
                        }
                    },
                    error: function(xhr) {
                        Swal.fire({
                            icon: 'error',
                            title: 'Error',
                            text: xhr.responseJSON?.message || 'Failed to confirm order'
                        });
                    }
                });
            }
        });
    });

    $(document).on('click', '.cancel-order-action-btn', function() {
        const orderId = $(this).data('order-id');
        
        Swal.fire({
            title: 'Cancel Order?',
            text: 'Are you sure you want to cancel this order? This action cannot be undone.',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#dc3545',
            cancelButtonColor: '#6c757d',
            confirmButtonText: 'Yes, cancel it!'
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: "{{ route('order.cancel', ':id') }}".replace(':id', orderId),
                    type: 'POST',
                    data: {
                        _token: '{{ csrf_token() }}'
                    },
                    success: function(response) {
                        if (response.status) {
                            Swal.fire({
                                icon: 'success',
                                title: 'Cancelled',
                                text: response.message || 'Order cancelled successfully'
                            });
                            $('#customerDataModal').modal('hide');
                        }
                    },
                    error: function(xhr) {
                        Swal.fire({
                            icon: 'error',
                            title: 'Error',
                            text: xhr.responseJSON?.message || 'Failed to cancel order'
                        });
                    }
                });
            }
        });
    });

    $(document).on('click', '.change-status-action-btn', function() {
        const orderId = $(this).data('order-id');
        const currentStatus = $(this).data('current-status');
        
        Swal.fire({
            title: 'Change Order Status',
            input: 'select',
            inputOptions: {
                'pending': 'Pending',
                'completed': 'Completed',
                'cancelled': 'Cancelled'
            },
            inputValue: currentStatus,
            showCancelButton: true,
            confirmButtonText: 'Update',
            cancelButtonText: 'Cancel'
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: "{{ route('order.update_status', ':id') }}".replace(':id', orderId),
                    type: 'POST',
                    data: {
                        _token: '{{ csrf_token() }}',
                        status: result.value
                    },
                    success: function(response) {
                        if (response.status) {
                            Swal.fire({
                                icon: 'success',
                                title: 'Success',
                                text: response.message || 'Status updated successfully'
                            });
                            $('#customerDataModal').modal('hide');
                        }
                    },
                    error: function(xhr) {
                        Swal.fire({
                            icon: 'error',
                            title: 'Error',
                            text: xhr.responseJSON?.message || 'Failed to update status'
                        });
                    }
                });
            }
        });
    });

    $(document).on('click', '.set-delivery-date-action-btn', function() {
        const orderId = $(this).data('order-id');
        const currentDate = $(this).data('current-date');
        
        Swal.fire({
            title: 'Set Delivery Date',
            html: '<input type="date" id="deliveryDateInput" class="swal2-input" min="{{ date("Y-m-d") }}" value="' + (currentDate || '') + '">',
            showCancelButton: true,
            confirmButtonText: 'Save',
            cancelButtonText: 'Cancel',
            preConfirm: () => {
                return document.getElementById('deliveryDateInput').value;
            }
        }).then((result) => {
            if (result.isConfirmed && result.value) {
                $.ajax({
                    url: "{{ route('order.update_delivery_date', ':id') }}".replace(':id', orderId),
                    type: 'POST',
                    data: {
                        _token: '{{ csrf_token() }}',
                        deliver_date: result.value
                    },
                    success: function(response) {
                        if (response.status) {
                            Swal.fire({
                                icon: 'success',
                                title: 'Success',
                                text: response.message || 'Delivery date updated successfully'
                            });
                            $('#customerDataModal').modal('hide');
                        }
                    },
                    error: function(xhr) {
                        Swal.fire({
                            icon: 'error',
                            title: 'Error',
                            text: xhr.responseJSON?.message || 'Failed to update delivery date'
                        });
                    }
                });
            }
        });
    });

    $(document).on('click', '.delete-order-action-btn', function() {
        const orderId = $(this).data('order-id');
        
        Swal.fire({
            title: 'Delete Order?',
            text: 'Are you sure you want to delete this order? This action cannot be undone.',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#dc3545',
            cancelButtonColor: '#6c757d',
            confirmButtonText: 'Yes, delete it!'
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: "{{ url('/Order/delete') }}/" + orderId,
                    type: 'DELETE',
                    beforeSend: function(xhr) {
                        xhr.setRequestHeader('X-CSRF-TOKEN', $('meta[name="csrf-token"]').attr('content'));
                    },
                    success: function(response) {
                        if (response.status === true || response.status === 'success') {
                            Swal.fire({
                                icon: 'success',
                                title: 'Deleted',
                                text: response.message || 'Order deleted successfully'
                            });
                            $('#customerDataModal').modal('hide');
                        } else {
                            Swal.fire({
                                icon: 'warning',
                                title: 'Warning',
                                text: response.message || 'Something went wrong'
                            });
                        }
                    },
                    error: function(xhr) {
                        Swal.fire({
                            icon: 'error',
                            title: 'Error',
                            text: xhr.responseJSON?.message || 'Server error occurred'
                        });
                    }
                });
            }
        });
    });

    // Cleanup on page unload
    $(window).on('beforeunload', function() {
        stopMessagePolling();
    });
});
</script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
@endsection
