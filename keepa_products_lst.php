<?php


/* maybe required - depends if youre using a framework which automaticly loading this file
require_once "vendor/autoload.php";
*/ 
require_once "vendor/autoload.php";
use Keepa\API\Request;
use Keepa\API\ResponseStatus;
use Keepa\helper\CSVType;
use Keepa\helper\CSVTypeWrapper;
use Keepa\helper\KeepaTime;
use Keepa\helper\ProductAnalyzer;
use Keepa\helper\ProductType;
use Keepa\KeepaAPI;
use Keepa\objects\AmazonLocale;
$apiKey = '7nitpb22hmvp3ielikp5h6ppclve1j1mf9193d2c195ssudd2aeetbll13jg93gi';

$asins_lst=[
    "B06X9QK6MY",
];
// $asins_lst=[
//     "B06X9QK6MY",
//     "B07PH2RQ7D",
//     "B09JVYZHND",
//     "B07K8XTZP8",
//     "B01N5HKTU5",
//     "B01MZ1Y2XD",
//     "B072JN5NWB",
//     "B07S975YHS",
//     "B0BF8L98QP",
//     "B09GH9RR4P",
//     "B0B69QD27R",
//     "B01I90VP0G",
//     "B0C87CLC8P",
//     "B0014C2NKS",
//     "B08412RMB6",
//     "B07L9BW3GL",
//     "B09NMCFG3P",
//     "B001RCSARA",
//     "B08RP8CKCL",
//     "B005PQQ350",
//     "B000XCYV0K",
//     "B0BSGCHH6J",
//     "B0BSGKQPN8",
//     "B07BTPS77F",
//     "B00HUIO178",
//     "B07TQNDQQ1",
//     "B0BF956YFV",
//     "B078P4NW3Z",
//     "B0BSGBS2K7",
//     "B0002GYXOG",
//     "B07Z42N94T",
//     "B098F57HSP",
//     "B010WE7TUM",
//     "B09JMB33FL",
//     "B09JM9TP2B",
//     "B06X9GQJTF",
//     "B098F57WJ8",
//     "B07PH2Y7YR",
//     "B07PH2SRHH",
//     "B06X9P9MG2",
//     "B07PH2QL2B",
//     "B09JVMC46T",
//     "B0BHC4BL6M",
//     "B098F6JQ4B",
//     "B07K8XNCYZ",
//     "B09GHLYRB5",
//     "B08412K47W",
//     "B0BF8SW6K7",
//     "B09773PR38",
//     "B0884CBD4N",
//     "B088415BXQ",
//     "B09GH45XJ9",
//     "B08V1QBNWY",
//     "B07TVK3CVK",
//     "B07CN49HW5",
//     "B07CN2ZZC1",
//     "B01A6L9V3Y",
//     "B07S75WC1J",
//     "B00152AGCY",
//     "B07K8YRNXQ",
//     "B07BTPPG7X",
//     "B09JVQ8HH4",
//     "B0BFNLMLFM",
//     "B0BSGC8122",
//     "B07L57XXXK",
//     "B078P212J3",
//     "B0C2H6VZS2",
//     "B0BFNNXZ4B",
//     "B0BSG9YJJH",
//     "B09JVG2BHB",
//     "B09JVFTNQ8",
//     "B00HB55ODA",
//     "B01M35MVDE",
//     "B08V6MVB8N",
//     "B0825GWSSV",
//     "B010WE7PQU",
//     "B01EZ5SGZ6",
//     "B0B4SGKT1J",
//     "B084GX5GR9",
//     "B0BSGD2ZGQ",
//     "B09JVSW5Z2",
//     "B00QEMRX4Y",
//     "B078P2WPHX",
//     "B09JM9JJ6J",
//     "B00QEMS03M",
//     "B01FM1AGAA",
//     "B07416J33N",
//     "B07N716W14",
//     "B07X4XX6ZP",
//     "B001RCXP2U",
//     "B0014C2QGE",
//     "B09NMCDLWC",
//     "B09774P9JM",
//     "B09774QC4F",
//     "B010WE7TNE",
//     "B0BSGBDK79",
//     "B08841ZYXY",
//     "B07SBB8DZY",
//     "B00RELQ642",
//     "B098F5ZBS2"
// ];

        $api = new KeepaAPI($apiKey);
        $r = Request::getProductRequest(AmazonLocale::DE, 0, "2001-12-31", "2026-01-01", 0, true, $asins_lst);

        $response = $api->sendRequestWithRetry($r);
        $products=json_decode(json_encode($response->products));
        print_r($products[0]);

			// switch ($response->status) {
            //     case ResponseStatus::OK:
            //         // iterate over received product information
            //         foreach ($response->products as $product){
            //             print_r($product);
            //             // if ($product->productType == ProductType::STANDARD || $product->productType == ProductType::DOWNLOADABLE) {

            //             //     //get basic data of product and print to stdout
            //             //     $currentAmazonPrice = ProductAnalyzer::getLast($product->csv[CSVType::AMAZON], CSVTypeWrapper::getCSVTypeFromIndex(CSVType::AMAZON));

			// 			// 	//check if the product is in stock -1 -> out of stock
			// 			// 	if ($currentAmazonPrice == -1) {
            //             //         echo sprintf("%s %s is currently not sold by Amazon (out of stock) %s",$product->asin,$product->title,PHP_EOL);
            //             //     } else {
            //             //         echo sprintf("%s %s Current Amazon Price: %s %s",$product->asin,$product->title,$currentAmazonPrice,PHP_EOL);
            //             //     }

			// 			// 	// get weighted mean of the last 90 days for Amazon
			// 			// 	$weightedMean90days = ProductAnalyzer::calcWeightedMean($product->csv[CSVType::AMAZON], KeepaTime::nowMinutes(),90, CSVTypeWrapper::getCSVTypeFromIndex(CSVType::AMAZON));

			// 			// } else {
            //             //    print_r(""); 
            //             // }
            //         }
			// 		break;
			// 	default:
			// 	// print_r($response);
			// }