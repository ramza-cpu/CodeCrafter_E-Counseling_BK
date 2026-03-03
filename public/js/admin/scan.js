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

// ===============================
// SMART E-COUNSEL SCAN JS
// ===============================

// Global scanner
let html5QrCode = null;
let scannerRunning = false;

// ===============================
// START CAMERA
// ===============================
function startScanner() {

    if (scannerRunning) {
        return;
    }

    html5QrCode = new Html5Qrcode("reader");

    Html5Qrcode.getCameras()
        .then(devices => {

            if (devices && devices.length > 0) {

                // Pilih kamera belakang jika ada
                let cameraId = devices[0].id;

                devices.forEach(device => {
                    if (device.label.toLowerCase().includes("back")) {
                        cameraId = device.id;
                    }
                });

                html5QrCode.start(
                    cameraId,
                    {
                        fps: 10,
                        qrbox: 250
                    },
                    onScanSuccess,
                    onScanFailure
                );

                scannerRunning = true;

            } else {
                alert("Kamera tidak ditemukan");
            }
        })
        .catch(err => {
            console.error("Error akses kamera:", err);
            alert("Gagal mengakses kamera");
        });
}

// ===============================
// SCAN BERHASIL
// ===============================
function onScanSuccess(decodedText) {

    if (!decodedText) return;

    stopScanner();

    // Isi hidden input
    const hiddenInput = document.getElementById("nisnHidden");
    if (hiddenInput) {
        hiddenInput.value = decodedText;
    }

    // Submit form
    const form = document.getElementById("scanForm");
    if (form) {
        form.submit();
    }
}

// ===============================
// SCAN GAGAL (DIABAIKAN)
// ===============================
function onScanFailure(error) {
    // Tidak perlu tampilkan error scan terus-menerus
    // console.warn(error);
}

// ===============================
// STOP CAMERA
// ===============================
function stopScanner() {
    if (html5QrCode && scannerRunning) {
        html5QrCode.stop()
            .then(() => {
                scannerRunning = false;
            })
            .catch(err => {
                console.error("Gagal stop scanner:", err);
            });
    }
}

// ===============================
// MANUAL INPUT
// ===============================
function manualScan() {

    const manualInput = document.getElementById("manualInput");

    if (!manualInput) return;

    const value = manualInput.value.trim();

    if (value === "") {
        alert("Masukkan NISN terlebih dahulu!");
        return;
    }

    const hiddenInput = document.getElementById("nisnHidden");
    if (hiddenInput) {
        hiddenInput.value = value;
    }

    const form = document.getElementById("scanForm");
    if (form) {
        form.submit();
    }
}

// ===============================
// AUTO ENTER UNTUK INPUT MANUAL
// ===============================
document.addEventListener("DOMContentLoaded", function () {

    const manualInput = document.getElementById("manualInput");

    if (manualInput) {
        manualInput.addEventListener("keypress", function (e) {
            if (e.key === "Enter") {
                e.preventDefault();
                manualScan();
            }
        });
    }

});