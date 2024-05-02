<?php require "header.php";?> 
<?php require "global.php";?> 

    <!-- End Navbar -->
    
    <div class="container-fluid py-4">
      

    <div class="row mt-2">

        <div class="col-12">
        <h3 class="text-center mt-3 text-white">Selecciona el reporte que deseas exportar en excel</h3>


        <!-- CARDS DEL INICIO -->



        <div class="row mt-5 mb-5">
        <div class="col-xl-4 col-sm-6 mb-xl-0 mb-4">
          <div class="card">
            <div class="card-body p-3">
              <div class="row">
                <div class="col-7">
                  <div class="numbers">
                    <h5 class="font-weight-bolder">
                      Afiliaciones
                    </h5>
                  </div>
                </div>
                <div class="col-5 text-end">
                  <a href="exportar-afiliaciones.php" class="btn btn-primary">IR</a>
                </div>
              </div>
            </div>
          </div>
        </div>


        <div class="col-xl-4 col-sm-6 mb-xl-0 mb-5">
          <div class="card">
            <div class="card-body p-3">
              <div class="row">
                <div class="col-7">
                  <div class="numbers">
           
                    <h5 class="font-weight-bolder">
                    Usuarios
                    </h5>
                  </div>
                </div>
                <div class="col-5 text-end">
                  <a href="exportar-usuarios.php" class="btn btn-primary">IR</a>
                </div>
              </div>
            </div>
          </div>
        </div>

       
        



        <div class="col-xl-4 col-sm-6 mb-xl-0 mb-4">
          <div class="card">
            <div class="card-body p-3">
              <div class="row">
                <div class="col-7">
                  <div class="numbers">
                  
                    <h5 class="font-weight-bolder">
                    Asesorias
                    </h5>
                  </div>
                </div>
                <div class="col-5 text-end">
                  <a href="exportar-asesorias.php" class="btn btn-primary">IR</a>
                </div>
              </div>
            </div>
          </div>
        </div>


          </div>

    



        <!-- FIN DE CARDS DEL INICIO -->
      
    
        </div>

    
       




    </div>
     
 

<!-- SECCION GENERAL -->

  <?php require "footer.php";?>
