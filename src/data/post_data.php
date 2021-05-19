<?php

namespace andyp\fetch\data;

class post_data {


    private $post_obj;
    private $results;


    public function __construct( $post_obj)
    {
        $this->post_obj = $post_obj;

        $this->cast_post_to_array();

    }


    private function cast_post_to_array()
    {
        $this->results = (array) $this->post_obj;
    }


    public function get_results()
    {
        return $this->results;
    }


}