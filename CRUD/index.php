<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Sistema de Gestión de Usuarios</title>

  <!-- Bootstrap -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">

  <!-- CSS -->
  <link rel="stylesheet" href="style.css">
</head>
<body>

<!-- NavBar -->
<nav class="navbar navbar-expand-lg navbar-dark bg-dark bg-opacity-75 fixed-top shadow-sm">
  <div class="container">
    <a class="navbar-brand fw-bold text-info" href="#"><i class="bi bi-person-gear"></i> Gestión PRO</a>
    <button class="navbar-toggler" data-bs-toggle="collapse" data-bs-target="#menu">
      <span class="navbar-toggler-icon"></span>
    </button>

    
    <div class="collapse navbar-collapse justify-content-end" id="menu">
      <ul class="navbar-nav">
        <li class="nav-item"><a class="nav-link active" href="#">Inicio</a></li>
        <li class="nav-item"><a class="nav-link" href="#">Contacto</a></li>
        <li class="nav-item"><a class="nav-link" href="#">Ayuda</a></li>
      </ul>
    </div>
  </div>
</nav>

<!-- Hero Section -->
<section class="hero">
  <div class="overlay"></div>
  <div class="hero-content text-center">
    <h1 class="display-3 fw-bold text-white mb-3 title">Gestiona. Optimiza. Evoluciona.</h1>
    <p class="lead text-white-50 mb-4">La plataforma inteligente para administrar usuarios con innovación real.</p>
    
    <a href="login.php" class="btn btn-lg btn-info px-5 py-3 fw-semibold shadow-lg">
      <i class="bi bi-people-fill me-2"></i> Iniciar Sesión
    </a>

    <!-- Contador -->
    <div class="counter-box mt-5">
      <h2 class="text-white mb-1"><span id="counter">0</span>+</h2>
      <p class="text-white-50">Usuarios registrados</p>
    </div>
  </div>
</section>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

<!-- Script Contador Animado -->
<script>
let contador = document.getElementById("counter");
let inicio = 0;
let final = 150; // Cambia el número final si lo deseas
let tiempo = 20; // Velocidad

let intervalo = setInterval(() => {
  inicio++;
  contador.textContent = inicio;
  if(inicio >= final){
    clearInterval(intervalo);
  }
}, tiempo);
</script>
</body>
</html>
