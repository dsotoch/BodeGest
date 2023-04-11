
$(document).on('click', '#btn-modal-registrarse', function () {
    $("#exampleModal").modal('show');
});

$(document).on('click', '#btn-registrarse', function (e) {
    e.preventDefault();
    let nombres = $("#modal-auth-name").val();
    let apellidos = $("#modal-auth-apellidos").val();
    let telefono = $("#modal-auth-telefono").val();
    let email = $("#modal-auth-email").val();
    let password = $("#modal-auth-password").val();
    let terminos = $("#modal-auth-register-checkbox");
    let csrf_token = $("#registrarse input[name='_token']").val();
    if (nombres == "" || apellidos == "" || telefono == "" || email == "" || password == "") {
        Swal.fire(
            'ERROR!',
            'Complete Todos Los Campos!',
            'error'
        )
    } else {
        if (!terminos.prop("checked")) {
            Swal.fire(
                'ERROR!',
                'Seleccione los Terminos y Condiciones!',
                'error'
            )
        } else {
            $.ajax({
                type: "GET",
                url: "/Login/Registrarse",
                data: { nombres: nombres, apellidos: apellidos, telefono: telefono, email: email, password: password, _token: csrf_token },
                dataType: "json",
                success: function (response) {
                    if (response == 'EXISTE') {
                        Swal.fire(
                            'ERROR!',
                            'El Correo Electronico ya se Encuentra Registrado!',
                            'error'
                        )
                    } else {
                        Swal.fire(
                            response.email,
                            'Revise su Correo Electronico para Confirmar su Cuenta!',
                            'warning'
                        )

                    }
                }
            });
        }
    }


});
$(document).on('click', '#btn-iniciar-sesion', function (e) {
    e.preventDefault();
    let email = $("#email").val();
    let password = $("#password").val();
    if (email == "" || password == "") {
        Swal.fire({
            title: 'Error!',
            text: 'Complete Todos los Campos',
            icon: 'error',
            confirmButtonText: 'Ok'
        })
    } else {
        $.ajax({
            type: "get",
            url: "/Login/IniciarSesion",
            data: { email: email, password: password },
            dataType: "json",
            success: function (response) {
                switch (response) {
                    case true:
                        Swal.fire({
                            title: 'Confirmación!',
                            text: 'Se ha Identificado Correctamente',
                            icon: 'success',
                            confirmButtonText: 'Ok'
                        }).then((value) => {
                            window.location.href = "/Principal/Dashboard";
                        });
                        break;
                    case false:
                        Swal.fire({
                            title: 'Error!',
                            text: 'Usuario/Contraseña Incorrecta',
                            icon: 'error',
                            confirmButtonText: 'Ok'
                        });
                        break;
                    case 'verificado':
                        Swal.fire({
                            title: 'Error!',
                            text: 'Tu Correo Electronico no Se Encuentra Verificado || Revisa tu Correo con Instrucciones de Verificación',
                            icon: 'error',
                            confirmButtonText: 'Ok'
                        });
                        break;

                    default:
                        Swal.fire({
                            title: 'Error!',
                            text: response,
                            icon: 'error',
                            confirmButtonText: 'Ok'
                        });
                        break;
                }
            }
        });
    }

});