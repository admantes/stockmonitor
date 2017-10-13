<?php
include("conf.php");
// ini_set("error_reporting","E_ERROR");//Disable error reporting in warning
DEFINE("STOP_LOSS_PERCENTAGE", 3.00); 
DEFINE("SELL_TARGET_PERCENTAGE", 1.7); 

$stockURL = "http://phisix-api4.appspot.com/stocks/";
//$stockURL = "https://phutie.com/admantes/stock/sampledata/";
$sharesArr = array();
$avepriceArr = array();
$stockArr = array();
$stopLossArr = array();

$targetArr = array();
$resultArr = array("stock"=>array());
$multiArr = array();
$keyArr = array("symbol","shares","aveprice","price","percent_change","marketvalue","totalcost","gainloss","fcolor","stoploss","target","action");
 

// Create connection
$conn = mysqli_connect($servername, $username, $password, $dbname);
// Check connection
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

$sql = "SELECT * from t_stocks";
$result = mysqli_query($conn, $sql);

if (mysqli_num_rows($result) > 0) {
    // output data of each row
    while($row = mysqli_fetch_assoc($result)) {
  
	//Get JSON DATA for each stock	 
	$url = $stockURL.$row["symbol"].".json";
	array_push($stockArr,$url);
	array_push($sharesArr,$row["shares"]);
	array_push($avepriceArr,$row["aveprice"]);
	array_push($stopLossArr,$row["stoploss"]);
	array_push($targetArr,$row["target"]);
	//echo $url;
	
    }
} else {
    echo "0 results";
}

mysqli_close($conn);

 
 $all = "";
 $jsonArr = array();
 $curIndex = 0;
 
 $ch = curl_init();
foreach ($stockArr as $x) {
    $url = $x;
	array_push($jsonArr,array());
	
	curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
	curl_setopt($ch, CURLOPT_URL,$url);
	$result=curl_exec($ch);
	 
	//$all .= $result;
	
	$obj = json_decode($result, false);
	
	if(substr($result,0,1) != "{"){
		//echo 0;
		continue;
	}
	$currentPrice = $obj->{'stock'}[0]->{'price'}->{'amount'};
	$shares = $sharesArr[$curIndex];
	$aveprice = $avepriceArr[$curIndex];
	
	//$stopLoss = $stopLossArr[$curIndex];
	//$target = $targetArr[$curIndex];
	
	array_push($jsonArr[$curIndex],$obj->{'stock'}[0]->{'symbol'});
	array_push($jsonArr[$curIndex],$shares);
	array_push($jsonArr[$curIndex],$aveprice);

	//array_push($jsonArr[$curIndex],""); //Stop Loss(calculated in client)
	//array_push($jsonArr[$curIndex],""); //Target (calculated in client)
	
	array_push($jsonArr[$curIndex],$currentPrice);
	array_push($jsonArr[$curIndex],$obj->{'stock'}[0]->{'percent_change'});
 
	//Compute Other Values
	$marketValue = ($currentPrice * $shares);
	$deductions = ( $marketValue * 0.0025 ) + ($marketValue*0.0001) + ($marketValue*0.005) + ($marketValue * 0.0025 * 0.12);
	
	
	$marketValue = $marketValue - $deductions ; //Current Price * Shares
	
	//(((x.price*x.shares*0.0025) +  (x.price*x.shares*0.0001) + (x.price*x.shares*.005) + (x.price*x.shares*.0025*0.12)))
		
	$totalCost = ($shares*$aveprice);// + $deductions;
	$gainLoss = $marketValue - $totalCost;
	
	$curStyle = $gainLoss > 0 ? "green" : "red";
	
	$stopLoss = $stopLossArr[$curIndex];
	//$target = $targetArr[$curIndex];
	
	  
	$stopLoss = $totalCost - ((STOP_LOSS_PERCENTAGE/100.00) * $totalCost);
	$sellTarget =  $totalCost + ((SELL_TARGET_PERCENTAGE/100) * $totalCost);
	
	$action = "HOLD";
	
	if($marketValue > $sellTarget){
		$action = "SELL";	
	}else{
		if($marketValue < $stopLoss){
			$action = "SELL";
		}
		
	}
	
	
	array_push($jsonArr[$curIndex],$marketValue); //Adding Market Value
	array_push($jsonArr[$curIndex],$totalCost); //Adding Total Cost
	array_push($jsonArr[$curIndex],$gainLoss); //Adding Total Cost
	array_push($jsonArr[$curIndex],$curStyle);
	
	array_push($jsonArr[$curIndex],$stopLoss);
	array_push($jsonArr[$curIndex],$sellTarget);
	array_push($jsonArr[$curIndex],$action);
	
	//Combine Keys and Array Values to form JSON output
	$keyValArr = array_combine($keyArr, $jsonArr[$curIndex]);	
	 
	array_push($multiArr,$keyValArr);
	$curIndex++;
}
	curl_close($ch);		 
			
			
	
	$resultArr["stock"] = $multiArr;
		 
	echo json_encode($resultArr);
				
  	
?>
