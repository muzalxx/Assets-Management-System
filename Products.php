<?php

defined('BASEPATH') OR exit('No direct script access allowed');
use chillerlan\QRCode\{QRCode, QROptions};
use chillerlan\QRCode\Common\EccLevel;
use chillerlan\QRCode\Data\QRMatrix;
use chillerlan\QRCode\Output\{QRGdImage, QRCodeOutputException};
use chillerlan\QRCode\Output\QROutputInterface;

class Products extends Admin_Controller 
{
	public function __construct()
	{
		parent::__construct();

		$this->not_logged_in();

		$this->data['page_title'] = 'Products';

		$this->load->model('model_products');
		$this->load->model('model_brands');
		$this->load->model('model_category');
		$this->load->model('model_stores');
		$this->load->model('model_attributes');
        $this->load->model('model_printout');
        $this->load->model('model_branch');
        $this->load->model('model_groups');


        $this->load->helper('url');
        $this->load->helper('file');
	}

    /* 
    * It only redirects to the manage product page
    */
	public function index()
	{
        if(!in_array('viewProduct', $this->permission)) {
            redirect('dashboard', 'refresh');
        }

		$this->render_template('products/index', $this->data);	
	}

    /*
    * It Fetches the products data from the product table 
    * this function is called from the datatable ajax function
    */
	public function fetchProductData()
	{
		$result = array('data' => array());

		$data = $this->model_products->getProductData();

		foreach ($data as $key => $value) {

            // $vendor_data = $this->model_stores->getStoresData($value['vendor_id']);
            $category_data = $this->model_category->getCategoryData($value['category_id']);
			// button
            $buttons = '';
            if(in_array('updateProduct', $this->permission)) {
    			$buttons .= '<a href="'.base_url('products/update/'.$value['id']).'" class="btn btn-default"><i class="fa fa-pencil"></i></a>';
            }

            if(in_array('deleteProduct', $this->permission)) { 
    			$buttons .= ' <button type="button" class="btn btn-default" onclick="removeFunc('.$value['id'].')" data-toggle="modal" data-target="#removeModal"><i class="fa fa-trash"></i></button>';
            }
			

			$img = '<img src="'.base_url($value['image']).'" alt="'.$value['name'].'" class="img-circle" width="50" height="50" />';
            
            if ($value['condition'] == 1){
                $condition = '<span class="label label-success">Available</span>';
            }elseif ($value['condition'] == 2){
                $condition = '<span class="label label-warning">Maintenance</span>';
            }elseif ($value['condition'] == 3){
                $condition = '<span class="label label-danger">Broken</span>';
            }else{
                $condition = '<span class="label" style="background-color: #000000!important">Dispose</span>';
            }
            
			$result['data'][$key] = array(
				$img,
				$value['name'],
				$value['code'],
				$category_data['name'],
				$value['price'],
                $value['dateBuy'],
                $value['serial_number'],
                // $vendor_data['name'],
				$condition,
				$buttons
			);
		} // /foreach

		echo json_encode($result);
	}	

    /*
    * If the validation is not valid, then it redirects to the create page.
    * If the validation for each input field is valid then it inserts the data into the database 
    * and it stores the operation message into the session flashdata and display on the manage product page
    */
	public function create()
	{
		if(!in_array('createProduct', $this->permission)) {
            redirect('dashboard', 'refresh');
        }

		$this->form_validation->set_rules('asset_name', 'Asset name', 'trim|required');
		$this->form_validation->set_rules('asset_code', 'Asset code', 'trim|required');
		$this->form_validation->set_rules('price', 'Price', 'trim|required');
		$this->form_validation->set_rules('date_buy', 'Date buy', 'trim|required');
        $this->form_validation->set_rules('user', 'User name', 'trim|required');
        $this->form_validation->set_rules('vendor', 'Vendor', 'trim|required');
		$this->form_validation->set_rules('condition', 'Condition', 'trim|required');
		$this->form_validation->set_rules('branch', 'Branch', 'trim|required');
		$this->form_validation->set_rules('department', 'Department', 'trim|required');
		
	
        if ($this->form_validation->run() == TRUE) {
            // true case
        	$upload_image = $this->upload_image();

        	$data = array(
        		'name' => $this->input->post('asset_name'),
        		'code' => $this->input->post('asset_code'),
        		'price' => $this->input->post('price'),
        		'dateBuy' => $this->input->post('date_buy'),
        		'serial_number' => $this->input->post('sn'),
        		'warranty' => $this->input->post('warranty'),
                'user' => $this->input->post('user'),
        		'image' => $upload_image,
        		'description' => $this->input->post('description'),
        		'attribute_value_id' => json_encode($this->input->post('attributes_value_id')),
        		'brand_id' => json_encode($this->input->post('brands')),
        		'category_id' => $this->input->post('category'),
                'vendor_id' => $this->input->post('vendor'),
                'branch_id' => $this->input->post('branch'),
                'department_id' => $this->input->post('department'),
        		'condition' => $this->input->post('condition'),
        	);

        	$create = $this->model_products->create($data);
        	if($create == true) {
        		$this->session->set_flashdata('success', 'Successfully created');
        		redirect('products/', 'refresh');
        	}
        	else {
        		$this->session->set_flashdata('errors', 'Error occurred!!');
        		redirect('products/create', 'refresh');
        	}
        }
        else {
            // false case

        	// attributes 
        	// $attribute_data = $this->model_attributes->getActiveAttributeData();

        	// $attributes_final_data = array();
        	// foreach ($attribute_data as $k => $v) {
        	// 	$attributes_final_data[$k]['attribute_data'] = $v;

        	// 	$value = $this->model_attributes->getAttributeValueData($v['id']);

        	// 	$attributes_final_data[$k]['attribute_value'] = $value;
        	// }

			$this->data['brands'] = $this->model_brands->getActiveBrands();        	
			$this->data['category'] = $this->model_category->getActiveCategroy();        	
			$this->data['vendor'] = $this->model_stores->getActiveStore();       
            $this->data['branch'] = $this->model_branch->getBranch();
            $this->data['department'] = $this->model_groups->getGroupInformation();
            
            $this->render_template('products/create', $this->data);
        }	
	}

    /*
    * This function is invoked from another function to upload the image into the assets folder
    * and returns the image path
    */
	public function upload_image()
    {
    	// assets/images/product_image
        $config['upload_path'] = 'assets/images/product_image';
        $config['file_name'] =  uniqid();
        $config['allowed_types'] = 'gif|jpg|png';
        $config['max_size'] = '1000';

        // $config['max_width']  = '1024';s
        // $config['max_height']  = '768';

        $this->load->library('upload', $config);
        if ( ! $this->upload->do_upload('product_image'))
        {
            $error = $this->upload->display_errors();
            return $error;
        }
        else
        {
            $data = array('upload_data' => $this->upload->data());
            $type = explode('.', $_FILES['product_image']['name']);
            $type = $type[count($type) - 1];
            
            $path = $config['upload_path'].'/'.$config['file_name'].'.'.$type;
            return ($data == true) ? $path : false;            
        }
    }

    /*
    * If the validation is not valid, then it redirects to the edit product page 
    * If the validation is successfully then it updates the data into the database 
    * and it stores the operation message into the session flashdata and display on the manage product page
    */
	public function update($product_id)
	{      
        if(!in_array('updateProduct', $this->permission)) {
            redirect('dashboard', 'refresh');
        }

        if(!$product_id) {
            redirect('dashboard', 'refresh');
        }

        $this->form_validation->set_rules('asset_name', 'Asset name', 'trim|required');
		$this->form_validation->set_rules('asset_code', 'Asset code', 'trim|required');
		$this->form_validation->set_rules('price', 'Price', 'trim|required');
		$this->form_validation->set_rules('date_buy', 'Date buy', 'trim|required');
        $this->form_validation->set_rules('user', 'User name', 'trim|required');
        $this->form_validation->set_rules('vendor', 'Vendor', 'trim|required');
		$this->form_validation->set_rules('condition', 'Condition', 'trim|required');
		$this->form_validation->set_rules('branch', 'Branch', 'required');
		$this->form_validation->set_rules('department', 'Department', 'required');

        if ($this->form_validation->run() == TRUE) {
            // true case
            
            if($_FILES['product_image']['size'] > 0) {
                $upload_image = $this->upload_image();
                $upload_image = array('image' => $upload_image);
                
                $this->model_products->update($upload_image, $product_id);
            }

            $data = array(
        		'name' => $this->input->post('asset_name'),
        		'code' => $this->input->post('asset_code'),
        		'price' => $this->input->post('price'),
        		'dateBuy' => $this->input->post('date_buy'),
        		'serial_number' => $this->input->post('sn'),
        		'warranty' => $this->input->post('warranty'),
                'user' => $this->input->post('user'),
        		'image' => $upload_image,
        		'description' => $this->input->post('description'),
        		'attribute_value_id' => json_encode($this->input->post('attributes_value_id')),
        		'brand_id' => json_encode($this->input->post('brands')),
        		'category_id' => $this->input->post('category'),
                'vendor_id' => $this->input->post('vendor'),
                'branch_id' => $this->input->post('branch'),
                'department_id' => $this->input->post('department'),
        		'condition' => $this->input->post('condition'),
        	);

            

            $update = $this->model_products->update($data, $product_id);
            if($update == true) {
                $this->session->set_flashdata('success', 'Successfully updated');
                redirect('products/', 'refresh');
            }
            else {
                $this->session->set_flashdata('errors', 'Error occurred!!');
                redirect('products/update/'.$product_id, 'refresh');
            }
        }
        else {
            // // attributes 
            // $attribute_data = $this->model_attributes->getActiveAttributeData();

            // $attributes_final_data = array();
            // foreach ($attribute_data as $k => $v) {
            //     $attributes_final_data[$k]['attribute_data'] = $v;

            //     $value = $this->model_attributes->getAttributeValueData($v['id']);

            //     $attributes_final_data[$k]['attribute_value'] = $value;
            // }
            
            // false case
            $this->data['brands'] = $this->model_brands->getActiveBrands();        	
			$this->data['category'] = $this->model_category->getActiveCategroy();        	
			$this->data['vendor'] = $this->model_stores->getActiveStore();       
            $this->data['branch'] = $this->model_branch->getBranch();
            $this->data['department'] = $this->model_groups->getGroupInformation();  

            $product_data = $this->model_products->getProductData($product_id);
            $this->data['product_data'] = $product_data;
            $this->render_template('products/edit', $this->data); 
        }   
	}

    /*
    * It removes the data from the database
    * and it returns the response into the json format
    */
	public function remove()
	{
        if(!in_array('deleteProduct', $this->permission)) {
            redirect('dashboard', 'refresh');
        }
        
        $product_id = $this->input->post('product_id');

        $response = array();
        if($product_id) {
            $delete = $this->model_products->remove($product_id);
            if($delete == true) {
                $response['success'] = true;
                $response['messages'] = "Successfully removed"; 
            }
            else {
                $response['success'] = false;
                $response['messages'] = "Error in the database while removing the product information";
            }
        }
        else {
            $response['success'] = false;
            $response['messages'] = "Refersh the page again!!";
        }

        echo json_encode($response);
	}

    public function generateQR()
    {
        if(!in_array('deleteProduct', $this->permission)) {
            redirect('dashboard', 'refresh');
        }
        $data = $this->model_products->getProductData(null);
		$html_body = '<!DOCTYPE html>
		<html lang="en">
		<head>
        <style>
        .flex-container {
          display: flex;
          flex-wrap: wrap;
        }
        .flex-container > div {
          width: 100px;
          margin: 20px;
          line-height: 75px;
        }
        div > p{
            margin-top: -30px;
            font-size: 19px;
            text-align: center;
        }
        </style>
		</head>
		<body>
            <div class="flex-container">';

		$data = $this->model_products->getProductData();
		foreach ($data as $key){
			$html_body .= '<div><img src='. FCPATH .'validation/uploads/QR/'. $key["code"] .'.png
			alt="" width="150" heigh="150"><p>'. $key["code"] .'</p></div>';
    	};
			
		$html_body .= '</div></body>
		</html>';

        $path_file = FCPATH.'/validation/uploads/generate_QR.pdf';
        $mpdf = new \Mpdf\Mpdf();
        $mpdf->WriteHTML($html_body, );
        $mpdf->OutputFile($path_file);
        $this->output
        ->set_content_type('application/pdf')
        ->set_output(file_get_contents($path_file));
    }

    public function QR()
    {
        $options = new QROptions([
            'version'             => 5,
            'eccLevel'            => EccLevel::H,
            'imageBase64'         => false,
            'addLogoSpace'        => true,
            'logoSpaceWidth'      => 14,
            'logoSpaceHeight'     => 13,
            'scale'               => 6,
            'imageTransparent'    => false,
            'drawCircularModules' => true,
            'circleRadius'        => 0.49,
            'keepAsSquare'        => [QRMatrix::M_FINDER, QRMatrix::M_FINDER_DOT],
            'outputType'          => QROutputInterface::GDIMAGE_PNG,
        ]);
        $path_logo = FCPATH.'/validation/uploads/company.png';
        $data = $this->model_products->getProductData();
        foreach($data as $key)
        {
            $qrcode = new QRCode($options);
            $path_file = FCPATH.'/validation/uploads/QR/'.$key['code'].'.png';
            
            $qrcode->addByteSegment('asset.projectit-esg.com/?code='.$key['code']);

            $qrOutputInterface = new QRImageWithLogo($options, $qrcode->getMatrix());
            // dump the output, with an additional logo
            // the logo could also be supplied via the options, see the svgWithLogo example
            $qrOutputInterface->dump($path_file, $path_logo);
        }

        $this->load->view('products/generateQR');
        // $this->output
        // ->set_content_type('image/png')
        // ->set_output(file_get_contents($path_file));
        // $matrix = $qrOutputInterface->dump(null, __DIR__.'/company.png');
        
        // $qr = new QRCode($options);
        // $qr->renderMatrix($matrix, null);
        // echo $qr;
        
    }
    
    public function print()
    {
        if(!in_array('deleteProduct', $this->permission)) {
            redirect('dashboard', 'refresh');
        }
        // $html = '<h1>Hello world</h1>';
        //$load = $this->view('products/generateQR');
        $path_file = FCPATH.'/validation/uploads/assets_data.pdf';
        $mpdf = new \Mpdf\Mpdf();
        $mpdf->WriteHTML('<h1> Print Data </h1><br \><p>Ini paragraf</p>');
        $mpdf->OutputFile($path_file);
        $this->output
        ->set_content_type('application/pdf')
        ->set_output(file_get_contents($path_file));
    }
}

class QRImageWithLogo extends QRGdImage{

	/**
	 * @param string|null $file
	 * @param string|null $logo
	 *
	 * @return string
	 * @throws \chillerlan\QRCode\Output\QRCodeOutputException
	 */
	public function dump(string $file = null, string $logo = null):string{
		// set returnResource to true to skip further processing for now
		$this->options->returnResource = true;

		// of course, you could accept other formats too (such as resource or Imagick)
		// I'm not checking for the file type either for simplicity reasons (assuming PNG)
		if(!is_file($logo) || !is_readable($logo)){
			throw new QRCodeOutputException('invalid logo');
		}

		// there's no need to save the result of dump() into $this->image here
		parent::dump($file);

		$im = imagecreatefrompng($logo);

		// get logo image size
		$w = imagesx($im);
		$h = imagesy($im);

		// set new logo size, leave a border of 1 module (no proportional resize/centering)
		$lw = (($this->options->logoSpaceWidth - 2) * $this->options->scale);
		$lh = (($this->options->logoSpaceHeight - 2) * $this->options->scale);

		// get the qrcode size
		$ql = ($this->matrix->size() * $this->options->scale);

		// scale the logo and copy it over. done!
		imagecopyresampled($this->image, $im, (($ql - $lw) / 2), (($ql - $lh) / 2), 0, 0, $lw, $lh, $w, $h);

		$imageData = $this->dumpImage();

		$this->saveToFile($imageData, $file);

		if($this->options->imageBase64){
			$imageData = $this->toBase64DataURI($imageData, 'image/'.$this->options->outputType);
		}

		return $imageData;
	}

}