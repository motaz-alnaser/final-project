// login.js
// This file is ONLY for login.html and matches its structure exactly

document.addEventListener("DOMContentLoaded", () => {
  const loader = document.getElementById("loader");
  const loginForm = document.getElementById("loginForm");

  /* -----------------------------
     SAFETY CHECKS
  ------------------------------ */
  if (!loader || !loginForm) {
    console.warn("Login elements not found.");
    return;
  }

  /* -----------------------------
     INITIAL STATE
     Hide loader after page load
  ------------------------------ */
  window.addEventListener("load", () => {
    setTimeout(() => {
      loader.classList.add("hidden");
    }, 2000); // same timing as your original code
  });

  /* -----------------------------
     LOGIN FORM SUBMISSION
  ------------------------------ */
  loginForm.addEventListener("submit", (e) => {
    e.preventDefault();

    // Show loader again during authentication
    loader.classList.remove("hidden");

    const email = document.getElementById("email")?.value.trim();
    const password = document.getElementById("password")?.value.trim();

    // Simulate authentication request
    setTimeout(() => {
      loader.classList.add("hidden");

      if (email && password) {
        // SUCCESS (later replace with real backend call)
        alert("Login successful! Redirecting...");
        window.location.href = "index.html";
      } else {
        alert("Please enter valid login credentials.");
      }
    }, 1500);
  });
});
