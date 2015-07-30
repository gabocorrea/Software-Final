/*function getType (val) {
	if (typeof val === 'undefined') return 'undefined';
	if (typeof val === 'object' && !val) return 'null';
	return ({}).toString.call(val).match(/\s([a-zA-Z]+)/)[1].toLowerCase();
}*/

var resultsPerPage = 5;
var currentPage = 1;
var currentQuery = null;
var baseUrl = "http://localhost:80/";
var searchUrl = "search";
var facetUrl = "searchFacets";
var uploadUrl = "docs";
var returnFields = "title filename id author version_number"

var activateClickListener = function (element, f) {
	var ev = $._data(element, 'events');
	if (!(ev && ev.click)) {
		element.click(f);
	}
}

var setPrevButtonListener = function () {
	activateClickListener($("#button-prev"), function () {
		search(currentQuery, currentPage - 1, !viewModel.versionView());
	});
}

var setNextButtonListener = function () {
	activateClickListener($("#button-next"), function () {
		search(currentQuery, currentPage + 1, !viewModel.versionView());
	});
}

var search = function (query, page, lastVersion) {
	viewModel.errorBusqueda("");
	currentPage = page;
	currentQuery = query;
	var start = (page - 1) * resultsPerPage;
	var rows = resultsPerPage;
	//var url = baseUrl + searchUrl + "?q=" + query + "&start=" + start + "&rows=" + rows;
	var url = baseUrl + searchUrl +
	 "?q=" + query + 
	 "&pag=" + page + 
	 "&cant=" + resultsPerPage +
	 "&returnFields=" + returnFields;

	if (!lastVersion) {
		url += "&lastVersion=false";
	}

	//"&prioridades=" + "author:2";
	$.ajax({
  		type: 'GET',
	    url: url,
	    contentType: "application/json",
	    dataType: 'json',
	    success: function (data) {
	    	var res = "";
	    	viewModel.results([]);
	    	viewModel.numFound(data.numFound);
	    	viewModel.elapsedTime(data.elapsedTime / 1000);
	    	viewModel.searched(true);
	    	viewModel.numPage(page);
	    	viewModel.error(false);

	    	if (page > 1) {
	    		viewModel.hasPrevPage(true);
	    	} else {
	    		viewModel.hasPrevPage(false);
	    	}

	    	if (page * resultsPerPage < data.numFound) {
	    		viewModel.hasNextPage(true);
	    	} else {
	    		viewModel.hasNextPage(false);
	    	}

	    	if(data.results !== undefined){
		    	data.results.forEach(function (element) {
		    		viewModel.results.push(new Result(element));
		    	});
		    }

		    if (!lastVersion) {
		    	viewModel.versionView(true);
		    }
		    else {
		    	viewModel.versionView(false);
		    }

		    $('.new-version-btn').click(function () {
				showUploadScreen($(this).data('id'));
			});

			$('.all-versions-btn').click(function () {
				var id = $(this).data('id');
				search('id:"' + id + '"', 1, false);
				viewModel.docId(id);
			});
	    },
	    error: function (response) {
	    	var err = response.responseJSON.error;
	    	viewModel.searched(true);
	    	viewModel.error(true);
        	viewModel.errorBusqueda("ERROR: " + err.message);
    	}
	});
}

var Result = function(jsonResult) {
	this.hasTitle = function () {
		if (jsonResult.title != null) {
			if (jsonResult.title[0].trim().length > 0) {
				return true;
			}
		}
		return false;
	}

	if (this.hasTitle()) {
		this.title = jsonResult.title;
	} else {
		this.title = jsonResult.filename;
	}

	this.author = jsonResult.author;
	this.hasAuthor = function () {
		if(this.author != null)
			return this.author[0].trim() != '';
		else
			return false;
	};
	this.filename = jsonResult.filename;
	this.versionNumber = jsonResult.version_number;
	this.downloadUrl = baseUrl + uploadUrl + "/" + jsonResult.id + "?version=" + this.versionNumber;
	this.fragments = [];
	this.docId = jsonResult.id;
	console.log(jsonResult);
	if(jsonResult.fragments != null)
    	this.fragments = jsonResult.fragments.attr_content;
};

var searchFacets = function () {
	var url = baseUrl + facetUrl +
	 "?facets=author&facets=amidata_escritura";
	$.ajax({
  		type: 'GET',
	    url: url,
	    contentType: "application/json",
	    dataType: 'json',
	    success: function (data) {
	    	var res = "";
	    	viewModel.facetResults([]);

	    	if(data.facets !== undefined){
		    	data.facets.forEach(function (element) {
		    		// for (var p in element) {
		    		// 	alert("prop = " + p + " value = " + element[p]);   
		    		// 	}        
		    		viewModel.facetResults.push(new facetsResult(element));
		    	});
		    }
		}
	});
}

var facetsResult = function(jsonResult, facetName) {
	this.facetArray = {};
	for (var p in jsonResult) {
		this.facetArray[p]=jsonResult[p];  
	}
	console.log(this.facetArray);
};

var getDate = function () {
	var now = new Date();
	var month = (now.getMonth() + 1);               
	var day = now.getDate();
	if(month < 10) 
	    month = "0" + month;
	if(day < 10) 
	    day = "0" + day;
	return now.getFullYear() + '-' + month + '-' + day;
}

var todayDate = getDate();

var viewModel = {
    results: ko.observableArray([]),
    facetResults: ko.observableArray([]),
    numFound: ko.observable(),
    elapsedTime: ko.observable(),
    errorBusqueda: ko.observable(),
    searched: ko.observable(false),
    hasPrevPage: ko.observable(false),
    hasNextPage: ko.observable(false),
    numPage: ko.observable(),
    todayDate: ko.observable(todayDate),
    versionView: ko.observable(false),
    docId: ko.observable(),
    error: ko.observable(false)
};


ko.applyBindings(viewModel);

$(document).ready(function () {

	$("#search-form").submit(function( event ) {
	  	event.preventDefault();
	  	if($("#search-box").val() !== ' '){
		  var query = encodeURIComponent($("#search-box").val());
		  search(query, 1, true);
		}
	  //searchFacets();
	});
	$("#advanced-search-form").submit(function( event ) {
	  event.preventDefault();
	  var query = '';
	  $('#advanced-search-form input').each(function(key, value) {
      	if(this.value !== ''){
      		if(this.id==='search-box')
      			query = query + this.value + ' ';
      		else
				query = query + this.id + ":" + this.value + ' ';
      	}
	  });
	  if(query !== '')
	  	search(query.trim(), 1, true);
	});

});

$.fn.resetForm = function() {
    return this.each(function(){
        this.reset();
    });
}

var showUploadScreen = function (id) {
	$('body').addClass('upload');
	if (id != 0) {
		$('<input>').attr({
		    type: 'hidden',
		    name: 'id',
		    value: id
		}).appendTo('#form-files');
	}
	disableSendButtonIfFilesEmpty($("form input.filestyle"));
};

var hideUploadScreen = function () {
	$('body').removeClass('upload');
	$('.files-notification').text('');
	$('#form-files input[type=hidden]').remove();
}

var showLoading = function () {
	$('body').addClass('loading');
}

var hideLoading = function () {
	$('body').removeClass('loading');
    $('#form-files').resetForm();
}

$('#load-files').click(function () {
	showUploadScreen(0);
});

$("form input.filestyle").change(function () {
	disableSendButtonIfFilesEmpty($(this));
});

var disableSendButtonIfFilesEmpty = function (filesElement) {
	if (filesElement.val() != '') {
		$('#submitbtn').prop('disabled', false);
	} else {
		$('#submitbtn').prop('disabled', true);
	}
}

$('#submitbtn').click(function (e){
	e.preventDefault();
	var form = $('#form-files');
	$('#form-files input').each(function(key, value) {
		if(this.value == ''){
			$(this).attr('disabled', 'true');
		}
	});
	
    var formData = new FormData(form[0]);
    console.log(formData);
    $.ajax({
        url: baseUrl + uploadUrl,
        type: 'POST',
        beforeSend: function () {
        	showLoading();
        },
        success: function (data) {
        	hideLoading();
        	$('.files-notification').text('Los documentos fueron cargados exitosamente');
        	console.log(data);

        },
        error: function (response) {
        	var err = response.responseJSON;
        	alert(err.error.message);
        	console.log(err);
        	hideLoading();
        },
        complete: function(){
        	$('#form-files input').each(function(key, value) {
				$(this).prop('disabled', false);
			});
        },
        data: formData,
        //Options to tell jQuery not to process data or worry about content-type.
        cache: false,
        contentType: false,
        processData: false
    });
});

$("#files-upload-container").click(function (e) {
	if (e.target.id === 'files-upload-container') {
		hideUploadScreen();
	}
});

function ShowNormalSearch(){
	$('#advanced-search-form').css('display', 'none');
	$('#search-form').css('display', 'block');
}

function ShowAdvancedSearch(){
	$('#advanced-search-form').css('display', 'block');
	$('#search-form').css('display', 'none');
}