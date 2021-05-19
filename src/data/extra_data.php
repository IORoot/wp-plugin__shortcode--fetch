<?php

namespace andyp\fetch\data;

class extra_data {

    private $post_obj;
    private $results;


    public function __construct($post_obj)
    {
        $this->post_obj = $post_obj;

        $this->get_permalink();
    }


    private function get_permalink()
    {
        $this->results['permalink']  = get_permalink($this->post_obj->ID);
    }


    public function get_results()
    {
        return $this->results;
    }

}