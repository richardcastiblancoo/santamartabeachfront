const translations = {
  es: {
    "hero-title": "Bienvenido al paraíso",
    "hero-desc":
      "Gestiona tus reservas, planifica tus vacaciones o administra tus propiedades frente al mar en Santa Marta de forma segura.",
    "social-proof": "+1k Usuarios confían en nosotros",
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
  document.querySelectorAll("[data-key]").forEach((el) => {
    const key = el.getAttribute("data-key");
    if (translations[lang][key]) el.innerText = translations[lang][key];
  });

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

  if (!document.getElementById("mobileMenu").classList.contains("hidden"))
    toggleMenu();
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

document.getElementById("menuBtn").addEventListener("click", toggleMenu);
