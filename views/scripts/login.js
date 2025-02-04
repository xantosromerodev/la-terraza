$("#btn-ingresar").on("click", function (e) {
    e.preventDefault();
<<<<<<< HEAD
    var data = {
        dni: $("#dni").val(),
        password: $("#password").val()
    }
    $.post("../controller/usuario.php?op=login", data, function (e) {
        console.log(e);

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
    
=======

    document.getElementById('dniError').style.display = 'none';
    document.getElementById('passwordError').style.display = 'none';
    document.getElementById('dni').classList.remove('is-invalid');
    document.getElementById('password').classList.remove('is-invalid');

    let isValid = true

    // Obtener los valores de los campos
    const dni = document.getElementById('dni').value;
    const password = document.getElementById('password').value;

    // Validación del campo usuario (debe ser un número no vacío)
    if (!dni || isNaN(dni)) {
        isValid = false;
        document.getElementById('dniError').style.display = 'block';
        document.getElementById('dni').classList.add('is-invalid');
      }

      // Validación del campo contraseña (no vacío)
      if (!password) {
        isValid = false;
        document.getElementById('passwordError').style.display = 'block';
        document.getElementById('password').classList.add('is-invalid');
      }
    
     if (isValid) {
        var data = {
            dni: $("#dni").val(),
            password: $("#password").val(),
        };
        $.post("../controller/usuario.php?op=login", data, function (e) {
            console.log(e);
            data = JSON.parse(e);
            console.log(data);
            if (data.rol == "ADMINISTRADOR") {
                $(location).attr("href", "home.php");
            } else if (data.rol == "AZAFATA") {
                $(location).attr("href", "pedidos.php");
            } else if (data.rol == "CAJA") {
                $(location).attr("href", "caja.php");
            }
        });
    }
>>>>>>> e09b22555810be5dab2c868ad27e46b20f3cc03a
});


// funcion mostrar contraseña
document.getElementById("toggle-password").addEventListener("click", function () {
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
