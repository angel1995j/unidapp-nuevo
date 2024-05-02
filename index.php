<?php require "header.php";?> 
<?php require "global.php";?> 

    <!-- End Navbar -->
    
    <div class="container-fluid py-4">
      

    <div class="row mt-2">

        <div class="col-12">
        <h3 class="text-center mt-3 text-white">¡Hola compañerx bienvenido a tu nuevo a tu panel de administración!</h3><br>


        <!-- CARDS DEL INICIO -->



        <div class="row mt-2">
        <div class="col-xl-3 col-sm-6 mb-xl-0 mb-4">
          <div class="card">
            <div class="card-body p-3">
              <div class="row">
                <div class="col-7">
                  <div class="numbers">
                    <h5 class="text-sm mb-0 text-uppercase font-weight-bold">ir a la sección de Afiliaciones Totales</h5>
                  </div>
                </div>
                <div class="col-5 text-end">
                  <a href="afiliaciones.php" class="btn btn-primary">IR</a>
                </div>
              </div>
            </div>
          </div>
        </div>


        <div class="col-xl-3 col-sm-6 mb-xl-0 mb-4">
          <div class="card">
            <div class="card-body p-3">
              <div class="row">
                <div class="col-7">
                  <div class="numbers">
                    <h5 class="text-sm mb-0 text-uppercase font-weight-bold">Gestionar Usuarios registrados en la app</h5>
                  </div>
                </div>
                <div class="col-5 text-end">
                  <a href="usuarios.php" class="btn btn-primary">IR</a>
                </div>
              </div>
            </div>
          </div>
        </div>

       
        <div class="col-xl-3 col-sm-6 mb-xl-0 mb-4">
          <div class="card">
            <div class="card-body p-3">
              <div class="row">
                <div class="col-7">
                  <div class="numbers">
                    <h5 class="text-sm mb-0 text-uppercase font-weight-bold">Revisar y responder Asesorías juridicas</h5>
                  </div>
                </div>
                <div class="col-5 text-end">
                  <a href="conversaciones.php" class="btn btn-primary">IR</a>
                </div>
              </div>
            </div>
          </div>
        </div>



        <div class="col-xl-3 col-sm-6 mb-xl-0 mb-4">
          <div class="card">
            <div class="card-body p-3">
              <div class="row">
                <div class="col-7">
                  <div class="numbers">
                    <h5 class="text-sm mb-0 text-uppercase font-weight-bold">gestionar los Contenidos de formación</h5>
                  </div>
                </div>
                <div class="col-5 text-end">
                  <a href="contenidos.php" class="btn btn-primary">IR</a>
                </div>
              </div>
            </div>
          </div>
        </div>


          </div>

    



        <!-- FIN DE CARDS DEL INICIO -->
      
    
        </div>

        <div class="col-lg-7 mb-lg-0 mb-4 mt-5">
          <div class="card z-index-2 h-100">
            <div class="card-header pb-0 pt-3 bg-transparent">
              <h6 class="text-capitalize">Últimas asesorías</h6>
            </div>
            <div class="card-body p-3">
               <!-- Aquí va la lista de los últimos 10 registros -->
               <ul>
                   <?php
                   try {
                       $collection = $database->asesorias; 
                       $pipeline = [
                           ['$sort' => ['_id' => -1]],
                           ['$limit' => 7]
                       ];
                       $documents = $collection->aggregate($pipeline);
                       
                       foreach ($documents as $document) {
                        echo "<li style='border-bottom: 1px solid #dbdbdb;list-style: none;margin-bottom: 2%;padding-bottom: 2%;'>Usuario: " . $document['usuario'] . " - Descripción: " . substr($document['descripcion'], 0, 50) . " <a href='conversacion.php?usuario=" . $document['_id'] . "' class=''>Ver</a></li>";
                       }
                   } catch (Exception $e) {
                       echo "Error: " . $e->getMessage();
                   }
                   ?>
               </ul>
            </div>
          </div>
        </div>
        <div class="col-lg-5">


        <div class="card z-index-2 h-100 mt-5">
            <div class="card-header pb-0 pt-3 bg-transparent">
              <h6 class="text-capitalize">¿Cómo utilizar tu panel de administración?</h6>
            </div>
            <div class="card-body p-3">
            <iframe width="100%" height="315" src="https://www.youtube.com/embed/TOi8pj1pyJk?si=Ix95BWtiIutbiHK_" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" referrerpolicy="strict-origin-when-cross-origin" allowfullscreen></iframe>
            </div>
          </div>

      </div>




    </div>
     
 

<!-- SECCION GENERAL -->

  <?php require "footer.php";?>
