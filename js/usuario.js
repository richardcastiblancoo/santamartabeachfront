document.addEventListener("DOMContentLoaded", function () {
  const searchInput = document.getElementById("search_input");
  if (searchInput) {
    searchInput.addEventListener("keyup", function () {
      let query = this.value;
      let role = "<?php echo $role_filter; ?>";

      let formData = new FormData();
      formData.append("search", query);
      formData.append("role", role);

      fetch("buscar_usuarios_be.php", {
        method: "POST",
        body: formData,
      })
        .then((response) => response.text())
        .then((data) => {
          document.querySelector("tbody").innerHTML = data;
        })
        .catch((error) => console.error("Error:", error));
    });
  }
});

function openDeleteModal(id) {
  const modal = document.getElementById("delete-user-modal");
  const confirmBtn = document.getElementById("confirm-delete-btn");
  confirmBtn.href = `eliminar_usuario_be.php?id=${id}`;
  modal.classList.remove("hidden");
  modal.style.display = "flex";
}

function closeDeleteModal() {
  const modal = document.getElementById("delete-user-modal");
  modal.classList.add("hidden");
  modal.style.display = "none";
}

function openEditModal(data) {
  document.getElementById("edit-id").value = data.id;
  document.getElementById("edit-nombre").value = data.nombre;
  document.getElementById("edit-apellido").value = data.apellido;
  document.getElementById("edit-usuario").value = data.usuario;
  document.getElementById("edit-email").value = data.email;

  // Seleccionar el rol correcto
  const rolSelect = document.getElementById("edit-rol");
  const rol =
    data.rol.charAt(0).toUpperCase() + data.rol.slice(1).toLowerCase(); // Capitalizar
  for (let i = 0; i < rolSelect.options.length; i++) {
    if (rolSelect.options[i].value.toLowerCase() === data.rol.toLowerCase()) {
      rolSelect.selectedIndex = i;
      break;
    }
  }

  // Previsualizar imagen actual
  let imagenUrl =
    "https://ui-avatars.com/api/?name=" +
    encodeURIComponent(data.nombre + " " + data.apellido) +
    "&background=random";
  if (data.imagen) {
    imagenUrl = data.imagen.startsWith("assets/")
      ? "../../" + data.imagen
      : "../../assets/img/usuarios/" + data.imagen;
  }
  document.getElementById("edit-image-preview").style.backgroundImage =
    `url('${imagenUrl}')`;

  const modal = document.getElementById("edit-user-modal");
  modal.classList.remove("hidden");
  modal.style.display = "flex";
}

function closeEditModal() {
  const modal = document.getElementById("edit-user-modal");
  modal.classList.add("hidden");
  modal.style.display = "none";
}

function openPreviewModal(data) {
  document.getElementById("preview-name").textContent =
    data.nombre + " " + data.apellido;
  document.getElementById("preview-email").textContent = data.email;
  document.getElementById("preview-username").textContent = data.usuario;
  document.getElementById("preview-date").textContent = new Date(
    data.reg_date,
  ).toLocaleDateString("es-ES", {
    year: "numeric",
    month: "long",
    day: "numeric",
  });

  // Imagen
  let imagenUrl =
    "https://ui-avatars.com/api/?name=" +
    encodeURIComponent(data.nombre + " " + data.apellido) +
    "&background=random";
  if (data.imagen) {
    imagenUrl = data.imagen.startsWith("assets/")
      ? "../../" + data.imagen
      : "../../assets/img/usuarios/" + data.imagen;
  }
  document.getElementById("preview-image").style.backgroundImage =
    `url('${imagenUrl}')`;

  // Rol y estilos
  const roleBadge = document.getElementById("preview-role");
  roleBadge.textContent = data.rol;
  if (data.rol.toLowerCase() === "admin") {
    roleBadge.className =
      "px-3 py-1 rounded-full text-xs font-bold uppercase mb-6 bg-blue-100 text-blue-700";
  } else {
    roleBadge.className =
      "px-3 py-1 rounded-full text-xs font-bold uppercase mb-6 bg-gray-100 text-gray-700";
  }

  const modal = document.getElementById("preview-user-modal");
  modal.classList.remove("hidden");
  modal.style.display = "flex";
}

function closePreviewModal() {
  const modal = document.getElementById("preview-user-modal");
  modal.classList.add("hidden");
  modal.style.display = "none";
}

// Driver.js Tour
document.addEventListener("DOMContentLoaded", function () {
  const driver = window.driver.js.driver;

  const driverObj = driver({
    showProgress: true,
    nextBtnText: "Siguiente",
    prevBtnText: "Anterior",
    doneBtnText: "Finalizar",
    steps: [
      {
        element: "#users-header",
        popover: {
          title: "Gestión de Usuarios",
          description:
            "Aquí puedes administrar todos los usuarios registrados en la plataforma.",
        },
      },
      {
        element: "#add-user-btn",
        popover: {
          title: "Nuevo Usuario",
          description:
            "Haz clic aquí para registrar manualmente un nuevo administrador o usuario.",
        },
      },
      {
        element: "#filter-tabs",
        popover: {
          title: "Filtros Rápidos",
          description:
            "Navega fácilmente entre todos los usuarios, solo huéspedes o solo administradores.",
        },
      },
      {
        element: "#search-form",
        popover: {
          title: "Búsqueda Avanzada",
          description:
            "Encuentra usuarios rápidamente por su nombre, correo electrónico o nombre de usuario.",
        },
      },
      {
        element: "#users-section table",
        popover: {
          title: "Lista de Usuarios",
          description:
            "Consulta la información detallada, roles y estado de cada usuario en esta tabla.",
        },
      },
      {
        element: "#users-section table tbody tr:first-child td:last-child",
        popover: {
          title: "Acciones",
          description:
            "Usa estos botones para ver detalles, editar información o eliminar un usuario.",
        },
      },
    ],
  });

  document.getElementById("start-tour-btn").addEventListener("click", () => {
    driverObj.drive();
  });
});

//----------------------menu
function toggleSidebar() {
  const sidebar = document.querySelector("aside");
  const overlay = document.getElementById("sidebar-overlay");

  // Si el sidebar tiene la clase 'hidden', lo mostramos
  if (sidebar.classList.contains("hidden")) {
    sidebar.classList.remove("hidden");
    sidebar.classList.add("fixed", "inset-y-0", "left-0", "z-50");

    overlay.classList.remove("hidden");
    setTimeout(() => {
      overlay.classList.remove("opacity-0");
      overlay.classList.add("opacity-100");
    }, 10);
  } else {
    // Si ya está visible, lo ocultamos
    sidebar.classList.add("hidden");
    sidebar.classList.remove("fixed", "inset-y-0", "left-0", "z-50");

    overlay.classList.add("opacity-0");
    overlay.classList.remove("opacity-100");
    setTimeout(() => {
      overlay.classList.add("hidden");
    }, 300);
  }
}
