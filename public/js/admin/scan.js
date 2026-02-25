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

// ==========================
// QR SCANNER
// ==========================
let html5QrCode;

// Dummy database murid
const students = {
  1234567890: {
    nama: "Budi Santoso",
    kelas: "X IPA 1",
    jurusan: "IPA",
  },
  9876543210: {
    nama: "Siti Aminah",
    kelas: "XI IPS 2",
    jurusan: "IPS",
  },
};

function tampilkanData(kode) {
  const resultDiv = document.getElementById("result");
  
  if (students[kode]) {
    const s = students[kode];
    resultDiv.innerHTML = `
      <div class="student-data">
        <p><strong>Nama:</strong> ${s.nama}</p>
        <p><strong>Kelas:</strong> ${s.kelas}</p>
        <p><strong>Jurusan:</strong> ${s.jurusan}</p>
        <p><strong>NISN:</strong> ${kode}</p>
      </div>
    `;
    resultDiv.style.color = "inherit";
  } else {
    resultDiv.innerHTML = `
      <p class="error-message">❌ Data tidak ditemukan untuk kode: <strong>${kode}</strong></p>
    `;
  }
}

function startScanner() {
  const readerDiv = document.getElementById("reader");
  
  // Jika scanner sudah aktif, stop dulu
  if (html5QrCode && html5QrCode.isScanning) {
    html5QrCode.stop().then(() => {
      readerDiv.innerHTML = "";
      initScanner();
    });
  } else {
    initScanner();
  }
}

function initScanner() {  
  html5QrCode = new Html5Qrcode("reader");

  Html5Qrcode.getCameras()
    .then((devices) => {
      if (devices.length) {
        html5QrCode.start(
          devices[0].id,
          { fps: 10, qrbox: { width: 250, height: 250 } },
          (qrMessage) => {
            tampilkanData(qrMessage);
            html5QrCode.stop();
          },
          (errorMessage) => {
            // Ignore scan errors (normal saat lagi scan)
          }
        ).catch((err) => {
          alert("Gagal memulai kamera: " + err);
        });
      } else {
        alert("Tidak ada kamera yang terdeteksi!");
      }
    })
    .catch(() => {
      alert("Kamera tidak bisa diakses! Pastikan izin kamera sudah diberikan.");
    });
}

function manualScan() {
  const input = document.getElementById("manualInput");
  const value = input.value.trim();
  
  if (value === "") {
    alert("Silakan masukkan NISN atau kode QR!");
    return;
  }
  
  tampilkanData(value);
  input.value = ""; // Clear input setelah scan
}

// Allow Enter key untuk manual scan
document.getElementById("manualInput")?.addEventListener("keypress", function(e) {
  if (e.key === "Enter") {
    manualScan();
  }
});