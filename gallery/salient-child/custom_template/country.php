<?php
/* Template Name: country */
get_header();
$countries = get_terms(array(
    'taxonomy'      => 'countries',
    'hide_empty'    =>  0,
));
?>
<style>
	
        div#count img {
        width: 10% !important;
    }
  
    .main .column {
        column-width: 10.5em;
        -webkit-column-width: 11.5em;
        width: 100%;
    }

    div#count_menu {
        font-size: 0.95em;
        width: 66.875%;
        max-width: 70%;
        text-align: left;
        margin: 0px auto;
        padding: 3.84615384615385%;
    }


    .alphabet {
        text-align: center;
        margin: auto;
        display: flex;
        width: 100%;
        padding-top: 20px;
    }
    div#count_menu {
        display: flex;
        justify-content: center;
        align-items: center;
    }
    div#count_menu ul li {
        color: #5681bb;
        list-style: auto;
    }
    #count p.desc {
        margin-top: 20px;
    }
    div#count img {width: 10%;animation: up-down 2s ease-in-out infinite alternate-reverse both;}

    div#count {
        padding-top: 40px;
        text-align: center;
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
            <img src="https://devu14.testdevlink.net/gallery/wp-content/uploads/2024/01/Cover-Title-Page-600dpi-scaled.jpg">
            <p class="desc">Biographies of artists are now in book form. Click on the book cover to view.</p> 
            <div class="let">
            <h3><span style="color: #5681bb;">Artists</span> <span style="color: #b5b5b5;"><strong><div class="alphabet"><a href="javascript:;" class="active">All</a><?php
            for ($i = 65; $i <= 90; $i++) {
                $letter = chr($i);
                echo "<a href='javascript:;'>$letter</a>&nbsp;&nbsp;";
            }
            ?></div></strong></span></h3>
            </div>
        </div>
        <div class="row main" id="count_menu">
            <div class="col span_2 column">
                <ul>
                    <?php  foreach($countries as $country) {  ?>
                    <li class="country-link"><a href="<?= site_url('marine-art-2?id='.$country->term_id) ?>" title="<?= $country->name ?>"><?= $country->name ?></a></li>
                    <?php } ?>
                </ul>
                <div class="message"><p id="no_record_message" style="display:none">No Record Found</p></div>
            </div>
        </div>
    </div>
</section>   

<?php get_footer(); ?>  
<script>
     var _alphabets = jQuery('.alphabet > a');
        var _contentRows = jQuery('#count_menu .country-link');
        // var _singleRows = jQuery('#count_menu .country-link');
        var _noRecordMessage = jQuery('#no_record_message'); // Assuming you have a placeholder for the message

        _alphabets.click(function () {
            var _letter = jQuery(this),
                _text = jQuery(this).text(),
                _count = 0;

            _alphabets.removeClass("active");
            _letter.addClass("active");

            _contentRows.hide();
            _contentRows.each(function (i) {
                var _cellText = jQuery(this).children('a').eq(0).text();

                if (_text === 'All' || RegExp('^' + _text).test(_cellText)) {
                    _count += 1;
                    jQuery(this).fadeIn(400);
                }
            });

            // Check if no records were found
            if (_count === 0) {
                _noRecordMessage.show(); // Show the message
            } else {
                _noRecordMessage.hide(); // Hide the message if there are records
            }
        });
</script>