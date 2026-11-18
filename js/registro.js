const translations = {
  es: {
    "nav-home": "Inicio",
    "btn-close": "Cerrar",
    "hero-title": "Bienvenido al paraíso",
    "hero-desc":
      "Gestiona tus reservas, planifica tus vacaciones o administra tus propiedades frente al mar en Santa Marta de forma segura.",
    "social-proof": "+100 Usuarios confían en nosotros",
    "reg-title": "Crea tu cuenta de hospedaje",
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
    "reg-title": "Create your hosting account",
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
  fr: {
    "nav-home": "Accueil",
    "btn-close": "Fermer",
    "hero-title": "Bienvenue au paradis",
    "hero-desc":
      "Gérez vos réservations, planifiez vos vacances ou gérez vos propriétés en bord de mer à Santa Marta en toute sécurité.",
    "social-proof": "+100 utilisateurs nous font confiance",
    "reg-title": "Créez votre compte d'hébergement",
    "reg-subtitle": "Rejoignez notre communauté pour commencer.",
    "tab-login": "Connexion",
    "tab-register": "S'inscrire",
    "label-name": "Prénom",
    "label-lastname": "Nom",
    "label-username": "Nom d'utilisateur",
    "label-email": "Courriel",
    "label-pass": "Mot de passe",
    "btn-create": "Créer un compte",
    "have-account": "Vous avez déjà un compte ?",
    "link-login": "Connectez-vous ici",
  },
  it: {
    "nav-home": "Home",
    "btn-close": "Chiudi",
    "hero-title": "Benvenuto in paradiso",
    "hero-desc":
      "Gestisci le tue prenotazioni, pianifica le tue vacanze o gestisci le tue proprietà sulla spiaggia a Santa Marta in sicurezza.",
    "social-proof": "+100 utenti si fidano di noi",
    "reg-title": "Crea il tuo account di hosting",
    "reg-subtitle": "Unisciti alla nostra community per iniziare.",
    "tab-login": "Accedi",
    "tab-register": "Registrati",
    "label-name": "Nome",
    "label-lastname": "Cognome",
    "label-username": "Nome utente",
    "label-email": "Posta elettronica",
    "label-pass": "Password",
    "btn-create": "Crea account",
    "have-account": "Hai già un account?",
    "link-login": "Accedi qui",
  },
  pt: {
    "nav-home": "Início",
    "btn-close": "Fechar",
    "hero-title": "Bem-vindo ao paraíso",
    "hero-desc":
      "Gerencie suas reservas, planeje suas férias ou administre suas propriedades à beira-mar em Santa Marta com segurança.",
    "social-proof": "+100 usuários confiam em nós",
    "reg-title": "Crie sua conta de hospedagem",
    "reg-subtitle": "Junte-se à nossa comunidade para começar.",
    "tab-login": "Entrar",
    "tab-register": "Cadastre-se",
    "label-name": "Nome",
    "label-lastname": "Sobrenome",
    "label-username": "Nome de usuário",
    "label-email": "E-mail",
    "label-pass": "Senha",
    "btn-create": "Criar conta",
    "have-account": "Já tem uma conta?",
    "link-login": "Entre aqui",
  },
};

const langFlags = {
  es: "https://flagcdn.com/w40/co.png",
  en: "https://flagcdn.com/w40/us.png",
  fr: "https://flagcdn.com/w40/fr.png",
  it: "https://flagcdn.com/w40/it.png",
  pt: "https://flagcdn.com/w40/pt.png",
};

function changeLanguage(lang) {
  if (!translations[lang]) lang = "es";

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

  // Actualizar la bandera y el texto del botón principal del dropdown de escritorio
  const currentFlag = document.querySelector(".btn-flag-current");
  const currentText = document.querySelector(".btn-text-current");
  if (currentFlag) currentFlag.src = langFlags[lang];
  if (currentText) currentText.innerText = lang.toUpperCase();

  // Cerrar el menú móvil si está abierto
  const menu = document.getElementById("mobileMenu");
  if (menu && !menu.classList.contains("hidden")) {
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
  const menuBtn = document.getElementById("menuBtn");
  if (menuBtn) {
    menuBtn.addEventListener("click", toggleMenu);
  }

  const savedLang =
    localStorage.getItem("selectedLang") ||
    (navigator.language.startsWith("es") ? "es" : "en");

  changeLanguage(savedLang);
});
