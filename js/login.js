const translations = {
  es: {
    "hero-title": "Bienvenido al paraíso",
    "hero-desc":
      "Gestiona tus reservas, planifica tus vacaciones o administra tus propiedades frente al mar en Santa Marta de forma segura.",
    "social-proof": "+1k Usuarios confían en nosotros",
    "form-title": "Acceso a la plataforma",
    "form-subtitle": "Ingresa tus datos para continuar explorando.",
    "tab-login": "Iniciar Sesión",
    "tab-register": "Registrarse",
    "label-user": "Usuario",
    "placeholder-user": "Ej: JuanPerez",
    "label-pass": "Contraseña",
    "placeholder-pass": "••••••••",
    "forgot-pass": "¿Olvidaste tu contraseña?",
    "btn-enter": "Entrar",
    "no-account": "¿No tienes una cuenta?",
    "link-register": "Regístrate aquí",
  },
  en: {
    "hero-title": "Welcome to Paradise",
    "hero-desc":
      "Manage your reservations, plan your vacations, or manage your beachfront properties in Santa Marta securely.",
    "social-proof": "+1k Users trust us",
    "form-title": "Platform Access",
    "form-subtitle": "Enter your details to continue exploring.",
    "tab-login": "Login",
    "tab-register": "Register",
    "label-user": "Username",
    "placeholder-user": "Ex: JohnDoe",
    "label-pass": "Password",
    "placeholder-pass": "••••••••",
    "forgot-pass": "Forgot password?",
    "btn-enter": "Sign In",
    "no-account": "Don't have an account?",
    "link-register": "Register here",
  },
};

/**
 * Cambia el idioma de la página
 * @param {string} lang - 'es' o 'en'
 */
function changeLanguage(lang) {
  // Guardar preferencia del usuario en el navegador
  localStorage.setItem("selectedLang", lang);

  // Buscar todos los elementos con el atributo data-key
  document.querySelectorAll("[data-key]").forEach((el) => {
    const key = el.getAttribute("data-key");
    const translation = translations[lang][key];

    if (translation) {
      // Si el elemento es un input, traducimos el placeholder
      if (el.tagName === "INPUT") {
        el.placeholder = translation;
      } else {
        // De lo contrario, traducimos el texto interior
        el.innerText = translation;
      }
    }
  });

  // Actualizar estilos de los botones en Desktop
  const btnEs = document.getElementById("btn-es");
  const btnEn = document.getElementById("btn-en");

  if (lang === "es") {
    btnEs.className =
      "flex items-center gap-2 px-3 py-1.5 text-xs font-bold rounded-lg transition-all bg-primary text-white";
    btnEn.className =
      "flex items-center gap-2 px-3 py-1.5 text-xs font-bold rounded-lg transition-all text-gray-500 hover:bg-white/10";
  } else {
    btnEn.className =
      "flex items-center gap-2 px-3 py-1.5 text-xs font-bold rounded-lg transition-all bg-primary text-white";
    btnEs.className =
      "flex items-center gap-2 px-3 py-1.5 text-xs font-bold rounded-lg transition-all text-gray-500 hover:bg-white/10";
  }

  // Si el menú móvil está abierto, cerrarlo al cambiar idioma
  const mobileMenu = document.getElementById("mobileMenu");
  if (!mobileMenu.classList.contains("hidden")) {
    toggleMenu();
  }
}

/**
 * Controla la apertura y cierre del menú móvil
 */
function toggleMenu() {
  const menu = document.getElementById("mobileMenu");
  const icon = document.getElementById("menuIcon");
  const isOpening = menu.classList.contains("hidden");

  if (isOpening) {
    menu.classList.remove("hidden");
    icon.textContent = "close";
    document.body.style.overflow = "hidden";
  } else {
    menu.classList.add("hidden");
    icon.textContent = "menu";
    document.body.style.overflow = "";
  }
}

// Ejecutar al cargar la página
document.addEventListener("DOMContentLoaded", () => {
  // 1. Verificar si hay un idioma guardado, si no, usar el del navegador o español por defecto
  const savedLang =
    localStorage.getItem("selectedLang") ||
    (navigator.language.startsWith("es") ? "es" : "en");

  changeLanguage(savedLang);

  // 2. Escuchar el evento del botón menú
  const menuBtn = document.getElementById("menuBtn");
  if (menuBtn) {
    menuBtn.addEventListener("click", toggleMenu);
  }
});
