/* Ensure buttons in a row have identical heights */
(function(){

  var scripts = document.getElementsByTagName('script'),
      thisscript = scripts[scripts.length-1],
      buttons = thisscript.parentNode.querySelectorAll('a.fc-button'),
      maxWidth = 0,
      maxHeight = 0;

  // Get the tallest button's height and the widest button's width
  for(var i = 0; i < buttons.length; i++){

    var rect = buttons[i].getBoundingClientRect(),
        width = rect.width,
        height = rect.height;

    if(width > maxWidth)
      maxWidth = Math.ceil(width);

    if(height > maxHeight)
      maxHeight = Math.ceil(height);

  }

  // Set all buttons to those dimensions
  for(var i = 0; i < buttons.length; i++){

    var button = buttons[i],
        rect = button.getBoundingClientRect();

    button.style.minWidth = maxWidth + 'px';

    // Adjust height and line height to match when buttons are scaled down
    if(rect.height < maxHeight){
      var style = window.getComputedStyle(button),
          paddingTopAndBottom = parseFloat(style.getPropertyValue('padding-top')) + parseFloat(style.getPropertyValue('padding-bottom')),
          borderTopAndBottom = parseFloat(style.getPropertyValue('border-top-width')) + parseFloat(style.getPropertyValue('border-bottom-width'));
      button.style.lineHeight = maxHeight - borderTopAndBottom - paddingTopAndBottom + 'px';
    }

    button.style.minHeight = maxHeight + 'px';

  }

})();
