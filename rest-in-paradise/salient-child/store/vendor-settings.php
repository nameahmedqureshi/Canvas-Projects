<?php /* Template Name: Vendor Settings */ ?>
<?php include "includes/styles.php"; ?>

<style>
    .col-12.btns {
        margin-top: 70px;
    }

    .form-control:disabled {
        background-color: #efefef;
    }
</style>

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

            <div class="content-body">

                <!-- Basic Vertical form layout section start -->

                <section id="basic-vertical-layouts">
                    <div class="row">
                        <div class="col-12">
                            <div class="card">
                                <div class="card-body">
                                    <?php $subscription_data = get_option('subscription_data', true); ?>
                                    <form class="form form-vertical" id="subscription">
                                        <div class="row">

                                            <div class="col-md-12  col-3">
                                                <label class="form-label" for="subscription_price">Subscription Price *</label>
                                                <div class="input-group mb-1">
                                                    <span class="input-group-text">$</span>
                                                    <input type="number" class="form-control" name="subscription_price" value="<?= $subscription_data['monthly_price']  ?>" placeholder="100" aria-label="Subscription Price">
                                                    <span class="input-group-text">.00</span>
                                                </div>
                                            </div>

                                            <div class="col-md-12  col-3">
                                                <label class="form-label" for="subscription_price">Commission on subscribed vendors *</label>
                                                <div class="input-group mb-1">
                                                    <span class="input-group-text">%</span>
                                                    <input type="number" class="form-control" name="subscribed_commission" value="<?= $subscription_data['subscribed_commission']  ?>" placeholder="15">
                                                </div>
                                            </div>

                                            <div class="col-md-12  col-3">
                                                <label class="form-label" for="subscription_price">Commission on unsubscribed vendors *</label>
                                                <div class="input-group mb-1">
                                                    <span class="input-group-text">%</span>
                                                    <input type="number" class="form-control" name="unsubscribed_commission" value="<?= $subscription_data['unsubscribed_commission']  ?>" placeholder="5">
                                                </div>
                                            </div>

                                            <div class="col-md-12  col-3">
                                                <div class="mb-1">
                                                    <label class="form-label" for="subscription_tooltip">Subscription Tooltip Text *</label>
                                                    <input type="text" id="subscription_tooltip" class="form-control"  name="subscription_tooltip"  value="<?= $subscription_data['tooltip'] ?>" placeholder="Subscription Tooltip Text" />
                                                </div>
                                            </div>

                                            <div class="col-12">
                                                <input type="hidden" value="vendor_settings" name="action">
                                                <button type="submit" class="btn btn-primary me-1">Save</button>
                                            </div>
                                        </div>

                                    </form>
                                </div>
                            </div>
                        </div>

                    </div>
                </section>

                <!-- Basic Vertical form layout section end -->

            </div>
        </div>
    </div>
    <!-- END: Content-->

    <div class="sidenav-overlay"></div>
    <div class="drag-target"></div>

    <?php include "includes/scripts.php"; ?>
    
    <script>
        $(document).ready(function() {

            $("#subscription").submit(function(e) {
                e.preventDefault(); // avoid to execute the actual submit of the form.
                var form = new FormData(this);
                // console.log('form', form);
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
                $.ajax({
                    type: 'post',
                    url: "<?= admin_url('admin-ajax.php')  ?>",
                    data: form,
                    dataType: 'json',
                    cache: false,
                    contentType: false,
                    processData: false,
                    success: function(response) {
                        $('.fa.fa-spinner.fa-spin').remove();
                        $('body').waitMe('hide');
                        $(thiss).find('button[type=submit]').prop('disabled', false);
                        //  console.log(response);
                        if(!response.status){
                        toastr.error(response.message, response.title);
                        }
                        else{
                            toastr.success(response.message, response.title);
                        } 
                    },
                    error: function(errorThrown) {
                        console.log(errorThrown);
                        $('body').waitMe('hide');
                    }
                });
            });
        });
    </script>

</body>
<!-- END: Body-->

</html>