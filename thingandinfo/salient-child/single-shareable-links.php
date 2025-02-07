<?php
get_header();
// Get the current post
$post = get_post(get_the_ID());

$source_url = get_post_meta($post->ID, 'downloadable_link', true);
$expiration_days =  get_post_meta(get_the_ID(), 'expiration_days', true);

$current_url = home_url(add_query_arg(array(), $wp->request)); // Get the current URL
$name = basename($current_url); // Get the last part of the URL
// var_dump($name);
$path = parse_url($source_url, PHP_URL_PATH);
// Use pathinfo to extract file information
$fileInfo = pathinfo($path);
// Get the file extension
$fileType = $fileInfo['extension'];

function getFileSizeFromUrl($url)
{
    $headers = get_headers($url, true);

    // Check if the 'Content-Length' header is present
    if (isset($headers['Content-Length'])) {
        // Get the file size in bytes
        $fileSizeBytes = (int)$headers['Content-Length'];

        // Convert bytes to kilobytes or megabytes for better readability
        $fileSizeKB = $fileSizeBytes / 1024;
        $fileSizeMB = $fileSizeKB / 1024;

        // Choose the appropriate unit based on the file size
        if ($fileSizeMB >= 1) {
            return round($fileSizeMB, 2) . ' MB';
        } elseif ($fileSizeKB >= 1) {
            return round($fileSizeKB, 2) . ' KB';
        } else {
            return $fileSizeBytes . ' bytes';
        }
    } else {
        return 'Unable to determine file size.';
    }
}
?>
<section class="transfer_box">
    <div class="main_box">
        <div class="img_box">
            <?php if ($fileType == 'zip' || $fileType == 'rar') { ?>
                <img src="<?= get_stylesheet_directory_uri() . '/custom/assets/front/images/zip.png' ?>" alt="img" class="img_fluid">
            <?php  } elseif ($fileType == 'png' || $fileType == 'jpg' || $fileType == 'jpeg') { ?>
                <img src="<?= $source_url ?>" alt="img">
            <?php  } elseif ($fileType == 'pdf') { ?>
                <img src="<?= get_stylesheet_directory_uri() . '/custom/assets/front/images/pdf.png' ?>" alt="img" class="img_fluid">
            <?php  } elseif ($fileType == 'xlsx' || $fileType == 'xls' || $fileType == 'xml') { ?>
                <img src="<?= get_stylesheet_directory_uri() . '/custom/assets/front/images/xlsx.png' ?>" alt="img" class="img_fluid">
            <?php  } elseif ($fileType == 'docx' || $fileType == 'doc') { ?>
                <img src="<?= get_stylesheet_directory_uri() . '/custom/assets/front/images/ms-word.png' ?>" alt="img" class="img_fluid">
            <?php  } else { ?>
                <img src="<?= get_stylesheet_directory_uri() . '/custom/assets/front/images/file.png' ?>" alt="img" class="img_fluid">
            <?php  } ?>
            <!-- <img src="<?= $source_url ?>" alt="img" class="img_fluid"> -->
        </div>
        <!-- <svg class="downloader__top-icon" viewBox="0 0 170 170">
            <g fill="#d4d7d9" fill-rule="evenodd">
                <path d="M145.104 24.896c33.195 33.194 33.195 87.014 0 120.208-33.194 33.195-87.014 33.195-120.208 0C-8.3 111.91-8.3 58.09 24.896 24.896 58.09-8.3 111.91-8.3 145.104 24.896zm-7.071 7.071c-29.29-29.29-76.777-29.29-106.066 0-29.29 29.29-29.29 76.777 0 106.066 29.29 29.29 76.777 29.29 106.066 0 29.29-29.29 29.29-76.777 0-106.066z"></path>
                <path d="M82 100.843V59.007A4.006 4.006 0 0 1 86 55c2.21 0 4 1.794 4 4.007v41.777l15.956-15.956a4.003 4.003 0 0 1 5.657 0 4.004 4.004 0 0 1 0 5.657l-22.628 22.628a3.99 3.99 0 0 1-3.017 1.166 3.992 3.992 0 0 1-3.012-1.166L60.328 90.485a4.003 4.003 0 0 1 0-5.657 4.004 4.004 0 0 1 5.657 0L82 100.843z"></path>
            </g>
        </svg> -->
        <h2>Ready when you are</h2>
        <p class="exp">Transfer expires in <?= $expiration_days ?> days</p>
        <h5 class="title"><?= $name ?></h5>
        <div class="main_inner_box">
            <div class="inner_box">
                <p><?= $name ?></p>
            </div>
            <div class="inner_box2">
                <p><?= getFileSizeFromUrl($source_url) . " - " . $fileType ?></p>
            </div>
        </div>
        <a class="button" href="<?= $source_url ?>" target="_blank">Download</a>
    </div>
</section>
<style>
    .img_box img {
        width: 150px;
        height: 150px;
        margin: auto;
        display: table;
        margin-bottom: 10px;
        object-fit: contain;
    }

    .inner_box2 {
        display: flex;
        align-items: center;
    }

    h5.title {
        margin-top: 20px;
    }

    .main_box h2 {
        text-align: center;
    }

    p.exp {
        text-align: center;
    }

    .inner_box p {
        padding-bottom: 0px;
        margin-bottom: -9px;
    }

    .inner_box2 p {
        margin: 6px 10px 0px 0px;
    }

    svg.downloader__top-icon {
        width: 50%;
        margin: auto;
        display: table;
        margin-bottom: 20px;
    }

    .main_inner_box {
        border-top: 1px solid #80808040;
        border-bottom: 1px solid #80808040;
    }

    .button {
        margin-top: 20px;
        margin: 20px auto;
        display: table;
        width: 70%;
        padding: 14px 0px;
        background: #7d7;
        border: #7d7;
        color: #fff;
        border-radius: 50px !important;
        text-align: center;
        box-shadow: 0px 0px 5px 0px #8080808f;
    }

    a.button:hover {
        color: white;
    }

    .main_box {
        /* display: flex; */
        margin: auto;
        display: table;
        width: 22%;
        box-shadow: 0px 0px 5px 0px #80808075;
        padding: 30px;
    }

    section.transfer_box {
        padding-top: 130px;
        padding-bottom: 130px;
    }

    @media (max-width: 840px) {
        section.transfer_box {
            padding-top: 80px;
        }

        .main_box {
            /* display: flex; */
            margin: auto;
            display: table;
            width: 42%;
            box-shadow: 0px 0px 5px 0px #80808075;
            padding: 30px;
        }
    }

    @media (max-width: 525px) {
        .main_box {
            /* display: flex; */
            margin: auto;
            display: table;
            width: 54%;
            box-shadow: 0px 0px 5px 0px #80808075;
            padding: 14px 10px 0px 20px;
        }

        section.transfer_box {
            padding-top: 40px;
        }
    }
</style>

<?php get_footer(); ?>