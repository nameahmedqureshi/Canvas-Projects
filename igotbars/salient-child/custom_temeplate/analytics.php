<?php /* Template Name: analytics  */   ?>
<?php  get_header();  
include('dashboard_menu.php'); ?>
<style>
    .custom-page {
		max-width: 100%;
		padding: 0px;
    }
    section.create_post {
        padding-bottom: 100px;
    }
    .analytics-frame {
        border: none;
        width: 100%;
        height: 275rem;
        display: none;
    }
    section.main_dashboard {
        background: #f1f1f1;
    }
</style>
<div class="analytics">
    <section class="wrapper create_post custom-page">
        <div class="row card_row">
<!--             <iframe id="myIframe" class="analytics-frame" scrolling="no" frameborder="0" src="<?php //echo home_url('wp-admin/admin.php?page=ahc_hits_counter_menu_free') ?>" ></iframe> -->
			
			    <iframe id="myIframe" class="analytics-frame" scrolling="no" frameborder="0" src="<?= home_url('wp-admin/admin.php?page=ahc_hits_counter_menu_free') ?>" ></iframe>
        </div>
    </section>
</div>
<?php get_footer(); ?>
<script>

(function ($) {
    $(document).ready(function () {
        jQuery('.create_post').waitMe({
                effect : 'facebook',
                text : '',
                bg : 'rgba(255,255,255,0.7)',
                color : '#000',
                maxSize : '',
                waitTime : -1,
                textPos : 'vertical',
                fontSize : '',
                source : '',
            });
            var iframe = jQuery("#myIframe");
            iframe.load( function() {
                iframe.contents().find("head")
                .append(jQuery("<style> #adminmenumain, #wpadminbar, #screen-meta-links, .error, .notice, #vtrts_subscribe{display:none;} #wpcontent, #wpfooter { margin-left: 0px;} </style>"));
                jQuery("#myIframe").show();
                jQuery('.create_post').waitMe('hide');
        });
    });
})(jQuery);
</script>
