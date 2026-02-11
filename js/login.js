const translations = {
  es: {
    "nav-home": "Inicio",
    "btn-close": "Cerrar",
    "hero-title": "Bienvenido al paraíso",
    "hero-desc":
      "Gestiona tus reservas, planifica tus vacaciones o administra tus propiedades frente al mar en Santa Marta de forma segura.",
    "social-proof": "+100 Usuarios confían en nosotros",
    "form-title": "Acceso a la plataforma",
    "form-subtitle": "Ingresa tus datos para continuar explorando.",
    "tab-login": "Iniciar Sesión",
    "tab-register": "Registrarse",
    "label-user": "Usuario",
    "placeholder-user": "Ej: JuanPerez",
    "label-pass": "Contraseña",
    "placeholder-pass": "••••••••",
    "btn-enter": "Entrar",
    "no-account": "¿No tienes una cuenta?",
    "link-register": "Regístrate aquí",
  },
  en: {
    "nav-home": "Home",
    "btn-close": "Close",
    "hero-title": "Welcome to Paradise",
    "hero-desc":
      "Manage your reservations, plan your vacations, or manage your beachfront properties in Santa Marta securely.",
    "social-proof": "+100 Users trust us",
    "form-title": "Platform Access",
    "form-subtitle": "Enter your details to continue exploring.",
    "tab-login": "Login",
    "tab-register": "Register",
    "label-user": "Username",
    "placeholder-user": "Ex: JohnDoe",
    "label-pass": "Password",
    "placeholder-pass": "••••••••",
    "btn-enter": "Sign In",
    "no-account": "Don't have an account?",
    "link-register": "Register here",
  },
};

function changeLanguage(lang) {
  localStorage.setItem("selectedLang", lang);

  // Traducir todos los elementos con data-key
  document.querySelectorAll("[data-key]").forEach((el) => {
    const key = el.getAttribute("data-key");
    const translation = translations[lang][key];
    if (translation) {
      if (el.tagName === "INPUT") el.placeholder = translation;
      else el.innerText = translation;
    }
  });

  // Actualizar estilos de los botones (Escritorio y Móvil)
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

  // Opcional: Cerrar menú móvil al cambiar idioma
  const menu = document.getElementById("mobileMenu");
  if (!menu.classList.contains("hidden")) {
    setTimeout(toggleMenu, 300);
  }
}

function toggleMenu() {
  const menu = document.getElementById("mobileMenu");
  const icon = document.getElementById("menuIcon");
  if (menu.classList.contains("hidden")) {
    menu.classList.remove("hidden");
    icon.textContent = "close";
    document.body.style.overflow = "hidden";
  } else {
    menu.classList.add("hidden");
    icon.textContent = "menu";
    document.body.style.overflow = "";
  }
}

document.addEventListener("DOMContentLoaded", () => {
  const savedLang =
    localStorage.getItem("selectedLang") ||
    (navigator.language.startsWith("es") ? "es" : "en");
  changeLanguage(savedLang);

  const menuBtn = document.getElementById("menuBtn");
  if (menuBtn) menuBtn.addEventListener("click", toggleMenu);
});
