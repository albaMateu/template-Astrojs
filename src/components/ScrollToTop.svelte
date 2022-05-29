<script>
  import { onMount } from "svelte";
  //onload
  onMount(() => {
    let mybutton = document.getElementById("btn-back-to-top");

    // Cuando el usuario se desplace 20 píxeles hacia abajo desde la parte superior del documento, muestre el botón
    window.onscroll = function () {
      if (
        document.body.scrollTop > 20 ||
        document.documentElement.scrollTop > 20
      ) {
        mybutton.style.display = "block";
      } else {
        mybutton.style.display = "none";
      }
    };

    // Cuando el usuario haga clic en el botón, desplácese hasta la parte superior del documento
    mybutton.addEventListener("click", function () {
      document.body.scrollTop = 0;
      document.documentElement.scrollTop = 0;
    });
  });
</script>

<button
  id="btn-back-to-top"
  type="button"
  class="p-2 bg-naranja text-white rounded-full shadow-md hover:bg-rosa-plata focus:bg-rosa-plata focus:text-violeta-oscuro focus:outline-none transition duration-150 ease-in-out "
>
  <svg
    xmlns="http://www.w3.org/2000/svg"
    class="h-6 w-6"
    fill="none"
    viewBox="0 0 24 24"
    stroke="currentColor"
    stroke-width="2"
  >
    <path
      stroke-linecap="round"
      stroke-linejoin="round"
      d="M5 10l7-7m0 0l7 7m-7-7v18"
    />
  </svg>
</button>
