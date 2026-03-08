// 1. Configuración manual de los elementos para evitar errores de carga
const mediaItems = [
  {
    type: "image",
    src: "/public/img/©️SantaMartaBeachFront-compressed-1.webp",
  }, // 0
  {
    type: "image",
    src: "/public/img/©️SantaMartaBeachFront-compressed-2.webp",
  }, // 1
  {
    type: "image",
    src: "/public/img/©️SantaMartaBeachFront-compressed-3.webp",
  }, // 2
  {
    type: "image",
    src: "/public/img/©️SantaMartaBeachFront-compressed-4.webp",
  }, // 3
  { type: "video", src: "/public/video/video-reserva-del-mar.mp4" }, // 4
  {
    type: "image",
    src: "/public/img/©️SantaMartaBeachFront-compressed-5.webp",
  }, // 5
  {
    type: "image",
    src: "/public/img/©️SantaMartaBeachFront-compressed-6.webp",
  }, // 6
  {
    type: "image",
    src: "/public/img/©️SantaMartaBeachFront-compressed-7.webp",
  }, // 7
  {
    type: "image",
    src: "/public/img/©️SantaMartaBeachFront-compressed-8.webp",
  }, // 8
  {
    type: "image",
    src: "/public/img/©️SantaMartaBeachFront-compressed-9.webp",
  }, // 9
  {
    type: "image",
    src: "/public/img/©️SantaMartaBeachFront-compressed-10.webp",
  }, // 10
  {
    type: "image",
    src: "/public/img/©️SantaMartaBeachFront-compressed-11.webp",
  }, // 11
  {
    type: "image",
    src: "/public/img/©️SantaMartaBeachFront-compressed-12.webp",
  }, // 12
  {
    type: "image",
    src: "/public/img/©️SantaMartaBeachFront-compressed-13.webp",
  }, // 13
  {
    type: "image",
    src: "/public/img/©️SantaMartaBeachFront-compressed-14.webp",
  }, // 14
  {
    type: "image",
    src: "/public/img/©️SantaMartaBeachFront-compressed-15.webp",
  }, // 15
  {
    type: "image",
    src: "/public/img/©️SantaMartaBeachFront-compressed-16.webp",
  }, // 16
  {
    type: "image",
    src: "/public/img/©️SantaMartaBeachFront-compressed-17.webp",
  }, // 17
  {
    type: "image",
    src: "/public/img/©️SantaMartaBeachFront-compressed-18.webp",
  }, // 18
  {
    type: "image",
    src: "/public/img/©️SantaMartaBeachFront-compressed-19.webp",
  }, // 19
  {
    type: "image",
    src: "/public/img/©️SantaMartaBeachFront-compressed-20.webp",
  }, // 20
  {
    type: "image",
    src: "/public/img/©️SantaMartaBeachFront-compressed-21.webp",
  }, // 21
  {
    type: "image",
    src: "/public/img/©️SantaMartaBeachFront-compressed-22.webp",
  }, // 22
  {
    type: "image",
    src: "/public/img/©️SantaMartaBeachFront-compressed-23.webp",
  }, // 23
  {
    type: "image",
    src: "/public/img/©️SantaMartaBeachFront-compressed-24.webp",
  }, // 24
  {
    type: "image",
    src: "/public/img/©️SantaMartaBeachFront-compressed-25.webp",
  }, // 25
  {
    type: "image",
    src: "/public/img/©️SantaMartaBeachFront-compressed-26.webp",
  }, // 26
  {
    type: "image",
    src: "/public/img/©️SantaMartaBeachFront-compressed-27.webp",
  }, // 27
  {
    type: "image",
    src: "/public/img/©️SantaMartaBeachFront-compressed-28.webp",
  }, // 28
  {
    type: "image",
    src: "/public/img/©️SantaMartaBeachFront-compressed-29.webp",
  }, // 29
  {
    type: "image",
    src: "/public/img/©️SantaMartaBeachFront-compressed-30.webp",
  }, // 30
  {
    type: "image",
    src: "/public/img/©️SantaMartaBeachFront-compressed-31.webp",
  }, // 31
  {
    type: "image",
    src: "/public/img/©️SantaMartaBeachFront-compressed-32.webp",
  }, // 32
  {
    type: "image",
    src: "/public/img/©️SantaMartaBeachFront-compressed-33.webp",
  }, // 33
  { type: "image", src: "/public/img/©️SantaMartaBeachFront.com©️34.png" }, // 34
  { type: "image", src: "/public/img/©️SantaMartaBeachFront.com©️35.png" }, // 35
];

let currentIndex = 0;

function openGallery(index) {
  currentIndex = index;
  updateModal();
  const modal = document.getElementById("gallery-modal");
  if (modal) {
    modal.classList.remove("hidden");
    document.body.classList.add("modal-active");
  }
}

function updateModal() {
  const item = mediaItems[currentIndex];
  const content = document.getElementById("modal-content");
  if (!content || !item) return;

  content.style.opacity = "0";

  setTimeout(() => {
    if (item.type === "image") {
      content.innerHTML = `<img src="${item.src}" class="max-w-[95vw] max-h-[85vh] object-contain animate-zoom rounded-xl shadow-2xl">`;
    } else {
      content.innerHTML = `<video controls autoplay class="max-w-[95vw] max-h-[80vh] rounded-xl shadow-2xl"><source src="${item.src}" type="video/mp4"></video>`;
    }
    content.style.opacity = "1";
  }, 150);
}

function nextMedia() {
  currentIndex = (currentIndex + 1) % mediaItems.length;
  updateModal();
}

function prevMedia() {
  currentIndex = (currentIndex - 1 + mediaItems.length) % mediaItems.length;
  updateModal();
}

function closeModal() {
  document.getElementById("gallery-modal").classList.add("hidden");
  document.body.classList.remove("modal-active");
  document.getElementById("modal-content").innerHTML = "";
}

// Atajos de teclado
document.addEventListener("keydown", (e) => {
  const modal = document.getElementById("gallery-modal");
  if (!modal || modal.classList.contains("hidden")) return;
  if (e.key === "Escape") closeModal();
  if (e.key === "ArrowRight") nextMedia();
  if (e.key === "ArrowLeft") prevMedia();
});

// --- Lógica de Idiomas (Tu código original funciona bien) ---
const translations = {
  es: {
    "nav-home": "Inicio",
    "click-expand": "Click para ampliar video",
    "cta-title": "¿Listo para vivir la experiencia?",
    "cta-desc":
      "Reserva tu estancia en la Torre 4 de Reserva del Mar 1 y despierta frente al mar Caribe.",
    "btn-call": "Llamar ahora",
    "footer-contact-title": "Información de Contacto",
    "footer-desc":
      "La plataforma líder en alquileres vacacionales de lujo en Santa Marta. Experiencias únicas, confort superior y las mejores vistas del Caribe colombiano.",
    foo_social_title: "Síguenos",
    foo_rights: "Todos los derechos reservados.",
    foo_privacy: "Políticas de Privacidad",
    foo_terms: "Términos y Condiciones",
  },
  en: {
    "nav-home": "Home",
    "click-expand": "Click to expand video",
    "cta-title": "Ready to live the experience?",
    "cta-desc":
      "Book your stay at Tower 4 of Reserva del Mar 1 and wake up facing the Caribbean Sea.",
    "btn-call": "Call now",
    "footer-contact-title": "Contact Information",
    "footer-desc":
      "The leading platform for luxury vacation rentals in Santa Marta. Unique experiences, superior comfort, and the best views of the Colombian Caribbean.",
    foo_social_title: "Follow us",
    foo_rights: "All rights reserved.",
    foo_privacy: "Privacy Policies",
    foo_terms: "Terms and Conditions",
  },
};

function changeLang(lang) {
  localStorage.setItem("preferredLang", lang);
  document.querySelectorAll("[data-i18n]").forEach((el) => {
    const key = el.getAttribute("data-i18n");
    if (translations[lang][key]) el.textContent = translations[lang][key];
  });
  document.querySelectorAll("[data-key]").forEach((el) => {
    const key = el.getAttribute("data-key");
    if (translations[lang][key]) el.textContent = translations[lang][key];
  });
  document.getElementById("btn-es")?.classList.remove("flag-active");
  document.getElementById("btn-en")?.classList.remove("flag-active");
  document.getElementById(`btn-${lang}`)?.classList.add("flag-active");
  document.documentElement.lang = lang;
}

document.addEventListener("DOMContentLoaded", () => {
  const savedLang = localStorage.getItem("preferredLang") || "es";
  changeLang(savedLang);
});
