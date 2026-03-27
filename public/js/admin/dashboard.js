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
// SIDEBAR TOGGLE
// ==========================
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

// ==========================
// MENU ACTIVE
// ==========================
document.querySelectorAll(".menu li").forEach((item) => {
  item.addEventListener("click", () => {
    document.querySelector(".menu .active")?.classList.remove("active");
    item.classList.add("active");

    if (window.innerWidth <= 768) closeSidebar();
  });
});

// ==========================
// HELPER
// ==========================
function persen(val, total) {
  return total === 0 ? 0 : ((val / total) * 100).toFixed(1);
}

function formatTanggal(date) {
  return new Date(date).toLocaleDateString("id-ID");
}

// ==========================
// CHART INSTANCE (ANTI DOUBLE)
// ==========================
let lineChartInstance = null;
let barChartInstance = null;
let donutChartInstance = null;

// ==========================
// FETCH DASHBOARD
// ==========================
async function loadDashboard() {
  try {
    const res = await fetch('/admin/dashboard/data');
    const data = await res.json();

    // ======================
    // USERNAME
    // ======================
    const username = document.getElementById("username");
    if (username) username.innerText = data.user;

    // ======================
    // CARD DATA
    // ======================
    const totalMurid = document.getElementById("totalMurid");
    const butuhPerhatian = document.getElementById("butuhPerhatian");

    if (totalMurid) totalMurid.innerText = data.total_murid;
    if (butuhPerhatian) butuhPerhatian.innerText = data.butuh_perhatian;

    // ======================
    // LINE CHART (STATISTIK BULANAN)
    // ======================
    if (lineChartInstance) lineChartInstance.destroy();

  const namaBulan = [
  "Januari", "Februari", "Maret", "April", "Mei", "Juni",
  "Juli", "Agustus", "September", "Oktober", "November", "Desember"
];

  const bulan = data.statistik_bulanan.map(i => namaBulan[i.bulan - 1]);
    const total = data.statistik_bulanan.map(i => i.total);

    const lineCtx = document.getElementById("lineChart");

    if (lineCtx) {
      lineChartInstance = new Chart(lineCtx, {
        type: "line",
        data: {
          labels: bulan,
          datasets: [{
            label: "Jumlah Pelanggaran",
            data: total,
            borderColor: "#7ea9e1",
            backgroundColor: "rgba(126,169,225,0.2)",
            fill: true,
            tension: 0.4,
            pointRadius: 4,
            pointBackgroundColor: "#7ea9e1",
          }]
        },
        options: {
          responsive: true,
          maintainAspectRatio: false,
          plugins: {
            legend: { display: false }
          }
        }
      });
    }

    // ======================
    // BAR CHART (TOP 4 KASUS)
    // ======================
    if (barChartInstance) barChartInstance.destroy();

    const barCtx = document.getElementById("barChart");

    if (barCtx) {
      barChartInstance = new Chart(barCtx, {
        type: "bar",
        data: {
          labels: data.kategori_kasus.map(i => i.nama_pelanggaran),
          datasets: [{
            label: "Jumlah Kasus",
            data: data.kategori_kasus.map(i => i.total),
            backgroundColor: "#7ea9e1",
            borderRadius: 8
          }]
        },
        options: {
          responsive: true,
          maintainAspectRatio: false,
          plugins: {
            legend: { display: false }
          }
        }
      });
    }

    // ======================
    // DONUT CHART (REKAP POIN)
    // ======================
    if (donutChartInstance) donutChartInstance.destroy();

    const donutCtx = document.getElementById("donutChart");

    if (donutCtx) {
      const totalRekap =
        data.rekap.tertib +
        data.rekap.pembinaan +
        data.rekap.prioritas;

      donutChartInstance = new Chart(donutCtx, {
        type: "doughnut",
        data: {
          labels: ["Tertib", "Pembinaan", "Prioritas/SP"],
          datasets: [{
            data: [
              persen(data.rekap.tertib, totalRekap),
              persen(data.rekap.pembinaan, totalRekap),
              persen(data.rekap.prioritas, totalRekap)
            ],
            backgroundColor: ["#7ea9e1", "#f4b400", "#ff6b6b"],
            borderWidth: 0
          }]
        },
        options: {
          responsive: true,
          maintainAspectRatio: false,
          plugins: {
            legend: { display: false }
          }
        }
      });
    }


    
    const tertib = document.getElementById("tertib");
    const pembinaan = document.getElementById("pembinaan");
    const prioritas = document.getElementById("prioritas");

    if (tertib) tertib.innerText = data.rekap.tertib;
    if (pembinaan) pembinaan.innerText = data.rekap.pembinaan;
    if (prioritas) prioritas.innerText = data.rekap.prioritas;

    // ======================
    // NOTIF DARURAT
    // ======================
    const notifContainer = document.getElementById("notifDarurat");

    if (notifContainer) {
      notifContainer.innerHTML = "";

      if (data.notif_darurat.length === 0) {
        notifContainer.innerHTML = `<p>Tidak ada notifikasi</p>`;
      } else {
        data.notif_darurat.forEach(n => {
          notifContainer.innerHTML += `
            <div class="notif-item">
              <b>${n.nama}</b>
              <p>${n.jenis_surat}</p>
              <span>${formatTanggal(n.created_at)}</span>
              <br>
              <br>
            </div>
          `;
        });
      }
    }

    // ======================
    // TINDAK LANJUT
    // ======================
    const tindak = document.getElementById("tindakLanjut");

    if (tindak) {
      tindak.innerHTML = "";

      if (data.tindak_lanjut.length === 0) {
        tindak.innerHTML = `<li>Tidak ada tindak lanjut</li>`;
      } else {
        data.tindak_lanjut.forEach(t => {
          tindak.innerHTML += `
            <li>${t.nama} - ${t.nama_pelanggaran}</li>
          `;
        });
      }
    }

  } catch (error) {
    console.error(error);
    Swal.fire("Error", "Gagal load dashboard", "error");
  }
}

// ==========================
// INIT
// ==========================
document.addEventListener("DOMContentLoaded", () => {
  loadDashboard();
});