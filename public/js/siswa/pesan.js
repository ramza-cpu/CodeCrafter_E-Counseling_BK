// =====================
// ELEMENT GLOBAL
// =====================

const chatRoom = document.querySelector(".chat-room");
const chatList = document.querySelector(".chat-list");
// const sidebar = document.querySelector(".sidebar");
const chatName = document.getElementById("chatName");
const chatBody = document.getElementById("chatBody");


// =====================
// OPEN CHAT
// =====================

function openChat(element, name, message1, message2) {

  if (!chatName || !chatBody) return;

  // Ganti nama
  chatName.textContent = name;

  // Isi ulang pesan
  chatBody.innerHTML = `
    <div class="message right">${message1}</div>
    <div class="message left">${message2}</div>
  `;

  // Scroll ke bawah
  chatBody.scrollTop = chatBody.scrollHeight;

  // Reset active
  document.querySelectorAll(".chat-item").forEach(item => {
    item.classList.remove("active");
  });

  element.classList.add("active");

  // MOBILE MODE
  if (window.innerWidth <= 768) {
    if (chatRoom) chatRoom.classList.add("active");
    if (chatList) chatList.style.display = "none";
    // if (sidebar) sidebar.classList.remove("active");
  }
}


// =====================
// BACK BUTTON (MOBILE)
// =====================

function goBack() {
  if (window.innerWidth <= 768) {
    if (chatRoom) chatRoom.classList.remove("active");
    if (chatList) chatList.style.display = "flex";
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


// =====================
// KIRIM PESAN
// =====================

document.addEventListener("DOMContentLoaded", function () {

  const input = document.querySelector(".chat-input input");
  const button = document.querySelector(".chat-input button");

  if (!input || !button || !chatBody) return;

  function sendMessage() {
    const text = input.value.trim();
    if (!text) return;

    const newMsg = document.createElement("div");
    newMsg.className = "message right";
    newMsg.textContent = text;

    chatBody.appendChild(newMsg);

    // Scroll otomatis
    chatBody.scrollTop = chatBody.scrollHeight;

    input.value = "";
  }

  button.addEventListener("click", sendMessage);

  input.addEventListener("keydown", function (e) {
    if (e.key === "Enter") {
      e.preventDefault();
      sendMessage();
    }
  });

});