<?php

namespace andyp\fetch\data;

class meta_data {


    private $post_obj;
    private $results;


    public function __construct($post_obj)
    {
        $this->post_obj = $post_obj;

        $this->get_post_metadata();
    }


    private function get_post_metadata()
    {
        
        $this->results = get_post_meta($this->post_obj->ID);

    }

    public function get_results()
    {
        return $this->results;
    }


}