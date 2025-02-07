<?php /*  Template Name: Journey  */ ?>
<?php get_header('header'); ?>
<?php $current_user = wp_get_current_user(); ?>
<section class="sec_main">
	<div class="sec_row">
		<?php get_template_part('templates/includes/menu', 'template'); ?>

		<div class="content_main">
			<div class="inner_header">
				<h1 class="heading_top">My Duck Journey</h1>
				<div class="top_actions_btns_wrap">
					
					<div class="user_top_info" id="user_info">
						<p class="title"><?= isset($current_user->first_name) && $current_user->first_name ? $current_user->first_name : 'Jones Ferdinand' ?></p>
						<div class="user_img_box"><img src="<?= get_stylesheet_directory_uri() . '/templates/assets/front/images/user-img.png' ?>" alt="img" class="img-fluid w-100 h-100"></div>
					</div>
					<div class="nav_dropdown">
						<ul class="list-unstyled">
							<li>
								<a href="<?= site_url('dashboard') ?>"><span><img src="<?= get_stylesheet_directory_uri() . '/templates/assets/front/images/dd-icon-1.png' ?>" alt="img"></span>My Profile</a>
							</li>
							<li>
								<a href="#!"><span><img src="<?= get_stylesheet_directory_uri() . '/templates/assets/front/images/dd-icon-2.png' ?>" alt="img"></span>Terms & Conditions</a>
							</li>
							<li>
								<a href="#!"><span><img src="<?= get_stylesheet_directory_uri() . '/templates/assets/front/images/dd-icon-3.png' ?>" alt="img"></span>Privacy Policy</a>
							</li>
							<li>
								<a href="<?= site_url('logout') ?>"><span><img src="<?= get_stylesheet_directory_uri() . '/templates/assets/front/images/dd-icon-4.png' ?>" alt="img"></span>Logout</a>
							</li>
						</ul>
					</div>
				</div>
			</div>

			<div class="inner_content_body">
				<div class="map_location_search">
					<input id= "search-input" type="search" placeholder="Enter Location here...">
					<button id="search-btn" class="seacrh_btn">Search</button>
				</div>
				
				<button id="startButton" class="submit_btn edit_btn duck">QR Duck Journey</button>
				<video id="scanner-camera" playsinline autoplay></video>
				<div id="result"></div>

				<div class="map_wrap">
					<div id="ducks-journey" style="height: 400px;"></div>
				</div>
			</div>
		</div>
	</div>
</section>
<?php get_footer('footer'); ?>
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
					resultContainer.innerText = 'Error: ' + error;
					
				}
			});
		})
		.catch((error) => {
			console.error('Error accessing camera:', error);
		});
    }
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
				else{ initMap(locations); }
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
							<a class="view-btn" href="${locations[i].permalink}">View</a>
						</div>
					`);
					infowindow.open(map, marker);
				}
			})(marker, i));
			
		}
		map.fitBounds(bounds);
	}
</script>
<script async defer src="https://maps.googleapis.com/maps/api/js?key=AIzaSyC1cDxNrmPLxUFXAIEp4VNdXEpituJPYWs&callback=initMap"></script>