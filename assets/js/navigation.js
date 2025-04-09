document.addEventListener("DOMContentLoaded", () => {
  const hamburger = document.querySelector(".navigation__hamburger");
  const menu = document.querySelector("[data-menu]");

  hamburger.addEventListener("click", () => {
    const isVisible = menu.getAttribute("data-visible") === "true";
    menu.setAttribute("data-visible", !isVisible);
  });
});