(function(){

	var openlinks = document.querySelectorAll('.flexiblecolumns.row .publications a.open'),
			closelinks = document.querySelectorAll('.flexiblecolumns.row .publications a.close');

	for(var i = 0; i < openlinks.length; i++){
		openlinks[i].onclick = fcLightbox;
	}

	for(var i = 0; i < closelinks.length; i++){
		closelinks[i].onclick = fcLightboxClose;
	}

	function fcLightbox(e){

		var overlay = this.parentNode.querySelector('.overlay');
		overlay.className += ' opened';
		document.body.className += ' fc-lightbox-opened';

	}

	function fcLightboxClose(e){

		var overlay = this.parentNode;
		if(overlay.className.indexOf('overlay') < 0)
			overlay = overlay.parentNode;

		overlay.className = removeClass( 'opened', overlay.className );
		document.body.className = removeClass( 'fc-lightbox-opened', document.body.className );

	}

	function removeClass(classname, classattr){

		var arr = classattr.split(' ');
		for(var i = 0; i < arr.length; i++){
			if(arr[i] == classname){
				arr.splice(i, 1);
				break;
			}
		}
		return arr.join(' ');
	}
})();
