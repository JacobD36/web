function captura_datos() {
    var usuario = document.getElementById("username").value;
    var pass = document.getElementById("userpass").value;
    //var proyect = document.getElementById("proyect_id").value;

    var url1 = "controlador/login_getlogininfo.php";

    $.ajax({
        type: "post",
        url: url1,
        data: {
            username: usuario,
            userpass: pass,
            //proyecto: proyect
        },
        success: function(datos) {
            $("#resultado").html(datos);
        }
    })
}