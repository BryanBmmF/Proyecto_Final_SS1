        <!-- Main Content -->

          <div class="row">
            <div class="col-md-12">
                  <a  data-toggle="modal" href="#myModal" class="pull-right btn-sm btn btn-default">Agregar Proveedor</a>
  <!-- Button trigger modal -->

  <!-- Modal -->
  <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
          <h4 class="modal-title">Agregar Proveedor</h4>
        </div>
        <div class="modal-body">
<form class="form-horizontal" role="form" method="post" action="index.php?action=addprovider">
  <div class="form-group">
    <label for="inputEmail1" class="col-lg-2 control-label">Nombre</label>
    <div class="col-lg-10">
      <input type="text" required class="form-control" name="name" placeholder="Nombre del Proveedor">
    </div>
  </div>
  <div class="form-group">
    <label for="inputEmail1" class="col-lg-2 control-label">Direccion</label>
    <div class="col-lg-10">
      <input type="text" required class="form-control" name="address" placeholder="Dirección">
    </div>
  </div>
  <div class="form-group">
    <label for="inputEmail1" class="col-lg-2 control-label">Número de Teléfono</label>
    <div class="col-lg-10">
      <input type="text" required class="form-control" name="phone" placeholder="Número de Teléfono">
    </div>
  </div>
  <div class="form-group">
    <div class="col-lg-offset-2 col-lg-10">
      <div class="checkbox">
        <label>
          <input type="checkbox" name="is_active"> Proveedor Activo
        </label>
      </div>
    </div>
  </div>

  <div class="form-group">
    <div class="col-lg-offset-2 col-lg-10">
      <button type="submit" class="btn btn-block btn-primary">Agregar Proveedor</button>
    </div>
  </div>
</form>
        </div>
      </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
  </div><!-- /.modal -->
            <h1>Proveedores</h1>
            </div>
            </div>

          <div class="row">
            <div class="col-md-12">
              <div class="panel panel-default">
                <div class="panel-heading">
                  <i class="fa fa-th-list"></i> Proveedores
                </div>
                <div class="widget-body medium no-padding">
<?php
$providers = ProviderData::getAll();
 if(count($providers)>0):?>
                  <div class="table-responsive">
                    <table class="table table-bordered">
                    <thead>
                      <th>Nombre</th>
                      <th>Activo</th>
                      <th></th>
                    </thead>
                      <tbody>

<?php foreach($providers as $cat):?>
                        <tr>

                        <td><?php echo $cat->nombre; ?>
                        <td style="width:70px;"><?php if($cat->is_active):?><center><i class="fa fa-check"></i></center><?php endif;?></td>




                        </td>
                        <td style="width:90px;">
                        <a data-toggle="modal" href="#myModal-<?php echo $cat->id;?>" class="btn btn-warning btn-xs"><i class="fa fa-edit"></i></a>
  <!-- Button trigger modal -->

  <!-- Modal -->
  <div class="modal fade" id="myModal-<?php echo $cat->id;?>" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
          <h4 class="modal-title">Editar Proveedor</h4>
        </div>
        <div class="modal-body">
<form class="form-horizontal" role="form" method="post" action="index.php?action=updateprovider">
  <div class="form-group">
    <label for="inputEmail1" class="col-lg-2 control-label">Nombre</label>
    <div class="col-lg-10">
      <input type="text" required class="form-control" name="name" value="<?php echo $cat->nombre;?>" placeholder="Nombre del Proveedor">
    </div>
  </div>
  <div class="form-group">
    <label for="inputEmail1" class="col-lg-2 control-label">Direccion</label>
    <div class="col-lg-10">
      <input type="text" required class="form-control" value="<?php echo $cat->direccion; ?>" name="address" placeholder="Dirección">
    </div>
  </div>
  <div class="form-group">
    <label for="inputEmail1" class="col-lg-2 control-label">Número de Teléfono</label>
    <div class="col-lg-10">
      <input type="text" required class="form-control" value="<?php echo $cat->telefono; ?>" name="phone" placeholder="Teléfono">
    </div>
  </div>
  <div class="form-group">
    <div class="col-lg-offset-2 col-lg-10">
      <div class="checkbox">
        <label>
          <input type="checkbox" name="is_active" <?php if($cat->is_active){ echo "checked"; }?>> Proveedor Activo
        </label>
      </div>
    </div>
  </div>

  <div class="form-group">
    <div class="col-lg-offset-2 col-lg-10">
    <input type="hidden" name="provider_id" value="<?php echo $cat->id; ?>">
      <button type="submit" class="btn btn-block btn-success">Actualizar Proveedor</button>
    </div>
  </div>
</form>
        </div>
      </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
  </div><!-- /.modal -->

                        <a href="index.php?action=delprovider&provider_id=<?php echo $cat->id; ?>" class="btn btn-danger btn-xs"><i class="fa fa-trash"></i></a>
                        </td>
                        </tr>
<?php endforeach; ?>
                      </tbody>
                    </table>
                  </div>
 <?php endif; ?>
                </div>
              </div>
            </div>

          </div>
