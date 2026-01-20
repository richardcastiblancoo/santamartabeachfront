function showTab(tabName) {
  // IDs of setting containers
  const containers = ["profile-settings", "security-settings"];
  // IDs of buttons
  const buttons = ["btn-profile", "btn-security"];
  containers.forEach((id) => {
    const el = document.getElementById(id);
    if (el) el.classList.add("hidden");
  });
  buttons.forEach((id) => {
    const btn = document.getElementById(id);
    if (btn) {
      btn.classList.remove(
        "bg-card-light",
        "dark:bg-card-dark",
        "text-primary",
        "border-l-4",
        "border-primary",
        "shadow-sm",
      );
      btn.classList.add(
        "text-text-secondary",
        "hover:bg-card-light",
        "dark:hover:bg-card-dark",
        "hover:text-text-main",
      );
      const span = btn.querySelector("span:last-child");
      if (span) span.classList.remove("font-semibold");
      if (span) span.classList.add("font-medium");
    }
  });
  // Show active container
  const activeContainer = document.getElementById(tabName + "-settings");
  if (activeContainer) activeContainer.classList.remove("hidden");
  // Active active button
  const activeBtn = document.getElementById("btn-" + tabName);
  if (activeBtn) {
    activeBtn.classList.remove(
      "text-text-secondary",
      "hover:bg-card-light",
      "dark:hover:bg-card-dark",
      "hover:text-text-main",
    );
    activeBtn.classList.add(
      "bg-card-light",
      "dark:bg-card-dark",
      "text-primary",
      "border-l-4",
      "border-primary",
      "shadow-sm",
    );
    const span = activeBtn.querySelector("span:last-child");
    if (span) span.classList.remove("font-medium");
    if (span) span.classList.add("font-semibold");
  }
}

function togglePassword(inputId) {
  const input = document.getElementById(inputId);
  const button = input.nextElementSibling;
  const icon = button.querySelector("span");

  if (input.type === "password") {
    input.type = "text";
    icon.textContent = "visibility_off";
  } else {
    input.type = "password";
    icon.textContent = "visibility";
  }
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
          title: "Configuración del Sistema",
          description:
            "Aquí podrás gestionar tu perfil, seguridad y preferencias visuales de la plataforma.",
        },
      },
      {
        element: "aside",
        popover: {
          title: "Menú Principal",
          description:
            "Utiliza este menú para navegar entre las diferentes secciones del panel de administración.",
        },
      },
      {
        element: "#btn-profile",
        popover: {
          title: "Perfil Personal",
          description:
            "En esta sección puedes actualizar tu foto, nombre y correo electrónico.",
        },
      },
      {
        element: "#profile-settings",
        popover: {
          title: "Editar Perfil",
          description:
            "Utiliza este formulario para modificar tus datos personales.",
        },
        onHighlightStarted: () => showTab("profile"),
      },
      {
        element: "#btn-security",
        popover: {
          title: "Seguridad",
          description: "Gestiona la seguridad de tu cuenta.",
        },
        onHighlightStarted: () => showTab("security"),
      },
      {
        element: "#security-settings",
        popover: {
          title: "Credenciales",
          description:
            "Actualiza tu nombre de usuario y cambia tu contraseña periódicamente para mayor seguridad.",
        },
        onHighlightStarted: () => showTab("security"),
      },
    ],
  });

  const startBtn = document.getElementById("start-tour-btn");
  if (startBtn) {
    startBtn.addEventListener("click", () => {
      driverObj.drive();
    });
  }
});
