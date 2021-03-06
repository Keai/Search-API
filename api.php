<?php 
header("Content-Type:application/json");
// 请求data数据文件
// require_once "data.php";

// 请求数据库
require_once "db.php";

function response($status,$status_message,$data){
	header("HTTP/1.1 ".$status);

	$response['status'] = $status;
	$response['status_message'] = $status_message;
	$response['data'] = $data;
	$response['time'] = "18.04.16";

	$json_response = json_encode($response);
	echo $json_response;
}

		前端写的name是否为空
if (!empty($_GET['name'])) {
	$name = $_GET['name'];
	//data.php 的get_price方法
	// $price = get_price($name);

	//db.php方法
	$db = new DBConnection();
    $price = $db->getProductPriceByName($name);


	if (empty($price)) {
		response(200, "Product Not Found", NULL);
	} else {
		response(200, "Product Found", $price);
	}
} else {
	response(400, "Invalid Request", NULL);
}


//增 api/add/{name}/{quantity}
//查 api/product/{id}
//改 api/update/{id}/{new_quantity}
//删 api/delete/{id}
// if($_REQUEST['action']=='add') {
// 	$name = $_REQUEST['name'];
// 	$quantity = $_REQUEST['quantity'];

// 	$db = new DBConnection();
//     $result = $db->addProduct($name,$quantity);
//     echo "add". $name;
// }

if($_REQUEST['action']=="add"&&!empty($_REQUEST['name'])&&!empty($_REQUEST['quantity']))
{
	$name=$_REQUEST['name'];
	$quantity=$_REQUEST['quantity'];
	try{
		$db = new DBConnection();
		$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		$stmt = $db->addProduct($name,$quantity);

	    $insert_res = $stmt->rowCount();
	    echo $insert_res." record(s) added.";
	}catch(PDOException $e){
		echo "Connection failed: " . $e->getMessage();
	}
}



?>