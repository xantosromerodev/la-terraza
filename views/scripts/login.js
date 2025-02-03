$("#btn-ingresar").on("click", function (e) {
    e.preventDefault();
    var data = {
        email: $("#dni").val(),
        password: $("#password").val()
    }
    $.post("../controller/usuario.php?op=login", data, function (e) {
       data = JSON.parse(e);
       console.log(data);
        if (data.rol == "ADMINISTRADOR"){
            
            $(location).attr("href", "home.php");  
           
        }else if(data.rol == "AZAFATA"){
           
            $(location).attr("href", "pedidos.php");
        }else if(data.rol == "CAJA"){
           
            $(location).attr("href", "caja.php");
        }
    });
});


// Funcionar ojito
document.getElementById("toggle-password").addEventListener("click", function() {
    let passwordInput = document.getElementById("password");
    let icon = this.querySelector("i");

    if (passwordInput.type === "password") {
        passwordInput.type = "text";
        icon.classList.remove("fa-eye");
        icon.classList.add("fa-eye-slash");
    } else {
        passwordInput.type = "password";
        icon.classList.remove("fa-eye-slash");
        icon.classList.add("fa-eye");
    }
});