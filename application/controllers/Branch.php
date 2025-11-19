<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Branch extends Admin_Controller 
{
	public function __construct()
	{
		parent::__construct();

		$this->not_logged_in();

		$this->data['page_title'] = 'Branch';

		$this->load->model('model_products');
		$this->load->model('model_brands');
		$this->load->model('model_category');
		$this->load->model('model_stores');
		$this->load->model('model_attributes');
        $this->load->model('model_printout');
        $this->load->model('model_branch');
        $this->load->helper('url');
        $this->load->helper('file');
	}

    /* 
    * It only redirects to the manage product page
    */
	public function jakarta()
	{
        if(!in_array('viewProduct', $this->permission)) {
            redirect('dashboard', 'refresh');
        }

		$this->render_template('branch/jakarta', $this->data);	
	}

	public function fetchProductJakarta()
	{
		$result = array('data' => array());

		$data = $this->model_branch->getJakartaData();

		foreach ($data as $key => $value) {

            // $vendor_data = $this->model_stores->getStoresData($value['vendor_id']);
            $category_data = $this->model_category->getCategoryDatabyID($value['category_id']);

			$brand_id = json_decode($value['brand_id']);
			$brand_data = $this->model_brands->getBrandDatabyID($brand_id);

			$branch_data = $this->model_branch->getBranchbyID($value['branch_id']);

			$department_data = $this->model_groups->getGroupDatabyID($value['department_id']);
			if ($value['image'] != "<p>You did not select a file to upload.</p>"){
				$img = '<img src="'.base_url($value['image']).'" alt="'.$value['name'].'" class="img-circle" width="50" height="50" />';
			}else{
				$img = '<img src="'.base_url('assets/images/no-image.jpeg').'" class="img-circle" width="50" height="50" />';
			}
			if ($value['condition'] == 1){
				$condition = '<span class="label label-success">Good</span>';
			}elseif ($value['condition'] == 2){
				$condition = '<span class="label label-warning">Maintenance</span>';
			}elseif ($value['condition'] == 3){
				$condition = '<span class="label label-danger">Broken</span>';
			}else{
				$condition = '<span class="label" style="background-color: #000000!important">Dispose</span>';
			}

			// button
            $buttons = '';
            if(in_array('updateProduct', $this->permission)) {
    			$buttons .= '<a href="'.base_url('products/update/'.$value['id']).'" class="btn btn-default"><i class="fa fa-pencil"></i></a>';
            }

			if(in_array('viewProduct', $this->permission)){
				$buttons .= '<button id="btnView" type="button" class="btn btn-default" onclick="viewFunc('.$value['id'].')" data-toggle="modal" data-target="#viewModal"
				data-category = "'.$category_data['name'].'"
				data-brand = "'.$brand_data['name'].'"
				data-branch = "'.$branch_data['name'].'"
		 		data-dept = "'.$department_data['group_name'].'"
				><i class="fa fa-eye"></i></button>';
			}

            if(in_array('deleteProduct', $this->permission)) { 
    			$buttons .= ' <button type="button" class="btn btn-default" onclick="removeFunc('.$value['id'].')" data-toggle="modal" data-target="#removeModal"><i class="fa fa-trash"></i></button>';
            }
            
			$result['data'][$key] = array(
				$img,
				$value['name'],
				$value['code'],
				$category_data['name'],
				$value['user'],
				$value['price'],
                $value['dateBuy'],
                $value['serial_number'],
                // $vendor_data['name'],
				$condition,
				$buttons
			);
			$this->data['id'] = $value['id'];
		} // /foreach
        
		echo json_encode($result);
	}

	// ===========================================================================
	//								MEDAN
	// ===========================================================================
	
	public function medan()
	{
		if(!in_array('viewProduct', $this->permission)) {
			redirect('dashboard', 'refresh');
        }
		
		$this->render_template('branch/medan', $this->data);	
	}

	public function fetchProductMedan()
	{
		$result = array('data' => array());

		$data = $this->model_branch->getMedanData();

		foreach ($data as $key => $value) {

			$category_data = $this->model_category->getCategoryDatabyID($value['category_id']);

			$brand_id = json_decode($value['brand_id']);
			$brand_data = $this->model_brands->getBrandDatabyID($brand_id);

			$branch_data = $this->model_branch->getBranchbyID($value['branch_id']);

			$department_data = $this->model_groups->getGroupDatabyID($value['department_id']);
			$img = '<img src="'.base_url($value['image']).'" alt="'.$value['name'].'" class="img-circle" width="50" height="50" />';
			
			if ($value['condition'] == 1){
				$condition = '<span class="label label-success">Good</span>';
			}elseif ($value['condition'] == 2){
				$condition = '<span class="label label-warning">Maintenance</span>';
			}elseif ($value['condition'] == 3){
				$condition = '<span class="label label-danger">Broken</span>';
			}else{
				$condition = '<span class="label" style="background-color: #000000!important">Dispose</span>';
			}

			// button
			$buttons = '';
			if(in_array('updateProduct', $this->permission)) {
				$buttons .= '<a href="'.base_url('products/update/'.$value['id']).'" class="btn btn-default"><i class="fa fa-pencil"></i></a>';
			}

			if(in_array('viewProduct', $this->permission)){
				$buttons .= '<button id="btnView" type="button" class="btn btn-default" onclick="viewFunc('.$value['id'].')" data-toggle="modal" data-target="#viewModal"
				data-category = "'.$category_data['name'].'"
				data-brand = "'.$brand_data['name'].'"
				data-branch = "'.$branch_data['name'].'"
		 		data-dept = "'.$department_data['group_name'].'"
				><i class="fa fa-eye"></i></button>';
			}

			

			if(in_array('deleteProduct', $this->permission)) { 
				$buttons .= ' <button type="button" class="btn btn-default" onclick="removeFunc('.$value['id'].')" data-toggle="modal" data-target="#removeModal"><i class="fa fa-trash"></i></button>';
			}
			
			$result['data'][$key] = array(
				$img,
				$value['name'],
				$value['code'],
				$category_data['name'],
				$value['user'],
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



	// ===========================================================================
	//								SURABAYA
	// ===========================================================================
	
	public function surabaya()
	{
		if(!in_array('viewProduct', $this->permission)) {
            redirect('dashboard', 'refresh');
        }
		
		$this->render_template('branch/surabaya', $this->data);	
	}

	public function fetchProductSurabaya()
	{
		$result = array('data' => array());

		$data = $this->model_branch->getSurabayaData();

		foreach ($data as $key => $value) {

			$category_data = $this->model_category->getCategoryDatabyID($value['category_id']);

			$brand_id = json_decode($value['brand_id']);
			$brand_data = $this->model_brands->getBrandDatabyID($brand_id);

			$branch_data = $this->model_branch->getBranchbyID($value['branch_id']);

			$department_data = $this->model_groups->getGroupDatabyID($value['department_id']);
			$img = '<img src="'.base_url($value['image']).'" alt="'.$value['name'].'" class="img-circle" width="50" height="50" />';
			
			if ($value['condition'] == 1){
				$condition = '<span class="label label-success">Good</span>';
			}elseif ($value['condition'] == 2){
				$condition = '<span class="label label-warning">Maintenance</span>';
			}elseif ($value['condition'] == 3){
				$condition = '<span class="label label-danger">Broken</span>';
			}else{
				$condition = '<span class="label" style="background-color: #000000!important">Dispose</span>';
			}

			// button
			$buttons = '';
			if(in_array('updateProduct', $this->permission)) {
				$buttons .= '<a href="'.base_url('products/update/'.$value['id']).'" class="btn btn-default"><i class="fa fa-pencil"></i></a>';
			}

			if(in_array('viewProduct', $this->permission)){
				$buttons .= '<button id="btnView" type="button" class="btn btn-default" onclick="viewFunc('.$value['id'].')" data-toggle="modal" data-target="#viewModal"
				data-category = "'.$category_data['name'].'"
				data-brand = "'.$brand_data['name'].'"
				data-branch = "'.$branch_data['name'].'"
		 		data-dept = "'.$department_data['group_name'].'"
				><i class="fa fa-eye"></i></button>';
			}

			if(in_array('deleteProduct', $this->permission)) { 
				$buttons .= ' <button type="button" class="btn btn-default" onclick="removeFunc('.$value['id'].')" data-toggle="modal" data-target="#removeModal"><i class="fa fa-trash"></i></button>';
			}
			
			$result['data'][$key] = array(
				$img,
				$value['name'],
				$value['code'],
				$category_data['name'],
				$value['user'],
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
}