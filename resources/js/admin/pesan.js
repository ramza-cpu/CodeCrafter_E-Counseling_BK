// =====================
// ELEMENT GLOBAL
// =====================

const chatRoom = document.querySelector(".chat-room");
const chatList = document.querySelector(".chat-list");
// const sidebar = document.querySelector(".sidebar");
const chatName = document.getElementById("chatName");
const chatBody = document.getElementById("chatBody");
let currentChatId = null;
let channel = null;

// =====================
// BACK BUTTON (MOBILE)
// =====================

function goBack() {
  if (window.innerWidth <= 768) {
    if (chatRoom) chatRoom.classList.remove("active");
    if (chatList) chatList.style.display = "flex";
  }
}


function scrollToBottom() {
    const chatBox = document.getElementById('chat-box');
    if (chatBox) {
        chatBox.scrollTop = chatBox.scrollHeight;
    }
}
// ==========================
// TANGGAL OTOMATIS
// ==========================
function updateDate() {
  const options = {
    weekday: "long",
    day: "2-digit",
    month: "long",
    year: "numeric",
  };
  const today = new Date().toLocaleDateString("id-ID", options);
  const dateElement = document.querySelector(".date");
  if (dateElement) {
    dateElement.innerText = today;
  }
}
updateDate();

// ==========================
// HAMBURGER TOGGLE SIDEBAR (MOBILE)
// ==========================
const hamburger = document.getElementById("hamburgerBtn");
const mobileHamburger = document.getElementById("mobileHamburger");
const sidebar = document.getElementById("sidebar");
const overlay = document.getElementById("sidebarOverlay");

// Fungsi untuk membuka sidebar
function openSidebar() {
  sidebar.classList.add("active");
  overlay.classList.add("active");
  document.body.style.overflow = "hidden";
}

// Fungsi untuk menutup sidebar
function closeSidebar() {
  sidebar.classList.remove("active");
  overlay.classList.remove("active");
  document.body.style.overflow = "";
}

// Event listener untuk hamburger button di sidebar (desktop)
if (hamburger) {
  hamburger.addEventListener("click", () => {
    if (sidebar.classList.contains("active")) {
      closeSidebar();
    } else {
      openSidebar();
    }
  });
}

// Event listener untuk hamburger button di mobile topbar
if (mobileHamburger) {
  mobileHamburger.addEventListener("click", () => {
    if (sidebar.classList.contains("active")) {
      closeSidebar();
    } else {
      openSidebar();
    }
  });
}

// Event listener untuk overlay (klik di luar sidebar = tutup)
if (overlay) {
  overlay.addEventListener("click", closeSidebar);
}

// ==========================
// MENU ACTIVE SIDEBAR
// ==========================
const menuItems = document.querySelectorAll(".menu li");

menuItems.forEach((item) => {
  item.addEventListener("click", () => {
    // Remove active dari semua item
    const activeItem = document.querySelector(".menu .active");
    if (activeItem) {
      activeItem.classList.remove("active");
    }
    // Tambah active ke item yang diklik
    item.classList.add("active");
    
    // Tutup sidebar di mobile setelah klik menu
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
  logoutBtn.addEventListener("click", () => {
    if (confirm("Apakah anda yakin ingin keluar?")) {
      alert("Anda berhasil logout!");
      // window.location.href = "login.html"; // aktifkan kalau ada halaman login
    }
  });
}


// =====================
// AUTO FIX SAAT RESIZE
// =====================

window.addEventListener("resize", function () {
  if (window.innerWidth > 768) {
    if (chatRoom) chatRoom.classList.remove("active");
    if (chatList) chatList.style.display = "flex";
  }
});

function loadChats() {
    fetch('/chat/list')
        .then(res => res.json())
        .then(data => {

            let html = '';
         
            data.forEach(chat => {
                html += `
                <div class="chat-item" onclick="openChat(${chat.id_chat})">
                <div class="chat-info">
                    <h4>${chat.nama_anonim ?? 'Anonim'}</h4>
                    <p>${chat.last_message ?? ''}</p>
                    </div>
                </div>
                `;
            });

            document.getElementById('chat-list').innerHTML = html;
        });
}



function openChat(id) {
    currentChatId = id;

    // ❗ stop channel lama
    if (channel) {
        window.Echo.leave(channel);
    }

    fetch(`/chat/${id}`)
        .then(res => res.json())
        .then(data => {

            let html = '';

            data.forEach(msg => {
                let posisi = msg.sender_role === 'guru' ? 'right' : 'left';

                html += `
                    <div class="message ${posisi}">
                        ${msg.message}
                    </div>
                `;
            });

            document.getElementById('chat-box').innerHTML = html;

            scrollToBottom();
        });

    // 🔥 JOIN CHANNEL BARU
    channel = 'chat.' + id;

    window.Echo.channel(channel)
        .listen('.message.sent', (e) => {

            let posisi = e.message.sender_role === 'guru' ? 'right' : 'left';

            let html = `
                <div class="message ${posisi}">
                    ${e.message.message}
                </div>
            `;

            document.getElementById('chat-box').innerHTML += html;

            scrollToBottom();

            // update sidebar juga
            loadChats();
        });
}

function sendMessage() {

    let input = document.getElementById('message-input');
    let message = input.value;

    if (!message) return;

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

        // tampilkan langsung (biar tidak delay)
        let html = `
            <div class="message right">
                ${message}
            </div>
        `;

        document.getElementById('chat-box').innerHTML += html;

        input.value = '';

        scrollToBottom();

        loadChats();
    });
}

document.addEventListener("DOMContentLoaded", function () {
    loadChats();
});

document.getElementById("message-input")
.addEventListener("keypress", function(e) {
    if (e.key === "Enter") {
        sendMessage();
    }
});