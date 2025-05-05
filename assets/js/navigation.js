document.addEventListener("DOMContentLoaded", () => {
  const hamburger = document.querySelector(".navigation__hamburger");
  const menu = document.querySelector("[data-menu]");

  if (hamburger && menu) {
    hamburger.addEventListener("click", () => {
      const isVisible = menu.getAttribute("data-visible") === "true";
      menu.setAttribute("data-visible", !isVisible);
    });
  } else {
    console.error("Hamburger or menu element not found.");
  }
});

const nav = document.querySelector('.navigation');
if (nav) {
  window.addEventListener('scroll', () => {
    if (window.scrollY > 0) {
      nav.classList.add('scrolled');
    } else {
      nav.classList.remove('scrolled');
    }
  });
} else {
  console.error("Navigation element not found.");
}