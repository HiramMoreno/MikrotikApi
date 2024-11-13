<html>
 <head>
  <title>
   Bienvenido a su panel de control de Mikrotik
  </title>
  <script src="https://cdn.tailwindcss.com">
  </script>
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" rel="stylesheet"/>
  <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;700&amp;display=swap" rel="stylesheet"/>
  <link rel="stylesheet" href="{{ asset('css/view.css') }}">
  <style>
   body {
            font-family: 'Roboto', sans-serif;
        }
  </style>
 </head>
 <body>
  <div class="text-center">
   <img alt="Alternative company logo of Mikrotik with stylized text" class="mx-auto mb-8" height="100" src="{{ asset('images/logo.png') }}" width="300"/>
   <h1 class="text-4xl font-bold text-gray-800 mb-8">
    Bienvenido a su panel de control de Mikrotik
   </h1>
   <a class="bg-blue-500 text-white px-6 py-3 rounded-full text-lg font-semibold hover:bg-white-600 transition duration-0" href="/api/mikrotik/users">
    Ir al Panel de Control
   </a>
  </div>
 </body>