busqueda_realizada.addEventListener("keyup", () => {
    const valor = busqueda_realizada.value;
    if (valor === "") {
        ListarUsuarios('');
    } else {
        console.log(valor);
        buscarUsuarios(valor.trim());

    }
});

function buscarUsuarios(valor) {
    var resultado = document.getElementById('resultadosBusqueda');
    var formData = new FormData();
    formData.append("busqueda_realizada", valor);

    var ajax = new XMLHttpRequest();
    ajax.open('POST', './inc/busqueda_usuarios.php');

    ajax.onload = function() {
        if (ajax.status == 200) {
            var json = JSON.parse(ajax.responseText);
            var tabla = '<h5>Resultados de la búsqueda:</h5><ul style="list-style:none;">';
            json.forEach(function(item) {
                tabla += "<li>" + item.nombre_real + " - " + item.user_id + "</li>";
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