<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Supermarket extends CI_Controller {

	public function index()
	{
		$this->load->view('supermarket_checkout');
	}

    // Product Autocomplete
    function get_autocomplete(){
        if (isset($_GET['term'])) {
            $result = $this->supermarket_model->search_product($_GET['term']);
            if (count($result) > 0) {
            foreach ($result as $row)
                $arr_result[] = $row->item_name;
                echo json_encode($arr_result);
            }
        }
    }
    // Get product details
    function get_product_details(){
        if (isset($_POST['title'])) {
            $result = $this->supermarket_model->get_product_details($_POST['title']);
            if (count($result) > 0) {
                echo json_encode($result);
            }
        }
    }
    // Check the special price for this item
    function check_special_price(){
        if (isset($_POST['item_id'])) {
            $result = $this->supermarket_model->check_special_price($_POST['item_id'],$_POST['item_quantity']);
            if ($result) {
                echo json_encode($result);
            }
        }
    }
}
