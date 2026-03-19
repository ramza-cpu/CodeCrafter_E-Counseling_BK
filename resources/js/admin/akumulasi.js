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


document.addEventListener("DOMContentLoaded", function () {

    const select = document.getElementById("jenisSelect");
    const poinInput = document.getElementById("poinInput");

    select.addEventListener("change", function () {

        const selected = select.options[select.selectedIndex];
        const poin = selected.getAttribute("data-poin");

        if (poin) {
            poinInput.value = poin;
        } else {
            poinInput.value = "";
        }

    });

});