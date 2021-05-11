<?php
class Supermarket_model extends CI_Model{

    //Search product using autocomplete
    function search_product($title){
        try {
        $this->db->like('item_name', $title , 'both');
        $this->db->order_by('item_name', 'ASC');
        return $this->db->get('product_details')->result();
        }catch (Exception $e) {
            log_message('error: ',$e->getMessage());
            return;
        }
    }
    
    // Get product details using product name
    function get_product_details($title){
        try{
        $this->db->where('item_name', $title);
        return $this->db->get('product_details')->result();
        }catch (Exception $e) {
            log_message('error: ',$e->getMessage());
            return;
        }
    }

    function check_special_price($item_id,$item_quantity){
        try{
        $this->db->where('id', $item_id);
        $result=$this->db->get('product_details')->result();
        if(count($result) > 0)
        {
            foreach ($result as $row)
            {
                $apply_special= $row->apply_special;
                $unit_price=$row->unit_price;                
            }
            $response_arr=array();
            if($apply_special==1){
                $this->db->where('item_id', $item_id);
                $this->db->where('special_unit <=', $item_quantity);
                $result_set=$this->db->get('special_price')->result();
                if(count($result_set) > 0){
                    if(count($result_set)==1){
                        $special_unit=$result_set[0]->special_unit;
                        $special_price= $result_set[0]->special_price;
                        $special_slot= floor($item_quantity / $special_unit);
                        $special_slot_total= $special_slot * $special_unit;
                        $remaining_quantity= $item_quantity- $special_slot_total;
                        if($remaining_quantity > 0){
                            $response_arr['special_price']= $special_slot_total." * ".$special_price .", ".$remaining_quantity." * ". $unit_price;
                            $response_arr['unit_price']= $unit_price;
                            $response_arr['price']= $special_slot_total * $special_price + $remaining_quantity * $unit_price;
                        }else{
                            $response_arr['special_price']= $special_slot_total." * ".$special_price;
                            $response_arr['unit_price']= $unit_price;
                            $response_arr['price']= $special_slot_total * $special_price;
                        }
                        
                    }

                }else{
                    $response_arr['special_price']= 0;
                    $response_arr['unit_price']= $unit_price;
                    $response_arr['price']= $unit_price * $item_quantity;
                }

            }else{
                $response_arr['special_price']= 0;
                $response_arr['unit_price']= $unit_price;
                $response_arr['price']= $unit_price * $item_quantity;
            }
            return $response_arr;
        }
    }catch (Exception $e) {
            log_message('error: ',$e->getMessage());
            return;
        }
    }
 
}