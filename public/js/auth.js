// ===============================
// PARALLAX GURU (DESKTOP ONLY)
// ===============================
const guru = document.querySelector(".guru-img");
const loginBox = document.querySelector(".login-box");

if (window.innerWidth > 768) {
  document.addEventListener("mousemove", (e) => {
    let x = (window.innerWidth / 2 - e.pageX) / 40;
    let y = (window.innerHeight / 2 - e.pageY) / 40;

    guru.style.transform = `translate(${x}px, ${y}px)`;
    loginBox.style.transform = `rotateY(${-x/3}deg) rotateX(${y/3}deg)`;
  });
}

// ===============================
// ANIMASI MASUK SAAT LOAD
// ===============================
window.addEventListener("load", () => {
  document.querySelector(".login-box").style.opacity = "0";
  document.querySelector(".guru-img").style.opacity = "0";

  setTimeout(() => {
    document.querySelector(".login-box").style.transition = "1s ease";
    document.querySelector(".guru-img").style.transition = "1s ease";
    document.querySelector(".login-box").style.opacity = "1";
    document.querySelector(".guru-img").style.opacity = "1";
  }, 200);
});
