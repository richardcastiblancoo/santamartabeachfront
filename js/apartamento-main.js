// 1. Diccionario de traducciones
const translations = {
  es: {
    Santamartabeachfront: 'Santamarta<span class="text-blue-400">beachfront</span>',
    Español: "Español",
    English: "English",
    "Iniciar sesión": "Iniciar sesión",
    Registrarse: "Registrarse",
    Menú: "Menú",
    Idioma: "Idioma",
    Compartir: "Compartir",
    reseñas: "reseñas",
    "Sin reseñas": "Sin reseñas",
    "Escribir reseña": "Escribir reseña",
    Huésped: "Huésped",
    "Mostrar todas las reseñas": "Mostrar todas las reseñas",
    "Aún no hay reseñas para este apartamento.": "Aún no hay reseñas para este apartamento.",
    "Escribir Reseña": "Escribir Reseña",
    Comentario: "Comentario",
    "Comparte tu experiencia...": "Comparte tu experiencia...",
    "Enviar Reseña": "Enviar Reseña",
    "Dónde te quedarás": "Dónde te quedarás",
    "Cómo llegar": "Cómo llegar",
    "Pozos Colorados, Santa Marta": "Pozos Colorados, Santa Marta",
    "Reserva del Mar - Torre 4. Un sector exclusivo y tranquilo.": "Reserva del Mar - Torre 4. Un sector exclusivo y tranquilo.",
    "/ noche": " / noche",
    Llegada: "Llegada",
    Salida: "Salida",
    "Agrega fecha": "Agrega fecha",
    Huéspedes: "Huéspedes",
    Adultos: "Adultos",
    "Edad 13+": "Edad 13+",
    Niños: "Niños",
    "Edad 2-12": "Edad 2-12",
    Bebés: "Bebés",
    "Menos de 2 años": "Menos de 2 años",
    "Perro de guía": "Perro de guía",
    "¿Tienes un perro de guía?": "¿Tienes un perro de guía?",
    Cerrar: "Cerrar",
    "Reservar ahora": "Reservar ahora",
    "No se te cobrará nada todavía": "No se te cobrará nada todavía",
    "Tarifa de limpieza": "Tarifa de limpieza",
    "footer-desc": "La plataforma líder en alquileres vacacionales de lujo en Santa Marta. Experiencias únicas, confort superior y las mejores vistas del Caribe colombiano.",
    "footer-contact-title": "Información de Contacto",
    foo_social_title: "Síguenos",
    foo_rights: "Todos los derechos reservados.",
    foo_privacy: "Políticas de Privacidad",
    foo_terms: "Términos y Condiciones",
    Fotos: "Fotos",
    "Alojamiento entero": "Alojamiento entero",
    "vivienda rentada en Playa Salguero, Colombia": "vivienda rentada en Playa Salguero, Colombia",
    huéspedes: "huéspedes",
    habitaciones: "habitaciones",
    camas: "camas",
    baños: "baños",
    "Sobre este apartamento": "Sobre este apartamento",
    "Mostrar más": "Mostrar más",
    "Mostrar menos": "Mostrar menos",
    "Comisión de servicio": "Comisión de servicio",
    Total: "Total",
    "Apartamento no encontrado": "Apartamento no encontrado",
    "El apartamento que buscas no existe o ha sido eliminado.": "El apartamento que buscas no existe o ha sido eliminado.",
    "Volver al inicio": "Volver al inicio",
    "Galería del Apartamento": "Galería del Apartamento",
    "Explora los espacios": "Explora los espacios",
    "Vista principal": "Vista principal",
    "Video Tour": "Video Tour",
    "Fin de la galería": "Fin de la galería",
    "¡Enlace copiado al portapapeles!": "¡Enlace copiado al portapapeles!",
    "Por favor, selecciona las fechas de llegada y salida.": "Por favor, selecciona las fechas de llegada y salida.",
    "Por favor selecciona una calificación": "Por favor selecciona una calificación",
    "Error: No se pudo guardar la reseña": "Error: No se pudo guardar la reseña",
    "Ocurrió un error al enviar la reseña": "Ocurrió un error al enviar la reseña",
    Bebé: "Bebé",
    "Huésped": "Huésped",
    "Beneficios para huéspedes": "Beneficios para huéspedes",
    "Admitimos mascotas": "Admitimos mascotas",
    "Estadías largas": "Estadías largas",
    "Limpieza (cargo adicional)": "Limpieza (cargo adicional)",
    "Estacionamiento gratuito": "Estacionamiento gratuito",
    "Cafe · Bar Piso 1": "Cafe · Bar Piso 1",
    "Cafetería Piso 18": "Cafetería Piso 18",
    "Servicio de restaurantes": "Servicio de restaurantes",
    "Check in 15:00 - 18:00 Hr": "Check in 15:00 - 18:00 Hr",
    "Check out 11:00 Hr": "Check out 11:00 Hr",
    "Horas de silencio 23:00 - 7:00 Hr": "Horas de silencio 23:00 - 7:00 Hr",
    "Cancelar": "Cancelar",
    "Hecho por": "Hecho por",
    "Mira este increíble apartamento en Santa Marta": "Mira este increíble apartamento en Santa Marta",
    "noche": "noche",
    "noches": "noches",
    "Reserva del Mar 1": "Reserva del Mar 1",
    "Torre 4": "Torre 4",
    "Por favor, selecciona las fechas de llegada y salida.": "Por favor, selecciona las fechas de llegada y salida."
  },
  en: {
    Santamartabeachfront: 'Santamarta<span class="text-blue-400">beachfront</span>',
    Español: "Spanish",
    English: "English",
    "Iniciar sesión": "Login",
    Registrarse: "Sign Up",
    Menú: "Menu",
    Idioma: "Language",
    Compartir: "Share",
    reseñas: "reviews",
    "Sin reseñas": "No reviews",
    "Escribir reseña": "Write a review",
    Huésped: "Guest",
    "Mostrar todas las reseñas": "Show all reviews",
    "Aún no hay reseñas para este apartamento.": "There are no reviews for this apartment yet.",
    "Escribir Reseña": "Write a Review",
    Comentario: "Comment",
    "Comparte tu experiencia...": "Share your experience...",
    "Enviar Reseña": "Send Review",
    "Dónde te quedarás": "Where you'll stay",
    "Cómo llegar": "How to get there",
    "Pozos Colorados, Santa Marta": "Pozos Colorados, Santa Marta",
    "Reserva del Mar - Torre 4. Un sector exclusivo y tranquilo.": "Reserva del Mar - Torre 4. Exclusive and quiet area.",
    "/ noche": " / night",
    Llegada: "Check-in",
    Salida: "Check-out",
    "Agrega fecha": "Add date",
    Huéspedes: "Guests",
    Adultos: "Adults",
    "Edad 13+": "Age 13+",
    Niños: "Children",
    "Edad 2-12": "Age 2-12",
    Bebés: "Infants",
    "Menos de 2 años": "Under 2 years",
    "Perro de guía": "Guide dog",
    "¿Tienes un perro de guía?": "Do you have a guide dog?",
    Cerrar: "Close",
    "Reservar ahora": "Book now",
    "No se te cobrará nada todavía": "You won't be charged yet",
    "Tarifa de limpieza": "Cleaning fee",
    "footer-desc": "The leading platform for luxury vacation rentals in Santa Marta. Unique experiences, superior comfort and the best views of the Colombian Caribbean.",
    "footer-contact-title": "Contact Information",
    foo_social_title: "Follow us",
    foo_rights: "All rights reserved.",
    foo_privacy: "Privacy Policy",
    foo_terms: "Terms and Conditions",
    Fotos: "Photos",
    "Alojamiento entero": "Entire place",
    "vivienda rentada en Playa Salguero, Colombia": "rental home in Playa Salguero, Colombia",
    huéspedes: "guests",
    habitaciones: "bedrooms",
    camas: "beds",
    baños: "bathrooms",
    "Sobre este apartamento": "About this apartment",
    "Mostrar más": "Show more",
    "Mostrar menos": "Show less",
    "Comisión de servicio": "Service fee",
    Total: "Total",
    "Apartamento no encontrado": "Apartment not found",
    "El apartamento que buscas no existe o ha sido eliminado.": "The apartment you are looking for does not exist or has been deleted.",
    "Volver al inicio": "Back to home",
    "Galería del Apartamento": "Apartment Gallery",
    "Explora los espacios": "Explore the spaces",
    "Vista principal": "Main view",
    "Video Tour": "Video Tour",
    "Fin de la galería": "End of gallery",
    "¡Enlace copiado al portapapeles!": "Link copied to clipboard!",
    "Por favor, selecciona las fechas de llegada y salida.": "Please select check-in and check-out dates.",
    "Por favor selecciona una calificación": "Please select a rating",
    "Error: No se pudo guardar la reseña": "Error: Could not save review",
    "Ocurrió un error al enviar la reseña": "An error occurred while sending the review",
    Bebé: "Infant",
    "Huésped": "Guest",
    "¡Totalmente equipado con todo lo que necesitas y esperas en un entorno moderno en cualquier parte del mundo! Este es un complejo de condominios privado frente a la playa. La torre 4 es la más nueva y está más cerca de la playa. ¡Bienvenido y disfruta de tu visita a Santa Marta!": "Fully equipped with everything you need and expect in a modern environment anywhere in the world! This is a private beachfront condo complex. Tower 4 is the newest and closest to the beach. Welcome and enjoy your visit to Santa Marta!",
    "Lo que este lugar ofrece": "What this place offers",
    "Acomodación y dormitorios": "Accommodation and bedrooms",
    Entretenimiento: "Entertainment",
    "Aire acondicionado": "Air conditioning",
    "Vistas panorámicas": "Panoramic views",
    "Agua caliente": "Hot water",
    Amenities: "Amenities",
    "Lavadora y Secadora": "Washer and Dryer",
    "Atención 24/7": "24/7 Support",
    "Seguridad 24/7": "24/7 Security",
    Coworking: "Coworking",
    Wifi: "Wifi",
    Televisión: "Television",
    Gimnasio: "Gym",
    Piscinas: "Pools",
    "Vista a la bahía": "Bay view",
    "Vista a la playa": "Beach view",
    "Vista a las montañas": "Mountain view",
    "Vista al mar": "Sea view",
    "Beneficios para huéspedes": "Guest benefits",
    "Admitimos mascotas": "Pets allowed",
    "Estadías largas": "Long stays",
    "Limpieza (cargo adicional)": "Cleaning (additional charge)",
    "Estacionamiento gratuito": "Free parking",
    "Cafe · Bar Piso 1": "Cafe · Bar 1st Floor",
    "Cafetería Piso 18": "Coffee Shop 18th Floor",
    "Servicio de restaurantes": "Restaurant service",
    "Check in 15:00 - 18:00 Hr": "Check-in 15:00 - 18:00 Hr",
    "Check out 11:00 Hr": "Check-out 11:00 Hr",
    "Horas de silencio 23:00 - 7:00 Hr": "Quiet hours 23:00 - 7:00 Hr",
    "Cancelar": "Cancel",
    "Hecho por": "Made by",
    "Mira este increíble apartamento en Santa Marta": "Check out this amazing apartment in Santa Marta",
    "noche": "night",
    "noches": "nights",
    "Reserva del Mar 1": "Reserva del Mar 1",
    "Torre 4": "Tower 4",
    "Por favor, selecciona las fechas de llegada y salida.": "Please select your check-in and check-out dates."
  }
};

// 2. Función principal para aplicar traducciones
function applyTranslations(lang) {
  document.querySelectorAll("[data-i18n]").forEach((element) => {
    const key = element.getAttribute("data-i18n");
    if (translations[lang] && translations[lang][key]) {
      // Usamos innerHTML por si la traducción tiene etiquetas como el <span> del logo
      element.innerHTML = translations[lang][key];
    }
  });

  document.querySelectorAll("[data-i18n-placeholder]").forEach((element) => {
    const key = element.getAttribute("data-i18n-placeholder");
    if (translations[lang] && translations[lang][key]) {
      element.placeholder = translations[lang][key];
    }
  });

  // Guardar preferencia en el navegador
  localStorage.setItem("preferredLang", lang);
}

// 3. Funciones de la Interfaz (Dropdowns y Menús)
function toggleLangDesktop() {
  const dropdown = document.getElementById("lang-dropdown");
  dropdown.classList.toggle("hidden");

  // Cerrar al hacer clic fuera
  const closeDropdown = (e) => {
    if (!e.target.closest(".relative")) {
      dropdown.classList.add("hidden");
      window.removeEventListener("click", closeDropdown);
    }
  };
  setTimeout(() => window.addEventListener("click", closeDropdown), 10);
}

function toggleMobileMenu() {
  const menu = document.getElementById("mobile-menu");
  const isHidden = menu.classList.contains("translate-x-full");
  menu.classList.toggle("translate-x-full", !isHidden);
  document.body.style.overflow = isHidden ? "hidden" : "auto";
}

function toggleLangMobile() {
  const options = document.getElementById("mobile-lang-options");
  options.classList.toggle("hidden");
}

// 4. Función para seleccionar idioma y actualizar banderas
function selectLang(lang, flagUrl) {
  const languageCode = lang.toLowerCase();

  // Actualizar UI Escritorio con verificación de existencia (Safe Check)
  const desktopText = document.getElementById("current-lang-text");
  const desktopFlag = document.getElementById("current-lang-flag");
  const langName = languageCode === 'es' ? 'Español' : 'English';
  const translatedLang = (translations[languageCode] && translations[languageCode][langName]) || lang;
  
  if (desktopText) desktopText.innerText = translatedLang;
  if (desktopFlag) desktopFlag.src = flagUrl;

  // Actualizar UI Móvil con verificación de existencia
  const mobileText = document.getElementById("mobile-current-text");
  const mobileFlag = document.getElementById("mobile-current-flag");
  if (mobileText) mobileText.innerText = translatedLang;
  if (mobileFlag) mobileFlag.src = flagUrl;

  // Aplicar traducción
  applyTranslations(languageCode);

  // Cerrar dropdown si existe
  const dropdown = document.getElementById("lang-dropdown");
  if (dropdown) dropdown.classList.add("hidden");

  console.log("Idioma cambiado a: " + lang);
}

// 5. Inicialización al cargar la página
document.addEventListener("DOMContentLoaded", () => {
  const preferredLang = localStorage.getItem("preferredLang") || "es";
  applyTranslations(preferredLang);
  
  // Si no es el idioma por defecto (es), actualizar la UI de selección
  if (preferredLang !== "es") {
    const flagUrl = preferredLang === "en" ? "https://flagcdn.com/us.svg" : "https://flagcdn.com/co.svg";
    const langDisplay = preferredLang === "en" ? "English" : "Español";
    
    const desktopText = document.getElementById("current-lang-text");
    const desktopFlag = document.getElementById("current-lang-flag");
    if (desktopText) desktopText.innerText = langDisplay;
    if (desktopFlag) desktopFlag.src = flagUrl;

    const mobileText = document.getElementById("mobile-current-text");
    const mobileFlag = document.getElementById("mobile-current-flag");
    if (mobileText) mobileText.innerText = langDisplay;
    if (mobileFlag) mobileFlag.src = flagUrl;
  }
});
