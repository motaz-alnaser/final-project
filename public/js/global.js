// global.js
// Safe global JavaScript for ALL pages

document.addEventListener("DOMContentLoaded", () => {

  /* =========================
     LOADER (SAFE)
  ========================== */
  const loader = document.getElementById("loader");
  if (loader) {
    window.addEventListener("load", () => {
      setTimeout(() => {
        loader.classList.add("hidden");
      }, 2000);
    });
  }

  /* =========================
     MOBILE MENU (SAFE)
  ========================== */
  const menuToggle = document.getElementById("menuToggle");
  const navMenu = document.getElementById("navMenu");

  if (menuToggle && navMenu) {
    menuToggle.addEventListener("click", () => {
      navMenu.classList.toggle("active");
      menuToggle.classList.toggle("active");
    });
  }

  /* =========================
     FORMS (GENERIC – SAFE)
  ========================== */
  const forms = document.querySelectorAll("form");

  forms.forEach(form => {
    form.addEventListener("submit", () => {
      // show loader only if it exists
      if (loader) {
        loader.classList.remove("hidden");
        setTimeout(() => {
          loader.classList.add("hidden");
        }, 1500);
      }
    });
  });

});
