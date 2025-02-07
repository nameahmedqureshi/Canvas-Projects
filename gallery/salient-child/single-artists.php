<?php
get_header();
// $post_id = isset($_GET['id']) ? $_GET['id'] : '';
// $post = get_post( $post_id );
 $gallery = get_field('gallery', get_the_ID() );
?>
<script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.3.7/js/bootstrap.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.3.7/css/bootstrap.min.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
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
    width: 90% !important;
    margin: 0px auto !important;
}
	
	#count .col.span_6 {
    margin: 0px;
}
	
	/* ********* */
	
    div#count_menu img {
        height: 150px;
        object-fit: cover;
        object-position: center;
        BORDER: 1PX SOLID RED;
        BORDER-RADIUS: 10PX;
    }
    div#image-gallery {
        margin-bottom: 50px;
        text-align: center;
    }
    div#count_menu {
        display: flex;
        justify-content: unset;
        align-items: center;
        flex-wrap: wrap;
    }

    #gallery {
        padding-top: 40px;
        }
    div#count_menu ul li {
        color: #5681bb;
        list-style: auto;
    }
    #count p.desc {
        margin-top: 20px;
    }
    div#count img {width: 16%;animation: up-down 2s ease-in-out infinite alternate-reverse both;}

    div#count {
        padding-top: 40px;
        text-align: center;
    }
    .alphabet {
        text-align: center;
        margin: auto;
        display: flex;
        width: 100%;
        padding-top: 20px;
    }
    #count strong a {
    /* margin: 0px 8px; */
    color: #b2b2b2;
    width: 40px;
    float: left;
    color: #333;
    cursor: pointer;
    height: 26px;
    border: 1px solid #CCC;
    display: block;
    padding: 2px 2px;
    font-size: 20px;
    text-align: center;
    line-height: 20px;
    text-shadow: 0 1px 0 rgba(255, 255, 255, .5);
    border-right: none;
    text-decoration: none;
    background-color: #F1F1F1;
    }
    #count h3 span {
        font-weight: 700;
    }
    #count strong {
        margin: 0px 10px;
    }
    @keyframes up-down {
    0% {
        transform: translateY(10px);
    }

    100% {
        transform: translateY(-10px);
    }
    }
    @media (max-width: 820px) {
        #count p.desc {
            font-size: 15px !important;
            line-height: 25px !important;
        }
        #count strong a {
        margin: 0px 5px;
        }

    }
        @media screen and (min-width: 991px) {
        #gallery {
            padding: 60px 30px 0 30px;
        }
        }

        .img-wrapper {
        position: relative;
        margin-top: 15px;
        }
        .img-wrapper img {
        width: 100%;
        }
        .img-wrapper h4 {
            margin-bottom: 10px;
            margin-top: 40px;
            font-weight: 700;
            font-family: sans-serif;
        }
        .img-overlay {
            background: rgba(0, 0, 0, 0);
            width: 100%;
            height: 120%;
            position: absolute;
            top: 0px;
            left: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            opacity: 0;
        }
        .img-overlay i {
        color: #fff;
        font-size: 3em;
        }

        #overlay {
        background: rgba(0, 0, 0, 0.7);
        width: 100%;
        height: 100%;
        position: fixed;
        top: 0;
        left: 0;
        display: flex;
        justify-content: center;
        align-items: center;
        z-index: 999;
        -webkit-user-select: none;
        -moz-user-select: none;
        -ms-user-select: none;
        user-select: none;
        }
        #overlay img {
        margin: 0;
/*         width: 100%; */
        height: auto;
        -o-object-fit: contain;
            object-fit: contain;
        padding: 1%;
        }
        @media screen and (min-width: 768px) {
/*         #overlay img {
            width: 20%;
        } */
        }
        @media screen and (min-width: 1200px) {
/*       #overlay img {
    width: 30%;
} */
        }

        #nextButton {
        color: #fff;
        font-size: 2em;
        transition: opacity 0.8s;
        }
        #nextButton:hover {
        opacity: 0.7;
        }
        @media screen and (min-width: 768px) {
        #nextButton {
            font-size: 3em;
        }
        }

        #prevButton {
        color: #fff;
        font-size: 2em;
        transition: opacity 0.8s;
        }
        #prevButton:hover {
        opacity: 0.7;
        }
        @media screen and (min-width: 768px) {
        #prevButton {
            font-size: 3em;
        }
        }

        #exitButton {
        color: #fff;
        font-size: 2em;
        transition: opacity 0.8s;
        position: absolute;
        top: 15px;
        right: 15px;
        }
        #exitButton:hover {
        opacity: 0.7;
        }
        @media screen and (min-width: 768px) {
        #exitButton {
            font-size: 3em;
        }
        }
    @media (max-width: 480px) {
        div#count_menu .col.span_2 {
            margin-bottom: 0 !important;
        }
        #count h3 span {
            font-size: 19px;
            line-height: 29px;
        }
        div#count_menu {
            display: inline-block;
        }
        #count strong {
            margin: 0px 0px;
            display: flex;
            flex-wrap: wrap;
        }
        div#count img {
            width: 32%;
        }
    }

</style>
<section>
    <div class="container main-content">
        <div class="row" id="count">
			<div class="col span_12">
		<div class="col span_6">
	<a href="https://www.amazon.co.uk/Biographies-Artists-Lived-Before-1950/dp/B0C1JB1TMB/ref=tmm_pap_swatch_0?_encoding=UTF8&amp;qid=1681213651&amp;sr=8-1"><img src="https://devu14.testdevlink.net/gallery/wp-content/uploads/2024/05/newaaaa.png"></a>
			</div>
	<div class="col span_6">
		<h2>Biographies of Artists Who Lived Before 1950</h2>
		<p class="desc">This book covers the lives of artists who lived from Early Renaissance times to 1950. It encompasses artists of all genres from around the world. There are 1,178 biographies of artists from 37 countries written concisely for comfortable reading while documenting the central details of their lives.</p>
	<p class="desc">Biographies of artists are now in book form. Click on the book cover to view.</p> 
		</div>
		</div>
<!--             <div class="let">
            <h3><span style="color: #5681bb;">Artists</span> <span style="color: #b5b5b5;"><strong><div class="alphabet"><a class="artist active" href="#">All</a><?php
            for ($i = 65; $i <= 90; $i++) {
                $letter = chr($i);
                echo "<a class='artist' href='" . site_url('marine-art-2?alphabet=' . $letter) . "'>$letter</a>&nbsp;&nbsp;";
            }
            ?></div></strong></span></h3>
            </div> -->
        </div>

</section> 
<section id="gallery">
  <div class="container">
    <div id="image-gallery">
        <h1><?= get_the_title(get_the_ID()) ?></h1>
        <p class=gall_desc><?= get_the_excerpt(get_the_ID()) ?></p>
      <div class="row" id="count_menu">
        <?php if ($gallery) { foreach ($gallery as $value) { ?>
            <div class="col-lg-3 col-md-6 col-sm-6 col-xs-12 image country-link" title="<?= $value['name'] ?>">
                <div class="img-wrapper">
                    <h4><?= $value['name'] ?></h4>
                    <a href="<?= $value['image'] ?>"><img src="<?= $value['image'] ?>" class="img-responsive"></a>
                    <div class="img-overlay">
                    <i class="fa fa-plus-circle" aria-hidden="true"></i>
                    </div>
                </div>
            </div>
        <?php } } ?>
      </div><!-- End row -->
    </div><!-- End image gallery -->
  </div><!-- End container --> 
</section>   
    <script>
    $(document).ready(function() {
        // $('.artist').on( 'click', function(e) {
        //     e.preventDefault();
        //     window.location.href = "https://devu14.testdevlink.net/gallery/marine-art-2/" + $(this).text();

        // });
                // Gallery image hover
        $( ".img-wrapper" ).hover(
        function() {
            $(this).find(".img-overlay").animate({opacity: 1}, 600);
        }, function() {
            $(this).find(".img-overlay").animate({opacity: 0}, 600);
        }
        );

        // Lightbox
        var $overlay = $('<div id="overlay"></div>');
        var $image = $("<img>");
        var $prevButton = $('<div id="prevButton"><i class="fa fa-chevron-left"></i></div>');
        var $nextButton = $('<div id="nextButton"><i class="fa fa-chevron-right"></i></div>');
        var $exitButton = $('<div id="exitButton"><i class="fa fa-times"></i></div>');

        // Add overlay
        $overlay.append($image).prepend($prevButton).append($nextButton).append($exitButton);
        $("#gallery").append($overlay);

        // Hide overlay on default
        $overlay.hide();

        // When an image is clicked
        $(".img-overlay").click(function(event) {
        // Prevents default behavior
        event.preventDefault();
        // Adds href attribute to variable
        var imageLocation = $(this).prev().attr("href");
        // Add the image src to $image
        $image.attr("src", imageLocation);
        // Fade in the overlay
        $overlay.fadeIn("slow");
        });

        // When the overlay is clicked
        $overlay.click(function() {
        // Fade out the overlay
        $(this).fadeOut("slow");
        });

        // When next button is clicked
        $nextButton.click(function(event) {
        // Hide the current image
        $("#overlay img").hide();
        // Overlay image location
        var $currentImgSrc = $("#overlay img").attr("src");
        // Image with matching location of the overlay image
        var $currentImg = $('#image-gallery img[src="' + $currentImgSrc + '"]');
        // Finds the next image
        var $nextImg = $($currentImg.closest(".image").next().find("img"));
        // All of the images in the gallery
        var $images = $("#image-gallery img");
        // If there is a next image
        if ($nextImg.length > 0) { 
            // Fade in the next image
            $("#overlay img").attr("src", $nextImg.attr("src")).fadeIn(800);
        } else {
            // Otherwise fade in the first image
            $("#overlay img").attr("src", $($images[0]).attr("src")).fadeIn(800);
        }
        // Prevents overlay from being hidden
        event.stopPropagation();
        });

        // When previous button is clicked
        $prevButton.click(function(event) {
        // Hide the current image
        $("#overlay img").hide();
        // Overlay image location
        var $currentImgSrc = $("#overlay img").attr("src");
        // Image with matching location of the overlay image
        var $currentImg = $('#image-gallery img[src="' + $currentImgSrc + '"]');
        // Finds the next image
        var $nextImg = $($currentImg.closest(".image").prev().find("img"));
        // Fade in the next image
        $("#overlay img").attr("src", $nextImg.attr("src")).fadeIn(800);
        // Prevents overlay from being hidden
        event.stopPropagation();
        });

        // When the exit button is clicked
        $exitButton.click(function() {
        // Fade out the overlay
        $("#overlay").fadeOut("slow");
        });

    });
    </script>
<?php 
get_footer();
?>  