/* Ensure headings in a row have identical heights */
(function(){
  var scripts = document.getElementsByTagName('script'),
      thisscript = scripts[scripts.length-1],
      buttons = thisscript.parentNode.querySelectorAll('a'),
      maxWidth = 0,
      maxHeight = 0;

  for(var i = 0; i < buttons.length; i++){
    var rect = buttons[i].getBoundingClientRect();
    var width = rect.width;
    var height = rect.height;
    if(width > maxWidth){
      maxWidth = Math.ceil(width);
    }
    if(height > maxHeight){
      maxHeight = Math.ceil(height);
    }
  }
  for(var i = 0; i < buttons.length; i++){
    var button = buttons[i];
    button.style.width = maxWidth + 'px';
    var rect = button.getBoundingClientRect();
    // Adjust height and line height to match when buttons are scaled down
    if(rect.height < maxHeight){
      var style = window.getComputedStyle(button);
      var paddingTopAndBottom = parseFloat(style.getPropertyValue('padding-top')) + parseFloat(style.getPropertyValue('padding-bottom'));
      var borderTopAndBottom = parseFloat(style.getPropertyValue('border-top-width')) + parseFloat(style.getPropertyValue('border-bottom-width'));
      button.style.lineHeight = maxHeight - borderTopAndBottom - paddingTopAndBottom + 'px';
    }
    button.style.height = maxHeight + 'px';
  }
})();