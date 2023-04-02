<?php require_once __DIR__ . "/../../src/Utils/verifylogin.php"; ?>
<?php include "../base/header.html" ?>
<title>Cliente</title>
</head>

<body class="bg-custom">
  <div id="navigation">
    <nav class="sb-topnav navbar navbar-expand navbar-dark bg-custom-blue">
      <a class="navbar-brand ps-3" href="#">Proimpo</a>
      <div class="ms-auto"></div>
      <ul class="navbar-nav ms-md-0 me-3 me-lg-4">
        <li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle" id="navbarDropdown" href="#" role="button" data-bs-toggle="dropdown"
            aria-expanded="false"><i class="fas fa-user fa-fw"></i></a>
          <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
            <li><a class="dropdown-item" href="../../src/Utils/logout.php">Salir</a></li>
          </ul>
        </li>
      </ul>
    </nav>
  </div>
  <div id="content">
    <div class="container-fluid">
      <div class="row mt-3">
        <div class="col-md-4 offset-4">
          <div class="d-grid mx-auto">
            <button onclick="openModal(1)" class="btn btn-secondary" data-bs-toggle="modal" data-bs-target="#modalFiles">
              <i class="fa-solid fa-circle-plus"></i> Añadir
            </button>
          </div>
        </div>
      </div>
      <div class="row mt-3">
        <div class="col-12 col-lg-12 offset-0 offset-lg-12">
          <div class="table-responsive">
            <table class="table  display cell-border" id="tabla_vendedor" cellspacing="0" width="100%">
              <thead class="table-light">
                <tr>
                  <th>Nombre Vendedor</th>
                  <th>Cargo</th>
                  <th>Fecha de inicio en el cargo</th>
                  <th>Ventas</th>
                  <th>Clientes Nuevos</th>
                  <th>Observacion</th>
                  <th>Comision</th>
                  <th></th>
                </tr>
              </thead>
              <tbody class="table-group-divider">
              </tbody>
              <tfoot align="right">
                <tr><th></th><th></th><th></th><th></th><th></th><th></th><th></th><th></th></tr>
              </tfoot>
            </table>
          </div>
        </div>
      </div>
      <div class="row mt-3">
        <div class="col-md-4 offset-4">
          <div class="d-grid mx-auto">
            <button onclick="calcComision()" class="btn btn-success">
              <i class="fa-solid fa-calculator"></i> Calcular comisiones
            </button>
          </div>
          <div>
            <span class="badge bg-secondary">Comisión = (Ventas del mes * Tasa de comisión) + (Clientes nuevos * valor comisión por cliente)</span>
          </div>
        </div>
      </div>
    </div>
    <div id="modalFiles" class="modal fade" aria-hidden="true">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <label class="h5" id="title"></label>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
          <div class="modal-body">
            <form id="form">
              <input type="hidden" name="id" id="id">
              <div class="mb-3 col-md-12">
                <label class="form-label">Nombre del vendedor<small class="text-danger">*</small></label>
                <div class="input-group mb-3">
                  <span class="input-group-text">
                    <i class="fa-solid fa-user"></i>
                  </span>
                  <input type="text" class="form-control" name="nombre" id="name">
                </div>
              </div>
              <div class="mb-3 col-md-12">
                <label class="form-label">Cargo<small class="text-danger">*</small></label>
                <select class="form-select" name="cargo" id="charge">
                  <option disabled selected>Selecciona una opcion</option>
                  <option>Representante de ventas</option>
                  <option>Vendedor técnico</option>
                  <option>Vendedor de soluciones</option>
                  <option>Asesor comercial</option>
                </select>
              </div>
              <div class="mb-3 col-md-12">
                <label class="form-label">Fecha de inicio en el cargo<small class="text-danger">*</small></label>
                <div class="input-group mb-3">
                  <span class="input-group-text">
                    <i class="fa-solid fa-calendar"></i>
                  </span>
                  <input type="date" class="form-control" name="inicio_cargo" id="startdate">
                </div>
              </div>
              <div class="mb-3 col-md-12">
                <label class="form-label">Ventas<small class="text-danger">*</small></label>
                <div class="input-group mb-3">
                  <span class="input-group-text">
                    <i class="fa-solid fa-dollar-sign"></i>
                  </span>
                  <input type="number" min="0" pattern="[0-9]+" class="form-control" name="ventas" id="currentsales">
                </div>
              </div>
              <div class="mb-3 col-md-12">
                <label class="form-label">Clientes nuevos<small class="text-danger">*</small></label>
                <div class="input-group mb-3">
                  <span class="input-group-text">
                    <i class="fa-solid fa-hashtag"></i>
                  </span>
                  <input type="number" min="0" max="999" pattern="[0-9]+" class="form-control" name="clientes_nuevos" id="newclients">
                </div>
              </div>
              <div class="mb-3 col-md-12">
                <label class="form-label">Observaciones</label>
                <div class="input-group">
                  <span class="input-group-text">
                    <i class="fa-solid fa-comment"></i>
                  </span>
                  <textarea class="form-control" name="observacion" id="observation"></textarea>
                </div>
              </div>
            </form>
          </div>
          <div class="modal-footer">
            <button type="button" id="btnCerrar" class="btn btn-secondary" data-bs-dismiss="modal">
              Cerrar
            </button>
            <button onclick="validate()" class="btn btn-success">
              <i class="fa-solid fa-floppy-disk"></i> Guardar
            </button>
          </div>
        </div>
      </div>
    </div>
  </div>

  <script src="../../public/js/functions.js"></script>
<?php include "../base/footer.html" ?>