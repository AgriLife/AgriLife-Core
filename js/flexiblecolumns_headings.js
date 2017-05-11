/* Ensure headings in a row have identical heights */
if(typeof resizeACFlexibleColumnsHeadings != 'function'){
  var resizeACFlexibleColumnsHeadings = function(headings){
    var maxHeight = 0;

    for(var j = 0; j < headings.length; j++){
      var height = headings[j].childNodes[0].getBoundingClientRect().height;
      if(height > maxHeight){
        maxHeight = Math.ceil(height);
      }
    }

    for(var j = 0; j < headings.length; j++){
      if(window.innerWidth <= 710){
        // Mobile columns do not have headings in the same row
        headings[j].style.height = '';
      } else {
        // Resize headings in the same row
        headings[j].style.height = maxHeight + 'px';
      }
    }
  };

  window.onresize = function(event){
    // Resize all row headings
    var rows = document.querySelectorAll('.entry-content .row');

    for(var i = 0; i < rows.length; i++){
      if(rows[i].querySelectorAll('h3.summary-heading').length > 0){
        resizeACFlexibleColumnsHeadings(rows[i].querySelectorAll('h3.summary-heading'));
      }
    }
  };
}

(function(){
  // Resize only the row headings adjacent to this script element on page load
  var scripts = document.getElementsByTagName('script'),
    thisscript = scripts[scripts.length-1],
    headings = thisscript.parentNode.querySelectorAll('h3.summary-heading');

  resizeACFlexibleColumnsHeadings(headings);

})();
