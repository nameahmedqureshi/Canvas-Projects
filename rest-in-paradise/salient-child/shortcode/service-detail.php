<?php

if (isset($_GET['slug']) && $_GET['slug'] != '') {
    $postMeta = get_post_meta($_GET['slug']);
    $get_post = get_post($_GET['slug']);
} else{
    echo '<script> document.location.href = "'.home_url('services-directory').'" </script>';
    exit;
}
?>

<link rel="stylesheet" type="text/css" href="<?= get_stylesheet_directory_uri(  ) ?>/store/app-assets/vendors/css/editors/quill/quill.snow.css">
<style>
    .announcement-card {
        background: white;
        border-radius: 10px;
        /* box-shadow: 0 0 10px rgba(0, 0, 0, 0.1); */
        /* padding: 20px; */
        max-width: 90%;
        margin: 20px auto;
        border: 1px solid #c3ac93;
        box-shadow: 0 6px 12px hsla(31, 29%, 67%, .44);
        border-radius: 8px;
    }
    .serviceDetailsBody {
        padding: 30px;
    }
    .profile-img {
        border-radius: 10px;
        max-width: 150px;
    }
    .highlight {
        font-weight: bold;
        color: #d99207;
        margin-bottom: 0px !important;
    }

    .funeral-home {
        background: #FAF5EB;
        padding: 20px;
        border-radius: 10px;
        box-shadow: 2px 2px 10px rgba(0, 0, 0, 0.1);
        font-family: 'Arial', sans-serif;
        margin-top: 20px;
    }

    .funeral-home h3 {
        font-weight: bold;
        color: #444;
    }

    .funeral-home p {
        color: #666;
        font-size: 14px;
        margin: 5px 0;
    }

    .funeral-home a {
        color: #007BFF;
        text-decoration: none;
    }

    .funeral-home .icon {
        margin-right: 5px;
    }

    .funeral-home-btn {
        background: #F7E3A7;
        border: none;
        padding: 10px 15px;
        font-size: 14px;
        cursor: pointer;
        border-radius: 5px;
        display: inline-block;
        margin-top: 10px;
    }

    .funeral-home-btn:hover {
        background: #E6D39E;
    }


    .funeralDetail {
        display: flex;
        justify-content: space-between;
    }

    .text-center{
        text-align: center;
    }

    div#ajax-content-wrap .container-wrap {
        background: #f9f5ec;
    }

    .serviceDetails_preview-header {
        display: flex;
        flex-wrap: wrap;
        justify-content: center;
        align-items: center;
        height: 71px;
        border-radius: 8px 8px 0 0;
        border-bottom: 1px solid #c3ac93;
        background: url(https://rip.ie/ornament-left.svg) left 12px top 17px no-repeat, url(https://rip.ie/ornament-right.svg) right 12px top 17px no-repeat, #fdfcf7;
        background-size: 119px 39px;
    }

    .serviceDetails_preview-header h3 {
        text-align: center;
        width: 100%;
        margin-top: 5px;
    }

    .serviceDetails_preview-header p {
        text-align: center;
        width: 100%;
        margin-bottom: 10px;
    }

    .serviceDetailsBody .header {
        display: flex;
    }

    .serviceDetailsBody .details {
        width: 100%;
        padding: 15px 50px;
    }

    .header img {
        width: 270px !important;
        height: 200px !important;
        object-fit: cover;
    }

</style>

<div class="announcement-card">
    <div class="serviceDetails_preview-header">
    <h2 class="highlight"><?= $postMeta["name"][0] ?></h2>
        <!-- <p><?= $postMeta["location"][0]?></p> -->
    </div>
    <div class="serviceDetailsBody">
        <div class="header">
            <img src="<?= !empty($postMeta['person_image'][0]) ? wp_get_attachment_url($postMeta['person_image'][0]) :  get_stylesheet_directory_uri().'/store/assets/images/no-preview.png'  ?>" alt="Profile Picture" class="profile-img">
            <!-- <h4 class="mt-3">The death has occurred of</h4> -->
           <div class="details">
                <!-- <h2 class="highlight"><?= $postMeta["name"][0] ?></h2> -->
               <p> <?= $postMeta["short_description"][0] ?></p>
           </div>
        </div>
            <div class="ql-editor">
            <?= $postMeta["about"][0] ?>
            </div>
        <hr>

        <div class="funeral-home">
                <p style="text-align: center;">
                    <span class="icon">🌐</span> <a href="<?= $postMeta["web_link"][0] ?>"><?= $postMeta["web_link"][0] ?></a><br>
                    <span class="icon">✉️</span> <a href="<?= $postMeta["email"][0] ?>"><?= $postMeta["email"][0] ?></a><br>
                    <span class="icon">📞</span><?= $postMeta["phone"][0] ?><br>
                    <span class="icon">🌐</span><?= $postMeta["location"][0] ?>
                </p>
            </div>
        </div>
    </div>
 </div>




