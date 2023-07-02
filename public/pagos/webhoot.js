$.ajax({
    type: "get",
    url: "/Webhook/verificate",
    data: "",
    dataType: "json",
    success: function (response) {
        if (response == 'sin-pagar') {
            window.location.href="/Webhook/renew_payment"; 
        }
    }
});
