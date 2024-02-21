//const DIR_SERV = "http://localhost/Proyectos/TeoriaServiviosWeb/primera_api"
const DIR_SERV = "http://localhost/Proyectos/Practica1_SW/servicios_rest"
function llamada_get1() {

    $.ajax({
        url: DIR_SERV + "/saludo",
        dataType: "json",
        type: "GET"
    })
        .done(function (data) {
            $('#respuesta').html(data.mensaje)
        })
        .fail(function (a, b) {
            $('#respuesta').html(error_ajax_jquery(a, b))
        })
}

function llamada_get2() {
    let nombre = "Juan Diego"
    $.ajax({
        url: encodeURI(DIR_SERV + "/saludo/" + nombre),
        dataType: "json",
        type: "GET"
    })
        .done(function (data) {
            $('#respuesta').html(data.mensaje)
        })
        .fail(function (a, b) {
            $('#respuesta').html(error_ajax_jquery(a, b))
        })
}

function llamada_post() {
    let nombre = "Alvaro"
    $.ajax({
        url: encodeURI(DIR_SERV + "/saludo"),
        dataType: "json",
        type: "POST",
        data: { param: nombre }
    })
        .done(function (data) {
            $('#respuesta').html(data.mensaje)
        })
        .fail(function (a, b) {
            $('#respuesta').html(error_ajax_jquery(a, b))
        })
}
function llamada_delete() {
    let id = 5
    $.ajax({
        url: encodeURI(DIR_SERV + "/borrar_saludo/" + id),
        dataType: "json",
        type: "DELETE"
    })
        .done(function (data) {
            $('#respuesta').html(data.mensaje)
        })
        .fail(function (a, b) {
            $('#respuesta').html(error_ajax_jquery(a, b))
        })
}

function llamada_put() {
    let id = 5
    let nombre = "Juan Dieguito";
    $.ajax({
        url: encodeURI(DIR_SERV + "/actualizar_saludo/" + id),
        dataType: "json",
        type: "PUT",
        data: { nombre: nombre }
    })
        .done(function (data) {
            $('#respuesta').html(data.mensaje)
        })
        .fail(function (a, b) {
            $('#respuesta').html(error_ajax_jquery(a, b))
        })
}

function llamada_productos() {
    let id = 5
    let nombre = "Juan Dieguito";
    $.ajax({
        url: encodeURI(DIR_SERV + "/productos"),
        dataType: "json",
        type: "GET"
    })
        .done(function (data) {
            if (data.mensaje_error) {
                $('#respuesta').html(data.mensaje_error)
            } else {

                let codHtml = "<table>"
                codHtml += "<tr><th>COD</th><th>Nombre Corto</th><th>PVP</th></tr>"
                $.each(data.productos, function (key, producto) {
                    codHtml += "<tr><td>" + producto["cod"] + "</td><td>" + producto["nombre_corto"] + "</td><td>" + producto["PVP"] + "</td></tr>"
                })
                codHtml += "</table>"
                $('#respuesta').html(codHtml)
            }

        })
        .fail(function (a, b) {
            $('#respuesta').html(error_ajax_jquery(a, b))
        })
}


function error_ajax_jquery(jqXHR, textStatus) {
    var respuesta;
    if (jqXHR.status === 0) {

        respuesta = 'Not connect: Verify Network.';

    } else if (jqXHR.status == 404) {

        respuesta = 'Requested page not found [404]';

    } else if (jqXHR.status == 500) {

        respuesta = 'Internal Server Error [500].';

    } else if (textStatus === 'parsererror') {

        respuesta = 'Requested JSON parse failed.';

    } else if (textStatus === 'timeout') {

        respuesta = 'Time out error.';

    } else if (textStatus === 'abort') {

        respuesta = 'Ajax request aborted.';

    } else {

        respuesta = 'Uncaught Error: ' + jqXHR.responseText;

    }
    return respuesta;
}