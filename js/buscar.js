var READY_STATE_COMPLETE = 4;
var ajax = new XMLHttpRequest();
var resultado = document.getElementById('resultadosBusqueda');
var busqueda_realizada = document.getElementById("busqueda_realizada");
var userid = document.getElementById("user_id").value;
busqueda_realizada.addEventListener("keyup", () => {
    const valor = busqueda_realizada.value;
    var resultadosBusqueda = document.getElementById('resultadosBusqueda');
    if (valor === "") {
        // buscarUsuarios("");
        resultadosBusqueda.style.display = "none";

    } else {
        resultadosBusqueda.style.display = "block";
        buscarUsuarios(valor.trim());
        console.log(valor.trim());
    }
});

function buscarUsuarios(valor) {

    var formData = new FormData();
    formData.append("busqueda_realizada", valor);

    ajax.onreadystatechange = respuestaServer;

    ajax.open('POST', './inc/busqueda_usuarios.php');

    ajax.send(formData);
    ajax.onerror = function() {
        resultado.innerText = "Error de conexión";
    }
}
//Funcion de respuesta
function respuestaServer() {
    if (ajax.readyState == READY_STATE_COMPLETE) {
        if (ajax.status == 200) {
            console.log('ok');
            console.log(ajax.responseText);
            try {
                var json = JSON.parse(ajax.responseText);
                console.log(ajax.responseText);

                var tabla = '<h5>Resultados de la búsqueda:</h5><ul style="list-style:none;">';
                json.forEach(function(item) {

                    if (item.estado_solicitud == 'aceptada' || item.user_id == userid) {
                        tabla += "<li class='p-2'>"
                        tabla += "<div class='flex-row'>"
                        tabla += "<div class='pt-1'>"
                        tabla += "<div class='row align-items-left'>"
                        tabla += "<div class='col-6 text-center'>"
                        tabla += "<p onclick='ListarMensajes(" + item.user_id + ")' class='fw-bold text-left' style='margin-left: -5px'>" + item.nombre_real + "</p></div>"
                        tabla += "</div> </div> </div>"
                        tabla += "</li>"
                    } else {

                        tabla += "<li class='p-2'>"
                        tabla += "<div class='d-flex flex-row'>"
                        tabla += "<div class='pt-1'>"
                        tabla += "<div class='row align-items-center'>"
                        tabla += "<div class='col-6 text-center'>"
                        tabla += " <p class='fw-bold text-left'>" + item.nombre_real + "</p></div>"
                        tabla += "<div class='col-6 text-center'>"
                        tabla += "<a class='btn d-inline-flex text-right' onclick='EnviarSolicitud(" + item.user_id + ")'  style='background-color: white; border: none; margin-bottom: 50%;'>✅</a>"
                            // href='./inc/enviar_solicitud.php?agregarAmigo&idAmigo=" + item.user_id + "'
                        tabla += "</div>"
                        tabla += "</div> </div> </div>"
                        tabla += "</li>"
                    }

                });
                tabla += "</ul>";
                resultado.innerHTML = tabla;
            } catch (error) {
                console.error("Error al parsear la respuesta JSON:", error);
                resultado.innerText = "Error al procesar la respuesta del servidor";
            }

        } else {
            console.error("Error en la solicitud al servidor. Estado:", ajax.status);
            resultado.innerText = "Error al comunicarse con el servidor";
        }
        // };
    }
}