<?php

namespace andyp\fetch\data;

class image_data {

    private $post_obj;
    private $results;


    public function __construct($post_obj)
    {
        $this->post_obj = $post_obj;

        $this->get_image_data();

    }


    private function get_image_data()
    {
        $this->results['id']  = get_post_thumbnail_id($this->post_obj);
        $this->results['url'] = get_the_post_thumbnail_url($this->post_obj);
        $this->results['path'] = str_replace(get_site_url(), '', $this->results['url']);
        $this->results['dir'] = dirname($this->results['path']);
        $this->results['filename'] = basename($this->results['path']);
        $this->results['metadata'] = wp_get_attachment_metadata($this->results['id']);
    }




    public function get_results()
    {
        return $this->results;
    }
}