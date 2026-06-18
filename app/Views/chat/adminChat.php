<?= $this->extend('layouth/admin_layout') ?>

<?= $this->section('content') ?>
<style>
.chat-wrapper { display: flex; height: calc(100vh - 250px); min-height: 450px; border: 1px solid #dee2e6; border-radius: 8px; overflow: hidden; }
.chat-sidebar { width: 340px; border-right: 1px solid #dee2e6; display: flex; flex-direction: column; flex-shrink: 0; }
.chat-sidebar-header { padding: 15px; border-bottom: 1px solid #dee2e6; background: #f8f9fa; }
.chat-sidebar-list { flex: 1; overflow-y: auto; }
.chat-user-item { padding: 12px 15px; cursor: default; border-bottom: 1px solid #f0f0f0; display: flex; align-items: center; gap: 10px; }
.chat-user-item .user-avatar { width: 40px; height: 40px; border-radius: 50%; object-fit: cover; }
.chat-user-item .badge-role { font-size: 10px; padding: 2px 6px; border-radius: 4px; }
.chat-main { flex: 1; display: flex; flex-direction: column; min-width: 0; }
.chat-main-header { padding: 15px 20px; border-bottom: 1px solid #dee2e6; background: #f8f9fa; }
.chat-messages { flex: 1; overflow-y: auto; padding: 20px; background: #f8f9fa; }
.chat-message { margin-bottom: 15px; display: flex; }
.chat-message .label { font-size: 10px; font-weight: bold; margin-bottom: 2px; }
.chat-message .bubble { max-width: 90%; padding: 10px 15px; border-radius: 12px; font-size: 14px; line-height: 1.4; word-wrap: break-word; }
.chat-message.from-sender .bubble { background: #1b3cde; color: white; border-bottom-left-radius: 4px; }
.chat-message.from-receiver .bubble { background: #28a745; color: white; border-bottom-right-radius: 4px; }
.chat-message .time { font-size: 11px; color: #999; margin-top: 4px; }
.chat-message.from-sender .time { color: rgba(255,255,255,0.7); }
.chat-message.from-receiver .time { color: rgba(255,255,255,0.7); }
.chat-empty { display: flex; flex: 1; align-items: center; justify-content: center; flex-direction: column; color: #aaa; }
.chat-empty i { font-size: 64px; margin-bottom: 15px; }
.stat-card { border-radius: 8px; padding: 15px; margin-bottom: 15px; }
</style>

<div class="row mb-3">
    <div class="col-md-3">
        <div class="stat-card bg-primary text-white">
            <h5 class="mb-0" id="totalChats">0</h5>
            <small>Total Percakapan Aktif</small>
        </div>
    </div>
</div>

<div class="pd-20 bg-white border-radius-4 box-shadow mb-30">
    <div class="chat-wrapper">
        <div class="chat-sidebar">
            <div class="chat-sidebar-header">
                <h6 class="mb-0">Live Chat Monitor</h6>
            </div>
            <div class="chat-sidebar-list" id="conversationList">
                <div class="text-center py-4 text-muted">Loading...</div>
            </div>
        </div>
        <div class="chat-main" id="chatMain">
            <div class="chat-empty">
                <i class="bi bi-chat-dots"></i>
                <p>Pilih percakapan untuk melihat pesan</p>
            </div>
        </div>
    </div>
</div>

<?= $this->endSection() ?>

<?= $this->section('script') ?>
<script>
let currentConversationId = null;
let pollInterval = null;
let currentUserId = <?= session()->get('id') ?: 'null' ?>;

$(document).ready(function() {
    loadConversations();
});

function loadConversations() {
    $.ajax({
        url: '<?= base_url('/api/v1/chat/conversations') ?>',
        type: 'GET',
        dataType: 'json',
        success: function(res) {
            if (res.status && res.data.length > 0) {
                let html = '';
                $('#totalChats').text(res.data.length);
                $.each(res.data, function(i, item) {
                    const s = item.sender || {};
                    const r = item.receiver || {};
                    const lastMsg = item.last_message || {};
                    const msgCount = item.message_count || 0;
                    const time = lastMsg.created_at ? new Date(lastMsg.created_at).toLocaleString('id-ID', { hour: '2-digit', minute: '2-digit' }) : '';
                    const layanan = item.layanan ? item.layanan.nama_jasa : '-';
                    const isActive = currentConversationId === item.conversation.id;
                    html += `
                        <div class="chat-user-item ${isActive ? 'bg-light' : ''}" data-conv-id="${item.conversation.id}" data-sender-id="${s.id || 0}" data-receiver-id="${r.id || 0}" onclick="viewConversation(${item.conversation.id})" style="cursor:pointer">
                            <div class="flex-grow-1 min-width-0">
                                <div class="d-flex justify-content-between align-items-center">
                                    <div>
                                        <strong>${escapeHtml(s.username || 'Unknown')}</strong>
                                        <span class="badge-role bg-info text-white">${s.role || '?'}</span>
                                        <small class="text-muted mx-1">→</small>
                                        <strong>${escapeHtml(r.username || 'Unknown')}</strong>
                                        <span class="badge-role bg-success text-white">${r.role || '?'}</span>
                                    </div>
                                    <small class="text-muted">${time}</small>
                                </div>
                                <div class="d-flex justify-content-between mt-1">
                                    <small class="text-muted text-truncate d-block" style="max-width:250px">${lastMsg.message ? escapeHtml(lastMsg.message) : 'Belum ada pesan'}</small>
                                    <small class="text-muted">${msgCount} pesan</small>
                                </div>
                                ${layanan !== '-' ? `<small class="text-info">Layanan: ${escapeHtml(layanan)}</small>` : ''}
                            </div>
                        </div>
                    `;
                });
                $('#conversationList').html(html);
            } else {
                $('#conversationList').html('<div class="text-center py-4 text-muted">Belum ada percakapan aktif</div>');
                $('#totalChats').text('0');
            }
        }
    });
}

function viewConversation(convId) {
    currentConversationId = convId;
    $('.chat-user-item').removeClass('bg-light');
    $(`.chat-user-item[data-conv-id="${convId}"]`).addClass('bg-light');

    $.ajax({
        url: '<?= base_url('/api/v1/chat/messages') ?>/' + convId,
        type: 'GET',
        dataType: 'json',
        success: function(res) {
            if (res.status) {
                renderMessages(convId, res.data);
            }
        }
    });
}

function renderMessages(convId, messages) {
    const conv = $(`.chat-user-item[data-conv-id="${convId}"]`);
    const senderId = parseInt(conv.data('sender-id'));
    const receiverId = parseInt(conv.data('receiver-id'));
    const senderName = conv.find('strong:first').text() || 'Sender';
    const receiverName = conv.find('strong:last').text() || 'Receiver';

    let msgHtml = '';
    $.each(messages, function(i, msg) {
        const isSender = parseInt(msg.sender_id) === senderId;
        const time = new Date(msg.created_at).toLocaleString('id-ID', { hour: '2-digit', minute: '2-digit', day: 'numeric', month: 'short' });
        const who = isSender ? senderName : receiverName;
        msgHtml += `
            <div class="chat-message ${isSender ? 'from-sender' : 'from-receiver'}" data-msg-id="${msg.id}">
                <div>
                    <div class="label">${escapeHtml(who)}</div>
                    <div class="bubble">${escapeHtml(msg.message)}</div>
                    <div class="time">${time}</div>
                </div>
            </div>
        `;
    });

    $('#chatMain').html(`
        <div class="chat-main-header">
            <div>
                <strong>${escapeHtml(senderName)}</strong> <span class="text-muted">↔</span> <strong>${escapeHtml(receiverName)}</strong>
                <span class="ml-2 text-muted">(Read-only)</span>
            </div>
        </div>
        <div class="chat-messages" id="chatMessages">
            ${msgHtml}
        </div>
    `);

    scrollToBottom();
    if (pollInterval) clearInterval(pollInterval);
    pollInterval = setInterval(() => pollMessages(convId), 5000);
}

function pollMessages(convId) {
    $.ajax({
        url: '<?= base_url('/api/v1/chat/messages') ?>/' + convId,
        type: 'GET',
        dataType: 'json',
        success: function(res) {
            if (res.status) {
                const existingCount = $('#chatMessages .chat-message').length;
                const lastExistingId = $('#chatMessages .chat-message:last').data('msg-id') || 0;
                const lastServerId = res.data.length > 0 ? res.data[res.data.length - 1].id : 0;
                if (lastServerId > lastExistingId) {
                    renderMessages(convId, res.data);
                    loadConversations();
                }
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
<?= $this->endSection() ?>
