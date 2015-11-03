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
      listener.simple_combo("up", function() {previousPhrase();});
      listener.simple_combo("down", function() {nextPhrase();});
      listener.simple_combo("right", function() {nextComment();});
      listener.simple_combo("left", function() {previousComment('start');});
      listener.simple_combo("i", function() {previousPhrase();});
      listener.simple_combo("k", function() {nextPhrase();});
      listener.simple_combo("l", function() {nextComment();});
      listener.simple_combo("j", function() {previousComment('start');});
      listener.simple_combo("w", function() {previousPhrase();});
      listener.simple_combo("s", function() {nextPhrase();});
      listener.simple_combo("d", function() {nextComment();});
      listener.simple_combo("a", function() {previousComment('start');});
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

  <div id="CompatibilityMsg" style="display:none;" class="alert alert-danger" role="alert">
    <span class="glyphicon glyphicon-exclamation-sign" aria-hidden="true"></span>
    <span class="sr-only">Error:</span>
    Please use a browser that supports LocalStorage.
  </div>


  <div class="container" style="margin-top: 11px;" style="display:none;">

  <div id="ProjectNameLabel" class="container center-block">
    

  </div>

  <div id="upperButtonsContainer" class="container center-block text-center" >
    
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
    <a id="my_link_for_export_weka_file" style="display:none;"></a>


<!-- 
    <div class="row">
      <div id="uploadsSuccessMsg" class="col-sm-11 text-center">
      </div>
    </div> -->
    <div id="ajaxCallbackUploadFolder" style="display:none;" class="row col-sm-11 alert alert-danger" role="alert">
      <span class="glyphicon glyphicon-exclamation-sign" aria-hidden="true"></span>
      <span class="sr-only">Error:</span>
    </div>
    <div id="ajaxCallbackUploadFile" style="display:none;" class="row col-sm-11 alert alert-danger" role="alert">
      <span class="glyphicon glyphicon-exclamation-sign" aria-hidden="true"></span>
      <span class="sr-only">Error:</span>
    </div>
    <div id="ajaxCallbackNewProject" style="display:none;" class="row col-sm-11 alert alert-danger" role="alert">
      <span class="glyphicon glyphicon-exclamation-sign" aria-hidden="true"></span>
      <span class="sr-only">Error:</span>
    </div>
    <div id="ajaxCallbackExportProject" style="display:none;" class="row col-sm-11 alert alert-danger" role="alert">
      <span class="glyphicon glyphicon-exclamation-sign" aria-hidden="true"></span>
      <span class="sr-only">Error:</span>
    </div>
    <div id="ajaxCallbackExportWekaFile" style="display:none;" class="row col-sm-11 alert alert-danger" role="alert">
      <span class="glyphicon glyphicon-exclamation-sign" aria-hidden="true"></span>
      <span class="sr-only">Error:</span>
    </div>
    <div id="alertThatProjectHasSavedDataInLocalStorage" style="display:none;" class="row col-sm-11 alert alert-info">
      <span class="glyphicon glyphicon-exclamation-sign" aria-hidden="true"></span>
      <span class="sr-only">Info:</span>
      <a href="#" class="close" data-dismiss="alert" aria-label="close" title="close">×</a>
      Previous modifications made to this project have been detected and loaded.
    </div>


  </div>




  </br>









  <div id="spinner" hidden="true" style="position:absolute;left:0;top:0;background: rgba(255,255,255,.5);width:100%;height:100%;"></div>











    <div id="buttons_and_comments" class="container center-block" style="display:none">

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
        <div class="col-xs-1" style="padding:0 0 0 0">
           
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
        <div class="col-xs-1" style="padding:0 0 0 0">
           
          <button type="button" class="btn btn-default btn-block" onclick="previousComment();" data-toggle="tooltip" data-placement="top" title="&#8592 or J or A">
                    <span class="glyphicon glyphicon-triangle-left" aria-hidden="true"></span>
          </button>
        </div>
        <div class="col-xs-1" style="padding:0 0 0 0">
           
          <button type="button" class="btn btn-default btn-block" onclick="nextPhrase();" data-toggle="tooltip" data-placement="bottom" title="&#8595 or K or S">
                    <span class="glyphicon glyphicon-triangle-bottom" aria-hidden="true"></span>
          </button>
        </div>
        <div class="col-xs-1" style="padding:0 0 0 0">
           
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
        <div class="col-xs-3" style="padding:0 0 0 0">
           
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
        <div class="col-xs-1" style="padding-left:6px; padding-right:3px; font-weight:bold;">
            <input id="id_comment" style="width:100%" onchange="changeId();">
        </div>
        <div class="col-xs-1" style="padding-bottom:3px; padding-top:2px; padding-left:0px">
          <label id="id_comment_total">/maxID</label>
        </div>
        <div class="col-xs-2 text-left">
          <label id="sub_id_comment" style="padding-bottom:3px; padding-top:2px; padding-left:0px">Phrase </label>
        </div>
        <div class="col-xs-2">
        <div class="col-xs-3">
        </div>
        </div>
      </div>

    </div>
























    <div class="container-fluid">

      <div class="row">
        <div class="col-xs-2 text-right" >
          <label style="margin-top:5px">Java Class</label>
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
          <span id="ShowHideModificationsLabel">Show Modifications</span>
        </button>
    </div>
      <div class="col-sm-3">
        <button type="button" class="btn btn-default btn-sm btn-block" onclick="exportProject();" data-toggle="tooltip" data-placement="top" title="Save your modifications by downloading your project">
          <span id="exportButtonIcon" class="glyphicon glyphicon-download-alt" aria-hidden="true"></span>
          Save Project
        </button>
      </div>
      <div class="col-sm-3">
        <button type="button" class="btn btn-default btn-sm btn-block" onclick="wekaExport();" data-toggle="tooltip" data-placement="top" title="Download a file that can be used in Weka for Text Mining">
          <span id="exportButtonIcon" class="glyphicon glyphicon-download-alt" aria-hidden="true"></span>
          Weka Export
        </button>
      </div>
    <div class="col-sm-1">
        <button type="button" class="btn btn-danger btn-sm" onclick="eraseLocalStorage();" data-toggle="tooltip" data-placement="top" title="All your project's modifications are forgotten">
          <span class="glyphicon glyphicon-trash" aria-hidden="true"></span>
          Erase Modifications
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

// Global Variables:
  var debug = false;
  var commentsDict = [];
  var lines = [];
  var lines_current_subset = [];
  //var phrases = [];
  var file = null;
  var current_line_pointer = 1;//a pointer to a line in the project file that is being read
  var phrase_pointer = 1;
  var previous_comment_lines_subset = undefined;
  var _projectName = undefined;

  var is_directive_setted_values = {};






//  Spinner for loading during AJAX calls:

  var opts = {
    lines: 15 // The number of lines to draw
  , length: 3 // The length of each line
  , width: 2 // The line thickness
  , radius: 18 // The radius of the inner circle
  , scale: 1 // Scales overall size of the spinner
  , corners: 0 // Corner roundness (0..1)
  , color: '#000' // #rgb or #rrggbb or array of colors
  , opacity: 0.25 // Opacity of the lines
  , rotate: 0 // The rotation offset
  , direction: 1 // 1: clockwise, -1: counterclockwise
  , speed: 1 // Rounds per second
  , trail: 60 // Afterglow percentage
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





  // Check if LocalStorage is available
  if(typeof(Storage) === "undefined" || localStorage === null || localStorage === undefined) {
    document.getElementById("CompatibilityMsg").style.visibility = "visible";
    document.getElementById("folderNew").disabled = true;
    document.getElementById("file").disabled = true;
  } else {
    // we are cool
  }







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
    console.log("nextPhrase");
    if (phrase_pointer<lines_current_subset.length) {
      phrase_pointer += 1;
      updateText();
      updateId();
      updateSubId();
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
      updatePath();
      updateJavaClass();
    } else{
      previousComment('end');
    }
  }

  function nextComment()
  {
    console.log("nextComment");
    if (current_line_pointer<lines.length-1) {
      current_line_pointer += lines_current_subset.length;
      calculateCurrentLinesSubset();
      phrase_pointer = 1;
      updateText();
      updateId();
      updateSubId();
      updatePath();
      updateJavaClass();
    }
  }

  function previousComment(offset)
  {
    offset = typeof(offset) !== 'undefined' ? offset : 'start';

    
    if (current_line_pointer>=2) {
      
      prevSubset = getPreviousLinesSubset();
      current_line_pointer -= prevSubset.length;
      calculateCurrentLinesSubset();
      if (offset=='start') {
        phrase_pointer=1;
      } else if (offset == 'end') {
        console.log("previousComment 001")
        phrase_pointer=lines_current_subset.length;
      } else {
        alert('myError: called previousComment() function with an incorrect parameter');
      }
      updateText();
      updateId();
      updateSubId();
      updatePath();
      updateJavaClass();
    }
  }

  // Agrega las frases del comentario actual (id actual) a un arreglo global.
  function calculateCurrentLinesSubset()
  {
    console.log("calculateCurrentLinesSubset");
    var current_line_pointer_cpy = current_line_pointer;

    lines_current_subset=[];

    for (var i=1;i<5000;i++) { //maximo examinar max 5000 lineas (ojo: hay un break adentro del loop) para que no exista un loop infinito (se asume que un comentario no tiene tantas frases)
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
    console.log("calculateCurrentLinesSubset end");
  }

  function getPreviousLinesSubset()
  {
    var current_line_pointer_cpy = current_line_pointer;
    previous_comment_lines_subset = [];
    
    for (var i=1; i<5000;i++) { //maximo examinar 5000 lineas (ojo: hay un break adentro del loop) por si llega a haber un loop infinito
      if (current_line_pointer_cpy<=1) {
        if ( i==1 ) {
          console.info('cant go to previous comment because this one is the first one.');
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
    var line = mysplit(lines_current_subset[phrase_pointer-1],',',2);
    showId(line[0]);
  }
  function updateSubId()
  {
    var line = mysplit(lines_current_subset[phrase_pointer-1],',',2);
    showSubId(line[1]);
  }
  function updatePath()
  {
    var line = mysplit(lines_current_subset[phrase_pointer-1],',',5);
    showPath(line[4]);
  }
  function updateJavaClass()
  {
    console.log("updateJavaClass");
    var line = mysplit(lines_current_subset[phrase_pointer-1],',',5);
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
    console.log("updateJavaClass end");
  }


  function updateText()
  {
    console.log("updateText()");
    var comment = '';

    
    selected_phrase_dict = {};
    for (var i=1;i<=lines_current_subset.length; i++){
      var splitted_line = mysplit(lines_current_subset[i-1],',',5);
      var lineId = splitted_line[0];
      var lineSubId = splitted_line[1];
      var lineClass = splitted_line[2];
      var lineType = splitted_line[3];
      var linePath = splitted_line[4];
      var lineText = splitted_line[5];

      is_directive = undefined;
      //: Si ya ha sido modificado, entonces usar ese color. Si no, buscar color en las lineas del archivo
      if(is_directive_setted_values[lineId] != undefined && is_directive_setted_values[lineId][i] != undefined){
          is_directive = is_directive_setted_values[lineId][i];
      } else {
        is_directive = lineClass;
      }

      if (i==phrase_pointer){
        selected_phrase_dict[''+i] = '-selected';
      } else {
        selected_phrase_dict[''+i] = '';
      }


      // take substring from the first " to the last "
      var start = lineText.indexOf('"');
      if (start==-1){
        start = 0;
      }
      var end = lineText.lastIndexOf('"');
      if (end==-1){
        end = lineText.length;
      }
      lineText = lineText.substring(start+1,end);

      if (is_directive == '0') {
        comment += '<span class="inline bg-gris'+selected_phrase_dict[''+i]+'">'+lineText+'</span>';
      } else if (is_directive == '1') {
        comment += '<span class="inline bg-amarillo'+selected_phrase_dict[''+i]+'">'+lineText+'</span>';
      } else if (is_directive == '2') {
        comment += '<span class="inline bg-azul'+selected_phrase_dict[''+i]+'">'+lineText+'</span>';
      } else if (is_directive == '3') {
        comment += '<span class="inline bg-naranjo'+selected_phrase_dict[''+i]+'">'+lineText+'</span>';
      } else {
        console.error('myError: se leyó una clase de comentario con numero '+is_directive+' el cual no existe');
        return;
      }

    }
    showText(comment);

    console.log("updateText() end");
  }


  function toggleDirectiveField()
  {
    myLineVar = mysplit(lines[current_line_pointer+phrase_pointer-1],',',3);

    var aNumberStr;
    if (is_directive_setted_values[myLineVar[0]] == undefined) {
      is_directive_setted_values[myLineVar[0]] = {};
    }
    if ( is_directive_setted_values[myLineVar[0]][phrase_pointer] == undefined ) {
      aNumberStr = myLineVar[2];
      //TODO: aca sería deseable chequear que is_directive tiene el formato de numero.. y no fue leido mal del archivo
    } else {
      aNumberStr = is_directive_setted_values[myLineVar[0]][phrase_pointer];
    }
    var is_directive = ''+aNumberStr;
    

    if (is_directive == '0') {
      is_directive_setted_values[myLineVar[0]][phrase_pointer] = '1'
    } else if (is_directive == '1') {
      is_directive_setted_values[myLineVar[0]][phrase_pointer] = '3'
    } else if (is_directive == '2') {
      is_directive_setted_values[myLineVar[0]][phrase_pointer] = '0'
    } else if (is_directive == '3') {
      is_directive_setted_values[myLineVar[0]][phrase_pointer] = '2'
    } else {
      console.error("esto no deberia pasar, is_directive="+is_directive);
    }
    myAddItemToLocalStorage(myLineVar[0], phrase_pointer, is_directive_setted_values[myLineVar[0]][phrase_pointer]);

    updateText();
  }

  function populateDirectiveSettedValuesDictionary(){
    var ids = JSON.parse( localStorage.getItem(_projectName) );
    for (key in ids) {
      var phrases = ids[key];

      if (typeof(phrases) != 'object') {
        console.info('myInfo! found element in localStorage that isnt an object - skipping it');
      } else {
        is_directive_setted_values[key] = {};
        for (key_2 in phrases) {
          is_directive_setted_values[key][key_2] = phrases[key_2];
        }
      }
    }
    
  }


  function eraseLocalStorage(){
    var ans = confirm('Are you sure you want to erase the modifications done to the project '+_projectName+'?');
    if (ans) {

      var ids = JSON.parse( localStorage.getItem(_projectName) );

      console.log('\n-------- localStorage for this project  before being erased: ---------');
      for (key in ids){
        console.log(key+':'+ids[key]);
      }
      if (Object.keys(ids).length<1){
        console.log('((( localStorage for this project is empty )))');
      }

      localStorage.removeItem(_projectName);
      
      console.log('\n\n-------- localStorage for this project after being erased: ---------');
      for (key in ids){
        console.log(key+':'+ids[key]);
      }
      if (Object.keys(ids).length<1){
        console.log('((( localStorage for this project is empty )))');
      }
    }
  }

  function changeId(){
    

    theValue = $('#id_comment').val();
    
    idMain_int = parseInt(theValue);
    if (!isNaN(idMain_int)) {

      if (idMain_int>0 && idMain_int<lines.length-1) {
        if ( parseInt(mysplit(lines[current_line_pointer],',',1)[0]) == idMain_int ) {
          //do nothing, same id entered as the current id
        }
        else if ( parseInt(mysplit(lines[current_line_pointer],',',1)[0]) < idMain_int) {
          
          for (var i=current_line_pointer; i<lines.length-1;i++) {

            
            id = mysplit(lines[i],',',1)[0];
            id_int = parseInt(id);
            if (isNaN(id_int)){
              console.error('found an id in the file that is not an int at i='+i);
              return;
            } //else:
            if (id_int==idMain_int) {
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
        calculateCurrentLinesSubset();
        phrase_pointer = 1;
        updateText();
        updateId();
        updateSubId();
        updatePath();
        updateJavaClass();


      } else { // else, if number is not in a valid range
        console.log('!   id entered is out of range. do nothing   !');
      }
    } else { //else, if id value entered by user is not a number
      console.log('!   invalid id entered. do nothing   !');
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
      $("#id_comment_total").empty();
      $("#id_comment_total").append( "/"+mysplit(lines[lines.length-2],',',2)[0] );

 
    }
    window.showSubId = function(str)
    {
      

      $("#sub_id_comment").empty();
      $("#sub_id_comment").append( "Phrase "+str );
 
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

          var success = data["success"];
          var successMsg = data["successMsg"];
          if (success != 0){
            console.error("ajaxCallbackNewProject should show an error");
            $('#ajaxCallbackNewProject').append(successMsg);
            document.getElementById('ajaxCallbackNewProject').style.display = "";
          } else {

            // open file to show comments in the webpage
            var fileToOpen = $.get("./projects/"+_projectName+"/CHi-files/"+_projectName+".chi", function() {
              showComments(fileToOpen.responseText);
            });
          }
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
          if (success != 0){
            $('#ajaxCallbackUploadFolder').append(successMsg);
            document.getElementById('ajaxCallbackUploadFolder').style.display = "";
          } else {
          

            _projectName = data["projectName"];//returns the name of the uploaded folder
            callNewProjectPHP(_projectName);

            var numUploadedFiles = data["uploadedFilesCount"]; //TODO: show this number somewhere on the webpage (maybe)

          }
        }
      });//END AJAX
    }



    window.uploadFilePHP = function(aFile)
    {
      // upload file to update server copy of that file (this is needed by some python scripts of the webpage running in the server)
      var formdata = new FormData();
      formdata.append('fileUploaded',aFile);

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
          if (success != 0){
            $('#ajaxCallbackUploadFile').append(successMsg);
            document.getElementById('ajaxCallbackUploadFile').style.display = "";
          } else {
      
            // open file to show comments in the webpage
            var fileToOpen = $.get("./projects/"+_projectName+"/CHi-files/"+_projectName+".chi", function() {
              showComments(fileToOpen.responseText);
            });
          }

        }
      });//END AJAX


    }

    window.showComments = function(fileContents)
    {

      //Initialize localStorage for this project:
      if (localStorage.getItem(_projectName) === null || localStorage.getItem(_projectName) === undefined) {
        localStorage.setItem( _projectName,JSON.stringify( {} ) );  
      } else {
        document.getElementById('alertThatProjectHasSavedDataInLocalStorage').style.display = "";
      }

      // save lines to a global variable
      var s_temp = fileContents;
      lines = s_temp.split('\n');
      calculateCurrentLinesSubset();
      populateDirectiveSettedValuesDictionary(); //call before anything this time, otherwise colors arent shown the first time.
      updateText();
      updateId();
      updateSubId();
      updatePath();
      updateJavaClass();
      populateDirectiveSettedValuesDictionary();

      document.getElementById('buttons_and_comments').style.display = "";
      hideUpperButtonsAndShowProjectName();
    }

    window.openProjectFromFile = function(aFile)
    {
      _projectName = aFile.name.split('.')[0];
      var reader = new FileReader();

      reader.onload = function(progressEvent){
        //checkeo si el archivo ya existe
        var jqxhr = $.get("./projects/"+_projectName+"/CHi-files/"+_projectName+".chi", function() {
          //do nothing
        })
          .done(function(){ // si ya existe, solo muestro los la visualizacion de los comentarios en la aplicacion

            var fileToOpen = $.get("./projects/"+_projectName+"/CHi-files/"+_projectName+".chi", function() {
              showComments(jqxhr.responseText);
            });
          })
          .fail(function(){ // si no existe el archivo, hay que subirlo al servidor
            uploadFilePHP(aFile);
          });

      };
      reader.readAsText(aFile);
    }










  $("#id_comment").keyup(function(event){
      if(event.keyCode == 13){
          changeId();
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
        url: "exportProject.php",
        data: formdata,
        contentType: false,
        processData: false,
        type: "POST",
        dataType: "json",
        success: function(data){
          console.info("success! returned from exportProject.php");

          var success = data["success"];
          var successMsg = data["successMsg"];
          if (success != 0){
            $('#ajaxCallbackExportProject').append(successMsg);
            document.getElementById('ajaxCallbackExportProject').style.display = "";
          }
          
          var link_download = $("#my_link_for_export_project")[0];

          link_download.download = _projectName+".chi";
          link_download.href = "projects/"+_projectName+"/CHi-files/"+_projectName+"-export.csv";
          link_download.click();


        }
      });//End AJAX
  }




  function wekaExport() {
      var formdata = new FormData();

      formdata.append('exportString',localStorage2ExportString());
      if (_projectName != undefined) {
        formdata.append('projectName',_projectName);
      } else {
        console.info("MyError: global variable _projectName is undefined");
      }

      $.ajax({
        url: "exportWekaFile.php",
        data: formdata,
        contentType: false,
        processData: false,
        type: "POST",
        dataType: "json",
        success: function(data){
          console.info("success! returned from exportWekaFile.php");

          var success = data["success"];
          var successMsg = data["successMsg"];
          if (success != 0){
            $('#ajaxCallbackExportWekaFile').append(successMsg);
            document.getElementById('ajaxCallbackExportWekaFile').style.display = "";
          }
          
          var link_download = $("#my_link_for_export_weka_file")[0];

          link_download.download = _projectName+"-Weka.arff";
          link_download.href = "projects/"+_projectName+"/CHi-files/"+_projectName+"-export.arff";
          link_download.click();


        }
      });//End AJAX
  }







  window.hideUpperButtonsAndShowProjectName = function() {
    document.getElementById('upperButtonsContainer').style.display = "none";
    document.getElementById('ProjectNameLabel').style.display = "";
    $('#ProjectNameLabel').append("<div class='col-sm-11'><h2 class='text-center'>Project: "+_projectName+"</h2></div><div class='col-sm-1'></div>");
  }













  // sets the class of sub_id to value in the corresponding id, in the localStorage of the current project
  function myAddItemToLocalStorage(id, sub_id, value) {
    var ids = JSON.parse( localStorage.getItem(_projectName) );

    if (ids === undefined || ids === null){
      console.error("problem getting info from localStorage: projectName is not saved in the server");
    }

    console.info(ids);

    if (ids[id] === undefined){
      ids[id] = {};
    }
    console.log(ids[id][sub_id]);
    ids[id][sub_id] = value;
    console.log(ids[id][sub_id]);
    console.log("value:"+value);

    console.info(JSON.stringify( ids));
    localStorage.setItem( _projectName,JSON.stringify( ids) );

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




  function localStorage2ExportString(){
    ret = 'id,id_sub,is_directive\n';

    if (Object.keys(localStorage).length>0) {
      thisProjectDictionary = JSON.parse( localStorage.getItem(_projectName) );
      if (thisProjectDictionary === undefined || thisProjectDictionary === null) {
        console.error("problem getting info from localStorage: projectName is not saved in the server");
      } else {
        for (key in thisProjectDictionary){
          
          if (typeof(thisProjectDictionary) != 'object') {
            console.error("myInfo: an internal data element was not an object -> localStorage["+key+"]=="+localStorage[key]);
          }
          else {
            s='';
            for (key_2 in thisProjectDictionary[key]) {
              s += key+','+key_2+','+thisProjectDictionary[key][key_2] + '\n';
            }
            ret += s;
          }
        }
      }
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
        $("#ShowHideModificationsLabel").empty();
        $("#ShowHideModificationsLabel").append("Hide Modifications");
      } else {
        $('#outText').hide();
        outHidden = true;
        $("#ShowHideModificationsButtonIcon").addClass('glyphicon-collapse-down').removeClass('glyphicon-collapse-up');
        $("#ShowHideModificationsLabel").empty();
        $("#ShowHideModificationsLabel").append("Show Modifications");
      }
  }










    $(function () { //enables pretty tooltips from bootstrap
      $('[data-toggle="tooltip"]').tooltip();
    })


  </script>



  <!-- [Bootstrap] Latest compiled and minified JavaScript -->
  <script src="bootstrap/bootstrap.min.js"></script> 

</body>
</html>