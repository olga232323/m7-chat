// Sweet alert para aceptar/eliminar solicitudes de amistad.
var http_request_mensajes = new XMLHttpRequest();
var ajax = new XMLHttpRequest();
var READY_STATE_COMPLETE = 4;

function ListarMensajes(id) {
  var listaMensajes = document.getElementById('listaMensajes');
  var barraEnviarMensaje = document.getElementById('barraMensaje');
  var infoCuboChat = document.getElementById('infoCuboChat');
  var str = "";
  var html = "";
  // Enviamos por POST idAmigo del que queremos ver los mensajes
  var formData = new FormData();
  formData.append('idAmigo', id);
  http_request_mensajes.open('POST', './inc/listado_mensajes.php');

  http_request_mensajes.onreadystatechange = function () {
    if (http_request_mensajes.readyState == READY_STATE_COMPLETE && http_request_mensajes.status == 200) {
      var respuestaPeticion = http_request_mensajes.responseText;
      if (respuestaPeticion == 'empty') {
        infoCuboChat.innerText = "No tienes mensajes con esta persona.";
      } else {
        var json = JSON.parse(respuestaPeticion);
        infoCuboChat.innerText = "";
        json.forEach(function (item) {
          mensaje = item.contenido;
          senderId = item.sender_id;
          fechaEnvio = item.fecha_envio;
          sender_username = item.sender_username;
          /* Si el usuario de envio es igual al de la sesion se mostraran los mensajes en azul y a la derecha */
          if (senderId == userID) {
            str += "<div class='d-flex flex-row justify-content-end'><div><p class='small p-2 me-3 mb-1 text-white rounded-3 bg-primary'>" + mensaje + "</p><p class='small me-3 text-muted'>Enviado por: " + sender_username + "</p><p class='small me-3 mb-3 text-muted'>Fecha: " + fechaEnvio + "</p></div></div>";
          }
          /* En caso contario se mostraran en blanco y a la izquierda */
          else if (senderId == id) {
            str += "<div class='d-flex flex-row justify-content-start'><div><p class='small p-2 ms-3 mb-1 rounded-3' style='background-color: #f5f6f7;'>" + mensaje + "</p><p class='small ms-3 text-muted'>Enviado por: " + sender_username + "</p><p class='small ms-3 mb-3 text-muted'>Fecha: " + fechaEnvio + "</p></div></div>";
          }
        });
      }
      listaMensajes.innerHTML = str;
    } else {
      listaMensajes.innerText = "Error";
    }
    html = "<div class='text-muted d-flex justify-content-start align-items-center pe-3 pt-3 mt-2'><form method='POST' action='' id='formMensaje' class='d-flex w-100'><input type='hidden' name='idAmigo' id='idAmigo' value='" + id + "'><input type='text' name='mensaje' class='form-control flex-grow-1' id='mensaje' placeholder='Escriba un mensaje'><input type='button' name='enviarMensaje' id='enviarMensaje' value='Enviar' class='btn btn-secondary'></form></div>";
    barraEnviarMensaje.innerHTML = html;
    document.getElementById('enviarMensaje').addEventListener("click", EnviarMensaje);
    // document.getElementById('formMensaje').addEventListener("submit", EnviarMensaje);
  }
  http_request_mensajes.send(formData);

}
function EnviarMensaje () {
  var form = document.getElementById('formMensaje');
  var idAmigo = form.elements['idAmigo'].value;
  var formDataMensaje = new FormData(form);

  ajax.open('POST', './inc/enviar_mensaje.php');
  ajax.onload = function () {
    if (ajax.status == 200) {
      if (ajax.responseText == "ok") {
        // Reseteamos el formulario
        form.reset();
        // Refrescar el listado de mensajes
        ListarMensajes(idAmigo);
      }
    } else {
      console.log('errorajax');
    }
  }
  ajax.send(formDataMensaje);
}