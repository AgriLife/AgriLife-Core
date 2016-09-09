/* Ensure headings in a row have identical heights */
(function(){
  var scripts = document.getElementsByTagName('script'),
      thisscript = scripts[scripts.length-1],
      buttons = thisscript.parentNode.querySelectorAll('a'),
      maxWidth = 0;

  for(var i = 0; i < buttons.length; i++){
    var width = buttons[i].getBoundingClientRect().width;
    if(width > maxWidth){
      maxWidth = Math.ceil(width);
    }
  }
  for(var i = 0; i < buttons.length; i++){
    buttons[i].style.width = maxWidth + 'px';
  }
})();