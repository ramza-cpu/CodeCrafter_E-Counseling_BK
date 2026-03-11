// Chart.js Configuration
Chart.defaults.font.family = 'Segoe UI, sans-serif';

// Points Doughnut Chart
const pointsCtx = document.getElementById('pointsChart').getContext('2d');
const pointsChart = new Chart(pointsCtx, {
    type: 'doughnut',
    data: {
        labels: ['Tertib', 'Pembinaan'],
        datasets: [{
            data: [75, 25],
            backgroundColor: [
                '#22c55e',
                '#fbbf24'
            ],
            borderWidth: 0,
            cutout: '75%',
        }]
    },
    options: {
        responsive: true,
        maintainAspectRatio: true,
        plugins: {
            legend: {
                display: false
            },
            tooltip: {
                backgroundColor: 'rgba(0, 0, 0, 0.8)',
                padding: 12,
                borderRadius: 8,
                titleFont: {
                    size: 13
                },
                bodyFont: {
                    size: 12
                },
                callbacks: {
                    label: function(context) {
                        return context.label + ': ' + context.parsed + '%';
                    }
                }
            }
        }
    }
});


// Tab Switching for Points Chart
const tabButtons = document.querySelectorAll('.tab-btn');

tabButtons.forEach(btn => {
    btn.addEventListener('click', function() {
        // Remove active class from all tabs
        tabButtons.forEach(b => b.classList.remove('active'));
        
        // Add active class to clicked tab
        this.classList.add('active');
        
        // Update chart data based on selected tab
        const tabText = this.textContent;
        
        if (tabText === 'Tertib') {
            pointsChart.data.datasets[0].data = [75, 25];
            pointsChart.data.datasets[0].backgroundColor = ['#22c55e', '#fbbf24'];
        } else if (tabText === 'Pembinaan') {
            pointsChart.data.datasets[0].data = [40, 60];
            pointsChart.data.datasets[0].backgroundColor = ['#ef4444', '#f59e0b'];
        }
        
        pointsChart.update('active');
    });
});

// Mood Navigation (Previous/Next week)
const moodNavButtons = document.querySelectorAll('.mood-nav-btn');
let currentWeekOffset = 0;

moodNavButtons.forEach((btn, index) => {
    btn.addEventListener('click', function() {
        if (index === 0) {
            // Previous week
            currentWeekOffset--;
        } else {
            // Next week
            currentWeekOffset++;
        }
        
        // Generate random mood data for demo
        const newData = Array.from({length: 6}, () => Math.floor(Math.random() * 5) + 1);
        currentMoodData = newData;
        
        moodChart.data.datasets[0].data = newData;
        moodChart.update('active');
        
        console.log('Week offset:', currentWeekOffset);
    });
});

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
  document.body.style.overflow = "hidden"; // Prevent scroll saat sidebar terbuka
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
    document.querySelector(".menu .active")?.classList.remove("active");
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
