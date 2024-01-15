// Sweet alert para aceptar/eliminar solicitudes de amistad.
var http_request_solicitudes = new XMLHttpRequest();
var http_request = new XMLHttpRequest();
var ajax = new XMLHttpRequest();
var READY_STATE_COMPLETE = 4;

var intervalo = setInterval(function () {
  //call $.ajax here
}, 30000);
window.onload = function () { // Cuando cargue la pagina 
  http_request_solicitudes.open('POST', './inc/listar_solicitudes.php');
  http_request_solicitudes.onreadystatechange = ListarSolicitudes;
  http_request_solicitudes.send(null);
}
function Aceptar(friend_id, amigo_id) {
  var formData = new FormData();
  formData.append('friend_id', friend_id);
  formData.append('amigo_id', amigo_id);

  // Abre una conexión con el servidor para aceptar la solicitud
  http_request.open('POST', './inc/aceptar_solicitud.php');

  http_request.onreadystatechange = function () {
    if (http_request.readyState == READY_STATE_COMPLETE && http_request.status == 200 && http_request.responseText == 'ok') {
      Swal.fire({
        title: 'Solicitud aceptada!',
        icon: "success",
        showConfirmButton: false,
        timer: 1500
      });
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

      ajax.onreadystatechange = function () {
        if (ajax.readyState == READY_STATE_COMPLETE && ajax.status == 200 && ajax.responseText == 'ok') {
          Swal.fire({
            icon: 'success',
            title: 'Eliminado',
            showConfirmButton: false,
            timer: 1500
          });

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
      json.forEach(function (item) {
        str += "<li>" + item.username_user_id_2 + "<a style='text-decoration: none; color: black;' onclick='Aceptar(" + item.friendship_id + "," + item.user_id_user_id_2 + ")'>✅</a><a style='text-decoration: none; color: black;' onclick='Eliminar(" + item.friendship_id + "," + item.user_id_user_id_2 + ")'>❌</a></li>";
      });
    }
    resultado.innerHTML = str;
  } else {
    resultado.innerText = "Error";
  }
}