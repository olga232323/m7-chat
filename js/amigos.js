window.onload = function ListarUsuarios() {
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
    }
    ajax.onerror = function() {
        resultado.innerText = "Error de conexión";
    }
    ajax.send(formData);

}