<?php

$count = 0;
if ($_SERVER['REQUEST_METHOD'] == 'POST'){
    foreach ($_FILES['files']['name'] as $i => $name) {
        if (strlen($_FILES['files']['name'][$i]) > 1) {
            if (move_uploaded_file($_FILES['files']['tmp_name'][$i], 'projects/'.$name)) {
                $count++;
            }
        }
    }
}
?>

<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
  <title>CommentsReaderApp</title>

  <!-- Latest compiled and minified CSS -->
  <link rel="stylesheet" href="bootstrap/bootstrap.min.css">

  <!-- Optional theme -->
  <link rel="stylesheet" href="bootstrap/bootstrap-theme.min.css">

  <script type="text/javascript" src="scripts/jquery-2.1.3.js"></script>
  <script type="text/javascript" src="scripts/keypress.js"></script>
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

  <div class="container" style="margin-top: 2px">


    <div class="row" style="margin-bottom: 5px">
      <div class="col-lg-6 col-sm-6 col-12">
        <h4>Start new project:</h4>
        <h6>(Extract all javadoc from files in a folder and subfolders and start tagging comments)</h6>
        <div class="input-group">
          
          <form method="post" enctype="multipart/form-data">
            <input type="file" name="files[]" id="folder" multiple="" directory="" webkitdirectory="" mozdirectory="">
      
            <input class="button" type="submit" value="Upload">
          </form>
          <?php
          if ($count > 0) {
              echo "<p class='msg'>{$count} files uploaded</p>\n\n";
          }
          ?>
        </div>
      </div>
    </div>




    <div class="row" style="margin-bottom: 5px">
      <div class="col-lg-6 col-sm-6 col-12">
        <h4>Open existing project:</h4>
        <h6>(Open .csv file from a previously created project)</h6>
        <div class="input-group">
          <span class="input-group-btn">  
            <span class="btn btn-info btn-file">
              Browse <input type="file" id="file">
            </span>
          </span>
          <input id='file_name' type="text" class="form-control" readonly>
        </div>
      </div>
    </div>


      <div class="col-sm-offset-7">
        <button type="button" class="btn btn-info btn-sm" onclick="execBtnTrigger();">
            extract comments, then run python scripts (toPhrases->..)
        </button>
      </div>




    <div id="buttons_and_comments">



     <div id="buttons" style="margin-top: 10px">

      
          <div class="col-sm-offset-7">
            <button type="button" class="btn btn-success btn-sm" onclick="previousPhrase();">
              <span class="glyphicon glyphicon-triangle-top" aria-hidden="true"></span>
            </button>
          </div>
       

        
        <div class="inline-block col-sm-offset-5">
          <button type="button" class=" col-sm-4 btn btn-default btn-sm" onclick="toggleDirectiveField();">
            Toggle Comment Type (space)
          </button>
          

            <button type="button" class="btn btn-default btn-sm" onclick="previousComment();">
              <span class="glyphicon glyphicon-triangle-left" aria-hidden="true"></span>
            </button>
            <button type="button" class="btn btn-danger btn-sm" onclick="nextPhrase();">
              <span class="glyphicon glyphicon-triangle-bottom" aria-hidden="true"></span>
            </button>
            <button type="button" class="btn btn-default btn-sm" onclick="nextComment();">
              <span class="glyphicon glyphicon-triangle-right" aria-hidden="true"></span>
            </button>
            
          
        </div>


      </div>



      <div>
        <div>
          status:
        </div>
        <div id='php'>
          idle
        </div>
      </div>



      <div class="text-center">
        <div class="row">
            <label class="">ID: </label>
            <input id="id_comment" onchange="changeId();">
            <span>(the '-' is not necessary)</span>
        </div>
        <div class="row">
          <h4 id="type_comment" class="">_</h4>
        </div>
        <div class="row">
          <h4 id="path_comment" class="">_</h4>
        </div>
        
        <p id='mylogger'></p>
      </div>

      <div id="comment" class="col-md-12">
        <pre id="commentPre">
        </pre>
      </div>




      <br>

      <div class="row">
        <div class="col-md-3">
        <button type="button" class="btn btn-default btn-lg btn-block" onclick="toggleExportText();" data-toggle="tooltip" data-placement="top" title="Copy this text to a file to export all data">
          <span class="glyphicon glyphicon-collapse-down" aria-hidden="true"></span>
          Toggle export data
        </button>
        </div>
        <div class="col-md-6">
        <button type="button" class="btn btn-info btn-lg btn-block" onclick="toggleLocalStorageText();">
          <span class="glyphicon glyphicon-collapse-down" aria-hidden="true"></span>
          Toggle export data (readable)
        </button>
        </div>
        <div class="col-md-3">
        <button type="button" class="btn btn-warning btn-lg btn-block" onclick="eraseLocalStorage();" data-toggle="tooltip" data-placement="top" title="The app forgets all the states set by the user in the past (data is stored in your hard drive)">
          <span class="glyphicon glyphicon-trash" aria-hidden="true"></span>
          Erase all data
        </button>
        </div>
      </div>





      <div id="out">
        <pre id="outText">

        </pre>
      </div>


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


  var debug = false;
  var commentsDict = [];
  var lines = [];
  var lines_current_subset = [];
  //var phrases = [];
  var file = null;
  var current_line_pointer = 2;
  var phrase_pointer = 1;
  var previous_comment_lines_subset = undefined;

  var is_directive_setted_values = {};

  document.getElementById('folder').onchange = function(){
    console.log( "folder selected , onchange() was called\n with value:"+this.files[0] );
  };



  document.getElementById('file').onchange = function(){
    console.log( "file selected , onchange() was called\n" );

    file = this.files[0];

    var reader = new FileReader();
    reader.onload = function(progressEvent){
      // save lines to a global variable
      var s_temp = 'dummy_line\n'+this.result;
      lines = s_temp.split('\n');
      calculateCurrentLinesSubset();
      updateText();
      updateId();
      updateType();
      updatePath();
      updateMyLogger();
      console.log(Object.keys(is_directive_setted_values).length);
      populateDirectiveSettedValuesDictionary();
      console.log(Object.keys(is_directive_setted_values).length);
    };
    reader.readAsText(file);

    $('#buttons_and_comments').show();
  };

  //show file selected in text input (readonly)
  $(document).on('change', '#file', function() {
    var input = $(this),
        numFiles = input.get(0).files ? input.get(0).files.length : 1,
        label = input.val().replace(/\\/g, '/').replace(/.*\//, '');
    input.trigger('fileselect', [numFiles, label]);
  });




  function execBtnTrigger()
  {
    execBtn();
  }



  function nextPhrase()
  {
    console.log("nextPhrase function was called\n");
    if (phrase_pointer<lines_current_subset.length-1) {
      phrase_pointer += 1;
      updateText();
      updateId();
      updateType();
      updatePath();
    } else {
      nextComment();
    }
  }

  function previousPhrase()
  {
    console.log("previousPhrase function was called\n");
    console.log('current_line_pointer:' +current_line_pointer);
    if (phrase_pointer>1) {
      phrase_pointer -= 1;
      updateText();
      updateId();
      updateType();
      updatePath();
    } else{
      previousComment('end');
    }
  }

  function nextComment()
  {
      console.log("nextComment function was called\n");
    if (current_line_pointer<lines.length-1) {
      console.log(lines_current_subset.length);
      current_line_pointer += lines_current_subset.length;
      calculateCurrentLinesSubset();
      phrase_pointer = 1;
      updateText();
      updateId();
      updateType();
      updatePath();
    }
  }

  function previousComment(offset)
  {
    offset = typeof(offset) !== 'undefined' ? offset : 'start';

    console.log("previousComment function was called\n");
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
      updateType();
      updatePath();
    }
  }
  function calculateCurrentLinesSubset()
  {
    var current_line_pointer_cpy = current_line_pointer;

    lines_current_subset=[];

    for (var i=1;i<200;i++) { //maximo examinar max 200 lineas para que no exista un loop infinito
      if (current_line_pointer_cpy>=lines.length) {
        console.log('break (malo solo deberia pasar cuando se acaba el archivo) with i='+i)
        break;
      }
      var id = mysplit(lines[current_line_pointer_cpy],',',1)[0];
      
      if ( i>1 && id!=lastId) {
        console.log('break (bueno) with i='+i)
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
        console.log('i='+i);
        if ( i==1 ) {
          console.log('cant go to previous comment because this one is the first one.');
        } else {
          console.log('break (bueno) with i='+i);
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
    showId(line[0]+'-'+line[1]);
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
        console.log('\n**is_directive('+ss+')='+is_directive+'\n');
      }

      if (i==phrase_pointer){
        selected_phrase_dict[''+i] = '-selected';
      } else {
        selected_phrase_dict[''+i] = '';
      }



      if (is_directive == '0') {
        comment += '<span class="inline bg-gris'+selected_phrase_dict[''+i]+'">'+splitted_line[5]+'</span>';
      } else if (is_directive == '1') {
        comment += '<span class="inline bg-amarillo'+selected_phrase_dict[''+i]+'">'+splitted_line[5]+'</span>';
      } else if (is_directive == '2') {
        comment += '<span class="inline bg-azul'+selected_phrase_dict[''+i]+'">'+splitted_line[5]+'</span>';
      } else if (is_directive == '3') {
        comment += '<span class="inline bg-naranjo'+selected_phrase_dict[''+i]+'">'+splitted_line[5]+'</span>';
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
    console.log("yes() function was called\n");

    ////wrong call to .split (call mysplit) localStorage.setItem(""+current_line_pointer, lines[current_line_pointer].split(',',1)[0]+",1\n");
  }

  function no()
  {
    console.log("no() function was called\n");

    ////wrong call to .split (call mysplit) localStorage.setItem(""+current_line_pointer, lines[current_line_pointer].split(',',1)[0]+",0\n");
  }
  function toggleDirectiveField()
  {
    console.log("toggleDirectiveField() function was called\n");

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
      is_directive_setted_values[myLineVar[0]][phrase_pointer] = '2'
      console.log("phrase set to 2 (revise-later)\n");
    } else if (is_directive == '1') {
      is_directive_setted_values[myLineVar[0]][phrase_pointer] = '0'
      console.log("phrase set to 0 (non-directive)\n");
    } else if (is_directive == '2') {
      is_directive_setted_values[myLineVar[0]][phrase_pointer] = '3'
      console.log("phrase set to 3 (comment-with-null)\n");
    } else if (is_directive == '3') {
      is_directive_setted_values[myLineVar[0]][phrase_pointer] = '1'
      console.log("phrase set to 1 (directive)\n");
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
    console.log('eraseLocalStorage() function was called');

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
    console.log("changeId function was called\n");

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
        updateType();
        updatePath();
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
      console.log("showText() was called");
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
      console.log("showId() was called");


      $("#id_comment").val( str );
 
    }
    window.showType = function(str)
    {
      console.log("showType() was called");

      $("#type_comment").empty();
      $("#type_comment").append( str );
 
    }
    window.showPath = function(str)
    {
      console.log("showPath() was called");

      $("#path_comment").empty();
      $("#path_comment").append( str );
 
    }

    window.showLog = function(str)
    {
      $('#mylogger').empty();
      $('#mylogger').append( "<br></br><h5><u>debugging log:</u></h5>"+ str);
    }

    window.execBtn = function()
    {
      //$('#php').load('exec.php');
      $.ajax({
        url: "exec.php",
        data: {"exportString":localStorage2ExportString},
        type: "post",
        success: function(data){
          $('#php').html(data)
        }
      })
    }

/*    $('#folder').onchange = function(){
      console.log( "folder selected , onchange() was called\n" );
      var value = $(this);
      console.log(value.val);

      file = this.files[0];
    }*/

  });
















  function mysplit(aString, aChar, maxSplit) {
      var aStringCpy = aString.slice(0);
      var arr = [];
      var j=-1;


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


  function localStorage2String(){
    ret = '';
    if (Object.keys(localStorage).length>0) {
      for (key in localStorage){
        obj = JSON.parse(localStorage[key]);
        s = '\n' + key + ':';
        if (typeof(obj) != 'object') {
          s += '\n\tmyError!: This is not an object/dictionary and it should be. It is of type <'+typeof(obj)+'>';
        }
        for (key_2 in obj) {
          s += '\n\t'+key_2+':'+obj[key_2];
        }
        ret += s;
      }
    } else {
      ret += 'localStorage is empty.';
    }
    return ret;
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
      ret += 'localStorage is empty.';
    }
    return ret;
  }





  function toggleLocalStorageText() {
      if (outHidden) {
        $("#outText").empty();
        $("#outText").append( localStorage2String() );
        $('#outText').show();
        outHidden = false;
      } else {
        $('#outText').hide();
        outHidden = true;
      }
  }


  function toggleExportText() {
      if (outHidden) {
        $("#outText").empty();
        $("#outText").append( localStorage2ExportString() );
        $('#outText').show();
        outHidden = false;
      } else {
        $('#outText').hide();
        outHidden = true;
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