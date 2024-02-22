// function get_deals_products()
// {
// 	    $api_deals_url="https://api.keepa.com/deal?key=7nitpb22hmvp3ielikp5h6ppclve1j1mf9193d2c195ssudd2aeetbll13jg93gi&selection=%7B%22page%22%3A0%2C%22domainId%22%3A%221%22%2C%22excludeCategories%22%3A%5B2625373011%2C7141123011%2C283155%2C599858%2C163856011%2C5174%2C16310091%2C11260432011%2C3452431%2C229534%5D%2C%22includeCategories%22%3A%5B16381%2C266224%2C281388%2C769052%2C3406051%2C3410871%2C3410901%2C3410911%2C3411001%2C3411181%2C3411261%2C3411271%2C3800401%2C4118751%2C13280071%2C13702601%2C159838011%2C159846011%2C166457011%2C293595011%2C374810011%2C374811011%2C374812011%2C374813011%2C374814011%2C374815011%2C374816011%2C562377011%2C562378011%2C679278011%2C679353011%2C1238971011%2C3311052011%2C3318351011%2C7304157011%2C9408557011%2C7507228011%2C5805438011%2C9626672011%2C17928760011%2C10332456011%2C14351416011%2C5769001011%5D%2C%22priceTypes%22%3A%5B0%5D%2C%22deltaRange%22%3A%5B0%2C2147483647%5D%2C%22deltaPercentRange%22%3A%5B0%2C2147483647%5D%2C%22salesRankRange%22%3A%5B-1%2C-1%5D%2C%22currentRange%22%3A%5B500%2C2147483647%5D%2C%22minRating%22%3A30%2C%22isLowest%22%3Atrue%2C%22isLowestOffer%22%3Afalse%2C%22isOutOfStock%22%3Afalse%2C%22titleSearch%22%3A%22%22%2C%22isRangeEnabled%22%3Atrue%2C%22isFilterEnabled%22%3Atrue%2C%22filterErotic%22%3Atrue%2C%22singleVariation%22%3Atrue%2C%22hasReviews%22%3Atrue%2C%22isPrimeExclusive%22%3Afalse%2C%22mustHaveAmazonOffer%22%3Afalse%2C%22mustNotHaveAmazonOffer%22%3Afalse%2C%22sortType%22%3A4%2C%22dateRange%22%3A%221%22%2C%22warehouseConditions%22%3A%5B2%2C3%2C4%2C5%5D%2C%22hasAmazonOffer%22%3Atrue%2C%22isRisers%22%3Afalse%2C%22isHighest%22%3Afalse%7D";

//     // // Create a new Guzzle client
//   	$client = new Client;
//     try {
        
//         // Send a GET request to the API
//         $response = $client->get($api_deals_url);
    
//         // Get the response body as a string (you can decode it to JSON or parse as needed)
//         $data = $response->getBody();
//         $json = json_decode($data);
//         $deals_products=$json->deals->dr;
//      	//   print_r($deals_products);
//         $prods=array();
//         $prod_i=0;
//         foreach($deals_products as $product)
//         {
//             $product_current_price_str=$product->current[0];
//             if (is_numeric($product_current_price_str))
//             {
//                 $product_current_price=$product_current_price_str/100;
//             }else{
//                 $product_current_price=number_format(0,2)/100;
//             }

//             $product_avg_price_str=$product->avg[0];
//             if (is_numeric($product_avg_price_str))
//             {
//                 $product_avg_price=$product_avg_price_str/100;
                
//             }else{
//                 $product_avg_price=number_format(0,2)/100;
//             }
            
//             $product_title=$product->title;
// 			$product_sku=$product->asin;
// 			$product_description=$product->title;
// 			$product_price=$product_current_price;
// 			$product_tag=$product->asin;
// 			$product_categories=$product->categories;
//             $product_data=array(
//                 "product_title"=>sanitize_text_field($product->title),
//                 "product_sku"=>$product->asin,
//                 "product_price"=>$product_current_price,
//                 "product_avg_price"=>$product_avg_price,
//                 "product_tag"=>$product->asin,
// 				"product_categories"=>$product->categories
//             );
//             $prods[$prod_i]=json_encode($product_data);
//             $prod_i+=1;
			
// 			// Prepare the database query to check for the existence of the product
// 			global $wpdb;
// 			$product_id = $wpdb->get_var( $wpdb->prepare( "SELECT ID FROM $wpdb->posts WHERE post_type = %s AND post_title = %s", $product_ins_type, $product_title ) );
		    
// 			// Check if the product exists
// 			if ( $product_id ) {
// 				echo "Product with name '$product_title' exists. Product ID: $product_id";
// 			} else {

// 				// Sanitize the product name to prevent SQL injection
// 				$product_name = sanitize_text_field( $product_name );
				
// 				$product = new WC_Product_Simple();

// 				$product->set_name($product_name); // product title

// 				$product->set_slug($product_sku);
// 				$product->set_sku('".$product_sku."'); // Should be unique
// 				$product->set_regular_price($product_current_price ); // in current shop currency
// 				$product->set_short_description(sanitize_text_field( $product_description ));
				
// 				// you can also add a full product description
// 				$product->set_description(sanitize_text_field( $product_description ));
// 				$product->set_category_ids($product_categories);
// 				$product->save();
			
// 					// let's suppose that our 'Accessories' category has ID = 19 
// 				//	
// 				$product->set_category_ids($product_categories);
// 					// you can also use $product->set_tag_ids() for tags, brands etc
// 			}

//         }
        
      
//     } catch (RequestException $e) {
//         // Handle any request exceptions (e.g., connection error, 404, etc.)
//         echo "Error: " . $e->getMessage();
//     } catch (GuzzleException $e) {
//         // Handle any Guzzle-specific exceptions
//         echo "Guzzle Error: " . $e->getMessage();
//     }
//     return $prods;
// }
