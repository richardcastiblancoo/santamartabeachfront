// Diccionario de traducciones completo
const translations = {
  ES: {
    "nav-inicio": "Inicio",
    "nav-apartamentos": "Apartamentos",
    "nav-nosotros": "Nosotros",
    "titulo-principal": "Políticas y Términos",
    "ultima-actualizacion": "Última actualización: 1 de febrero, 2026",
    "aside-nav": "Navegación",
    "aside-legal": "Secciones legales",
    "link-intro": "Introducción",
    "link-data": "Uso de Datos",
    "link-cancel": "Cancelaciones",
    "link-resp": "Responsabilidades",
    "link-intellect": "Propiedad Intelectual",
    "ayuda-titulo": "¿Necesitas ayuda?",
    "ayuda-desc":
      "Si tienes dudas sobre nuestras políticas, contáctanos a 17clouds@gmail.com",
    "sec1-titulo": "1. Introducción",
    "sec1-p1":
      "Bienvenido a Santamartabeachfront. Al utilizar nuestros servicios de alquiler de apartamentos frente al mar, usted acepta cumplir con los siguientes términos y condiciones. Estos términos rigen su relación con nuestra plataforma y las estancias en nuestras propiedades.",
    "sec2-titulo": "2. Uso de Datos y Privacidad",
    "sec3-titulo": "3. Cancelaciones y Reembolsos",
    "table-h1": "Antelación",
    "table-h2": "Reembolso",
    "table-r1-c1": "Más de 30 días",
    "table-r1-c2": "100% Reembolsable",
    "sec4-titulo": "4. Responsabilidades del Huésped",
    "sec5-titulo": "5. Propiedad Intelectual",
  },
  EN: {
    "nav-inicio": "Home",
    "nav-apartamentos": "Apartments",
    "nav-nosotros": "About Us",
    "titulo-principal": "Policies & Terms",
    "ultima-actualizacion": "Last updated: February 1, 2026",
    "aside-nav": "Navigation",
    "aside-legal": "Legal Sections",
    "link-intro": "Introduction",
    "link-data": "Data Usage",
    "link-cancel": "Cancellations",
    "link-resp": "Responsibilities",
    "link-intellect": "Intellectual Property",
    "ayuda-titulo": "Need help?",
    "ayuda-desc":
      "If you have questions about our policies, contact us at 17clouds@gmail.com",
    "sec1-titulo": "1. Introduction",
    "sec1-p1":
      "Welcome to Santamartabeachfront. By using our beachfront apartment rental services, you agree to comply with the following terms and conditions. These terms govern your relationship with our platform and stays at our properties.",
    "sec2-titulo": "2. Data Usage & Privacy",
    "sec3-titulo": "3. Cancellations & Refunds",
    "table-h1": "Notice Period",
    "table-h2": "Refund",
    "table-r1-c1": "More than 30 days",
    "table-r1-c2": "100% Refundable",
    "sec4-titulo": "4. Guest Responsibilities",
    "sec5-titulo": "5. Intellectual Property",
  },
};

document.addEventListener("DOMContentLoaded", () => {
  // Selectores de Elementos
  const menuBtn = document.getElementById("menuBtn");
  const navContainer = document.getElementById("navContainer");
  const menuIcon = document.getElementById("menuIcon");
  const langBtn = document.getElementById("langBtn");
  const langMenu = document.getElementById("langMenu");
  const currentFlag = document.getElementById("currentFlag");
  const langOptions = langMenu.querySelectorAll("a");

  // --- FUNCIÓN DE TRADUCCIÓN ---
  function translatePage(lang) {
    const elements = document.querySelectorAll("[data-key]");
    elements.forEach((el) => {
      const key = el.getAttribute("data-key");
      if (translations[lang] && translations[lang][key]) {
        el.textContent = translations[lang][key];
      }
    });
    // Guardar preferencia
    localStorage.setItem("preferredLang", lang);
  }

  // --- GESTIÓN DEL MENÚ HAMBURGUESA (MÓVIL) ---
  if (menuBtn) {
    menuBtn.addEventListener("click", (e) => {
      e.stopPropagation();
      const isHidden = navContainer.classList.contains("hidden");

      if (isHidden) {
        // Abrir menú
        navContainer.classList.remove("hidden");
        navContainer.classList.add("flex");
        menuIcon.textContent = "close";
        document.body.style.overflow = "hidden"; // Bloquear scroll
      } else {
        // Cerrar menú
        closeMobileMenu();
      }
    });
  }

  function closeMobileMenu() {
    navContainer.classList.add("hidden");
    navContainer.classList.remove("flex");
    menuIcon.textContent = "menu";
    document.body.style.overflow = ""; // Liberar scroll
  }

  // --- GESTIÓN DEL SELECTOR DE IDIOMAS ---
  if (langBtn) {
    langBtn.addEventListener("click", (e) => {
      e.stopPropagation();
      langMenu.classList.toggle("hidden");
    });
  }

  // Cambio de idioma al hacer clic en las opciones
  langOptions.forEach((option) => {
    option.addEventListener("click", (e) => {
      e.preventDefault();
      const selectedLang = option.getAttribute("data-lang");
      const selectedFlagSrc = option.querySelector("img").src;

      // 1. Actualizar Bandera e Interfaz
      currentFlag.src = selectedFlagSrc;

      // 2. Traducir
      translatePage(selectedLang);

      // 3. Cerrar menús
      langMenu.classList.add("hidden");
      if (window.innerWidth < 1024) closeMobileMenu();
    });
  });

  // --- CIERRE DE MENÚS AL HACER CLIC FUERA ---
  document.addEventListener("click", (e) => {
    // Cerrar dropdown de idiomas
    if (langMenu && !e.target.closest(".lang-dropdown")) {
      langMenu.classList.add("hidden");
    }

    // Cerrar menú móvil si se hace clic en el fondo oscuro (si aplica) o fuera del nav
    if (
      window.innerWidth < 1024 &&
      navContainer &&
      !navContainer.classList.contains("hidden") &&
      !e.target.closest("#navContainer") &&
      !e.target.closest("#menuBtn")
    ) {
      closeMobileMenu();
    }
  });

  // --- CARGA INICIAL ---
  const savedLang = localStorage.getItem("preferredLang") || "ES";
  translatePage(savedLang);

  // Ajustar bandera inicial según idioma guardado
  if (savedLang === "EN") {
    currentFlag.src = "https://flagcdn.com/w80/us.png";
  } else {
    currentFlag.src = "https://flagcdn.com/w80/co.png";
  }
});
