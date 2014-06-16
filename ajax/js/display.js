var current = 0;
var prev = 0;
var next = 0;
var the_size = 0;
var loads = 0;

function init (size,c) {
  the_size = size;

  if (loads < 1) {
    current = c;
    loads++;
    load();
  }

  if ( (current + 1) < size) 
    next = (current + 1);
  else next = 0;

  if ( (current - 1) >= 0) 
    prev = (current - 1);
  else prev = (size - 1);
}

function display (a) {
  a.removeAttribute('style');
  document.getElementById('loader').style.display="none";
}

function scale (a) {
  if (a.className == '') {
    a.className = 'scaled';
    a.title = 'click to reduce';

    var body = document.getElementsByTagName('body')[0];
    //body.style.opacity = '0.3';
  }
  else {
    a.removeAttribute('class');
    a.title = 'click to enlarge';
  }
  
}

function load () {
  xmlHttp=new XMLHttpRequest();

  if (xmlHttp.readyState == 0 || xmlHttp.readyState == 4) {

    xmlHttp.onreadystatechange = processServerResponse;
    
    xmlHttp.open("GET", "/ajax/php/display.php?id=" + current, true);
    xmlHttp.send();
    }
}

function show_curr (where) {
  if (where == 'next')
    current = next;

  if (where == 'prev')
    current = prev;

  if (where == 'next')
    current = next;

  xmlHttp=new XMLHttpRequest();

  if (xmlHttp.readyState == 0 || xmlHttp.readyState == 4) {

    xmlHttp.onreadystatechange = processServerResponse;
    
    xmlHttp.open("GET", "/ajax/php/display.php?id=" + current, true);
    xmlHttp.send();
    }

    // reinitialise
    init(the_size);
}


function prev () {
  current = prev;

  show_curr();
}

function next () {
  current = next;

  show_curr();
}

function processServerResponse () {
  if (xmlHttp.readyState == 4 && xmlHttp.status==200) {
    document.getElementById("picture").innerHTML=xmlHttp.responseText;
  }
}