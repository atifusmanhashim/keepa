function insert_product()
{
		$product_data=["product_title"=> "adidas Men's TOUR360 22 Golf Shoes, Footwear White/Footwear White/Silver Metallic, 7",
						"product_sku"=> "B096H74PKJ",
						"product_description"=> "adidas Men's TOUR360 22 Golf Shoes, Footwear White/Footwear White/Silver Metallic, 7",
						"product_price"=> 92.58,
						"product_avg_price"=> 0,
						"product_tag"=> "B096H74PKJ",
						"product_img"=>"31iqUWr8iFL.jpg",
						"product_img_url"=>"https://m.media-amazon.com/images/I/31iqUWr8iFL.jpg"
                    ];
//	print_r(json_encode($product_data));
	$product_data=json_decode(json_encode($product_data),false);
	$product_ins_type = 'product';
	$product_name=$product_data->product_title;
	$product_description=$product_data->product_description;
	$product_current_price=$product_data->product_price;
	
	// Sanitize the product name to prevent SQL injection
	$product_name = sanitize_text_field( $product_name );

	// Prepare the database query to check for the existence of the product
	global $wpdb;
	$product_id = $wpdb->get_var( $wpdb->prepare( "SELECT ID FROM $wpdb->posts WHERE post_type = %s AND post_title = %s", $product_ins_type, $product_name ) );

	// Check if the product exists
	if ( $product_id ) {
	//	echo "Product with name '$product_name' exists. Product ID: $product_id";
		
		$image_url = $product_img_url;

			// Download and save the image to the media library
			$image_name = basename($image_url);
			$upload_dir = wp_upload_dir();
			$image_path = $upload_dir['path'] . '/' . $image_name;

			if (function_exists('download_url')) {
				$temp_image = download_url($image_url);
				if (is_wp_error($temp_image)) {
					// Handle download error here if needed
				} else {
					file_put_contents($image_path, file_get_contents($temp_image));
				}
			}

			// Check if the image was successfully downloaded and saved
			if (file_exists($image_path)) {
				// Get the image file type
				$file_type = wp_check_filetype($image_path);

				// Set up the attachment data
				$attachment = array(
					'post_mime_type' => $file_type['type'],
					'post_title' => sanitize_file_name($image_name),
					'post_content' => '',
					'post_status' => 'inherit',
				);

				// Insert the attachment into the media library
				$attach_id = wp_insert_attachment($attachment, $image_path, $product_id);

				// Set product featured image
				if (!is_wp_error($attach_id)) {
					set_post_thumbnail($product_id, $attach_id);
				} else {
					// Handle attachment insertion error here if needed
				}
			}

	} else {
		$product_sku=$product_data->product_sku;
		$product_title=$product_name;
		$product_img_url=$product_data->product_img_url;
		$product_img=$product_data->product_img;
		$product = new WC_Product_Simple();

 			$product->set_name($product_name); // product title

 			$product->set_slug($product_sku);
			$product->set_sku($product_sku); // Should be unique
 			$product->set_regular_price($product_current_price ); // in current shop currency

 			$product->set_short_description($product_description);
 			// you can also add a full product description
 			 $product->set_description($product_title);
			
// 			file_put_contents($product_img, file_get_contents($product_img_url));
// 			$imageId = media_handle_sideload($product_img, $product->get_id());
// 			$product->set_image_id($imageId);
 			

 			// let's suppose that our 'Accessories' category has ID = 19 
 		//	$product->set_category_ids($product_categories);
 			// you can also use $product->set_tag_ids() for tags, brands etc

 			$product->save();
		// Assuming you have the product ID and the image URL, let's say:
			$product_id = $product->product_id;
			$image_url = $product_img_url;

			// Download and save the image to the media library
			$image_name = basename($image_url);
			$upload_dir = wp_upload_dir();
			$image_path = $upload_dir['path'] . '/' . $image_name;

			if (function_exists('download_url')) {
				$temp_image = download_url($image_url);
				if (is_wp_error($temp_image)) {
					// Handle download error here if needed
				} else {
					file_put_contents($image_path, file_get_contents($temp_image));
				}
			}

			// Check if the image was successfully downloaded and saved
			if (file_exists($image_path)) {
				// Get the image file type
				$file_type = wp_check_filetype($image_path);

				// Set up the attachment data
				$attachment = array(
					'post_mime_type' => $file_type['type'],
					'post_title' => sanitize_file_name($image_name),
					'post_content' => '',
					'post_status' => 'inherit',
				);

				// Insert the attachment into the media library
				$attach_id = wp_insert_attachment($attachment, $image_path, $product_id);

				// Set product featured image
				if (!is_wp_error($attach_id)) {
					set_post_thumbnail($product_id, $attach_id);
				} else {
					// Handle attachment insertion error here if needed
				}
			}

	}
}
add_action('init', 'insert_product');
//