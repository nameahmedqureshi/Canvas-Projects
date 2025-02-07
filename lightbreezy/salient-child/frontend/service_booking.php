<?php 
function services_booking(){

    
    if (!is_user_logged_in()) {
        wp_redirect( home_url('login') );
        exit();
    }
    $id = isset($_GET['id']) ? $_GET['id'] : 0;
    $meta = get_post_meta( $id);
    $args = array(
        'post_type' => 'services', 
        'posts_per_page' => -1
    );
    $query = new WP_Query($args);
?>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.1/css/all.min.css" integrity="sha512-MV7K8+y+gLIBoVD59lQIYicR65iaqukzvf/nwasF0nqhPay5w/9lJmVM2hMDcnK1OnMGCdVK+iQrJ7lzPJQd1w==" crossorigin="anonymous" referrerpolicy="no-referrer" />
<!-- Include the PayPal JavaScript SDK -->
<script src="https://www.paypal.com/sdk/js?client-id=BAAnS3DMgciO_mBSav69jnECjMXJ_0snwx8OxgwkdrsBt8Cq0ORqApzFt8pIH6NYwX_3f9rRSQXNzEHGl8" data-sdk-integration-source="button-factory"></script>
<!-- <script src="https://www.paypal.com/sdk/js?client-id=Ae4_SRU8Yftk9uZlQhj0bCfU8Ryaft8hN-HMLOZssXNaJ5Z1ZVbguiFiDtbWLtihJ9bqgl0xZ8KBkPjB" data-sdk-integration-source="button-factory"></script> -->
<style>
    	div#paypal-buttons {
            margin-top: 20px;
            opacity: 0.3;
            pointer-events: none;
        }

        div#calendar_header {
        display: flex;
        justify-content: center;
        align-items: center;
    }
        div#calendar_header .fa.fa-angle-left:before {
        content: "\f104" !important;
    }
    .radio-list {
        display: flex;
        flex-wrap: wrap;
    }
        div#calendar_header .fa.fa-angle-right:before {
        content: "\f105" !important;
    }

    .form-check {
        margin-right: 10px; /* Adjust spacing between slots */
        margin-bottom: 10px;
        border: 1px solid #ccc; /* Add border to each slot */
        border-radius: 5px; /* Add border radius */
    }

    .form-check-label {
        display: block;
        padding: 10px; /* Add padding inside each slot */
        cursor: pointer;
    }

    .form-check-input {
        display: none;
    }

        .form-check-input:checked + .form-check-label {
        background-color: #ea6783;
        color: #fff;
        outline: unset !important;
        border: unset !important;
    }
        #calendar {
        margin-right: 2%;
        width: 565px !important;
        font-family: 'Lato', sans-serif;
    }
        .col.span_12.price {
        margin-top: 20px;
    }
  #calendar_weekdays div{
      display:inline-block;
      vertical-align:top;
  }
    #calendar_content, #calendar_weekdays, #calendar_header {
        position: relative;
        width: 496px !important;
        overflow: hidden;
        float: left;
        z-index: 10;
    }
        #calendar_weekdays div, #calendar_content div {
        width: 70.7px !important;
        height: 50px !important;
        overflow: hidden;
        text-align: center;
        background-color: #FFFFFF;
        color: #787878;
    }
  #calendar_content{
      -webkit-border-radius: 0px 0px 12px 12px;
      -moz-border-radius: 0px 0px 12px 12px;
      border-radius: 0px 0px 12px 12px;
  }
  #calendar_content div{
      float: left;
  }
  #calendar_content div:hover{
      background-color: #F8F8F8;
  }
  #calendar_content div.blank{
      background-color: #E8E8E8;
  }
  #calendar_header, #calendar_content div.active{
      zoom: 1;
      filter: alpha(opacity=70);
      /* opacity: 0.7; */
  }
  #calendar_content div.active {
    color: #FFFFFF;
    background-color: #ea6783;
    }
  #calendar_header{
      width: 100%;
      /* height: 37px; */
      text-align: center;
      /* background-color: #191970; */
      background-color: rgb(184 96 249);
      padding: 14px 0px 5px 0px;
      -webkit-border-radius: 12px 12px 0px 0px;
      -moz-border-radius: 12px 12px 0px 0px;
      border-radius: 12px 12px 0px 0px;
  }
  #calendar_header h1{
      font-size: 1.5em;
      color: #FFFFFF;
      float:left;
      width:70%;
  }
  i[class^=icon-chevron]{
      color: #FFFFFF;
      float: left;
      width:15%;
      border-radius: 50%;
  }
  .fa-angle-left:before ,.fa-angle-right:before {
      font-family: 'FontAwesome';
      cursor: pointer;

  }
  .select-date {
      cursor: pointer;
      font-weight: bold;
  }

  #calendar .disabled {
      cursor: not-allowed;
      opacity: 0.65;
  }

  .form-check.booked {
    background: #cbcbcb;
    color: white;
    }

    #service {
    -webkit-appearance: none;
    -moz-appearance: none;
    text-indent: 1px;
    text-overflow: '';
    }
	.special_req{
		margin-left: 2%;
	}
	
	#paypal-buttons, .price{
		margin-left: 5%;
	}

</style>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<section class="service_inner">
    <div class="container">
        <div class="row wpb_row vc_row-fluid vc_row top-level vc_row-o-equal-height vc_row-flex vc_row-o-content-middle" id="service_booking">
            <form id="service_order" class="service_order">
                <?php
                if (is_user_logged_in()) {
                    $current_user = wp_get_current_user();
                    $first_name = $current_user->user_firstname;
                    $last_name = $current_user->user_lastname;
                    $phone = get_user_meta($current_user->ID, 'phone', true);
                    $email = $current_user->user_email;
                } else {
                    $first_name = '';
                    $last_name = '';
                    $phone = '';
                    $email = '';
                }
                ?>
                <div class="required">
                    <div class="col span_6">
                        <label for="first_name">First Name *</label><br>
                        <input type="text" id="first_name" name="first_name" value="<?= esc_attr($first_name); ?>">
                    </div>
                    <div class="col span_6">
                        <label for="last_name">Last Name *</label><br>
                        <input type="text" id="last_name" name="last_name" value="<?= esc_attr($last_name); ?>">
                    </div>
                    <div class="col span_6">
                        <label for="phone">Phone *</label><br>
                        <input type="text" id="phone" name="phone" value="<?= esc_attr($phone); ?>">
                    </div>
                    <div class="col span_6">
                        <label for="email">Email *</label><br>
                        <input type="email" id="email" name="email" value="<?= esc_attr($email); ?>">
                    </div>
                    <div class="col span_6">
                        <label for="service">Service</label><br>
                        <select disabled id="service" name="service">
                            <option value="">Select a Service</option>
                            <?php
                            $services = get_posts(array('post_type' => 'services', 'posts_per_page' => -1));
                            foreach ($services as $service) { ?>
                                <option <?= $id == $service->ID ? "selected" : ""?> value="<?= $service->ID ?>"><?= $service->post_title ?></option>;

                            <?php  } ?>
                        </select>
                        <div id="dna_service" class="dna_service" <?= isset($meta['dna_check'][0]) && $meta['dna_check'][0] ? '' : 'style="visibility: hidden;"' ?> >
                            <label for="service_dna">Check DNA Option</label><br>
                            <!-- <select id="service_dna" name="service_dna" multiple>
                                <option value="">Select DNA</option> -->
                                <?php
                                    if (isset($meta['dna_option'][0]) && $meta['dna_option'][0]) {
                                        $lines = explode(PHP_EOL, $meta['dna_option'][0]);
                                        // Loop through each line and process it
                                        foreach ($lines as $key => $line) { ?>
                                            <!-- echo '<option value="'.$line.'">'.$line.'</option>'; -->
                                            <input type="checkbox" id="DNA<?= $key ?>" name="service_dna[]" value="<?= htmlspecialchars($line) ?>">
                                            <label for="DNA<?= $key ?>"><?= htmlspecialchars($line) ?></label><br>
                                <?php   }
                                    }
                                ?>
                            <!-- </select> -->
                        </div>
                    </div>
                </div>
                <div class="col span_6 special_req">
                    <label for="client_requests">Special Requests</label><br>
                    <textarea id="client_requests" name="client_requests"></textarea>
                </div>

                <?php if ($meta['servic_type'][0] != "recorded") { ?>
					
                    <div class="col span_6" id="calendar">
						<label class="form-label" >Select Time Slots</label>
                        <div id="calendar_header">
                            <i class="icon-chevron-left fa fa-angle-left"></i>
                            <h1></h1>
                            <i class="icon-chevron-right fa fa-angle-right"></i>
                        </div>
                        <div id="calendar_weekdays"></div>
                        <div id="calendar_content"></div>
                    </div>

                <?php } ?>

                <div class="col span_6" >

                    <?php if ($meta['servic_type'][0] != "recorded") { ?>
                        
                        <div class="position-relative" id="slotsParent">
                            <div class="radio-list">
                                <!-- <div class="form-check">
                                    <input class="form-check-input" type="radio" name="time_slot" value="slot1" id="slot1">
                                    <label class="form-check-label" for="slot1">
                                        8:00 AM - 9:00 AM
                                    </label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="time_slot" value="slot2" id="slot2">
                                    <label class="form-check-label" for="slot2">
                                        9:00 AM - 10:00 AM
                                    </label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="time_slot" value="slot3" id="slot3">
                                    <label class="form-check-label" for="slot3">
                                        10:00 AM - 11:00 AM
                                    </label>
                                </div> -->
                                <!-- Add more time slots here -->
                            </div>
                        </div>
                    <?php } ?>

                    <div class="price">
                        <label>Prices:</label><br>
                        <?php if( isset($meta['dna_check'][0]) && $meta['dna_check'][0] ) { ?>
                        <span class="booking_price">$0</span>
                        <input type="hidden" name="service_price" value="<?= $meta['price'][0] ?>">
                        <input type="hidden" value="<?= $meta['price'][0] ?>" class="service_price">
                        <?php } else { ?>
                        <span class="booking_price">$<?= $meta['price'][0] ?></span>
                        <input type="hidden" name="service_price" value="<?= $meta['price'][0] ?>">
                        <input type="hidden" value="<?= $meta['price'][0] ?>" class="service_price">

                        <?php }  ?>
                    </div>
                    <?php if ($meta['servic_type'][0] != "in_person") { ?>
                    <div id="paypal-buttons"></div>
                    <?php }  ?>
                </div>
                <div class="col span_12">
                    <input type="hidden" value="" name="date">
                    
                    <input type="hidden" value="service_order" name="action">
                    <input type="hidden" name="service" value="<?= $id ?>">

                    <?php if ($meta['servic_type'][0] == "in_person") { ?>
                    <button type="submit" class="button">Submit</button>
                    <?php }  ?>
                </div>
            </form>
        </div>
    </div>
</section>
<script src="
https://cdn.jsdelivr.net/npm/waitme@1.19.0/waitMe.min.js"></script>
<link href="https://cdn.jsdelivr.net/npm/waitme@1.19.0/waitMe.min.css" rel="stylesheet">
<script>
 jQuery(document).ready(function() {

    // jQuery("#service_dna").select2({
    //     placeholder: 'Select DNA',
    // });

    //paypal btns availability conditions

    $('.required input').on('input', function() {
        // Check if all input fields are filled
        var allFieldsFilled = $('.required input').filter(function() {
            return $(this).val() !== '';
        }).length === $('.required input').length;

        // Update styles of the "paypal-buttons" div based on the condition
        if (allFieldsFilled) {
            $('#paypal-buttons').css({
                'pointer-events': 'auto',
                'opacity': '1'
            });
        } else {
            $('#paypal-buttons').css({
                'pointer-events': 'none',
                'opacity': '0.3'
            });
        }
    });

    jQuery(document).on('change', 'input[name="slots"]' , function() {

        var checkedSlots = parseInt(jQuery('input[name="slots"]:checked').length);
        if(checkedSlots > 0){
            $('#paypal-buttons').css({
                'pointer-events': 'auto',
                'opacity': '1'
            });
        }else {
            $('#paypal-buttons').css({
                'pointer-events': 'none',
                'opacity': '0.3'
            });
        }
    });

    if (!$('#calendar').length ) {
        $('#paypal-buttons').css({
            'pointer-events': 'auto',
            'opacity': '1'
        });
    } 
    if ($('input[name="service_dna[]"]').length ) {
        $('#paypal-buttons').css({
            'pointer-events': 'none',
            'opacity': '0.3'
        });
    }

    //paypal btns availability conditions end

    jQuery('input[name="service_dna[]"]').change(function() {
        var checkedDna = parseInt(jQuery('input[name="service_dna[]"]:checked').length);
        if(checkedDna > 0){
            var OriginalPrice = parseInt(jQuery('input[name="service_price"]').val());
            checkedDna = checkedDna ? checkedDna : 1;
            var totalPrice = checkedDna * OriginalPrice;
            jQuery(".booking_price").text("$"+totalPrice);
            $('#paypal-buttons').empty(); // Clear previous paypal buttons
            renderPayPalButtons(totalPrice);
            $('#paypal-buttons').css({
                'pointer-events': 'auto',
                'opacity': '1'
            });

            console.log('At least one checkbox is checked.');
        } else {
            jQuery('.booking_price').text('$0');
            $('#paypal-buttons').css({
                'pointer-events': 'none',
                'opacity': '0.3'
            });
        }
        

    });

    jQuery('#service').change(function() {
        var serviceId = jQuery(this).val();
        if(serviceId) {
            jQuery.ajax({
                url: '<?= admin_url('admin-ajax.php'); ?>',
                type: 'POST',
                data: {
                    action: 'get_service_price',
                    service_id: serviceId
                },
                success: function(response) {
                    if(response.success) {
                        jQuery('.booking_price').text('$' + response.data.price);
                        jQuery('input[name="service_price"]').val(response.data.price);
                    } else {
                        alert('Failed to retrieve service price.');
                    }
                }
            });
        } else {
            jQuery('.booking_price').text('$0.00');
            jQuery('input[name="service_price"]').val('0');
        }
    });
    
    jQuery(".service_order").submit(function(e) {
        e.preventDefault();

        // var form = new FormData(this);
        var form = jQuery(this).serialize();
        jQuery(this).find('button[type=submit]').append('<i class="fa fa-spinner fa-spin" style="font-size:24px"></i>');
        jQuery(this).find('button[type=submit]').prop('disabled', true);
        var $form = jQuery(this);
               
        jQuery.ajax({
            type: 'post',
            url: '<?= admin_url('admin-ajax.php'); ?>',
            data: 
            {
                action: 'service_order',
                form_data: form,
            },
            dataType : 'json',
            // cache: false,
            // contentType: false,
            // processData: false,
            success: function(response) {
                $form.find('.fa-spinner').remove();
                jQuery('body').waitMe('hide');
                $form.find('button[type=submit]').prop('disabled', false);
                if(!response.status){
                    Swal.fire({
                        title: response.title,
                        text: response.message,
                        icon: response.icon,
                    }).then(() => {
                        if (response.redirect_url) {
                            window.location.href = response.redirect_url;
                        }
                    });
                }
                else{
                    Swal.fire({
                        title: response.title,
                        text: response.message,
                        icon: response.icon,
                    }).then((willDelete) => {
                        if (response.redirect_url) {
                            window.location.href = response.redirect_url;
                        }
                    }); 
                } 
            },
            error: function(errorThrown) {
                console.log(errorThrown);
                $form.find('.fa-spinner').remove();
                $form.find('button[type=submit]').prop('disabled', false);
                jQuery('body').waitMe('hide');
            }
        });
          
    });


    function renderPayPalButtons(price) {

        paypal.Buttons({
            style: {
                shape: 'pill',
                color: 'gold',
                layout: 'vertical',
                label: 'pay'
            },
            createOrder: function(data, actions) {
                return actions.order.create({
                    purchase_units: [{
                        amount: {
                            value: price // Set the amount 
                        }
                    }]
                });
            },
            onApprove: function(data, actions) {
                return actions.order.capture().then(function(details) {
                    // var form = new FormData('#service_order');
                    // var $form = jQuery('#service_order');
                    var formData = $('.service_order').serialize();
                    jQuery.ajax({
                        type: 'post',
                        url: '<?= admin_url('admin-ajax.php'); ?>',
                       // data: form,
                        data: {
							action: 'service_order',
							form_data: formData,
                            payment_status: details.status,
                            payment_id: details.id,
						},
                        dataType: 'json',
                        // cache: false,
                        // contentType: false,
                        // processData: false,
                        success: function(response) {
                            jQuery('body').waitMe('hide');
                            if(!response.status){
                                Swal.fire({
                                    title: response.title,
                                    text: response.message,
                                    icon: response.icon,
                                }).then(() => {
                                    if (response.redirect_url) {
                                        window.location.href = response.redirect_url;
                                    }
                                });
                            }
                            else{
                                Swal.fire({
                                    title: response.title,
                                    text: response.message,
                                    icon: response.icon,
                                }).then((willDelete) => {
                                    if (response.redirect_url) {
                                        window.location.href = response.redirect_url;
                                    }
                                }); 
                            } 
                        },
                        error: function(errorThrown) {
                            console.log(errorThrown);
                            jQuery('body').waitMe('hide');
                        }
                    });
                });
            }
        }).render('#paypal-buttons');

    }

    var initialPrice = parseInt(jQuery('input[name="service_price"]').val());
    renderPayPalButtons(initialPrice);

    // jQuery('.dna_service').on('change', 'input[type="checkbox"]', function() {
    //     // Check if any checkbox is checked
    //     if (jQuery('.dna_service input[type="checkbox"]:checked').length > 0) {
    //         console.log('At least one checkbox is checked.');
    //     } else {
    //         jQuery('.booking_price').text('$0');
    //     }
    // });

    //jQuery('label[for="DNA0"]').click();
});
</script>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
<script>

        var days = <?= json_encode(isset($meta['slots'][0]) ? array_column(unserialize($meta['slots'][0]) ?? [], 'days') : []); ?>;
        // var blackOutDate = {!! json_encode(explode(",",str_replace(" ", "",$session?->blackout_dates))) !!};
        var blackOutDate =[];
        var monthLimit = 90;

        var date = "";

        $(document).on( 'click', '.select-date', function(e){
            $('#calendar').find('.active').removeClass('active');
            $(this).addClass('active');

            $('body').waitMe({
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

            date = $(this).attr('date');
            $('input[name=date]').val(date);
            var sessionId   =   $('#service').val();
            var weekday     =   $(this).attr('weekday');
            $.ajax({
                url: '<?= admin_url( 'admin-ajax.php' ); ?>',
                type: "POST",
                dataType : 'json',
                data: {date : date, id : sessionId, weekday : weekday, action:"get_slots"},
            }).done(function (data) {
                $('body').waitMe('hide');
                if(!data.status){
                    Swal.fire({
                        title: data.title,
                        text: data.message,
                        icon: data.icon,
                    });
                    return false;
                }
                      
                var html = '';
                $.each(data.slots, function(key,val){
                    if(jQuery.inArray(val, data.booked) != -1) {
                        html += `<div class="form-check booked">
                                    <label class="form-check-label">
                                        ${val}
                                    </label>
                                </div>`;
                    } else {
                        html += `<div class="form-check">
                                    <input class="form-check-input" type="radio" name="slots" value="${val}" id="${val}">
                                    <label class="form-check-label" for="${val}">
                                        ${val}
                                    </label>
                                </div>`;
                    }
                });
                $('#slotsParent .radio-list').html(html);
            });

        })


        function setCalender(){
            $(function () {
            function c() {
                p();
                var e = h();
                var r = 0;
                var u = false;
                l.empty();
                while (!u) {
                if (s[r] == e[0].weekday) {
                    u = true;
                } else {
                    l.append('<div class="blank"></div>');
                    r++;
                }
                }
                for (var c = 0; c < 42 - r; c++) {
                if (c >= e.length) {
                    l.append('<div class="blank"></div>');
                } else {
                    var v = e[c].day;
                    var  date1 = t+"/"+n+"/"+v;
                    var limit3month = twoDateDiffr(new Date(t, n - 1, v));
                    var attr = 'weekday="'+e[c].weekday+'" day="'+v+'" month="'+ n +'" year="'+t+'" date="'+date1+'"';
                    var blockDate = ifBlockDate(date1);
                    var allowDate = jQuery.inArray( e[c].weekday, days) !== -1;
                    var ifActive = (gNew(new Date(t, n - 1, v)) && allowDate && limit3month && blockDate) ? "select-date" : "disabled";
                    var m = g(new Date(t, n - 1, v)) ? '<div '+attr+' class="active '+ifActive+'">' : '<div '+attr+' class="'+ifActive+'">';
                    l.append(m + "" + v + "</div>");
                }
                }
                var y = o[n - 1];
                a.css("background-color", y)
                .find("h1")
                .text(i[n - 1] + " " + t);
                f.find("div").css("color", y);
                // l.find(".active").css("background-color", y);
                // l.find(".active").css("background-color", '#191970');
                d();
            }

            function ifBlockDate(date) {
                let parts = date.split('/'); // Split the date string by '/'
                let year = parts[0]; // Extract year
                let month = parts[1].padStart(2, '0'); // Extract month and pad with zero if needed
                let day = parts[2].padStart(2, '0'); // Extract day and pad with zero if needed

                let newDate = `${year}/${month}/${day}`;
                return jQuery.inArray( newDate, blackOutDate) == -1;
            }

            function twoDateDiffr(start){
                var end= new Date();
                tempDays = (start - end) / (1000 * 60 * 60 * 24);
                return (monthLimit) ? Math.round(tempDays) < monthLimit : true;
                // if (sectionLimit == 1) {
                //     return Math.round(tempDays) < 31;
                // } else if (sectionLimit == 4) {
                //     return Math.round(tempDays) < 121;
                // } else if (sectionLimit == 12) {
                //     return Math.round(tempDays) < 181;
                // } else if (sectionLimit == 24) {
                //     return Math.round(tempDays) < 365;
                // } else{
                //     return Math.round(tempDays) < 91;
                // }
            }
            function h() {
                var e = [];
                for (var r = 1; r < v(t, n) + 1; r++) {
                e.push({ day: r, weekday: s[m(t, n, r)] });
                }
                return e;
            }
            function p() {
                f.empty();
                for (var e = 0; e < 7; e++) {
                f.append("<div>" + s[e].substring(0, 3) + "</div>");
                }
            }
            function d() {
                var t;
                var n = $("#calendar").css("width", e+28 + "px");
                n.find((t = "#calendar_weekdays, #calendar_content"))
                .css("width", e + "px")
                .find("div")
                .css({
                    width: e / 7 + "px",
                    height: e / 7 + "px",
                    "line-height": e / 7 + "px"
                });
                n.find("#calendar_header")
                // .css({ height: e * (1 / 5) + "px" })
                // .find('i[class^="icon-chevron"]')
                // .css("line-height", e * (1 / 7) + "px");
            }
            function v(e, t) {
                return new Date(e, t, 0).getDate();
            }
            function m(e, t, n) {
                return new Date(e, t - 1, n).getDay();
            }
            function g(e) {
                return y(new Date()) == y(e);
            }
            function gNew(e) {
                // console.log(y(new Date()), y(e))
                // console.log(    new Date(y(new Date())).getTime() , e.getTime() )
                return new Date(y(new Date())).getTime() < e.getTime();
                // return y(new Date()) > y(e);
            }
            function y(e) {
                return e.getFullYear() + "/" + (e.getMonth() + 1) + "/" + e.getDate();
            }
            function b() {
                var e = new Date();
                t = e.getFullYear();
                n = e.getMonth() + 1;
            }
            var e = 480;
            var e = 350;
            var t = 2013;
            var n = 9;
            var r = [];
            var i = [
                "JANUARY",
                "FEBRUARY",
                "MARCH",
                "APRIL",
                "MAY",
                "JUNE",
                "JULY",
                "AUGUST",
                "SEPTEMBER",
                "OCTOBER",
                "NOVEMBER",
                "DECEMBER"
            ];
            var s = [
                "Sunday",
                "Monday",
                "Tuesday",
                "Wednesday",
                "Thursday",
                "Friday",
                "Saturday"
            ];
            var o = [
                "#f18ea4",
                "#f18ea4",
                "#f18ea4",
                "#f18ea4",
                "#f18ea4",
                "#f18ea4",
                "#f18ea4",
                "#f18ea4",
                "#f18ea4",
                "#f18ea4",
                "#f18ea4",
                "#f18ea4",
                "#f18ea4",
                "#f18ea4",
                "#f18ea4",
                "#f18ea4"
            ];
            var u = $("#calendar");
            var a = u.find("#calendar_header");
            var f = u.find("#calendar_weekdays");
            var l = u.find("#calendar_content");
            b();
            c();
            a.find('i[class^="icon-chevron"]').on("click", function () {
                var e = $(this);
                var r = function (e) {
                n = e == "next" ? n + 1 : n - 1;
                if (n < 1) {
                    n = 12;
                    t--;
                } else if (n > 12) {
                    n = 1;
                    t++;
                }
                c();
                };
                if (e.attr("class").indexOf("left") != -1) {
                r("previous");
                } else {
                    r("next");
                }
            });
            });
        }

        setCalender()
       
</script>
<?php 
}
add_shortcode('services_booking', 'services_booking');
?>