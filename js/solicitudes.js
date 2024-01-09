// Sweet alert para aceptar/eliminar solicitudes de amistad.
var http_request = new XMLHttpRequest();
var READY_STATE_COMPLETE = 4;
window.onload = function () { // Cuando cargue la pagina 
  http_request.open('GET', './inc/listar_solicitudes.php');
  http_request.onreadystatechange = ListarSolicitudes;
  http_request.send(null);
}
function Aceptar(friend_id, amigo_id) {
  var formData = new FormData();
  formData.append('friend_id', friend_id);
  formData.append('amigo_id', amigo_id);
  var http_request = new XMLHttpRequest();
  http_request.open('POST', './inc/aceptar_solicitud.php');
  http_request.onload = function () {
    if (http_request.status == 200) {
      if (http_request.responseText == 'ok') {
        Swal.fire({
          title: 'Solicitud aceptada!',
          position: "top-end",
          icon: "success",
          showConfirmButton: false,
          timer: 1500
        });
      }
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
      var formData = new FormData();
      formData.append('friend_id', friend_id);
      formData.append('amigo_id', amigo_id);
      var ajax = new XMLHttpRequest();
      ajax.open('POST', './inc/borrar_solicitud.php');
      ajax.onload = function () {
        if (ajax.status == 200) {
          if (ajax.responseText == 'ok') {
            Swal.fire({
              icon: 'success',
              title: 'Eliminado',
              showConfirmButton: false,
              timer: 1500
            });
          }
        }
      }
      ajax.send(formData);
    }
  });
}
function ListarSolicitudes() {
  var resultado = document.getElementById('resultado');
  var str = "";
  // if (http_request.readyState == READY_STATE_COMPLETE) {
  if (http_request.status == 200) {
    var html = '';
    if (http_request.responseText = 'empty') {
      str = "<div class='d-flex flex-row justify-content-center align-items-center '><div><p class='small p-2 ms-3 mb-1 rounded-3' style='background-color: #f5f6f7;'>No tienes solicitudes de Amistad.</p></div></div>";
      html += str;
    } else {
      var json = JSON.parse(http_request.responseText);
      str = "<ol style='margin-left: 10%;'>";
      json.forEach(function (item) {
        str = str + "<li>" + item.username_user_id_2 + "<a style='text-decoration: none; color: black;' onclick=Aceptar(" + item.friendship_id, item.user_id_user_id_2 + ")>✅</a><a style='text-decoration: none; color: black;' onclick=Eliminar(" + item.friendship_id, item.user_id_user_id_2 + ")>❌</a></li>";
        html += str;
      });
    }
    resultado.innerHTML = html;
  } else {
  resultado.innerText = "Error";
}
}
