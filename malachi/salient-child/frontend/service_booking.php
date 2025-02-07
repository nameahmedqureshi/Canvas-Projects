<?php
function encryptData($data) {
    $ciphering = "AES-128-CTR";
    $iv_length = openssl_cipher_iv_length($ciphering);
    $options = 0;
    $encryption_iv = '1234567891011121';
    $encryption_key = "W3docs";
    return  openssl_encrypt($data, $ciphering, $encryption_key, $options, $encryption_iv);
}

function service_booking(){
$args = [
    'post_type'      => 'services',
    'posts_per_page' => -1,
    'post_status' => 'publish',
];
$services = new WP_Query($args);

// var_dump($data);

$services_categories = get_terms( array(
    'taxonomy' => 'services-category',
    'orderby' => 'name',
    'order'   => 'ASC',
    'hide_empty' => false, // Change to false to show categories even if they have no posts
) );


?>
<link rel="stylesheet" href='https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/css/toastr.min.css'>
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/waitme@1.19.0/waitMe.min.css">
<script src='https://cdn.jsdelivr.net/npm/waitme@1.19.0/waitMe.min.js'></script>
<script src='https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/js/toastr.min.js'></script>

<style>
    div#card-element {
        padding: 20px;
        background: #e8edf4;
        width: 100%;
        margin-top: 20px;
    }
    .service_form form {
        margin-top: 20px;
    }
   button.book_button {
    background-color: #084025;
    color: #ffff;
    font-size: 16px;
    padding: 5px 50px;
    cursor: pointer;
    margin-top: 10px;
    }
    .single_service img {
        width: 30% !important;
    }

    button.apply_now {
        background-color: #084025;
        color: #ffff;
        font-size: 22px;
        padding: 10px 50px;
        cursor: pointer;
    }

    .service_detail {
        /* padding-top: 35px; */
        width: 100%;
    }
    .book_service_details {
        display: flex;
        padding: 0px 50px 0px 30px;
        justify-content: space-between;
        align-items: center;
        border-bottom: 1px solid #80808057;
        margin-bottom: 5px;
    }
    .single_service h1 {
        width: 100%;
    }
    .book_service_details h1 {
        font-size: 17px;
        /* width: 39%; */
        line-height: 30px;
        font-family: 'font2' !important;
        margin-bottom: 0;
        margin-left: 30px;
    }
    .booK_pricing {
        display: flex;
        width: 100%;
    }
    .single_box p {
        width: 87%;
    }
    .booK_pricing p {
        font-size: 13px;
        text-align: left;
        margin: 0px 10px;
        padding-bottom: 0 !important;
        margin-bottom: 0 !important;
    }
    .booK_pricing p span {
        margin: 0px 6px;
        font-weight: 600;
        font-size: 16px;
    }

    .service_form button.service_submit {
        width: 100%;
        margin: unset;
        margin-top: 20px;
    }

    .modal {
        display: none;
        position: fixed;
        z-index: 1000;
        left: 0;
        top: 0;
        width: 100%;
        height: 100%;
        overflow: auto;
        background-color: rgba(0, 0, 0, 0.5);
    }
    .modal-contents {
        margin: 8% auto;
        padding: 20px;
        width: 100%;
        display: flex;
        justify-content: center;
    }

    .form-box {
        max-width: 30%;
        background: #f1f7fe;
        overflow: hidden;
        border-radius: 16px;
        color: #010101;
        padding: 20px;
    }

    .form-box .close {
        right: 3%;
        top: 3%;
        font-size: 19px;
        z-index: 9999;
    }
    .close {
        color: #aaa;
        float: right;
        font-size: 28px;
        font-weight: bold;
    }
    form.service_form {
        padding: 30px 10px 30px 40px;
    }
    .service_form {
        display: flex;
        flex-wrap: wrap;
    }
    
    p.catgory {
        color: green;
        font-size: 20px;
        font-weight: 600;
    }
    .product-grid {
        display: flex;
        gap: 20px; /* Adjust spacing between product items */
    }
    .product-item {
    width: 19%;
    border: 1px solid #ccc;
    padding-bottom: 20px;
    text-align: center;
    margin-bottom: 20px;
	transition:0.5s ease all;
    }
        section.service_booking .col.span_10 .service_book .product-grid {
        display: flex;
        gap: 1%;
        flex-wrap: wrap;
    }

    .product-image img {
        width: 100%; /* Make the image fill the container */
        height: auto; /* Maintain the aspect ratio */
    }

    .product-title {
        font-size: 24px !important;
        font-weight: bold !important;
        margin: 10px 0;
    }
    .product-price {
        font-size: 14px !important;;
        color: #333;
    }
    .product-author, .product-posted {
        font-size: 12px;
        color: #666;
    }
    .product-details p {
        padding-bottom: 3px !important;
		font-size:14px;
    }
    .product-item:hover {
        border-bottom: 3px solid #A52A2A; /* Add a bottom border on hover */
		background: #f1f1f1;
		transform: scale(1.05);
    }
    p.catgory {
        padding-bottom: 0;
    }

    .service_form label {
        font-size: 19px;
        color: #000;
        text-transform: capitalize;
    }

    button.service_submit {
        background-color: #084025 !important;;
    }

    button.service_submit:hover {
        background: #000 !important;
    }



    @media (max-width: 1600px) {
        .form-box {
            max-width: 40%;
        }
    }
  


</style>
<section class="service_booking">
    <div class="main-content">
        <div id="service_book">
            <div class="col span_2">
                <h2>Categories</h2>
                <ul id="categories_list">
                    <input type="radio" name="services_categories" id="all" class="services_categories" value="all" >
                    <label for="all">All</label><br>
                    
                    <?php if ( ! empty( $services_categories ) && ! is_wp_error( $services_categories ) ) {
                        foreach ( $services_categories as $category ) { ?>
                           <input type="radio" name="services_categories" id="<?=  esc_attr( $category->name ) ?>" class="services_categories" value="<?=  esc_attr( $category->term_id ) ?>" >
                           <label for="<?=  esc_attr( $category->name ) ?>"><?=  esc_attr( $category->name ) ?></label><br>
                        <?php   }
                        
                    } ?>
                </ul>
            </div>
            <div class="col span_10">
                <div class="service_book">
                    <!-- <div class="accordion"> -->
                    <div class="product-grid">

                        <?php foreach ($services->posts as $key => $value) {
                            $price =  get_post_meta($value->ID, 'price', true); ?>
                            <div class="product-item">
                                <div class="product-image">
                                    <img src="<?= !empty(get_the_post_thumbnail_url( $value->ID ) ) ? get_the_post_thumbnail_url( $value->ID )  : get_stylesheet_directory_uri().'/store/assets/images/no-preview.png'; ?>" alt="Service Image">
                                </div>
                                <div class="product-details">
                                    <p class="catgory">
                                        <?php
                                            $post_categories = wp_get_post_terms($value->ID, 'services-category', array('fields' => 'names'));
                                            echo implode(', ', $post_categories);
                                        ?>
                                    </p>
                                    <h3 class="product-title"><?= get_the_title($value->ID) ?></h3>
                                    <p class="product-content"><?= get_the_excerpt($value->ID) ?></p>
                                    <p class="product-price">$<?= number_format($price, 2, '.', ''); ?></p>
                                    <p class="product-author">Author: <?= get_post_meta($value->ID, 'vendor', true) ?></p>
                                    <p class="product-posted">Posted: <?= get_the_date('', $value->ID) ?></p>
                                    <button class="book_button" type="button"  data-id="<?= encryptData($value->ID) ?>" data-user="<?= encryptData($value->post_author) ?>">Book</button>
                                </div>
                            </div>
                        <?php } ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<div id="Booking_Modal" class="modal main_service">
    <div class="modal-contents">
        <div class="form-box">
            <i class="fa fa-times close" aria-hidden="true"></i>
            <div class="booking">
                <form class="service_form">
                    <div class="service_detail">
                        <div class="book_service_details single_service">
                            <img src="" alt="">
                            <h1></h1>
                            <div class="booK_pricing single_box">
                                <p><span></span></p>
                            </div>
                        </div>
                    </div>
                    <label>Instruction</label>
                    <textarea id="comment" name="comment" rows="4" cols="50"></textarea>
                    <div id="card-element"></div> 
                    <input type="hidden" name="post_id" value="<?= encryptData($value->ID) ?>">
                    <input type="hidden" name="action" value="buy_service">
                    <button class="service_submit" type="submit">Book</button>
                </form>
            </div>
        </div>
    </div>
</div>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://js.stripe.com/v3/"></script>

<script>
    $(document).ready(function() {

        var stripe = "";
        var cardElement = "";

        $(document).on( 'click', ".book_button", function(){
            
            // var stripe = "";
            // var cardElement = "";
            $('#card-element').empty();

            $("#Booking_Modal").fadeIn();

            var mainServiceBox = $(this).parents('.product-item');
            var service_img = mainServiceBox.find("img").attr("src");
            var service_id = mainServiceBox.find("book_button").attr("data-id");
            var service_title = mainServiceBox.find(".product-title").text();
            var single_price_text = mainServiceBox.find(".product-price").text();

            $('.single_service img').attr('src',service_img);
            $('.single_service h1').text(service_title);
            $('.single_service span').text(single_price_text);

            var user = $(this).attr('data-user');
            // $('.user').val(user);

            // stripe 
            stripe = Stripe("pk_test_51PNfoGAOqJbE4AIGUB2S5oYWIWMRjB0N4otuUHZKgYZk7TwZ3MDhFN1lJQqq3JoFfyHzvMWoA2bRH3SecQ1L8VdF00XTYhOqiJ");
            var elements = stripe.elements();
            cardElement = elements.create('card', {
                hidePostalCode: true,
            });
            cardElement.mount('#card-element');

            // jQuery.ajax({
            //     type: 'post',
            //     url: "<?= admin_url( 'admin-ajax.php') ?>",
            //     data: {
            //         action: 'get_publishable_key',
            //         user: user,
            //     },
            //     dataType : 'json',
            //     success: function (response) {
            //         // stripe 
            //         var pub_key = response.publishable_key;
            //         stripe = Stripe(pub_key);
            //         var elements = stripe.elements();
            //         cardElement = elements.create('card', {
            //             hidePostalCode: true,
            //         });
            //         cardElement.mount('#card-element');
                    
            //         },
            //         error : function(errorThrown){
            //         console.log(errorThrown);
            //     }
            // });
            
        });

        $(".close").click(function(){
            $("#Booking_Modal").fadeOut();
        });
            

        // $('.accordion-header').click(function() {
        //     // Hide all accordion contents
        //     $('.accordion-content').slideUp();
        //     // Reset all arrows
        //     $('.arrow').removeClass('arrow-up').addClass('arrow-down');

        //     // Check if the clicked header's content is not already open
        //     if (!$(this).next('.accordion-content').is(':visible')) {
        //         // Open the clicked header's content
        //         $(this).next('.accordion-content').slideDown();
        //         // Rotate the arrow
        //         $(this).find('.arrow').removeClass('arrow-down').addClass('arrow-up');
        //     }
        // });

        $(document).on( 'change', '.services_categories', function(e) {
            e.preventDefault();
            var category = $(this).val();
            jQuery('.product-grid').waitMe({
                effect : 'bounce',
                text : '',
                bg : 'rgba(255,255,255,0.7)',
                color : '#000',
                maxSize : '',
                waitTime : -1,
                textPos : 'vertical',
                fontSize : '',
                source : '',
            });
        
            jQuery.ajax({
                type: 'post',
                url: "<?= admin_url( 'admin-ajax.php' ); ?>",
                data: { category:category, action:"get_selected_category_services"},
                dataType : 'json',
                success: function (response) {
                    jQuery('.product-grid').waitMe('hide');
                    // console.log(response.html);

                    if(!response.status){
                        toastr.error(response.message,"Error")
                    } else {
                        $('.product-grid').html(response.html)
                    }
                },
                error : function(errorThrown){
                    jQuery('.product-grid').waitMe('hide');
                    console.log(errorThrown);
                }
            });
        });

        // buy service
        $(".service_form").submit(function(e) {
            e.preventDefault(); // avoid to execute the actual submit of the form.
            var form = new FormData(this);
            // console.log('stripe', stripe);
            $(this).find('button[type=submit]').append('<i class="fa fa-spinner fa-spin" style="font-size:24px"></i>');
            $(this).find('button[type=submit]').prop('disabled', true);
                var thiss = $(this);
            $('body').waitMe({
                effect: 'bounce',
                text: '',
                bg: 'rgba(255,255,255,0.7)',
                color: '#000',
                maxSize: '',
                waitTime: -1,
                textPos: 'vertical',
                fontSize: '',
                source: '',
            });
            stripe.createToken(cardElement).then(function(result) {
                if (result.error) {
                    // Handle error
                    Swal.fire({
                        title: "Error",
                        text:  result.error.message,
                        icon: "error",
                    })
                    console.log(result.error);
                    jQuery('.fa.fa-spinner.fa-spin').remove();
                    jQuery('body').waitMe('hide');
                    jQuery(thiss).find('button[type=submit]').prop('disabled',false); 
                    return;
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
                            jQuery('.fa.fa-spinner.fa-spin').remove();
                            jQuery('body').waitMe('hide');
                            jQuery(thiss).find('button[type=submit]').prop('disabled',false);
                            if(!response.status){
                                toastr.error(response.message, response.title);
                            }
                            else{
                                toastr.success(response.message, response.title);
                                if (response.auto_redirect) {window.location.href = response.redirect_url;}
                            } 
                        },
                        error : function(errorThrown){ 
                            console.log(errorThrown);
                            jQuery('body').waitMe('hide');

                        }
                    });
                }
            }); 
        });

        // $('#categories_list input[type="radio"]:first').click();

        // jQuery(".service_form").fadeOut();
        // jQuery(".apply_now").click(function(){
        //     jQuery(".service_form").fadeIn();
        // });
    });
</script>
<?php }
add_shortcode('service_booking_form', 'service_booking'); ?>