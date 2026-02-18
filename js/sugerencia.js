function toggleSidebar() {
  const sidebar = document.getElementById("sidebar");
  const overlay = document.getElementById("sidebar-overlay");

  if (sidebar.classList.contains("-translate-x-full")) {
    sidebar.classList.remove("-translate-x-full");
    overlay.classList.remove("hidden");
    setTimeout(() => overlay.classList.remove("opacity-0"), 10);
  } else {
    sidebar.classList.add("-translate-x-full");
    overlay.classList.add("opacity-0");
    setTimeout(() => overlay.classList.add("hidden"), 300);
  }
}

// --- Lógica del Modal ---
const modal = document.getElementById("suggestionModal");
const modalBackdrop = document.getElementById("modalBackdrop");
const modalContent = document.getElementById("modalContent");

function openModal(name, date, text, img) {
  // Llenar datos
  document.getElementById("modalName").innerText = name;
  document.getElementById("modalDate").innerText = date;
  document.getElementById("modalText").innerHTML = text; // innerHTML para respetar saltos de línea si usas nl2br
  document.getElementById("modalImg").src = img;

  // Mostrar modal
  modal.classList.remove("hidden");

  // Animación de entrada
  setTimeout(() => {
    modalBackdrop.classList.remove("opacity-0");
    modalContent.classList.remove(
      "opacity-0",
      "translate-y-4",
      "sm:translate-y-0",
      "sm:scale-95",
    );
    modalContent.classList.add("translate-y-0", "scale-100");
  }, 10);
}

function closeModal() {
  // Animación de salida
  modalBackdrop.classList.add("opacity-0");
  modalContent.classList.remove("translate-y-0", "scale-100");
  modalContent.classList.add(
    "opacity-0",
    "translate-y-4",
    "sm:translate-y-0",
    "sm:scale-95",
  );

  // Ocultar div después de la animación
  setTimeout(() => {
    modal.classList.add("hidden");
  }, 300);
}

// Cerrar modal al dar click fuera (en el backdrop)
modalBackdrop.addEventListener("click", closeModal);

// Cerrar con tecla Escape
document.addEventListener("keydown", function (event) {
  if (event.key === "Escape" && !modal.classList.contains("hidden")) {
    closeModal();
  }
});
//------------------------------

//-----------------------------
// 1. Menú Hamburgesa
function toggleSidebar() {
  const sidebar = document.getElementById("sidebar");
  const overlay = document.getElementById("sidebar-overlay");
  sidebar.classList.toggle("-translate-x-full");
  overlay.classList.toggle("hidden");
}

// 2. Buscador en Tiempo Real
function filterTable() {
  const input = document.getElementById("realTimeSearch").value.toLowerCase();
  const rows = document.querySelectorAll(".suggestion-row");

  rows.forEach((row) => {
    const name = row.querySelector(".user-name").innerText.toLowerCase();
    const text = row.querySelector(".sug-text").innerText.toLowerCase();

    if (name.includes(input) || text.includes(input)) {
      row.style.display = "";
    } else {
      row.style.display = "none";
    }
  });
}

// 3. Modal Dinámico
function openModal(name, date, text, img) {
  document.getElementById("modalName").innerText = name;
  document.getElementById("modalDate").innerText = "Enviado el: " + date;
  document.getElementById("modalText").innerText = text;
  document.getElementById("modalImg").src = img;
  document.getElementById("suggestionModal").classList.remove("hidden");
}

function closeModal() {
  document.getElementById("suggestionModal").classList.add("hidden");
}

//-----------------------------------------------

//
document.addEventListener("DOMContentLoaded", () => {
  /* -----------------------------------------------------
       1. Lógica de Filtros (Todas / Nuevas)
    ----------------------------------------------------- */
  const btnAll = document.getElementById("filter-all");
  const btnNew = document.getElementById("filter-new");

  function setActiveButton(activeBtn, inactiveBtn) {
    // Estilos para el activo
    activeBtn.classList.remove(
      "text-gray-400",
      "font-semibold",
      "hover:text-white",
    );
    activeBtn.classList.add("bg-primary", "text-white", "font-bold");

    // Estilos para el inactivo
    inactiveBtn.classList.remove("bg-primary", "text-white", "font-bold");
    inactiveBtn.classList.add(
      "text-gray-400",
      "font-semibold",
      "hover:text-white",
    );
  }

  if (btnAll && btnNew) {
    btnAll.addEventListener("click", () => {
      setActiveButton(btnAll, btnNew);
      filterTableByDate("todas");
    });

    btnNew.addEventListener("click", () => {
      setActiveButton(btnNew, btnAll);
      filterTableByDate("nuevas");
    });
  }

  /* -----------------------------------------------------
       2. Buscador en Tiempo Real
    ----------------------------------------------------- */
  const searchInput = document.getElementById("realTimeSearch");
  if (searchInput) {
    searchInput.addEventListener("keyup", () => {
      const filter = searchInput.value.toLowerCase();
      const rows = document.querySelectorAll(".suggestion-row");

      rows.forEach((row) => {
        const name = row.querySelector(".user-name").textContent.toLowerCase();
        const msg = row.querySelector(".sug-text").textContent.toLowerCase();

        if (name.includes(filter) || msg.includes(filter)) {
          row.style.display = "";
        } else {
          row.style.display = "none";
        }
      });
    });
  }

  /* -----------------------------------------------------
       3. Guía Interactiva (Driver.js)
    ----------------------------------------------------- */
  const driver = window.driver.js.driver;

  const driverObj = driver({
    showProgress: true,
    nextBtnText: "Siguiente",
    prevBtnText: "Anterior",
    doneBtnText: "Finalizar",
    steps: [
      {
        element: "#sidebar",
        popover: {
          title: "Menú Lateral",
          description:
            "Navega entre las diferentes secciones del sistema aquí.",
        },
      },
      {
        element: "#table-container",
        popover: {
          title: "Lista de Sugerencias",
          description:
            "Aquí verás todas las sugerencias enviadas por los usuarios.",
        },
      },
      {
        element: "#filter-container",
        popover: {
          title: "Filtros Rápidos",
          description:
            "Alterna entre ver todas las sugerencias o solo las recibidas recientemente (últimos 7 días).",
        },
      },
      {
        element: "#realTimeSearch",
        popover: {
          title: "Buscador",
          description:
            "Escribe el nombre del huésped o palabras clave para encontrar sugerencias específicas.",
        },
      },
      {
        element: ".action-btn",
        popover: {
          title: "Ver Detalle",
          description:
            "Haz clic en el ojo para leer el mensaje completo del usuario.",
        },
      },
    ],
  });

  const btnGuide = document.getElementById("btn-guide");
  if (btnGuide) {
    btnGuide.addEventListener("click", () => {
      driverObj.drive();
    });
  }
});

/* -----------------------------------------------------
   4. Funciones Auxiliares (Modal y Sidebar)
----------------------------------------------------- */

function toggleSidebar() {
  const sidebar = document.getElementById("sidebar");
  const overlay = document.getElementById("sidebar-overlay");
  sidebar.classList.toggle("-translate-x-full");
  overlay.classList.toggle("hidden");
}

function filterTableByDate(type) {
  const rows = document.querySelectorAll(".suggestion-row");
  const today = new Date();

  rows.forEach((row) => {
    if (type === "todas") {
      row.style.display = "";
      return;
    }
    // Asumiendo formato dd/mm/yyyy en la columna fecha
    const dateText = row.querySelector(".date-col").textContent.trim();
    const parts = dateText.split("/");
    // Nota: Meses en JS son 0-11
    const rowDate = new Date(parts[2], parts[1] - 1, parts[0]);

    // Diferencia en días
    const diffTime = Math.abs(today - rowDate);
    const diffDays = Math.ceil(diffTime / (1000 * 60 * 60 * 24));

    // Mostrar si tiene menos de 7 días
    if (diffDays <= 7) {
      row.style.display = "";
    } else {
      row.style.display = "none";
    }
  });
}

function openModal(name, date, message, img) {
  const modal = document.getElementById("suggestionModal");
  const content = document.getElementById("modal-content");

  document.getElementById("modalName").textContent = name;
  document.getElementById("modalDate").textContent = date;
  document.getElementById("modalText").textContent = message;
  document.getElementById("modalImg").src = img;

  modal.classList.remove("hidden");
  // Pequeño timeout para permitir que la clase hidden se quite antes de animar
  setTimeout(() => {
    content.classList.remove("scale-95");
    content.classList.add("scale-100");
  }, 10);
}

function closeModal() {
  const modal = document.getElementById("suggestionModal");
  const content = document.getElementById("modal-content");

  content.classList.remove("scale-100");
  content.classList.add("scale-95");

  setTimeout(() => {
    modal.classList.add("hidden");
  }, 200);
}
