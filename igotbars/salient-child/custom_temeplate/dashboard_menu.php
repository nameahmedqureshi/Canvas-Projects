<?php  

if (is_user_logged_in() ) {

    global $post;

    $post_slug = $post->post_name;

    $post_slugs = ['view-post', 'add-post'];

    $page_slugs = ['view-page', 'add-page'];

    $media_slugs = ['add-media'];

    $analytics_slugs = ['analytics'];

?>
<style>
        .logout_dashboard:hover {
        color: #000 !important;
    }
    .logout_dashboard {
        padding: 10px 40px !important;
        margin: auto;
        display: table;
        font-size: 15px !important;
        cursor: pointer;
        background: #fff;
     }
</style>

<section class="main_dashboard">

    <div class="container main-content">

        <div class="custom_row" id="dashboard">

            <div class="col_8">

                <h4>Dashboard</h4>

            </div>

            <div class="col_4">

                <!-- <form class="search_form" action="">

                    <input type="text" placeholder="Search" name="search">

                    <button type="submit"><i class="fa fa-search"></i></button>

                </form> -->

            </div>

        </div>

        <div class="custom_row" id="main_menu">

            <div class="col_3 bg_lig <?= in_array($post_slug, $post_slugs) ? 'active' : '' ?>" >

                <div class="post_cloumn">

                    <div class="menu_heading">

                        <h4>Blog Post</h4>

                    </div>

                    <div class="menu_icon">

                        <a href ="<?= home_url('add-post') ?>"><i class="fa-solid fa-plus"></i></a>

                        <a href ="<?= home_url('view-post') ?>"><i class="fa fa-eye" aria-hidden="true"></i></a>

                    </div>

                </div>

                <a href ="<?= home_url('view-post') ?>"> 

                    <div class="menu_image">

                            <img src="https://devu10.testdevlink.net/Envision/wp-content/uploads/2024/04/blogpost.jpeg" alt="">

                    </div>

                </a>

            </div>

            <div class="col_3 bg_lig <?= in_array($post_slug, $analytics_slugs) ? 'active' : '' ?>">

                <div class="post_cloumn">

                    <div class="menu_heading">

                        <h4>Analytics</h4>

                    </div>

                    <div class="menu_icon">

                        <a href ="<?= home_url('analytics') ?>"> <i class="fa fa-eye" aria-hidden="true"></i></a>

                    </div>

                </div>

                <a href ="<?= home_url('analytics') ?>"> 

                    <div class="menu_image">

                        <img src="<?= home_url('/wp-content/uploads/2024/06/analytics.png') ?>" alt="">

                    </div>

                </a>

            </div>
          

        </div>
        <a class="logout_dashboard" href="<?= home_url("logout") ?>">Logout</a>
    </div>

</section>

<?php

} else {

 wp_redirect(home_url('/')); 

 exit;

} 

?>