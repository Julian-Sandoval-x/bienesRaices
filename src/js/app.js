document.addEventListener("DOMContentLoaded", function () {
  eventListeners();
  darkMode();
});

function darkMode() {
  // Preferencia del usuario en base a su sistema
  const prefeDarkMode = window.matchMedia("(prefers-color-scheme: dark)");
  console.log(prefeDarkMode);

  // if (prefeDarkMode) {
  //   document.body.classList.add("dark-mode");
  // } else {
  //   document.body.classList.remove("dark-mode");
  // }

  prefeDarkMode
    ? document.body.classList.add("dark-mode")
    : document.body.classList.remove("dark-mode");

  prefeDarkMode.addEventListener("change", function () {
    prefeDarkMode
      ? document.body.classList.add("dark-mode")
      : document.body.classList.remove("dark-mode");
  });

  const dark = document.querySelector(".dark-mode-boton");
  dark.addEventListener("click", function () {
    document.body.classList.toggle("dark-mode");
  });
}

function eventListeners() {
  const mobileMenu = document.querySelector(".mobile-menu");
  mobileMenu.addEventListener("click", navResponsive);

  // Muestra campos condicionales
  const metodoContacto = document.querySelectorAll(
    'input[name="contacto[contacto]"]'
  );
  metodoContacto.forEach((input) =>
    input.addEventListener("click", mostrarMetodosContacto)
  );
}

function navResponsive() {
  const navegacion = document.querySelector(".navegacion");
  navegacion.classList.toggle("mostrar"); // Agrega la clase o en caso de que la tenga la quita
}

function mostrarMetodosContacto(e) {
  const contactoDiv = document.querySelector("#contacto");

  if (e.target.value === "telefono") {
    contactoDiv.innerHTML = `
            <label for="telefono">Número Teléfonico</label>
            <input type="tel" placeholder="Tu teléfono" id="telefono" name="contacto[telefono]">

            <p>Elija la fecha y la hora para la llamada </p>

            <label for="fecha">Fecha</label>
            <input type="date" id="fecha" name="contacto[fecha]">

            <label for="hora">Hora</label>
            <input type="time" id="hora" min="09:00" max="18:00" name="contacto[hora]">
    `;
  } else {
    contactoDiv.innerHTML = `
            <label for="email">E-mail</label>
            <input type="email" placeholder="Tu Email" id="email" name="contacto[email]" required>
    `;
  }
}
