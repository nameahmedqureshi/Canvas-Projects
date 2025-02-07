
<?php if (isset($attr['type']) && $attr['type'] == 'full') { ?>
    <style>
        ul.serviceDirectory.full.main-page {
            display: flex;
            flex-wrap: wrap;
            /* justify-content: space-between; */
            align-items: center;
        }

        ul.serviceDirectory.full.main-page li {
            margin-right: 15px;
            width: 31%;
            margin-bottom: 15px;
        }
    </style>

    <?php if (isset($_GET['county']) && isset($_GET['type'])) { ?>
        
        <ul class="directory services full main-page">
            <?php 
                $type = $_GET['type'];
                $args = array(
                    'post_type' => 'cpt-service-directry',
                    'post_status' => 'publish',
                    'posts_per_page' => -1,
                    'meta_query'     => [
                        [
                            'key'     => 'country',
                            'value'   => $value,
                            'compare' => 'like',
                        ],
                        [
                            'key'     => 'service_type',
                            'value'   => strtr($type, ["-" => " ", "and" => "&"]),
                            'compare' => '=',
                        ],
                        
                    ],
                );
                $services = new WP_Query($args);

                foreach ($services->posts ?? [] as $key => $value) { 
                    $metaData = get_post_meta($value->ID);
                    $image = !empty($metaData['person_image'][0]) ? wp_get_attachment_url($metaData['person_image'][0]) :  get_stylesheet_directory_uri( ).'/store/assets/images/no-preview.png';
                ?>
                    <li>
                        <a href="<?= home_url('service-detail/?slug='.$value->ID) ?>">
                            <div class="image">
                                <img src="<?= $image ?>" alt="">
                            </div>
                            <div class="detail">
                                <p class="service-type"><?= $metaData['service_type'][0] ?></p>
                                <p class="service-location"><?= $metaData['location'][0] ?></p>
                                <h6 class="title"><?= $metaData['name'][0] ?></h6>
                                <p class="description"><?= $metaData['short_description'][0] ?></p>
                            </div>
                        </a>
                    </li>
            <?php } ?>
        </ul>

    <?php } else if (isset($_GET['type']) || isset($_GET['county'])) { ?>

        <ul class="serviceDirectory full main-page county">
            <?php
                $data = $irishCounties = [ 'Antrim','Armagh','Carlow','Cavan','Clare','Cork','Derry','Donegal','Down','Dublin','Fermanagh','Galway','Kerry','Kildare','Kilkenny','Laois','Leitrim','Limerick','Longford','Louth','Mayo','Meath','Monaghan','Offaly','Roscommon','Sligo','Tipperary','Tyrone','Waterford','Westmeath','Wexford','Wicklow'];
                
                $typeSearch = '';
                $type = '';
                if (isset($_GET['type'])) {
                    $type = $_GET['type'];
                    $typeSearch = [
                        'key'     => 'service_type',
                         'value'   => strtr($type, ["-" => " ", "and" => "&"]),
                         'compare' => '=',
                    ];
                }

                foreach ($data as $key => $value) { 
                    $args = array(
                        'post_type' => 'cpt-service-directry',
                        'post_status' => 'publish',
                        'posts_per_page' => -1,
                        'meta_query'     => [
                            [
                                'key'     => 'country',
                                'value'   => $value,
                                'compare' => 'like',
                            ],
                            $typeSearch,
                            
                        ],
                    );
                    $services = new WP_Query($args);
                    $count = count($services->posts);
            ?>
                    <li>
                        <a href="<?= home_url('services-directory/?county='.$value.'&type='.$type) ?>">
                            <div class="icon">
                                <img src="https://img-dedicated.rip.ie/assets/services/ic_sympathy_cards.svg" alt="">
                            </div>
                            <h6 class="title"><?= $value ?></h6>
                            <span class="count"><?= $count ?></span>
                        </a>
                    </li>
            <?php } ?>
        </ul>

    <?php } else { ?>
            <ul class="serviceDirectory full main-page type">
                <?php
                    $serviceType = [
                        "Funeral Directors",
                        "Crematoriums",
                        "Funeral Video Streaming",
                        "Funeral Car Hire",
                        "Florists",
                        "Bereavement Counsellors & Groups",
                        "Caterers",
                        "Headstones for Graves",
                        "Suit Hire",
                        "Funeral Celebrants/ Civil & Humanist Funerals",
                        "Singers & Musicians",
                        "Dove Hire",
                        "Grave Maintenance",
                        "Grave Markers, Plaques & Ornaments",
                        "Memorial Cards/Mass Cards",
                        "Urns & Keepsakes"
                    ];

                    foreach ($serviceType ?? [] as $key => $value) { 
                        $args = array(
                            'post_type' => 'cpt-service-directry',
                            'post_status' => 'publish',
                            'posts_per_page' => -1,
                            'meta_query'     => [
                                [
                                    'key'     => 'service_type',
                                    'value'   => $value,
                                    'compare' => '=',
                                ],
                            ],
                        );
                        $services = new WP_Query($args);
                        $count = count($services->posts);
                        $parameter = strtr($value, [" " => "-", "&" => "and"]);
                        ?>
                        <li>
                            <a href="<?= home_url('services-directory/?type='.$parameter) ?>">
                                <div class="icon">
                                    <img src="https://img-dedicated.rip.ie/assets/services/ic_sympathy_cards.svg" alt="">
                                </div>
                                <h6 class="title"><?= $value ?></h6>
                                <span class="count"><?= $count ?></span>
                            </a>
                        </li>
                <?php } ?>
            </ul>

<?php } } else{?>

    <ul class="serviceDirectory ads sidebar">
        <?php 
            
            $serviceType = [
                "Funeral Directors",
                "Crematoriums",
                "Funeral Video Streaming",
                "Funeral Car Hire",
                "Florists",
                "Bereavement Counsellors & Groups",
                "Caterers",
                "Headstones for Graves",
                "Suit Hire",
                "Funeral Celebrants/ Civil & Humanist Funerals",
                "Singers & Musicians",
                "Dove Hire",
                "Grave Maintenance",
                "Grave Markers, Plaques & Ornaments",
                "Memorial Cards/Mass Cards",
                "Urns & Keepsakes"
            ];
            
            shuffle($serviceType);
            foreach ($serviceType as $key => $value) { 

                if ($key >= 6) {break;}
                $args = array(
                    'post_type' => 'cpt-service-directry',
                    'post_status' => 'publish',
                    'posts_per_page' => -1,
                    'meta_query'     => [
                        [
                            'key'     => 'service_type',
                            'value'   => $value,
                            'compare' => '=',
                        ],
                    ],
                );
                $services = new WP_Query($args);
                $count = count($services->posts);
                $parameter = strtr($value, [" " => "-", "&" => "and"]);
        ?>
                <li>
                    <a href="<?= home_url('services-directory/?type='.$parameter) ?>">
                        <div class="icon">
                            <img src="https://img-dedicated.rip.ie/assets/services/ic_sympathy_cards.svg" alt="">
                        </div>
                        <h6 class="title"><?= $value ?></h6>
                        <span class="count"><?= $count ?></span>
                    </a>
                </li>
        <?php } ?>
        
        <li>
            <a class="browseAll" href="<?= home_url('services-directory/') ?>">
                Browse All Categories
                <svg width="14" height="14" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="m10.477 6.33-4.47-4.47L7.185.682l6.482 6.481-6.482 6.482-1.178-1.178 4.47-4.47H.333V6.33h10.144Z" fill="#3D320E"></path></svg>
            </a>
        </li>
    </ul>
<?php } ?>
