<?php /*Template Name: Upload */ ?>
<?php get_header();
if (is_user_logged_in() && current_user_can('customer')) {

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

    $user = wp_get_current_user();

    $args = array(
        'post_type' => 'folders',
        'posts_per_page' => -1,
        'author' => $user->ID,
    );

    $query = new WP_Query($args);

    // query to get link logs
    if (isset($_GET['f'])) {

        $logs = array(
            'post_type' => 'shareable-links',
            'posts_per_page' => -1,
            'author'   => $user->ID,
            'meta_query'     => array(
                array(
                    'key'     => 'folder',
                    'value'   => $_GET['f'],
                    'compare' => '=',
                ),
            ),
        );
    } else {

        $logs = array(
            'post_type' => 'shareable-links',
            'posts_per_page' => -1,
            'author'   => $user->ID,
        );
    }

    //   var_dump($logs);
    $link = new WP_Query($logs);

    // $currencies = [
    //     'AFN' => 'Afghan Afghani',
    //     'ALL' => 'Albanian Lek',
    //     'DZD' => 'Algerian Dinar',
    //     'AOA' => 'Angolan Kwanza',
    //     'ARS' => 'Argentine Peso',
    //     'AMD' => 'Armenian Dram',
    //     'AWG' => 'Aruban Florin',
    //     'AUD' => 'Australian Dollar',
    //     'AZN' => 'Azerbaijani Manat',
    //     'BSD' => 'Bahamian Dollar',
    //     'BDT' => 'Bangladeshi Taka',
    //     'BBD' => 'Barbadian Dollar',
    //     'BZD' => 'Belize Dollar',
    //     'BMD' => 'Bermudian Dollar',
    //     'BOB' => 'Bolivian Boliviano',
    //     'BAM' => 'Bosnia & Herzegovina Convertible Mark',
    //     'BWP' => 'Botswana Pula',
    //     'BRL' => 'Brazilian Real',
    //     'GBP' => 'British Pound',
    //     'BND' => 'Brunei Dollar',
    //     'BGN' => 'Bulgarian Lev',
    //     'BIF' => 'Burundian Franc',
    //     'KHR' => 'Cambodian Riel',
    //     'CAD' => 'Canadian Dollar',
    //     'CVE' => 'Cape Verdean Escudo',
    //     'KYD' => 'Cayman Islands Dollar',
    //     'XAF' => 'Central African Cfa Franc',
    //     'XPF' => 'Cfp Franc',
    //     'CLP' => 'Chilean Peso',
    //     'CNY' => 'Chinese Renminbi Yuan',
    //     'COP' => 'Colombian Peso',
    //     'KMF' => 'Comorian Franc',
    //     'CDF' => 'Congolese Franc',
    //     'CRC' => 'Costa Rican Colón',
    //     'HRK' => 'Croatian Kuna',
    //     'CZK' => 'Czech Koruna',
    //     'DKK' => 'Danish Krone',
    //     'DJF' => 'Djiboutian Franc',
    //     'DOP' => 'Dominican Peso',
    //     'XCD' => 'East Caribbean Dollar',
    //     'EGP' => 'Egyptian Pound',
    //     'ETB' => 'Ethiopian Birr',
    //     'EUR' => 'Euro',
    //     'FKP' => 'Falkland Islands Pound',
    //     'FJD' => 'Fijian Dollar',
    //     'GMD' => 'Gambian Dalasi',
    //     'GEL' => 'Georgian Lari',
    //     'GIP' => 'Gibraltar Pound',
    //     'GTQ' => 'Guatemalan Quetzal',
    //     'GNF' => 'Guinean Franc',
    //     'GYD' => 'Guyanese Dollar',
    //     'HTG' => 'Haitian Gourde',
    //     'HNL' => 'Honduran Lempira',
    //     'HKD' => 'Hong Kong Dollar',
    //     'HUF' => 'Hungarian Forint',
    //     'ISK' => 'Icelandic Króna',
    //     'INR' => 'Indian Rupee',
    //     'IDR' => 'Indonesian Rupiah',
    //     'ILS' => 'Israeli New Sheqel',
    //     'JMD' => 'Jamaican Dollar',
    //     'JPY' => 'Japanese Yen',
    //     'KZT' => 'Kazakhstani Tenge',
    //     'KES' => 'Kenyan Shilling',
    //     'KGS' => 'Kyrgyzstani Som',
    //     'LAK' => 'Lao Kip',
    //     'LBP' => 'Lebanese Pound',
    //     'LSL' => 'Lesotho Loti',
    //     'LRD' => 'Liberian Dollar',
    //     'MOP' => 'Macanese Pataca',
    //     'MKD' => 'Macedonian Denar',
    //     'MGA' => 'Malagasy Ariary',
    //     'MWK' => 'Malawian Kwacha',
    //     'MYR' => 'Malaysian Ringgit',
    //     'MVR' => 'Maldivian Rufiyaa',
    //     'MRO' => 'Mauritanian Ouguiya',
    //     'MUR' => 'Mauritian Rupee',
    //     'MXN' => 'Mexican Peso',
    //     'MDL' => 'Moldovan Leu',
    //     'MNT' => 'Mongolian Tögrög',
    //     'MAD' => 'Moroccan Dirham',
    //     'MZN' => 'Mozambican Metical',
    //     'MMK' => 'Myanmar Kyat',
    //     'NAD' => 'Namibian Dollar',
    //     'NPR' => 'Nepalese Rupee',
    //     'ANG' => 'Netherlands Antillean Gulden',
    //     'TWD' => 'New Taiwan Dollar',
    //     'NZD' => 'New Zealand Dollar',
    //     'NIO' => 'Nicaraguan Córdoba',
    //     'NGN' => 'Nigerian Naira',
    //     'NOK' => 'Norwegian Krone',
    //     'PKR' => 'Pakistani Rupee',
    //     'PAB' => 'Panamanian Balboa',
    //     'PGK' => 'Papua New Guinean Kina',
    //     'PYG' => 'Paraguayan Guaraní',
    //     'PEN' => 'Peruvian Nuevo Sol',
    //     'PHP' => 'Philippine Peso',
    //     'PLN' => 'Polish Złoty',
    //     'QAR' => 'Qatari Riyal',
    //     'RON' => 'Romanian Leu',
    //     'RUB' => 'Russian Ruble',
    //     'RWF' => 'Rwandan Franc',
    //     'STD' => 'São Tomé and Príncipe Dobra',
    //     'SHP' => 'Saint Helenian Pound',
    //     'SVC' => 'Salvadoran Colón',
    //     'WST' => 'Samoan Tala',
    //     'SAR' => 'Saudi Riyal',
    //     'RSD' => 'Serbian Dinar',
    //     'SCR' => 'Seychellois Rupee',
    //     'SLL' => 'Sierra Leonean Leone',
    //     'SGD' => 'Singapore Dollar',
    //     'SBD' => 'Solomon Islands Dollar',
    //     'SOS' => 'Somali Shilling',
    //     'ZAR' => 'South African Rand',
    //     'KRW' => 'South Korean Won',
    //     'LKR' => 'Sri Lankan Rupee',
    //     'SRD' => 'Surinamese Dollar',
    //     'SZL' => 'Swazi Lilangeni',
    //     'SEK' => 'Swedish Krona',
    //     'CHF' => 'Swiss Franc',
    //     'TJS' => 'Tajikistani Somoni',
    //     'TZS' => 'Tanzanian Shilling',
    //     'THB' => 'Thai Baht',
    //     'TOP' => 'Tongan Paʻanga',
    //     'TTD' => 'Trinidad and Tobago Dollar',
    //     'TRY' => 'Turkish Lira',
    //     'UGX' => 'Ugandan Shilling',
    //     'UAH' => 'Ukrainian Hryvnia',
    //     'AED' => 'United Arab Emirates Dirham',
    //     'USD' => 'United States Dollar',
    //     'UYU' => 'Uruguayan Peso',
    //     'UZS' => 'Uzbekistani Som',
    //     'VUV' => 'Vanuatu Vatu',
    //     'VND' => 'Vietnamese Đồng',
    //     'XOF' => 'West African Cfa Franc',
    //     'YER' => 'Yemeni Rial',
    //     'ZMW' => 'Zambian Kwacha'
    // ];


?>
    <meta name="viewport" content="width=device-width, initial-scale=1.0,user-scalable=no">
    <link rel="icon" href="<?= get_stylesheet_directory_uri() . '/custom/assets/front/images/favicon.png' ?>">
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700;900&display=swap" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.7/css/jquery.dataTables.css" />
    <link rel="stylesheet" href="<?= get_stylesheet_directory_uri() . '/custom/assets/front/css/main.css' ?>">
    <link rel="stylesheet" href="<?= get_stylesheet_directory_uri() . '/custom/assets/front/css/responsive.css' ?>">
    <style>
        input[type=number]::-webkit-inner-spin-button,
        input[type=number]::-webkit-outer-spin-button {
            -webkit-appearance: textfield;
            margin: 0;
        }

        p.desc {
            font-size: 12px;
        }

        input[type=number] {
            -moz-appearance: textfield;
        }

        div#card-element {
            padding: 20px;
            background-color: #e9e9e9;

        }

        .per_day {
            display: flex;
            align-items: center;
        }

        input.price_input {
            width: 70%;
        }

        .para {
            margin-left: 8px;
        }

        .main_col_middle {
            width: 100%;
            padding: 45px;
        }

        .main_col_left {
            width: 20%;
        }

        .right-open {
            position: absolute;
            right: 0px;
            width: 28%;
            height: 100%;
        }

        table#myTable td i {
            cursor: pointer;
        }

        .fa-download:before {
            color: black;
        }
    </style>
    <section class="main_wrapper">
        <div class="main_col_left">
            <a href="<?= site_url('/') ?>" class="logo_box">
                <img src="<?= get_stylesheet_directory_uri() . '/custom/assets/front/images/logo-main.png' ?>" alt="logo" class="img_fluid">
            </a>
            <div class="nav_wrapper">
                <div class="nav_bar">
                    <ul>
                        <li>
                            <a href="<?= site_url('upload/') ?>">
                                <img src="<?= get_stylesheet_directory_uri() . '/custom/assets/front/images/table-icon-3.png' ?>" alt="icon">Home</a>
                        </li>
                        <li class="drop_dwon_nav">
                            <a href="javascript:;">
                                <img src="<?= get_stylesheet_directory_uri() . '/custom/assets/front/images/table-icon-1.png' ?>" alt="icon">My Folders </a>
                        </li>
                        <ul class="drop_dwon_list">
                            <!-- <li>
                            <a href="<?= site_url('upload/')  ?>" >
                            <img src="<?= get_stylesheet_directory_uri() . '/custom/assets/front/images/table-icon-1.png' ?>" alt="icon">All </a>
                        </li> -->
                            <li>
                                <a href="<?= site_url('upload/?f=137')  ?>">
                                    <img src="<?= get_stylesheet_directory_uri() . '/custom/assets/front/images/table-icon-1.png' ?>" alt="icon">New</a>
                            </li>
                            <?php while ($query->have_posts()) : $query->the_post(); ?>
                                <li>
                                    <a href="<?= site_url('upload/?f=' . get_the_ID())  ?>" data-id="<?= get_the_ID() ?>">
                                        <img src="<?= get_stylesheet_directory_uri() . '/custom/assets/front/images/table-icon-1.png' ?>" alt="icon"><?= get_the_title((get_the_ID()))  ?> <i class="fa-regular fa-pen-to-square edit-folder" style="margin-left: 30%;"></i>
                                        |<i class="fa-solid fa-trash folder-deleted" data-id="<?= get_the_ID() ?>"></i></a>

                                </li>
                            <?php endwhile;  ?>
                        </ul>
                        <li>
                            <a class="create-folder" href="javascript:;">
                                <img src="<?= get_stylesheet_directory_uri() . '/custom/assets/front/images/table-icon-1.png' ?>" alt="icon">Create Folder</a>
                        </li>
                        <li>
                            <a href="<?= site_url('logout') ?>">
                                <img src="<?= get_stylesheet_directory_uri() . '/custom/assets/front/images/table-icon-3.png' ?>" alt="icon">Logout</a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
        <div class="main_col_middle">
            <div class="header_main">
                <div class="left_col">
                    <h1 class="page_title">
                        <img src="<?= get_stylesheet_directory_uri() . '/custom/assets/front/images/drive-icon.png' ?>" alt="img"><?= isset($_GET['f']) ?  get_the_title($_GET['f']) : 'Home' ?>
                    </h1>
                    <p <?= isset($_GET['f']) ? 'style="display:none;"' : '' ?>>Recent</p>
                </div>
                <div class="right_col">
                    <div class="inner_col">
                        <!-- <div class="search_bar">
                        <input type="search" placeholder="Search here...">
                        <img src="<?= get_stylesheet_directory_uri() . '/custom/assets/front/images/search.png' ?>" alt="img" class="seach_icon">
                    </div> -->
                        <div class="profile_info_top">
                            <p class="name_logo"><?= substr($user->user_login, 0, 2); ?></p>
                            <p class="user_name"><?= $user->user_login ?></p>
                            <!-- <button class="profile_info_dropdown_btn">
                            <img src="<?= get_stylesheet_directory_uri() . '/custom/assets/front/images//Btn-Option-Light.png' ?>" alt="img">
                        </button> -->
                        </div>
                    </div>
                    <label for="upload_main" class="upload_btn_top">
                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="21" viewBox="0 0 20 21" fill="none">
                            <path d="M15.8333 11.3333H10.8333V16.3333H9.16666V11.3333H4.16666V9.66666H9.16666V4.66666H10.8333V9.66666H15.8333V11.3333Z" fill="#F9FAFB" />
                        </svg> Upload File <input type="file" id="upload_main" style="display: none;">
                    </label>
                </div>
            </div>
            <div class="main_content_wrapper">
                <div class="top_card_row" <?= isset($_GET['f']) ? 'style="display:none;"' : '' ?>>
                    <?php $count = 0;
                    while ($link->have_posts() && $count < 4) : $link->the_post();
                        $source_url = get_post_meta(get_the_ID(), 'downloadable_link', true);
                        $expiration_date =  get_post_meta(get_the_ID(), 'expiration_date', true);
                        // Use parse_url to get the path component of the URL
                        $path = parse_url($source_url, PHP_URL_PATH);
                        // Use pathinfo to extract file information
                        $fileInfo = pathinfo($path);
                        // Get the file extension
                        $fileType = $fileInfo['extension']; ?>

                        <a <?= date('Y-m-d') > $expiration_date ? 'style="display:none"' : '' ?> href="<?= get_permalink(get_the_ID()) ?>" target="_blank" class="gen_card">
                            <p class="card_title">
                                <img src="<?= get_stylesheet_directory_uri() . '/custom/assets/front/images/img-icon.png' ?>" alt="img"><?= get_the_title(get_the_ID())  ?>
                            </p>
                            <div class="img_box">
                                <?php if ($fileType == 'zip') { ?>
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
                        </a>

                    <?php $count++;
                    endwhile; ?>
                </div>
                <h2 class="gen_title">My Files</h2>
                <div class="table_wrapper">
                    <table id="myTable" class="hover" style="width:100%">
                        <thead>
                            <tr>
                                <th>Folder</th>
                                <th>Name</th>
                                <th>Description</th>
                                <th>Created</th>
                                <th>Expire Date</th>
                                <th>Type</th>
                                <th>Size</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php while ($link->have_posts()) : $link->the_post();
                                $folder_id = get_post_meta(get_the_ID(), 'folder', true);
                                $url =  get_post_meta(get_the_ID(), 'downloadable_link', true);
                                $expiration_date =  get_post_meta(get_the_ID(), 'expiration_date', true);
                                $expiration_days =  get_post_meta(get_the_ID(), 'expiration_days', true);
                                $expire = date('Y-m-d', strtotime(get_the_date() . ' + ' . $expiration_days . ' days'));

                                // var_dump($expire );
                                // Use parse_url to get the path component of the URL
                                $path = parse_url($url, PHP_URL_PATH);
                                // Use pathinfo to extract file information
                                $fileInfo = pathinfo($path);
                                // Get the file extension
                                $fileType = $fileInfo['extension']; ?>
                                <tr>
                                    <td>
                                        <div class="flex_wrap">
                                            <span class="table_icon">
                                                <img src="<?= get_stylesheet_directory_uri() . '/custom/assets/front/images/table-icon-1.png' ?>" alt="img">
                                            </span>
                                            <span><?= get_the_title($folder_id) ?></span>
                                        </div>
                                    </td>
                                    <td><?= get_the_title(get_the_ID()) ?></td>

                                    <td><?= get_post_field('post_content', get_the_ID()) ? get_post_field('post_content', get_the_ID()) : '----'; ?></td>
                                    <td><?= get_the_date('j F Y');  ?></td>
                                    <td><?= date('j F Y', strtotime($expire)); ?></td>

                                    <td>
                                        <div class="flex_wrap">
                                            <span class="name_icon"><?= substr($user->user_login, 0, 2); ?></span>
                                            <span><?= $fileType ?></span>
                                        </div>
                                    </td>
                                    <td><?= getFileSizeFromUrl($url); ?></td>
                                    <td><a <?= date('Y-m-d') > $expiration_date ? 'style="pointer-events:none; opacity:0.3;"' : '' ?> href="<?= get_permalink(get_the_ID()) ?>" target="_blank"><i data-url="<?= $url ?>" class="fa-solid fa-download"></i></a>
                                        &nbsp&nbsp<i <?= date('Y-m-d') > $expiration_date ? 'style="pointer-events:none; opacity:0.3;"' : '' ?> class="fa-regular fa-copy" data-url="<?= get_permalink(get_the_ID()) ?>"></i>
                                        &nbsp&nbsp<i class="fa-solid fa-trash link-deleted" data-id="<?= get_the_ID() ?>"></i></td>
                                </tr>
                            <?php endwhile; ?>

                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <div class="main_col_right right-open">
            <h2 class="right_header_top_text">Upload File<i class="fa-solid fa-xmark cross" style="float: right; cursor: pointer;"></i></h2>
            <div class="file_details_listing">
                <form id="upload" enctype="multipart/form-data">
                    <div class="col-12">
                        <div class="form_group mb-4">
                            <label for="" class="gen_label">Desired URL</label>
                            <p class="desc">www.thingsandinfo.com/.../DESIRED_URL_NAME</p>
                            <input type="text" name="title" placeholder="Enter Desired URL" class="gen_input" required>
                        </div>

                        <div class="form_group mb-4">
                            <label for="" class="gen_label">Select Folder</label>
                            <select name="folders">
                                <option value="" selected hidden disabled>Select Folder</option>
                                <?php foreach (get_posts(['post_type' => 'folders', 'numberposts' => -1,  'author' => $user->ID,]) as $post) : ?>
                                    <?php if ($post->ID != 137) : ?>
                                        <option value="<?php echo esc_attr($post->ID); ?>"><?php echo esc_html($post->post_title); ?></option>
                                    <?php endif; ?>
                                <?php endforeach; ?>
                            </select>

                        </div>

                        <div class="form_group mb-4">
                            <label for="" class="gen_label">Desciption</label>
                            <textarea name="desciption" rows="12" cols="50" class="gen_input"></textarea>
                        </div>

                        <div class="form_group mb-4">
                            <label for="" class="gen_label">Select File</label>
                            <input type="file" name="upload_file" class="gen_input" required>
                        </div>
                        <!-- <div class="form_group mb-4">
                        <label for="" class="gen_label">Select Currency</label>
                        <select id="currencyDropdown" name="currency">
                            <?php foreach ($currencies as $key => $value) { ?>
                               <option value="<?= $key ?>"><?= $value ?></option>
                           <?php } ?>
                        </select>
                    </div> -->

                        <div class="form_group mb-4">
                            <label for="" class="gen_label">How many days do you want it online?</label>
                            <div class="per_day">
                                <input type="number" min="1" value="1" name="expiration_days" class="gen_input price_input" required>
                                <p class="para">$<span class="price_per_day">0.50 </span>/day</p>
                                <!-- <p class="para"><span class="price_per_day">$0.50 </span><span class="currency_symbol">USD</span>/day</p>       -->
                            </div>
                        </div>

                        <div class="form_group mb-4">
                            <div id="card-element"></div>
                        </div>

                    </div>
                    <div class="col-6">
                        <div class="form_group mt-4">
                            <button type="submit" class="submit_btn">Get Link</button>
                        </div>
                    </div>
                    <input type="hidden" name="action" value="get_link" />

                </form>
            </div>
        </div>
    </section>

<?php } else {
    wp_redirect('/');
}
get_footer(); ?>
<script>
    (function($) {
        $(document).ready(function() {
            // stripe 
            // console.log(stripe_private_key.key_url);
            var stripe = Stripe(stripe_private_key.key_url);

            var elements = stripe.elements();
            var cardElement = elements.create('card', {
                hidePostalCode: true,
            });
            cardElement.mount('#card-element');

            jQuery(document).on('change', '#currencyDropdown', function() {
                jQuery('.currency_symbol').text(jQuery(this).val());
            });


            $('#upload').submit(function(e) {
                e.preventDefault();

                // Collect form data
                var form = new FormData(this);
                $('body').waitMe({
                    effect: 'facebook',
                    text: '',
                    bg: 'rgba(255,255,255,0.7)',
                    color: '#000',
                    maxSize: '',
                    waitTime: -1,
                    textPos: 'vertical',
                    fontSize: '',
                    source: '',
                });

                stripe.createToken(cardElement).then(function(result) {
                    if (result.error) {
                        // Handle error
                        Swal.fire({
                            title: 'Error',
                            text: result.error.message,
                            icon: "error",
                        })
                        $('body').waitMe('hide');
                        return false;
                    } else {
                        // Attach the token or source to the form data
                        form.append('stripeToken', result.token.id);
                        // Make the API call
                        $.ajax({
                            type: 'post',
                            url: '<?= admin_url('admin-ajax.php'); ?>',
                            data: form,
                            dataType: 'json',
                            cache: false,
                            contentType: false,
                            processData: false,
                            success: function(response) {
                                $('body').waitMe('hide');
                                Swal.fire({
                                    title: response.icon,
                                    text: response.message,
                                    icon: response.icon,
                                })
                                // Handle the API response
                                console.log(response.url);
                                if (response.status) {
                                    $('#upload')[0].reset();
                                    $('#upload').after('<div class="transfer-link"><input class="transfer-link__url" readonly="" value="' + response.url + '"><button class="copy-link">Copy Link</button></div>');
                                    $('#upload').hide();
                                }
                            },
                            error: function(error) {
                                $('body').waitMe('hide');

                                // Handle the API error
                                console.error(error);
                            }
                        });
                    }
                });
            });

            $(document).on('change', '.price_input', function() {
                var day = $(this).val();
                $('.price_per_day').text(day * 0.50);
            })
        });
    })(jQuery);
</script>