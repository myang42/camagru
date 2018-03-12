		console.log('OH');
		var streaming = false;
		var dakor = document.querySelector('#dakor');
		var video	= document.querySelector('#video');
		var cover	= document.querySelector('#cover');
		var canvas	 = document.getElementById('canvas');
		// var photo	= document.querySelector('#photo');
		var startbutton	= document.querySelector('#startbutton');


		var width = 320;
		var height = 0;

		navigator.getMedia = (navigator.getUserMedia ||
		navigator.webkitGetUserMedia || navigator.mozGetUserMedia ||
		navigator.msGetUserMedia); //Get the Webcam

		navigator.getMedia(
			{
				video : true, // video on
				sound : false //audio off
			},
			function(stream){ //on success
				console.log(stream);
				if(navigator.mozGetUserMedia){
					video.mozSrcObject = stream;
				} else {
					var vendorURL = window.URL || window.webkitURL;
					video.src = vendorURL.createObjectURL(stream);
				}
				video.play();
			},
			function(error){ //if fail
				console.log("An error occured : " + error)
				return;
			}
		)


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
				dakor.value = data;
				// console.log(data);
				// photo.setAttribute('src', data);
			}

			startbutton.addEventListener('click', function(ev){
				takepicture();
				ev.preventDefault();
			}, false);
