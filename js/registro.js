const translations = {
  es: {
    "nav-home": "Inicio",
    "btn-close": "Cerrar",
    "hero-title": "Bienvenido al paraíso",
    "hero-desc":
      "Gestiona tus reservas, planifica tus vacaciones o administra tus propiedades frente al mar en Santa Marta de forma segura.",
    "social-proof": "+100 Usuarios confían en nosotros",
    "reg-title": "Crea tu cuenta",
    "reg-subtitle": "Únete a nuestra comunidad para empezar.",
    "tab-login": "Iniciar Sesión",
    "tab-register": "Registrarse",
    "label-name": "Nombre",
    "label-lastname": "Apellido",
    "label-username": "Nombre de usuario",
    "label-email": "Correo electrónico",
    "label-pass": "Contraseña",
    "btn-create": "Crear cuenta",
    "have-account": "¿Ya tienes una cuenta?",
    "link-login": "Inicia sesión aquí",
  },
  en: {
    "nav-home": "Home",
    "btn-close": "Close",
    "hero-title": "Welcome to Paradise",
    "hero-desc":
      "Manage your reservations, plan your vacations, or manage your beachfront properties in Santa Marta securely.",
    "social-proof": "+100 Users trust us",
    "reg-title": "Create your account",
    "reg-subtitle": "Join our community to get started.",
    "tab-login": "Login",
    "tab-register": "Sign Up",
    "label-name": "First Name",
    "label-lastname": "Last Name",
    "label-username": "Username",
    "label-email": "Email Address",
    "label-pass": "Password",
    "btn-create": "Create account",
    "have-account": "Already have an account?",
    "link-login": "Login here",
  },
};

function changeLanguage(lang) {
  localStorage.setItem("selectedLang", lang);

  // Traducir todos los elementos marcados con data-key
  document.querySelectorAll("[data-key]").forEach((el) => {
    const key = el.getAttribute("data-key");
    const translation = translations[lang][key];
    if (translation) {
      if (el.tagName === "INPUT") el.placeholder = translation;
      else el.innerText = translation;
    }
  });

  // Actualizar estilos de los botones (Escritorio + Móvil)
  const allBtnEs = document.querySelectorAll(".btn-es");
  const allBtnEn = document.querySelectorAll(".btn-en");

  const activeClasses = ["bg-primary", "text-white", "shadow-md"];
  const inactiveClasses = ["text-gray-500", "bg-transparent"];

  if (lang === "es") {
    allBtnEs.forEach((btn) => {
      btn.classList.add(...activeClasses);
      btn.classList.remove(...inactiveClasses);
    });
    allBtnEn.forEach((btn) => {
      btn.classList.remove(...activeClasses);
      btn.classList.add(...inactiveClasses);
    });
  } else {
    allBtnEn.forEach((btn) => {
      btn.classList.add(...activeClasses);
      btn.classList.remove(...inactiveClasses);
    });
    allBtnEs.forEach((btn) => {
      btn.classList.remove(...activeClasses);
      btn.classList.add(...inactiveClasses);
    });
  }

  // Cerrar el menú móvil si está abierto
  const menu = document.getElementById("mobileMenu");
  if (!menu.classList.contains("hidden")) {
    setTimeout(toggleMenu, 300);
  }
}

function toggleMenu() {
  const menu = document.getElementById("mobileMenu");
  const icon = document.getElementById("menuIcon");
  const isOpen = !menu.classList.contains("hidden");

  if (isOpen) {
    menu.classList.add("hidden");
    icon.textContent = "menu";
    document.body.style.overflow = "";
  } else {
    menu.classList.remove("hidden");
    icon.textContent = "close";
    document.body.style.overflow = "hidden";
  }
}

document.addEventListener("DOMContentLoaded", () => {
  // Escuchar el clic del botón menú
  document.getElementById("menuBtn").addEventListener("click", toggleMenu);

  // Cargar idioma guardado o por defecto
  const savedLang =
    localStorage.getItem("selectedLang") ||
    (navigator.language.startsWith("es") ? "es" : "en");
  changeLanguage(savedLang);
});
