window.onload = resizeall;
window.onresize = resizeall;

var url = location.href;
var decoupe = url.match(/\/([^\/]*)(?=\.php)/);

function cam() {

  var streaming = false,
      video        = document.querySelector('#video'),
      cover        = document.querySelector('#cover'),
      canvas       = document.querySelector('#canvas'),
      photo        = document.querySelector('#photo'),
      startbutton  = document.querySelector('#startbutton'),
      width = 320,
      height = 0;

  navigator.getMedia = ( navigator.getUserMedia ||
                         navigator.webkitGetUserMedia ||
                         navigator.mozGetUserMedia ||
                         navigator.msGetUserMedia);

  navigator.getMedia(
    {
      video: true,
      audio: false
    },
    function(stream) {
      if (navigator.mozGetUserMedia) {
        video.mozSrcObject = stream;
      } else {
        var vendorURL = window.URL || window.webkitURL;
        video.src = vendorURL.createObjectURL(stream);
      }
      video.play();
    },
    function(err) {
      console.log("An error occured! " + err);
    }
  );

  video.addEventListener('canplay', function(ev){
    if (!streaming) {
      height = video.videoHeight / (video.videoWidth/width);
      video.setAttribute('width', width);
      video.setAttribute('height', height);
      canvas.setAttribute('width', width);
      canvas.setAttribute('height', height);
      streaming = true;
    }
  }, false);

  function takepicture() {
    canvas.width = width;
    canvas.height = height;
    canvas.getContext('2d').drawImage(video, 0, 0, width, height);
    var data = canvas.toDataURL('image/png');
    photo.setAttribute('src', data);
  }

  startbutton.addEventListener('click', function(ev){
      takepicture();
    ev.preventDefault();
  }, false);

}

function resizeindex(){
	var menu = document.getElementById('menu');
	var photoarea = document.getElementById('photoarea');
	var largeur = window.innerWidth;

	if (largeur < 1024){
		console.log("index.js");
		menu.style.display = "none";
		photoarea.style.display = "block";
		photoarea.style.marginLeft = "15%";
		photoarea.style.position = "absolute";
	}
	else{
		photoarea.style.position = "fixed";
		photoarea.style.display = " inline-block";
		photoarea.style.marginLeft = " 2%";
		menu.style.display = "inline-block";
	}
}

function resizeall(){
	if (decoupe[1] == "index")
		resizeindex();
	if (decoupe[1] == "cam")
		cam();
	var menuicon = document.getElementById('menuicon');
	var homeicon = document.getElementById('homeicon');
	var faqicon = document.getElementById('faqicon');
	var loginicon = document.getElementById('loginicon');
	var searchicon = document.getElementById('searchicon');
	var largeur = window.innerWidth;

	if (largeur < 1024){
		homeicon.style.display="none";
		faqicon.style.display="none";
		searchicon.style.display="none";
		loginicon.style.display="none";
		menuicon.style.display="inline-block";
	}
	else{
		menuicon.style.display="none";
		homeicon.style.display="inline-block";
		faqicon.style.display="inline-block";
		searchicon.style.display="inline-block";
		loginicon.style.display="inline-block";
	}
}
