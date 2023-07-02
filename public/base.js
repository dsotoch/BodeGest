function footer() {
    var fgrande = document.getElementById('footer-grande');
    var fpequ = document.getElementById('footer-pe');
    if (window.innerWidth > 768) {
        fgrande.hidden = false;
        fpequ.hidden = true;
    } else {
        fpequ.hidden = false;
        fgrande.hidden = true;
    }
}
footer();
window.addEventListener("resize", footer);
$("#guardarempresa").prop('disabled',true);
$(document).on('click', '#guardarempresa', function () {
    let ruc = $("#ruc").val();
    let nombre = $("#nombre").val();
    let direccion = $("#direccion").val();
    let telefono = $("#telefono").val();
    if (ruc == "" || nombre == "" || direccion == "" || telefono == "") {
        Swal.fire("Error", "Complete todos los campos", "error");
    } else {
        let data = { ruc: ruc, nombre: nombre, direccion: direccion, telefono: telefono };
        $.ajax({
            type: "get",
            url: "/Login/Empresa",
            data: data,
            dataType: "json",
            success: function (response) {
                Swal.fire("Confirmación",response, "success");
                $("#guardarempresa").prop('disabled',true);
            }
        });
    }
});

$(document).on('click', '#verempresa', function () {
    $.ajax({
        type: "get",
        url: "/Login/verEmpresa",
        data: "",
        dataType: "json",
        success: function (response) {
            if (response === 500) {
                $("#ruc").val("sin datos");
                $("#nombre").val("sin datos");
                $("#direccion").val("sin datos");
                $("#telefono").val("sin datos");
            } else {
                $("#ruc").val(response.ruc);
                $("#nombre").val(response.nombre);
                $("#direccion").val(response.direccion);
                $("#telefono").val(response.telefono);
            }
            $("#guardarempresa").prop('disabled',false);
        }
    });
});
