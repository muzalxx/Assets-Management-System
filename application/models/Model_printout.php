<?php 

class Model_printout extends CI_Model
{
    public function printQR()
	{
		$data = $this->model_products->getProductData(null);
		$html = '<!DOCTYPE html>
		<html lang="en">
		<head>
			<meta charset="UTF-8">
			<meta name="viewport" content="width=device-width, initial-scale=1.0">
			<title>Generate QR</title>
		</head>
		<body>';

		$data = $this->model_products->getProductData();
		foreach ($data as $key){
			$html .= '<img src='. base_url("validation/uploads/QR/". $key["code"] .".png") .'
			alt="" width="150" heigh="150"><br /><p>'. $key["code"] .'</p>';
    	};
			
		$html .= '</body>
		</html>';
	}
}
