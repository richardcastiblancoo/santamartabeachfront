function openResponseModal(id, subject, name) {
  document.getElementById("modal_pqr_id").value = id;
  document.getElementById("modal_subject").textContent = subject;
  document.getElementById("modal_user_name").textContent = name;
  document.getElementById("responseModal").classList.remove("hidden");
}

function closeResponseModal() {
  document.getElementById("responseModal").classList.add("hidden");
  document.getElementById("responseForm").reset();
}

// Edit Modal Functions
function openEditModal(id) {
  fetch(`get_apartamento.php?id=${id}`)
    .then((response) => response.json())
    .then((data) => {
      if (data.error) {
        alert(data.error);
      } else {
        document.getElementById("edit_id").value = data.id;
        document.getElementById("edit_titulo").value = data.titulo;
        document.getElementById("edit_ubicacion").value = data.ubicacion;
        document.getElementById("edit_precio").value = data.precio;
        document.getElementById("edit_habitaciones").value = data.habitaciones;
        document.getElementById("edit_banos").value = data.banos;
        document.getElementById("edit_capacidad").value = data.capacidad;
        document.getElementById("edit_descripcion").value = data.descripcion;
        document.getElementById("editModal").classList.remove("hidden");
      }
    })
    .catch((error) => console.error("Error:", error));
}

function closeEditModal() {
  document.getElementById("editModal").classList.add("hidden");
}

// View Modal Functions
let currentGalleryIndex = 0;
let currentGalleryItems = [];

function openViewModal(id) {
  // Reset state
  currentGalleryIndex = 0;
  currentGalleryItems = [];

  fetch(`get_apartamento.php?id=${id}`)
    .then((response) => response.json())
    .then((data) => {
      if (data.error) {
        alert(data.error);
      } else {
        document.getElementById("view_titulo").textContent = data.titulo;
        document.getElementById("view_ubicacion").textContent = data.ubicacion;
        document.getElementById("view_precio").textContent =
          "$" + new Intl.NumberFormat().format(data.precio) + " / noche";
        document.getElementById("view_habitaciones").textContent =
          data.habitaciones;
        document.getElementById("view_banos").textContent = data.banos;
        document.getElementById("view_capacidad").textContent = data.capacidad;
        document.getElementById("view_descripcion").textContent =
          data.descripcion;

        // Add main image first
        if (data.imagen_principal) {
          currentGalleryItems.push({
            type: "imagen",
            fullPath: `../../assets/img/apartamentos/${data.imagen_principal}`,
          });
        } else {
          currentGalleryItems.push({
            type: "imagen",
            fullPath: "https://placehold.co/600x400",
          });
        }

        // Fetch gallery items
        return fetch(`obtener_galeria_be.php?id=${id}`);
      }
    })
    .then((response) => {
      if (response) return response.json();
    })
    .then((galleryData) => {
      if (galleryData && Array.isArray(galleryData)) {
        galleryData.forEach((item) => {
          let path = "";
          if (item.tipo === "imagen")
            path = `../../assets/img/apartamentos/${item.ruta}`;
          else if (item.tipo === "video")
            path = `../../assets/video/apartamentos/${item.ruta}`;

          currentGalleryItems.push({
            type: item.tipo,
            fullPath: path,
          });
        });
      }

      updateCarousel();
      document.getElementById("viewModal").classList.remove("hidden");
    })
    .catch((error) => console.error("Error:", error));
}

function updateCarousel() {
  if (currentGalleryItems.length === 0) return;

  const item = currentGalleryItems[currentGalleryIndex];
  const imgContainer = document.getElementById("view_image_container");
  const vidContainer = document.getElementById("view_video_container");
  const counter = document.getElementById("slide-counter");
  const prevBtn = document.getElementById("prev-slide");
  const nextBtn = document.getElementById("next-slide");

  // Update counter
  counter.textContent = `${currentGalleryIndex + 1}/${currentGalleryItems.length}`;

  // Toggle buttons visibility
  if (currentGalleryItems.length > 1) {
    prevBtn.classList.remove("hidden");
    nextBtn.classList.remove("hidden");
  } else {
    prevBtn.classList.add("hidden");
    nextBtn.classList.add("hidden");
  }

  if (item.type === "imagen") {
    imgContainer.style.backgroundImage = `url('${item.fullPath}')`;
    imgContainer.classList.remove("hidden");
    vidContainer.classList.add("hidden");
    vidContainer.innerHTML = ""; // Stop any playing video
  } else {
    imgContainer.classList.add("hidden");
    vidContainer.classList.remove("hidden");
    vidContainer.innerHTML = `<video src="${item.fullPath}" controls class="h-full w-full object-contain" autoplay></video>`;
  }
}

function nextSlide() {
  if (currentGalleryItems.length <= 1) return;
  currentGalleryIndex = (currentGalleryIndex + 1) % currentGalleryItems.length;
  updateCarousel();
}

function prevSlide() {
  if (currentGalleryItems.length <= 1) return;
  currentGalleryIndex =
    (currentGalleryIndex - 1 + currentGalleryItems.length) %
    currentGalleryItems.length;
  updateCarousel();
}

function closeViewModal() {
  document.getElementById("viewModal").classList.add("hidden");
  // Stop any video playing
  document.getElementById("view_video_container").innerHTML = "";
}

// Sidebar Toggle Function
function toggleSidebar() {
  const sidebar = document.getElementById("sidebar");
  const overlay = document.getElementById("sidebar-overlay");

  if (sidebar.classList.contains("-translate-x-full")) {
    // Open sidebar
    sidebar.classList.remove("-translate-x-full");
    overlay.classList.remove("hidden");
    setTimeout(() => {
      overlay.classList.remove("opacity-0");
    }, 10);
  } else {
    // Close sidebar
    sidebar.classList.add("-translate-x-full");
    overlay.classList.add("opacity-0");
    setTimeout(() => {
      overlay.classList.add("hidden");
    }, 300);
  }
}

document.addEventListener("DOMContentLoaded", function () {
  const driver = window.driver.js.driver;

  const driverObj = driver({
    showProgress: true,
    animate: true,
    nextBtnText: "Siguiente",
    prevBtnText: "Anterior",
    doneBtnText: "Finalizar",
    steps: [
      {
        element: "body",
        popover: {
          title: "Bienvenido al Panel de Administrador",
          description:
            "Este es un recorrido rápido para familiarizarte con las funcionalidades principales del dashboard.",
        },
      },
      {
        element: "aside",
        popover: {
          title: "Menú de Navegación",
          description:
            "Desde aquí puedes acceder a todas las secciones del sistema: Apartamentos, Reservas, Usuarios y Configuración.",
        },
      },
      {
        element: "#dashboard-section",
        popover: {
          title: "Resumen Administrativo",
          description:
            "Visualiza rápidamente los indicadores clave como el total de reservas y PQR pendientes.",
        },
      },
      {
        element: "#apartments-section",
        popover: {
          title: "Gestión de Apartamentos",
          description:
            "Administra tus propiedades. Puedes ver el listado, filtrar, agregar nuevos apartamentos o editar los existentes.",
        },
      },
      {
        element: "#bookings-section",
        popover: {
          title: "Control de Reservas",
          description:
            "Gestiona las reservas. Revisa el estado (Confirmada, Pendiente, etc.), detalles del huésped y fechas.",
        },
      },
      {
        element: "#pqr-section",
        popover: {
          title: "Bandeja de PQR",
          description:
            "Atiende las Peticiones, Quejas y Reclamos de los usuarios. Puedes ver el detalle y responder directamente.",
        },
      },
      {
        element: "#start-tour",
        popover: {
          title: "Ayuda y Recorrido",
          description:
            "Si necesitas ver este recorrido nuevamente, puedes hacer clic en este botón de ayuda.",
        },
      },
    ],
  });

  const startTourBtn = document.getElementById("start-tour");
  if (startTourBtn) {
    startTourBtn.addEventListener("click", function () {
      driverObj.drive();
    });
  }

  // Opcional: Iniciar automáticamente si es la primera vez (puedes usar localStorage)
   if (!localStorage.getItem('tour_visto')) {
       driverObj.drive();
       localStorage.setItem('tour_visto', 'true');
   }
});
