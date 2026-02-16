const translations = {
  es: {
    "nav-home": "Inicio",
    "hero-title": "Lugares Recomendados",
    "hero-subtitle":
      "Selección exclusiva de experiencias gastronómicas en Santa Marta.",
    foo_desc:
      "La plataforma líder en alquileres vacacionales de lujo en Santa Marta. Experiencias únicas, confort superior y las mejores vistas del Caribe colombiano.",
    foo_contact_title: "Información de Contacto",
    foo_address:
      "Apartamento 1730 - Torre 4 - Reserva del Mar 1<br>Calle 22 # 1 - 67 Playa Salguero,<br>Santa Marta, Colombia",
    foo_social_title: "Síguenos",
    foo_rights: "Todos los derechos reservados.",
    foo_made: "Hecho por",
    foo_privacy: "Políticas de Privacidad",
    foo_terms: "Términos y Condiciones",
    restaurants: [
      {
        name: "Casa Magdalena",
        addr: "Cl. 17 #2-09, Comuna 2, Santa Marta, Magdalena",
        tel: "314 5096244",
      },
      {
        name: "Guasimo",
        addr: "Cra. 2 #19-15, Comuna 2, Santa Marta,",
        tel: "300 8358604",
      },
      {
        name: "El Nascal",
        addr: "Cl. 18 #3-94, Comuna 2, Santa Marta, Magdalena",
        tel: "N/A",
      },
      {
        name: "Lulo Cafe Bar",
        addr: "Cra. 3 #16-34, Comuna 2, Santa Marta,",
        tel: "320 4768870",
      },
      {
        name: "Dónde Chucho",
        addr: "Cl. 19 #2 - 17, Comuna 2, Santa Marta, Magdalena",
        tel: "300 4410748",
      },
      {
        name: "Portho’s Steakhouse",
        addr: "Cl. 19 #3 - 25, Comuna 2, Santa Marta, Magdalena",
        tel: "(605) 3966030",
      },
      {
        name: "BK Rooftop Terrace",
        addr: "Cra 1 # 1 - 104 Rodadero, Santa Marta, Magdalena",
        tel: "300 2880266",
      },
      {
        name: "La Muzzería",
        addr: "Cra. 3 #16-02, Comuna 2, Santa Marta, Magdalena",
        tel: "314 7720146",
      },
      {
        name: "Ouzo",
        addr: "Cra. 3 #19-29, Comuna 2, Santa Marta, Magdalena",
        tel: "317 5219377",
      },
      {
        name: "Restaurante La Mart",
        addr: "Cra. 3 #16-30, Comuna 2, Santa Marta,",
        tel: "301 7155870",
      },
      {
        name: "Pachamana (Taganga)",
        addr: "Kra 1 calle 18-5, Santa Marta - Taganga",
        tel: "320 6703549",
      },
      {
        name: "Chef del Mar",
        addr: "Carrera 2 Calle 23 # 23-18, Playa Salguero, Santa Marta",
        tel: "312 6455014",
      },
      {
        name: "Nómada",
        addr: "Cl. 23 #1-52, Gaira, Santa Marta, Magdalena",
        tel: "310 6472895",
      },
    ],
  },
  en: {
    "nav-home": "Home",
    "hero-title": "Recommended Places",
    "hero-subtitle":
      "Exclusive selection of gastronomic experiences in Santa Marta.",
    foo_desc:
      "The leading luxury vacation rental platform in Santa Marta. Unique experiences, superior comfort, and the best views of the Colombian Caribbean.",
    foo_contact_title: "Contact Information",
    foo_address:
      "Apartment 1730 - Tower 4 - Reserva del Mar 1<br>22nd St # 1 - 67 Salguero Beach,<br>Santa Marta, Colombia",
    foo_social_title: "Follow Us",
    foo_rights: "All rights reserved.",
    foo_made: "Made by",
    foo_privacy: "Privacy Policies",
    foo_terms: "Terms and Conditions",
    restaurants: [
      {
        name: "Casa Magdalena",
        addr: "17th St #2-09, District 2, Santa Marta, Magdalena",
        tel: "314 5096244",
      },
      {
        name: "Guasimo",
        addr: "2nd Ave #19-15, District 2, Santa Marta,",
        tel: "300 8358604",
      },
      {
        name: "El Nascal",
        addr: "18th St #3-94, District 2, Santa Marta, Magdalena",
        tel: "N/A",
      },
      {
        name: "Lulo Cafe Bar",
        addr: "3rd Ave #16-34, District 2, Santa Marta,",
        tel: "320 4768870",
      },
      {
        name: "Dónde Chucho",
        addr: "19th St #2 - 17, District 2, Santa Marta, Magdalena",
        tel: "300 4410748",
      },
      {
        name: "Portho’s Steakhouse",
        addr: "19th St #3 - 25, District 2, Santa Marta, Magdalena",
        tel: "(605) 3966030",
      },
      {
        name: "BK Rooftop Terrace",
        addr: "1st Ave # 1 - 104 Rodadero, Santa Marta, Magdalena",
        tel: "300 2880266",
      },
      {
        name: "La Muzzería",
        addr: "3rd Ave #16-02, District 2, Santa Marta, Magdalena",
        tel: "314 7720146",
      },
      {
        name: "Ouzo",
        addr: "3rd Ave #19-29, District 2, Santa Marta, Magdalena",
        tel: "317 5219377",
      },
      {
        name: "Restaurante La Mart",
        addr: "3rd Ave #16-30, District 2, Santa Marta,",
        tel: "301 7155870",
      },
      {
        name: "Pachamana (in Taganga)",
        addr: "1st Ave 18th St-5, Taganga, Santa Marta",
        tel: "320 6703549",
      },
      {
        name: "Chef del Mar",
        addr: "2nd Ave 23rd St # 23-18, Salguero Beach, Santa Marta",
        tel: "312 6455014",
      },
      {
        name: "Nómada",
        addr: "23rd St #1-52, Gaira, Santa Marta, Magdalena",
        tel: "310 6472895",
      },
    ],
  },
};

function initMobileMenu() {
  const menuBtn = document.getElementById("menu-btn");
  const mobileMenu = document.getElementById("mobile-menu");
  const menuIcon = document.getElementById("menu-icon");
  if (menuBtn) {
    menuBtn.addEventListener("click", () => {
      const isHidden = mobileMenu.classList.toggle("hidden");
      menuIcon.textContent = isHidden ? "menu" : "close";
    });
  }
}

function changeLanguage(lang) {
  document.documentElement.lang = lang;
  document.querySelectorAll("[data-key]").forEach((el) => {
    const key = el.getAttribute("data-key");
    if (translations[lang][key]) {
      el.innerHTML = translations[lang][key];
    }
  });

  document.querySelectorAll(".flag-btn").forEach((b) => {
    b.classList.remove("flag-active");
    if (b.id.includes(lang)) b.classList.add("flag-active");
  });

  renderRestaurants(lang);
}

function renderRestaurants(lang) {
  const grid = document.getElementById("restaurant-grid");
  if (!grid) return;
  grid.innerHTML = "";
  translations[lang].restaurants.forEach((res, index) => {
    const card = document.createElement("div");
    card.className =
      "restaurant-card bg-white dark:bg-gray-950 border border-gray-100 dark:border-gray-900 p-8 flex flex-col gap-4";
    card.style.animationDelay = `${index * 0.1}s`;
    card.innerHTML = `
            <h3 class="font-display text-2xl text-black dark:text-white">${res.name}</h3>
            <div class="space-y-2 mt-2">
                <p class="text-gray-500 text-xs flex items-center gap-2">
                    <span class="material-symbols-outlined !text-lg text-accent">location_on</span> ${res.addr}
                </p>
                <p class="text-gray-400 text-[11px] tracking-widest flex items-center gap-2">
                    <span class="material-symbols-outlined !text-lg">call</span> ${res.tel}
                </p>
            </div>
        `;
    grid.appendChild(card);
    setTimeout(() => card.classList.add("visible"), 50);
  });
}

document.addEventListener("DOMContentLoaded", () => {
  initMobileMenu();
  changeLanguage("es");
});
