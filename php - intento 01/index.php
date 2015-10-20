<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
  <title>CHi - Comments Highlighter</title>

  <!-- Latest compiled and minified CSS -->
  <link rel="stylesheet" href="bootstrap/bootstrap.min.css">

  <!-- Optional theme -->
  <link rel="stylesheet" href="bootstrap/bootstrap-theme.min.css">

  <!-- Webpage icon (shows when someone bookmarks the page) -->
  <link rel="shortcut icon" href="favicon.ico" type="image/x-icon"/>

  <script type="text/javascript" src="scripts/jquery-2.1.3.js"></script>
  <script type="text/javascript" src="scripts/keypress.js"></script>
  <script type="text/javascript" src="scripts/spin.js"></script>
  <script type="text/javascript" src="scripts/spin.min.js"></script>
  <script type="text/javascript">
    $(document).ready(function() {
      var listener = new window.keypress.Listener();
      //listener.simple_combo({"keys":"space","prevent_default":true,}, toggleDirectiveField);
      listener.simple_combo("space", function() {toggleDirectiveField();});
      listener.simple_combo("up", function() {previousPhrase(); updateMyLogger();});
      listener.simple_combo("down", function() {nextPhrase(); updateMyLogger();});
      listener.simple_combo("right", function() {nextComment(); updateMyLogger();});
      listener.simple_combo("left", function() {previousComment('start'); updateMyLogger();});
      listener.simple_combo("i", function() {previousPhrase(); updateMyLogger();});
      listener.simple_combo("k", function() {nextPhrase(); updateMyLogger();});
      listener.simple_combo("l", function() {nextComment(); updateMyLogger();});
      listener.simple_combo("j", function() {previousComment('start'); updateMyLogger();});
      listener.simple_combo("w", function() {previousPhrase(); updateMyLogger();});
      listener.simple_combo("s", function() {nextPhrase(); updateMyLogger();});
      listener.simple_combo("d", function() {nextComment(); updateMyLogger();});
      listener.simple_combo("a", function() {previousComment('start'); updateMyLogger();});
      $('#file').on('fileselect', function(event, numFiles, label) {
        $('#file_name').val(label);
      });
    })
  </script>



  <style>
  .btn-file {
    position: relative;
    overflow: hidden;
  }
  .btn-file input[type=file] {
    position: absolute;
    top: 0;
    right: 0;
    min-width: 100%;
    min-height: 100%;
    font-size: 100px;
    text-align: right;
    filter: alpha(opacity=0);
    opacity: 0;
    background: red;
    cursor: inherit;
    display: block;
  }
  input[readonly] {
    background-color: white !important;
    cursor: text !important;
  }
  .tooltip-inner {
    max-width: none;
    white-space: nowrap;
  }

  mark{color:#000;background:#ff0}
  
  .bg-azul{background-color:#A8EFFF}
  .bg-azul > *{background-color:#A8EFFF}
  .bg-azul-selected{background-color:#9AD6E3}
  .bg-azul-selected > *{background-color:#9AD6E3}

  .bg-amarillo{background-color:#F5FF66}
  .bg-amarillo > *{background-color:#F5FF66}
  .bg-amarillo-selected{background-color:#E0DC5C}
  .bg-amarillo-selected > *{background-color:#E0DC5C}

  .bg-gris{background-color:#FAFAFA}
  .bg-gris > *{background-color:#FAFAFA}
  .bg-gris-selected{background-color:#DEDEDE}
  .bg-gris-selected > *{background-color:#DEDEDE}


  .bg-naranjo{background-color:#FFE3B3}
  .bg-naranjo > *{background-color:#FFE3B3}
  .bg-naranjo-selected{background-color:#FFDA99}
  .bg-naranjo-selected > *{background-color:#FFDA99}

  </style>


</head>
<body>

  <div class="container" style="margin-top: 11px;">

	<div class="container center-block">
		
    <div class="row" style="margin-bottom: 5px;" >

  		<div class="col-sm-1">
  		</div>

  		<div class="col-sm-4">
  			<h3 data-toggle="tooltip" data-placement="top" title="Extract all javadoc from files in a folder and subfolders and start tagging comments">New project</h3>
  			<div class="input-group">
  			  
  			  <span class="input-group-btn">  
  			    <span class="btn btn-info btn-file">
  			      Folder <input type="file" id="folderNew" name="folderPost[]" multiple="" directory="" webkitdirectory="" mozdirectory="">
  			    </span>
  			  </span>
  			  <input id='folder_name' type="text" class="form-control" readonly>
  			</div>
  		</div>


  		<div class="col-sm-1 text-center">
  			<img src="fonts/or-small.png">
  		</div>

  		<div class="col-sm-4">
  			<h3 data-toggle="tooltip" data-placement="top" title="Open .csv file from a previously created project">Open project</h3>
  			<div class="input-group">
  			  <span class="input-group-btn">  
  			    <span class="btn btn-info btn-file">
  			      File <input type="file" id="file">
  			    </span>
  			  </span>
  			  <input id='file_name' type="text" class="form-control" readonly>
  			</div>
  		</div>


  		<div class="col-sm-1">
  		</div>

    </div>


    <a id="my_link_for_export_project" style="display:none;"></a>



    <div class="row">
      <div id="uploadsSuccessMsg" class="col-sm-11 text-center">
      </div>
    </div>







  </div>




  </br>









  <div id="spinner" hidden="true" style="position:absolute;left:0;top:0;background: rgba(255,255,255,.5);width:100%;height:100%;"></div>











    <div id="buttons_and_comments" class="container center-block">

	    <div class="container-fluid">
			<div class="row">
				<div class="col-xs-1">
				</div>
				<div class="col-xs-1">
				</div>
				<div class="col-xs-1">
				</div>
				<div class="col-xs-1">
				</div>
				<div class="col-xs-1">
				</div>
				<div class="col-xs-1">
					 
					<button type="button" class="btn btn-default btn-block" onclick="previousPhrase();" data-toggle="tooltip" data-placement="top" title="&#8593 or i or W">
              			<span class="glyphicon glyphicon-triangle-top" aria-hidden="true"></span>
					</button>
				</div>
				<div class="col-xs-1">
				</div>
				<div class="col-xs-1">
				</div>
				<div class="col-xs-1">
				</div>
				<div class="col-xs-1">
				</div>
				<div class="col-xs-1">
				</div>
				<div class="col-xs-1">
				</div>
			</div>
			<div class="row">
				<div class="col-xs-1">
				</div>
				<div class="col-xs-1">
				</div>
				<div class="col-xs-1">
				</div>
				<div class="col-xs-1">
				</div>
				<div class="col-xs-1">
					 
					<button type="button" class="btn btn-default btn-block" onclick="previousComment();" data-toggle="tooltip" data-placement="top" title="&#8592 or J or A">
              			<span class="glyphicon glyphicon-triangle-left" aria-hidden="true"></span>
					</button>
				</div>
				<div class="col-xs-1">
					 
					<button type="button" class="btn btn-default btn-block" onclick="nextPhrase();" data-toggle="tooltip" data-placement="bottom" title="&#8595 or K or S">
              			<span class="glyphicon glyphicon-triangle-bottom" aria-hidden="true"></span>
					</button>
				</div>
				<div class="col-xs-1">
					 
					<button type="button" class="btn btn-default btn-block" onclick="nextComment();" data-toggle="tooltip" data-placement="top" title="&#8594 or L or D">
              			<span class="glyphicon glyphicon-triangle-right" aria-hidden="true"></span>
					</button>
				</div>
				<div class="col-xs-1">
				</div>
				<div class="col-xs-1">
				</div>
				<div class="col-xs-1">
				</div>
				<div class="col-xs-1">
				</div>
				<div class="col-xs-1">
				</div>
			</div>
			<div class="row">
				<div class="col-xs-1">
				</div>
				<div class="col-xs-1">
				</div>
				<div class="col-xs-1">
				</div>
				<div class="col-xs-1">
				</div>
				<div class="col-xs-3">
					 
					<button type="button" class="btn btn-default btn-block" onclick="toggleDirectiveField();" data-toggle="tooltip" data-placement="right" title="(space)">
            			change class
					</button>
				</div>
				<div class="col-xs-1">
				</div>
				<div class="col-xs-1">
				</div>
				<div class="col-xs-1">
				</div>
				<div class="col-xs-1">
				</div>
				<div class="col-xs-1">
				</div>
			</div>




			<div class="row" style="margin-top:5px">
				<div class="col-xs-3">
				</div>
				<div class="col-xs-2" style="text-align:right; padding-right:0">
					<label class="">Comment ID</label>
				</div>
				<div class="col-xs-1" style="padding-left:1;font-weight:bold;">
				    <input id="id_comment" style="width:140%" onchange="changeId();">
				</div>
				<div class="col-xs-1">
					<button type="button" id="go_to_id_button" class="btn btn-default" onclick="changeId();" style="padding-bottom:3px; padding-top:2px" data-toggle="tooltip" data-placement="right" title="(or just press Enter)">
            			go
					</button>
				</div>
				<div class="col-xs-2 text-left">
					<label id="sub_id_comment">Phrase </label>
				</div>
			</div>

		</div>
























		<div class="container-fluid">
			<div class="row">
				<div class="col-xs-2 text-right">
					<label style="margin-top:5px">Type of Comment</label>
				</div>
				<div class="col-xs-2 left-align">
			  		<h5 id="type_comment" class="">_</h5>
				</div>
				<div class="col-xs-7">
				</div>
				<div class="col-xs-1">
				</div>
			</div>


			<div class="row">
				<div class="col-xs-2 text-right" >
					<label style="margin-top:5px">Class</label>
				</div>
				<div class="col-xs-6">
					<h5 id="javaclass_comment" class="">_</h5>
				</div>
				<div class="col-xs-3">
				</div>
				<div class="col-xs-1">
				</div>
			</div>
			

			<div class="row">
				<div class="col-xs-2 text-right">
					<label style="margin-top:5px">Path of File</label>
				</div>
				<div class="col-xs-9">
				  <h5 id="path_comment" class="">_</h5>
				</div>
				<div class="col-xs-1">
				</div>
			</div>

			<p id='mylogger'></p>
		</div>







		<div class="row">
			<div id="comment" class="col-sm-11">
				<pre id="commentPre">
				</pre>
			</div>
			<div class="col-sm-1">
			</div>
		</div>



















		<br>

	<div class="row">
		<div class="col-sm-3">
	  		<button type="button" class="btn btn-default btn-sm btn-block" onclick="showModifications();" data-toggle="tooltip" data-placement="top" title="Show your modifications in .csv format">
	  		  <span id="ShowHideModificationsButtonIcon" class="glyphicon glyphicon-collapse-down" aria-hidden="true"></span>
	  		  Show/Hide Modifications
	  		</button>
		</div>
	    <div class="col-sm-3">
	      <button id="ExportBtn" type="button" class="btn btn-default btn-sm btn-block" onclick="exportProject();" data-toggle="tooltip" data-placement="top" title="Export modifications to <Project Name>-export.csv">
	        <span id="ShowHideModificationsButtonIcon" class="glyphicon glyphicon-download-alt" aria-hidden="true"></span>
	        Export Project
	      </button>
	    </div>
	    <div class="col-sm-3">
	    </div>
		<div class="col-sm-1">
	  		<button type="button" class="btn btn-danger btn-sm" onclick="eraseLocalStorage();" data-toggle="tooltip" data-placement="top" title="All your modifications are forgotten">
	  		  <span class="glyphicon glyphicon-trash" aria-hidden="true"></span>
	  		  Erase all Modifications
	  		</button>
		</div>
		<div class="col-sm-1">
		</div>
		<div class="col-sm-1">
		</div>
	</div>











		<div id="out">
		<pre id="outText">

		</pre>
		</div>






		</br>
		








    </div>


  </div>

















































<script type="text/javascript">

  outHidden = true;
  $("#outText").hide();

  //$('#buttons_and_comments').hide();

  // Check if client's browser version can handle HTML5's Local Storage
  if(typeof(Storage) !== "undefined") {
    ;
  } else {
      alert("Update your Browser or use Google Chrome (Error: HTML5's Local Storage is not supported in this browser version.");
  }

// Global Variables:
  var debug = false;
  var commentsDict = [];
  var lines = [];
  var lines_current_subset = [];
  //var phrases = [];
  var file = null;
  var current_line_pointer = 2;
  var phrase_pointer = 1;
  var previous_comment_lines_subset = undefined;
  var _projectName = undefined;

  var is_directive_setted_values = {};







//  Spinner for loading during AJAX calls:

  var opts = {
    lines: 13 // The number of lines to draw
  , length: 11 // The length of each line
  , width: 15 // The line thickness
  , radius: 36 // The radius of the inner circle
  , scale: 1 // Scales overall size of the spinner
  , corners: 1 // Corner roundness (0..1)
  , color: '#000' // #rgb or #rrggbb or array of colors
  , opacity: 0.1 // Opacity of the lines
  , rotate: 0 // The rotation offset
  , direction: 1 // 1: clockwise, -1: counterclockwise
  , speed: 1 // Rounds per second
  , trail: 58 // Afterglow percentage
  , fps: 20 // Frames per second when using setTimeout() as a fallback for CSS
  , zIndex: 2e9 // The z-index (defaults to 2000000000)
  , className: 'spinner' // The CSS class to assign to the spinner
  , top: '70%' // Top position relative to parent
  , left: '50%' // Left position relative to parent
  , shadow: false // Whether to render a shadow
  , hwaccel: false // Whether to use hardware acceleration
  , position: 'absolute' // Element positioning
  };
  var target = document.getElementById('spinner');
  var spinner = new Spinner(opts).spin(target);
  spinner.stop();

  $(document).ajaxStart(function(){
      $('#spinner').show();
      spinner.spin(target);
  });

  $(document).ajaxStop(function(){
      $('#spinner').hide();
      spinner.stop();
  });










  //Open Project Button: upload file and show file selected in text input (readonly)
  $(document).on('change', '#file', function() {
    var input = $(this),
        numFiles = input.get(0).files ? input.get(0).files.length : 1,
        label = input.val().replace(/\\/g, '/').replace(/.*\//, '');
    input.trigger('fileselect', [numFiles, label]);

    openProjectFromFile( this.files[0] );
  });

  $(document).on('change', '#folderNew', function() {
      

      folderBtn();
  });


  function nextPhrase()
  {
    
    if (phrase_pointer<lines_current_subset.length-1) {
      phrase_pointer += 1;
      updateText();
      updateId();
      updateSubId();
      updateType();
      updatePath();
      updateJavaClass();
    } else {
      nextComment();
    }
  }

  function previousPhrase()
  {
    if (phrase_pointer>1) {
      phrase_pointer -= 1;
      updateText();
      updateId();
      updateSubId();
      updateType();
      updatePath();
      updateJavaClass();
    } else{
      previousComment('end');
    }
  }

  function nextComment()
  {
      
    if (current_line_pointer<lines.length-1) {
      current_line_pointer += lines_current_subset.length;
      calculateCurrentLinesSubset();
      phrase_pointer = 1;
      updateText();
      updateId();
      updateSubId();
      updateType();
      updatePath();
      updateJavaClass();
    }
  }

  function previousComment(offset)
  {
    offset = typeof(offset) !== 'undefined' ? offset : 'start';

    
    if (current_line_pointer>2) {
      
      prevSubset = getPreviousLinesSubset();
      current_line_pointer -= prevSubset.length;
      calculateCurrentLinesSubset();
      if (offset=='start') {
        phrase_pointer=1;
      } else if (offset == 'end') {
        phrase_pointer=lines_current_subset.length-1;
      } else {
        alert('myError: called previousComment() function with an incorrect parameter');
      }
      updateText();
      updateId();
      updateSubId();
      updateType();
      updatePath();
      updateJavaClass();
    }
  }
  function calculateCurrentLinesSubset()
  {
    var current_line_pointer_cpy = current_line_pointer;

    lines_current_subset=[];

    for (var i=1;i<200;i++) { //maximo examinar max 200 lineas para que no exista un loop infinito
      if (current_line_pointer_cpy>=lines.length) {
        break;
      }
      var id = mysplit(lines[current_line_pointer_cpy],',',1)[0];
      
      if ( i>1 && id!=lastId) {
        break;
      }
      var lastId = id;
      lines_current_subset.push(lines[current_line_pointer_cpy]);
      current_line_pointer_cpy++;
    }

  }

  function getPreviousLinesSubset()
  {
    var current_line_pointer_cpy = current_line_pointer;
    previous_comment_lines_subset = [];
    
    for (var i=1; i<200;i++) { //maximo examinar 200 lineas por si llega a haber un loop infinito
      if (current_line_pointer_cpy<=2) {
        if ( i==1 ) {
          console.log('cant go to previous comment because this one is the first one.');
        } else {
          
        }
        break;
      }
      current_line_pointer_cpy--;
      id = mysplit(lines[current_line_pointer_cpy],',',1)[0];

      if ( i>1 && id!=lastId) {
        console.log('break (bueno) with i='+i);
        break;
      }
      lastId = id;
      previous_comment_lines_subset.push(lines[current_line_pointer_cpy]);
    }
    return previous_comment_lines_subset.reverse();
  }


  function updateId()
  {
    var line = mysplit(lines_current_subset[phrase_pointer],',',2);
    showId(line[0]);
  }
  function updateSubId()
  {
    var line = mysplit(lines_current_subset[phrase_pointer],',',2);
    showSubId(line[1]);
  }
  function updateType()
  {
    var line = mysplit(lines_current_subset[phrase_pointer],',',4);
    showType(line[3]);
  }
  function updatePath()
  {
    var line = mysplit(lines_current_subset[phrase_pointer],',',5);
    showPath(line[4]);
  }
  function updateJavaClass()
  {
  	var line = mysplit(lines_current_subset[phrase_pointer],',',5);
  	var path = line[4];

  	// Check if string starts with ./ or ../ or .\ or ..\     if that is the case, ommit those chars and work with the rest of the string
  	if (path.length>1 && path[0]=='.')
  	{
  		path = path.substring(1);
  		if(path.length>1 && path[0]=='.')
  		{
  			path = path.substring(1);
  		}
  		if(path.length>1 && (path[0]=='/' || path[0]=='\\'))
  		{
  			path = path.substring(1);
  		}
  	} else if (path.length>1 && (path[0]=='/' || path[0]=='\\'))
  	{
  		path = path.substring(1);
  	}


  	var split = mysplit(path,'/');
  	if (split.length==1)
  	{
  		split = mysplit(path,'\\');
  	}
  	var s = split[split.length-1];
  	showJavaClass(s);
  }


  function updateText()
  {
    var comment = '';

    
    selected_phrase_dict = {};
    for (var i=1;i<lines_current_subset.length; i++){
      myLineVar = mysplit(lines_current_subset[i],',',3);
      var splitted_line = mysplit(lines_current_subset[i],',',5);

      ss = '';
      is_directive = undefined;
      //: Si existe ha sido modificado, usar ese color. Si no, buscar color en las lineas del archivo
      if(is_directive_setted_values[myLineVar[0]] != undefined && is_directive_setted_values[myLineVar[0]][i] != undefined){
          is_directive = is_directive_setted_values[myLineVar[0]][i];
          ss='if';
      } else {
        is_directive = splitted_line[2];
        ss = 'else';
      }
      if (i==phrase_pointer) {
        //console.log('\n**is_directive('+ss+')='+is_directive+'\n');
      }

      if (i==phrase_pointer){
        selected_phrase_dict[''+i] = '-selected';
      } else {
        selected_phrase_dict[''+i] = '';
      }


      // take substring from the first " to the last "
      var phrase = splitted_line[5];
      var start = phrase.indexOf('"');
      if (start==-1){
        start = 0;
      }
      var end = phrase.lastIndexOf('"');
      if (end==-1){
        end = prase.length;
      }
      phrase = splitted_line[5].substring(start+1,end);

      if (is_directive == '0') {
        comment += '<span class="inline bg-gris'+selected_phrase_dict[''+i]+'">'+phrase+'</span>';
      } else if (is_directive == '1') {
        comment += '<span class="inline bg-amarillo'+selected_phrase_dict[''+i]+'">'+phrase+'</span>';
      } else if (is_directive == '2') {
        comment += '<span class="inline bg-azul'+selected_phrase_dict[''+i]+'">'+phrase+'</span>';
      } else if (is_directive == '3') {
        comment += '<span class="inline bg-naranjo'+selected_phrase_dict[''+i]+'">'+phrase+'</span>';
      } else {
        console.error('myError: se leyó una directiva distinta a {0,1,2}');
        return;
      }
      if (i!=phrase_pointer) {
       
        
      }

    }
    showText(comment);
  }
  function updateMyLogger()
  {
    if (debug) {
      $('#mylogger').show();
      var s = '';
      s += 'current line pointer:'+current_line_pointer;
      s += '<br>phrase pointer:'+phrase_pointer;
      s += '<br>length of current subset of lines:'+lines_current_subset.length;
      showLog(s);
    } else {
      $('#mylogger').hide();
    }
  }


  function yes()
  {
    

    ////wrong call to .split (call mysplit) localStorage.setItem(""+current_line_pointer, lines[current_line_pointer].split(',',1)[0]+",1\n");
  }

  function no()
  {
    

    ////wrong call to .split (call mysplit) localStorage.setItem(""+current_line_pointer, lines[current_line_pointer].split(',',1)[0]+",0\n");
  }
  function toggleDirectiveField()
  {
    

    myLineVar = mysplit(lines[current_line_pointer+phrase_pointer],',',3);

    var aNumberStr;
    if (is_directive_setted_values[myLineVar[0]] == undefined) {
      is_directive_setted_values[myLineVar[0]] = {};
      console.log("reset of dictionary");
    }
    if ( is_directive_setted_values[myLineVar[0]][phrase_pointer] == undefined ) {
      aNumberStr = myLineVar[2];
      //TODO: aca sería deseable chequear que is_directive tiene el formato de numero.. y no fue leido mal del archivo
      console.log('(if) - is_directive='+is_directive);
    } else {
      aNumberStr = is_directive_setted_values[myLineVar[0]][phrase_pointer];
      console.log('(else) - is_directive='+is_directive);
    }
    var is_directive = ''+aNumberStr;
    

    if (is_directive == '0') {
      is_directive_setted_values[myLineVar[0]][phrase_pointer] = '1'
      console.log("phrase set to 1 (directive)\n");
    } else if (is_directive == '1') {
      is_directive_setted_values[myLineVar[0]][phrase_pointer] = '3'
      console.log("phrase set to 3 (comment-with-null)\n");
    } else if (is_directive == '2') {
      is_directive_setted_values[myLineVar[0]][phrase_pointer] = '0'
      console.log("phrase set to 0 (non-directive)\n");
    } else if (is_directive == '3') {
      is_directive_setted_values[myLineVar[0]][phrase_pointer] = '2'
      console.log("phrase set to 2 (revise-later)\n");
    } else {
      console.error("esto no deberia pasar, is_directive="+is_directive);
    }
    localStorage.setItem(''+myLineVar[0], JSON.stringify(is_directive_setted_values[myLineVar[0]]));
    updateText();
  }

  function populateDirectiveSettedValuesDictionary(){
    for (key in localStorage) {
      var s = JSON.parse(localStorage.getItem( key ));

      if (typeof(s) != 'object') {
        console.info('myInfo! found element in localStorage that isnt an object - skipping it');
      } else {
        is_directive_setted_values[key] = {};
        for (key_2 in s) {
          is_directive_setted_values[key][key_2] = s[key_2];
        }
      }
    }
    
  }
  function eraseLocalStorage(){
    

    var ans = confirm('Are you sure?');
    if (ans) {
      console.log('\n-------- localStorage before being erased: ---------');
      for (key in localStorage){
        console.log(key+':'+localStorage[key]);
      }
      if (Object.keys(localStorage).length<1){
        console.log('((( localStorage is empty )))');
      }

      localStorage.clear();
      
      console.log('\n\n-------- localStorage after being erased: ---------');
      for (key in localStorage){
        console.log(key+':'+localStorage[key]);
      }
      if (Object.keys(localStorage).length<1){
        console.log('((( localStorage is empty )))');
      }  
    }
    
  }

  function changeId(){
    

    theValue = $('#id_comment').val();
    splittedArray = mysplit(theValue,'-',1);

    idMain = splittedArray[0];
    
    idMain_int = parseInt(idMain);
    if (!isNaN(idMain_int)) {

      if (idMain_int>0 && idMain_int<lines.length-1) {
        
        if ( parseInt(mysplit(lines[current_line_pointer],',',1)[0]) <=idMain_int) {
          
          for (var i=current_line_pointer; i<lines.length-1;i++) {

            
            id = mysplit(lines[i],',',1)[0];
            id_int = parseInt(id);
            if (isNaN(id_int)){
              console.error('found an id in the file that is not an int at i='+i);
              return;
            } //else:
            if (id_int==idMain_int) {
              console.log('el idMain fue encontrado');
              current_line_pointer = i;
              break;
            }
            
          }
        } else {
          for (var i=current_line_pointer; i>1;i--) {

            id = mysplit(lines[i],',',1)[0];
            id_int = parseInt(id);
            if (isNaN(id_int)){
              console.error('found an id in the file that is not an int at i='+i);
              return;
            } //else:
            if (id_int==idMain_int) {
              lastId = undefined;
              stop = undefined;
              console.log('el idMain fue encontrado');
              for (var j=i; j>1;j--){
                console.log(j);
                id = mysplit(lines[j],',',1)[0];
                id_int = parseInt(id);
                if (lastId!=undefined && lastId!=id_int){
                  current_line_pointer = j+1;
                  stop = true;
                  break;
                }
                lastId = id_int;

              }
              if (stop) { break; }
            }
            
          }
        }
        console.log('loop finished_________');
        calculateCurrentLinesSubset();
        phrase_pointer = 1;
        updateText();
        updateId();
        updateSubId();
        updateType();
        updatePath();
        updateJavaClass();
        updateMyLogger();


      } else {
        console.log('!   id entered is out of range   !');
      }
    } else {
      console.log('!   invalid id entered   !');
      return;
    }
  }












  //jquery
  jQuery(document).ready(function($) {

    window.showText = function(str)
    {
      
      ////// Last version: splitted_line[5].replace(/<[^>]+>/g,'') //esto es para ignorar todos los tags
      str = str.replace(/<\/?p>/g,'');
      str = str.replace(/<\/?ul>/g,'');
      str = str.replace(/<\/?dl>/g,'');

      str = str.replace(/<\/?ol>/g,'');//esto no he testeado como se ve aun en la pagina

      str = str.replace(/\\n/g,'<br>');
      html = $.parseHTML( str );

      // Append the parsed HTML
      $("#commentPre").empty();
      $("#commentPre").append(html);
 
    };

    window.showId = function(str)
    {
      


      $("#id_comment").val( str );
 
    }
    window.showSubId = function(str)
    {
      

      $("#sub_id_comment").empty();
      $("#sub_id_comment").append( "Phrase "+str );
 
    }
    window.showType = function(str)
    {
      

      $("#type_comment").empty();
      $("#type_comment").append( str );
 
    }
    window.showPath = function(str)
    {
      

      $("#path_comment").empty();
      $("#path_comment").append( str );
 
    }
    window.showJavaClass = function(str)
    {
    	

    	$("#javaclass_comment").empty();
    	$("#javaclass_comment").append(str)
    }

    window.showLog = function(str)
    {
      $('#mylogger').empty();
      $('#mylogger').append( "<br></br><h5><u>debugging log:</u></h5>"+ str);
    }

    // newProject.php has calls to important python scripts.
    window.callNewProjectPHP = function(projectName)
    {
      var formdata = new FormData();

      formdata.append('exportString',localStorage2ExportString());
      formdata.append('projectName',projectName);

      $.ajax({
        url: "newProject.php",
        data: formdata,
        contentType: false,
        processData: false,
        type: "POST",
        dataType: "json",
        success: function(data){
          console.info("success! returned from newProject.php");
          $('#uploadsSuccessMsg').append(data); //this show a Log, on the body of the page, of what happened after de AJAX call
          //TODO: llamar a subir el archivo
          //var csvfile = data["csvfile"];
          _projectName = projectName;


          // open file to show comments in the webpage
          var fileToOpen = $.get("./projects/"+_projectName+"/CHi-files/project.csv", function() {
            showComments(fileToOpen.responseText);
          });
          
        }
      });//END AJAX
    }

    window.folderBtn = function()
    {
      var fileInput = $('#folderNew')[0];
      var formdata = new FormData();

      for(var i = 0; i < fileInput.files.length; ++i){
          formdata.append('folderPost[]',fileInput.files[i]);
          formdata.append('folderPostFullDirectory[]',fileInput.files[i].webkitRelativePath);
      }

      $.ajax({
        url: "uploadFolder.php", //if url is not set, then we are sending data to this same file
        data: formdata,
        contentType: false,
        processData: false,
        method: "POST",
        dataType: "json",
        success: function(data){
          console.info("success! returned from uploadFolder.php");
          var success = data["success"];
          var successMsg = data["successMsg"];
          if (success == 0)
          {
            //TODO: make a progress bar
          } else {
            $('#uploadsSuccessMsg').append(successMsg);
          }
          

          var projectName = data["projectName"];
          callNewProjectPHP(projectName);
          $("#ExportBtn")[0].attributes["data-original-title"].nodeValue = "Export modifications to "+projectName+"-export.csv"; //show project name in tooltip of ExportBtn

          var numUploadedFiles = data["uploadedFilesCount"]; //TODO: show this number somewhere on the webpage (maybe)




          console.debug(data["debug"]);
          
        }
      });//END AJAX
    }



    window.uploadFilePHP = function()
    {
      // upload file to update server copy of that file (this is needed by some python scripts of the webpage running in the server)
      var formdata = new FormData();
      

      $.ajax({
        url: "uploadFile.php", //if url is not set, then we are sending data to this same file
        data: formdata,
        contentType: false,
        processData: false,
        method: "POST",
        dataType: "json",
        success: function(data){
          console.info("success! returned from uploadFile.php");
          var success = data["success"];
          var successMsg = data["successMsg"];
          if (success == 0)
          {
            //TODO: make a progress bar
          } else {
            $('#uploadsSuccessMsg').append(successMsg);
          }
          var projectName = $('#file')[0].files[0].name;          
          $("#ExportBtn")[0].attributes["data-original-title"].nodeValue = "Export modifications to "+projectName+"-export.csv"; //show project name in tooltip of ExportBtn

          _projectName = projectName;
        }
      });//END AJAX


    }

    window.showComments = function(fileContents)
    {
      // save lines to a global variable
      var s_temp = 'dummy_line\n'+fileContents;
      lines = s_temp.split('\n');
      calculateCurrentLinesSubset();
      updateText();
      updateId();
      updateSubId();
      updateType();
      updatePath();
      updateJavaClass();
      updateMyLogger();
      populateDirectiveSettedValuesDictionary();

      $('#buttons_and_comments').show();
    }

    window.openProjectFromFile = function(aFile)
    {
      var reader = new FileReader();
      reader.onload = function(progressEvent){
        uploadFilePHP();
        showComments( this.result );
      };
      reader.readAsText(aFile);
    }










	$("#id_comment").keyup(function(event){
	    if(event.keyCode == 13){
	        $("#go_to_id_button").click();
	    }
	});


  });





  function exportProject() {
      var formdata = new FormData();

      formdata.append('exportString',localStorage2ExportString());
      if (_projectName != undefined) {
        formdata.append('projectName',_projectName);
      } else {
        console.info("MyError: global variable _projectName is undefined");
      }

      $.ajax({
        url: "export.php",
        data: formdata,
        contentType: false,
        processData: false,
        type: "POST",
        dataType: "json",
        success: function(data){
          console.info("success! returned from export.php");
          //$('#TODO').append(data); //this show a Log, on the body of the page, of what happened after de AJAX call
          //var csvfile = data["csvfile"];
          
          var link_download = $("#my_link_for_export_project")[0];

          link_download.download = _projectName+".csv";
          link_download.href = "projects/"+_projectName+"/CHi-files/project.csv";
          link_download.click();


        }
      });//End AJAX
  }
































  function mysplit(aString, aChar, maxSplit) {
      var aStringCpy = aString.slice(0);
      var arr = [];
      var j=-1;

      if (maxSplit==undefined)
      {
      	maxSplit=aStringCpy.length-1;
      }
      for (var n=0; n<=maxSplit; n++) {
          aStringCpy = aStringCpy.slice(j+1)
          if (n==maxSplit) {
              arr.push(aStringCpy.slice(0));
              break;
          }
          j = aStringCpy.indexOf(aChar);
          if (j!=-1){
            arr.push(aStringCpy.slice(0,j));
          } else {
            arr.push(aStringCpy.slice(0));
            break;
          }
      
      }
      return arr;
  }



  function help(){
    console.log("______________\nhelp:\n\n"
      +"mydebug() : fixes the button Toggle Export Data (it may stop working because of an internal error with the localStorage\n");
  }
  function mydebug(){fixToggleExportData();}
  //fixes the InternalDataElementWasNotAnObject error seen in console sometimes
  function fixToggleExportData(){
    myflag=true;
    
    for (key in localStorage){
      if (typeof(localStorage[key]) != 'string') {
        console.error("myError: localStorage["+key+"] has type "+ typeof(localStorage[key]));
        myflag = false;

      }
      
      try{
        myobj=JSON.parse(localStorage[key]);
      } catch(err) {
        console.log(err.message+" (at "+key+") ... (deleting key)");
        localStorage.removeItem(key);
      }
    }
    if (myflag){
      console.log("myMsg: no errors found in localStorage");
    }
  }

  function localStorage2ExportString(){
    ret = 'id,id_sub,is_directive\n';
    if (Object.keys(localStorage).length>0) {
      for (key in localStorage){
        try{
          obj = JSON.parse(localStorage[key]);
        } catch(err){
          console.error("catched error: "+err.message);
          console.error("myError: JSON.parse tried to parse: "+localStorage[key]);
        }
        
        if (typeof(obj) != 'object') {
          console.info("myInfo: an internal data element was not an object -> localStorage["+key+"]=="+localStorage[key]);
        }
        else {
          s='';
          for (key_2 in obj) {
            s += key+','+key_2+','+obj[key_2] + '\n';
          }
          ret += s;
        }
      }
    } else {
      ret = 'No modifications yet';
    }
    return ret;
  }



  function showModifications() {
      if (outHidden) {
        $("#outText").empty();
        $("#outText").append( localStorage2ExportString() );
        $('#outText').show();
        outHidden = false;
		$("#ShowHideModificationsButtonIcon").addClass('glyphicon-collapse-up').removeClass('glyphicon-collapse-down');
      } else {
        $('#outText').hide();
        outHidden = true;
		$("#ShowHideModificationsButtonIcon").addClass('glyphicon-collapse-down').removeClass('glyphicon-collapse-up');
      }
  }

  function increase_brightness(hex, percent){
      // strip the leading # if it's there
      hex = hex.replace(/^\s*#|\s*$/g, '');

      // convert 3 char codes --> 6, e.g. `E0F` --> `EE00FF`
      if(hex.length == 3){
          hex = hex.replace(/(.)/g, '$1$1');
      }

      var r = parseInt(hex.substr(0, 2), 16),
          g = parseInt(hex.substr(2, 2), 16),
          b = parseInt(hex.substr(4, 2), 16);

      return '#' +
         ((0|(1<<8) + r + (256 - r) * percent / 100).toString(16)).substr(1) +
         ((0|(1<<8) + g + (256 - g) * percent / 100).toString(16)).substr(1) +
         ((0|(1<<8) + b + (256 - b) * percent / 100).toString(16)).substr(1);
  }










    $(function () { //enables pretty tooltips from bootstrap
      $('[data-toggle="tooltip"]').tooltip();
    })


  </script>



  <!-- [Bootstrap] Latest compiled and minified JavaScript -->
  <script src="bootstrap/bootstrap.min.js"></script> 

</body>
</html>