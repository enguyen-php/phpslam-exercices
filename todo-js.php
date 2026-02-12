<?php 

include "partials/header.php";

?>

<!-- Script JS pour le fonctionnement de la todo  -->
<script type="module" src="scripts/todo.js" defer></script>


<h1>Mon app de Todo en JS</h1>

<div class="w-80 mt-24 mx-auto">

    <!-- L'input pour insérer une todo  -->
    <div>
        <label for="todo-input" class="block text-sm/6 font-medium text-gray-900">Que faire ?</label>
        <div class="mt-2">
            <input id="todo-input" type="text" name="todo" required autocomplete="todo" class="block w-full rounded-md bg-white px-3 py-1.5 text-base text-gray-900 outline-1 -outline-offset-1 outline-gray-300 placeholder:text-gray-400 focus:outline-2 focus:-outline-offset-2 focus:outline-indigo-600 sm:text-sm/6" />
        </div>
    </div>

    <!-- Bouton de confirmation -->
    <div>
        <input value="Ok" type="submit" name="submit" class="todo-submit mt-2 flex w-full justify-center rounded-md bg-indigo-600 px-3 py-1.5 text-sm/6 font-semibold text-white shadow-xs hover:bg-indigo-500 focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600">
    </div>

    <div class="todos-zone">

    </div>

</div>


<?php

include "partials/footer.php";

?>
