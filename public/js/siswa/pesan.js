// =====================
// ELEMENT GLOBAL
// =====================
const chatRoom = document.querySelector(".chat-room");
const chatList = document.querySelector(".chat-list");
const chatName = document.getElementById("chatName");
const chatBody = document.querySelector(".chat-body");
const chatInput = document.querySelector(".chat-input input");
const sendBtn = document.querySelector(".chat-input button");
const chatListContainer = document.getElementById("chatItems");

let currentChatId = null;
// let channel = null;

// =====================
// SIDEBAR (SAMA ADMIN)
// =====================
const hamburger = document.getElementById("hamburgerBtn");
const mobileHamburger = document.getElementById("mobileHamburger");
const sidebar = document.getElementById("sidebar");
const overlay = document.getElementById("sidebarOverlay");

function openSidebar() {
  sidebar?.classList.add("active");
  overlay?.classList.add("active");
  document.body.style.overflow = "hidden";
}

function closeSidebar() {
  sidebar?.classList.remove("active");
  overlay?.classList.remove("active");
  document.body.style.overflow = "";
}

hamburger?.addEventListener("click", () => {
  sidebar.classList.contains("active") ? closeSidebar() : openSidebar();
});

mobileHamburger?.addEventListener("click", () => {
  sidebar.classList.contains("active") ? closeSidebar() : openSidebar();
});

overlay?.addEventListener("click", closeSidebar);

// =====================
// BACK BUTTON (MOBILE)
// =====================
function goBack() {
  if (window.innerWidth <= 768) {
    chatRoom?.classList.remove("active");
    chatList?.classList.remove("hidden");
  }
}

// =====================
// RESIZE FIX
// =====================
window.addEventListener("resize", () => {
  if (window.innerWidth > 768) {
    chatRoom?.classList.remove("active");
    chatList?.classList.remove("hidden");
  }
});

// =====================
// LOAD CHAT LIST (RINGAN)
// =====================
async function loadChatList() {
  try {
    const res = await fetch('/siswa/chat/list');
    const data = await res.json();

    if (!chatListContainer) return;

    chatListContainer.innerHTML = '';

    if (data.length === 0) {
      chatListContainer.innerHTML = `<p style="padding:10px;">Belum ada chat</p>`;
      return;
    }

    data.forEach(chat => {

      // 🔥 INISIAL GURU
      const getInitial = (name) => {
        if (!name) return '?';
        const words = name.split(' ');
        return words.length > 1
          ? (words[0][0] + words[1][0]).toUpperCase()
          : words[0][0].toUpperCase();
      };

      const initial = getInitial(chat.name);

      const item = document.createElement("div");
      item.classList.add("chat-item");
      item.innerHTML = `
        <div class="avatar">${initial}</div>
        <div class="chat-info">
          <h4>${chat.name}</h4>
          <p>${chat.last_message ?? 'Belum ada pesan'}</p>
        </div>
      `;

      item.addEventListener("click", () => {
        openChat(chat.id_chat, chat.name, item);
      });

      chatListContainer.appendChild(item);
    });

  } catch (err) {
    console.error("Error load chat list:", err);
  }
}

// =====================
// OPEN CHAT (MOBILE FIX)
// =====================
let channel = null;

async function openChat(id, name, el) {

  currentChatId = id;

  if (chatName) {
    chatName.textContent = name;
  }

  // ❌ leave channel lama
  if (channel && window.Echo) {
    window.Echo.leave(channel);
  }

  try {
    const res = await fetch(`/siswa/chat/${id}`);
    const data = await res.json();

    chatBody.innerHTML = '';

    data.forEach(msg => {
      const posisi = msg.sender_role === 'siswa' ? 'right' : 'left';

      chatBody.innerHTML += `
        <div class="message ${posisi}">
          ${msg.message}
        </div>
      `;
    });

    chatBody.scrollTop = chatBody.scrollHeight;

  } catch (err) {
    console.error("❌ ERROR LOAD CHAT:", err);
  }

  // ==========================
  // REALTIME
  // ==========================
  channel = 'chat.' + id;

  if (window.Echo) {

    window.Echo.channel(channel)
      .listen('.message.sent', (e) => {

        if (e.message.id_chat != currentChatId) return;

        // ❗ filter agar tidak double (skip sendiri)
        if (e.message.sender_role === 'siswa') return;

        chatBody.innerHTML += `
          <div class="message left">
            ${e.message.message}
          </div>
        `;

        chatBody.scrollTop = chatBody.scrollHeight;
      });

  } else {
    console.error("Echo tidak tersedia");
  }
}

// =====================
// SEND MESSAGE (RINGAN)
// =====================
async function sendMessage() {

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

  const text = chatInput.value.trim();

  console.log("📤 SEND SISWA DEBUG:", {
    text,
    currentChatId
  });

  if (!text || !currentChatId) {
    console.warn("⚠️ kosong / chat belum dipilih");
    return;
  }

  try {
    const res = await fetch('/siswa/chat/send', {
      method: 'POST',
      headers: {
        'Content-Type': 'application/json',
        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
      },
      body: JSON.stringify({
        id_chat: currentChatId,
        message: text
      })
    });

    console.log("📡 STATUS:", res.status);

    const result = await res.json();

    console.log("📥 RESPONSE:", result);

    // ❗ cek response
    if (!result.success) {
      console.error("❌ SERVER ERROR:", result);
      alert(result.error || "Gagal kirim pesan");
      return;
    }

    // tampil langsung
    chatBody.innerHTML += `
      <div class="message right">
        ${text}
      </div>
    `;

    chatInput.value = '';
    chatBody.scrollTop = chatBody.scrollHeight;

  } catch (err) {
    console.error("❌ FETCH ERROR:", err);
  }
}

// =====================
// INIT
// =====================
document.addEventListener("DOMContentLoaded", () => {

  loadChatList();

  sendBtn?.addEventListener("click", sendMessage);

  chatInput?.addEventListener("keydown", (e) => {
    if (e.key === "Enter") {
      e.preventDefault();
      sendMessage();
    }
  });

});