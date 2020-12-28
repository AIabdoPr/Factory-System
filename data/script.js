var _GET = {};
if(document.location.toString().indexOf('?') !== -1) {
  var query = document.location.toString()
                // get the query string
                .replace(/^.*?\?/, '')
                // and remove any existing hash string (thanks, @vrijdenker)
                .replace(/#.*$/, '')
                .split('&');
  for(var i=0, l=query.length; i<l; i++) {
    var aux = decodeURIComponent(query[i]).split('=');
    _GET[aux[0]] = aux[1];
  }
}

function createNoty(message, type) {
  var html = '<div class="alert alert-' + type + ' alert-dismissable page-alert">';    
  html += '<button class="close" aria-hidden="true" onclick="removeNoty(this)">×<span class="sr-only">Close</span></button>';
  html += message;
  html += '</div>';    
  $(html).hide().prependTo('#my-noty').slideDown();
};

function removeNoty(element) {
  $(element).closest('.page-alert').slideUp();
}

function load_page(path){
  var div = document.createElement("div");
  div.className = "modal";
  div.style.display='block';
  div.innerHTML = '<object type="text/html" data="'+path+'" style="width: 100%; height: 100%;"></object>';
  document.body.appendChild(div);
}

function getOffset(el) {
  const rect = el.getBoundingClientRect();
  return {
    left: rect.left + window.scrollX,
    top: rect.top + window.scrollY,
    width: rect.width,
    height: rect.height,
  };
}

function mouseX(evt) {
  if (evt.pageX) {
    return evt.pageX;
  } else if (evt.clientX) {
    return evt.clientX + (document.documentElement.scrollLeft ?
      document.documentElement.scrollLeft :
      document.body.scrollLeft);
  } else {
    return null;
  }
}

function mouseY(evt) {
  if(evt.pageY) {
    return evt.pageY;
  }else if (evt.clientY) {
    return evt.clientY + (document.documentElement.scrollTop ?
      document.documentElement.scrollTop :
      document.body.scrollTop);
  }else {
    return null;
  }
}
