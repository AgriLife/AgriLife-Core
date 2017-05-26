(function(){

	var openlinks = document.querySelectorAll('.flexiblecolumns.row .publications a.open'),
			closelinks = document.querySelectorAll('.flexiblecolumns.row .publications a.close');

	for(var m = 0; m < openlinks.length; m++){
		openlinks[m].onclick = fcLightbox;
	}

	for(var n = 0; n < closelinks.length; n++){
		closelinks[n].onclick = fcLightboxClose;
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
		for(var o = 0; o < arr.length; o++){
			if(arr[o] == classname){
				arr.splice(o, 1);
				break;
			}
		}
		return arr.join(' ');
	}
})();
