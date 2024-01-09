// Sweet alert para aceptar/eliminar solicitudes de amistad.
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
