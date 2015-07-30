var baseUrl = "http://localhost:8080/";

$("#form-delete").submit(function( event ) {
	  event.preventDefault();
	  var id = $('#id').val();
	  delete_by_id(id);
	});

var delete_by_id = function(id) {
	var url = baseUrl + "deleteById?id=" + id;
	$.ajax({
  		type: 'GET',
	    url: url,
	    contentType: "application/json",
	    dataType: 'json',
	    success: function (data) {
	    	alert('deleted');
	    },
	    error: function (error) {
	    	alert('Error. El servidor no responde.')
	    }
	});
}