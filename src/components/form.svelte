<script>
  import { onMount } from "svelte";
  /* Adding an event listener to the submit button, so when the user clicks on it, it will call the
validateForm() function, and if it returns true, it will call the sendEmail */
  //onload
  onMount(() => {
    const submit = document.getElementById("send-btn");
    submit.addEventListener(
      "click",
      function (e) {
        e.preventDefault(); //evita el reload en el submit
        if (validateForm()) {
          sendEmail();
        }
      },
      false
    );
  });

  /**
   * If the value is equal to the constant NULL, then return true, otherwise return false
   * @param value - The value to check.
   * @returns true
   */
  function isEmpty(value) {
    return value === "" || value === null ? true : false;
  }
  /**
   * It checks if the email is valid.
   * @param email - The email address to validate.
   * @returns the result of the test.
   */
  function validateEmail(email) {
    var re = /\S+@\S+\.\S+/;
    return re.test(email);
  }

  /**
   * It returns true if the value is a number, and false if it's not.
   * @param value - The value to be validated.
   * @returns A boolean value.
   */
  function validateOnlyNumbers(value) {
    var re = /^([0-9])*$/;
    return re.test(value);
  }

  /**
   * It checks if the input fields are empty, if the email is valid, if the phone number is valid, if the
   * checkbox is checked, and if all of the above are true, it returns true.
   * @returns a boolean value.
   */
  function validateForm() {
    /* div de error a mostrar */
    const box = document.getElementById("toast-danger");

    /* It's removing the class "shadowError" from the element that has it. */
    let border = document.querySelector(".shadowError");
    if (border) {
      border.classList.remove("shadowError");
    }

    /* Removing the class "flex" and adding the class "hidden" to the div with the id "toast-danger". */
    if (box.classList.contains("flex")) {
      box.classList.remove("flex");
      box.classList.add("hidden");
    }

    /* Nombre */
    const name = document.getElementById("name");
    var nameValue = name.value;
    /* E-mail */
    const email = document.getElementById("email");
    var emailValue = email.value;
    /* Telefono */
    const tel = document.getElementById("phone");
    var telValue = tel.value;
    /* Asunto */
    const subject = document.getElementById("subject");
    var subjectValue = subject.value;
    /* Mensaje */
    const message = document.getElementById("message");
    var messageValue = message.value;
    /* checkbox */
    const checkbox = document.getElementById("terms");
    var checkboxChecked = checkbox.checked;

    /* Validaciones */
    if (isEmpty(nameValue)) {
      box.classList.remove("hidden");
      box.classList.add("flex");
      name.classList.add("shadowError");

      return false;
    } else if (isEmpty(emailValue) || !validateEmail(emailValue)) {
      box.classList.remove("hidden");
      box.classList.add("flex");
      email.classList.add("shadowError");

      return false;
    } else if (
      isEmpty(telValue) ||
      !validateOnlyNumbers(telValue) ||
      telValue.length !== 9
    ) {
      box.classList.remove("hidden");
      box.classList.add("flex");
      tel.classList.add("shadowError");

      return false;
    } else if (isEmpty(subjectValue)) {
      box.classList.remove("hidden");
      box.classList.add("flex");
      subject.classList.add("shadowError");

      return false;
    } else if (isEmpty(messageValue)) {
      box.classList.remove("hidden");
      box.classList.add("flex");
      message.classList.add("shadowError");

      return false;
    } else if (!checkboxChecked) {
      box.classList.remove("hidden");
      box.classList.add("flex");
      const terms = document.getElementById("termsCheck");
      terms.classList.add("shadowError");

      return false;
    } else {
      return true;
    }
  }

  /**
   * It sends a POST request to the sendEmail.php file, and if the request is successful, it displays a
   * success message
   *
   * @return [void]
   *
   */
  async function sendEmail() {
    let form = new FormData(document.getElementById("form"));
    /* no hi ha que posar header quan envie form  */
    await fetch("sendEmail.php", {
      method: "POST",
      body: form,
    })
      .then(async function (response) {
        let text = await response.text();
        let json = JSON.parse(text);
        if (json.status === "Success") {
          let boxSuccess = document.getElementById("toast-success");
          boxSuccess.classList.remove("hidden");
          boxSuccess.classList.add("flex");
        } else {
          let boxError = document.getElementById("toast-danger");
          boxError.classList.remove("hidden");
          boxError.classList.add("flex");
          document.querySelector(".messageError").innerHTML = json.message;
        }
      })
      .catch(function (err) {
        console.log(err);
      });
  }
</script>

<div class="mx-auto">
  <div class="text-center pb-10">
    <h3
      class="mt-2 md:text-5xl leading-8 font-extrabold tracking-tight sm:text-4xl text-gray-700"
    >
      Pide tu presupuesto
    </h3>
    <p
      class="mt-4 max-w-2xl text-xl lg:mx-auto text-center sm:px-5 lg:px-0 text-gray-400"
    >
      Descubre qué podemos hacer por ti.
      <span class="block">Sin compromiso.</span>
    </p>
  </div>
  <div
    class="sm:my-7 md:m-8 p-5 rounded-xl mb-0 bg-violeta-oscuro bg-opacity-25"
  >
    <form id="form" method="POST">
      <div class="mb-3">
        <label for="name" class="block mb-1 text-sm text-gray-600 "
          >Nombre</label
        >
        <input
          type="text"
          name="name"
          id="name"
          placeholder="Tu nombre"
          class=" placeholder-gray-300 focus:border-naranja"
        />
      </div>
      <div class="mb-3">
        <label for="email" class="block mb-1 text-sm text-gray-600 "
          >E-mail</label
        >
        <input
          type="email"
          name="email"
          id="email"
          placeholder="tu@correo.com"
          class=" placeholder-gray-300 focus:border-naranja"
        />
      </div>
      <div class="mb-3">
        <label for="phone" class="text-sm text-gray-600 ">Teléfono</label>
        <input
          type="text"
          name="phone"
          id="phone"
          placeholder="999 999 999"
          class=" placeholder-gray-300 focus:border-naranja"
        />
      </div>
      <div class="mb-3">
        <label for="subject" class="block mb-1 text-sm text-gray-600 "
          >Tu asunto</label
        >
        <input
          type="text"
          name="subject"
          id="subject"
          placeholder="Tu asunto"
          class=" placeholder-gray-300 focus:border-naranja"
        />
      </div>
      <div class="mb-3">
        <label for="message" class="block mb-1 text-sm text-gray-600 "
          >Tu mensaje</label
        >
        <textarea
          name="message"
          id="message"
          placeholder="Mensaje"
          class=" placeholder-gray-300 focus:border-naranja"
          rows="5"
        />
      </div>
      <div id="termsCheck" class="mb-3 flex items-baseline">
        <input
          type="checkbox"
          name="terms"
          id="terms"
          class="focus:border-naranja checked:bg-naranja"
        />
        <p class="mb-0 ml-2">
          He leído y acepto la <a
            class="text-naranja "
            href="/politicas"
            target="_blank"
          >
            política de privacidad y las condiciones de uso
          </a>.
        </p>
      </div>
      <button
        id="send-btn"
        type="submit"
        class="w-full px-3 py-4 text-white focus:bg-violeta-claro rounded-md bg-naranja focus:outline-none"
      >
        Enviar
      </button>

      <div
        id="toast-success"
        class="hidden items-center w-full p-4 mt-4 text-gray-500 bg-white rounded-lg shadow"
        role="alert"
      >
        <div
          class="inline-flex items-center justify-center flex-shrink-0 w-8 h-8 text-green-500 bg-green-100 rounded-lg"
        >
          <svg
            class="w-5 h-5"
            fill="currentColor"
            viewBox="0 0 20 20"
            xmlns="http://www.w3.org/2000/svg"
            ><path
              fill-rule="evenodd"
              d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z"
              clip-rule="evenodd"
            /></svg
          >
        </div>
        <div class="ml-3 text-sm font-normal messageSuccess">
          Mensaje enviado correctamente.
        </div>
        <button
          type="button"
          class="ml-auto -mx-1.5 -my-1.5 bg-white text-gray-400 hover:text-gray-900 rounded-lg focus:ring-2 focus:ring-gray-300 p-1.5 hover:bg-gray-100 inline-flex h-8 w-8 "
          data-dismiss-target="#toast-success"
          aria-label="Close"
        >
          <span class="sr-only">Close</span>
          <svg
            class="w-5 h-5"
            fill="currentColor"
            viewBox="0 0 20 20"
            xmlns="http://www.w3.org/2000/svg"
            ><path
              fill-rule="evenodd"
              d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z"
              clip-rule="evenodd"
            /></svg
          >
        </button>
      </div>
      <div
        id="toast-danger"
        class="hidden items-center w-full p-4 mt-4 text-gray-500 bg-white rounded-lg shadow"
        role="alert"
      >
        <div
          class="inline-flex items-center justify-center flex-shrink-0 w-8 h-8 text-red-500 bg-red-100 rounded-lg"
        >
          <svg
            class="w-5 h-5"
            fill="currentColor"
            viewBox="0 0 20 20"
            xmlns="http://www.w3.org/2000/svg"
            ><path
              fill-rule="evenodd"
              d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z"
              clip-rule="evenodd"
            /></svg
          >
        </div>
        <div class="ml-3 text-sm font-normal messageError">
          Hay algún error. Por favor, revisa los campos.
        </div>
        <button
          type="button"
          class="ml-auto -mx-1.5 -my-1.5 bg-white text-gray-400 hover:text-gray-900 rounded-lg focus:ring-2 focus:ring-gray-300 p-1.5 hover:bg-gray-100 inline-flex h-8 w-8 "
          data-dismiss-target="#toast-danger"
          aria-label="Close"
        >
          <span class="sr-only">Close</span>
          <svg
            class="w-5 h-5"
            fill="currentColor"
            viewBox="0 0 20 20"
            xmlns="http://www.w3.org/2000/svg"
            ><path
              fill-rule="evenodd"
              d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z"
              clip-rule="evenodd"
            /></svg
          >
        </button>
      </div>
    </form>
  </div>
</div>
