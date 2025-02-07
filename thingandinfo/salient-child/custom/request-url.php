<?php /*Template Name: Upload old */ ?>
<?php get_header(); if(is_user_logged_in()) { ?>
        <form id="upload" enctype="multipart/form-data">
            <div class="col-12">
                <div class="form_group mb-4">
                    <label for="" class="gen_label">Title</label>
                    <input type="text" name= "title" placeholder="Enter Full Name Here" class="gen_input"  required>
                </div>
                <div class="form_group mb-4">
                    <label for="" class="gen_label">Desciption</label>
                    <textarea name= "desciption" class="gen_input"></textarea>
                </div>
                <div class="form_group mb-4">
                    <label for="" class="gen_label">Select File</label>
                    <input type="file" name= "upload_file"  class="gen_input"  required>
                </div>
            </div>
            <div class="col-6">
                <div class="form_group mt-4">
                    <button type ="submit" class="submit_btn">Get Link</button>
                </div>
            </div>
            <input type="hidden" name="action" value="get_link" />

        </form>
<?php } else { ?> 
	<div>
		<p>
			Logged in first!
		</p>
	</div> 
<?php } get_footer(); ?>