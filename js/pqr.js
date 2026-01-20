let currentPqrId = null;

let lastNotificationCount = 0;
let currentNotifications = [];

function requestNotificationPermission() {
  if ("Notification" in window && Notification.permission !== "granted") {
    Notification.requestPermission();
  }
}

function checkNotifications() {
  fetch("check_notifications.php")
    .then((response) => response.json())
    .then((data) => {
      if (data.success) {
        const badge = document.getElementById("notification-badge");
        const list = document.getElementById("notification-list");

        // Actualizar badge
        if (data.count > 0) {
          badge.classList.remove("hidden");
          badge.textContent = "";
        } else {
          badge.classList.add("hidden");
        }

        // Alerta y Notificación del sistema
        if (data.count > lastNotificationCount) {
          // Reproducir sonido si es posible
          try {
            const audio = new Audio("../../assets/sounds/notification.mp3");
            audio.play().catch((e) => console.log("Audio autoplay blocked"));
          } catch (e) {}

          // Mostrar notificación del navegador
          if (
            "Notification" in window &&
            Notification.permission === "granted"
          ) {
            const newPqr = data.notifications[0];
            if (newPqr) {
              let imagenUsuario =
                "https://ui-avatars.com/api/?name=" +
                encodeURIComponent(newPqr.nombre + " " + newPqr.apellido) +
                "&background=random";
              if (newPqr.imagen) {
                imagenUsuario = newPqr.imagen.startsWith("assets/")
                  ? "../../" + newPqr.imagen
                  : "../../assets/img/usuarios/" + newPqr.imagen;
              }

              // Para notificaciones nativas, la imagen debe ser una URL absoluta o relativa válida accesible
              // Nota: Las notificaciones del sistema a veces no muestran imágenes grandes dependiendo del OS
              new Notification("Nueva PQR Recibida", {
                body: `${newPqr.nombre} ${newPqr.apellido}: ${newPqr.asunto}`,
                icon: imagenUsuario, // Intentar mostrar la foto del usuario en la notificación
                image: imagenUsuario, // Algunos navegadores soportan esto para imagen grande
              });
            }
          }
        }
        lastNotificationCount = data.count;

        // Guardar notificaciones actuales
        currentNotifications = data.notifications;

        // Actualizar lista
        if (data.notifications.length > 0) {
          let html = "";
          data.notifications.forEach((notif, index) => {
            let imagenUsuario =
              "https://ui-avatars.com/api/?name=" +
              encodeURIComponent(notif.nombre + " " + notif.apellido) +
              "&background=random";
            if (notif.imagen) {
              imagenUsuario = notif.imagen.startsWith("assets/")
                ? "../../" + notif.imagen
                : "../../assets/img/usuarios/" + notif.imagen;
            }
            const time = new Date(notif.fecha_creacion).toLocaleTimeString(
              "es-ES",
              { hour: "2-digit", minute: "2-digit" },
            );

            html += `
                                    <div class="p-3 border-b border-[#f0f3f4] dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-700/50 cursor-pointer transition-colors" onclick="abrirNotificacion(${index})">
                                        <div class="flex gap-3">
                                            <div class="w-10 h-10 rounded-full bg-cover bg-center shrink-0" style="background-image: url('${imagenUsuario}');"></div>
                                            <div class="flex-1 overflow-hidden">
                                                <div class="flex justify-between items-start">
                                                    <p class="text-sm font-bold text-text-main dark:text-white truncate">${notif.nombre} ${notif.apellido}</p>
                                                    <span class="text-[10px] text-text-secondary">${time}</span>
                                                </div>
                                                <p class="text-xs text-primary font-medium mb-0.5">Nueva PQR #${notif.id}</p>
                                                <p class="text-xs text-text-secondary truncate">${notif.asunto}</p>
                                            </div>
                                        </div>
                                    </div>
                                `;
          });
          list.innerHTML = html;
        } else {
          list.innerHTML =
            '<div class="p-4 text-center text-xs text-text-secondary">No tienes nuevas notificaciones</div>';
        }
      }
    })
    .catch((err) => console.error("Error checking notifications:", err));
}

function abrirNotificacion(index) {
  const notif = currentNotifications[index];
  if (notif) {
    verDetallePQR(notif);
    toggleNotifications();
  }
}

function toggleNotifications() {
  const dropdown = document.getElementById("notification-dropdown");
  dropdown.classList.toggle("hidden");
}

function markAllRead() {
  document.getElementById("notification-badge").classList.add("hidden");
}

// Solicitar permiso al cargar
document.addEventListener("DOMContentLoaded", requestNotificationPermission);

// Iniciar polling
setInterval(checkNotifications, 10000);
checkNotifications();

function filterPQR(status, btn) {
  // Actualizar estado activo de los botones
  document.querySelectorAll(".filter-tab").forEach((tab) => {
    tab.classList.remove("bg-primary", "text-white");
    tab.classList.add(
      "bg-gray-100",
      "text-text-secondary",
      "hover:bg-gray-200",
      "dark:bg-gray-800",
      "dark:hover:bg-gray-700",
    );
  });

  // Si btn no está definido (carga inicial o llamada externa), buscar el botón correspondiente
  if (!btn) {
    // Lógica opcional si se necesitara persistir el filtro
    return;
  }

  btn.classList.remove(
    "bg-gray-100",
    "text-text-secondary",
    "hover:bg-gray-200",
    "dark:bg-gray-800",
    "dark:hover:bg-gray-700",
  );
  btn.classList.add("bg-primary", "text-white");

  // Filtrar items
  const items = document.querySelectorAll(".pqr-item");
  let visibleCount = 0;
  items.forEach((item) => {
    if (status === "all" || item.dataset.status === status) {
      item.classList.remove("hidden");
      visibleCount++;
    } else {
      item.classList.add("hidden");
    }
  });
}

// Función cambiarEstadoHeader eliminada

function verDetallePQR(pqr) {
  currentPqrId = pqr.id;
  const placeholder = document.getElementById("detalle-pqr-placeholder");
  const conversacionContainer = document.getElementById(
    "conversacion-container",
  );
  const mensajeInicialContainer = document.getElementById(
    "mensaje-inicial-container",
  );
  const respuestasList = document.getElementById("respuestas-list");
  const respuestaContainer = document.getElementById("respuesta-pqr-container");

  // Ocultar placeholder y mostrar conversación
  placeholder.style.display = "none";
  conversacionContainer.style.display = "block";
  respuestaContainer.classList.remove("hidden");

  // Asignar ID al formulario de respuesta
  document.getElementById("respuesta-pqr-id").value = pqr.id;

  // Establecer estado actual en el select
  const selectEstado = document.getElementById("respuesta-estado");
  for (let i = 0; i < selectEstado.options.length; i++) {
    if (selectEstado.options[i].value === pqr.estado) {
      selectEstado.selectedIndex = i;
      break;
    }
  }

  // Imagen del usuario
  let imagenUsuario =
    "https://ui-avatars.com/api/?name=" +
    encodeURIComponent(pqr.nombre + " " + pqr.apellido) +
    "&background=random";
  if (pqr.imagen) {
    imagenUsuario = pqr.imagen.startsWith("assets/")
      ? "../../" + pqr.imagen
      : "../../assets/img/usuarios/" + pqr.imagen;
  }

  // Estado y color
  let estadoColor = "text-red-600 dark:text-red-400";
  let estadoBg = "bg-red-100 dark:bg-red-900/30";

  if (pqr.estado === "En Progreso") {
    estadoColor = "text-yellow-600 dark:text-yellow-400";
    estadoBg = "bg-yellow-100 dark:bg-yellow-900/30";
  } else if (pqr.estado === "Resuelto") {
    estadoColor = "text-green-600 dark:text-green-400";
    estadoBg = "bg-green-100 dark:bg-green-900/30";
  }

  const fecha = new Date(pqr.fecha_creacion);
  const fechaFormateada =
    fecha.toLocaleDateString("es-ES", {
      day: "numeric",
      month: "long",
      year: "numeric",
    }) +
    " a las " +
    fecha.toLocaleTimeString("es-ES", { hour: "2-digit", minute: "2-digit" });

  // Renderizar mensaje inicial
  mensajeInicialContainer.innerHTML = `
                <div class="bg-background-light dark:bg-gray-800 p-4 rounded-lg flex items-center gap-4 border border-[#f0f3f4] dark:border-gray-700 mb-6">
                    <div class="w-12 h-12 rounded-full bg-cover bg-center shrink-0 border-2 border-white dark:border-gray-700 shadow-sm" style="background-image: url('${imagenUsuario}');"></div>
                    <div class="flex-1">
                        <h4 class="font-bold text-text-main dark:text-white">${pqr.nombre} ${pqr.apellido}</h4>
                        <p class="text-sm text-text-secondary">${pqr.email}</p>
                    </div>
                    <div class="flex flex-col items-end gap-1">
                        <div class="${estadoBg} ${estadoColor} text-xs px-2 py-0.5 rounded-full font-bold uppercase tracking-wider">${pqr.estado}</div>
                        <span class="text-xs text-text-secondary">ID: #${pqr.id}</span>
                        <span class="text-[10px] font-medium bg-gray-100 dark:bg-gray-700 text-gray-600 dark:text-gray-300 px-1.5 py-0.5 rounded border border-gray-200 dark:border-gray-600 uppercase tracking-wider mt-1">${pqr.tipo || "Petición"}</span>
                    </div>
                </div>
                
                <div class="flex gap-4">
                    <div class="w-10 h-10 rounded-full bg-cover bg-center shrink-0 mt-1" style="background-image: url('${imagenUsuario}');"></div>
                    <div class="flex-1 space-y-2">
                        <div class="flex items-baseline justify-between">
                            <span class="font-bold text-text-main dark:text-white">${pqr.nombre} ${pqr.apellido}</span>
                            <span class="text-xs text-text-secondary">${fechaFormateada}</span>
                        </div>
                        <div class="bg-blue-50 dark:bg-blue-900/20 p-4 rounded-r-xl rounded-bl-xl text-text-main dark:text-gray-200 text-sm leading-relaxed border border-blue-100 dark:border-blue-800/50">
                            <p class="mb-2 font-bold text-primary">Asunto: ${pqr.asunto}</p>
                            <p>${pqr.mensaje}</p>
                        </div>
                    </div>
                </div>
            `;

  // Cargar respuestas
  respuestasList.innerHTML =
    '<div class="flex justify-center p-4"><div class="animate-spin rounded-full h-6 w-6 border-b-2 border-primary"></div></div>';

  fetch(`obtener_respuestas_pqr.php?pqr_id=${pqr.id}`)
    .then((response) => response.json())
    .then((respuestas) => {
      respuestasList.innerHTML = "";

      if (respuestas.length === 0) {
        respuestasList.innerHTML =
          '<p class="text-center text-xs text-text-secondary py-4 italic">No hay respuestas aún. Sé el primero en responder.</p>';
        return;
      }

      respuestas.forEach((resp) => {
        const fechaResp = new Date(resp.fecha_respuesta);
        const fechaRespFormateada =
          fechaResp.toLocaleDateString("es-ES", {
            day: "numeric",
            month: "long",
            year: "numeric",
          }) +
          " a las " +
          fechaResp.toLocaleTimeString("es-ES", {
            hour: "2-digit",
            minute: "2-digit",
          });

        // Determinar si es respuesta de admin (siempre lo es por ahora en respuestas_pqr, pero preparamos por si acaso)
        // Como respuestas_pqr tiene admin_id, asumimos que es el admin actual o cualquier admin
        const esAdmin = true;

        let archivoHtml = "";
        if (resp.archivo) {
          const nombreArchivo = resp.archivo.split("/").pop();
          const extension = nombreArchivo.split(".").pop().toLowerCase();
          const esImagen = ["jpg", "jpeg", "png", "gif"].includes(extension);

          if (esImagen) {
            archivoHtml = `
                                    <div class="mt-3">
                                        <a href="../../${resp.archivo}" target="_blank" class="block max-w-xs rounded-lg overflow-hidden border border-gray-200 dark:border-gray-700 hover:opacity-90 transition-opacity">
                                            <img src="../../${resp.archivo}" alt="Adjunto" class="w-full h-auto object-cover">
                                        </a>
                                    </div>
                                `;
          } else {
            archivoHtml = `
                                    <div class="mt-3">
                                        <a href="../../${resp.archivo}" target="_blank" class="inline-flex items-center gap-2 px-3 py-2 bg-white dark:bg-gray-800 rounded-lg border border-gray-200 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-700 transition-colors group">
                                            <div class="p-1.5 bg-primary/10 rounded-md group-hover:bg-primary/20 transition-colors">
                                                <span class="material-symbols-outlined text-primary text-sm">description</span>
                                            </div>
                                            <span class="text-sm text-text-main dark:text-gray-300 font-medium">${nombreArchivo}</span>
                                            <span class="material-symbols-outlined text-text-secondary text-sm">open_in_new</span>
                                        </a>
                                    </div>
                                `;
          }
        }

        // Admin avatar (usar el del admin que respondió o uno genérico si no se encuentra)
        // Asegurar que usamos la imagen del admin devuelta por el backend
        let adminImg =
          "https://ui-avatars.com/api/?name=" +
          encodeURIComponent(resp.nombre || "Admin") +
          "&background=13a4ec&color=fff";
        if (resp.imagen && resp.imagen.trim() !== "") {
          adminImg = resp.imagen.startsWith("assets/")
            ? "../../" + resp.imagen
            : "../../assets/img/usuarios/" + resp.imagen;
        }

        const html = `
                             <div class="flex gap-4 flex-row-reverse">
                                 <div class="w-10 h-10 rounded-full bg-cover bg-center shrink-0 mt-1 ring-2 ring-primary/20" style="background-image: url('${adminImg}');" title="${resp.nombre} ${resp.apellido}"></div>
                                 <div class="flex-1 space-y-2 flex flex-col items-end">
                                     <div class="flex items-baseline justify-between w-full flex-row-reverse">
                                         <span class="font-bold text-text-main dark:text-white">${resp.nombre} ${resp.apellido} <span class="text-xs font-normal text-primary ml-1">(Admin)</span></span>
                                         <span class="text-xs text-text-secondary">${fechaRespFormateada}</span>
                                     </div>
                                     <div class="bg-white dark:bg-gray-800 p-4 rounded-l-xl rounded-br-xl text-text-main dark:text-gray-200 text-sm leading-relaxed border border-[#f0f3f4] dark:border-gray-700 shadow-sm w-full">
                                         <p class="whitespace-pre-wrap">${resp.mensaje}</p>
                                         ${archivoHtml}
                                     </div>
                                 </div>
                             </div>
                         `;

        respuestasList.insertAdjacentHTML("beforeend", html);
      });

      // Scroll al fondo
      conversacionContainer.scrollTop = conversacionContainer.scrollHeight;
    })
    .catch((err) => {
      console.error("Error cargando respuestas:", err);
      respuestasList.innerHTML =
        '<p class="text-center text-xs text-red-500 py-4">Error al cargar la conversación.</p>';
    });
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
        element: "header h2",
        popover: {
          title: "Gestión de PQR",
          description:
            "Bienvenido al panel de control de Peticiones, Quejas y Reclamos. Aquí podrás gestionar toda la comunicación con los usuarios.",
        },
      },
      {
        element: "#notification-btn",
        popover: {
          title: "Notificaciones",
          description:
            "Recibe alertas en tiempo real cuando lleguen nuevas solicitudes.",
        },
      },
      {
        element: 'button[onclick="location.reload()"]',
        popover: {
          title: "Actualizar Lista",
          description:
            "Pulsa aquí para refrescar la lista y buscar nuevas solicitudes manualmente.",
        },
      },
      {
        element: ".flex.gap-2.mb-4.overflow-x-auto",
        popover: {
          title: "Filtros de Estado",
          description:
            "Navega rápidamente entre solicitudes Pendientes, En Progreso o Resueltas.",
        },
      },
      {
        element: "select",
        popover: {
          title: "Filtro por Tipo",
          description:
            "Filtra específicamente por Peticiones, Quejas o Reclamos según necesites.",
        },
      },
      {
        element: ".divide-y",
        popover: {
          title: "Bandeja de Entrada",
          description:
            "Aquí encontrarás todas las solicitudes. Haz clic en cualquier tarjeta para ver el detalle completo.",
        },
      },
      {
        element: ".lg\\:w-2\\/5 + div",
        popover: {
          title: "Panel de Respuesta",
          description:
            "En esta área verás el historial de la conversación y podrás responder al usuario, adjuntar archivos y cambiar el estado de la solicitud.",
        },
      },
    ],
  });

  document.getElementById("start-tour-btn").addEventListener("click", () => {
    driverObj.drive();
  });
});
