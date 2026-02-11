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
      "Apartamento 1730 - Torre 4 - Reserva del Mar 1. Calle 22 # 1 - 67 Playa Salguero, Gaira - Santa Marta, Colombia",
    foo_social_title: "Síguenos",
    foo_rights: "Todos los derechos reservados.",
    foo_made: "Hecho por",
    foo_privacy: "Políticas de Privacidad",
    foo_terms: "Términos y Condiciones",
    restaurants: [
      {
        name: "Ouzo Santa Marta",
        addr: "Carrera 3 #19-29, Centro",
        tel: "+57 304 666 7788",
      },
      {
        name: "Donde Chucho Gourmet",
        addr: "Calle 19 #2-17, Centro",
        tel: "+57 318 555 6677",
      },
      {
        name: "Tsuki Sushi Bar",
        addr: "Carrera 3 #16-44, Centro",
        tel: "+57 301 222 3344",
      },
      {
        name: "Burukuka",
        addr: "Edificio El Rodadero",
        tel: "+57 315 888 9900",
      },
      {
        name: "Mar y Zielo",
        addr: "Calle 15 #3-05, Centro",
        tel: "+57 300 444 5566",
      },
      {
        name: "Radio Salsa",
        addr: "Calle 17 #2-44, Centro",
        tel: "+57 310 111 2233",
      },
      {
        name: "Soul Food",
        addr: "Calle 16 #2-58, Centro",
        tel: "+57 302 999 8877",
      },
      {
        name: "Porthos Steakhouse",
        addr: "Carrera 3 #17-26, Centro",
        tel: "+57 311 444 5566",
      },
      {
        name: "Guasimo",
        addr: "Calle 12 #3-87, Centro",
        tel: "+57 305 777 8899",
      },
      {
        name: "Lulo",
        addr: "Carrera 3 #16-34, Centro",
        tel: "+57 320 666 5544",
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
      "Apartment 1730 - Tower 4 - Reserva del Mar 1. 22nd St # 1 - 67 Salguero Beach, Gaira - Santa Marta, Colombia",
    foo_social_title: "Follow Us",
    foo_rights: "All rights reserved.",
    foo_made: "Made by",
    foo_privacy: "Privacy Policy",
    foo_terms: "Terms and Conditions",
    restaurants: [
      {
        name: "Ouzo Santa Marta",
        addr: "3rd Ave #19-29, Downtown",
        tel: "+57 304 666 7788",
      },
      {
        name: "Donde Chucho Gourmet",
        addr: "19th St #2-17, Downtown",
        tel: "+57 318 555 6677",
      },
      {
        name: "Tsuki Sushi Bar",
        addr: "3rd Ave #16-44, Downtown",
        tel: "+57 301 222 3344",
      },
      {
        name: "Burukuka",
        addr: "El Rodadero Building",
        tel: "+57 315 888 9900",
      },
      {
        name: "Mar y Zielo",
        addr: "15th St #3-05, Downtown",
        tel: "+57 300 444 5566",
      },
      {
        name: "Radio Salsa",
        addr: "17th St #2-44, Downtown",
        tel: "+57 310 111 2233",
      },
      {
        name: "Soul Food",
        addr: "16th St #2-58, Downtown",
        tel: "+57 302 999 8877",
      },
      {
        name: "Porthos Steakhouse",
        addr: "3rd Ave #17-26, Downtown",
        tel: "+57 311 444 5566",
      },
      {
        name: "Guasimo",
        addr: "12th St #3-87, Downtown",
        tel: "+57 305 777 8899",
      },
      {
        name: "Lulo",
        addr: "3rd Ave #16-34, Downtown",
        tel: "+57 320 666 5544",
      },
    ],
  },
};

function changeLanguage(lang) {
  document.documentElement.lang = lang;
  document.querySelectorAll("[data-key]").forEach((el) => {
    const key = el.getAttribute("data-key");
    if (translations[lang][key]) el.innerText = translations[lang][key];
  });

  document
    .querySelectorAll(".flag-btn")
    .forEach((b) => b.classList.remove("flag-active"));
  document.getElementById("btn-" + lang).classList.add("flag-active");

  renderRestaurants(lang);
}

function renderRestaurants(lang) {
  const grid = document.getElementById("restaurant-grid");
  grid.innerHTML = "";

  translations[lang].restaurants.forEach((res, index) => {
    const card = document.createElement("div");
    card.className = `restaurant-card bg-white dark:bg-gray-950 border border-gray-100 dark:border-gray-900 p-8 flex flex-col gap-4`;
    card.style.animationDelay = `${index * 0.1}s`;

    card.innerHTML = `
                    <h3 class="font-display text-2xl text-black dark:text-white leading-tight">${res.name}</h3>
                    <div class="space-y-2 mt-2">
                        <p class="text-gray-500 dark:text-gray-400 text-xs font-medium flex items-center gap-2">
                            <span class="material-symbols-outlined !text-sm text-accent">location_on</span> ${res.addr}
                        </p>
                        <p class="text-gray-400 dark:text-gray-500 text-[11px] tracking-widest flex items-center gap-2">
                            <span class="material-symbols-outlined !text-sm">call</span> ${res.tel}
                        </p>
                    </div>
                `;
    grid.appendChild(card);
    setTimeout(() => card.classList.add("visible"), 50);
  });
}

document.addEventListener("DOMContentLoaded", () => changeLanguage("es"));
