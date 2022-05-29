<script>
  import { onMount } from "svelte";
  // contador de diapositivas actual
  var countSlide = 0;
  // numero total de dispositivas
  var maxSlide = 0;
  // diapositives
  var sliders = null;
  // width de la diapositiva
  var widthSlider = 0;
  var intervalo;

  //onload
  onMount(() => {
    sliders = document.querySelectorAll(".slide");
    maxSlide = sliders.length - 1;
    // +24 porque tiene gap-6 que son 24px de separacion entre cards
    widthSlider = sliders[0].clientWidth + 24;
    const next = document.querySelector("#next");
    const prev = document.querySelector("#prev");

    intervalo = setInterval(goNext, 3000);

    /* recalcula el width del slide cuando cambia de tamanyo la pantalla */
    window.addEventListener("resize", function () {
      widthSlider = sliders[0].clientWidth + 24;
    });
    // agregar el detector de eventos y la funcionalidad de la próxima diapositiva
    next.addEventListener("click", function () {
      clearInterval(intervalo);
      goNext();
      intervalo = setInterval(goNext, 3000);
    });
    // agregar el detector de eventos y la funcionalidad de la anterior diapositiva
    prev.addEventListener("click", function () {
      clearInterval(intervalo);
      goPrev();
      intervalo = setInterval(goNext, 3000);
    });
  });

  function goNext(e) {
    if (e) {
      e.preventDefault();
    }
    // comprueba si la diapositiva actual es el clon del final (osea la 0), restablece la diapositiva actual a 0 (la primera)
    if (countSlide === maxSlide - 2) {
      countSlide = 0;
    } else {
      countSlide++;
    }
    desplazar();
  }

  function goPrev(e) {
    if (e) {
      e.preventDefault();
    }
    // comprueba si la diapositiva actual es la primera y restablece la diapositiva actual a maxSlide (la ultima)
    if (countSlide === 0) {
      /* -2 porque se quedan 2 huecos vacíos para llenar las 3 cards  */
      countSlide = maxSlide - 2;
    } else {
      countSlide--;
    }
    desplazar();
  }
  function desplazar() {
    /* cada diapositiva se traslada el width + margen de la diapo  */
    /* si count es positivo, a la derecha y si es negativo desplaza a la izquierda */
    sliders.forEach((slide) => {
      slide.style.transform = `translateX(${countSlide * -widthSlider}px)`;
    });
  }
</script>

<div class="text-center pb-10">
  <h3
    class="mt-2 md:text-5xl leading-8 font-extrabold tracking-tight sm:text-4xl text-gray-700"
  >
    Nuestros Servicios
  </h3>
  <p
    class="mt-4 max-w-2xl text-xl lg:mx-auto text-center sm:px-5 lg:px-0 text-gray-400"
  >
    Nec ultrices dui sapien eget mi proin sed libero.
  </p>
</div>

<div class="flex items-center justify-center w-full h-full md:px-4">
  <div id="carousel-container" class="w-full flex items-center justify-center">
    <button
      id="prev"
      aria-label="slide backward"
      class=" z-30  focus:outline-none hover:bg-violeta-oscuro hover:text-white cursor-pointer rounded-full p-3"
    >
      <svg
        width="8"
        height="14"
        viewBox="0 0 8 14"
        fill="none"
        xmlns="http://www.w3.org/2000/svg"
      >
        <path
          d="M7 1L1 7L7 13"
          stroke="currentColor"
          stroke-width="2"
          stroke-linecap="round"
          stroke-linejoin="round"
        />
      </svg>
    </button>
    <div class="w-full h-full overflow-x-hidden overflow-y-hidden mx-auto">
      <div
        id="carousel"
        class="flex relative gap-6 justify-items-center transition ease-out duration-700 p-3"
      >
        <slot />
      </div>
    </div>
    <button
      id="next"
      aria-label="slide forward"
      class="z-30 focus:outline-none hover:bg-violeta-oscuro hover:text-white cursor-pointer rounded-full p-3"
    >
      <svg
        width="8"
        height="14"
        viewBox="0 0 8 14"
        fill="none"
        xmlns="http://www.w3.org/2000/svg"
      >
        <path
          d="M1 1L7 7L1 13"
          stroke="currentColor"
          stroke-width="2"
          stroke-linecap="round"
          stroke-linejoin="round"
        />
      </svg>
    </button>
  </div>
</div>
