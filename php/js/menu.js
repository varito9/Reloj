document.addEventListener("DOMContentLoaded", () => {
  const links = document.querySelectorAll(".menu-link");
  const underline = document.getElementById("menu-underline");
  const active = document.querySelector(".menu-link.active");

  function moveUnderlineTo(element) {
    const rect = element.getBoundingClientRect();
    const parentRect = element.parentElement.getBoundingClientRect();
    underline.style.left = (rect.left - parentRect.left) + "px";
    underline.style.width = rect.width + "px";
  }

  // Inicial: mover al enlace activo
  if (active) moveUnderlineTo(active);

  // Hover: mover a enlace bajo el cursor
  links.forEach(link => {
    link.addEventListener("mouseenter", () => moveUnderlineTo(link));
    link.addEventListener("mouseleave", () => {
      if (active) moveUnderlineTo(active); // volver activar
    });
  });
});