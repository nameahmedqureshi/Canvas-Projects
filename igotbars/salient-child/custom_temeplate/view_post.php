<?php /* Template Name: view post */   ?>
<?php get_header(); 
include('dashboard_menu.php');  ?>
<?php
$arg = array(
    'post_type'=> 'post',
    'posts_per_page'=> -1,
    'post_status'    => 'any',
);
$post_query = new WP_Query($arg);

?>
<div class="container">
    <div class="custom_row" id="view_post">
        <div class="col_12">
            <table id="example" class="display" style="width:100%">
                <thead>
                    <tr>
                        <th>Name</th>
                        <th>Author</th>
                        <th>Categories</th>
                        <th>Tags</th>
                        <th>Date</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($post_query->posts ?? [] as $key => $value) { $tags = get_the_tags($value->ID);  $categories = get_the_category($value->ID); ?>
                        <tr class="post-view">
                            <td ><a href="<?= get_permalink($value->ID) ?>" ><?= get_the_title($value->ID) ?></a></td>
                            <td><?= the_author_meta( 'display_name', $value->post_author ); ?></td>
                            <td>
                                <?php if($categories) { $categories_names = array(); foreach ($categories as $cat) { 
                                    $categories_names[] = $cat->name;
                                  } echo implode(', ', $categories_names);
                                }  else { echo '---'; } 
                                ?>
                            </td>
                            <td>
                                <?php if($tags) { $tag_names = array(); foreach ($tags as $tag) { 
                                    $tag_names[] = $tag->name;
                                  } echo implode(', ', $tag_names);
                                }  else { echo '---'; } 
                                ?>
                            </td>
                            <td><?= date('d F Y', strtotime($value->post_date)); ?></td>
                            <td><a href="<?= get_permalink($value->ID)  ?>"><i class="fa fa-eye" aria-hidden="true"></i></a>&nbsp&nbsp 
                                <a href="<?= home_url('add-post?id='.$value->ID)  ?>"><i class="fa fa-edit"></i></a>&nbsp&nbsp  
                                <i post_id = "<?= $value->ID ?>" class="fa fa-trash delete-post-page" aria-hidden="true"></i>
                            </td>
                        </tr>
                    <?php } ?>
                </tbody>
                <!-- <tfoot>
                    <tr>
                        <th>Name</th>
                        <th>Author</th>
                        <th>Categories</th>
                        <th>Tags</th>
                        <th>Date</th>
                        <th>Actions</th>
                    </tr>
                </tfoot> -->
            </table>
        </div>
    </div>
</div>
<script>
    jQuery('#example').DataTable({
            "pagingType": "full_numbers",
            responsive: true,
            rowReorder: {
                selector: 'td:nth-child(2)'
            }
        });
</script>
<?php get_footer(); ?>