
<?php
require 'vendor/autoload.php';
use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;
use GuzzleHttp\Exception\RequestException;

use Keepa\API\Request;
use Keepa\API\ResponseStatus;
use Keepa\helper\CSVType;
use Keepa\helper\CSVTypeWrapper;
use Keepa\helper\KeepaTime;
use Keepa\helper\ProductAnalyzer;
use Keepa\helper\ProductType;
use Keepa\KeepaAPI;
use Keepa\objects\AmazonLocale;



function get_deals_products()
{
    $apiKey="7nitpb22hmvp3ielikp5h6ppclve1j1mf9193d2c195ssudd2aeetbll13jg93gi";
    $api_deals_url="https://api.keepa.com/deal?key=".$apiKey."&selection=%7B%22page%22%3A0%2C%22domainId%22%3A%221%22%2C%22excludeCategories%22%3A%5B5174%2C283155%2C2625373011%5D%2C%22includeCategories%22%3A%5B%5D%2C%22priceTypes%22%3A%5B1%5D%2C%22deltaRange%22%3A%5B0%2C2147483647%5D%2C%22deltaPercentRange%22%3A%5B90%2C2147483647%5D%2C%22salesRankRange%22%3A%5B-1%2C9999999%5D%2C%22currentRange%22%3A%5B0%2C2147483647%5D%2C%22minRating%22%3A30%2C%22isLowest%22%3Afalse%2C%22isLowestOffer%22%3Afalse%2C%22isOutOfStock%22%3Afalse%2C%22titleSearch%22%3A%22%22%2C%22isRangeEnabled%22%3Atrue%2C%22isFilterEnabled%22%3Atrue%2C%22filterErotic%22%3Atrue%2C%22singleVariation%22%3Atrue%2C%22hasReviews%22%3Afalse%2C%22isPrimeExclusive%22%3Afalse%2C%22mustHaveAmazonOffer%22%3Afalse%2C%22mustNotHaveAmazonOffer%22%3Afalse%2C%22sortType%22%3A1%2C%22dateRange%22%3A%221%22%2C%22warehouseConditions%22%3A%5B2%2C3%2C4%2C5%5D%2C%22hasAmazonOffer%22%3Atrue%2C%22isRisers%22%3Afalse%2C%22isHighest%22%3Afalse%2C%22exclud%5B%E2%80%A6%5Ds%22%3Afalse%7D";
	// $api_deals_url="https://api.keepa.com/deal?key=7nitpb22hmvp3ielikp5h6ppclve1j1mf9193d2c195ssudd2aeetbll13jg93gi&selection=%7B%22page%22%3A0%2C%22domainId%22%3A%221%22%2C%22excludeCategories%22%3A%5B283155%2C15684181%2C468642%2C165796011%2C7141123011%2C2617941011%5D%2C%22includeCategories%22%3A%5B%5D%2C%22priceTypes%22%3A%5B1%5D%2C%22deltaRange%22%3A%5B0%2C2147483647%5D%2C%22deltaPercentRange%22%3A%5B10%2C90%5D%2C%22salesRankRange%22%3A%5B-1%2C20000%5D%2C%22currentRange%22%3A%5B500%2C2147483647%5D%2C%22minRating%22%3A30%2C%22isLowest%22%3Atrue%2C%22isLowestOffer%22%3Afalse%2C%22isOutOfStock%22%3Afalse%2C%22titleSearch%22%3A%22golf%2C%20-disc%2C%20-hiking%2C%20-running%2C%20-tennis%2C%20-wheelchair%2C%20-slides%2C%20-jmierr%2C%20-belt%2C%20-skirt%2C%20-skirts%2C%20-belts%2C%20-umbrella%2C%20-party%2C%20-yoga%2C%20-pleated%2C%20-tennis%2C%20-shorts%2C%20-tank%2C%20-walnut%2C%20-gatherer%2C%20-rake%2C%20-mug%2C%20-coffee%22%2C%22isRangeEnabled%22%3Atrue%2C%22isFilterEnabled%22%3Atrue%2C%22filterErotic%22%3Atrue%2C%22singleVariation%22%3Atrue%2C%22hasReviews%22%3Afalse%2C%22isPrimeExclusive%22%3Afalse%2C%22mustHaveAmazonOffer%22%3Afalse%2C%22mustNotHaveAmazonOffer%22%3Afalse%2C%22sortType%22%3A1%2C%22dateRange%22%3A%221%22%2C%22warehouseConditions%22%3A%5B2%2C3%2C4%2C5%5D%2C%22hasAmazonOffer%22%3Atrue%2C%22isRisers%22%3Afalse%2C%22isHighest%22%3Afalse%2C%22exclud%5B%E2%80%A6%5Ds%22%3Afalse%7D";
    $prods=[];
    $prod_i=0;
    $p_i=0;
    $product_data=[];
    $asin_list=[];


    // Create a new Guzzle client
    $client = new Client;
    try {
        

        
        
        // Send a GET request to the API
        $response = $client->get($api_deals_url);
    
        // Get the response body as a string (you can decode it to JSON or parse as needed)
        $data = $response->getBody();
        $json = json_decode($data);
        $deals_products=$json->deals->dr;
	    $deals_products=array_slice($deals_products, 0, 2);
        print_r($deals_products);


        foreach($deals_products as $product)
        {
                $product_title=$product->title;
                $product_sku=$product->asin;
                $product_asin=$product->asin;
                $product_description=$product->title;
                $product_current_price=0;
                $product_avg_price=0;


                //Keepa API 
                $product_keepa=null;
                $api = new KeepaAPI($apiKey);
                $r = Request::getProductRequest(AmazonLocale::DE, 0, "2001-12-31", "2026-01-01", 0, true, [$product_asin]);

                $response_keepa = $api->sendRequestWithRetry($r);
                $products_keepa=json_decode(json_encode($response_keepa->products));
                if ($response_keepa->status==200)
                {
                    $product_keepa=$products_keepa[0];
                    if ($product_keepa->productType == ProductType::STANDARD || $product_keepa->productType == ProductType::DOWNLOADABLE) 
                    {
                        $currentAmazonPrice = ProductAnalyzer::getLast($product_keepa->csv[CSVType::AMAZON], CSVTypeWrapper::getCSVTypeFromIndex(CSVType::AMAZON));
                        if ($currentAmazonPrice >=1)
                        {
                            $salePrice = round(($currentAmazonPrice / 100), 2);
                            $product_current_price=$salePrice;
                            $weightedMean90days = ProductAnalyzer::calcWeightedMean($product_keepa->csv[CSVType::AMAZON], KeepaTime::nowMinutes(),90, CSVTypeWrapper::getCSVTypeFromIndex(CSVType::AMAZON));
                            $regularPrice = round(($weightedMean90days / 100), 2);
                            $product_avg_price=$regularPrice;
                        }
                    }

                } else {
                    $product_keepa=null;

                    //Product Current Price
                    $product_current_price=number_format(0,2)/100;
                    foreach($product->current as $price)
                    {
                        if ($price>1)
                        {
                            $product_current_price_str=$price;
                            break;
                        }
                    }
                    if (is_numeric($product_current_price_str))
                    {
                        $product_current_price=$product_current_price_str/100;
                    }else{
                        $product_current_price=number_format(0,2)/100;
                    }

                    //pRODUCT aVERAGE pRICE
                    $product_avg_price_str="";
                    $product_avg_price=number_format(0,2)/100;
                    if (is_array($product->avg[1])) 
                    {
                        foreach($product->avg[1] as $avg_price)
                        {
                            if ($avg_price>1)
                            {
                                $product_avg_price_str=$avg_price;
                                break;
                            }
                        }

                        if (is_numeric($product_avg_price_str))
                        {
                            $product_avg_price=$product_avg_price_str/100;
                            
                        }else{
                            $product_avg_price=number_format(0,2)/100;
                        }
                        
                    } else {
                        if (is_numeric($product_avg_price_str))
                        {
                            $product_avg_price=$product_avg_price_str/100;
                            
                        }else{
                            $product_avg_price=number_format(0,2)/100;
                        }
                    }

                }
                


                





                $product_tag=$product->asin;
                $product_categories="";
                $product_description="";
                $prod_asin="";
                $product_category_id="";
                $product_category_name="";
                $product_img_url="";
                $product_img_file="";
                $product_category="";
                $product_category_slug="";
                $product_api_url="https://api.keepa.com/product?key=".$apiKey."&domain=1&asin=".$product->asin."&only-live-offer=1&history=0&rating=1&buybox=1";
                $product_url="https://www.amazon.com/dp/".$product_asin;
                
                try {
                    $response_product = $client->get($product_api_url);
                    // Get the response body as a string (you can decode it to JSON or parse as needed)
                    $data_product = $response_product->getBody();
                    $json_product = json_decode($data_product);
                    $sel_products=$json_product->products;
                    $prod_data=$sel_products[0];
                    $pcat_id="";
                    $prod_asin=$prod_data->asin;
                    $product_description=$prod_data->description;
                    $product_img_url="https://m.media-amazon.com/images/I/".explode(',', $prod_data->imagesCSV)[0]."";
                    $product_img_file=explode(',', $prod_data->imagesCSV)[0];
                    $sel_product_category=$prod_data->categories[0];
                    $product_category=$prod_data->categoryTree;
                    $product_type=$prod_data->productType;
                    
                    //Current Price and Average Price
                    $product_current_price_str="";
                    $product_avg_price_str="";
                    if (!empty($prod_data->categoryTree))
                    {
                        $prod_data_categories_lst=$prod_data->categoryTree;
                        foreach($prod_data_categories_lst as $pcat)
                        {
                            if ($pcat->catId==$sel_product_category)
                            {
                                $product_category_id=$pcat->catId;
                                $product_category_name=$pcat->name;
                                $product_category_slug=$pcat->catId;
                                break;
                            }
                        }
                            
                    } else {
                        $pcat_id="";
                        $product_category_name="";
                        $product_category_slug="";
                    }

                    $product_data=[
                        "product_title"=>$product_title,
                        "product_sku"=>$product_asin,
                        "product_current_price"=>$product_current_price,
                        "product_avg_price"=>$product_avg_price,
                        "product_tag"=>$product_asin,
                        "product_description"=>$product_description,
                        "product_category_id"=>$product_category_id,
                        "product_category_name"=>$product_category_name,
                        "product_category_slug"=>$product_category_id,
                        "product_img"=>$product_img_file,
                        "product_img_url"=>$product_img_url,
                        "product_url"=>$product_url
                    ];

                    print_r($product_data);

                    

                    

                    // insert_product($product_data);

                } catch (GuzzleException $e) {
                    // Handle any Guzzle-specific exceptions
                    echo "Guzzle Error in Product Details: " . $e->getMessage();
                    $product_data=[
                        "product_title"=>$product_title,
                        "product_sku"=>$product_asin,
                        "product_current_price"=>$product_current_price,
                        "product_avg_price"=>$product_avg_price,
                        "product_tag"=>$product_asin,
                        "product_description"=>$product_description,
                        "product_category_id"=>$product_category_id,
                        "product_category_name"=>$product_category_name,
                        "product_category_slug"=>"",
                        "product_img"=>$product_img_file,
                        "product_img_url"=>$product_img_url,
                        "product_url"=>""
                    ];
                //	insert_product($product_data);
                }

                
                
                $product_data[$product_asin]=$product_data;
                $prods[$prod_i]=$product_data;
                $asin_list[$prod_i]=$product->asin;
                $prod_i++;
                
                

        }
        


        
    } catch (RequestException $e) {
        // Handle any request exceptions (e.g., connection error, 404, etc.)
        echo "Error: " . $e->getMessage();
    } catch (GuzzleException $e) {
        // Handle any Guzzle-specific exceptions
        echo "Guzzle Error: " . $e->getMessage();
    }


    


    
    
    return $prods;
}

get_deals_products();