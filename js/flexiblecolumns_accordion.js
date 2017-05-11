(function(){

  var i,
      titles = document.querySelectorAll('.af-accordion .accordion-title'),
      content = document.querySelectorAll('.af-accordion .accordion-content');

  for(i = 0; i < content.length; i++){
    content[i].style.height = content[i].getBoundingClientRect().height + 'px';
  }

  for(i = 0; i < titles.length; i++){
    titles[i].addEventListener('click', toggleUpClass);
    titles[i].className = titles[i].className += ' up';
  }

  function toggleUpClass(e){

    var classes = this.className.split(' ');

    e.preventDefault();

    for(i = 0; i < classes.length; i++){
      var iclass = classes[i];
      if(iclass == 'down'){
        classes[i] = 'up';
      } else if(iclass == 'up'){
        classes[i] = 'down';
      }
    }
    
    this.className = classes.join(' ');

  }

})();
