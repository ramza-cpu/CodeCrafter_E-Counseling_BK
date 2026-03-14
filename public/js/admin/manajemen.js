// ==========================
// HAMBURGER TOGGLE SIDEBAR
// ==========================
const hamburger = document.getElementById("hamburgerBtn");
const mobileHamburger = document.getElementById("mobileHamburger");
const sidebar = document.getElementById("sidebar");
const overlay = document.getElementById("sidebarOverlay");

function openSidebar() {
  sidebar.classList.add("active");
  overlay.classList.add("active");
  document.body.style.overflow = "hidden";
}

function closeSidebar() {
  sidebar.classList.remove("active");
  overlay.classList.remove("active");
  document.body.style.overflow = "";
}

if (hamburger) {
  hamburger.addEventListener("click", () => {
    sidebar.classList.contains("active") ? closeSidebar() : openSidebar();
  });
}

if (mobileHamburger) {
  mobileHamburger.addEventListener("click", () => {
    sidebar.classList.contains("active") ? closeSidebar() : openSidebar();
  });
}

if (overlay) {
  overlay.addEventListener("click", closeSidebar);
}

// ==========================
// MENU ACTIVE
// ==========================
const menuItems = document.querySelectorAll(".menu li");
menuItems.forEach((item) => {
  item.addEventListener("click", () => {
    document.querySelector(".menu .active")?.classList.remove("active");
    item.classList.add("active");
    if (window.innerWidth <= 768) {
      closeSidebar();
    }
  });
});


// ==========================
// MODAL HANDLING
// ==========================
const modal = document.getElementById("modalSiswa");
const btnTambahSiswa = document.getElementById("btnTambahSiswa");
const closeModal = document.getElementById("closeModal");
const btnBatal = document.getElementById("btnBatal");
const formSiswa = document.getElementById("formSiswa");
const modalTitle = document.getElementById("modalTitle");
let isEditMode = false;

// Open modal untuk tambah
btnTambahSiswa.addEventListener("click", () => {
  isEditMode = false;
  modalTitle.textContent = "Tambah Data Siswa";
  formSiswa.reset();
  document.getElementById("studentId").value = "";
  modal.classList.add("active");
  document.body.style.overflow = "hidden";
});

// Close modal
function closeModalHandler() {
  modal.classList.remove("active");
  document.body.style.overflow = "";
  formSiswa.reset();
}

closeModal.addEventListener("click", closeModalHandler);
btnBatal.addEventListener("click", closeModalHandler);

// Close modal saat klik di luar
modal.addEventListener("click", (e) => {
  if (e.target === modal) {
    closeModalHandler();
  }
});


// ==========================
// EDIT & DELETE HANDLER
// ==========================

document.addEventListener("click", function (e) {

  // ======================
  // EDIT DATA
  // ======================

  if (e.target.closest(".btn-edit")) {

    const button = e.target.closest(".btn-edit");

    let id = button.dataset.id;

    console.log("edit clicked");

    document.getElementById("studentId").value = id;

    document.getElementById("username").value = button.dataset.username;
    document.getElementById("email").value = button.dataset.email;
    document.getElementById("nisn").value = button.dataset.nisn;
    document.getElementById("nama").value = button.dataset.nama;
    document.getElementById("kelas").value = button.dataset.kelas;
    document.getElementById("jenis_kelamin").value = button.dataset.jk;
    document.getElementById("alamat").value = button.dataset.alamat;
    document.getElementById("no_hp").value = button.dataset.nohp;
    document.getElementById("skor").value = button.dataset.skor;

    modalTitle.textContent = "Edit Data Siswa";

    formSiswa.action = "/manajemen/update/" + id;

    document.getElementById("formMethod").value = "PUT";

    modal.classList.add("active");

  }


  // ======================
  // DELETE DATA
  // ======================

  if (e.target.closest(".btn-delete")) {

    const button = e.target.closest(".btn-delete");

    let id = button.dataset.id;

    Swal.fire({
      title: "Yakin ingin menghapus?",
      text: "Data siswa akan dihapus!",
      icon: "warning",
      showCancelButton: true,
      confirmButtonColor: "#d33",
      cancelButtonColor: "#3085d6",
      confirmButtonText: "Ya, Hapus!"
    }).then((result) => {

      if (result.isConfirmed) {

        const form = document.createElement("form");

        form.method = "POST";
        form.action = "/manajemen/delete/" + id;

        const csrf = document.createElement("input");
        csrf.type = "hidden";
        csrf.name = "_token";
        csrf.value = document.querySelector('meta[name="csrf-token"]').content;

        const method = document.createElement("input");
        method.type = "hidden";
        method.name = "_method";
        method.value = "DELETE";

        form.appendChild(csrf);
        form.appendChild(method);

        document.body.appendChild(form);

        form.submit();

      }

    });

  }

});

// ==========================
// KEYBOARD SHORTCUTS
// ==========================
document.addEventListener("keydown", (e) => {
  // ESC untuk close modal/sidebar
  if (e.key === "Escape") {
    if (modal.classList.contains("active")) {
      closeModalHandler();
    } else if (sidebar.classList.contains("active")) {
      closeSidebar();
    }
  }
  
  // Ctrl/Cmd + K untuk focus search
  if ((e.ctrlKey || e.metaKey) && e.key === "k") {
    e.preventDefault();
    searchInput.focus();
  }
});
