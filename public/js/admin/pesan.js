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
  fetch('/chat/list')
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
  currentChatId = id;

  // Update nama di header
  if (chatName) {
    chatName.textContent = nama || 'Anonim';
  }

  // Stop channel lama
  if (channel) {
    window.Echo.leave(channel);
  }

  // Fetch messages
  fetch(`/chat/${id}`)
    .then(res => res.json())
    .then(data => {
      let html = '';

      if (data && data.length > 0) {
        data.forEach(msg => {
          let posisi = msg.sender_role === 'guru' ? 'right' : 'left';

          html += `
            <div class="message ${posisi}">
              ${msg.message}
            </div>
          `;
        });
      }

      const chatBox = document.getElementById('chat-box');
      if (chatBox) {
        chatBox.innerHTML = html;
      }

      scrollToBottom();
      
      // Highlight active chat
      const allChatItems = document.querySelectorAll('.chat-item');
      allChatItems.forEach(item => {
        item.classList.remove('active');
      });
      
      if (clickedElement) {
        clickedElement.classList.add('active');
      }
      
      // Show chat room on mobile, hide chat list
      if (window.innerWidth <= 768) {
        if (chatRoom) {
          chatRoom.classList.add('active');
        }
        if (chatList) {
          chatList.classList.add('hidden');
        }
      }
    })
    .catch(error => {
      console.error('Error loading messages:', error);
    });

  // JOIN CHANNEL BARU
  channel = 'chat.' + id;

  window.Echo.channel(channel)
    .listen('.message.sent', (e) => {
      let posisi = e.message.sender_role === 'guru' ? 'right' : 'left';

      let html = `
        <div class="message ${posisi}">
          ${e.message.message}
        </div>
      `;

      const chatBox = document.getElementById('chat-box');
      if (chatBox) {
        chatBox.innerHTML += html;
      }

      scrollToBottom();

      // Update sidebar
      loadChats();
    });
}

// ==========================
// SEND MESSAGE
// ==========================
function sendMessage() {
  const input = document.getElementById('message-input');
  
  if (!input) return;
  
  const message = input.value.trim();

  if (!message || !currentChatId) return;

  fetch('/chat/send', {
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
  .then(res => res.json())
  .then(res => {
    // Tampilkan langsung
    let html = `
      <div class="message right">
        ${message}
      </div>
    `;

    const chatBox = document.getElementById('chat-box');
    if (chatBox) {
      chatBox.innerHTML += html;
    }

    input.value = '';

    scrollToBottom();

    loadChats();
  })
  .catch(error => {
    console.error('Error sending message:', error);
    alert('Gagal mengirim pesan');
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