// 1. Configuración manual de los elementos de la galería
const mediaItems = [
  {
    type: "image",
    src: "/public/img/©️SantaMartaBeachFront-compressed-1.webp",
  },
  {
    type: "image",
    src: "/public/img/©️SantaMartaBeachFront-compressed-2.webp",
  },
  {
    type: "image",
    src: "/public/img/©️SantaMartaBeachFront-compressed-3.webp",
  },
  {
    type: "image",
    src: "/public/img/©️SantaMartaBeachFront-compressed-4.webp",
  },
  { type: "video", src: "/public/video/video-reserva-del-mar.mp4" },
  {
    type: "image",
    src: "/public/img/©️SantaMartaBeachFront-compressed-5.webp",
  },
  {
    type: "image",
    src: "/public/img/©️SantaMartaBeachFront-compressed-6.webp",
  },
  {
    type: "image",
    src: "/public/img/©️SantaMartaBeachFront-compressed-7.webp",
  },
  {
    type: "image",
    src: "/public/img/©️SantaMartaBeachFront-compressed-8.webp",
  },
  {
    type: "image",
    src: "/public/img/©️SantaMartaBeachFront-compressed-9.webp",
  },
  {
    type: "image",
    src: "/public/img/©️SantaMartaBeachFront-compressed-10.webp",
  },
  {
    type: "image",
    src: "/public/img/©️SantaMartaBeachFront-compressed-11.webp",
  },
  {
    type: "image",
    src: "/public/img/©️SantaMartaBeachFront-compressed-12.webp",
  },
  {
    type: "image",
    src: "/public/img/©️SantaMartaBeachFront-compressed-13.webp",
  },
  {
    type: "image",
    src: "/public/img/©️SantaMartaBeachFront-compressed-14.webp",
  },
  {
    type: "image",
    src: "/public/img/©️SantaMartaBeachFront-compressed-15.webp",
  },
  {
    type: "image",
    src: "/public/img/©️SantaMartaBeachFront-compressed-16.webp",
  },
  {
    type: "image",
    src: "/public/img/©️SantaMartaBeachFront-compressed-17.webp",
  },
  {
    type: "image",
    src: "/public/img/©️SantaMartaBeachFront-compressed-18.webp",
  },
  {
    type: "image",
    src: "/public/img/©️SantaMartaBeachFront-compressed-19.webp",
  },
  {
    type: "image",
    src: "/public/img/©️SantaMartaBeachFront-compressed-20.webp",
  },
  {
    type: "image",
    src: "/public/img/©️SantaMartaBeachFront-compressed-21.webp",
  },
  {
    type: "image",
    src: "/public/img/©️SantaMartaBeachFront-compressed-22.webp",
  },
  {
    type: "image",
    src: "/public/img/©️SantaMartaBeachFront-compressed-23.webp",
  },
  {
    type: "image",
    src: "/public/img/©️SantaMartaBeachFront-compressed-24.webp",
  },
  {
    type: "image",
    src: "/public/img/©️SantaMartaBeachFront-compressed-25.webp",
  },
  {
    type: "image",
    src: "/public/img/©️SantaMartaBeachFront-compressed-26.webp",
  },
  {
    type: "image",
    src: "/public/img/©️SantaMartaBeachFront-compressed-27.webp",
  },
  {
    type: "image",
    src: "/public/img/©️SantaMartaBeachFront-compressed-28.webp",
  },
  {
    type: "image",
    src: "/public/img/©️SantaMartaBeachFront-compressed-29.webp",
  },
  {
    type: "image",
    src: "/public/img/©️SantaMartaBeachFront-compressed-30.webp",
  },
  {
    type: "image",
    src: "/public/img/©️SantaMartaBeachFront-compressed-31.webp",
  },
  {
    type: "image",
    src: "/public/img/©️SantaMartaBeachFront-compressed-32.webp",
  },
  {
    type: "image",
    src: "/public/img/©️SantaMartaBeachFront-compressed-33.webp",
  },
  { type: "image", src: "/public/img/©️SantaMartaBeachFront.com©️34.png" },
  { type: "image", src: "/public/img/©️SantaMartaBeachFront.com©️35.png" },
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

// Atajos de teclado para la galería
document.addEventListener("keydown", (e) => {
  const modal = document.getElementById("gallery-modal");
  if (!modal || modal.classList.contains("hidden")) return;
  if (e.key === "Escape") closeModal();
  if (e.key === "ArrowRight") nextMedia();
  if (e.key === "ArrowLeft") prevMedia();
});

// --- Configuración de Idiomas ---
const langData = {
  es: { flag: "https://flagcdn.com/w80/co.png", label: "Español" },
  en: { flag: "https://flagcdn.com/w80/us.png", label: "English" },
  fr: { flag: "https://flagcdn.com/w80/fr.png", label: "Français" },
  it: { flag: "https://flagcdn.com/w80/it.png", label: "Italiano" },
  pt: { flag: "https://flagcdn.com/w80/pt.png", label: "Português" },
};

const translations = {
  es: {
    "nav-home": "Inicio",
    "click-expand": "Click para ampliar video",
    "cta-title": "¿Listo para vivir la experiencia?",
    "cta-desc":
      "Reserva tu estancia en la Torre 4 de Reserva del Mar 1 y despierta frente al mar Caribe.",
    "btn-ws": "Reservar por WhatsApp",
    "btn-call": "Llamar ahora",
    "footer-contact-title": "Información de Contacto",
    "footer-desc":
      "La plataforma líder en alquileres vacacionales de lujo en Santa Marta. Experiencias únicas, confort superior y las mejores vistas del Caribe colombiano.",
    foo_social_title: "Síguenos",
    "qr-title": "Comparte y califícanos",
    "qr-desc-1": "Escanea el código QR para visitar nuestro perfil en Google y",
    "qr-desc-2": "dejar tu reseña.",
    foo_made_by: "Hecho por",
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
    "btn-ws": "Book via WhatsApp",
    "btn-call": "Call now",
    "footer-contact-title": "Contact Information",
    "footer-desc":
      "The leading platform for luxury vacation rentals in Santa Marta. Unique experiences, superior comfort, and the best views of the Colombian Caribbean.",
    foo_social_title: "Follow us",
    "qr-title": "Share and rate us",
    "qr-desc-1": "Scan the QR code to visit our Google profile and",
    "qr-desc-2": "leave your review.",
    foo_made_by: "Made by",
    foo_rights: "All rights reserved.",
    foo_privacy: "Privacy Policies",
    foo_terms: "Terms and Conditions",
  },
  fr: {
    "nav-home": "Accueil",
    "click-expand": "Cliquez pour agrandir la vidéo",
    "cta-title": "Prêt à vivre l'expérience ?",
    "cta-desc":
      "Réservez votre séjour dans la Tour 4 de Reserva del Mar 1 et réveillez-vous face à la mer des Caraïbes.",
    "btn-ws": "Réserver via WhatsApp",
    "btn-call": "Appeler maintenant",
    "footer-contact-title": "Coordonnées de Contact",
    "footer-desc":
      "La plateforme leader pour les locations de vacances de luxe à Santa Marta. Des expériences uniques, un confort supérieur et les meilleures vues des Caraïbes colombiennes.",
    foo_social_title: "Suivez-nous",
    "qr-title": "Partagez et notez-nous",
    "qr-desc-1": "Scannez le code QR pour visiter notre profil Google et",
    "qr-desc-2": "laisser votre avis.",
    foo_made_by: "Réalisé par",
    foo_rights: "Tous droits réservés.",
    foo_privacy: "Politique de Confidentialité",
    foo_terms: "Conditions Générales",
  },
  it: {
    "nav-home": "Home",
    "click-expand": "Clicca per ingrandire il video",
    "cta-title": "Pronto a vivere l'esperienza?",
    "cta-desc":
      "Prenota il tuo soggiorno nella Torre 4 di Reserva del Mar 1 e svegliati di fronte al Mar Caraibico.",
    "btn-ws": "Prenota su WhatsApp",
    "btn-call": "Chiama ora",
    "footer-contact-title": "Informazioni di Contatto",
    "footer-desc":
      "La piattaforma leader per gli affitti vacanze di lusso a Santa Marta. Esperienze uniche, comfort superiore e le migliori viste del Caraibi colombiano.",
    foo_social_title: "Seguici",
    "qr-title": "Condividi e valutaci",
    "qr-desc-1":
      "Scansiona il codice QR per visitare il nostro profilo Google e",
    "qr-desc-2": "lasciare la tua recensione.",
    foo_made_by: "Fatto da",
    foo_rights: "Tutti i diritti riservati.",
    foo_privacy: "Informativa sulla Privacy",
    foo_terms: "Termini e Condizioni",
  },
  pt: {
    "nav-home": "Início",
    "click-expand": "Clique para ampliar o vídeo",
    "cta-title": "Pronto para viver a experiência?",
    "cta-desc":
      "Reserve sua estadia na Torre 4 de Reserva del Mar 1 e acorde em frente ao mar do Caribe.",
    "btn-ws": "Reservar pelo WhatsApp",
    "btn-call": "Ligar agora",
    "footer-contact-title": "Informações de Contato",
    "footer-desc":
      "A plataforma líder em aluguéis de temporada de luxo em Santa Marta. Experiências únicas, conforto superior e as melhores vistas do Caribe colombiano.",
    foo_social_title: "Siga-nos",
    "qr-title": "Compartilhe e avalie-nos",
    "qr-desc-1": "Escaneie o código QR para visitar nosso perfil no Google e",
    "qr-desc-2": "deixar sua avaliação.",
    foo_made_by: "Feito por",
    foo_rights: "Todos os direitos reservados.",
    foo_privacy: "Políticas de Privacidade",
    foo_terms: "Termos e Condições",
  },
};

// --- Control del Menú Desplegable ---
function toggleLangMenu() {
  const dropdown = document.getElementById("lang-dropdown");
  const arrow = document.getElementById("lang-arrow");
  if (!dropdown) return;

  const isHidden = dropdown.classList.contains("hidden");

  if (isHidden) {
    dropdown.classList.remove("hidden");
    setTimeout(() => {
      dropdown.classList.remove("opacity-0", "scale-95");
      dropdown.classList.add("opacity-100", "scale-100");
    }, 10);
    if (arrow) arrow.style.transform = "rotate(180deg)";
  } else {
    closeLangMenu();
  }
}

function closeLangMenu() {
  const dropdown = document.getElementById("lang-dropdown");
  const arrow = document.getElementById("lang-arrow");
  if (!dropdown || dropdown.classList.contains("hidden")) return;

  dropdown.classList.remove("opacity-100", "scale-100");
  dropdown.classList.add("opacity-0", "scale-95");

  setTimeout(() => {
    dropdown.classList.add("hidden");
  }, 200);

  if (arrow) arrow.style.transform = "rotate(0deg)";
}

// Cerrar menú al hacer click afuera
document.addEventListener("click", (e) => {
  const btn = document.getElementById("lang-menu-btn");
  const dropdown = document.getElementById("lang-dropdown");
  if (
    btn &&
    dropdown &&
    !btn.contains(e.target) &&
    !dropdown.contains(e.target)
  ) {
    closeLangMenu();
  }
});

// --- Cambiar Idioma ---
function changeLang(lang) {
  const selectedLang = translations[lang] ? lang : "es";
  localStorage.setItem("preferredLang", selectedLang);

  // Traducir textos
  document.querySelectorAll("[data-i18n]").forEach((el) => {
    const key = el.getAttribute("data-i18n");
    if (translations[selectedLang][key]) {
      el.textContent = translations[selectedLang][key];
    }
  });

  // Actualizar Botón Principal (Bandera y Nombre)
  const activeFlag = document.getElementById("active-flag");
  const activeText = document.getElementById("active-lang-text");

  if (activeFlag && langData[selectedLang]) {
    activeFlag.src = langData[selectedLang].flag;
  }
  if (activeText && langData[selectedLang]) {
    activeText.textContent = langData[selectedLang].label;
  }

  document.documentElement.lang = selectedLang;
  closeLangMenu();
}

// Cargar idioma guardado al iniciar
document.addEventListener("DOMContentLoaded", () => {
  const savedLang = localStorage.getItem("preferredLang") || "es";
  changeLang(savedLang);
});
