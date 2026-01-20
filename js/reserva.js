// Inicializar Flatpickr
document.addEventListener("DOMContentLoaded", function () {
  flatpickr("#date-range", {
    mode: "range",
    dateFormat: "Y-m-d",
    locale: "es",
    theme: "dark",
    onChange: function (selectedDates, dateStr, instance) {
      // Aquí puedes agregar lógica para filtrar si lo deseas
      console.log("Fechas seleccionadas:", dateStr);
    },
  });
});

let currentReservationId = null;

function openModal(data) {
  currentReservationId = data.id;
  const modal = document.getElementById("reservationModal");

  // Set basic info
  document.getElementById("modal-id").textContent = data.id;
  document.getElementById("modal-huesped").textContent = data.huesped;
  document.getElementById("modal-email").textContent = data.email;
  document.getElementById("modal-telefono").textContent = data.telefono;
  document.getElementById("modal-ocupantes").textContent = data.ocupantes;
  document.getElementById("modal-nombres-huespedes").textContent =
    data.nombres_huespedes
      ? "Huéspedes: " + data.nombres_huespedes
      : "Sin nombres adicionales registrados";
  document.getElementById("modal-apartamento").textContent = data.apartamento;
  document.getElementById("modal-checkin").textContent = data.fecha_inicio;
  document.getElementById("modal-checkout").textContent = data.fecha_fin;
  document.getElementById("modal-noches").textContent = data.noches;
  document.getElementById("modal-total").textContent = data.total;

  // Set images
  document.getElementById("modal-user-img").style.backgroundImage =
    `url('${data.imagen_usuario}')`;
  document.getElementById("modal-apt-img").style.backgroundImage =
    `url('${data.imagen_apartamento}')`;

  // Set Status Select
  const statusSelect = document.getElementById("modal-estado-select");
  statusSelect.value = data.estado;

  // Aplicar colores iniciales al select según el estado
  updateSelectColor(statusSelect);

  // Show modal
  modal.classList.remove("hidden");
}

function updateSelectColor(select) {
  const status = select.value;
  let colorClass = "";

  // Reset classes (manteniendo base)
  select.className =
    "bg-transparent border border-gray-300 dark:border-gray-600 rounded-md text-xs font-bold mt-1 py-1 pl-2 pr-8 focus:ring-primary focus:border-primary dark:bg-gray-700 dark:text-white";

  switch (status) {
    case "Confirmada":
      select.classList.add(
        "text-green-700",
        "dark:text-green-400",
        "bg-green-50",
        "dark:bg-green-900/20",
      );
      break;
    case "Pendiente":
      select.classList.add(
        "text-yellow-700",
        "dark:text-yellow-400",
        "bg-yellow-50",
        "dark:bg-yellow-900/20",
      );
      break;
    case "Completada":
      select.classList.add(
        "text-blue-700",
        "dark:text-blue-400",
        "bg-blue-50",
        "dark:bg-blue-900/20",
      );
      break;
    case "Cancelada":
      select.classList.add(
        "text-red-700",
        "dark:text-red-400",
        "bg-red-50",
        "dark:bg-red-900/20",
      );
      break;
  }
}

function updateStatus(newStatus) {
  const select = document.getElementById("modal-estado-select");
  updateSelectColor(select);

  if (!currentReservationId) return;

  // Enviar actualización al servidor via fetch
  fetch("actualizar_estado_reserva.php", {
    method: "POST",
    headers: {
      "Content-Type": "application/x-www-form-urlencoded",
    },
    body: `id=${currentReservationId}&estado=${newStatus}`,
  })
    .then((response) => response.json())
    .then((data) => {
      if (data.success) {
        // Opcional: Mostrar notificación de éxito
        console.log("Estado actualizado correctamente");
        // Recargar página para reflejar cambios en la tabla principal
        window.location.reload();
      } else {
        alert("Error al actualizar el estado: " + data.message);
      }
    })
    .catch((error) => {
      console.error("Error:", error);
      alert("Hubo un error al conectar con el servidor");
    });
}

function closeModal() {
  const modal = document.getElementById("reservationModal");
  modal.classList.add("hidden");
}

// Close on Escape key
document.addEventListener("keydown", function (event) {
  if (event.key === "Escape") {
    closeModal();
  }
});
