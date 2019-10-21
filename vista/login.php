<!doctype html>
<html>
<head>
    <meta charset="utf-8" name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./vista/css/bootstrap.min.css">
    <link rel="stylesheet" href="./vista/css/login_style.css">
    <script type="text/javascript" src="./vista/js/getlogininfo.js"></script>
    <script src="./vista/js/jquery.min.js"></script>
    <script src="./vista/js/bootstrap.min.js"></script>
    <title>Bayental Compartido</title>
</head>
<body>
<div class="container">
    <div class="card card-container">
        <!--<img id="profile-img" class="profile-img-card" src="//ssl.gstatic.com/accounts/ui/avatar_2x.png" />-->
        <img src="./vista/img/bayental_logo.png" class="center-block img-responsive">
        <p id="profile-name" class="profile-name-card"></p>
        <div class="titulo">
            <!--<p><h4>Financiera Oh!</h4></p>-->
        </div>
        <form class="form-signin">
            <div id="resultado"></div>
            <input type="text" id="username" class="form-control" placeholder="Usuario" required autofocus>
            <input type="password" id="userpass" class="form-control" placeholder="Contraseña" required>
            <div><p></p></div>
            <button type="button" onclick="captura_datos();" class="btn btn-primary">Ingresar</button>
        </form>
    </div>
</div>

</body>
</html>