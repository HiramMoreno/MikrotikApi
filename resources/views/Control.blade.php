<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Panel De Control</title>

    
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" />
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;700&display=swap" />
    <script src="https://cdn.tailwindcss.com"></script>
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link rel="stylesheet" href="{{ asset('css/view.css') }}">
</head>
<body>
        <header class="header p-2 bg-white relative flex justify-between items-center w-full rounded-full">
        <div class="logo_details">
            <div class="logo_name">Mikrotik</div>
        </div>
        <div class="user-options flex items-center space-x-4 pr-6">
                <a href="/api/mikrotik/users">
                    <i class="fa-solid fa-user-plus"></i>
                    <span class="link_name">Usuarios</span>
                </a>
                <a href="/api/mikrotik/ipaddress">
                    <i class="fa-solid fa-ethernet"></i>
                    <span class="link_name">Direccion IP</span>
                </a>
                <a href="/api/mikrotik/bandwidth">
                    <i class="fa-solid fa-server"></i>
                    <span class="link_name">Bandwidth</span>
                </a>
        </div>
    </header>

    <section class="home-section">
        <main>
            @if ($action === 'list')
                <div class="presentacion">
                    <div class="presContent">
                        <p>Bienvenido usuario: {{ $userName ? $userName : 'Undefined' }}</p>
                        <p>Este es el centro de control de su router Mikrotik</p>
                        <p>Funciones disponibles: Creacion y eliminacion de usaurios, Creacion y eliminacion de direcciones IP y Creacion y eliminacion de configuracion de ancho de banda</p>
                    </div>
                </div>
             
                    <button class="centered-button" onclick="window.location.href='{{ route('mikrotik.' . $entity . '.create') }}'">Añadir nuevo</button>
               
                @isset($datas)
                    <div class="container">
                        @foreach ($datas as $data)
                            <div class="content">
                                <div>
                                    @foreach ($data as $key => $value)
                                        <p>{{ $key }}: {{ $value != '' ? $value : 'undefined' }}</p>
                                    @endforeach
                                    <form action="{{ route('mikrotik.' . $entity . '.delete', $data['.id']) }}" method="GET"><button type="submit">Eliminar</button></form>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @endisset
   
            @elseif ($action === 'create')
                <div class="area">
                    <form action="{{ route('mikrotik.' . $entity . '.add') }}" method="POST">
                        @csrf
                        @foreach ($fields as $field_type => $field_list)
                            @if ($field_type === 'write_fields')
                                @foreach ($field_list as $field)
                                    <label>{{ $field }}: </label>
                                    <input name={{ $field }}>
                                @endforeach
                            @endif
                            @if ($field_type === 'option_fields')
                                @foreach ($field_list as $field)
                                    @foreach ($relations as $relation_type => $relation_value)
                                        @if ($relation_type === $field)
                                            @php
                                                $current_relation = [$relation_type => $relation_value];
                                                $specific_relation = $current_relation[$field];
                                            @endphp
                                        @endif
                                    @endforeach
                                    <label>{{ $field }}: </label>
                                    <select name={{ $field }}>
                                        @foreach ($specific_relation as $rel)
                                            <option value={{ $rel['name'] }}>{{ $rel['name'] }}</option>
                                        @endforeach
                                    </select>
                                @endforeach
                            @endif
                            @if ($field_type === 'boolean_fields')
                                @foreach ($field_list as $field)
                                    <label>{{ $field }}: </label>
                                    <select name={{ $field }}>
                                        <option value=false>false</option>
                                        <option value=true>true</option>
                                    </select>
                                @endforeach
                            @endif
                        @endforeach
                        <button type="submit"> Crear</button>
                    </form>
                </div>
            @endif
        </main>
    </section>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const fromSelect = document.getElementById('from_id');
            const toSelect = document.getElementById('to_id');

            function checkSelection() {
                if (fromSelect.value === toSelect.value) {
                    toSelect.selectedIndex = 0; // Cambia al primer elemento
                }
            }
            fromSelect.addEventListener('change', checkSelection);
            toSelect.addEventListener('change', checkSelection);
        });
    </script>
    </section>
    <!-- Scripts -->
    <script>
        window.onload = function() {
            const sidebar = document.querySelector(".sidebar");
            const closeBtn = document.querySelector("#btn");
            const searchBtn = document.querySelector(".bx-search")

            closeBtn.addEventListener("click", function() {
                sidebar.classList.toggle("open")
                menuBtnChange()
            })

            searchBtn.addEventListener("click", function() {
                sidebar.classList.toggle("open")
                menuBtnChange()
            })

            function menuBtnChange() {
                if (sidebar.classList.contains("open")) {
                    closeBtn.classList.replace("bx-menu", "bx-menu-alt-right")
                } else {
                    closeBtn.classList.replace("bx-menu-alt-right", "bx-menu")
                }
            }
        }
    </script>
</body>

</html>
