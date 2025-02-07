<?php /*Template Name: Link Logs*/ ?>
<?php get_header(); if(is_user_logged_in()) { 
$user_id = get_current_user_id();

  // Query to get custom post type data
  $args = array(
    'post_type' => 'shareable-links',
    'posts_per_page' => -1,
	'author'   => $user_id,
);

$query = new WP_Query($args);
?>
			<div class="inner_content_body">
				<div class="gen_new_box">
					<div class="row">
						<div class="col-lg-12 col-md-12 col-sm-12 col-12">
							<h1 class="gen_heading pb-5">Generated Links Record</h1>
                            <table id="my-table" class="hover cell-border" style="width:100%">
                                <thead>
                                    <tr>
                                        <th>S.No#</th>
                                        <th>Title</th>
                                        <th>Description</th>
										<th>Date</th>
										<th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php $count = 1; while ($query->have_posts()) : $query->the_post(); ?>
                                        <tr>
                                            <td><?= $count ?></td>  
											<td><?= get_the_title(get_the_ID()) ?></td> 
											<td><?= get_post_field('post_content', get_the_ID()) ? get_post_field('post_content', get_the_ID()) : '----'; ?></td>
                                            <td><?= get_the_date( 'j F Y' );  ?></td>
											<td><a href="<?= get_post_meta(get_the_ID(), 'downloadable_link', true); ?>"target="_blank" >View</a></td>     

                                        </tr>
                                    <?php $count++; endwhile; ?>
                                </tbody>
                            </table>
						</div>
					</div>
				</div>
			</div>
<?php } else { ?> 
	<div>
		<p>
			Logged in first!
		</p>
	</div> 
<?php } get_footer(); ?>
<!-- Initialize the DataTable -->
<script>
    jQuery(document).ready(function() {
        jQuery("#my-table").DataTable();
    });
</script>