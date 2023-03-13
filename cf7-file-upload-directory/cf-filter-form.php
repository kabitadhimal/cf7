s<?php
/*
 * Insert CF-7 submission to custom post
 *  Save the cf7 uploaded file to the folder
 *
 */
add_action('wpcf7_before_send_mail', function($wpcf7){
    if($wpcf7->id() == 12)  {
        $submission = WPCF7_Submission::get_instance();
        if($submission) {
            $input = $posted_data['form-input']?? null;
            $postTitle = $posted_data['form-input-email']?? 'New Email';
            $post = [
                'post_title'    => $postTitle,
                'post_status'   => 'publish',
                'post_type' 	=> 'contract_work' // Could be: `page` or your CPT
            ];
            $postID = wp_insert_post($post);

            $posted_data = $submission->get_posted_data();

            //For uploaded file/cv
            $uploaded_files = $submission->uploaded_files();
            foreach ( $uploaded_files as $name => $path ) {
                $file_path = $path[0];
                $destination_path = WP_CONTENT_DIR . '/uploads/cf7_uploads/';
                if (!file_exists($destination_path)) {
                    wp_mkdir_p($destination_path);
                }

                $new_file_path = $destination_path . rand().strtolower(basename($file_path));
                copy($file_path, $new_file_path);
                if (!copy($file_path, $new_file_path)) {
                    //echo "error goes here";
                }

                $uploadedFilePath = explode('wp-content',$new_file_path);
                //update the custom field with cv path
                update_field("cv", $uploadedFilePath[1], $postID); //Update the acf field;
            }

        }
    }

    return $wpcf7;
}, 20);