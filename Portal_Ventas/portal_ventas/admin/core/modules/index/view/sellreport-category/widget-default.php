
        <!-- Main Content -->

          <div class="row">
          <div class="col-md-12">
          <h1>Reporte de Venta de Productos </h1>
          </div>
          <hr>
          </div>

<input type="hidden" name="view" value="sellreport">
          <div class="row">
            
            <div class="col-lg-3">
            <label for="inputState">Nombre de Producto: </label>
            <input placeholder="Escriba el nombre del producto" type="text" name="nameproduct" id="nameproduct" class="form-control">
            </div>
            <div class="col-md-2">
              <label for="inputState">Categoría: </label>

              <?php
                $categories = CategoryData::getAll();
                 if(count($categories)>0):
              ?>
                <select name="category_id" id="category_id" class="form-control" required>
                <!--
                  <option value="n">-- SELECCIONE CATEGORIA --</option>
                -->
                
                  <?php foreach($categories as $cat):?>
                  <option value="<?php echo $cat->id; ?>"><?php echo $cat->name; ?></option>
                  <?php endforeach; ?>
                </select>
                  <?php endif; ?>
              
            </div>
            <div class="col-md-2">
              <label for="inputState">Proveedor: </label>
              <?php
                $providers = ProviderData::getAll();
                if(count($providers)>0):
              ?>
                <select name="provider_id" id="provider_id" class="form-control" required>
                <!--
                    <option value="n">-- SELECCIONE PROVEEDOR --</option>
                -->
                
                  <?php foreach($providers as $cat):?>
                    <option value="<?php echo $cat->id; ?>"><?php echo $cat->nombre; ?></option>
                  <?php endforeach; ?>
                </select>
              <?php endif; ?>
            </div>
            </div>
           
<br>

          <div class="row">
            <div class="col-lg-12">
              <div class="panel panel-default">
                <div class="panel-heading">
                  <i class="fa fa-tasks"></i> Reporte de Productos Vendidos
                </div>
                <div class="widget-body medium no-padding">

                  <div class="table-responsive" id="result">
                      <!--Resultado de la tabla-->
                  </div>
                </div>
              </div>
            </div>

          </div>

  

  <script>
		/*1. script de llenado de tabla con id=result */	
		$(document).ready(function () {
          var category_id = document.getElementById("category_id").value;
          var provider_id = document.getElementById("provider_id").value;
			//obteniendo los datos de bd
			function obtener_datos(consulta){
				$.ajax({
					//type: "method",
					url: "load_report_products.php",
					method: "POST",
					data: {consulta: consulta, category_id: category_id, provider_id: provider_id},
					//dataType: "dataType",
					success: function (data) {
						$("#result").html(data)
					},

// código a ejecutar si la petición falla;
// son pasados como argumentos a la función
// el objeto de la petición en crudo y código de estatus de la petición
error : function(xhr, status) {
    alert('Disculpe, existió un problema');
}
				})

			}
			obtener_datos();


            /*2. filtar busqueda por campo ingresado */
			$(document).on("keyup","#nameproduct", function () {
			//obteniendo el valor que se puso en campo identifier
			var valor = $(this).val();
        	//condición de campo no vacio
        	if (valor!= "") {
                obtener_datos(valor); //busqueda en base al valor
        	} else {
				obtener_datos(); //desplegar todo
			}

			})

		});

	</script>
