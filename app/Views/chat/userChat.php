<!DOCTYPE html>
<html lang="en">
<?= view('userPages/layout/header') ?>
<body style="background-color: #f8f9fa;">

<?= view('userPages/layout/navbar') ?>

<div class="container my-4">
    <div class="card shadow border-0 rounded-lg overflow-hidden">
        <div class="card-body p-0">
            <style>
                .chat-wrapper { display: flex; height: calc(100vh - 200px); min-height: 500px; }
                .chat-sidebar { width: 320px; border-right: 1px solid #dee2e6; display: flex; flex-direction: column; flex-shrink: 0; }
                .chat-sidebar-header { padding: 15px; border-bottom: 1px solid #dee2e6; background: #f8f9fa; }
                .chat-sidebar-list { flex: 1; overflow-y: auto; }
                .chat-user-item { padding: 12px 15px; cursor: pointer; border-bottom: 1px solid #f0f0f0; transition: background 0.2s; display: flex; align-items: center; gap: 10px; }
                .chat-user-item:hover { background: #f0f7ff; }
                .chat-user-item.active { background: #e3f2fd; }
                .chat-user-item .user-avatar { width: 40px; height: 40px; border-radius: 50%; object-fit: cover; }
                .chat-user-item .unread-badge { background: #dc3545; color: white; border-radius: 50%; width: 22px; height: 22px; display: flex; align-items: center; justify-content: center; font-size: 11px; font-weight: bold; flex-shrink: 0; }
                .chat-main { flex: 1; display: flex; flex-direction: column; min-width: 0; }
                .chat-main-header { padding: 15px 20px; border-bottom: 1px solid #dee2e6; background: #f8f9fa; display: flex; align-items: center; justify-content: space-between; }
                .chat-messages { flex: 1; overflow-y: auto; padding: 20px; background: #f8f9fa; }
                .chat-message { margin-bottom: 15px; display: flex; }
                .chat-message.sent { justify-content: flex-end; }
                .chat-message .bubble { max-width: 90%; padding: 10px 15px; border-radius: 12px; font-size: 14px; line-height: 1.4; word-wrap: break-word; }
                .chat-message.sent .bubble { background: #1b3cde; color: white; border-bottom-right-radius: 4px; }
                .chat-message.received .bubble { background: white; color: #333; border: 1px solid #dee2e6; border-bottom-left-radius: 4px; }
                .chat-message .time { font-size: 11px; color: #999; margin-top: 4px; }
                .chat-message.sent .time { text-align: right; color: rgba(255,255,255,0.7); }
                .chat-input-area { padding: 15px 20px; border-top: 1px solid #dee2e6; background: white; }
                .chat-empty { display: flex; flex: 1; align-items: center; justify-content: center; flex-direction: column; color: #aaa; }
                .chat-empty i { font-size: 64px; margin-bottom: 15px; }
                @media (max-width: 768px) {
                    .chat-sidebar { width: 100%; }
                    .chat-main { display: none; }
                    .chat-main.active { display: flex; }
                    .chat-sidebar.hide { display: none; }
                }
            </style>

            <div class="chat-wrapper" id="chatWrapper">
                <div class="chat-sidebar" id="chatSidebar">
                    <div class="chat-sidebar-header d-flex justify-content-between align-items-center">
                        <h6 class="mb-0">Percakapan</h6>
                        <button class="btn btn-sm btn-outline-primary d-md-none" onclick="toggleSidebar()">←</button>
                    </div>
                    <div class="chat-sidebar-list" id="conversationList">
                        <div class="text-center py-4 text-muted">Loading...</div>
                    </div>
                </div>
                <div class="chat-main" id="chatMain">
                    <div class="chat-empty">
                        <i class="bi bi-chat-dots"></i>
                        <p>Pilih percakapan untuk mulai chat</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?= view('userPages/layout/footer') ?>

<script>
let currentConversationId = null;
let pollInterval = null;
let currentUserId = <?= session()->get('id') ?: 'null' ?>;

$(document).ready(function() {
    loadConversations();
    const urlConvId = window.location.pathname.split('/').pop();
    if (urlConvId && !isNaN(urlConvId)) {
        setTimeout(() => openConversation(parseInt(urlConvId)), 500);
    }
});

function toggleSidebar() {
    $('#chatSidebar').toggleClass('hide');
    $('#chatMain').toggleClass('active');
}

function loadConversations() {
    $.ajax({
        url: '<?= base_url('/api/v1/chat/conversations') ?>',
        type: 'GET',
        dataType: 'json',
        success: function(res) {
            if (res.status && res.data.length > 0) {
                let html = '';
                $.each(res.data, function(i, item) {
                    const other = item.other_user || {};
                    const lastMsg = item.last_message || {};
                    const unread = item.unread_count || 0;
                    const time = lastMsg.created_at ? new Date(lastMsg.created_at).toLocaleString('id-ID', { hour: '2-digit', minute: '2-digit' }) : '';
                    const isActive = currentConversationId === item.conversation.id;
                    html += `
                        <div class="chat-user-item ${isActive ? 'active' : ''}" data-conv-id="${item.conversation.id}" onclick="openConversation(${item.conversation.id})">
                            <img src="/${other.avatar_url || 'template/images/avatar.png'}" class="user-avatar" alt="">
                            <div class="flex-grow-1 min-width-0" style="min-width:0">
                                <div class="d-flex justify-content-between">
                                    <strong class="text-truncate d-block">${escapeHtml(other.username || 'Unknown')}</strong>
                                    <small class="text-muted flex-shrink-0">${time}</small>
                                </div>
                                <div class="d-flex justify-content-between align-items-center">
                                    <small class="text-muted text-truncate d-block" style="max-width:240px">${lastMsg.message ? escapeHtml(lastMsg.message) : 'Belum ada pesan'}</small>
                                    ${unread > 0 ? `<span class="unread-badge">${unread}</span>` : ''}
                                </div>
                            </div>
                        </div>
                    `;
                });
                $('#conversationList').html(html);
            } else {
                $('#conversationList').html('<div class="text-center py-4 text-muted">Belum ada percakapan</div>');
            }
        }
    });
}

function openConversation(convId) {
    currentConversationId = convId;
    $('.chat-user-item').removeClass('active');
    $(`.chat-user-item[data-conv-id="${convId}"]`).addClass('active');

    $.ajax({
        url: '<?= base_url('/api/v1/chat/messages') ?>/' + convId,
        type: 'GET',
        dataType: 'json',
        success: function(res) {
            if (res.status) {
                renderChatRoom(convId, res.data);
                if ($(window).width() < 768) toggleSidebar();
            }
        }
    });
}

function renderChatRoom(convId, messages) {
    const conv = $(`.chat-user-item[data-conv-id="${convId}"]`);
    const otherName = conv.find('strong').text() || 'Chat';
    const otherAvatar = conv.find('.user-avatar').attr('src') || '/template/images/avatar.png';

    let msgHtml = '';
    $.each(messages, function(i, msg) {
        const isSent = parseInt(msg.sender_id) === currentUserId;
        const time = new Date(msg.created_at).toLocaleString('id-ID', { hour: '2-digit', minute: '2-digit' });
        msgHtml += `
            <div class="chat-message ${isSent ? 'sent' : 'received'}" data-msg-id="${msg.id}">
                <div>
                    <div class="bubble">${escapeHtml(msg.message)}</div>
                    <div class="time">${time}</div>
                </div>
            </div>
        `;
    });

    $('#chatMain').html(`
        <div class="chat-main-header">
            <div class="d-flex align-items-center gap-2">
                <button class="btn btn-sm btn-outline-secondary d-md-none me-1" onclick="toggleSidebar()">☰</button>
                <img src="${otherAvatar}" class="user-avatar" style="width:36px;height:36px;border-radius:50%;object-fit:cover;" alt="">
                <strong>${escapeHtml(otherName)}</strong>
            </div>
            <button class="btn btn-sm btn-outline-danger" onclick="closeConversation(${convId})">Tutup</button>
        </div>
        <div class="chat-messages" id="chatMessages">
            ${msgHtml}
        </div>
        <div class="chat-input-area">
            <div class="input-group">
                <textarea class="form-control" id="messageInput" placeholder="Ketik pesan..." maxlength="1000" rows="1" style="resize:none" onkeypress="if(event.key==='Enter' && !event.shiftKey) { event.preventDefault(); sendMessage(); }"></textarea>
                <button class="btn btn-primary" onclick="sendMessage()">Kirim</button>
            </div>
        </div>
    `);

    scrollToBottom();
    if (pollInterval) clearInterval(pollInterval);
    pollInterval = setInterval(() => pollMessages(convId), 3000);
}

function autoResize(el) {
    el.style.height = 'auto';
    el.style.height = el.scrollHeight + 'px';
}

$(document).on('input', '#messageInput', function() {
    autoResize(this);
});

function sendMessage() {
    const msg = $('#messageInput').val().trim();
    if (!msg || !currentConversationId) return;

    $.ajax({
        url: '<?= base_url('/api/v1/chat/send') ?>',
        type: 'POST',
        dataType: 'json',
        data: { conversation_id: currentConversationId, message: msg },
        success: function(res) {
            if (res.status) {
                $('#messageInput').val('').height('auto');
                const time = new Date(res.data.created_at).toLocaleString('id-ID', { hour: '2-digit', minute: '2-digit' });
                $('#chatMessages').append(`
                    <div class="chat-message sent" data-msg-id="${res.data.id}">
                        <div>
                            <div class="bubble">${escapeHtml(res.data.message)}</div>
                            <div class="time">${time}</div>
                        </div>
                    </div>
                `);
                scrollToBottom();
                loadConversations();
            }
        }
    });
}

function pollMessages(convId) {
    $.ajax({
        url: '<?= base_url('/api/v1/chat/messages') ?>/' + convId,
        type: 'GET',
        dataType: 'json',
        success: function(res) {
            if (res.status) {
                const lastExistingId = parseInt($('#chatMessages .chat-message:last').data('msg-id')) || 0;
                const newMsgs = res.data.filter(function(m) { return parseInt(m.id) > lastExistingId; });
                if (newMsgs.length > 0) {
                    $.each(newMsgs, function(i, msg) {
                        const isSent = parseInt(msg.sender_id) === currentUserId;
                        if (!isSent) {
                            const time = new Date(msg.created_at).toLocaleString('id-ID', { hour: '2-digit', minute: '2-digit' });
                            $('#chatMessages').append(`
                                <div class="chat-message received" data-msg-id="${msg.id}">
                                    <div>
                                        <div class="bubble">${escapeHtml(msg.message)}</div>
                                        <div class="time">${time}</div>
                                    </div>
                                </div>
                            `);
                            scrollToBottom();
                            loadConversations();
                        }
                    });
                }
            }
        }
    });
}

function closeConversation(convId) {
    if (!confirm('Tutup percakapan ini?')) return;
    $.ajax({
        url: '<?= base_url('/api/v1/chat/close') ?>/' + convId,
        type: 'POST',
        dataType: 'json',
        success: function(res) {
            if (res.status) {
                if (pollInterval) clearInterval(pollInterval);
                currentConversationId = null;
                $('#chatMain').html('<div class="chat-empty"><i class="bi bi-chat-dots"></i><p>Pilih percakapan untuk mulai chat</p></div>');
                loadConversations();
            }
        }
    });
}

function scrollToBottom() {
    setTimeout(() => {
        const el = document.getElementById('chatMessages');
        if (el) el.scrollTop = el.scrollHeight;
    }, 100);
}

function escapeHtml(text) {
    const div = document.createElement('div');
    div.textContent = text;
    return div.innerHTML;
}
</script>

</body>
</html>
