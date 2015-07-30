var baseUrl = "http://localhost:8080/";

$("#form-update").submit(function( event ) {
	  event.preventDefault();
	  var id = $('#id').val();
	  var campo = $('#campo').val();
	  var valor = $('#valor').val();
	  update(id, campo, valor);
	});

var update = function(id, campo, valor) {
	var a = {};
	a[campo] = valor;
	updateFields(id, "set", a);
}

var updateFields = function (id, metodo, campos) {
	var url = baseUrl + "update";
	var fields = campos;
	fields.id = id;
	fields.metodo = metodo;
	$.ajax({
		type: 'POST',
		url: url,
		data: fields,
		success: function (response) {
			alert('updated');
		},
		error: function (error) {
			alert(error.responseJSON.error.message);
			console.log(error.responseJSON);
		}
	});
}

var updateMultiple2 = function(id, valor, campo) {
	var url = baseUrl + "updateMultiple";
	var id="bc5e3235-4839-489c-bc95-c776042fd893";
	var metodo = "set";
	var campos = {};
	campos["amidata_cosas"] = "logat";
	$.ajax({
  		type: 'POST',
	    url: url,
	    //contentType: "application/json",
	    data: {"id":id, "metodo":metodo, "campos": JSON.stringify(campos)},
	    dataType: 'json',
	    success: function (data) {
	    	alert('updated');
	    },
	    error: function (error) {
	    	alert('Error. El servidor no responde.')
	    }
	});
}
