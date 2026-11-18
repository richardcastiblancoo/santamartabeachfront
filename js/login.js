// 1. DICCIONARIO DE TRADUCCIONES
const translations = {
  es: {
    "nav-home": "Inicio",
    "hero-title": "Bienvenido al paraíso",
    "hero-desc":
      "Gestiona tus reservas, planifica tus vacaciones o administra tus propiedades frente al mar en Santa Marta de forma segura.",
    "social-proof": "+100 Usuarios confían en nosotros",
    "form-title": "Acceso a la plataforma de Huéspedes",
    "form-subtitle": "Ingresa tus datos para continuar explorando.",
    "tab-login": "Iniciar Sesión",
    "tab-register": "Registrarse",
    "label-user": "Usuario",
    "placeholder-user": "Ej: JuanPerez",
    "label-pass": "Contraseña",
    "placeholder-pass": "••••••••",
    "btn-enter": "Entrar",
    "btn-register": "Crear Cuenta",
    "no-account": "¿No tienes una cuenta?",
    "link-register": "Regístrate aquí",
  },
  en: {
    "nav-home": "Home",
    "hero-title": "Welcome to paradise",
    "hero-desc":
      "Manage your bookings, plan your vacation, or manage your beachfront properties in Santa Marta securely.",
    "social-proof": "+100 Users trust us",
    "form-title": "Guest Platform Access",
    "form-subtitle": "Enter your details to continue exploring.",
    "tab-login": "Log In",
    "tab-register": "Register",
    "label-user": "Username",
    "placeholder-user": "e.g. JohnDoe",
    "label-pass": "Password",
    "placeholder-pass": "••••••••",
    "btn-enter": "Enter",
    "btn-register": "Create Account",
    "no-account": "Don't have an account?",
    "link-register": "Register here",
  },
  fr: {
    "nav-home": "Accueil",
    "hero-title": "Bienvenue au paradis",
    "hero-desc":
      "Gérez vos réservations, planifiez vos vacances ou gérez vos propriétés en bord de mer à Santa Marta en toute sécurité.",
    "social-proof": "+100 Utilisateurs nous font confiance",
    "form-title": "Accès à la plateforme Invités",
    "form-subtitle": "Entrez vos coordonnées pour continuer l'exploration.",
    "tab-login": "Connexion",
    "tab-register": "S'inscrire",
    "label-user": "Nom d'utilisateur",
    "placeholder-user": "ex: JeanDupont",
    "label-pass": "Mot de passe",
    "placeholder-pass": "••••••••",
    "btn-enter": "Entrer",
    "btn-register": "Créer un compte",
    "no-account": "Vous n'avez pas de compte ?",
    "link-register": "Inscrivez-vous ici",
  },
  it: {
    "nav-home": "Home",
    "hero-title": "Benvenuto in paradiso",
    "hero-desc":
      "Gestisci le tue prenotazioni, pianifica le tue vacanze o gestisci le tue proprietà fronte mare a Santa Marta in modo sicuro.",
    "social-proof": "+100 Utenti si fidano di noi",
    "form-title": "Accesso piattaforma Ospiti",
    "form-subtitle": "Inserisci i tuoi dati per continuare a esplorare.",
    "tab-login": "Accedi",
    "tab-register": "Registrati",
    "label-user": "Nome utente",
    "placeholder-user": "es: MarioRossi",
    "label-pass": "Password",
    "placeholder-pass": "••••••••",
    "btn-enter": "Entra",
    "btn-register": "Crea account",
    "no-account": "Non hai un account?",
    "link-register": "Registrati qui",
  },
  pt: {
    "nav-home": "Início",
    "hero-title": "Bem-vindo ao paraíso",
    "hero-desc":
      "Gerencie suas reservas, planeje suas férias ou administre suas propriedades à beira-mar em Santa Marta com segurança.",
    "social-proof": "+100 Usuários confiam em nós",
    "form-title": "Acesso à plataforma de Hóspedes",
    "form-subtitle": "Insira seus dados para continuar explorando.",
    "tab-login": "Entrar",
    "tab-register": "Cadastrar-se",
    "label-user": "Usuário",
    "placeholder-user": "ex: JoaoSilva",
    "label-pass": "Senha",
    "placeholder-pass": "••••••••",
    "btn-enter": "Entrar",
    "btn-register": "Criar Conta",
    "no-account": "Não tem uma conta?",
    "link-register": "Cadastre-se aqui",
  },
};

// 2. ICONOS SVG DE LAS BANDERAS (CORREGIDA BANDERA DE PORTUGAL)
const flags = {
  es: '<svg class="w-4 h-4 rounded-full object-cover flex-shrink-0" viewBox="0 0 900 600"><rect width="900" height="300" fill="#FCD116"/><rect width="900" height="150" y="300" fill="#003893"/><rect width="900" height="150" y="450" fill="#CE1126"/></svg>',
  en: '<svg class="w-4 h-4 rounded-full object-cover flex-shrink-0" viewBox="0 0 741 390"><rect width="741" height="390" fill="#b22234"/><path d="M0 30h741M0 90h741M0 150h741M0 210h741M0 270h741M0 330h741" stroke="#fff" stroke-width="30"/><rect width="296.4" height="210" fill="#3c3b6e"/></svg>',
  fr: '<svg class="w-4 h-4 rounded-full object-cover flex-shrink-0" viewBox="0 0 3 2"><rect width="1" height="2" fill="#002395"/><rect width="1" height="2" x="1" fill="#fff"/><rect width="1" height="2" x="2" fill="#ed2939"/></svg>',
  it: '<svg class="w-4 h-4 rounded-full object-cover flex-shrink-0" viewBox="0 0 3 2"><rect width="1" height="2" fill="#009246"/><rect width="1" height="2" x="1" fill="#fff"/><rect width="1" height="2" x="2" fill="#ce2b37"/></svg>',
  pt: '<svg class="w-4 h-4 rounded-full object-cover flex-shrink-0" viewBox="0 0 600 400"><rect width="240" height="400" fill="#006600"/><rect width="360" height="400" x="240" fill="#FF0000"/><circle cx="240" cy="200" r="80" fill="#FFCC00"/><path d="M 210,160 H 270 V 220 C 270,250 210,250 210,220 Z" fill="#FF0000"/><path d="M 220,170 H 260 V 210 C 260,235 220,235 220,210 Z" fill="#FFFFFF"/><circle cx="240" cy="185" r="4" fill="#003893"/><circle cx="230" cy="195" r="4" fill="#003893"/><circle cx="250" cy="195" r="4" fill="#003893"/><circle cx="235" cy="207" r="4" fill="#003893"/><circle cx="245" cy="207" r="4" fill="#003893"/></svg>',
};

// 3. FUNCIONES GLOBALES INVOCADAS POR ATRIBUTOS onclick DEL HTML

// Alternar menú desplegable móvil
function toggleMenu() {
  const mobileMenu = document.getElementById("mobileMenu");
  if (mobileMenu) {
    mobileMenu.classList.toggle("hidden");
  }
}

// Alternar dropdown de idioma en Desktop
function toggleLangHeaderDesktop(event) {
  if (event) event.stopPropagation();
  const menu = document.getElementById("langMenuDesktop");
  if (menu) menu.classList.toggle("hidden");
}

// Alternar dropdown de idioma en Móvil
function toggleLangHeaderMobile(event) {
  if (event) event.stopPropagation();
  const menu = document.getElementById("langMenuMobileHeader");
  if (menu) menu.classList.toggle("hidden");
}

// Alias para mantener compatibilidad si el HTML llama a selectLanguage u onclick="changeLanguage"
function selectLanguage(lang) {
  changeLanguage(lang);
}

// 4. FUNCIÓN PRINCIPAL PARA CAMBIAR EL IDIOMA
function changeLanguage(lang) {
  if (!translations[lang]) return;

  document.documentElement.lang = lang;

  // 4.1 Traducir elementos con atributo data-key
  document.querySelectorAll("[data-key]").forEach((el) => {
    const key = el.getAttribute("data-key");
    const translatedText = translations[lang][key];

    if (translatedText) {
      if (el.tagName === "INPUT" || el.tagName === "TEXTAREA") {
        if (el.type === "submit" || el.type === "button") {
          el.value = translatedText;
        } else {
          el.placeholder = translatedText;
        }
      } else {
        const textSpan = Array.from(el.querySelectorAll("span")).find(
          (s) => !s.classList.contains("material-symbols-outlined"),
        );

        if (textSpan) {
          textSpan.textContent = translatedText;
        } else {
          let hasChildNodes = false;
          el.childNodes.forEach((node) => {
            if (
              node.nodeType === Node.TEXT_NODE &&
              node.nodeValue.trim() !== ""
            ) {
              node.nodeValue = translatedText;
              hasChildNodes = true;
            }
          });
          if (!hasChildNodes) {
            el.textContent = translatedText;
          }
        }
      }
    }
  });

  // 4.2 Actualizar el botón de escritorio (Bandera + Texto)
  const desktopBtnText = document.getElementById("currentLangDesktopText");
  const desktopBtn = document.getElementById("langBtnDesktop");
  if (desktopBtnText && desktopBtn) {
    desktopBtnText.textContent = lang.toUpperCase();
    const oldSvg = desktopBtn.querySelector("svg");
    if (oldSvg) oldSvg.remove();
    desktopBtn.insertAdjacentHTML("afterbegin", flags[lang]);
  }

  // 4.3 Actualizar el indicador de idioma en el menú móvil
  const mobileHeader = document.getElementById("langBtnMobileHeader");
  if (mobileHeader) {
    mobileHeader.innerHTML = `
      <div class="flex items-center gap-2.5">
        ${flags[lang]} <span class="font-bold">${lang.toUpperCase()}</span>
      </div>
      <span class="material-symbols-outlined">expand_more</span>
    `;
  }

  // Ocultar submenús de idioma al seleccionar
  document.getElementById("langMenuDesktop")?.classList.add("hidden");
  document.getElementById("langMenuMobileHeader")?.classList.add("hidden");

  // Guardar preferencia
  localStorage.setItem("preferredLang", lang);
}

// 5. LÓGICA DE INICIALIZACIÓN DEL DOM
document.addEventListener("DOMContentLoaded", () => {
  // Pestañas (Login / Register)
  const tabLogin = document.getElementById("tabLogin");
  const tabRegister = document.getElementById("tabRegister");

  function setTabActive(activeTab, inactiveTab) {
    activeTab.classList.add(
      "text-cyan-400",
      "border-b-2",
      "border-cyan-400",
      "font-semibold",
    );
    activeTab.classList.remove(
      "text-slate-400",
      "hover:text-slate-200",
      "font-medium",
    );

    inactiveTab.classList.remove(
      "text-cyan-400",
      "border-b-2",
      "border-cyan-400",
      "font-semibold",
    );
    inactiveTab.classList.add(
      "text-slate-400",
      "hover:text-slate-200",
      "font-medium",
    );
  }

  if (tabLogin && tabRegister) {
    tabLogin.addEventListener("click", () =>
      setTabActive(tabLogin, tabRegister),
    );
    tabRegister.addEventListener("click", () =>
      setTabActive(tabRegister, tabLogin),
    );
  }

  // Cierre de menús al hacer clic fuera de ellos
  document.addEventListener("click", () => {
    document.getElementById("langMenuDesktop")?.classList.add("hidden");
    document.getElementById("langMenuMobileHeader")?.classList.add("hidden");
  });

  // Cargar el idioma guardado al iniciar
  const savedLang = localStorage.getItem("preferredLang") || "es";
  changeLanguage(savedLang);
});
