<script>
  import { onMount } from "svelte";
  //onload
  onMount(() => {
    compruebaAceptaCookies();
    /* Analytics */
    if (localStorage.cookies == "true") {
      /* Global site tag (gtag.js) - Google Analytics */
      var tag = document.createElement("script");
      tag.type = "text/javascript";
      tag.async = true;
      tag.src = "https://www.googletagmanager.com/gtag/js?id=G-GW5C8Y3F7C";

      document.head.append(tag);

      window.dataLayer = window.dataLayer || [];

      function gtag() {
        dataLayer.push(arguments);
      }
      gtag("js", new Date());
      gtag("config", "G-GW5C8Y3F7C");
    }

    document.querySelector(".accept").addEventListener("click", function () {
      aceptarCookies();
    });

    document.querySelector(".refuse").addEventListener("click", function () {
      rechazarCookies();
    });
  });
  /* ésto comprueba la localStorage si ya tiene la variable guardada */
  function compruebaAceptaCookies() {
    if (localStorage.cookies === undefined) {
      showBannerCookies();
    }
  }

  /* aquí guardamos la variable de que se ha
aceptado el uso de cookies así no mostraremos
el mensaje de nuevo */
  function aceptarCookies() {
    localStorage.cookies = "true";
    location.reload();
  }
  function rechazarCookies() {
    localStorage.cookies = "false";
    location.reload();
  }

  /* ocultar y mostrar banner */
  function hideBannerCookies() {
    document.querySelector("#cookies").classList.add("hidden");
  }
  function showBannerCookies() {
    document.querySelector("#cookies").classList.remove("hidden");
  }
</script>

<p class="text-white">
  Utilizamos cookies propias y de terceros para obtener datos estadísticos de la
  navegación de nuestros usuarios y mejorar nuestros servicios. Puede leer más
  sobre el uso de cookies en nuestra
  <a class="text-naranja " href="/politicas" target="_blank">
    política de privacidad y condiciones de uso
  </a>.
</p>
<div class="justify-between text-white flex gap-2 self-center ">
  <button class="accept bg-green-700 rounded-md p-2">Aceptar</button>
  <button class="refuse bg-red-700 rounded-md p-2">Rechazar</button>
</div>
