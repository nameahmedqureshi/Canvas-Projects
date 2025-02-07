<?php /* Template Name: Show Quote Requests */ 
// function encryptData($data) {
//     $ciphering = "AES-128-CTR";
//     $iv_length = openssl_cipher_iv_length($ciphering);
//     $options = 0;
//     $encryption_iv = '1234567891011121';
//     $encryption_key = "W3docs";
//     return  openssl_encrypt($data, $ciphering, $encryption_key, $options, $encryption_iv);
// }
 include "includes/styles.php"; ?>
    <link rel="stylesheet" type="text/css" href="<?= $directory_url ?>/app-assets/vendors/css/vendors.min.css">
    <link rel="stylesheet" type="text/css" href="<?= $directory_url ?>/app-assets/vendors/css/tables/datatable/dataTables.bootstrap5.min.css">
    <link rel="stylesheet" type="text/css" href="<?= $directory_url ?>/app-assets/vendors/css/tables/datatable/responsive.bootstrap5.min.css">
    <link rel="stylesheet" type="text/css" href="<?= $directory_url ?>/app-assets/vendors/css/tables/datatable/buttons.bootstrap5.min.css">
    <style>
        div#card-element {
            padding: 15px;
            background: aliceblue;
        }
        td a {
            text-decoration: underline;
        }
        .modal-dialog{
            max-width: 1200px;
        }
        .agreement.col-md-12 {
            height: 300px;
            overflow: auto;
        }
        .paymentDiv {
            margin-top: 40px;
        }

        .quote_description {
        width: 40%;
        font-size: 14px;
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
        button.dt-button.add-new.btn.btn-primary {
            padding: 10px;
        }
    </style>
<!-- END: Head-->
<?php include "includes/header.php"; ?>
<body class="vertical-layout vertical-menu-modern  navbar-floating footer-static  " data-open="click" data-menu="vertical-menu-modern" data-col="">
    <!-- BEGIN: Header-->
    <!-- END: Header-->
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
                <!-- users list start -->
                <section class="app-user-list">
                    <!-- list and filter start -->
                    <div class="card">
                        <div class="card-body border-bottom">
                            <h4 class="card-title">Quotes</h4>
                        </div>
                        <!-- customer -->
                        <?php
                           $services = get_post($_GET['id']);
                        ?>
                        <div class="card-datatable table-responsive pt-0">
                            <table class="datatables-basic table">
                                <thead>
                                    <tr>
                                        <th>Vendor</th>
                                        <th>Quotation</th>
                                        <th>Amount</th>
                                        <th>Applied Date</th>
                                        <?php if( in_array('customer', wp_get_current_user()->roles) ) { ?>
                                        <th>Actions</th>
                                        <?php } ?>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php 
                                       $quote = get_post_meta($_GET['id'], 'quote');
                                    //    var_dump($quote);
                                       foreach ($quote as $key => $value) {  
                                        $first_name = get_user_meta( $value['vendor_id'], 'first_name', true );
                                    ?>
                                        <tr>
                                            <td><a href="<?= home_url('store-profile?id='.$value['vendor_id']) ?>" target="_blank"><?= $first_name ?></a></td>
                                            <td class="quote_description"><?= $value['quote_description'] ?></td>
                                            <td class="total">$<?= number_format( $value['quote_price'], 2); ?></td>
                                            <td><?= date('d F Y', strtotime($value['apply_date'])) ?></td>
                                            <?php if( in_array('customer', wp_get_current_user()->roles) ) { ?>
                                            <td><button type="button" data-price="<?= encryptData($value['quote_price']) ?>" data-id="<?= $value['vendor_id'] ?>" class="accept btn btn-success waves-effect waves-float waves-light" data-bs-toggle="modal" data-bs-target="#addNewCard">Accept</button></td>
                                            <?php } ?>
                                        </tr>
                                   <?php } ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <!-- list and filter end -->
                </section>
                <!-- users list ends -->
            </div>
        </div>
    </div>
    <!-- END: Content-->
    <!-- add new card modal  -->
    <div class="modal fade" id="addNewCard" tabindex="-1" aria-labelledby="addNewCardTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header bg-transparent">
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body px-sm-5 mx-50 pb-5">
                    <form id="submit_accept_request">
                        <div class="summary"></div>
                        <div class="agreement col-md-12">
                            <h4>Service Agreement</h4>
                            <h5>Universal Service Agreement</h5>
                            <p>
                                This Universal Service Agreement is entered into between the <strong>Designer</strong> (the individual or entity providing the service) and the <strong>Customer</strong> (the individual or entity purchasing the service) through the Kainamo platform. By checking the box below, both parties agree to the terms outlined herein:
                            </p>
                            <hr>
                            <h6>1. Scope of Work</h6>
                            <p>
                                The Designer agrees to deliver the project as described in the agreed-upon specifications, including design, materials, timeline, and any other mutually agreed details.
                            </p>
                            <hr>
                            <h6>2. Escrow and Payment</h6>
                            <ul>
                                <li>The Customer agrees to pay the total project cost upfront. This payment will be held in escrow by Kainamo and released to the Designer upon completion and approval of the Project by the Customer.</li>
                                <li>If disputes arise, Kainamo will act as an intermediary to resolve the issue based on the terms of this Agreement and supporting evidence provided by both parties.</li>
                            </ul>
                            <hr>
                            <h6>3. Designer's Responsibilities</h6>
                            <ul>
                                <li>Perform the work professionally and in alignment with the agreed-upon specifications.</li>
                                <li>Communicate promptly with the Customer regarding any delays or changes necessary for the Project.</li>
                                <li>Use the specified materials and methods as agreed with the Customer.</li>
                            </ul>
                            <hr>
                            <h6>4. Customer’s Responsibilities</h6>
                            <ul>
                                <li>Provide accurate and complete information required to fulfill the Project.</li>
                                <li>Respond to design approvals or revisions in a timely manner.</li>
                                <li>Approve or provide feedback on the completed Project within 3 days of submission.</li>
                            </ul>
                            <hr>
                            <h6>5. Revisions</h6>
                            <p>
                                The Project includes a reasonable amount of revisions. Additional revisions may be subject to extra charges as determined by the Designer and approved by the Customer.
                            </p>
                            <hr>
                            <h6>6. Limitations of Liability</h6>
                            <ul>
                                <li>The Designer is not liable for delays caused by the Customer’s actions or unforeseen circumstances beyond the Designer’s control.</li>
                                <li>Minor deviations in the final product that do not significantly affect functionality or quality are not grounds for non-payment or dispute.</li>
                            </ul>
                            <hr>
                            <h6>7. Intellectual Property</h6>
                            <ul>
                                <li>Ownership of the final product or design transfers to the Customer only after full payment is released from escrow.</li>
                                <li>The Designer retains rights to any underlying intellectual property unless otherwise agreed.</li>
                            </ul>
                            <hr>
                            <h6>8. Dispute Resolution</h6>
                            <p>
                                Any disputes arising under this Agreement will be resolved through mediation facilitated by Kainamo. The decision of Kainamo is binding.
                            </p>
                            <hr>
                            <h6>9. Global Applicability</h6>
                            <p>
                                This Agreement is intended for global use and operates under the principles of fair trade and mutual respect. In the event of a legal dispute, both parties agree to submit to the jurisdiction of Kainamo's chosen governing body, which will be specified in the platform's Terms of Service.
                            </p>
                            <hr>
                            <h6>10. Entire Agreement</h6>
                            <p>
                                This Agreement constitutes the entire understanding between the Designer and the Customer for the Project. No additional agreements or changes will be binding unless facilitated through Kainamo.
                            </p>
                            <hr>
                            <h6>Acknowledgment</h6>
                            <p>
                                By checking the box below, the Designer and Customer confirm they have read, understood, and agree to the terms of this Agreement.
                            </p>
                            <div class="form-check form-check-success">
                                <input type="checkbox" class="form-check-input" id="colorCheck3">
                                <b><label class="form-check-label" for="colorCheck3">I agree terms & conditions</label></b>
                            </div>
                        </div>

                        <div class="mb-1 col-md-12 paymentDiv" style="display:none">
                            <div id="card-element"></div> 
                        </div>
                        <div class="col-12 text-center footerbtns" style="display:none">
                            <input type="hidden" class="post_id" name="post_id" value="<?= $_GET['id'] ?>">
                            <input type="hidden" name="type" value="<?= $_GET['type'] ?>">
                            <input type="hidden" class="vendor_id" name="vendor_id" value="">
                            <input type="hidden" class="price" name="price" value="">
                            <input type="hidden" name="action" value="accept_print_on_demand_request_by_customer">
                            <button type="submit" class="btn btn-primary me-1 mt-1">Accept</button>
                            <button type="reset" class="btn btn-outline-secondary mt-1 reset_btn" data-bs-dismiss="modal" aria-label="Close"> Cancel </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <!--/ add new card modal  -->
    <div class="sidenav-overlay"></div>
    <div class="drag-target"></div>
    <?php include "includes/scripts.php"; ?>
    <script src="<?= $directory_url ?>/app-assets/vendors/js/tables/datatable/jquery.dataTables.min.js"></script>
    <script src="<?= $directory_url ?>/app-assets/vendors/js/tables/datatable/dataTables.bootstrap5.min.js"></script>
    <script src="<?= $directory_url ?>/app-assets/vendors/js/tables/datatable/dataTables.responsive.min.js"></script>
    <script src="<?= $directory_url ?>/app-assets/vendors/js/tables/datatable/responsive.bootstrap5.min.js"></script>
    <script src="<?= $directory_url ?>/app-assets/vendors/js/tables/datatable/datatables.buttons.min.js"></script>
    <script src="<?= $directory_url ?>/app-assets/vendors/js/tables/datatable/jszip.min.js"></script>
    <script src="<?= $directory_url ?>/app-assets/vendors/js/tables/datatable/pdfmake.min.js"></script>
    <script src="<?= $directory_url ?>/app-assets/vendors/js/tables/datatable/vfs_fonts.js"></script>
    <script src="<?= $directory_url ?>/app-assets/vendors/js/tables/datatable/buttons.html5.min.js"></script>
    <script src="https://js.stripe.com/v3/"></script>
    <script>
        $(document).ready(function(){
            var stripe = "";
            var cardElement = "";
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
                // language: {
                //     sLengthMenu: 'Show _MENU_',
                //     search: 'Search',
                //     searchPlaceholder: 'Search..'
                // },
                // Buttons with Dropdown
                buttons: [
                    'copyHtml5',
                    'excelHtml5',
                    'csvHtml5',
                    'pdfHtml5',
                ],
            });
            table.on('draw', function () {
                feather.replace({
                    width: 14,
                    height: 14
                });
            });

            $(document).on("change", "#colorCheck3", function(e) {
                if($(this).is(':checked')){
                    // stripe 
                    var pub_key = "pk_test_51PNfoGAOqJbE4AIGUB2S5oYWIWMRjB0N4otuUHZKgYZk7TwZ3MDhFN1lJQqq3JoFfyHzvMWoA2bRH3SecQ1L8VdF00XTYhOqiJ";
                    stripe = Stripe(pub_key);
                    var elements = stripe.elements();
                    cardElement = elements.create('card', {
                        hidePostalCode: true,
                    });
                    cardElement.mount('#card-element');
                    $('.paymentDiv').show();
                    $('.footerbtns').show();

                } else {
                    $('.paymentDiv').hide();
                    $('.footerbtns').hide();
                }
            });

            $(document).on("click", ".accept", function(e) {
                var vendor_id = $(this).data('id');
                $('.vendor_id').val(vendor_id);
                var post_id = $(this).attr('post-id');
                var price = $(this).data('price');
                $('.price').val(price);
                $vendor_name = $(this).parents('tr').find('a').text();
                $quote_desc = $(this).parents('tr').find('.quote_description').text();
                $total = $(this).parents('tr').find('.total').text();
                numericValue = parseFloat($total.replace(/[$,]/g, ''));
                $first_payment = numericValue / 2;
                $('.summary').html("<h4 class='text-center'>" + $vendor_name + "</h4><p class='text-center'>" + $quote_desc + "</p><p class='text-center'>Total Amount: " + $total + "</p><p class='text-center'>You can pay 50% at this time, After 50% the payable amount will be $" + $first_payment.toFixed(2) + "</p>");
              
            });
            $("#submit_accept_request").submit(function(e) {
                e.preventDefault(); // avoid to execute the actual submit of the form.
                var form = new FormData(this);
                // console.log('stripe', stripe);
                $(this).find('button[type=submit]').append('<i class="fa fa-spinner fa-spin" style="font-size:24px"></i>');
                $(this).find('button[type=submit]').prop('disabled', true);
                 var thiss = $(this);
                $('body').waitMe({
                    effect: 'bounce',
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
                        toastr.error( result.error.message, "Error");
                        console.log(result.error);
                        jQuery('.fa.fa-spinner.fa-spin').remove();
                        jQuery('body').waitMe('hide');
                        jQuery(thiss).find('button[type=submit]').prop('disabled',false); 
                        return;
                    } else {
                        // Attach the token or source to the form data
                        form.append('stripeToken', result.token.id);
                        $.ajax({
                            type: 'post',
                            url: '<?= admin_url( 'admin-ajax.php' ); ?>',
                            data: form, // Use FormData directly
                            dataType : 'json',
                            cache:false,
                            contentType: false,
                            processData: false,
                            success: function (response) {
                               jQuery('.fa.fa-spinner.fa-spin').remove();
                                jQuery('body').waitMe('hide');
                                jQuery(thiss).find('button[type=submit]').prop('disabled',false);
                                if(!response.status){
                                    toastr.error(response.message, response.title);
                                    $('.reset_btn').click();
                                }
                                else{
                                    // toastr.success(response.message, response.title);
                                    if (response.auto_redirect) {window.location.href = response.redirect_url;}
                                } 
                            },
                            error : function(errorThrown){ 
                                console.log(errorThrown);
                                jQuery('body').waitMe('hide');
                            }
                        });
                    }
                }); 
            });
        });
    </script>
</body>
<!-- END: Body-->