  <!-- Main Sidebar Container -->
  <aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <!-- <a href="../index.php" class="brand-link"> -->
      <!-- <img src="../dist/img/AdminLTELogo.png"
           alt="AdminLTE Logo"
           class="brand-image img-circle elevation-3"
           style="opacity: .8"> -->
      <!-- <span class="brand-text font-weight-light"> -->
      

    <!-- Sidebar -->
    <div class="sidebar">
      <!-- Sidebar user (optional) -->
      <div class="user-panel mt-3 pb-3 mb-3 d-flex">
        <!-- <div class="image"> -->
          <!-- <img src="../dist/img/user2-160x160.jpg" class="img-circle elevation-2" alt="User Image"> -->
          <!-- <i class="fas fa-male"></i> -->
        <!-- </div> -->
        <div class="info text-white">
          <!-- <a href="#" class="d-block"> -->
          <i class="fas fa-male"></i> 
          <?php
            // session_start();
          echo $_SESSION['userName'];
          ?>
          </a>
        </div>
      </div>

      <!-- Sidebar Menu -->
      <nav class="mt-2">
        <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
          <!-- Add icons to the links using the .nav-icon class
               with font-awesome or any other icon font library -->
          
          
              <li class="nav-item has-treeview">

            <a href="../index.php" class="nav-link">
            <!-- <i class="fas fa-money-bill-wave"></i> -->
            <i class="fas fa-cash-register"></i>
            <!-- <i class="nav-icon fas fa-edit"></i> -->
              <p>
                Caja
                <!-- <i class="right fas fa-angle-left"></i> -->
              </p>
            </a>
            </li>

            <li class="nav-item has-treeview">

<a href="../usuario-corte/index.php" class="nav-link">
<!-- <i class="fas fa-money-bill-wave"></i> -->
<i class="fas fa-cut"></i>
<!-- <i class="nav-icon fas fa-edit"></i> -->
  <p>
    Corte
    <!-- <i class="right fas fa-angle-left"></i> -->
  </p>
</a>
</li>
          
          
          <li class="nav-item has-treeview">
            <a href="#" class="nav-link">
            <i class="fas fa-redo"></i>
            <!-- <i class="nav-icon fas fa-edit"></i> -->
              <p>
                Devoluciones
                <i class="right fas fa-angle-left"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
            <?php
            // session_start();
            if($_SESSION['nivel']===1){ 
            // echo $_SESSION['userName'];s
          ?>
              <li class="nav-item">
                <a href="../administrador-devoluciones/index.php" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Consultar</p>
                </a>
              </li>
              <?php
            }
          ?>

              <li class="nav-item">
                <a href="../usuario-devolucion/index.php" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Hacer una devolución</p>
                </a>
              </li>
            </ul>
          </li>
         
          <li class="nav-item has-treeview">
            <a href="#" class="nav-link">
            <i class="fas fa-cube"></i>
              <p>
                Productos
                <i class="fas fa-angle-left right"></i>
                <!-- <span class="badge badge-info right">6</span> -->
              </p>
            </a>
            <ul class="nav nav-treeview">
            
            <?php
            if($_SESSION['nivel']===1){ 
              
          // echo $_SESSION['userName'];
          ?>
            <li class="nav-item">
                <a href="../producto-registrar/index.php" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Nuevo producto</p>
                </a>
              </li>
            
              <li class="nav-item">
                <a href="../producto-surtir/index.php" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Agregar producto</p>
                </a>
              </li>

              <li class="nav-item">
                <a href="../producto-agregar/index.php" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Surtir sucursal</p>
                </a>
              </li>
              <?php
            }
          ?>
              <li class="nav-item">
                <a href="../usuario-consulta/index.php" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Consultar producto</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="../usuario-baja/index.php" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Dar de baja producto</p>
                </a>
              </li>
            </ul>
          </li>


          <li class="nav-item has-treeview">
            <a href="#" class="nav-link">
            <i class="fas fa-store-alt"></i>
              <p>
                Sucursales
                <i class="fas fa-angle-left right"></i>
                <!-- <span class="badge badge-info right">6</span> -->
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="../usuario-sucursales/index.php" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Consultar existencia</p>
                </a>
              </li>
            </ul>
          </li>

          <?php
            if($_SESSION['nivel']===1){ 
              
          // echo $_SESSION['userName'];
          ?>
          <li class="nav-item has-treeview">
            <a href="#" class="nav-link">
            <i class="fas fa-user-friends"></i>
              <p>
                Usuarios
                <i class="fas fa-angle-left right"></i>
                <!-- <span class="badge badge-info right">6</span> -->
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="../administrador-todosUsuarios/index.php" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Consultar</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="../administrador-usuarios/index.php" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Agregar Usuario</p>
                </a>
              </li>
            </ul>

          </li>

          <li class="nav-item has-treeview">
            <a href="#" class="nav-link">
            <i class="fas fa-shopping-basket"></i>
              <p>
                Ventas
                <i class="fas fa-angle-left right"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="../administrador-ventas/index.php" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Consultar</p>
                </a>
              </li>
            </ul>
          </li>

          <li class="nav-item has-treeview">
            <a href="#" class="nav-link">
            <i class="fas fa-user-shield"></i>
              <p>
                Administrador
                <i class="fas fa-angle-left right"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="../administrador-principal/index.php" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>General</p>
                </a>
              </li>
            </ul>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="../imprimirCodigos/index.php" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Descargar Códigos de barra</p>
                </a>
              </li>
            </ul>
          </li>

         

          <?php
            }
          ?>

<li class="nav-item has-treeview">

<a href="../salir.php" class="nav-link">
<!-- <i class="fas fa-money-bill-wave"></i> -->
<i class="fas fa-sign-out-alt"></i>
<!-- <i class="nav-icon fas fa-edit"></i> -->
  <p>
    Salir
    <!-- <i class="right fas fa-angle-left"></i> -->
  </p>
</a>
</li>
          
         
        </ul>
      </nav>
      <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
  </aside>