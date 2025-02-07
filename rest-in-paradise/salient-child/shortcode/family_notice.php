<?php
$postMeta = get_post_meta($_GET['slug']);
$get_post = get_post($_GET['slug']);
$funeral_director = get_user_meta($get_post->post_author);
$userData = get_userdata($get_post->post_author);
$categories = get_the_terms($get_post->ID, 'family-notice-category');
// var_dump($categories);
// var_dump($postMeta);
?>
<link rel="stylesheet" type="text/css" href="<?= get_stylesheet_directory_uri(  ) ?>/store/app-assets/vendors/css/editors/quill/quill.snow.css">

<style>
    .announcement-card {
        background: white;
        border-radius: 10px;
        /* box-shadow: 0 0 10px rgba(0, 0, 0, 0.1); */
        /* padding: 20px; */
        max-width: 700px;
        margin: 20px auto;
        border: 1px solid #c3ac93;
        box-shadow: 0 6px 12px hsla(31, 29%, 67%, .44);
        border-radius: 8px;
    }
	.FamilyNoticeBody {
    padding: 30px;
	background-image:url(https://devu20.testdevlink.net/rest-in-paradise/wp-content/uploads/2025/02/logo2.png);
    background-size: 70%;
    background-repeat: no-repeat;
    background-position: center;
	}
    .profile-img {
        border-radius: 10px;
        max-width: 150px;
    }
    .highlight {
        font-weight: bold;
        color: #d99207;
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

    .FamilyNotice_preview-header {
        display: flex;
        justify-content: center;
        align-items: center;
        height: 71px;
        border-radius: 8px 8px 0 0;
        border-bottom: 1px solid #c3ac93;
        background: url(https://rip.ie/ornament-left.svg) left 12px top 17px no-repeat, url(https://rip.ie/ornament-right.svg) right 12px top 17px no-repeat, #fdfcf7;
        background-size: 119px 39px;
    }

    .FamilyNotice_preview-header h3 {
        text-align: center;
    }

</style>

<div class="announcement-card">
    <?php if($categories[0]->name) { ?>
    <div class="FamilyNotice_preview-header">
        <h3><?= $categories[0]->name ?></h3>
    </div>
    <?php } ?>
    <div class="FamilyNoticeBody">
        <div class="text-center">
            <img src="<?= !empty($postMeta['person_image'][0]) ? wp_get_attachment_url($postMeta['person_image'][0]) :  get_stylesheet_directory_uri().'/assets/images/no-preview.png'  ?>" alt="Profile Picture" class="profile-img">
            <!-- <h4 class="mt-3">The death has occurred of</h4> -->
            <h2 class="highlight"><?= $postMeta["name"][0] .' '. $postMeta["surname"][0] ?></h2>
            <p><?= $postMeta["country"][0] ?></p>
        </div>
        <div class="ql-editor"><?= $postMeta["about"][0]  ?></div>

        <!-- <p><strong>AYLWARD</strong> Seamus (Late of Drumcondra, retired VHI, member of the Aquamarine Dive Club, Santry Community Gardens and HSBC Howth) January 24th 2025...</p>
        <p><strong>Reposing at</strong> Rom Massey & Sons Funeral Home, Ballymun Road, on Thursday, January 30th, 6:00pm - 8:00pm.</p>
        <p><strong>Funeral Mass</strong> on Friday, January 31st, 12:30pm at Saint Columba’s Church.</p> -->
        <!-- <p class="text-center mt-4"><a href="#" class="btn btn-warning">Funeral Service →</a></p> -->
        <hr>
        <p><strong>Date Published:</strong> <?=   date('l jS F Y', strtotime($get_post->post_date )); ?></p>
        <!-- <p><strong>Date of Death:</strong> Friday 24th January 2025</p> -->

        <!-- <div class="funeral-home">
            <h3>Rom Massey & Sons - Ballymun Rd</h3>
            <div class="funeralDetail">
                <p>The Civic Centre,<br>
                    Ballymun Road,<br>
                    D09 RFY6,<br>
                    Dublin
                </p>
                <p>
                    <span class="icon">🌐</span> <a href="https://www.rommassey.ie">www.rommassey.ie</a><br>
                    <span class="icon">✉️</span> <a href="mailto:info@rommassey.ie">info@rommassey.ie</a><br>
                    <span class="icon">📞</span> (01) 8367700 (24 hrs)
                </p>
            </div>

            <button class="funeral-home-btn">Funeral Home Map →</button>
        </div> -->
    </div>
 </div>




