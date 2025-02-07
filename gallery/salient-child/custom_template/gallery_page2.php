<?php /* Template Name: gallery page2 */ ?>
<?php get_header(); ?>
<?php

// if ( is_page() )
// $slug = get_queried_object()->post_name;
// if($slug == "marine-art"){
// $args = array(
//     'post_type' => 'artists',
//     'posts_per_page' => -1,
//     'tax_query' => array(
//         array(
//             'taxonomy' => 'countries',
//             'field' => 'term_id',
//             'terms' => 67,
//         ),
//     ),
// );
// }
// else {
    $args = array(
        'post_type' => 'artists',
        'posts_per_page' => -1,
        'orderby' => 'title',
        'order' => 'ASC',
		'tax_query' => array(
			array(
				'taxonomy' => 'countries', // Replace with your actual taxonomy name
				'field'    => 'slug',
				'terms'    => 'marine-arts', // Replace with the slug of the "Marine Art" category
			),
		),
    );
//}

$artists_query = new WP_Query($args);
//var_dump($artists_query);

?>

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.5.0/css/bootstrap.min.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/assets/owl.carousel.min.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/assets/owl.theme.default.css">
<script src="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/owl.carousel.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/magnific-popup.js/1.1.0/jquery.magnific-popup.min.js" integrity="sha512-IsNh5E3eYy3tr/JiX2Yx4vsCujtkhwl7SLqgnwLNgf04Hrt9BT9SXlLlZlWx+OK4ndzAoALhsMNcCmkggjZB1w==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/magnific-popup.js/1.1.0/jquery.magnific-popup.js" integrity="sha512-C1zvdb9R55RAkl6xCLTPt+Wmcz6s+ccOvcr6G57lbm8M2fbgn2SUjUJbQ13fEyjuLViwe97uJvwa1EUf4F1Akw==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/magnific-popup.js/1.1.0/magnific-popup.css" integrity="sha512-WEQNv9d3+sqyHjrqUZobDhFARZDko2wpWdfcpv44lsypsSuMO0kHGd3MQ8rrsBn/Qa39VojphdU6CMkpJUmDVw==" crossorigin="anonymous" referrerpolicy="no-referrer" />
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/magnific-popup.js/1.1.0/magnific-popup.min.css" integrity="sha512-+EoPw+Fiwh6eSeRK7zwIKG2MA8i3rV/DGa3tdttQGgWyatG/SkncT53KHQaS5Jh9MNOT3dmFL0FjTY08And/Cw==" crossorigin="anonymous" referrerpolicy="no-referrer" />

<style>
	
		/* new css */
	
	#count .col.span_12 {
    display: flex;
    align-items: center;
    }

        #count .col.span_12 .col.span_6 p.desc {
        text-align: left;
        padding-bottom: 0px;
    }
        
        #count h2 {
        margin-bottom: 0px;
        text-align: left;
        color: #000;
    }
        
        div#count img {
        width: 65% !important;
        margin: 0px auto !important;
    }
        
        #count .col.span_6 {
        margin: 0px;
    }
        
        #count {
        max-width: 100%;
        width: 80%;
    }
	
	/* ********* */
	
    button.mfp-arrow.mfp-arrow-right:before {
        content: "\f061";
        position: absolute;
        width: 100%;
        height: 100%;
        left: -40px;
        background: transparent;
        box-shadow: unset;
        border: unset;
        top: -35px;
        font-family: 'FontAwesome';
    }
    button.mfp-arrow.mfp-arrow-left:before {
        content: "\f060";
        position: absolute;
        width: 100%;
        height: 100%;
        background: transparent;
        box-shadow: unset;
        border: unset;
        top: -35px;
        left: -20px;
        font-family: 'FontAwesome';
    }
        .mfp-arrow:after {
        display: none;
    }
        .game-section .owl-nav.disabled {
        display: block;
    }

    .game-section .owl-nav.disabled button.owl-prev {
        position: absolute;
        left: -30px;
        top: 0;
        bottom: 0;
        font-size: 42px;
    }

    .game-section .owl-nav.disabled button.owl-next {position: absolute;right: -60px;top: 0;bottom: 0;font-size: 42px;}

    .game-section .owl-nav.disabled button:hover {
        background: transparent;
        color: #000;
    }
    @charset "utf-8";

    /******* Fonts Import Start **********/
    @import url("https://fonts.googleapis.com/css2?family=Roboto:wght@400;700&display=swap");
    /********* Fonts Face CSS End **********/

    /******* Common Element CSS Start ******/
    * {
    margin: 0px;
    padding: 0px;
    }
    a.artist-link.active {
    color: #ffff !important;
    background: #527dbb !important;
    padding: 0px 6px;
    margin-right: 7px;
    }
	div#artistDiv {
		max-height: 220px;
		overflow: auto;
	}
    .alphabet {
    width: 80%;
    display: flex;
    flex-wrap: wrap;
    }
	.game-section .alphabet a.artist-link {
		background: transparent;
		width: 30px;
		height: 28px;
		display: flex;
		justify-content: center;
		margin: 4px 3px;
		border: 1px solid #000;
		color: #000;
		border-radius: 4px;
	}
    input.submit_btn {
    background-image: url(https://devu14.testdevlink.net/gallery/wp-content/uploads/2024/02/Rectangle-3-copy-9.png);
    color: #000;
    padding: 10px 40px;
    }
    .item-desc h3 {
    color: #fff !important;
    }
    .col_artist {
    margin-top: 20px;
    }
    select#Country {
    border: 1px solid;
    }
    .col_text h2 {
    color: #000;
    font-size: 35px;
    margin-bottom: 0;
    }
    body {
    font-family: "Roboto", sans-serif;
    font-size: 16px;
    }
    .clear {
    clear: both;
    }
    img {
    max-width: 100%;
    border: 0px;
    }
    ul,
    ol {
    list-style: none;
    }
  div#count img {
    width: 10%;
    }
    /* section.image:before {
    content: '';
    position: absolute;
    background-repeat: no-repeat;
    width: 100%;
    height: 79px;
    left: 0px;
    right: 0px;
    top: 80PX;
    background-image: url(https://devu14.testdevlink.net/gallery/wp-content/uploads/2024/01/a-greybardd.png) !important;
    background-size: 100% 100% !important;
    z-index: 9999;
    section.image: before;
    } 

    section.image:before {
    animation: scroll 3000s infinite linear;
        background-repeat: repeat;
    } */

    /*     section.image:after {
        content: '';
        position: absolute;
        background-repeat: no-repeat;
        width: 45%;
        height: 40%;
        right: 0%;
        background-image: url(https://devu14.testdevlink.net/gallery/wp-content/uploads/2024/01/Group-7dgsdgas.png) !important;
    background-size: 100% 100% !important;
    animation: 2s move linear alternate infinite;
    top: 0;
    }    */
    .item-desc {
    color: #ffff !important;
    }
    div#count p.desc {
        margin-top: 10px;
    }
    .col_text {
    width: 33%;
    }
    .owl-carousel {
    width: 70%;
    float: inline-end;
        margin-bottom: 40px;
        padding-left: 20px;
        }
        div#count {
            display: table;
            margin: 0px auto;
            text-align: center;
            padding-top: 30px;
        }
       section.image {
    padding: 50px 60px;
    }
        a {
        text-decoration: none;
        color: inherit;
        outline: none;
        transition: all 0.4s ease-in-out;
        -webkit-transition: all 0.4s ease-in-out;
        }
        a:focus,
        a:active,
        a:visited,
        a:hover {
        text-decoration: none;
        outline: none;
        }
        a:hover {
        color: #e73700;
        }
        h2 {
        margin-bottom: 48px;
        padding-bottom: 16px;
        font-size: 20px;
        line-height: 28px;
        font-weight: 700;
        position: relative;
        text-transform: capitalize;
        }
        h3 {
        margin: 0 0 10px;
        font-size: 28px;
        line-height: 36px;
        }
        button {
        outline: none !important;
        }
        /******* Common Element CSS End *********/

        /* -------- title style ------- */
        .line-title {
        position: relative;
        width: 400px;
        }
        .line-title::before,
        .line-title::after {
        content: "";
        position: absolute;
        bottom: 0;
        left: 0;
        height: 4px;
        border-radius: 2px;
        }
        .line-title::before {
        width: 100%;
        background: #f2f2f2;
        }
        .line-title::after {
        width: 32px;
        background: #e73700;
        }

        /******* Middle section CSS Start ******/
        /* -------- Landing page ------- */
        .game-section {
        padding: 50px 50px;
        display: flex;
        }
        .game-section .owl-stage {
        margin: 15px 0;
        display: flex;
        display: -webkit-flex;
        }
        .game-section .item {
        margin: 0 15px 60px;
        width: 320px;
        height: 400px;
        display: flex;
        display: -webkit-flex;
        align-items: flex-end;
        -webkit-align-items: flex-end;
        background: #343434 no-repeat center center / cover;
        border-radius: 16px;
        overflow: hidden;
        position: relative;
        transition: all 0.4s ease-in-out;
        -webkit-transition: all 0.4s ease-in-out;
        cursor: pointer;
        }
        .game-section .item.active {
        width: 500px;
        box-shadow: 12px 40px 40px rgba(0, 0, 0, 0.25);
        -webkit-box-shadow: 12px 40px 40px rgba(0, 0, 0, 0.25);
        }
        .game-section .item:after {
        content: "";
        display: block;
        position: absolute;
        height: 100%;
        width: 100%;
        left: 0;
        top: 0;
        background-image: linear-gradient(rgba(0, 0, 0, 0), rgba(0, 0, 0, 1));
        }
        .game-section .item-desc {
        padding: 0 24px 12px;
        color: #fff;
        position: relative;
        z-index: 1;
        overflow: hidden;
        transform: translateY(calc(100% - 54px));
        -webkit-transform: translateY(calc(100% - 54px));
        transition: all 0.4s ease-in-out;
        -webkit-transition: all 0.4s ease-in-out;
        }
        .game-section .item.active .item-desc {
        transform: none;
        -webkit-transform: none;
        }
        .game-section .item-desc p {
        opacity: 0;
        -webkit-transform: translateY(32px);
        transform: translateY(32px);
        transition: all 0.4s ease-in-out 0.2s;
        -webkit-transition: all 0.4s ease-in-out 0.2s;
        }
        .game-section .item.active .item-desc p {
        opacity: 1;
        -webkit-transform: translateY(0);
        transform: translateY(0);
        }
        .game-section .owl-theme.custom-carousel .owl-dots {
        margin-top: -20px;
        position: relative;
        z-index: 5;
        }
        /******** Middle section CSS End *******/

        /***** responsive css Start ******/

        @media (min-width: 992px) and (max-width: 1199px) {
        h2 {
            margin-bottom: 32px;
        }
        h3 {
            margin: 0 0 8px;
            font-size: 24px;
            line-height: 32px;
        }

        /* -------- Landing page ------- */
        .game-section {
            padding: 50px 30px;
        }
        .game-section .item {
            margin: 0 12px 60px;
            width: 260px;
            height: 360px;
        }
        .game-section .item.active {
            width: 400px;
        }
        .game-section .item-desc {
            transform: translateY(calc(100% - 46px));
            -webkit-transform: translateY(calc(100% - 46px));
        }
        }

        @media (min-width: 768px) and (max-width: 991px) {
        h2 {
            margin-bottom: 32px;
        }
        h3 {
            margin: 0 0 8px;
            font-size: 24px;
            line-height: 32px;
        }
        .line-title {
            width: 330px;
        }

        /* -------- Landing page ------- */
        .game-section {
            padding: 50px 30px 40px;
        }
        .game-section .item {
            margin: 0 12px 60px;
            width: 240px;
            height: 330px;
        }
        .game-section .item.active {
            width: 360px;
        }
        .game-section .item-desc {
            transform: translateY(calc(100% - 42px));
            -webkit-transform: translateY(calc(100% - 42px));
        }
        }

        @media (max-width: 767px) {
            .owl-carousel {
        width: 100%;
        float: none;
        margin-bottom: 40px;
        padding-left: 0px;
        }
            .col_text {
        width: 100%;
        }
            div#count img {
        width: 40%;
        }
            section.game-section {
        display: inline;
        padding: unset;
        }

        body {
            font-size: 14px;
        }
        h2 {
            margin-bottom: 20px;
        }
        h3 {
            margin: 0 0 8px;
            font-size: 19px;
            line-height: 24px;
        }
        .line-title {
            width: 250px;
        }

        /* -------- Landing page ------- */
        .game-section {
            padding: 30px 15px 20px;
        }
        .game-section .item {
            margin: 0 10px 40px;
            width: 200px;
            height: 280px;
        }
        .game-section .item.active {
            width: 270px;
            box-shadow: 6px 10px 10px rgba(0, 0, 0, 0.25);
            -webkit-box-shadow: 6px 10px 10px rgba(0, 0, 0, 0.25);
        }
        .game-section .item-desc {
            padding: 0 14px 5px;
            transform: translateY(calc(100% - 42px));
            -webkit-transform: translateY(calc(100% - 42px));
        }
        }

</style>
<section class="image">
<div class="row" id="count">
	<div class="col span_12">
		<div class="col span_6">
	<a href="https://www.amazon.co.uk/Biographies-Artists-Lived-Before-1950/dp/B0C1JB1TMB/ref=tmm_pap_swatch_0?_encoding=UTF8&qid=1681213651&sr=8-1"><img src="https://devu14.testdevlink.net/gallery/wp-content/uploads/2024/05/newaaaa.png"></a>
			</div>
	<div class="col span_6">
		<h2>Biographies of Artists Who Lived Before 1950</h2>
		<p class="desc">This book covers the lives of artists who lived from Early Renaissance times to 1950. It encompasses artists of all genres from around the world. There are 1,178 biographies of artists from 37 countries written concisely for comfortable reading while documenting the central details of their lives.</p>
	<p class="desc">Biographies of artists are now in book form. Click on the book cover to view.</p> 
		</div>
		</div>
</div>
<section class="game-section">
    <div class="col_text">
        <h2>View Your Favorite Artist</h2>
        <h3><span style="color: #b5b5b5;"><strong><div class="alphabet" data-url="<?= $slug; ?>"><a class='artist-link active' href="#" class="active">All</a><?php
            for ($i = 65; $i <= 90; $i++) {
                $letter = chr($i);
                // if($_GET['alphabet'] == $letter){
                //     echo "<a class='artist-link active' href='#!'>$letter</a>&nbsp;&nbsp;";

                // }
                // else {
                    echo "<a class='artist-link' href='#!'>$letter</a>&nbsp;&nbsp;";

               //}
               
            }
            ?></div></strong></span></h3>
    <div class="col_artist">
        <h4>Select Your Artist</h4>
        <div id="artistDiv">
            <?php  if ($artists_query->have_posts()) :
                    while ($artists_query->have_posts()) : $artists_query->the_post();  ?>
                            <input type="radio" id="<?= get_the_ID()  ?>" class="artists" name="artist" value="<?= get_the_ID() ?>">
                            <label for="<?= get_the_ID()  ?>"><?=  get_the_title(get_the_ID()) ?></label><br>
                <?php endwhile;  wp_reset_postdata();
                else :
                    echo 'No artists found';
                endif; 
            ?>
        </div>
        <!-- <input type="submit" class="submit_btn" placeholder="View Artist Gallery" value="View Artist Gallery"> -->
    </div>
    </div>
    <div class="result">
 </div>
    <div class="owl-carousel custom-carousel owl-theme">
      
    </div>
</div>
</section>
<script>
   
$(document).ready(function () {
    $(".custom-carousel").owlCarousel({
        autoWidth: true,
        loop: true
    });



    $(".custom-carousel .item").click(function () {
        $(".custom-carousel .item").not($(this)).removeClass("active");
        $(this).toggleClass("active");
    });


    $(document).on( 'change', '.artists', function(e) {
        e.preventDefault();
        
        var artist = $(this).val();
        var slug = 'marine-art';
     
       // console.log("artist", artist);

        jQuery('body').waitMe({
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
            data: { artist:artist, slug: slug, action:"get_selected_artist"},
            dataType : 'json',
            success: function (response) {
                jQuery('body').waitMe('hide');
               
               // console.log(response.html);
                $('.custom-carousel').remove();
                
                $('.game-section').append('<div class="owl-carousel custom-carousel owl-theme">'+response.html+'</div>');
                $(".custom-carousel").owlCarousel({
                autoWidth: true,
                loop: true
                });
                $('.owl-carousel.custom-carousel.owl-theme').prepend(response.artistHtml);
                $('.image-link').magnificPopup({
                type: 'image',
                gallery: {
                    enabled: true
                }
                });
            },
            error : function(errorThrown){
                jQuery('body').waitMe('hide');
                console.log(errorThrown);
            }
        });
        
    });
    // Get the current page slug
    var pageSlug = window.location.pathname; 

   
    $('#artistDiv input[type="radio"]:first').click();

    // $(document).on( 'click', '.artist-link', function(e) {
    //     $('.col_artist').find('#artistDiv input[type="radio"]:first').click();

    // });
   
   jQuery('.image-link').magnificPopup({
    type: 'image',
    gallery: {
        enabled: true
      }
    });

});
    </script>
<?php 
get_footer();
?>