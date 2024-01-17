// Sweet alert para aceptar/eliminar/enviar solicitudes de amistad.
var http_request_solicitudes = new XMLHttpRequest();
var http_request = new XMLHttpRequest();
var http_request_crear_solicitud = new XMLHttpRequest();
var ajax = new XMLHttpRequest();
var READY_STATE_COMPLETE = 4;

window.onload = function() {
    RefrescarSolicitudes();
    ListarUsuarios();
};



function RefrescarSolicitudes() {
    http_request_solicitudes.open('POST', './inc/listar_solicitudes.php');
    http_request_solicitudes.onreadystatechange = ListarSolicitudes;
    http_request_solicitudes.send(null);
}



// Lista solicitudes usuario
function ListarSolicitudes() {
    var resultado = document.getElementById('resultado');
    var str = "";
    if (http_request_solicitudes.readyState == READY_STATE_COMPLETE && http_request_solicitudes.status == 200) {
        var html = '';
        var respuestaPeticion = http_request_solicitudes.responseText;
        if (respuestaPeticion == 'empty') {
            str = "<div class='d-flex flex-row justify-content-center align-items-center'><div><p class='small p-2 ms-3 mb-1 rounded-3' style='background-color: #f5f6f7;'>No tienes solicitudes de Amistad.</p></div></div>";
            html += str;
        } else {
            var json = JSON.parse(respuestaPeticion);
            str += "<ol style='margin-left: 10%;'>";
            json.forEach(function(item) {
                str += "<li>" + item.username_user_id_2 + "<a style='text-decoration: none; color: black;' onclick='Aceptar(" + item.friendship_id + "," + item.user_id_user_id_2 + ")'>✅</a><a style='text-decoration: none; color: black;' onclick='Eliminar(" + item.friendship_id + "," + item.user_id_user_id_2 + ")'>❌</a></li>";
            });
        }
        resultado.innerHTML = str;
    } else {
        resultado.innerText = "Error";
    }
}

function ListarUsuarios() {
    var READY_STATE_COMPLETE = 4;
    var resultado = document.getElementById('listarAmigos');
    var formData = new FormData();
    var ajax = new XMLHttpRequest();
    ajax.open('POST', './inc/listado_amigos.php');

    ajax.onreadystatechange = function() {
        console.log(ajax.responseText)

        if (ajax.status == 200 && ajax.readyState == READY_STATE_COMPLETE) {
            console.log('ok');
            console.log(ajax.responseText)
            var json = JSON.parse(ajax.responseText);

            var tabla = " <h5>Tus Amigos:</h5>"
            if (json.length > 0) {
                json.forEach(function(item) {
                    // tabla += "<li class='p-2'>"
                    tabla += " <a onclick='ListarMensajes(" + item.user_id + ")' class='d-flex justify-content-between text-decoration-none text-dark'>"
                    tabla += " <div class='d-flex flex-row'> <div class='pt-1'>"
                    tabla += "<p class='fw-bold mb-0 text-center'>" + item.nombre_real + "</p>"
                    tabla += " </div></div> </a>"
                });
                resultado.innerHTML = tabla;
            } else {
                var empty = "<div class='d-flex flex-row'> <div class='pt-1'> <p class='fw-bold mb-0'>No tienes amigos agregados</p> </div> </div>"
                resultado.innerHTML = empty;
            }

        } else {
            var empty = "<div class='d-flex flex-row'> <div class='pt-1'> <p class='fw-bold mb-0'>No tienes amigos agregados</p> </div> </div>"
            resultado.innerHTML = empty;

        }
    }
    ajax.onerror = function() {
        resultado.innerText = "Error de conexión";
    }
    ajax.send(formData);

}
// Aceptar solicitud
function Aceptar(friend_id, amigo_id) {
    var formData = new FormData();
    formData.append('friend_id', friend_id);
    formData.append('amigo_id', amigo_id);

    // Abre una conexión con el servidor para aceptar la solicitud
    http_request.open('POST', './inc/aceptar_solicitud.php');

    http_request.onreadystatechange = function() {
        if (http_request.readyState == READY_STATE_COMPLETE && http_request.status == 200 && http_request.responseText == 'ok') {
            Swal.fire({
                title: 'Solicitud aceptada!',
                icon: "success",
                showConfirmButton: false,
                timer: 1500
            });
            RefrescarSolicitudes();
            ListarUsuarios();
        } else {
            // Mensaje error solicitud no aceptada
            Swal.fire({
                icon: 'error',
                title: 'Algo ha salido mal',
                text: 'Solicitud no aceptada, inténtelo de nuevo más tarde..',
                showConfirmButton: false,
                timer: 1500
            });
        }
    }
    http_request.send(formData);
}

// Eliminar solicitud
function Eliminar(friend_id, amigo_id) {
    Swal.fire({
        title: 'Eliminar solicitud?',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Sí!',
        cancelButtonText: 'NO'
    }).then((result) => {
        if (result.isConfirmed) {
            var formDataEliminar = new FormData();
            formDataEliminar.append('friend_id', friend_id);
            formDataEliminar.append('amigo_id', amigo_id);
            // Abre una conexión con el servidor para eliminar la solicitud
            ajax.open('POST', './inc/borrar_solicitud.php');

            ajax.onreadystatechange = function() {
                if (ajax.readyState == READY_STATE_COMPLETE && ajax.status == 200 && ajax.responseText == 'ok') {
                    Swal.fire({
                        icon: 'success',
                        title: 'Eliminado',
                        showConfirmButton: false,
                        timer: 1500
                    });
                    console.log('')
                    RefrescarSolicitudes();
                    ListarUsuarios();
                } else {
                    // Mensaje error solicitud no eliminada
                    Swal.fire({
                        icon: 'error',
                        title: 'Algo ha salido mal',
                        text: 'Solicitud no eliminada, inténtelo de nuevo más tarde..',
                        showConfirmButton: false,
                        timer: 1500
                    });
                }
            }
            ajax.send(formDataEliminar);
        }
    });
}


function EnviarSolicitud(user_id) {
    var agregarAmigo = 'agregarAmigo';
    var formDataSolicitud = new FormData();
    formDataSolicitud.append('idAmigo', user_id);
    formDataSolicitud.append('agregarAmigo', agregarAmigo);

    // Abre una conexión con el servidor para enviar la solicitud
    http_request_crear_solicitud.open('POST', './inc/enviar_solicitud.php');

    http_request_crear_solicitud.onreadystatechange = function() {
        if (http_request_crear_solicitud.readyState == READY_STATE_COMPLETE) {
            console.log('readystateok');
            if (http_request_crear_solicitud.status == 200 && http_request_crear_solicitud.responseText == 'ok') {
                console.log('readystateok2');

                Swal.fire({
                    title: 'Solicitud enviada!',
                    icon: "success",
                    showConfirmButton: false,
                    timer: 1500
                });
                RefrescarSolicitudes();
            }

        } else {
            // Mensaje error solicitud no enviada
            Swal.fire({
                icon: 'error',
                title: 'Algo ha salido mal',
                text: 'Solicitud no enviada, inténtelo de nuevo más tarde..',
                showConfirmButton: false,
                timer: 1500
            });
        }
    }
    http_request_crear_solicitud.send(formDataSolicitud);
}