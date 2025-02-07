<?php /* Template Name: Ducking Records */ ?>
<?php get_header('header'); ?>
<?php 
$current_user = wp_get_current_user(); 
  // Query to get custom post type data
$args = array(
    'post_type'      => 'ducks',
    'posts_per_page' => -1,
    'meta_query'     => array(
        array(
            'key'     => 'user_id', // Replace 'your_meta_key' with the actual meta key
            'value'   => $current_user->ID, // Replace 'your_meta_value' with the actual meta value
            'compare' => '=', // You can change the comparison operator if needed
        ),
    ),
);

$query = new WP_Query($args);
function encryptData($data) {
	$ciphering = "AES-128-CTR";
	$iv_length = openssl_cipher_iv_length($ciphering);
	$options = 0;
	$encryption_iv = '1234567891011121';
	$encryption_key = "W3docs";
	return  openssl_encrypt($data, $ciphering, $encryption_key, $options, $encryption_iv);
  }

  function decrypt_custom($data) {
	$ciphering = "AES-128-CTR";
	$decryption_iv = '1234567891011121';
	$options = 0;
	$decryption_key = "W3docs";
	return openssl_decrypt($data, $ciphering, $decryption_key, $options, $decryption_iv);
  }
?>
<section class="sec_main">
	<div class="sec_row">
		<?php get_template_part('templates/includes/menu', 'template'); ?>
		<div class="content_main">
			<div class="inner_header">
					<h1 class="heading_top">Ducking Records</h1>
				<div class="top_actions_btns_wrap">
					
					<div class="user_top_info" id="user_info">
						<p class="title"><?= isset($current_user->first_name) && $current_user->first_name ? $current_user->first_name : 'Jones Ferdinand' ?></p>

						<div class="user_img_box"><img src="<?= get_stylesheet_directory_uri() . '/templates/assets/front/images/user-img.png' ?>" alt="img" class="img-fluid w-100 h-100"></div>
					</div>
					<div class="nav_dropdown">
						<ul class="list-unstyled">
							<li>
								<a href="<?= site_url('dashboard') ?>"><span><img src="<?= get_stylesheet_directory_uri() . '/templates/assets/front/images/dd-icon-1.png' ?>" alt="img"></span>My Profile</a>
							</li>
							<li>
								<a href="#!"><span><img src="<?= get_stylesheet_directory_uri() . '/templates/assets/front/images/dd-icon-2.png' ?>" alt="img"></span>Terms & Conditions</a>
							</li>
							<li>
								<a href="#!"><span><img src="<?= get_stylesheet_directory_uri() . '/templates/assets/front/images/dd-icon-3.png' ?>" alt="img"></span>Privacy Policy</a>
							</li>
							<li>
								<a href="<?= site_url('logout') ?>"><span><img src="<?= get_stylesheet_directory_uri() . '/templates/assets/front/images/dd-icon-4.png' ?>" alt="img"></span>Logout</a>
							</li>
						</ul>
					</div>
				</div>
			</div>

			<div class="inner_content_body">
				<div class="gen_new_box">
					<div class="row">
						<div class="col-lg-12 col-md-12 col-sm-12 col-12">
							<!-- <h1 class="gen_heading pb-5">Ducking Records</h1> -->
							<a href="<?= site_url('add-duck')  ?>" class="submit_btn edit_btn duck">Add Duck</a>
                            <table id="my-plugin-table" class="hover cell-border dataTable" style="width:100%">
                                <thead>
                                    <tr>
                                        <th>S.No#</th>
										<th>Duck Name</th>
                                        <th>Assign Jeep</th>
                                        <th>Status</th>
										<th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php  while ($query->have_posts()) : $query->the_post(); ?>
                                        <tr>
                                            <td><?=  encryptData(get_the_ID()) ?></td>  
											<td><?= get_the_title() ?></td>  
                                            <td>
												<?php $jeep = get_post_meta(get_the_ID(), 'active_duck', true) ; 
												  echo $jeep ? get_the_title($jeep) : 'Unassigned';
												?>
											</td> 
											<td>
												<?= get_post_meta(get_the_ID(), 'status', true); ?> 
											</td>      
                                            <td><a href="<?= site_url('add-duck?id='.get_the_ID())  ?>">View QR Code</a></td>  
                                        </tr>
                                    <?php endwhile; ?>
                                </tbody>
                            </table>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</section>
<!-- Initialize the DataTable -->
<script>
    jQuery(document).ready(function() {
        jQuery("#my-plugin-table").DataTable();
    });
</script>
<?php get_footer('footer'); ?>