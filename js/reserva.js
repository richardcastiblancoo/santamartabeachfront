/**
 * reservas.js - Gestión de previsualización de reservas
 */

function verDetalle(reserva) {
  const modal = document.getElementById("modalReserva");
  const contenido = document.getElementById("m-contenido");
  const codigo = document.getElementById("m-codigo");

  // Formatear fechas
  const options = {
    weekday: "long",
    year: "numeric",
    month: "long",
    day: "numeric",
  };
  const fIn = new Date(reserva.fecha_checkin).toLocaleDateString(
    "es-ES",
    options,
  );
  const fOut = new Date(reserva.fecha_checkout).toLocaleDateString(
    "es-ES",
    options,
  );

  codigo.innerText = `Reserva #RS-${reserva.id.toString().padStart(4, "0")}`;

  contenido.innerHTML = `
        <div class="grid grid-cols-2 gap-4 text-sm">
            <div class="col-span-2 p-3 bg-primary/5 rounded-lg border border-primary/10">
                <p class="text-[10px] uppercase font-bold text-primary">Apartamento</p>
                <p class="font-bold text-base">${reserva.apto_nombre}</p>
            </div>
            
            <div>
                <p class="text-[10px] uppercase font-bold text-text-secondary">Huésped</p>
                <p class="font-bold">${reserva.nombre_cliente} ${reserva.apellido_cliente}</p>
                <p class="text-xs text-text-secondary">${reserva.email_cliente}</p>
                <p class="text-xs text-text-secondary">${reserva.telefono_cliente || "Sin teléfono"}</p>
            </div>

            <div>
                <p class="text-[10px] uppercase font-bold text-text-secondary">Estado</p>
                <span class="inline-flex items-center px-2 py-0.5 rounded-full text-[10px] font-bold bg-gray-200 dark:bg-gray-700">
                    ${reserva.estado.toUpperCase()}
                </span>
            </div>

            <div class="col-span-2 grid grid-cols-2 gap-2 py-2 border-y dark:border-gray-800">
                <div>
                    <p class="text-[10px] uppercase font-bold text-text-secondary">Check-In</p>
                    <p class="text-xs font-medium">${fIn}</p>
                </div>
                <div>
                    <p class="text-[10px] uppercase font-bold text-text-secondary">Check-Out</p>
                    <p class="text-xs font-medium">${fOut}</p>
                </div>
            </div>

            <div>
                <p class="text-[10px] uppercase font-bold text-text-secondary">Ocupación</p>
                <p class="text-xs font-bold">${reserva.adultos} Adultos, ${reserva.ninos} Niños</p>
            </div>

            <div class="text-right">
                <p class="text-[10px] uppercase font-bold text-text-secondary">Total Pagado</p>
                <p class="text-xl font-black text-primary">$${new Intl.NumberFormat("es-CO").format(reserva.precio_total)}</p>
            </div>
        </div>
    `;

  // Mostrar modal
  modal.classList.remove("hidden");
  document.body.style.overflow = "hidden"; // Bloquear scroll
}

function cerrarModal() {
  const modal = document.getElementById("modalReserva");
  modal.classList.add("hidden");
  document.body.style.overflow = "auto"; // Restaurar scroll
}

// Cerrar con la tecla ESC
document.addEventListener("keydown", (e) => {
  if (e.key === "Escape") cerrarModal();
});
