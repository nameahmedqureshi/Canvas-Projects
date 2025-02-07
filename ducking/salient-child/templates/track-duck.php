<?php /* Template Name: Track Duck  */ ?>


<style>
	input[type=search]::-ms-clear { display: none; width : 0; height: 0; }
	input[type=search]::-ms-reveal { display: none; width : 0; height: 0; }
	input[type="search"]::-webkit-search-decoration,
	input[type="search"]::-webkit-search-cancel-button,
	input[type="search"]::-webkit-search-results-button,
	input[type="search"]::-webkit-search-results-decoration { display: none; }
	/*************GENRAL CLASSES START*************/
	@font-face {
		font-family: 'Libel-suit-reg';
		src: url(../fonts/libel-suit-rg.otf);
	}
	.gen_btn {
		font-family: 'Poppins', sans-serif;
		padding: 0px 24px;
		height: 55px;
		border-radius: 5px;
		background: #fed843;
		color: #000;
		transition: all .2s ease-in-out;
		display: flex;
		justify-content: center;
		align-items: center;
		font-size: 16px;
		font-weight: 500;
		border: 0;
		width: fit-content;
		text-transform: uppercase;
		cursor: pointer;
	}
	.gen_btn:hover {
		color: #000;
	}
	/*************GENRAL CLASSES END*************/

	.track_duck_wrapper_1 {
		padding: 70px 0px;
	}
	.heading {
		font-size: 60px;
		font-family: 'Libel-suit-reg';
		color: #000;
		letter-spacing: 3px;
		margin-bottom: 10px;
	}	
	.search_bar {
		max-width: 100%;
		border: 1px solid rgba(17, 63, 89, 0.20);
		border-radius: 5px;
		height: 55px;
		width: 100%;
		display: flex;
		align-items: center;
		position: relative;
	}
	.search_input {
		font-family: 'Poppins', sans-serif;
		width: 100%;
		height: 100%;
		border: 0;
		background: transparent;
		font-size: 16px;
		padding: 0px 135px 0px 20px;
		outline: none;
	}
	.search_bar .gen_btn {
		height: 48px;
		position: absolute;
		top: 50%;
		transform: translateY(-50%);
		right: 3px;
	}
	.search_bar .gen_btn i {
		margin-left: 8px;
		font-size: 14px;
	} 
	.qr_btn {
		margin-bottom: 20px;
		width: 100%;
	}
	.qr_scan_box {
		width: 100%;
		height: 300px;
		border: 2px dashed #000;
		border-radius: 25px;
		display: none;
		justify-content: center;
		align-items: center;
	}
	.qr_scan_box i {
		font-size: 80px;
		color: #e8d9d9;
	}
	.map_wrap {
		padding: 15px;
		background: var(--white);
		box-shadow: rgba(149, 157, 165, 0.2) 0px 8px 24px;
		border-radius: 15px;
		margin-top: 25px;
	}
	.map_wrap .heading {
		font-size: 35px!important;
	}

	.gen_row {
		display: flex;
		gap: 20px;
	}
	.gen_col_1 {
		width: 60%;
	}
	.gen_col_2 {
		width: 40%;
	}
	.gallery_wrapper_1 .search_bar {
		margin-bottom: 30px;
	}
	.gallery_wrapper_1 {
		padding: 70px 0px;
	}
	.product_filters {
		max-width: 250px;
		width: 100%;
	}
	.content_main {
		width: calc(100% - 250px);
	}
	.product_filters {
		padding: 20px;
		border: 1px solid #E4E7E9;
		border-radius: 2px;
	}
	.product_filters .heading {
		font-size: 22px;
		font-weight: 500;
		color: #000;
		line-height: 1;
		padding-bottom: 15px;
	}
	.sort_list {
		list-style: none;
	}
	.sort_list li {
		margin: 10px 0px;
	}
	.sort_list li a {
		font-family: 'Poppins', sans-serif;
		font-size: 16px;
		color: #000;
		display: block;
	}
	.sort_list li a:hover {
		color: #fed843;
	}
	.genCard {
		display: block;
		max-width: 250px;
		width: 100%;
		padding: 15px;
		border-radius: 10px;
		background: var(--white);
		display: block;
		margin-bottom: 10px;
		transition: all 0.5s;
		box-shadow: rgba(149, 157, 165, 0.2) 0px 8px 24px;
		height: 350px;
	}
	.genCard .imgBox {
		width: 100%;
		height: 200px;
		overflow: hidden;
		border-radius: 10px;
		overflow: hidden;
	}
	.genCard .imgBox img {
		width: 100%;
		height: 100%;
		object-fit: cover;
		object-position: center;
		transition: all 0.5s;
		border-radius: 20px;
		overflow: hidden;
	}
	.genCard:hover .imgBox img { 
		filter: brightness(0.6);
		transform: scale(1.1);
	}
	.genCard .textBox {
		padding-top: 10px;
	}
	.genCard .title {
		font-family: 'Poppins', sans-serif;
		font-size: 18px;
		font-weight: 600;
		color: #000;
		padding-bottom: 5px;
	}
	.genCard .desc {
		font-family: 'Poppins', sans-serif;
		font-size: 14px;
		color: #000;
	}
	.xy-between {
		display: flex;
		justify-content: space-between;
		align-items: center;
		flex-wrap: wrap;
	}
	.img_box {
		max-width: 285px;
		width: 100%;
		height: 285px;
		border-radius: 5px;
		overflow: hidden;
		cursor: pointer;
	}
	.img_box img {
		width: 100%;
		height: 100%;
		object-fit: cover;
		object-position: center;
	}

</style>

<section class="track_duck_wrapper_1">
	<div class="container">
		<h1 class="heading">Enter Details</h1>
		<div class="gen_row">
			<div class="gen_col_1">
				<form class="search_bar">
					<input id="search-input" type="search" class="search_input" placeholder="Enter Location here....">
					<button id="search-btn" class="gen_btn seacrh_btn" type="button">
						<span>Search</span> 
						<i class="fa-solid fa-magnifying-glass"></i>
					</button>
				</form>
			</div>
			<div class="gen_col_2">
				<button id="startButton" class="gen_btn qr_btn">Scan Duck Qr code</button>

				<div class="qr_scan_box">
					<!-- <i class="fa-solid fa-camera"></i> -->
					<video width="70%" id="scanner-camera" playsinline autoplay></video>
					<div id="result"></div>
				</div>
			</div>
		</div>

		<div class="map_wrap">
			<h1 class="heading">Map</h1>
				<div id="ducks-journey" style="width:600px; height:450px; border:0; width: 100%;" allowfullscreen="" loading="lazy"></div>                             
			<!-- <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3259.277506620112!2d-80.84930198805164!3d35.224461354815695!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x8856a024bc5716dd%3A0x709e0e7838b9b467!2sLevine%20Museum%20of%20the%20New%20South!5e0!3m2!1sen!2s!4v1697051926298!5m2!1sen!2s" width="600" height="450" style="border:0; width: 100%;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe> -->
		</div>
	</div>
</section>


<script>
	var locations = [];
	// scan qr code
	const video = document.getElementById('scanner-camera');
    const startButton = document.getElementById('startButton');
    const resultContainer = document.getElementById('result');



    function startCamera() {
        const constraints = {
            video: {
                facingMode: 'environment'
            }
        };

        navigator.mediaDevices.getUserMedia(constraints)
            .then((stream) => {
                video.srcObject = stream;
                // Initialize the code reader
                const codeReader = new ZXing.BrowserQRCodeReader();
				codeReader.reset();
                // Start scanning for QR codes
                codeReader.decodeFromVideoDevice(null, 'scanner-camera', (result, error) => {
                    if (result) {
                        resultContainer.innerHTML  = result.text;
                        ajaxCall(result);
                        // Stop the video stream and hide the video element
                        codeReader.reset();
                    }
                    if (error) {
                        //console.error('QR Code error:', error);
                        //resultContainer.innerText = 'Error: ' + error;
                        
                    }
                });
            })
            .catch((error) => {
                console.error('Error accessing camera:', error);
            });
    }

	// function stopScan() {
	// 	const constraints1 = {
    //         video: {
    //             facingMode: 'environment'
    //         }
    //     };

	// 	navigator.mediaDevices.getUserMedia(constraints1)
    //         .then((stream) => {
    //             video.srcObject = stream;
	// 			stream.getTracks().forEach(function(track) {
	// 			track.stop();
	// 			});
             
    //         })
    //         .catch((error) => {
    //             console.error('Error accessing camera:', error);
    //         });

	// }

     startButton.addEventListener('click', startCamera);
	
    function ajaxCall(result) {
		let data = result;
		// alert(data);
		// function execute after request is successful 
		var xhr = new XMLHttpRequest();
		xhr.onreadystatechange = function () {
			if (xhr.readyState === 4 && xhr.status === 200) {
				// Parse the JSON response
				var response = JSON.parse(xhr.responseText);
				console.log("location array-->",response.locations );
				var locations = response.locations;
				// If locations array is empty
				if (!locations || locations.length === 0) {
					alert('No Record Found!');
					return;
				}
				else{
					initMap(locations);
				}
				
			}
		};
		xhr.open('POST', '<?php echo admin_url('admin-ajax.php'); ?>', true);
		xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
		xhr.send('action=getDuckJourney&data=' + data);
	}

	var searchInput = document.getElementById('search-input');
	var searchBtn = document.getElementById('search-btn');
	//console.log("searchBtn--->",searchBtn);
	searchBtn.addEventListener('click', function (event) {
		event.preventDefault(); // Prevent form submission
		var searchTerm = searchInput.value;
		// var noRecordsFound = true; 
		//console.log("searchTerm--->",searchTerm);
		ajaxCall(searchTerm)
		
	});

	function initMap(locations) {
		//console.log("map load" );	
		//console.log("locations-->", locations);
		var map = new google.maps.Map(document.getElementById('ducks-journey'), {
			zoom: 14,
			center: new google.maps.LatLng(38.460304, -82.649666), // Set a default location
    	});

		// If locations array is empty
		if (!locations || locations.length === 0) {
			return;
		}
		
		var infowindow = new google.maps.InfoWindow();
		var markers = [];
		var bounds = new google.maps.LatLngBounds();
			
		for (var i = 0; i < locations.length; i++) {
			var location = locations[i];
			// console.log("active_duck-->", location.active_duck);
			//var markerColor = location.active_duck == 0 ? 'red' : 'green';
			var marker = new google.maps.Marker({
				position: new google.maps.LatLng(location.lat, location.lng),
				map: map,
				title: location.duck_id,
				label: (i + 1).toString(), // Display numbers on markers
				permalink: location.permalink,
				//icon: 'http://maps.google.com/mapfiles/ms/icons/' + markerColor + '-dot.png',
				icon: 'https://devu10.testdevlink.net/Ducking/wp-content/uploads/2023/10/duck-icon.png',
			});
	
			markers.push(marker);
			bounds.extend(marker.getPosition());
	
			google.maps.event.addListener(marker, 'mouseover', (function (marker, i) {
				return function () {
					infowindow.setContent(`
						<div class="duck-info">
							<span>Jeep Name: ${locations[i].jeep_name}</span>
						</div>
					`);
					infowindow.open(map, marker);
				}
			})(marker, i));
			
		}
		map.fitBounds(bounds);
	}

	
	document.querySelector(".qr_btn").addEventListener("click", function () {
		var qrScanBox = document.querySelector(".qr_scan_box");
		
		if (qrScanBox.classList.contains("active")) {
			qrScanBox.style.display = "none"
			qrScanBox.classList.remove("active");
			location.reload();
			
		}
		else {
			qrScanBox.style.display = "flex"
		
			qrScanBox.classList.add("active"); 
		}
		// window.location.reload
	});

</script>
<script async defer src="https://maps.googleapis.com/maps/api/js?key=AIzaSyC1cDxNrmPLxUFXAIEp4VNdXEpituJPYWs&callback=initMap"></script>