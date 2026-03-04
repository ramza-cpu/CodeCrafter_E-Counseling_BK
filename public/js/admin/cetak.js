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

const students = [
  { nama: "Bimo Pratama", kelas: "X RPL 1", poin: 18 },
  { nama: "Alya Putri", kelas: "X RPL 2", poin: 32 },
  { nama: "Rizky Ramadhan", kelas: "XI RPL 1", poin: 47 },
  { nama: "Siti Aisyah", kelas: "XI RPL 2", poin: 56 },
  { nama: "Dimas Saputra", kelas: "XII RPL 1", poin: 73 },
  { nama: "Nabila Zahra", kelas: "XII RPL 2", poin: 82 },
  { nama: "Farhan Akbar", kelas: "X RPL 3", poin: 12 },
  { nama: "Putri Maharani", kelas: "XI RPL 3", poin: 65 },
  { nama: "Andi Wijaya", kelas: "XII RPL 3", poin: 90 },
  { nama: "Intan Permata", kelas: "XI RPL 4", poin: 28 }
];

function getKategoriSP(poin) {
  if (poin >= 0 && poin <= 25) return "SP1";
  if (poin > 25 && poin <= 50) return "SP2";
  if (poin > 50 && poin <= 75) return "SP3";
  if (poin > 75 && poin <= 100) return "SP4";
  return "-";
}

const table = document.getElementById("studentTable");

students.forEach((siswa, index) => {
  table.innerHTML += `
    <tr>
      <td>${index + 1}</td>
      <td>${siswa.nama}</td>
      <td>${siswa.kelas}</td>
      <td>${siswa.poin}</td>
      <td>${getKategoriSP(siswa.poin)}</td>
      <td>
        <button class="btn-action" onclick="confirmPrint('${siswa.nama}')">
          Cetak
        </button>
      </td>
    </tr>
  `;
});

function confirmPrint(nama) {
  Swal.fire({
    title: 'Cetak Surat?',
    text: `Apakah Anda yakin ingin mencetak surat untuk ${nama}?`,
    icon: 'question',
    showCancelButton: true,
    confirmButtonColor: '#4f46e5',
    cancelButtonColor: '#d33',
    confirmButtonText: 'Ya, Cetak',
    cancelButtonText: 'Batal'
  }).then((result) => {
    if (result.isConfirmed) {
      window.print();
    }
  });
}

