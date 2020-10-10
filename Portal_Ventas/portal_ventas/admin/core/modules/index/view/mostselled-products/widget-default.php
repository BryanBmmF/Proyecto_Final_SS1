<?php
$con = Database::getCon();
$sql = "SELECT SUM(t1.q) AS cantidad, t2.name AS nombre, t2.description AS descripcion, t2.price AS precio_individual,SUM(t1.q)*t2.price AS ingreso FROM buy_product AS t1 
JOIN product AS t2 ON t1.product_id=t2.id 
JOIN buy AS t3 ON t1.buy_id=t3.id
WHERE t3.status_id!=3 AND t2.user_id=".$_SESSION["admin_id"]." group by t2.name,t2.price,t2.description ORDER BY cantidad DESC";
$result =$con->query($sql);
$row_cnt = $result->num_rows;
?>
        <!-- Main Content -->

          <div class="row">
          <div class="col-md-12">
          <h1>Productos mas vendidos</h1>
          </div>
          </div>

          <div class="row">
            <div class="col-lg-12">
              <div class="panel panel-default">
                <div class="panel-heading">
                  <i class="fa fa-tasks"></i> Productos mas vendidos
                </div>
                <div class="widget-body medium no-padding">

                  <div class="table-responsive">
<?php if($row_cnt>0):?>

  <table class="table table-bordered">
    <thead>
        <th>Elementos comprados</th>
        <th>Nombre</th>
        <th>Descripcion</th>
        <th>Precio Individual en Q</th>
        <th>Ingreso total en Q</th>
    </thead>
      <?php
      		while($row = $result->fetch_array(MYSQLI_ASSOC)) {
            echo "<tr>";
            echo "<td>".$row['cantidad']."</td>";
            echo "<td>".$row['nombre']."</td>";
            echo "<td>".$row['descripcion']."</td>";
            echo "<td>".$row['precio_individual']."</td>";
            echo "<td>".$row['ingreso']."</td>";
            echo "</tr>";  

          }
      ?>
    
    </table>
<?php else:?>
  <div class="panel-body">
  <h1>Sin productos vendidos</h1>
  </div>
<?php endif; ?>
                  </div>
                </div>
              </div>
            </div>

          </div>
