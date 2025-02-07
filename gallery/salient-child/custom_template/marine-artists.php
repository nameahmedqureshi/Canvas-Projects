<?php
/* Template Name: Marine Artists */
get_header();

$paged = get_query_var('paged') ? get_query_var('paged') : 1;

if($_GET['id']){
    $args = array(
        'post_type' => 'artists',
        'posts_per_page' => 30,
        'paged'=> $paged,
        'tax_query' => array(
            array(
                'taxonomy' => 'countries', // Replace with your custom taxonomy name
                'field' => 'term_id',
                'terms' => $_GET['id'], // Replace with the actual category ID
            ),
        ),
    );
}
else {
    $args = array(
        'post_type' => 'artists',
        'posts_per_page' => 30,
        'paged'=> $paged,
    );
}


 $artists_query = new WP_Query($args);

?>
<style>
	
    .pagination {padding: 10px 0px;text-align: center;margin-bottom: 20px;/* background: #7f9fcd; */}

    .pagination a {
        color: #000;
        background: #f1f1f1;
        padding: 4px 14px;
    }

    .pagination span.page-numbers.current {
        color: #fff;
        background: #527dbb;
        padding: 4px 14px;
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
    div#count img {width: 16%;animation: up-down 2s ease-in-out infinite alternate-reverse both;}

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
            <h3><span style="color: #5681bb;">Artists</span> <span style="color: #b5b5b5;"><strong><div class="alphabet"><a class='artist-link active' href="#" class="active">All</a><?php
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
            </div>
        </div>
        <div id="artistDiv">
            <div class="row main" id="count_menu">
                <div class="col span_2 column">
                    <ul>
                        <?php  if ($artists_query->have_posts()) :
                            while ($artists_query->have_posts()) : $artists_query->the_post();  ?>
                        <li class="country-link"><a href="<?= get_permalink(get_the_ID()) ?>"><?=  get_the_title(get_the_ID()) ?></a></li>
                        <?php endwhile;  wp_reset_postdata();
                        else :
                            echo 'No artists found';
                        endif; 
                    ?>
                    </ul>
                    
                    <div class="message"><p id="no_record_message" style="display:none">No Record Found</p></div>
                </div>
            </div>
            <div class="pagination">
                <?php echo paginate_links( array(
                    'base' => get_pagenum_link(1) . '%_%',
                    'format' => '?paged=%#%',
                    'current' => max( 1, get_query_var('paged') ),
                    'total' => $artists_query->max_num_pages,
                    'prev_text' => __('« Previous'),
                    'next_text' => __('Next »'),
                )); ?>
            </div>
        </div>
    </div>
</section>   

<?php get_footer(); ?>  
<script>
     jQuery(document).ready(function() {
       // Get the URL
       var url = window.location.href;

       // Check if the URL contains the alphabet parameter
       if (url.includes('?alphabet=')) {
           
           // Extract the value of the alphabet parameter
           var alphabetValue = url.split('?alphabet=')[1];
            //   setTimeout(function() {
                jQuery('.artist-link:contains(' + alphabetValue + ')').click();
                // jQuery('body').waitMe('hide');
            // }, 5000);

       }

    });
</script>