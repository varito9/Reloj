<?php

$title = 'Inicio';
require 'utils/header.php';
?>

<main class="container my-5 ancho">
  <?php if(isset($_SESSION['usuario'])): ?>
    <div class="alert alert-success">
      Bienvenido, <?php echo htmlspecialchars($_SESSION['usuario']); ?>
    </div>
  <?php endif; ?>

  <div class="text-center mb-4">
    <h2 class="fw-600">Excelencia en relojería y joyería de lujo</h2>
    <p class="text-muted">
      Somos una relojería especializada en relojes de alta gama, joyería exclusiva y servicios técnicos de primera calidad. Nuestro compromiso es ofrecer piezas únicas y un trato personalizado a cada cliente.
    </p>
  </div>


  <div class="row">
    <div class="col-md-4">
      <div class="card mb-3">
        <img src="https://www.watch-test.com/wp-content/uploads/2024/04/Duometre-Chronograph-Moon-platinum.jpg"  class="card-img-top" alt="Noticia 1">
        <div class="card-body">
          <h5 class="card-title">Relojes de lujo</h5>
          <p class="card-text">Descubre nuestra exclusiva colección.</p>
        </div>
      </div>
    </div>

    <div class="col-md-4">
      <div class="card mb-3">
        <img src="https://miguelmunozjoyeros.com/wp-content/uploads/2023/09/jaeger-lecoultre-calibre101-secrets-q2872201-open-levitation-16-9.jpg" class="card-img-top" alt="Joyería fina">
        <div class="card-body">
          <h5 class="card-title">Joyería fina</h5>
          <p class="card-text">
            <?php if(isset($_SESSION['usuario'])): ?>
              Bienvenido a la zona privada de joyería.
            <?php else: ?>
              Piezas únicas para ocasiones especiales.
            <?php endif; ?>
          </p>
        </div>
      </div>
    </div>

    <div class="col-md-4">
      <div class="card mb-3">
        <img src="https://cdn.shopify.com/s/files/1/0342/5311/1432/files/W_W_Jaeger_1e61cccb-0a2f-483c-9387-e2a1c22e7b74.png?v=1744638325" class="card-img-top" alt="Servicio técnico">
        <div class="card-body">
          <h5 class="card-title">
            <?php echo isset($_SESSION['usuario']) ? 'Novedades y Servicio' : 'Servicio técnico'; ?>
          </h5>
          <p class="card-text">
            <?php echo isset($_SESSION['usuario']) ? 'Novedades en relojería y mantenimiento premium.' : 'Expertos en reparación y mantenimiento.'; ?>
          </p>
        </div>
      </div>
    </div>
  </div>
</main>

<?php require 'utils/footer.php'; ?>