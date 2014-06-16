var tests = {
      progress: "upload" in new XMLHttpRequest
    },
    progress = document.getElementById('uploadprogress');

// getElementById
function $id(id) {
  return document.getElementById(id);
}

//
// output information
function Output(msg) {
  var m = $id('dragndrop');
  m.innerHTML = msg + m.innerHTML;
}

// call initialization file
if (window.File && window.FileList && window.FileReader) {
  Init();
}

//
// initialize
function Init() {

  var fileselect = $id('files'),
    filedrag = $id('dragndrop');

  // file select
  fileselect.addEventListener('change', FileSelectHandler, false);

  // is XHR2 available?
  var xhr = new XMLHttpRequest();
  if (xhr.upload) {
  
    // file drop
    filedrag.addEventListener('dragover', FileDragHover, false);
    filedrag.addEventListener('dragleave', FileDragHover, false);
    filedrag.addEventListener('drop', FileSelectHandler, false);
  }

}

// file drag hover
function FileDragHover(e) {
  e.stopPropagation();
  e.preventDefault();
  //e.target.className = (e.type == "dragover" ? "hover" : "");
}

// file selection
function FileSelectHandler(e) {

  // cancel event and hover styling
  FileDragHover(e);

  // fetch FileList object
  var files = e.target.files || e.dataTransfer.files;

  // process all File objects
  for (var i = 0, f; f = files[i]; i++) {
    ParseFile(f);
    process(f);
  }

}

function ParseFile(file) {
  var placeholder = $id('placeholder');

  // remove placeholder
  placeholder.style.display = "none";

  progress.innerHTML = 0;
  progress.value = 0;
  

  // display an image
  if (file.type.indexOf("image") == 0) {
    var reader = new FileReader();
    reader.onload = function(e) {
      Output(
        '<div class="preview_pic">' +
        '<img src="' + e.target.result + '" /><br/>' +
        '<span>' + file.name + '</span>' +
        '</div>'
      );
    }
    reader.readAsDataURL(file);
  }
  
}

function process(file) {
xmlHttp=new XMLHttpRequest();

  if (xmlHttp.readyState == 0 || xmlHttp.readyState == 4) {

    xmlHttp.onreadystatechange = processServerResponse;
    
    xmlHttp.open("POST", "/ajax/php/upload.php" ,true);
    xmlHttp.setRequestHeader("X_FILENAME", file.name);
    xmlHttp.setRequestHeader("X_FILETYPE", file.type);
    xmlHttp.setRequestHeader("X_FILESIZE", file.size);

    xmlHttp.onload = function() {
      progress.value = progress.innerHTML = 100;
    };

    if (tests.progress) {
      xmlHttp.upload.onprogress = function (event) {
        if (event.lengthComputable) {
          var complete = (event.loaded / event.total * 100 | 0);
          progress.value = progress.innerHTML = complete;
        }
      }
    }

    xmlHttp.send(file);
    }
}

function processServerResponse() {
  if (xmlHttp.readyState == 4 && xmlHttp.status==200) {
    var contents = document.getElementById("errors").innerHTML;

    document.getElementById("errors").innerHTML=contents + xmlHttp.responseText;
  }
}