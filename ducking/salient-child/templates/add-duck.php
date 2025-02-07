<?php /* Template Name: Add Duck */ ?>
<?php get_header('header'); ?>
<?php 
    $current_user = wp_get_current_user(); 
 	$post_id = isset($_GET['id']) ? $_GET['id'] : '';
	$post = get_post( $post_id );
    $type = 'jeeps';
    $args=array(
    'post_type' => $type,
    'post_status' => 'publish',
    'author'   => $current_user->ID, // Replace $user_id with the actual user ID

    );
    $query = new WP_Query($args);
    $jeep_post = get_post( get_post_meta($post_id, 'active_duck', true) );

    function encryptData($data) {
        $ciphering = "AES-128-CTR";
        $iv_length = openssl_cipher_iv_length($ciphering);
        $options = 0;
        $encryption_iv = '1234567891011121';
        $encryption_key = "W3docs";
        return  openssl_encrypt($data, $ciphering, $encryption_key, $options, $encryption_iv);
      }
?>

<section class="sec_main">
	<div class="sec_row">
		<?php get_template_part('templates/includes/menu', 'template'); ?>
		<div class="content_main">
			<div class="inner_header">
					<h1 class="heading_top">Add New Duck</h1>
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
				<div class="gen_new_box">
					<div class="row" style="justify-content: space-between;">
						<div class="col-lg-8 col-md-8 col-sm-12 col-12">
							<h1 class="gen_heading pb-5">Fill the form below to add new duck</h1>
							<form method="post" class="row" id="addDuck" enctype="multipart/form-data">
								<!-- Duck Form -->
									<div class="col-lg-12 col-md-12 col-sm-12 col-12">
										<div class="form_group mb-4" id="name-div" >
										<label for="" class="gen_label">Duck name</label>
										<input type="text" name="duck_name" id="duck-name" placeholder="Enter Name" value="<?= $post_id ? get_the_title(get_post_meta($post->ID, 'duck_id', true) ) : '' ?>" class="gen_input" required <?= $post_id ? 'readonly' : '' ?> >
									</div>
									</div>
                                    <div class="col-lg-12 col-md-12 col-sm-12 col-12">
										<div class="form_group mb-4">
										<label for="" class="gen_label">Select Jeep</label>
                                        <select class="form_control" name = "jeep" id="jeep" required>
                                            <option value="" selected disabled hidden>Choose here</option>
                                                <?php 
                                                   if ( $post_id ) { ?> 
                                                            <option value ="<?= $jeep_post->ID ?>"  name = "<?= $jeep_post->ID?>" selected><?= $jeep_post->post_title ?>
                                                        </option>
                                                        <?php 
                                                    } else {
                                                        if( $query->have_posts() ) {
                                                            while ($query->have_posts()) : $query->the_post(); 
                                                            ?>
                                                                <option value ="<?= the_ID() ?>"  name = "<?= the_ID() ?>" ><?= the_title() ?>
                                                                </option>
                                                            <?php  
                                                            endwhile;
                                                        }    
                                                    }
                                                    wp_reset_query();
                                                ?>
                                        </select>
									</div>
                                    
                                    <!-- Stripe Element -->
									<div class="form_group mb-4">
                                        <div id="card-element"></div> 
                                          <!-- Used to display form errors -->
                                        <div id="card-errors" role="alert"></div>

                                    </div>	
								</div>
								    <!-- End -->
								<div class="col-12">
									<div class="form_group mt-4">
										<button class="submit_btn edit_btn"><?= $post_id ? 'Update Duck' : 'Add New Duck'  ?></button>
									</div>
								</div>
								<input type="hidden" name="action" value="add_duck" />
                                <input type="hidden" name="jeep_id" value="<?=  get_post_meta($post_id, 'active_duck', true)    ?>" />
								<input type="hidden" id= "duck-id" name="duck_id" value="" />
							</form>
						</div>
						<div class="col-lg-4 col-md-4 col-sm-12" <?= $post_id ? 'style="display:block"' : 'style="display:none"'  ?>>
							<!--   <button class="submit_btn edit_btn showqr" data="<?= $post_id  ?>">Show QR Code</button> -->

							<div class="gen_new_box xy-center" style="padding: 20px;">
								<div class="row" style="padding-bottom: 0px;">
									<div class="col-lg-12 col-md-12 col-sm-12 mb-1">
										<div id="qrcode"></div>
									</div>
									<div class="col-lg-6 col-md-6 col-sm-12 mt-1">
										<h5>Serial No : <b><?=  encryptData($post_id) ?></b></h5>
									</div>
									<div class="col-lg-6 col-md-6 col-sm-12 text-end mt-1">
										<i class="fa fa-download" style="font-size:24px"></i>
									</div>
								</div>
							</div>
						</div>
						<div class="col-lg-4 col-md-4 col-sm-12 col-12" <?= $post_id ? 'style="display:none"' : 'style="display:block"'  ?>>
							<button style="margin-bottom: 20px;" class="submit_btn edit_btn" id="startButton">Start Scan</button>
							<video style="width:100%" id="scanner-camera" playsinline autoplay></video>
							<!-- <div id="result"></div> -->
						</div>
					</div> 
				</div>
			</div>
		</div>
	</div>
</section>
<?php get_footer('footer'); ?>
<script>
(function($){ 
    $(document).ready(function(){      
        // stripe 
        var stripe = Stripe('pk_test_51MTv5mDvdkIAX53sPrbH9lKokXRpHH89qBb2WldkNBlHFzNOZX7FNSn0WubzTzOGNlCkh5DU3gicu2iHymq6veUj00fWeLPfCC');
		var elements = stripe.elements();
		var cardElement = elements.create('card');
		cardElement.mount('#card-element');

        
        // Handle real-time validation errors from the card Element
        cardElement.addEventListener('change', function(event) {
            var displayError = document.getElementById('card-errors');
            if (event.error) {
            displayError.textContent = event.error.message;
            } else {
            displayError.textContent = '';
            }
        });

            // Add Duck
        $("#addDuck").submit(function(e) {
            e.preventDefault();
            var form = new FormData(this);
            $(this).find('button.submit_btn').append('<i class="fa fa-spinner fa-spin" style="font-size:24px"></i>');
            $(this).find('button.submit_btn').prop('disabled',true);
            var thiss = $(this);
            stripe.createToken(cardElement).then(function(result) {
                if (result.error) {
                    // Handle error
                    // Display error to the user
                    var errorElement = document.getElementById('card-errors');
                    errorElement.textContent = result.error.message;
                    $('.fa.fa-spinner.fa-spin').remove();
                    $(thiss).find('button.submit_btn').prop('disabled',false);
                    console.error(result.error);
                } else {
                    // Attach the token or source to the form data
                    form.append('stripeToken', result.token.id);
                    $.ajax({
                        type: 'post',
                        url: '<?= admin_url( 'admin-ajax.php' ); ?>',
                        data: form, // Use FormData directly
                        dataType : 'json',
                        cache:false,
                        contentType: false,
                        processData: false,
                        success: function (response) {
                            $('.fa.fa-spinner.fa-spin').remove();
				            $(thiss).find('button.submit_btn').prop('disabled',false);
                            if(!response.status){
                                Swal.fire({
                                title: "Error!",
                                text: response.message,
                                icon: "warning",
                                button: "Close",
                                });
                            }
                            else{
                                $('#addDuck')[0].reset();
                                Swal.fire({
                                    icon: 'success',
                                    title: response.message,
                                    showConfirmButton: false,
                                    timer: 2500
                                });
                                window.location.href = response.redirect;
                            }
                          
                        },
                        error : function(errorThrown){ 
                        console.log(errorThrown);
                    }
                    });
                }
            }); 
        }); 
       

         // Capture click event on download icon
        $('.fa-download').on('click', function () {
        // Get the source of the image
        var imageUrl = $('#qrcode img').attr('src');
            console.log(imageUrl);

        // Create a temporary link element
        var downloadLink = document.createElement('a');
        downloadLink.href = imageUrl;
        downloadLink.download = 'downloaded_image.jpg';

        // Append the link to the body and trigger the click event
        document.body.appendChild(downloadLink);
        downloadLink.click();

        // Remove the link from the body
        document.body.removeChild(downloadLink);
        });

    });
})(jQuery);
</script>
<script>
    // Qr code generate
    // Get the element where you want to render the QR code
    var qrcodeContainer = document.getElementById("qrcode");
    // Text/content for the QR code
    <?php if (isset($post_id) && !empty($post_id)) : ?>
    var qrText = '<?= encryptData($post_id); ?>';
    console.log("qrText-->",qrText);
    // Create QR code instance
    var qr = new QRCode(qrcodeContainer, {
    text: qrText,
    width: 128,
    height: 128,
    });
    <?php endif; ?>
    // scan qr code
    const video = document.getElementById('scanner-camera');
    const startButton = document.getElementById('startButton');
    // const resultContainer = document.getElementById('result');

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
                       // resultContainer.innerHTML  = result.text;
                        ajaxCall(result);
                        // Stop the video stream and hide the video element
                        codeReader.reset();
                    }
                    if (error) {
                        console.error('QR Code error:', error);
                        // resultContainer.innerText = 'Error: ' + error;
                        
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

    const  duckNameDiv = document.getElementById('name-div');
    const duckNameElement = document.getElementById('duck-name');
    const duckId = document.getElementById('duck-id');

    
    // alert(data);
    // function execute after request is successful 
    var xhr = new XMLHttpRequest();
    xhr.onreadystatechange = function () {
        if (xhr.readyState === 4 && xhr.status === 200) {
             // Parse the JSON response
            var response = JSON.parse(xhr.responseText);
              // Set the duck's name and image on the page
            duckNameElement.value  = response.data.duck_name;
            duckNameDiv.style.display  = 'none';
            duckId.value  = response.data.duck_id;
           // alert(this.responseText);

        }
    };
    xhr.open('POST', '<?php echo admin_url('admin-ajax.php'); ?>', true);
    xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
    xhr.send('action=getQRCode&data=' + data);
}
</script>