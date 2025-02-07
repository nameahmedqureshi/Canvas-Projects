<?php /* Template Name: add post */ ?>
<?php get_header();
include('dashboard_menu.php'); 
// if(isset($_GET['id'])){
//     $post_data = get_post($_GET['id']);
//     $post_title = $post_data->post_title;
//     $post_desc = $post_data->post_content;
//     $post_status = $post_data->post_status;
//     $post_image = get_the_post_thumbnail_url($post_data->ID) ? : '';
//     $post_tags = get_the_tags($post_data->ID); 
//     $post_category = get_the_category($post_data->ID); 
// } 
// $tags = get_tags(array(
//     'hide_empty' => false
// ));
// $categories = get_categories(array(
//     'hide_empty' => false
// ));
 ?>
<!-- <section class="create_post">
    <div class="container main-content">
        <h1><?=  isset($_GET['id']) ? 'Update Post' : 'Add Post' ?> </h1>
        <div class="custom_row" id="post">
            <div class="col_12">
                <form  class="add_post_or_page" enctype="multipart/form-data">
                    <label class="whit" for="">Title *</label>
                    <input type="text" name="post_title" value="<?= $post_title  ?>" placeholder="Add Title">
                    <label class="whit" for="w3review">Description *</label>
                        <?php
                            // Use wp_editor to display a rich text editor
                            wp_editor($post_desc, 'post_desc', array(
                                'textarea_name' => 'post_desc',
                                'textarea_rows' => 6, // Adjust as needed
                                'teeny'         => false, // Use the "teeny" mode for a simplified toolbar
                                'media_buttons' => false, // Disable media buttons if not needed
                                'quicktags' => false,
                                'tinymce'       => array(
                                    'resize'            => true,
                                    'wp_autoresize_on' => true,
                                
                                ),
                            ));
                        ?>
                    <div class="tag_&_img">
                        <div class="col_3">
                            <h4> Select Tags</h4>
                            <div class="add">
                                <div class="post_tags post_all_tags">
                                <?php foreach ($tags as $tag) { ?>
                                    <input type="checkbox" id="<?= $tag->term_id ?>" name="post_tag[]" value="<?= $tag->name ?>" <?php if (isset($post_tags) && !empty($post_tags) && in_array($tag, $post_tags)) echo 'checked'; ?>>
                                    <label for="<?= $tag->term_id ?>"> <?= $tag->name ?></label><br>
                                <?php } ?>
                                </div>
                                <div class="ptags">
                                    <label for="">Add Tags</label>
                                    <select class="dropdown tags form-control js-example-basic-single" name="add_tags[]" multiple="multiple" data-tags="true" data-token-separators="[',', ' ']">
                                        <option></option>
                                    </select><br><br>
                                    <button type="button" class="add_tags">Add New Tags</button>
                                </div>
                            </div>
                        </div>
                        <div class="col_3">
                            <h4> Select Category</h4>
                            <div class="add">
                                <div class="post_tags post_all_categories">
                                    <?php foreach($categories as $category) {  ?>
                                        <input type="checkbox" id="<?= $category->term_id ?>" name="post_category[]" value="<?= $category->term_id ?>" <?php if (isset($post_category) && !empty($post_category) && in_array($category, $post_category)) echo 'checked'; ?>>
                                        <label for="<?= $category->term_id ?>"> <?= $category->name ?></label><br>
                                    <?php  } ?>
                                </div>
                                <div class="p_catgs">
                                    <label for="">Add Category</label>
                                    <select class="dropdown catgs form-control js-example-basic-single" name="add_category[]" multiple="multiple" data-tags="true" data-token-separators="[',', ' ']">
                                        <option></option>
                                    </select><br><br>
                                    <button type="button" class="add_catgs">Add New Category</button>
                                </div>
                            </div>
                        </div>
                        <div class="col_3">
                            <div class="row file_up" id="file_up" <?= $post_image ? 'style="display:none"' : '' ?>>
                                <label for="file" class="custom-file-upload">
                                    <div class="icon">
                                        <svg viewBox="0 0 24 24" fill="" xmlns="http://www.w3.org/2000/svg">
                                            <g id="SVGRepo_bgCarrier" stroke-width="0"></g>
                                            <g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g>
                                            <g id="SVGRepo_iconCarrier">
                                                <path fill-rule="evenodd" clip-rule="evenodd" d="M10 1C9.73478 1 9.48043 1.10536 9.29289 1.29289L3.29289 7.29289C3.10536 7.48043 3 7.73478 3 8V20C3 21.6569 4.34315 23 6 23H7C7.55228 23 8 22.5523 8 22C8 21.4477 7.55228 21 7 21H6C5.44772 21 5 20.5523 5 20V9H10C10.5523 9 11 8.55228 11 8V3H18C18.5523 3 19 3.44772 19 4V9C19 9.55228 19.4477 10 20 10C20.5523 10 21 9.55228 21 9V4C21 2.34315 19.6569 1 18 1H10ZM9 7H6.41421L9 4.41421V7ZM14 15.5C14 14.1193 15.1193 13 16.5 13C17.8807 13 19 14.1193 19 15.5V16V17H20C21.1046 17 22 17.8954 22 19C22 20.1046 21.1046 21 20 21H13C11.8954 21 11 20.1046 11 19C11 17.8954 11.8954 17 13 17H14V16V15.5ZM16.5 11C14.142 11 12.2076 12.8136 12.0156 15.122C10.2825 15.5606 9 17.1305 9 19C9 21.2091 10.7909 23 13 23H20C22.2091 23 24 21.2091 24 19C24 17.1305 22.7175 15.5606 20.9844 15.122C20.7924 12.8136 18.858 11 16.5 11Z" fill=""></path>
                                            </g>
                                        </svg>
                                    </div>
                                    <div class="text">
                                        <span>Set Featured Image</span>
                                    </div>
                                </label>
                                <input id="file" name="image" type="file" accept="image/*" onchange="previewImage(this)">
                            </div>
                            <div class="row" id="imagePreview" <?= $post_image ? 'style="display:flex"' : 'style="display:none"' ?> >
                                <div class="col-md-6">
                                    <img id="preview" src="<?= $post_image ?>" alt="Uploaded Image" style="max-width: 100%; max-height: 200px;">
                                </div>
                                <div class="col-md-6">
                                    <button type="button" onclick="removePreview()">Close</button>
                                </div>
                            </div>
                        </div>
                        <div class="col_3">
                            <h4>Status</h4>
                            <div class="add">
                                <select class="dropdown" name="post_status">
                                    <option <?= $post_status == 'publish' ? 'selected hidden' : '' ?> value="publish">Publish</option>
                                    <option <?= $post_status == 'draft' ? 'selected hidden' : '' ?>  value="draft">Draft</option>
                                    <option <?= $post_status == 'pending' ? 'selected hidden' : '' ?>  value="pending">Pending Review</option>
                                </select>
                                <input type="hidden" name="post_type" value="post">
                                <input type="hidden" name="existing_post_id" value="<?= isset($_GET['id']) ? $_GET['id'] : '' ?>">
                                <input type="hidden" name="action" value="add_post_or_page">
                                <input type="submit" id="publish" placeholder="publish" value="publish">
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</section> -->
<!-- <script>
    function previewImage(input) {
        var file = input.files[0];
        var reader = new FileReader();

        reader.onload = function(e) {
            document.getElementById('preview').setAttribute('src', e.target.result);
            document.getElementById('imagePreview').style.display = 'flex'; // Show the image preview
            document.getElementById('file_up').style.display = 'none'; // Show the image preview
        }

        reader.readAsDataURL(file);
    }

    function removePreview() {
        document.getElementById('file').value = ''; // Clear the input file value
        document.getElementById('imagePreview').style.display = 'none'; // Hide the image preview
        document.getElementById('file_up').style.display = 'block'; // Hide the image preview
    }
    jQuery(document).ready(function() {
        jQuery('.js-example-basic-single').select2({
            tags: true
        });	
    });
</script> -->

<style>

    section.main_dashboard {
        background: #f1f1f1;
    }
    section.create_post {
        padding-bottom: 100px;
    }
    .analytics-frame{
        border: none;
        width: 100%;
        height: 1150px;
        display: none;
       
    }

</style>
<section class="create_post">
    <div class="row card_row">
        <?php if(isset($_GET['id'])) { ?>
            <iframe id="myIframe" class="analytics-frame"  frameborder="0" src="<?= home_url('wp-admin/post.php?post='.$_GET['id'].'&action=edit') ?>" ></iframe>
        <?php } else { ?>
            <iframe id="myIframe" class="analytics-frame"  frameborder="0" src="<?= home_url('wp-admin/post-new.php') ?>" ></iframe>
        <?php } ?>
    </div>
</section>

<?php get_footer(); ?>

<script>
(function ($) {
    $(document).ready(function () {
        jQuery('.create_post').waitMe({
                effect : 'facebook',
                text : '',
                bg : 'rgba(255,255,255,0.7)',
                color : '#000',
                maxSize : '',
                waitTime : -1,
                textPos : 'vertical',
                fontSize : '',
                source : '',
        });
            var iframe = jQuery("#myIframe");
            // iframe.attr("src", iframe.data("src"));
            iframe.load(function() {
               
            iframe.contents().find("head")
                .append(jQuery("<style> #adminmenumain, #wpadminbar, #screen-meta-links, .error, .page-title-action, .notice, #vtrts_subscribe {display:none !important;} #wpcontent, #wpfooter { margin-left: 0px;} </style>"))
                jQuery("#myIframe").show();
                jQuery('.create_post').waitMe('hide');
            });
    });
})(jQuery);
</script>
