
var tabla;
//Función que se ejecuta al inicio
function init() {

    listar();
    $('#rol_user').select();
 $.post("../controller/usuario.php?op=selectPerfil", function (r) {
     $("#rol_user").html(r);
     $('#rol_user').selectpicker('refresh');
    });  

}


function listar() {
    tabla = $("#datatable-responsive").DataTable({
        bLengthChange: true,
        autoWidth: false,
        bDestroy: true,
        language: {
            search: "Buscar por",
            lengthMenu: "Mostrar _MENU_ Elementos",
            info: "Mostrando _START_ a _END_ de _TOTAL_ Elementos",
            infoEmpty: "Mostrando 0 registros de 0 registros encontrados",
            paginate: {
                next: "<span ><i class='fa fa-arrow-right' aria-hidden='true'></span>",
                previous: "<span ><i class='fa fa-arrow-left' aria-hidden='true'></i></span>",
            },
        },
        "ajax": {
            url: '../controller/usuario.php?op=listar',
            type: 'get',
            dataType: 'json',
            error: function (e) {
                console.log(e);
            }
        },
        responsive: true,
        searching: true,
    });
}
$("#btn-guardar").on("click", function (e) {
    e.preventDefault();
    if ($("#id_user").val() == "") {
        guardar();
    } else {
        actualizar();
    }
});
function guardar() {
    var data={
        dni_user:$("#dni_user").val(),
        nombre_user:$("#nombre_user").val(),
        correo_user:$("#correo_user").val(),
        celular_user:$("#celular_user").val(),
        direccion_user:$("#direccion_user").val(),
        rol_user:$("#rol_user").val(),
        contraseña_user:$("#contraseña_user").val(),
        
    }
    console.log(data);
    $.post("../controller/usuario.php?op=guardaryeditar",data,function(e){
        if(data){
            console.log(e);
            $.notify(e,"success");
            $("#exampleModal").modal('hide');
            limpiar();
            listar();
        }else{
            $.notify(e,"error");
        }
    });
}
function actualizar() {
    var data={
        id_user: $("#id_user").val(),
        dni_user:$("#dni_user").val(),
        nombre_user:$("#nombre_user").val(),
        correo_user:$("#correo_user").val(),
        celular_user:$("#celular_user").val(),
        direccion_user:$("#direccion_user").val(),
        rol_user: $("#rol_user").val(),
        contraseña_user:$("#contraseña_user").val()
    }
    
    $.post("../controller/usuario.php?op=guardaryeditar",data,function(e){
        if(e){
            $.notify(e,"success");
            $("#exampleModal").modal('hide');
            limpiar();
            listar();
        }else{
            $.notify(e,"error");
        }
    });
}

function limpiar() {
    $("#frm_usuario")[0].reset();
}
$("#btn_buscar_ruc_dni").click(function () {
    var dni = $("#dni_user").val();
        $.ajax({
            type: "POST",
            url: "../controller/consultaDni.php",
            data: "dni=" + dni,
            dataType: "json",
            success: function (data) {
                if (data.numeroDocumento == dni) {
                    $("#nombre_user").val(data.nombres + " " + data.apellidoPaterno + " " + data.apellidoMaterno);
                    $("#direccion_user").val(data.direccion);
                    console.log(data);
                }
            },
        });
});
function mostrar(id_user) {
    $.post("../controller/usuario.php?op=mostrar",{id_user:id_user},function(data){
        data=JSON.parse(data);
        $("#exampleModal").modal('show');
        $("#id_user").val(data.id);
        $("#dni_user").val(data.dni);
        $("#nombre_user").val(data.nombre_ape);
        $("#correo_user").val(data.correo);
        $("#celular_user").val(data.celular);
        $("#direccion_user").val(data.direccion);
        $("#rol_user").val(data.rol_id);
        $("#contraseña_user").val(data.contraseña);
        $('#rol_user').selectpicker('refresh');
    });
}

function eliminar(id_user) {
   Swal.fire({
       title: '¿Estás seguro de eliminar el usuario?',
       text: "¡No podrás revertir esto!",
       icon: 'warning',
       showCancelButton: true,
       confirmButtonColor: '#3085d6',
       cancelButtonColor: '#d33',
       confirmButtonText: '¡Sí, eliminarlo!',
       cancelButtonText: 'Cancelar'
   }).then((result) => {
       if (result.isConfirmed) {
           $.post("../controller/usuario.php?op=eliminar",{id_user:id_user},function(e){
               if(e){
                  $.notify(e,"success");
                   listar();
               }else{
                   $.notify(e,"error");
               }
           });
       }
   })
}

init();
