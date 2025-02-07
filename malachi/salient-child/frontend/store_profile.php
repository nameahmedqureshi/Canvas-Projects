<?php /* Template Name: Store Profile */   ?>
<?php get_header(); ?> 
<?php
$user_id = isset($_GET['id']) ? $_GET['id'] : '';
if($user_id){
    $store_details = get_user_meta($user_id, 'store_details', true);
    $store_pic = !empty($store_details) ? wp_get_attachment_url( $store_details['store_pic'] ) : get_stylesheet_directory_uri().'/store/assets/images/no-preview.png';
    
    $paged = get_query_var('paged') ? get_query_var('paged') : 1;
    $args = [
        'post_type' => 'product',
        'posts_per_page' => 20,
        'post_status'=> 'publish',
        'author' => $user_id, 
        'paged'=> $paged,
    ];


    $get_products = new WP_Query( $args );
} else {
    wp_redirect(home_url());
    exit;
}

?>
<style>

    div#tab1, div#tab2, div#tab3 {
        margin-top: 50px;
    }
    label.review-rating {
        pointer-events: none;
    }

    .rate {
        float: left;
        padding: 0 10px;
    }
    .rate:not(:checked) > input {
        position:absolute;
        top:-9999px;
    }
    .rate:not(:checked) > label {
        float:right;
        width:1em;
        overflow:hidden;
        white-space:nowrap;
        cursor:pointer;
        font-size:30px;
        color:#ccc;
    }
    .rate:not(:checked) > label:before {
        content: '★ ';
    }
    .rate > input:checked ~ label {
        color: #ffc700;    
    }
    .rate:not(:checked) > label:hover,
    .rate:not(:checked) > label:hover ~ label {
        color: #deb217;  
    }
    .rate > input:checked + label:hover,
    .rate > input:checked + label:hover ~ label,
    .rate > input:checked ~ label:hover,
    .rate > input:checked ~ label:hover ~ label,
    .rate > label:hover ~ input:checked ~ label {
        color: #c59b08;
    }

    span.page-numbers.current {
        background: #444444;
        color: #ffff;
        padding: 5px;
    }
    .pagination {
        text-align: center;
    }
    .search-container {
        display: flex;
        align-items: center;
        margin: 5px 0px 20px 0px;
        justify-content: end;
    }
    .search-input {
        width: 100%;
        padding: 10px;
        font-size: 16px;
        border: 2px solid #ccc;
        border-radius: 5px 0 0 5px;
        outline: none;
    }

    .search-button {
        padding: 10px;
        border: none;
        background-color: #4CAF50;
        color: white;  /* Font Awesome icons inherit the color */
        border-radius: 0 5px 5px 0;
        cursor: pointer;
    }

    .search-button i {
        font-size: 16px;
    }

    .search-button:hover {
        background-color: #45a049;
    }
    .profile {
        display: flex;
        justify-content: center;
        align-items: center;
        margin-top: 30px;
    }


    .profile_img img {
        width: 160px !important;
        height: 160px !important;
        object-fit: cover;
        object-position: top;
    }

    .profile_desc {
        padding: 20px;
    }

    .profile_info {
        display: flex;
        justify-content: center;
        align-items: center;
        margin-top: 60px;
    }

        .profile_info .profile_info_detail {
        margin: 0px 30px;
    }
        div#pro_bann img {
        height: 430px;
        width: 100%;
        object-fit: cover;
        object-position: center;
    }

    .profile_info .profile_info_detail i {
        color: #000;
        font-size: 22px;
        margin-bottom: 10px;
        border-radius: 50px;
        width: 50px;
        height: 50px;
        border: 1px solid #000;
        display: flex;
        justify-content: center;
        align-items: center;
    }

    .profile_info .profile_info_detail a {
        color: gray;
        font-size: 15px;
    }

    ul#tabs-nav {
        display: flex;
        justify-content: center;
    }

    ul#tabs-nav li {
        background: #000;
        list-style: none;
        width: 100%;
        padding: 10px;
        text-align: center;
    }
    /* Tabs */
    /* .tabs {
    width: 600px;
    background-color: #09F;
    border-radius: 5px 5px 5px 5px;
    } */
    ul#tabs-nav {
    list-style: none;
    margin: 0;
    padding: 5px;
    overflow: auto;
    }
    ul#tabs-nav li {
    float: left;
    font-weight: bold;
    margin-right: 2px;
    padding: 8px 10px;
    border-radius: 5px 5px 5px 5px;
    /*border: 1px solid #d5d5de;
    border-bottom: none;*/
    cursor: pointer;
    }
        ul#tabs-nav li:hover, ul#tabs-nav li.active {
        background-color: green;
    }
    #tabs-nav li a {
    text-decoration: none;
    color: #FFF;
    }
    button.search-button {
        padding: 15px !important;
        border-radius: unset !important;
        background: green;
    }
        .item_box {
        padding: 10px;
        box-shadow: 0px 0px 5px 0px #80808052;
    }
    .item_box {
        padding: 10px;
        box-shadow: 0px 0px 5px 0px #80808052;
    }

    .item_box img {
        width: 300px !important;
        height: 200px !important;
    }
    button.search-button {
        padding: 15px !important;
        border-radius: unset !important;
        background: green;
    }

    .reviews_box {
        display: flex;
        flex-wrap: nowrap;
        box-shadow: 0px 0px 4px 0px #8080806e;
        width: 48%;
        margin: 10px 10px;
    }
    div#feedback button {
        width: 20%;
        padding: 10px;
        background: #000;
    }
    div#reviews {
        display: flex;
        flex-wrap: wrap;
    }

    div#product_description {
        margin-top: 30px;
    }
    div#feedback input {
        background: transparent;
        border: 1px solid;
    }
    .reviews_box .col.span_2 {
        width: 12%;
    }
    div#feedback textarea#comment {
        background: transparent;
        border: 1px solid;
    }
    div#feedback form {
        padding: 20px;
        box-shadow: 0px 0px 5px 0px #80808094;
        margin-top: 30px;
    }s
    div#reviews {
        display: flex;
        flex-wrap: wrap;
        margin-top: 20px;
    }

    .review_detials p {
        padding-bottom: 0px;
    }

    .reviews_box img {
        margin-bottom: 0px !important;
        border-radius: 50px !important;
        padding: 8px;
    }

    .reviews_box .col.span_10 {
        padding-top: 10px;
        padding-bottom: 10px;
    }
    .item_box img {
        width: 300px !important;
        height: 200px !important;
    }
    .tab-content {
    padding: 10px;
    background-color: #FFF;
    }

</style>  
<section class="profile_banner">
    <div class="container main-content">
        <div class="row  wpb_row vc_row-fluid vc_row top-level full-width-content vc_row-o-equal-height vc_row-flex vc_row-o-content-middle" id="pro_bann">
            <img src="<?= $store_pic ?>" alt="">
        </div>
    </div>
</section>
<section class="profile_deatils">
    <div class="container main-content">
        <div class="row  wpb_row vc_row top-level vc_row-o-equal-height vc_row-flex vc_row-o-content-middle" id="profile_detail">
            <div class="col span_6">
                <div class="profile">
                    <div class="profile_img">
                        <img src="<?= $store_pic ?>" alt="">
                    </div>
                    <div class="profile_desc">
                        <h3><?= !empty($store_details['store_name']) ? $store_details['store_name'] : 'Store Name Not Set'  ?></h3>
                        <p><?= !empty($store_details['store_about']) ? $store_details['store_about'] : 'Store About Not Set' ?></p>
                    </div>
                </div>
            </div>
            <div class="col span_6">
                <div class="profile_info">
                    <div class="profile_info_detail">
                        <i class="fa fa-phone" aria-hidden="true"></i>
                        <h5>Phone Number</h5>
                        <a href="#"><?= !empty($store_details['store_number']) ? $store_details['store_number'] : 'Not Set' ?></a>
                    </div>
                    <div class="profile_info_detail">
                        <i class="fa fa-envelope" aria-hidden="true"></i>
                        <h5>Email</h5>
                        <a href="#"><?=  !empty($store_details['store_email']) ? $store_details['store_email'] : 'Not Set' ?></a>
                    </div>
                    <div class="profile_info_detail">
                            <i class="fa fa-map-marker" aria-hidden="true"></i>
                        <h5>Address</h5>
                        <p><?= !empty($store_details['store_address']) ? $store_details['store_address'] : 'Not Set' ?></p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<section class="profile_tabs">
    <div class="container main-content">
        <div class="row  wpb_row vc_row top-level vc_row-o-equal-height vc_row-flex vc_row-o-content-middle" id="products">
           
            <div id="tab1" class="tab-content">
                <div class="row  wpb_row vc_row top-level vc_row-o-equal-height vc_row-flex vc_row-o-content-middle" id="items">
                    <?= do_shortcode( '[product_filter]' ) ?>
                    
                </div>
                
            </div>
                   
        </div>
    </div>
</section>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
<script>

    // jQuery(document).on("click", "a.page-numbers", function(e){
    //     e.preventDefault();
    //     var page = jQuery(this).text();
    //     if(jQuery(this).hasClass('next')){
    //         page = jQuery('.page-numbers.current').next().text();
    //     } else if(jQuery(this).hasClass('prev')){
    //         page = jQuery('.page-numbers.current').prev().text();
    //     }
       
    //     var search = jQuery('.search-input').val(); 
    //     paginate_search(e, page, search);
    // });

    // jQuery(document).on( 'click', '.search-button', function(e) {
    //     e.preventDefault();
    //     var search = jQuery('.search-input').val(); 
    //     paginate_search(e, 1, search); // Assuming you want to set page=1 initially
    // });

    // function paginate_search(e,page=1, search) {
    //     var user_id = "<?= $_GET['id'] ?>";
    //     console.log('user_id', user_id);
    //     console.log('search', search);
    //     jQuery('body').waitMe({
    //         effect : 'bounce',
    //         text : '',
    //         bg : 'rgba(255,255,255,0.7)',
    //         color : '#000',
    //         maxSize : '',
    //         waitTime : -1,
    //         textPos : 'vertical',
    //         fontSize : '',
    //         source : '',
    //     });
        
    //     jQuery.ajax({
    //         type: 'post',
    //         url: "<?= admin_url('admin-ajax.php') ?>",
    //         data: {action:"get_products_by_page", page:page, search: search, user_id: user_id},
    //         dataType : 'json',
    //         success: function (response) {
    //             jQuery('body').waitMe('hide');
    //             alert();
    //             console.log("producthtml", response.producthtml);
    //             console.log("status", response.status);
    //             if (response.status) {
    //                 jQuery('.woocommerce ').html(response.producthtml);
    //                 //jQuery('.pagination').html(response.paginationhtml);
    //             } else {
    //                 console.log("No products found or another error occurred.");
    //             }
          

    //         },
    //         error : function(errorThrown){
    //             jQuery('body').waitMe('hide');
    //             console.log(errorThrown);
    //         }
    //     });
    // }

</script>
<?php get_footer();?>