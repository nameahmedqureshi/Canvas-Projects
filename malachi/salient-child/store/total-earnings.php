<?php /* Template Name: Total Earnings */ ?>

<!-- BEGIN: Head-->

<?php include "includes/styles.php"; ?>
    <link rel="stylesheet" type="text/css" href="<?= $directory_url ?>/app-assets/vendors/css/vendors.min.css">
    <link rel="stylesheet" type="text/css" href="<?= $directory_url ?>/app-assets/vendors/css/tables/datatable/dataTables.bootstrap5.min.css">
    <link rel="stylesheet" type="text/css" href="<?= $directory_url ?>/app-assets/vendors/css/tables/datatable/responsive.bootstrap5.min.css">
    <link rel="stylesheet" type="text/css" href="<?= $directory_url ?>/app-assets/vendors/css/tables/datatable/buttons.bootstrap5.min.css">
    <link rel="stylesheet" type="text/css" href="<?= $directory_url ?>/app-assets/css/core/menu/menu-types/vertical-menu.css">

    <style>
        .card {
             margin-bottom: 0px !important;
        }
        .filter-btn{
            margin-top: 20px;
        }
        .dt-buttons button {
            border: 1px solid #82868b !important;
            background-color: transparent;
            color: #82868b;
            padding: 0.386rem 1.2rem;
            font-weight: 500;
            font-size: 1rem;
            border-radius: 0.358rem;
        }
        .dt-buttons button:hover {
            color: #fff;
            background-color: #7367f0;
            border-color: #7367f0;
        }
       
    </style>
<!-- END: Head-->
<?php include "includes/header.php"; ?>
<!-- BEGIN: Body-->

<body class="vertical-layout vertical-menu-modern  navbar-floating footer-static  " data-open="click" data-menu="vertical-menu-modern" data-col="">

    <!-- BEGIN: Main Menu-->
   <?php include "includes/manu.php"; ?>
    <!-- END: Main Menu-->

    <!-- BEGIN: Content-->
    <div class="app-content content ">
        <div class="content-overlay"></div>
        <div class="header-navbar-shadow"></div>
        <div class="content-wrapper container-xxl p-0">
            <div class="content-header row">
            </div>
            <div class="content-body">
                <!--list start -->
                <section class="app-user-list">
                    <!-- Total Earnings -->
                    <?php $user = wp_get_current_user();  ?>
                    <div class="card">
                        <div class="card-body border-bottom">
                            <h4 class="card-title">Monthly Total Earning</h4>
                            <section id="dropdown-with-outline-btn">
                                <div class="row">
                                    <div class="col-12">
                                        <div class="card">
                                            
                                            <form id="filter_earning">
                                                <div class="row">
                                                    <div class="col-md-4 col-12">
                                                        <div class="mb-1">
                                                            <label class="form-label" for="filter_type">Select Type</label>
                                                            <select class="form-select" name="filter_type" id="filter_type">
                                                                <option selected value="creations">Creations</option>
                                                                <option value="services">Services</option>
                                                                <option value="stl-library">STL Library</option>
                                                                <option value="print-on-demand">Print On Demand</option>
                                                                <option value="service-on-demand">Service On Demand</option>
                                                                <option value="bulk-manufacturing">Bulk Manufacturing</option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-4 col-12">
                                                        <div class="mb-1">
                                                            <label class="form-label" for="filter_year">Select Year</label>
                                                            <select class="form-select" name="filter_year" id="filter_year">
                                                                <?php $start_year = 2024; //  start year
                                                                    $current_year = date('Y'); // Current year 
                                                                    for ($year = $start_year; $year <= $current_year; $year++) { 
                                                                        $selected = ($year == $current_year) ? 'selected' : ''; ?>
                                                                        <option  value="<?= $year  ?>" <?= $selected ?>><?= $year  ?></option>
                                                                    <?php  } ?>
                                                            </select>
                                                        </div>
                                                    </div>
                                                
                                                    <div class="col-md-4 col-12">
                                                        <div class="btn-group">
                                                            <input type="hidden" name="action" value="filer_earning">
                                                            <button type="submit" class="btn btn-primary filter-btn"  aria-expanded="false">
                                                                Filter
                                                            </button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </form>
                                            
                                        </div>
                                    </div>
                                </div>
                            </section>
                        </div>
                       
                        <div class="card-datatable table-responsive pt-0">
                            <table class="datatables-basic table">
                                <thead>
                                    <tr>
                                        <th>Month Name</th>
                                        <th>Total Commission</th>
                                        <th>Total Sale</th>
                                    
                                    </tr>
                                </thead>
                                <tbody class="table_body">
                                    <?php
                                        // global $wpdb;

                                        // $current_year = date('Y');
                                        // $meta_key = 'total_price'; // Replace with your actual meta key
                                        // $post_type = 'services-order'; // Replace with your actual post type

                                        // $query = $wpdb->prepare("
                                        //     SELECT DATE_FORMAT(post_date, '%%Y-%%m') as month, 
                                        //         SUM(CAST(pm.meta_value AS UNSIGNED)) AS total_amount
                                        //     FROM {$wpdb->postmeta} pm
                                        //     JOIN {$wpdb->posts} p ON pm.post_id = p.ID
                                        //     WHERE pm.meta_key = %s
                                        //     AND p.post_type = %s
                                        //     AND p.post_status IN ('draft', 'publish')
                                        //     AND YEAR(p.post_date) = %d
                                        //     GROUP BY DATE_FORMAT(p.post_date, '%%Y-%%m')
                                        //     ORDER BY DATE_FORMAT(p.post_date, '%%Y-%%m') ASC
                                        // ", $meta_key, $post_type, $current_year);

                                        // $results = $wpdb->get_results($query, OBJECT);

                                        $months = [
                                            'January', 'February', 'March', 'April', 'May', 'June', 
                                            'July', 'August', 'September', 'October', 'November', 'December'
                                        ];
                                        $monthly_totals = array_fill_keys($months, ['total_sale' => 0, 'total_commission' => 0]);
                            

                                        $arg = [
                                            'post_type' => 'total_sales',
                                            'posts_per_page' => -1,
                                            'date_query'     => [
                                                [
                                                    'year' => date('Y'),
                                                ],
                                            ],
                                            'meta_query'     => [
                                                [
                                                    'key'      => 'type',
                                                    'value'      => $_POST['filter_type'],
                                                    'compare'  => '=',
                                                ]
                                            ],
                                        ];
                                        $query = new WP_Query($arg);

                                        // Loop through posts and sum totals by month
                                        if ($query->have_posts()) {
                                            while ($query->have_posts()) {
                                                $query->the_post();

                                                // Get month as full name (e.g., "January")
                                                $post_month = date('F', strtotime(get_the_date('Y-m-d')));

                                                // Fetch meta values
                                                $total_price = (float) get_post_meta(get_the_ID(), 'total_price', true);
                                                $commission_amount = (float) get_post_meta(get_the_ID(), 'commission_amount', true);

                                                // Aggregate totals by month
                                                $monthly_totals[$post_month]['total_sale'] += $total_price;
                                                $monthly_totals[$post_month]['total_commission'] += $commission_amount;
                                            }
                                            wp_reset_postdata();
                                        }

                                    ?>
                                    <?php foreach ($months as $month) { ?>
                                        <tr>
                                            <td><?= $month ?></td>
                                            <td>$<?= number_format($monthly_totals[$month]['total_commission'], 2) ?></td>
                                            <td>$<?= number_format($monthly_totals[$month]['total_sale'], 2) ?></td>
                                            </tr>
                                    <?php } ?>
                                </tbody>
                            </table>
                        </div>

                    </div>

                    <!-- list and filter end -->
                </section>
                <!-- list ends -->

            </div>
        </div>
    </div>
    <!-- END: Content-->

    <div class="sidenav-overlay"></div>
    <div class="drag-target"></div>


    <?php include "includes/scripts.php"; ?>

    <script src="<?= $directory_url ?>/app-assets/vendors/js/tables/datatable/jquery.dataTables.min.js"></script>
    <script src="<?= $directory_url ?>/app-assets/vendors/js/tables/datatable/dataTables.bootstrap5.min.js"></script>
    <script src="<?= $directory_url ?>/app-assets/vendors/js/tables/datatable/dataTables.responsive.min.js"></script>
    <script src="<?= $directory_url ?>/app-assets/vendors/js/tables/datatable/responsive.bootstrap5.min.js"></script>
    <script src="<?= $directory_url ?>/app-assets/vendors/js/tables/datatable/pdfmake.min.js"></script>
    <script src="<?= $directory_url ?>/app-assets/vendors/js/tables/datatable/vfs_fonts.js"></script>
    <script src="<?= $directory_url ?>/app-assets/js/scripts/components/components-dropdowns.js"></script>

    <script>
        jQuery(document).ready(function(){
            var table = $('.datatables-basic').DataTable({
                pageLength: 25,

            // order: [[1, 'desc']],
            dom:
                '<"d-flex justify-content-between align-items-center header-actions mx-2 row mt-75"' +
                '<"col-sm-12 col-lg-4 d-flex justify-content-center justify-content-lg-start" l>' +
                '<"col-sm-12 col-lg-8 ps-xl-75 ps-0"<"dt-action-buttons d-flex align-items-center justify-content-center justify-content-lg-end flex-lg-nowrap flex-wrap"<"me-1"f>B>>' +
                '>t' +
                '<"d-flex justify-content-between mx-2 row mb-1"' +
                '<"col-sm-12 col-md-6"i>' +
                '<"col-sm-12 col-md-6"p>' +
                '>',
            });

            table.on('draw', function () {
                feather.replace({
                    width: 14,
                    height: 14
                });
            });

            jQuery("#filter_earning").submit(function(e) {
                e.preventDefault(); // avoid to execute the actual submit of the form.
                
                var form = new FormData(this);	
                jQuery(this).find('button[type=submit]').append('<i class="fa fa-spinner fa-spin" style="font-size:24px"></i>');
                jQuery(this).find('button[type=submit]').prop('disabled',true);
                var thiss = jQuery(this);
                jQuery('.card-datatable').waitMe({
                    effect : 'bounce',
                    text : '',
                    bg : 'rgb(40 48 70 / 48%)',
                    color : '#000',
                    maxSize : '',
                    waitTime : -1,
                    textPos : 'vertical',
                    fontSize : '',
                    source : '',
                });
                
                jQuery.ajax({
                    type: 'post',
                    url: "<?= admin_url('admin-ajax.php') ?>",
                    data: form,
                    dataType : 'json',
                    cache:false,
                    contentType: false,
                    processData: false,
                    success: function (response) {
                        jQuery('.fa.fa-spinner.fa-spin').remove();
                        jQuery('.card-datatable').waitMe('hide');
                        jQuery(thiss).find('button[type=submit]').prop('disabled',false);
                        console.log(response.html);
                        $('.table_body').html(response.html);
                    
                    },
                    error : function(errorThrown){
                    console.log(errorThrown);
                    jQuery('.card-datatable').waitMe('hide');
                }
                });
            }); 

           jQuery('.filter-btn').click();

        });

            
    </script>
</body>
<!-- END: Body-->

</html>