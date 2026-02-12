<?php

include "partials/header.php";
include "partials/check-session.php";

if (isset($_GET["error"])) {
    $error = "Veuillez remplir tous les champs";
} elseif (isset($_GET["success"])) {
    $message = "Votre mail a bien été envoyé !";
}

?>

<!-- Page de contact  -->
<div class="isolate bg-white px-6 py-24 sm:py-32 lg:px-8">


  <!-- <div aria-hidden="true" class="absolute inset-x-0 -top-40 -z-10 transform-gpu overflow-hidden blur-3xl sm:-top-80">
    <div style="clip-path: polygon(74.1% 44.1%, 100% 61.6%, 97.5% 26.9%, 85.5% 0.1%, 80.7% 2%, 72.5% 32.5%, 60.2% 62.4%, 52.4% 68.1%, 47.5% 58.3%, 45.2% 34.5%, 27.5% 76.7%, 0.1% 64.9%, 17.9% 100%, 27.6% 76.8%, 76.1% 97.7%, 74.1% 44.1%)" class="relative left-1/2 -z-10 aspect-1155/678 w-144.5 max-w-none -translate-x-1/2 rotate-30 bg-linear-to-tr from-[#ff80b5] to-[#9089fc] opacity-30 sm:left-[calc(50%-40rem)] sm:w-288.75"></div>
  </div> -->
  <div class="mx-auto max-w-2xl text-center">
    <h2 class="text-4xl font-semibold tracking-tight text-balance text-gray-900 sm:text-5xl">Contact</h2>
    <p class="mt-4 text-lg/8 text-gray-600">Contactez nous par mail via le formulaire ci-dessous</p>
  </div>

    <?php if (isset($message)) : ?>

        <h3 class="text-green-500 text-center mt-4"><?= $message ?></h3>

    <?php endif ?>

    <!-- Formulaire de contact en POST -->
  <form action="contact-process.php" method="POST" class="mx-auto mt-16 max-w-xl sm:mt-20">
    <div class="grid grid-cols-1 gap-x-8 gap-y-6 sm:grid-cols-2">
      <div>
        <label for="first-name" class="block text-sm/6 font-semibold text-gray-900">Prénom</label>
        <div class="mt-2.5">
          <input id="first-name" type="text" name="first-name" autocomplete="given-name" class="block w-full rounded-md bg-white px-3.5 py-2 text-base text-gray-900 outline-1 -outline-offset-1 outline-gray-300 placeholder:text-gray-400 focus:outline-2 focus:-outline-offset-2 focus:outline-indigo-600" />
        </div>
      </div>
      <div>
        <label for="last-name" class="block text-sm/6 font-semibold text-gray-900">Nom</label>
        <div class="mt-2.5">
          <input id="last-name" type="text" name="last-name" autocomplete="family-name" class="block w-full rounded-md bg-white px-3.5 py-2 text-base text-gray-900 outline-1 -outline-offset-1 outline-gray-300 placeholder:text-gray-400 focus:outline-2 focus:-outline-offset-2 focus:outline-indigo-600" />
        </div>
      </div>
      <div class="sm:col-span-2">
        <label for="email" class="block text-sm/6 font-semibold text-gray-900">Email</label>
        <div class="mt-2.5">
          <input id="email" type="email" name="email" autocomplete="email" class="block w-full rounded-md bg-white px-3.5 py-2 text-base text-gray-900 outline-1 -outline-offset-1 outline-gray-300 placeholder:text-gray-400 focus:outline-2 focus:-outline-offset-2 focus:outline-indigo-600" />
        </div>
      </div>
      <div class="sm:col-span-2">
        <label for="message" class="block text-sm/6 font-semibold text-gray-900">Message</label>
        <div class="mt-2.5">
          <textarea id="message" name="message" rows="4" class="block w-full rounded-md bg-white px-3.5 py-2 text-base text-gray-900 outline-1 -outline-offset-1 outline-gray-300 placeholder:text-gray-400 focus:outline-2 focus:-outline-offset-2 focus:outline-indigo-600"></textarea>
        </div>
      </div>
      <div class="flex gap-x-4 sm:col-span-2">
        <div class="flex h-6 items-center">
          <div class="group relative inline-flex w-8 shrink-0 rounded-full bg-gray-200 p-px inset-ring inset-ring-gray-900/5 outline-offset-2 outline-indigo-600 transition-colors duration-200 ease-in-out has-checked:bg-indigo-600 has-focus-visible:outline-2">
            <span class="size-4 rounded-full bg-white shadow-xs ring-1 ring-gray-900/5 transition-transform duration-200 ease-in-out group-has-checked:translate-x-3.5"></span>
            <input id="agree-to-policies" type="checkbox" name="agree-to-policies" aria-label="Agree to policies" class="absolute inset-0 size-full appearance-none focus:outline-hidden" />
          </div>
        </div>
        <label for="agree-to-policies" class="text-sm/6 text-gray-600">
          En cochant cette case vous acceptez nos conditions 
        </label>
      </div>
    </div>
    <div class="mt-10">
      <button name="submit" type="submit" class="block w-full rounded-md bg-indigo-600 px-3.5 py-2.5 text-center text-sm font-semibold text-white shadow-xs hover:bg-indigo-500 focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600">Envoyer le mail</button>
    </div>
  </form>
</div>

<?php if (isset($error)) : ?>

    <h3 class="text-red-500"><?= $error ?></h3>

<?php endif ?>


<?php

include "partials/footer.php";

?>