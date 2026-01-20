function verApartamento(apartamento) {
  // Llenar datos en el modal
  document.getElementById("preview-image").src =
    "../../assets/img/apartamentos/" + apartamento.imagen_principal;
  document.getElementById("preview-title").innerText = apartamento.titulo;
  document.getElementById("preview-location").innerText = apartamento.ubicacion;

  // Formatear precio
  const precioFormateado = new Intl.NumberFormat("es-CO", {
    style: "currency",
    currency: "COP",
    maximumFractionDigits: 0,
  }).format(apartamento.precio);
  document.getElementById("preview-price").innerText =
    precioFormateado + " / noche";

  document.getElementById("preview-description").innerText =
    apartamento.descripcion;
  document.getElementById("preview-habitaciones").innerText =
    apartamento.habitaciones + " Habitaciones";
  document.getElementById("preview-banos").innerText =
    apartamento.banos + " Baños";
  document.getElementById("preview-capacidad").innerText =
    apartamento.capacidad + " Huéspedes";

  // Cargar servicios en preview
  const servicesContainer = document.getElementById(
    "preview-services-container",
  );
  const servicesGrid = document.getElementById("preview-services-grid");
  servicesGrid.innerHTML = "";
  servicesContainer.classList.add("hidden");

  const iconMap = {
    "Acomodación y dormitorios": "bed",
    Entretenimiento: "theater_comedy",
    "Aire acondicionado": "ac_unit",
    "Vistas panorámicas": "panorama",
    "Agua caliente": "water_drop",
    Amenities: "soap",
    "Lavadora y Secadora": "local_laundry_service",
    "Atención 24/7": "support_agent",
    "Seguridad 24/7": "local_police",
    Coworking: "work",
    Wifi: "wifi",
    Televisión: "tv",
    Gimnasio: "fitness_center",
    Piscinas: "pool",
    "Vista a la bahía": "water",
    "Vista a la playa": "beach_access",
    "Vista a las montañas": "landscape",
    "Vista al mar": "sailing",
    "Beneficios para huéspedes": "loyalty",
    "Admitimos mascotas": "pets",
    "Estadías largas": "calendar_month",
    "Limpieza (cargo adicional)": "cleaning_services",
    "Estacionamiento gratuito": "local_parking",
    "Cafe · Bar Piso 1": "coffee",
    "Cafetería Piso 18": "coffee_maker",
    "Servicio de restaurantes": "restaurant",
    "Check in 15:00 - 18:00 Hr": "login",
    "Check out 11:00 Hr": "logout",
    "Horas de silencio 23:00 - 7:00 Hr": "volume_off",
  };

  if (apartamento.servicios) {
    try {
      const servicios = JSON.parse(apartamento.servicios);
      if (Array.isArray(servicios) && servicios.length > 0) {
        servicesContainer.classList.remove("hidden");
        servicios.forEach((servicio) => {
          const icon = iconMap[servicio] || "check_circle";
          const div = document.createElement("div");
          div.className = "flex items-center gap-2 text-sm text-text-secondary";
          div.innerHTML = `<span class="material-symbols-outlined text-primary text-base">${icon}</span> <span>${servicio}</span>`;
          servicesGrid.appendChild(div);
        });
      }
    } catch (e) {
      console.error("Error parseando servicios:", e);
    }
  }

  // Cargar galería para vista previa
  const galleryContainer = document.getElementById("preview-gallery-container");
  const galleryGrid = document.getElementById("preview-gallery-grid");

  galleryGrid.innerHTML = "";
  galleryContainer.classList.add("hidden");

  fetch("obtener_galeria_be.php?id=" + apartamento.id)
    .then((response) => response.json())
    .then((data) => {
      if (data.length > 0) {
        galleryContainer.classList.remove("hidden");
        data.forEach((item) => {
          const div = document.createElement("div");
          div.className =
            "rounded-lg overflow-hidden border border-gray-200 dark:border-gray-700 h-32 relative group cursor-pointer";

          if (item.tipo === "imagen") {
            div.innerHTML = `
                                    <img src="../../assets/img/apartamentos/${item.ruta}" class="w-full h-full object-cover transition-transform duration-300 group-hover:scale-110" alt="Galería" onclick="cambiarImagenPreview('../../assets/img/apartamentos/${item.ruta}')">
                                    <div class="absolute inset-0 bg-black/0 group-hover:bg-black/10 transition-colors pointer-events-none"></div>
                                `;
          } else if (item.tipo === "video") {
            div.innerHTML = `
                                    <video src="../../assets/video/apartamentos/${item.ruta}" class="w-full h-full object-cover bg-black"></video>
                                    <div class="absolute inset-0 flex items-center justify-center pointer-events-none">
                                        <span class="material-symbols-outlined text-white text-3xl drop-shadow-lg">play_circle</span>
                                    </div>
                                `;
            div.onclick = function () {
              cambiarVideoPreview(
                "../../assets/video/apartamentos/" + item.ruta,
              );
            };
          }
          galleryGrid.appendChild(div);
        });
      }
    })
    .catch((err) => console.error("Error cargando galería preview:", err));

  // Mostrar modal
  const modal = document.getElementById("preview-modal");
  modal.classList.remove("hidden");
  modal.classList.add("flex");
  document.body.style.overflow = "hidden"; // Evitar scroll de fondo
}

function cambiarImagenPreview(src) {
  const container = document.getElementById("preview-image").parentElement;
  // Si hay un video reproduciéndose, reemplazarlo con la imagen
  if (container.querySelector("video")) {
    container.innerHTML = `
                    <img id="preview-image" src="${src}" alt="Vista previa" class="w-full h-full object-cover">
                    <button onclick="cerrarPreview()" class="absolute top-4 right-4 bg-black/50 hover:bg-black/70 text-white rounded-full p-2 transition-colors backdrop-blur-sm z-10">
                        <span class="material-symbols-outlined">close</span>
                    </button>
                    <div class="absolute bottom-4 left-4 right-4 flex justify-between items-end">
                        <div class="bg-black/50 backdrop-blur-sm p-4 rounded-xl text-white">
                            <h3 class="text-2xl font-bold" id="preview-title">${document.getElementById("preview-title").innerText}</h3>
                            <div class="flex items-center gap-1 text-gray-200 text-sm mt-1">
                                <span class="material-symbols-outlined text-sm">location_on</span>
                                <span id="preview-location">${document.getElementById("preview-location").innerText}</span>
                            </div>
                        </div>
                        <div class="bg-primary text-white px-4 py-2 rounded-xl font-bold text-lg shadow-lg" id="preview-price">
                            ${document.getElementById("preview-price").innerText}
                        </div>
                    </div>
                `;
  } else {
    document.getElementById("preview-image").src = src;
  }
}

function cambiarVideoPreview(src) {
  const container = document.getElementById("preview-image").parentElement;

  // Guardar info actual
  const title = document.getElementById("preview-title").innerText;
  const location = document.getElementById("preview-location").innerText;
  const price = document.getElementById("preview-price").innerText;

  container.innerHTML = `
                <video src="${src}" class="w-full h-full object-contain bg-black" controls autoplay></video>
                <button onclick="cerrarPreview()" class="absolute top-4 right-4 bg-black/50 hover:bg-black/70 text-white rounded-full p-2 transition-colors backdrop-blur-sm z-10">
                    <span class="material-symbols-outlined">close</span>
                </button>
                <div class="absolute bottom-4 left-4 right-4 flex justify-between items-end pointer-events-none">
                    <div class="bg-black/50 backdrop-blur-sm p-4 rounded-xl text-white pointer-events-auto">
                        <h3 class="text-2xl font-bold" id="preview-title">${title}</h3>
                        <div class="flex items-center gap-1 text-gray-200 text-sm mt-1">
                            <span class="material-symbols-outlined text-sm">location_on</span>
                            <span id="preview-location">${location}</span>
                        </div>
                    </div>
                    <div class="bg-primary text-white px-4 py-2 rounded-xl font-bold text-lg shadow-lg pointer-events-auto" id="preview-price">
                        ${price}
                    </div>
                </div>
            `;
}

function cerrarPreview() {
  const modal = document.getElementById("preview-modal");
  modal.classList.add("hidden");
  modal.classList.remove("flex");
  document.body.style.overflow = ""; // Restaurar scroll
}

function editarApartamento(apartamento) {
  document.getElementById("modal-title").innerText = "Editar Apartamento";
  document.getElementById("apartamento_id").value = apartamento.id;
  document.querySelector('input[name="titulo"]').value = apartamento.titulo;
  document.querySelector('textarea[name="descripcion"]').value =
    apartamento.descripcion;
  document.querySelector('input[name="precio"]').value = apartamento.precio;
  document.querySelector('input[name="ubicacion"]').value =
    apartamento.ubicacion;
  document.querySelector('input[name="habitaciones"]').value =
    apartamento.habitaciones;
  document.querySelector('input[name="banos"]').value = apartamento.banos;
  document.querySelector('input[name="capacidad"]').value =
    apartamento.capacidad;
  // document.querySelector('input[name="video"]').value = apartamento.video || ''; // Ya no se usa URL de video

  // Marcar servicios seleccionados
  const checkboxes = document.querySelectorAll('input[name="servicios[]"]');
  checkboxes.forEach((cb) => (cb.checked = false)); // Resetear primero

  if (apartamento.servicios) {
    try {
      const servicios = JSON.parse(apartamento.servicios);
      if (Array.isArray(servicios)) {
        servicios.forEach((s) => {
          const cb = document.querySelector(
            `input[name="servicios[]"][value="${s}"]`,
          );
          if (cb) cb.checked = true;
        });
      }
    } catch (e) {
      console.error("Error parseando servicios al editar:", e);
    }
  }

  // Imagen no es requerida al editar
  document.getElementById("imagen_input").required = false;

  // Cargar galería existente
  cargarGaleria(apartamento.id);
}

function cargarGaleria(id) {
  const containerImg = document.getElementById("galeria-imagenes-existentes");
  const containerVid = document.getElementById("galeria-videos-existentes");

  containerImg.innerHTML =
    '<div class="col-span-full text-center text-xs text-text-secondary">Cargando imágenes...</div>';
  containerVid.innerHTML =
    '<div class="col-span-full text-center text-xs text-text-secondary">Cargando videos...</div>';

  fetch("obtener_galeria_be.php?id=" + id)
    .then((response) => response.json())
    .then((data) => {
      containerImg.innerHTML = "";
      containerVid.innerHTML = "";

      if (data.length === 0) {
        containerImg.innerHTML =
          '<div class="col-span-full text-center text-xs text-text-secondary">No hay imágenes en la galería.</div>';
        containerVid.innerHTML =
          '<div class="col-span-full text-center text-xs text-text-secondary">No hay videos en la galería.</div>';
        return;
      }

      let hayImagenes = false;
      let hayVideos = false;

      data.forEach((item) => {
        const div = document.createElement("div");
        div.className =
          "relative group rounded-lg overflow-hidden border border-gray-200 dark:border-gray-700";

        if (item.tipo === "imagen") {
          hayImagenes = true;
          div.innerHTML = `
                                <img src="../../assets/img/apartamentos/${item.ruta}" class="w-full h-24 object-cover" alt="Galería">
                                <button type="button" onclick="eliminarMultimedia(${item.id}, this)" class="absolute top-1 right-1 bg-red-500 hover:bg-red-600 text-white rounded-full p-1 opacity-0 group-hover:opacity-100 transition-opacity">
                                    <span class="material-symbols-outlined text-xs">close</span>
                                </button>
                            `;
          containerImg.appendChild(div);
        } else if (item.tipo === "video") {
          hayVideos = true;
          div.innerHTML = `
                                <video src="../../assets/video/apartamentos/${item.ruta}" class="w-full h-32 object-cover bg-black" controls></video>
                                <button type="button" onclick="eliminarMultimedia(${item.id}, this)" class="absolute top-1 right-1 bg-red-500 hover:bg-red-600 text-white rounded-full p-1 z-10 opacity-0 group-hover:opacity-100 transition-opacity">
                                    <span class="material-symbols-outlined text-xs">close</span>
                                </button>
                            `;
          containerVid.appendChild(div);
        }
      });

      if (!hayImagenes)
        containerImg.innerHTML =
          '<div class="col-span-full text-center text-xs text-text-secondary">No hay imágenes adicionales.</div>';
      if (!hayVideos)
        containerVid.innerHTML =
          '<div class="col-span-full text-center text-xs text-text-secondary">No hay videos.</div>';
    })
    .catch((error) => {
      console.error("Error:", error);
      containerImg.innerHTML =
        '<div class="col-span-full text-center text-red-500 text-xs">Error al cargar galería.</div>';
      containerVid.innerHTML =
        '<div class="col-span-full text-center text-red-500 text-xs">Error al cargar videos.</div>';
    });
}

function eliminarMultimedia(id, btnElement) {
  Swal.fire({
    title: "¿Eliminar archivo?",
    text: "Se borrará permanentemente de la galería.",
    icon: "warning",
    showCancelButton: true,
    confirmButtonColor: "#d33",
    cancelButtonColor: "#3085d6",
    confirmButtonText: "Sí, eliminar",
    cancelButtonText: "Cancelar",
    customClass: {
      popup: "dark:bg-[#1a2c35] dark:text-white",
      title: "dark:text-white",
      content: "dark:text-gray-300",
    },
  }).then((result) => {
    if (result.isConfirmed) {
      const formData = new FormData();
      formData.append("id", id);

      fetch("eliminar_multimedia_be.php", {
        method: "POST",
        body: formData,
      })
        .then((response) => response.json())
        .then((data) => {
          if (data.success) {
            // Eliminar el elemento del DOM
            btnElement.closest("div").remove();
            Swal.fire({
              title: "¡Eliminado!",
              text: "El archivo ha sido eliminado.",
              icon: "success",
              timer: 1500,
              showConfirmButton: false,
              customClass: {
                popup: "dark:bg-[#1a2c35] dark:text-white",
                title: "dark:text-white",
              },
            });
          } else {
            Swal.fire("Error", data.message || "No se pudo eliminar.", "error");
          }
        })
        .catch((error) => {
          console.error("Error:", error);
          Swal.fire("Error", "Hubo un problema de conexión.", "error");
        });
    }
  });
}

function eliminarApartamento(id) {
  Swal.fire({
    title: "¿Estás seguro?",
    text: "¡No podrás revertir esto! El apartamento será eliminado permanentemente.",
    icon: "warning",
    showCancelButton: true,
    confirmButtonColor: "#13a4ec",
    cancelButtonColor: "#d33",
    confirmButtonText: "Sí, eliminarlo",
    cancelButtonText: "Cancelar",
    background: "#fff",
    color: "#111618",
    customClass: {
      popup: "dark:bg-[#1a2c35] dark:text-white",
      title: "dark:text-white",
      content: "dark:text-gray-300",
    },
  }).then((result) => {
    if (result.isConfirmed) {
      window.location.href = "eliminar_apartamento_be.php?id=" + id;
    }
  });
}

// Limpiar formulario al abrir modal para nuevo apartamento
document
  .querySelector('a[href="#apartment-modal"]')
  .addEventListener("click", function () {
    if (!this.getAttribute("onclick")) {
      // Solo si no es el botón de editar
      document.getElementById("form-apartamento").reset();
      document.getElementById("modal-title").innerText = "Nuevo Apartamento";
      document.getElementById("apartamento_id").value = "";
      document.getElementById("imagen_input").required = true;

      // Limpiar galería visual
      document.getElementById("galeria-imagenes-existentes").innerHTML = "";
      document.getElementById("galeria-videos-existentes").innerHTML = "";

      // Resetear checkboxes de servicios
      document
        .querySelectorAll('input[name="servicios[]"]')
        .forEach((cb) => (cb.checked = false));
    }
  });
//-----------------
//tour
