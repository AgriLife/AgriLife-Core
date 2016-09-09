/* Ensure headings in a row have identical heights */
(function(){
  var scripts = document.getElementsByTagName('script'),
      thisscript = scripts[scripts.length-1],
      headings = thisscript.parentNode.querySelectorAll('h3'),
      maxHeight = 0;

  for(var i = 0; i < headings.length; i++){
    var height = headings[i].getBoundingClientRect().height;
    if(height > maxHeight){
      maxHeight = Math.ceil(height);
    }
  }
  for(var i = 0; i < headings.length; i++){
    headings[i].style.height = maxHeight + 'px';
  }
})();