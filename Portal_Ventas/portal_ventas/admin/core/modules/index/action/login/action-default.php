<!--<br><br><br><br><br><br>  <div class="container">
  <div class="row">
    <div class="col-md-4 col-md-offset-4">
      <div class="panel panel-default">
        <div class="panel-heading">Ingresar al sistema</div>
        <div class="panel-body">
        <?php// echo sha1(md5("tecnotronika"));?>


</div>
</div>
</div>
</div>
</div> -->





<div class="container">
<div class="row">
<div class="col-md-6 col-md-offset-3">
<div class="panel panel-login">
  <div class="panel-heading">
    <div class="row">
      <div class="col-xs-6">
        <a href="#" class="active" id="login-form-link">Login</a>
      </div>
      <div class="col-xs-6">
        <a href="#" id="register-form-link">Register</a>
      </div>
    </div>
    <hr>
  </div>
  <div class="panel-body">
    <div class="row">
      <div class="col-lg-12">
        <form id="login-form" role="form" method="post" action="login.php">
          <div class="form-group">
            <label for="exampleInputEmail1">Usuario</label>
            <input type="text" class="form-control" name="email" id="exampleInputEmail1" placeholder="Ingresar email">
          </div>
          <div class="form-group">
            <label for="exampleInputPassword1">Contrase&ntilde;a</label>
            <input type="password" class="form-control" name="password" id="exampleInputPassword1" placeholder="Contrase&ntilde;a">
          </div>
          <button type="submit" class="btn btn-block btn-default">Ingresar</button>

        </form>

        <form id="register-form"  action="index.php?action=adduseradmin" method="post" role="form" style="display: none;">
          <div class="form-group">
            <label for="inputEmail1" class="col-lg-2 control-label">Nombre*</label>
            <div class="col-md-12">
            <input required type="text" name="name" class="form-control" id="name" placeholder="Nombre">
            </div>
          </div>
          <div class="form-group">
            <label for="inputEmail1" class="col-lg-2 control-label">Apellido*</label>
            <div class="col-md-12">
              <input type="text" name="lastname" required class="form-control" id="lastname" placeholder="Apellido">
            </div>
          </div>
          <div class="form-group">
            <label for="inputEmail1" class="col-lg-6 control-label">Nombre de usuario*</label>
            <div class="col-md-12">
              <input type="text" name="username" class="form-control" required id="username" placeholder="Nombre de usuario">
            </div>
          </div>   
          <div class="form-group">
            <label for="inputEmail1" required class="col-lg-2 control-label">Email*</label>
            <div class="col-md-12">
              <input type="email" required name="email" class="form-control" id="email" placeholder="Email">
            </div>
          </div>                  
          <div class="form-group">
            <label for="inputEmail1" class="col-lg-2 control-label">Contrase&ntilde;a*</label>
            <div class="col-md-12">
              <input type="password" required name="password" class="form-control" id="inputEmail1" placeholder="Contrase&ntilde;a">
            </div>
          </div>
          <div class="form-group">
            <label for="userportalpagos" class="col-lg-6 control-label">Usuario de portal de pagos*</label>
            <div class="col-md-12">
              <input type="text" required name="userportalpagos" class="form-control" id="usrportalpagos" placeholder="Usuario de portal de pagos">
            </div>
          </div>                  
          <div class="form-group">
            <label for="passwordportaldepagos" class="col-lg-6 control-label">Contrase&ntilde;a de portal de pagos*</label>
            <div class="col-md-12">
              <input type="password" required name="passwordportaldepagos" class="form-control" id="passportaldepagos" placeholder="Contrase&ntilde;a de portal de pagos">
            </div>
          </div>
          <p class="alert alert-info">* Campos obligatorios</p>
          <div class="form-group">
            <div class="col-lg-offset-2 col-lg-6">
              <button type="submit" class="btn btn-primary">Agregar Usuario</button>
            </div>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>
</div>
</div>
</div>

<script>
$(function() {
$('#login-form-link').click(function(e) {
$("#login-form").delay(100).fadeIn(100);
$("#register-form").fadeOut(100);
$('#register-form-link').removeClass('active');
$(this).addClass('active');
e.preventDefault();
});

$('#register-form-link').click(function(e) {
$("#register-form").delay(100).fadeIn(100);
$("#login-form").fadeOut(100);
$('#login-form-link').removeClass('active');
$(this).addClass('active');
e.preventDefault();
});

});
</script>