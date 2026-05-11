<?php include __DIR__ . '/../layouts/header.php'; ?>

<link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">

<style>
    :root {
        --guide-primary: #0ea5e9;
        --guide-bg: #f8fafc;
        --guide-card: #ffffff;
        --guide-border: #e2e8f0;
        --guide-text: #0f172a;
    }

    body { 
        background-color: var(--guide-bg); 
        font-family: 'Plus Jakarta Sans', sans-serif; 
    }

    .chat-widget { display: none !important; }

    .chat-container {
        max-width: 1200px;
        margin: 0 auto;
        padding: 40px 15px;
    }

    .chat-card {
        background: var(--guide-card);
        border-radius: 24px;
        border: 1px solid var(--guide-border);
        box-shadow: 0 10px 30px rgba(0,0,0,0.04);
        height: 75vh;
        min-height: 500px;
        overflow: hidden;
    }

    ::-webkit-scrollbar { width: 6px; }
    ::-webkit-scrollbar-track { background: transparent; }
    ::-webkit-scrollbar-thumb { background: #cbd5e1; border-radius: 10px; }
    ::-webkit-scrollbar-thumb:hover { background: #94a3b8; }

    /* CSS TIN NHẮN CÁCH LY */
    .guide-msg-bubble {
        max-width: 80%;
        padding: 12px 18px;
        border-radius: 18px;
        font-size: 0.95rem;
        line-height: 1.5;
        position: relative;
        word-wrap: break-word; 
    }
    
    .guide-msg-me {
        background: var(--guide-primary);
        color: white;
        border-bottom-right-radius: 4px;
        box-shadow: 0 4px 12px rgba(14, 165, 233, 0.2);
    }

    .guide-msg-customer {
        background: white;
        color: var(--guide-text);
        border-bottom-left-radius: 4px;
        border: 1px solid var(--guide-border);
        box-shadow: 0 2px 4px rgba(0,0,0,0.02);
    }

    .chat-input-wrapper {
        background: var(--guide-bg);
        border-radius: 16px;
        padding: 4px;
        border: 1px solid transparent;
        transition: all 0.3s ease;
    }
    
    .chat-input-wrapper:focus-within {
        border-color: var(--guide-primary);
        background: white;
        box-shadow: 0 0 0 4px rgba(14, 165, 233, 0.1);
    }

    .session-item {
        transition: all 0.2s ease;
        border: none !important;
        border-left: 4px solid transparent !important;
        cursor: pointer;
    }
    .session-item:hover {
        background: #f8fafc;
    }
    .session-item.active-session {
        background: #f0f9ff;
        border-left: 4px solid var(--guide-primary) !important;
    }
    
    /* CSS Xử lý Responsive Mobile */
    @media (max-width: 767.98px) {
        .chat-card { height: 85vh !important; }
        .chat-card .col-md-4 { 
            height: 35% !important; 
            border-right: none !important; 
            border-bottom: 2px solid var(--guide-border) !important;
        }
        .chat-card .col-md-8 { height: 65% !important; }
    }
</style>

<div class="chat-container">
    <div class="d-flex align-items-center gap-3 mb-4">
        <div style="background: #e0f2fe; color: #0ea5e9; width: 55px; height: 55px; border-radius: 18px; display: flex; align-items: center; justify-content: center; font-size: 1.6rem;">
            <i class="bi bi-chat-right-text-fill"></i>
        </div>
        <div>
            <h1 style="font-size: 1.8rem; font-weight: 800; color: #0f172a; margin: 0;">Trung tâm hỗ trợ khách đoàn</h1>
            <p class="text-muted mb-0">Trả lời nhanh các thắc mắc của khách hàng trong tour bạn phụ trách.</p>
        </div>
    </div>

    <div class="chat-card">
        <div class="row g-0 h-100">
            <div class="col-md-4 border-end d-flex flex-column bg-white h-100">
                <div class="p-3 border-bottom">
                    <div class="chat-input-wrapper d-flex align-items-center px-3 py-1" style="background: #f1f5f9;">
                        <i class="bi bi-search text-muted me-2"></i>
                        <input type="text" class="form-control border-0 shadow-none bg-transparent px-0" placeholder="Tìm kiếm khách..." style="font-size: 0.95rem;">
                    </div>
                </div>
                <div class="list-group list-group-flush overflow-auto flex-grow-1" id="sessionList" style="min-height: 0;">
                    <div class="text-center p-5 text-muted small">Đang tải danh sách khách hàng...</div>
                </div>
            </div>

            <div class="col-md-8 d-flex flex-column h-100" style="background: #f8fafc;">
                <div id="chatHeader" class="p-3 bg-white border-bottom d-flex align-items-center fw-bold shadow-sm z-1" style="min-height: 70px; color: #0f172a;">
                    <span class="text-muted fw-normal small"><i class="bi bi-info-circle me-2"></i>Chọn một cuộc hội thoại từ bên trái</span>
                </div>

                <div id="adminChatBody" class="p-4 flex-grow-1 overflow-auto d-flex flex-column gap-3" style="min-height: 0;">
                    <div class="text-center my-auto">
                        <img src="https://cdn-icons-png.flaticon.com/512/4080/4080911.png" style="width: 100px; opacity: 0.5;">
                        <p class="text-muted mt-3 small">Bắt đầu tư vấn cho khách hàng của bạn ngay bây giờ</p>
                    </div>
                </div>

                <div id="chatFooter" class="p-3 bg-white border-top d-none">
                    <form id="adminChatForm" onsubmit="adminSendMessage(event)">
                        <div class="chat-input-wrapper d-flex align-items-center ps-3 pe-1 py-1" style="background: #f1f5f9;">
                            <input type="text" id="adminChatInput" class="form-control border-0 shadow-none bg-transparent px-0" 
                                   placeholder="Nhập nội dung trả lời khách..." autocomplete="off" style="font-size: 0.95rem;">
                            <button class="btn btn-primary d-flex align-items-center justify-content-center ms-2" type="submit" style="border-radius: 12px; width: 40px; height: 40px; min-width: 40px;">
                                <i class="bi bi-send-fill"></i>
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="https://js.pusher.com/8.2.0/pusher.min.js"></script>

<script>
    let currentSessionId = null;

    function loadSessions() {
        // Chống cache bằng timestamp
        fetch('guide.php?action=getSessions&t=' + new Date().getTime())
            .then(res => res.json())
            .then(data => {
                const list = document.getElementById('sessionList');
                if (data.length === 0) {
                    list.innerHTML = '<div class="text-center p-5 text-muted small"><i class="bi bi-chat-square-dots fs-1 d-block mb-2 opacity-50"></i>Chưa có khách hàng nào nhắn tin.</div>';
                    return;
                }
                list.innerHTML = '';
                data.forEach(s => {
                    const isActive = s.session_id === currentSessionId ? 'active-session' : '';
                    const unreadBadge = (s.unread_count > 0 && s.session_id !== currentSessionId) 
                        ? `<span class="badge bg-danger rounded-pill" style="font-size: 0.65rem;">${s.unread_count}</span>` 
                        : '';
                    const msgStyle = (s.unread_count > 0 && s.session_id !== currentSessionId) ? 'fw-bold text-dark' : 'text-muted';

                    list.innerHTML += `
                        <button onclick="openChat('${s.session_id}', '${s.sender_name || 'Khách vãng lai'}')" 
                                class="list-group-item list-group-item-action p-3 session-item ${isActive}">
                            <div class="d-flex justify-content-between align-items-center mb-1">
                                <span class="fw-bold text-primary small text-truncate" style="max-width: 60%;">${s.sender_name || 'Khách vãng lai'}</span>
                                <div class="d-flex align-items-center gap-1">
                                    <span style="font-size: 10px;" class="text-muted">${new Date(s.created_at).toLocaleTimeString([], {hour: '2-digit', minute:'2-digit'})}</span>
                                    ${unreadBadge}
                                </div>
                            </div>
                            <div class="text-truncate mb-1 ${msgStyle}" style="font-size: 0.85rem; max-width: 200px;">${s.message}</div>
                            <div class="text-truncate" style="font-size: 0.75rem; color: #10b981;">
                                <i class="bi bi-geo-alt-fill me-1"></i>${s.tour_name || 'Đang hỗ trợ'}
                            </div>
                        </button>`;
                });
            });
    }

    async function openChat(sessionId, senderName) {
        currentSessionId = sessionId;
        document.getElementById('chatFooter').classList.remove('d-none'); // Mở khóa lớp vỏ bên ngoài
        document.getElementById('chatHeader').innerHTML = `<i class="bi bi-person-circle me-2 text-primary"></i> Đang hỗ trợ: ${senderName}`;
        
        try {
            await fetch('guide.php?action=markAsRead&session_id=' + sessionId, { method: 'POST' });

            const res = await fetch(`guide.php?action=getHistory&session_id=${sessionId}&t=` + new Date().getTime());
            const data = await res.json();
            
            const body = document.getElementById('adminChatBody');
            body.innerHTML = '';
            data.forEach(msg => {
                appendMessageUI(msg.sender_type, msg.message);
            });
            body.scrollTop = body.scrollHeight;
            
            loadSessions(); 
        } catch (error) {
            console.error('Lỗi khi mở đoạn chat:', error);
        }
    }

    function appendMessageUI(type, text) {
        const body = document.getElementById('adminChatBody');
        const isMe = (type !== 'customer'); 
        const msgHtml = `
            <div class="d-flex ${isMe ? 'justify-content-end' : 'justify-content-start'}">
                <div class="guide-msg-bubble ${isMe ? 'guide-msg-me' : 'guide-msg-customer'}">
                    ${text}
                </div>
            </div>`;
        body.insertAdjacentHTML('beforeend', msgHtml);
        body.scrollTop = body.scrollHeight;
    }

    async function adminSendMessage(e) {
        e.preventDefault();
        const input = document.getElementById('adminChatInput');
        const msg = input.value.trim();
        if(!msg || !currentSessionId) return;

        const formData = new FormData();
        formData.append('message', msg);
        formData.append('sender_type', 'guide');
        formData.append('session_id', currentSessionId);

        await fetch('guide.php?action=sendMessage', { method: 'POST', body: formData });
        
        appendMessageUI('guide', msg);
        input.value = '';
        loadSessions();
    }

    var guidePusher = new Pusher('e5405b1b2139fed6f8bc', { 
        cluster: 'ap1',
        forceTLS: true 
    });
    var guideChannel = guidePusher.subscribe('live-chat');

    guideChannel.bind('new-message', async function(data) {
        if (data.session_id === currentSessionId && data.sender_type === 'customer') {
            appendMessageUI(data.sender_type, data.message);
            await fetch('guide.php?action=markAsRead&session_id=' + data.session_id, { method: 'POST' });
        }
        loadSessions(); 
    });

    loadSessions();
</script>

<?php include __DIR__ . '/../layouts/footer.php'; ?>