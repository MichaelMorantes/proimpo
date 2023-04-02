// Variables
const url = "http://localhost/proimpo/src/Controller/controller.php";
var records;
var operation;
var form = document.getElementById("form");
var id = document.getElementById("id");
var fname = document.getElementById("name");
var charge = document.getElementById("charge");
var startdate = document.getElementById("startdate");
var currentsales = document.getElementById("currentsales");
var newclients = document.getElementById("newclients");

// Carga la datatable
async function getContent() {
  const table = await axios.get(url).then(function (res) {
    $("#tabla_vendedor").DataTable({
      aaData: res.data[0],
      destroy: true,
      columns: [
        { data: "nombre" },
        { data: "cargo" },
        { data: "inicio_cargo" },
        { data: "ventas", render: $.fn.dataTable.render.number(",", ".", 2, "$") },
        { data: "clientes_nuevos" },
        { data: "observacion" },
        { data: "comision" },
        {
          data: "id",
          render: function (data, type, row, meta) {
            return `<div class="text-center">
                      <div class="btn-group">
                        <button onclick="deletePetition(${data})" class="btn btn-danger">
                          <i class="fa-solid fa-trash"></i>
                        </button>
                      </div>
                    </div>`;
          },
        },
      ],
      responsive: "true",
      processing: true,
      footerCallback: function (row, data, start, end, display) {
        var api = this.api();
        var intVal = function (i) {
          return typeof i === "string" ? i.replace(/[\$,]/g, "") * 1 : typeof i === "number" ? i : 0;
        };
        Selltotal = api
          .column(3)
          .data()
          .reduce(function (a, b) {
            return intVal(a) + intVal(b);
          }, 0);
        Clienttotal = api
          .column(4)
          .data()
          .reduce(function (a, b) {
            return intVal(a) + intVal(b);
          }, 0);
        Comisiontotal = api
          .column(6)
          .data()
          .reduce(function (a, b) {
            return intVal(a) + intVal(b);
          }, 0);
        $(api.column(0).footer()).html("Total");
        $(api.column(3).footer()).html("($" + Selltotal + " total)");
        $(api.column(4).footer()).html("(" + Clienttotal + " total)");
        $(api.column(6).footer()).html("($" + Comisiontotal + " total)");
      },
    });
    records = res.data[0];
  });
}

// Esta función realiza el calculo de comision
function calcComision() {
  const formData = new FormData();
  // Agrega el parámetro "acción" con un valor de "CALCULAR".
  formData.append("action", "CALCULATE");
  // Luego llama a la función sendPetition con el método HTTP "POST" y el objeto formData como parámetros.
  sendPetition("POST", formData);
}

// Esta funcion habre el modal y le añade un titulo
function openModal(op, record = "") {
  id.value = "";
  operation = op;
  if (op === 1) {
    document.getElementById("title").innerHTML = "Insertar nuevo archivo";
  }
  window.setTimeout(function () {
    fname.focus();
  }, 500);
}

// Función que se encarga de validar los campos del formulario.
function validate() {
  // Verifica si el campo "fname" está vacío.
  if (fname.value.trim() == "") {
    showAlert("Nombre del vendedor es obligatorio", "warning");
    // Verifica si el campo "charge" está vacío.
  } else if (charge.value == "") {
    showAlert("Cargo es obligatorio", "warning");
    // Verifica si el campo "startdate" está vacío.
  } else if (startdate.value == "") {
    showAlert("Fecha de inicio en el cargo es obligatorio", "warning");
    // Verifica si el campo "currentsales" está vacío o si no contiene solamente números.
  } else if (currentsales.value == "" || /^\d+$/.test(currentsales.value) === false) {
    showAlert("Ventas del mes actual solo acepta numeros", "warning");
    // Verifica si el campo "currentsales" es menor que 0.
  } else if (currentsales.value < 0) {
    showAlert("Ventas del mes actual solo acepta numeros positivos", "warning");
    // Verifica si el campo "newclients" está vacío o si no contiene solamente números.
  } else if (newclients.value == "" || /^\d+$/.test(newclients.value) === false) {
    showAlert("Clientes nuevos solo acepta numeros", "warning");
    // Verifica si el campo "newclients" es menor que 0.
  } else if (newclients.value < 0) {
    showAlert("Clientes nuevos solo acepta numeros positivos", "warning");
    // Si todos los campos están correctamente llenados, se envía la petición al servidor.
  } else {
    const formData = new FormData(form);
    // Si la operación es una inserción, se agrega el parámetro "action" con valor "INSERT".
    if (operation === 1) {
      formData.append("action", "INSERT");
    }
    // Se envía la petición al servidor.
    sendPetition("POST", formData);
  }
}

// Función que envía una petición HTTP usando axios, y muestra una alerta dependiendo del resultado de la petición
async function sendPetition(method, params) {
  await axios({ method: method, url: url, data: params })
    .then(function (response) {
      // Obtiene el tipo y mensaje de la respuesta
      var type = response.data[0][0];
      var msg = response.data[0][1];
      // Muestra una alerta con el mensaje y tipo de la respuesta
      showAlert(msg, type);
      // Si el tipo es "success", cierra un modal, resetea un formulario y actualiza el contenido de una sección
      if (type === "success") {
        document.getElementById("btnCerrar").click();
        form.reset();
        getContent();
      } else {
        // Si el tipo no es "success", muestra otra alerta con el mensaje y tipo de la respuesta
        showAlert(msg, type);
      }
    })
    .catch(function (error) {
      // Si hay un error en la petición, muestra una alerta con el mensaje de error
      showAlert("Se presento un error en la solicitud", "error");
      console.log(error);
    });
}

// Función que muestra una alerta de confirmación para eliminar un registro y envía una petición para eliminarlo
function deletePetition(record) {
  Swal.fire({
    title: "¿Seguro de eliminar el registro?",
    icon: "question",
    text: "No se podra recuperar la información",
    showCancelButton: true,
    confirmButtonText: "Sí, eliminar",
    cancelButtonText: "Cancelar",
  }).then((result) => {
    // Crea un objeto FormData con los datos del registro a eliminar y la acción a realizar
    const formData = new FormData();
    if (result.isConfirmed) {
      formData.append("id", record);
      formData.append("action", "DELETE");
      // Envía la petición para eliminar el registro
      sendPetition("POST", formData);
    } else {
      // Si no se confirma la eliminación, muestra una alerta informativa
      showAlert("El registro no fue eliminado", "info");
    }
  });
}

// Función que muestra una alerta con un mensaje y un icono
function showAlert(message, icon) {
  Swal.fire({
    title: message,
    icon: icon,
  });
}

// Se ejecuta cuando se carga el contenido de la página
document.addEventListener("DOMContentLoaded", (event) => {
  getContent();
});
