// ==========================
// ELEMENT GLOBAL
// ==========================
const chatRoom = document.querySelector(".chat-room");
const chatList = document.querySelector(".chat-list");
const chatName = document.getElementById("chatName");
const chatBody = document.getElementById("chat-box");
let currentChatId = null;
let channel = null;

// ==========================
// HAMBURGER TOGGLE SIDEBAR
// ==========================
const hamburger = document.getElementById("hamburgerBtn");
const mobileHamburger = document.getElementById("mobileHamburger");
const sidebar = document.getElementById("sidebar");
const overlay = document.getElementById("sidebarOverlay");

function openSidebar() {
  if (sidebar) {
    sidebar.classList.add("active");
  }
  if (overlay) {
    overlay.classList.add("active");
  }
  document.body.style.overflow = "hidden";
}

function closeSidebar() {
  if (sidebar) {
    sidebar.classList.remove("active");
  }
  if (overlay) {
    overlay.classList.remove("active");
  }
  document.body.style.overflow = "";
}

if (hamburger) {
  hamburger.addEventListener("click", () => {
    if (sidebar.classList.contains("active")) {
      closeSidebar();
    } else {
      openSidebar();
    }
  });
}

if (mobileHamburger) {
  mobileHamburger.addEventListener("click", () => {
    if (sidebar.classList.contains("active")) {
      closeSidebar();
    } else {
      openSidebar();
    }
  });
}

if (overlay) {
  overlay.addEventListener("click", closeSidebar);
}

// ==========================
// MENU ACTIVE SIDEBAR
// ==========================
const menuItems = document.querySelectorAll(".menu li");

menuItems.forEach((item) => {
  item.addEventListener("click", () => {
    const activeItem = document.querySelector(".menu .active");
    if (activeItem) {
      activeItem.classList.remove("active");
    }
    item.classList.add("active");
    
    if (window.innerWidth <= 768) {
      closeSidebar();
    }
  });
});

// ==========================
// LOGOUT BUTTON
// ==========================
const logoutBtn = document.querySelector(".logout");
if (logoutBtn) {
  logoutBtn.addEventListener("click", (e) => {
    e.preventDefault();
    if (confirm("Apakah anda yakin ingin keluar?")) {
      const form = logoutBtn.closest('form');
      if (form) {
        form.submit();
      }
    }
  });
}

// ==========================
// BACK BUTTON (MOBILE)
// ==========================
function goBack() {
  if (window.innerWidth <= 768) {
    if (chatRoom) {
      chatRoom.classList.remove("active");
    }
    if (chatList) {
      chatList.classList.remove("hidden");
    }
  }
}

// ==========================
// AUTO FIX SAAT RESIZE
// ==========================
window.addEventListener("resize", function () {
  if (window.innerWidth > 768) {
    if (chatRoom) {
      chatRoom.classList.remove("active");
    }
    if (chatList) {
      chatList.classList.remove("hidden");
    }
  }
});

// ==========================
// SCROLL TO BOTTOM
// ==========================
function scrollToBottom() {
  const chatBox = document.getElementById('chat-box');
  if (chatBox) {
    setTimeout(() => {
      chatBox.scrollTop = chatBox.scrollHeight;
    }, 100);
  }
}

// ==========================
// LOAD CHATS
// ==========================
function loadChats() {
  fetch('/admin/chat/list')
    .then(res => res.json())
    .then(data => {
      let html = '';
      
      if (data && data.length > 0) {
        data.forEach(chat => {
          const nama = chat.nama_anonim || 'Anonim';
          const lastMessage = chat.last_message || '';
          const inisial = nama.charAt(0).toUpperCase();
          
          html += `
            <div class="chat-item" data-chat-id="${chat.id_chat}" data-chat-name="${nama}">
              <div class="avatar">${inisial}</div>
              <div class="chat-info">
                <h4>${nama}</h4>
                <p>${lastMessage}</p>
              </div>
            </div>
          `;
        });
      } else {
        html = '<div class="empty-chat"><p>Belum ada chat</p></div>';
      }

      const chatListContainer = document.getElementById('chat-list');
      if (chatListContainer) {
        chatListContainer.innerHTML = html;
        
        // Add click listeners to chat items
        const chatItems = chatListContainer.querySelectorAll('.chat-item');
        chatItems.forEach(item => {
          item.addEventListener('click', function() {
            const chatId = this.getAttribute('data-chat-id');
            const chatNama = this.getAttribute('data-chat-name');
            openChat(chatId, chatNama, this);
          });
        });
      }
    })
    .catch(error => {
      console.error('Error loading chats:', error);
    });
}

// ==========================
// OPEN CHAT
// ==========================

function openChat(id, nama, clickedElement) {

  console.log("📡 DEBUG ECHO:", window.Echo);

const testChannel = 'chat.' + currentChatId;

console.log("📡 JOIN CHANNEL:", testChannel);

window.Echo.channel(testChannel)
  .subscribed(() => {
    console.log("✅ SUBSCRIBED:", testChannel);
  })
  .listen('.message.sent', (e) => {

    console.log("🔥 REALTIME MASUK:", e);

    alert("REALTIME MASUK!");

    chatBody.innerHTML += `
      <div class="message left">
        ${e.message.message}
      </div>
    `;

  });

  currentChatId = id;

  if (chatName) {
    chatName.textContent = nama || 'Anonim';
  }

  // ❌ leave channel lama
  if (channel && window.Echo) {
    window.Echo.leave(channel);
  }

  // ambil pesan
  fetch(`/admin/chat/${id}`)
    .then(res => res.json())
    .then(data => {

      let html = '';

      data.forEach(msg => {
        const posisi = msg.sender_role === 'guru' ? 'right' : 'left';

        html += `
          <div class="message ${posisi}">
            ${msg.message}
          </div>
        `;
      });

      chatBody.innerHTML = html;
      scrollToBottom();

    })
    .catch(err => console.error("❌ FETCH ERROR:", err));

  // =========================
  // REALTIME
  // =========================
  setTimeout(() => {

    if (!window.Echo) {
      console.error("Echo belum siap");
      return;
    }

    channel = 'chat.' + id;

    window.Echo.channel(channel)
      .listen('.message.sent', (e) => {

        console.log("🔥 REALTIME:", e);

        // filter chat
        if (e.message.id_chat != currentChatId) return;

        // filter supaya tidak double (opsional)
        if (e.message.sender_role === 'guru') return;

        chatBody.innerHTML += `
          <div class="message left">
            ${e.message.message}
          </div>
        `;

        scrollToBottom();
      });

  }, 300);
}
// ==========================
// SEND MESSAGE
// ==========================
function sendMessage() {

  const input = document.getElementById('message-input');

  if (!input) return;

  const message = input.value.trim();

  console.log("📤 SEND ADMIN DEBUG:", {
    message,
    currentChatId
  });

  if (!message || !currentChatId) {
    console.warn("⚠️ kosong / chat belum dipilih");
    return;
  }

  fetch('/admin/chat/send', {
    method: 'POST',
    headers: {
      'Content-Type': 'application/json',
      'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
    },
    body: JSON.stringify({
      id_chat: currentChatId,
      message: message
    })
  })
  .then(res => {
    console.log("📡 STATUS:", res.status);
    return res.json();
  })
  .then(res => {

    console.log("📥 RESPONSE:", res);

    if (!res.success) {
      console.error("❌ SERVER ERROR:", res);
      alert(res.error || "Gagal kirim pesan");
      return;
    }

    // tampil langsung
    chatBody.innerHTML += `
      <div class="message right">
        ${res.message.message}
      </div>
    `;

    input.value = '';
    chatBody.scrollTop = chatBody.scrollHeight;

  })
  .catch(err => {
    console.error("❌ FETCH ERROR:", err);
  });
}

// ==========================
// SEARCH CHAT
// ==========================
function searchChat() {
  const searchInput = document.getElementById('searchChat');
  
  if (!searchInput) return;
  
  searchInput.addEventListener('input', function(e) {
    const searchTerm = e.target.value.toLowerCase();
    const chatItems = document.querySelectorAll('.chat-item');
    
    chatItems.forEach(item => {
      const nama = item.querySelector('.chat-info h4');
      const message = item.querySelector('.chat-info p');
      
      if (nama && message) {
        const namaText = nama.textContent.toLowerCase();
        const messageText = message.textContent.toLowerCase();
        
        if (namaText.includes(searchTerm) || messageText.includes(searchTerm)) {
          item.style.display = 'flex';
        } else {
          item.style.display = 'none';
        }
      }
    });
  });
}

// ==========================
// INIT ON LOAD
// ==========================
document.addEventListener("DOMContentLoaded", function () {
  // Load chats
  loadChats();
  
  // Setup search
  searchChat();
  
  // Enter to send message
  const messageInput = document.getElementById("message-input");
  if (messageInput) {
    messageInput.addEventListener("keypress", function(e) {
      if (e.key === "Enter") {
        e.preventDefault();
        sendMessage();
      }
    });
  }
});