<?php /*Template Name: View Profile */ ?>
<?php //if(is_user_logged_in()) {  wp_redirect(home_url('dashboard/')); exit; } ?>
<?php
$userMeta = get_userdata($_GET['id']);
?>
    <!-- BEGIN: Head-->
    <?php include "includes/styles.php"; ?>

    <link rel="stylesheet" type="text/css" href="<?= $directory_url ?>/app-assets/vendors/css/vendors.min.css">
    <!-- BEGIN: Vendor CSS-->
    <link rel="stylesheet" type="text/css" href="<?= $directory_url ?>/app-assets/vendors/css/vendors.min.css">
    <link rel="stylesheet" type="text/css" href="<?= $directory_url ?>/app-assets/vendors/css/forms/select/select2.min.css">
    <link rel="stylesheet" type="text/css" href="<?= $directory_url ?>/app-assets/vendors/css/animate/animate.min.css">
    <link rel="stylesheet" type="text/css" href="<?= $directory_url ?>/app-assets/vendors/css/extensions/sweetalert2.min.css">
    <link rel="stylesheet" type="text/css" href="<?= $directory_url ?>/app-assets/vendors/css/tables/datatable/dataTables.bootstrap5.min.css">
    <link rel="stylesheet" type="text/css" href="<?= $directory_url ?>/app-assets/vendors/css/tables/datatable/responsive.bootstrap5.min.css">
    <link rel="stylesheet" type="text/css" href="<?= $directory_url ?>/app-assets/vendors/css/tables/datatable/buttons.bootstrap5.min.css">
    <link rel="stylesheet" type="text/css" href="<?= $directory_url ?>/app-assets/vendors/css/tables/datatable/rowGroup.bootstrap5.min.css">
    <!-- END: Vendor CSS-->

    <!-- BEGIN: Page CSS-->
    <link rel="stylesheet" type="text/css" href="<?= $directory_url ?>/app-assets/css/core/menu/menu-types/vertical-menu.css">
    <link rel="stylesheet" type="text/css" href="<?= $directory_url ?>/app-assets/css/plugins/forms/form-validation.css">
    <link rel="stylesheet" type="text/css" href="<?= $directory_url ?>/app-assets/css/plugins/extensions/ext-component-sweet-alerts.css">
    <!-- END: Page CSS-->
    <style>
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
            background-color: #577226;
            border-color: #577226;
        }
    </style>

    <?php include "includes/header.php"; ?>

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
                    <section class="app-user-view-account">
                        <div class="row">
                            <!-- User Sidebar -->
                            <div class="col-xl-4 col-lg-5 col-md-5 order-1 order-md-0">
                                <!-- User Card -->
                                <div class="card">
                                    <div class="card-body">
                                        <div class="user-avatar-section">
                                            <div class="d-flex align-items-center flex-column">
                                                <?php
                                                $image_url = get_user_meta( $_GET['id'], 'profile_pic', true );
                                                $image_url = wp_get_attachment_image_url( $image_url );


                                                ?>
                                                <img class="img-fluid rounded mt-3 mb-2" src="<?= !empty($image_url) ? $image_url : get_stylesheet_directory_uri().'/store/assets/images/avatar.png' ?>" height="110" width="110" alt="User avatar" />
                                                <div class="user-info text-center">
                                                    <h4><?= $userMeta->display_name ?></h4>
                                                    <span class="badge bg-light-secondary">Member</span>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="d-flex justify-content-around my-2 pt-75">
                                            <div class="d-flex align-items-start me-2">
                                                <span class="badge bg-light-primary p-75 rounded">
                                                    <i data-feather="check" class="font-medium-2"></i>
                                                </span>
                                                <div class="ms-75">
                                                    <?php
                                                        $sql = $wpdb->prepare(
                                                            "SELECT SUM(CAST(meta_value AS DECIMAL(10, 2))) as total_donations
                                                            FROM {$wpdb->postmeta} pm
                                                            INNER JOIN {$wpdb->posts} p ON pm.post_id = p.ID
                                                            WHERE p.post_type = %s
                                                            AND p.post_status = %s
                                                            AND p.post_author = %d
                                                            AND pm.meta_key = %s",
                                                            'donations',
                                                            'publish',
                                                            $_GET['id'],
                                                            'amount'
                                                        );
                                                    
                                                

                                                    ?>
                                                    <h4 class="mb-0">$<?= $total_donations = $wpdb->get_var($sql); ?></h4>
                                                    <small>Total Donation</small>
                                                </div>
                                            </div>
                                            <div class="d-flex align-items-start">
                                                <span class="badge bg-light-primary p-75 rounded">
                                                    <i data-feather="briefcase" class="font-medium-2"></i>
                                                </span>
                                                <div class="ms-75">
                                                    <?php
                                                        $events = new WP_Query([
                                                            'post_type'   => 'events',
                                                            'post_status' => 'publish',
                                                            'author'      => $_GET['id']
                                                        ]);
                                                        
                                                        $found_events = $events->found_posts;
                                                    ?>                                                    
                                                    <h4 class="mb-0"><?= $found_events ?></h4>
                                                    <small>Events</small>
                                                </div>
                                            </div>
                                        </div>
                                        <h4 class="fw-bolder border-bottom pb-50 mb-1">Details</h4>
                                        <div class="info-container">
                                            <ul class="list-unstyled">
                                               
                                                <li class="mb-75">
                                                    <span class="fw-bolder me-25">Email:</span>
                                                    <span><?= $userMeta->user_email ?></span>
                                                </li>
                                             
                                                <li class="mb-75">
                                                    <span class="fw-bolder me-25">EIR Code:</span>
                                                    <span><?= get_user_meta($_GET['id'], 'eir_code', true); ?></span>
                                                </li>
                                                <li class="mb-75">
                                                    <span class="fw-bolder me-25">County:</span>
                                                    <span><?= get_user_meta($_GET['id'], 'county', true); ?></span>
                                                </li>
                                                <li class="mb-75">
                                                    <span class="fw-bolder me-25">Phone Number:</span>
                                                    <span><?= get_user_meta($_GET['id'], 'phone', true); ?></span>
                                                </li>
                                                <li class="mb-75">
                                                    <span class="fw-bolder me-25">Address:</span>
                                                    <span><?= get_user_meta($_GET['id'], 'address', true); ?></span>
                                                </li>
                                                <li class="mb-75">
                                                    <span class="fw-bolder me-25">Status:</span>
                                                    <span class="badge bg-light-success"><?= get_user_meta($_GET['id'], 'account_status', true); ?></span>
                                                </li>
                                            </ul>
                                            <!-- <div class="d-flex justify-content-center pt-2">
                                                <a href="javascript:;" class="btn btn-primary me-1" data-bs-target="#editUser" data-bs-toggle="modal">
                                                    Edit
                                                </a>
                                                <a href="javascript:;" class="btn btn-outline-danger suspend-user">Suspended</a>
                                            </div> -->
                                        </div>
                                    </div>
                                </div>
                                <!-- /User Card -->
                                <!-- Plan Card -->
                                <div class="card border-primary">
                                    <div class="card-body">
                                        <div class="d-flex justify-content-between align-items-start">
                                            <span class="badge bg-light-primary">Standard</span>
                                            <div class="d-flex justify-content-center">
                                                <sup class="h5 pricing-currency text-primary mt-1 mb-0">$</sup>
                                                <span class="fw-bolder display-5 mb-0 text-primary">99</span>
                                                <sub class="pricing-duration font-small-4 ms-25 mt-auto mb-2">/month</sub>
                                            </div>
                                        </div>
                                        <!-- <ul class="ps-1 mb-2">
                                            <li class="mb-50">10 Users</li>
                                            <li class="mb-50">Up to 10 GB storage</li>
                                            <li>Basic Support</li>
                                        </ul> -->
                                        <?php
                                            // Retrieve subscription meta values
                                            $subscription_date = get_user_meta($_GET['id'], 'subscription_date', true); // Replace $user_id with the actual user ID
                                            $expire_date = get_user_meta($_GET['id'], 'expire_date', true);

                                            if ($subscription_date && $expire_date) {
                                                // Convert dates to timestamps
                                                $subscription_start = strtotime($subscription_date);
                                                $subscription_end = strtotime($expire_date);
                                                $current_time = time();

                                                // Calculate total days, elapsed days, and remaining days
                                                $total_days = ceil(($subscription_end - $subscription_start) / (60 * 60 * 24));
                                                $elapsed_days = ceil(($current_time - $subscription_start) / (60 * 60 * 24));
                                                $remaining_days = max(0, $total_days - $elapsed_days);

                                                // Calculate progress percentage
                                                $progress_percentage = ($elapsed_days / $total_days) * 100;
                                            } else {
                                                // Default fallback if subscription dates are missing
                                                $total_days = $elapsed_days = $remaining_days = $progress_percentage = 0;
                                            }
                                        ?>

                                        <div class="d-flex justify-content-between align-items-center fw-bolder mb-50">
                                            <span>Days</span>
                                            <span><?= $elapsed_days ?> of <?= $total_days ?> Days</span>
                                        </div>
                                        <div class="progress mb-50" style="height: 8px">
                                            <div class="progress-bar" role="progressbar" style="width: <?= $progress_percentage ?>%" aria-valuenow="<?= $progress_percentage ?>" aria-valuemax="100" aria-valuemin="0"></div>
                                        </div>
                                        <span><?= $remaining_days ?> days remaining</span>
                                        <!-- <div class="d-grid w-100 mt-2">
                                            <button class="btn btn-primary" data-bs-target="#upgradePlanModal" data-bs-toggle="modal">
                                                Upgrade Plan
                                            </button>
                                        </div> -->
                                    </div>
                                </div>
                                <!-- /Plan Card -->
                            </div>
                            <!--/ User Sidebar -->

                            <!-- User Content -->
                            <div class="col-xl-8 col-lg-7 col-md-7 order-0 order-md-1">
                                <!-- User Pills -->
                                <!-- <ul class="nav nav-pills mb-2">
                                    <li class="nav-item">
                                        <a class="nav-link active" href="app-user-view-account.html">
                                            <i data-feather="user" class="font-medium-3 me-50"></i>
                                            <span class="fw-bold">Account</span></a>
                                    </li>
                                   
                                    <li class="nav-item">
                                        <a class="nav-link" href="app-user-view-billing.html">
                                            <i data-feather="bookmark" class="font-medium-3 me-50"></i>
                                            <span class="fw-bold">Billing & Plans</span>
                                        </a>
                                    </li>
                                  
                                </ul> -->
                                <!--/ User Pills -->

                                <!-- Project table -->
                                <div class="card">
                                    <?php
                                      $args = array(
                                        'post_type' => 'donations',
                                        'post_status' => 'publish',
                                        'post_per_page' => -1,
                                        'author' => $_GET['id'],
                                       
                                    );
                                    $donations = new WP_Query($args);

                                    ?>
                                    <h4 class="card-header">Donations</h4>
                                    <div class="table-responsive">
                                        <table class="table datatables-basic">
                                            <thead>
                                                <tr>
                                                    <!-- <th></th> -->
                                                    <th>Member</th>
                                                    <th>Amount</th>
                                                    <th>Paid Date</th>
                                                    <th>Status</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php foreach ($donations->posts ?? [] as $key => $value) { 
                                                        $amount = get_post_meta($value->ID, 'amount', true); 
                                                        $agent = get_post_meta($value->ID, 'agent', true); ?>
                                                        <tr>
                                                            <td><?= $agent  ?></td>
                                                            <td class="payout_amount fw-bold">$<?= number_format($amount, 2)   ?></td>
                                                            <td class="payout_date"><?= date('Y/m/d', strtotime($value->post_date))  ?></td>
                                                            <td><span class="badge bg-success">Completed</span></td>
                                                        </tr>
                                                <?php } ?>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                                <!-- /Project table -->

                                <div class="card">
                                    <?php
                                      $args = array(
                                        'post_type' => 'events',
                                        'post_status' => 'publish',
                                        'post_per_page' => -1,
                                        'author' => $_GET['id'],
                                       
                                    );
                                    $events = new WP_Query($args);

                                    ?>
                                    <h4 class="card-header">Events</h4>
                                    <div class="table-responsive">
                                        <table class="table datatables-basic">
                                            <thead>
                                                <tr>
                                                    <!-- <th></th> -->
                                                    <th>Event</th>
                                                    <th>Type</th>
                                                    <th>Start Date</th>
                                                    <th>End Date</th>
                                                    <th>Location </th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php foreach ($events->posts as $key => $value) {
                                                $postMeta = get_post_meta($value->ID); ?>
                                                        <tr>
                                                            <td><?= $postMeta['event_name'][0]  ?></td>
                                                            <td><?= $postMeta['type'][0]  ?></td>
                                                            <td><?= $postMeta['start_date'][0]  ?></td>
                                                            <td><?= $postMeta['end_date'][0]  ?></td>
                                                            <td><?= $postMeta['event_location'][0]  ?></td>
                                                        </tr>
                                                <?php } ?>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>

                                <!-- Activity Timeline -->
                                <!-- <div class="card"> -->
                                    <!-- <h4 class="card-header">User Activity Timeline</h4> -->
                                    <!-- <div class="card-body pt-1">
                                        <ul class="timeline ms-50">
                                            <li class="timeline-item">
                                                <span class="timeline-point timeline-point-indicator"></span>
                                                <div class="timeline-event">
                                                    <div class="d-flex justify-content-between flex-sm-row flex-column mb-sm-0 mb-1">
                                                        <h6>User login</h6>
                                                        <span class="timeline-event-time me-1">12 min ago</span>
                                                    </div>
                                                    <p>User login at 2:12pm</p>
                                                </div>
                                            </li>
                                            <li class="timeline-item">
                                                <span class="timeline-point timeline-point-warning timeline-point-indicator"></span>
                                                <div class="timeline-event">
                                                    <div class="d-flex justify-content-between flex-sm-row flex-column mb-sm-0 mb-1">
                                                        <h6>Meeting with john</h6>
                                                        <span class="timeline-event-time me-1">45 min ago</span>
                                                    </div>
                                                    <p>React Project meeting with john @10:15am</p>
                                                    <div class="d-flex flex-row align-items-center mb-50">
                                                        <div class="avatar me-50">
                                                            <img src="<?= $directory_url ?>/app-assets/images/portrait/small/avatar-s-7.jpg" alt="Avatar" width="38" height="38" />
                                                        </div>
                                                        <div class="user-info">
                                                            <h6 class="mb-0">Leona Watkins (Client)</h6>
                                                            <p class="mb-0">CEO of pixinvent</p>
                                                        </div>
                                                    </div>
                                                </div>
                                            </li>
                                            <li class="timeline-item">
                                                <span class="timeline-point timeline-point-info timeline-point-indicator"></span>
                                                <div class="timeline-event">
                                                    <div class="d-flex justify-content-between flex-sm-row flex-column mb-sm-0 mb-1">
                                                        <h6>Create a new react project for client</h6>
                                                        <span class="timeline-event-time me-1">2 day ago</span>
                                                    </div>
                                                    <p>Add files to new design folder</p>
                                                </div>
                                            </li>
                                            <li class="timeline-item">
                                                <span class="timeline-point timeline-point-danger timeline-point-indicator"></span>
                                                <div class="timeline-event">
                                                    <div class="d-flex justify-content-between flex-sm-row flex-column mb-sm-0 mb-1">
                                                        <h6>Create Invoices for client</h6>
                                                        <span class="timeline-event-time me-1">12 min ago</span>
                                                    </div>
                                                    <p class="mb-0">Create new Invoices and send to Leona Watkins</p>
                                                    <div class="d-flex flex-row align-items-center mt-50">
                                                        <img class="me-1" src="<?= $directory_url ?>/app-assets/images/icons/pdf.png" alt="data.json" height="25" />
                                                        <h6 class="mb-0">Invoices.pdf</h6>
                                                    </div>
                                                </div>
                                            </li>
                                        </ul>
                                    </div> -->
                                <!-- </div> -->
                                <!-- /Activity Timeline -->

                                <!-- Invoice table -->
                                <!-- <div class="card">
                                    <table class="invoice-table table text-nowrap datatables-basic">
                                        <thead>
                                            <tr>
                                                <th>#ID</th>
                                                <th><i data-feather="trending-up"></i></th>
                                                <th>TOTAL Paid</th>
                                                <th class="text-truncate">Issued Date</th>
                                                <th class="cell-fit">Actions</th>
                                            </tr>
                                        </thead>
                                    </table>
                                </div> -->
                                <!-- /Invoice table -->
                            </div>
                            <!--/ User Content -->
                        </div>
                    </section>
                    <!-- Edit User Modal -->
                    <!-- <div class="modal fade" id="editUser" tabindex="-1" aria-hidden="true">
                        <div class="modal-dialog modal-lg modal-dialog-centered modal-edit-user">
                            <div class="modal-content">
                                <div class="modal-header bg-transparent">
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-body pb-5 px-sm-5 pt-50">
                                    <div class="text-center mb-2">
                                        <h1 class="mb-1">Edit User Information</h1>
                                        <p>Updating user details will receive a privacy audit.</p>
                                    </div>
                                    <form id="editUserForm" class="row gy-1 pt-75" onsubmit="return false">
                                        <div class="col-12 col-md-6">
                                            <label class="form-label" for="modalEditUserFirstName">First Name</label>
                                            <input type="text" id="modalEditUserFirstName" name="modalEditUserFirstName" class="form-control" placeholder="John" value="Gertrude" data-msg="Please enter your first name" />
                                        </div>
                                        <div class="col-12 col-md-6">
                                            <label class="form-label" for="modalEditUserLastName">Last Name</label>
                                            <input type="text" id="modalEditUserLastName" name="modalEditUserLastName" class="form-control" placeholder="Doe" value="Barton" data-msg="Please enter your last name" />
                                        </div>
                                        <div class="col-12">
                                            <label class="form-label" for="modalEditUserName">Username</label>
                                            <input type="text" id="modalEditUserName" name="modalEditUserName" class="form-control" value="gertrude.dev" placeholder="john.doe.007" />
                                        </div>
                                        <div class="col-12 col-md-6">
                                            <label class="form-label" for="modalEditUserEmail">Billing Email:</label>
                                            <input type="text" id="modalEditUserEmail" name="modalEditUserEmail" class="form-control" value="gertrude@gmail.com" placeholder="example@domain.com" />
                                        </div>
                                        <div class="col-12 col-md-6">
                                            <label class="form-label" for="modalEditUserStatus">Status</label>
                                            <select id="modalEditUserStatus" name="modalEditUserStatus" class="form-select" aria-label="Default select example">
                                                <option selected>Status</option>
                                                <option value="1">Active</option>
                                                <option value="2">Inactive</option>
                                                <option value="3">Suspended</option>
                                            </select>
                                        </div>
                                        <div class="col-12 col-md-6">
                                            <label class="form-label" for="modalEditTaxID">Tax ID</label>
                                            <input type="text" id="modalEditTaxID" name="modalEditTaxID" class="form-control modal-edit-tax-id" placeholder="Tax-8894" value="Tax-8894" />
                                        </div>
                                        <div class="col-12 col-md-6">
                                            <label class="form-label" for="modalEditUserPhone">Contact</label>
                                            <input type="text" id="modalEditUserPhone" name="modalEditUserPhone" class="form-control phone-number-mask" placeholder="+1 (609) 933-44-22" value="+1 (609) 933-44-22" />
                                        </div>
                                        <div class="col-12 col-md-6">
                                            <label class="form-label" for="modalEditUserLanguage">Language</label>
                                            <select id="modalEditUserLanguage" name="modalEditUserLanguage" class="select2 form-select" multiple>
                                                <option value="english">English</option>
                                                <option value="spanish">Spanish</option>
                                                <option value="french">French</option>
                                                <option value="german">German</option>
                                                <option value="dutch">Dutch</option>
                                                <option value="hebrew">Hebrew</option>
                                                <option value="sanskrit">Sanskrit</option>
                                                <option value="hindi">Hindi</option>
                                            </select>
                                        </div>
                                        <div class="col-12 col-md-6">
                                            <label class="form-label" for="modalEditUserCountry">Country</label>
                                            <select id="modalEditUserCountry" name="modalEditUserCountry" class="select2 form-select">
                                                <option value="">Select Value</option>
                                                <option value="Australia">Australia</option>
                                                <option value="Bangladesh">Bangladesh</option>
                                                <option value="Belarus">Belarus</option>
                                                <option value="Brazil">Brazil</option>
                                                <option value="Canada">Canada</option>
                                                <option value="China">China</option>
                                                <option value="France">France</option>
                                                <option value="Germany">Germany</option>
                                                <option value="India">India</option>
                                                <option value="Indonesia">Indonesia</option>
                                                <option value="Israel">Israel</option>
                                                <option value="Italy">Italy</option>
                                                <option value="Japan">Japan</option>
                                                <option value="Korea">Korea, Republic of</option>
                                                <option value="Mexico">Mexico</option>
                                                <option value="Philippines">Philippines</option>
                                                <option value="Russia">Russian Federation</option>
                                                <option value="South Africa">South Africa</option>
                                                <option value="Thailand">Thailand</option>
                                                <option value="Turkey">Turkey</option>
                                                <option value="Ukraine">Ukraine</option>
                                                <option value="United Arab Emirates">United Arab Emirates</option>
                                                <option value="United Kingdom">United Kingdom</option>
                                                <option value="United States">United States</option>
                                            </select>
                                        </div>
                                        <div class="col-12">
                                            <div class="d-flex align-items-center mt-1">
                                                <div class="form-check form-switch form-check-primary">
                                                    <input type="checkbox" class="form-check-input" id="customSwitch10" checked />
                                                    <label class="form-check-label" for="customSwitch10">
                                                        <span class="switch-icon-left"><i data-feather="check"></i></span>
                                                        <span class="switch-icon-right"><i data-feather="x"></i></span>
                                                    </label>
                                                </div>
                                                <label class="form-check-label fw-bolder" for="customSwitch10">Use as a billing address?</label>
                                            </div>
                                        </div>
                                        <div class="col-12 text-center mt-2 pt-50">
                                            <button type="submit" class="btn btn-primary me-1">Submit</button>
                                            <button type="reset" class="btn btn-outline-secondary" data-bs-dismiss="modal" aria-label="Close">
                                                Discard
                                            </button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div> -->
                    <!--/ Edit User Modal -->
                    <!-- upgrade your plan Modal -->
                    <!-- <div class="modal fade" id="upgradePlanModal" tabindex="-1" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered modal-upgrade-plan">
                            <div class="modal-content">
                                <div class="modal-header bg-transparent">
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-body px-5 pb-2">
                                    <div class="text-center mb-2">
                                        <h1 class="mb-1">Upgrade Plan</h1>
                                        <p>Choose the best plan for user.</p>
                                    </div>
                                    <form id="upgradePlanForm" class="row pt-50" onsubmit="return false">
                                        <div class="col-sm-8">
                                            <label class="form-label" for="choosePlan">Choose Plan</label>
                                            <select id="choosePlan" name="choosePlan" class="form-select" aria-label="Choose Plan">
                                                <option selected>Choose Plan</option>
                                                <option value="standard">Standard - $99/month</option>
                                                <option value="exclusive">Exclusive - $249/month</option>
                                                <option value="Enterprise">Enterprise - $499/month</option>
                                            </select>
                                        </div>
                                        <div class="col-sm-4 text-sm-end">
                                            <button type="submit" class="btn btn-primary mt-2">Upgrade</button>
                                        </div>
                                    </form>
                                </div>
                                <hr />
                                <div class="modal-body px-5 pb-3">
                                    <h6>User current plan is standard plan</h6>
                                    <div class="d-flex justify-content-between align-items-center flex-wrap">
                                        <div class="d-flex justify-content-center me-1 mb-1">
                                            <sup class="h5 pricing-currency pt-1 text-primary">$</sup>
                                            <h1 class="fw-bolder display-4 mb-0 text-primary me-25">99</h1>
                                            <sub class="pricing-duration font-small-4 mt-auto mb-2">/month</sub>
                                        </div>
                                        <button class="btn btn-outline-danger cancel-subscription mb-1">Cancel Subscription</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div> -->
                    <!--/ upgrade your plan Modal -->

                </div>
            </div>
        </div>
        <!-- END: Content-->
        
        <div class="sidenav-overlay"></div>
        <div class="drag-target"></div>

        <?php include "includes/scripts.php"; ?>
        <!-- BEGIN: Page Vendor JS-->
        <script src="<?= $directory_url ?>/app-assets/vendors/js/forms/select/select2.full.min.js"></script>
        <script src="<?= $directory_url ?>/app-assets/vendors/js/forms/cleave/cleave.min.js"></script>
        <script src="<?= $directory_url ?>/app-assets/vendors/js/forms/cleave/addons/cleave-phone.us.js"></script>
        <script src="<?= $directory_url ?>/app-assets/vendors/js/forms/validation/jquery.validate.min.js"></script>
        <script src="<?= $directory_url ?>/app-assets/vendors/js/extensions/moment.min.js"></script>
        <script src="<?= $directory_url ?>/app-assets/vendors/js/tables/datatable/jquery.dataTables.min.js"></script>
        <script src="<?= $directory_url ?>/app-assets/vendors/js/tables/datatable/dataTables.bootstrap5.min.js"></script>
        <script src="<?= $directory_url ?>/app-assets/vendors/js/tables/datatable/dataTables.responsive.min.js"></script>
        <script src="<?= $directory_url ?>/app-assets/vendors/js/tables/datatable/responsive.bootstrap5.js"></script>
        <script src="<?= $directory_url ?>/app-assets/vendors/js/tables/datatable/datatables.buttons.min.js"></script>
        <script src="<?= $directory_url ?>/app-assets/vendors/js/tables/datatable/jszip.min.js"></script>
        <script src="<?= $directory_url ?>/app-assets/vendors/js/tables/datatable/pdfmake.min.js"></script>
        <script src="<?= $directory_url ?>/app-assets/vendors/js/tables/datatable/vfs_fonts.js"></script>
        <script src="<?= $directory_url ?>/app-assets/vendors/js/tables/datatable/buttons.html5.min.js"></script>
        <script src="<?= $directory_url ?>/app-assets/vendors/js/tables/datatable/buttons.print.min.js"></script>
        <script src="<?= $directory_url ?>/app-assets/vendors/js/tables/datatable/dataTables.rowGroup.min.js"></script>
        <script src="<?= $directory_url ?>/app-assets/vendors/js/extensions/sweetalert2.all.min.js"></script>
        <script src="<?= $directory_url ?>/app-assets/vendors/js/extensions/polyfill.min.js"></script>
        <!-- END: Page Vendor JS-->
        <!-- BEGIN: Page JS-->
        <script src="<?= $directory_url ?>/app-assets/js/scripts/pages/modal-edit-user.js"></script>
        <script src="<?= $directory_url ?>/app-assets/js/scripts/pages/app-user-view-account.js"></script>
        <script src="<?= $directory_url ?>/app-assets/js/scripts/pages/app-user-view.js"></script>
        <!-- END: Page JS-->

        <script>
           
           var table = $('.datatables-basic').DataTable({
           order: [[0, 'desc']],
            dom:
                '<"d-flex justify-content-between align-items-center header-actions mx-2 row mt-75"' +
                '<"col-sm-12 col-lg-4 d-flex justify-content-center justify-content-lg-start" l>' +
                '<"col-sm-12 col-lg-8 ps-xl-75 ps-0"<"dt-action-buttons d-flex align-items-center justify-content-center justify-content-lg-end flex-lg-nowrap flex-wrap"<"me-1"f>B>>' +
                '>t' +
                '<"d-flex justify-content-between mx-2 row mb-1"' +
                '<"col-sm-12 col-md-6"i>' +
                '<"col-sm-12 col-md-6"p>' +
                '>',
                buttons: [
                // 'copyHtml5',
                'excelHtml5',
                'csvHtml5',
                'pdfHtml5',
             
               
            ],
        });
        // table.on('draw', function () {
        //     feather.replace({
        //         width: 14,
        //         height: 14
        //     });
        // });
            $(window).on('load', function() {
                if (feather) {
                    feather.replace({
                        width: 14,
                        height: 14
                    });
                }
            })
        </script>

    </body>
    <!-- END: Body-->

</html>