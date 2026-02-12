<?php

include "partials/header.php";
include "partials/check-session.php";
include "config/cURL.php";
include "dotenv.php";

// WIDGET METEO : 

// - Avec cURL on veut récupérer les infos de la météo actuelle -> logo pour le temps qu'il fait, l'endroit, 
//  la température (en degrés celcius)
// - Pour faire l'appel API on utilise Weather API, il va falloir une clé API disponible dans My API keys 
// sur le site 

// !! Utiliser la fonction connectToAPI qui est dans notre fichier cURL.php
// Afin d'afficher le logo du temps utiliser le short code dans la réponse API

// Url qui pointe vers l'API weather avec la clé API et lon et lat précisés 
$weatherUrl = "https://api.openweathermap.org/data/2.5/weather?lat=48.78&lon=2.04&appid=$apiKey&units=metric";

$weather = connectToAPI($weatherUrl);
$date = getdate();

// echo "<pre>";
// print_r($weather);
// echo "</pre>";

?>

<!-- WIDGET METEO AVEC TAILWIND  -->
<div class=" absolute right-0 w-64 h-fit cursor-pointer border b-gray-400 rounded flex flex-col justify-center items-center text-center p-6 bg-white">

  <div class="text-md font-bold flex flex-col text-gray-900"><span class="uppercase">Today</span> <span class="font-normal text-gray-700 text-sm"><?= $date["weekday"] . " " . $date["mday"] . " " . $date["month"] . " " . $date["year"] ?></span></div>
  
  <div class="w-32 h-32 flex items-center justify-center">
    <img src="https://openweathermap.org/img/wn/<?= $weather["weather"][0]["icon"] ?>@2x.png" alt="">
  </div>

  <p class="text-gray-700 mb-2"><?= $weather["weather"][0]["main"] ?></p>

  <div class="text-3xl font-bold text-gray-900 mb-6"><?= round($weather["main"]["temp"]) ?> °C</div>

  <div class="flex justify-between w-full">

    <div class="flex items-center text-gray-700 px-2">
       <?= $weather["main"]["humidity"] ?> l/m<sup>2</sup>
    </div>

    <div class="flex items-center text-gray-700 px-2">
      <?= round($weather["wind"]["speed"]) ?>  km/h
    </div>

  </div>
</div>


<div class="relative isolate px-6 pt-14 lg:px-8 -z-1">
    <div aria-hidden="true" class="absolute inset-x-0 -top-40 transform-gpu overflow-hidden blur-3xl sm:-top-80">
      <div style="clip-path: polygon(74.1% 44.1%, 100% 61.6%, 97.5% 26.9%, 85.5% 0.1%, 80.7% 2%, 72.5% 32.5%, 60.2% 62.4%, 52.4% 68.1%, 47.5% 58.3%, 45.2% 34.5%, 27.5% 76.7%, 0.1% 64.9%, 17.9% 100%, 27.6% 76.8%, 76.1% 97.7%, 74.1% 44.1%)" class="relative left-[calc(50%-11rem)] aspect-1155/678 w-144.5 -translate-x-1/2 rotate-30 bg-linear-to-tr from-[#ff80b5] to-[#9089fc] opacity-30 sm:left-[calc(50%-30rem)] sm:w-288.75 -z-10"></div>
    </div>

    <div class="mx-auto max-w-2xl py-24 sm:py-24 lg:py-24">
      <div class="text-center">
        <h1 class="animate animate__animated animate__zoomIn text-5xl font-semibold tracking-tight text-balance text-gray-900 sm:text-7xl">Bienvenue sur le Shop <?= $_SESSION["username"] ?> ! </h1>
        <p class="mt-8 text-lg font-medium text-pretty text-gray-500 sm:text-xl/8">Parce que PHP c'est pas le plus hype mais ça marche quand meme bien ...</p>
      </div>
    </div>
</div>


<?php

include "partials/footer.php";

?>