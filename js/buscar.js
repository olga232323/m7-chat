busqueda_realizada.addEventListener("keyup", () => {
    const valor = busqueda_realizada.value;
    if (valor === "") {
        ListarUsuarios('');
    } else {
        buscarUsuarios(valor.trim());

    }
});

function buscarUsuarios(valor) {
    var READY_STATE_COMPLETE = 4;
    var resultado = document.getElementById('resultadosBusqueda');
    var formData = new FormData();
    formData.append("busqueda_realizada", valor);

    var ajax = new XMLHttpRequest();
    ajax.open('POST', './inc/busqueda_usuarios.php');

    ajax.onreadystatechange = function() {

        if (ajax.status == 200 && ajax.readyState == READY_STATE_COMPLETE) {
            console.log('ok');
            console.log(ajax.responseText)
            var json = JSON.parse(ajax.responseText);

            var tabla = '<h5>Resultados de la búsqueda:</h5><ul style="list-style:none;">';
            json.forEach(function(item) {
                tabla += "<li class='p-2'>"
                tabla += "<div class='d-flex flex-row'>"
                tabla += "<div class='pt-1'>"
                tabla += "<div class='row align-items-center'>"
                tabla += "<div class='col-6 text-center'>"
                tabla += " <p class='fw-bold text-left'>" + item.nombre_real + "</p></div>"
                if (item.estado_solicitud == 'aceptada') {
                    tabla += "<div class='col-6 text-center'>"
                    tabla += "</div>"
                } else {
                    tabla += "<div class='col-6 text-center'>"
                    tabla += "<a class='btn d-inline-flex text-right' style='background-color: white; border: none; margin-bottom: 50%;' onclick='EnviarSolicitud(" + item.user_id + ")'>✅</a>"
                    tabla += "</div>"
                }
                tabla += "</div> </div> </div>"
                tabla += "</li>"
            });
            tabla += "</ul>";
            resultado.innerHTML = tabla;
        } else {
            resultado.innerText = "Error al buscar usuarios";
        }
    };
    ajax.onerror = function() {
        resultado.innerText = "Error de conexión";
    };
    ajax.send(formData);
}