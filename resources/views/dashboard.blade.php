<!DOCTYPE html>
<html lang="en">
<head>
	<!-- Required meta tags -->
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <!-- CSRF Token -->
  <meta name="csrf-token" content="{{ csrf_token() }}">

  <!-- FontAwesome v5 -->
  <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.8.1/css/all.css" integrity="sha384-50oBUHEmvpQ+1lW4y57PTFmhCaXp0ML5d60M1M7uH2+nqUivzIebhndOJK28anvf" crossorigin="anonymous">
  <!-- Bootstrap CSS v4.0 -->
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">

	<title>La Vendimia</title>

  <style type="text/css">
    h6{
      color: #28a745;
    }
  </style>
</head>

<body>
<div id="app">
  <nav class="navbar navbar-expand-sm bg-dark navbar-dark">
    <div class="collapse navbar-collapse" id="navbarSupportedContent">
      <ul class="navbar-nav mr-auto">
        <li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
            Inicio
          </a>
          <div class="dropdown-menu" aria-labelledby="navbarDropdown">
            <router-link to="/venta_index" class="dropdown-item">Ventas</router-link>
            <div class="dropdown-divider"></div>
            <router-link to="/cliente_index" class="dropdown-item">Clientes</router-link>
            <router-link to="/articulo_index" class="dropdown-item">Articulos</router-link>
            <router-link to="/configuracion_index" class="dropdown-item">Configuracion</router-link>
          </div>
        </li>
      </ul>
      <form class="form-inline my-2 my-lg-0">
        <h6 id="fecha" style="color: rgba(255,255,255,.5);"></h6>
      </form>
    </div>
  </nav>

  <transition name="fade">
    <router-view></router-view>
  </transition>
</div>

<!-- Complementos de JavaScript -->
<!--  jQuery 3.2.1  -->
<script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
<!-- VueJS -->
<script src="js/app.js"></script>
<!--  Popper JS  -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
<!-- Bootstrap JS -->
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
<!-- sweetalert -->
<script src="{{asset('js/sweetalert2.all.js')}}"></script>

<script>
  var fechaActual = function(){
    var fecha = new Date();
    dia = fecha.getDate();
    mes = fecha.getMonth().toString().padStart(2, "0");
    year = fecha.getFullYear();

    var pFecha = "Fecha: " + dia + "/" + mes + "/" + year;
    document.getElementById("fecha").innerHTML = pFecha;
    // console.log(pFecha);
  };

  fechaActual();

  function justNumbers(e)
  {
    var keynum = window.event ? window.event.keyCode : e.which;
    if ((keynum == 8) || (keynum == 46))
    return true;
     
    return /\d/.test(String.fromCharCode(keynum));
  }

  function soloLetras(e){
    key = e.keyCode || e.which;
    tecla = String.fromCharCode(key).toLowerCase();
    letras = " áéíóúabcdefghijklmnñopqrstuvwxyz";
    especiales = "8-37-39-46";

    tecla_especial = false
    for(var i in especiales){
      if(key == especiales[i]){
        tecla_especial = true;
        break;
      }
    }

    if(letras.indexOf(tecla)==-1 && !tecla_especial){
      return false;
    }
  }
</script>
</body>
</html>