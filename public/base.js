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
    let telefono = $("#telefonoempresa").val();
    let igv=$("#empresaigv").val();
    console.log(igv);
    if (ruc == "" || nombre == "" || direccion == "" || telefono == "" || igv=="" || parseFloat(igv)<=0) {
        Swal.fire("Error", "Complete todos los campos", "error");
    } else {
        let data = { ruc: ruc, nombre: nombre, direccion: direccion, telefono: telefono,igv:igv };
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
                $("#telefonoempresa").val("sin datos");
                $("#empresaigv").val("sin datos");

            } else {
                $("#ruc").val(response.ruc);
                $("#nombre").val(response.nombre);
                $("#direccion").val(response.direccion);
                $("#telefonoempresa").val(response.telefono);
                $("#empresaigv").val(response.igv);

            }
            $("#guardarempresa").prop('disabled',false);
        }
    });
});
