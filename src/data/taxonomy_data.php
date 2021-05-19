<?php

namespace andyp\fetch\data;

class taxonomy_data {


    private $post_obj;
    private $attributes;
    private $config;
    private $terms;
    private $results;


    public function __construct($post_obj, $attributes, $config)
    {
        $this->post_obj = $post_obj;
        $this->attributes = $attributes;
        $this->config = $config;

        $this->run();
    }


    private function run()
    {
        $this->get_all_post_taxonomies();
        $this->loop_taxonomies();
    }


    private function get_all_post_taxonomies()
    {
        $this->taxonomies = get_object_taxonomies( $this->post_obj );
    }


    private function loop_taxonomies()
    {

        foreach($this->taxonomies as $this->loop_taxonomy_key => $this->loop_taxonomy_name)
        {
            $this->get_all_post_terms();
            $this->get_all_post_terms_ACF();
        }
        
    }

    private function get_all_post_terms()
    {
        $this->results[$this->loop_taxonomy_name] = get_the_terms($this->post_obj, $this->loop_taxonomy_name);
    }


    private function get_all_post_terms_ACF()
    {
        if( ! class_exists('ACF') ) { return; }

        foreach ($this->results[$this->loop_taxonomy_name] as $this->loop_term_key => $this->loop_term_object)
        {
            // arrayify & set ACF. (need to arrayify, otherwise WP_TERM won't allow you to add a new ACF array entry because its an object.)
            $this->results[$this->loop_taxonomy_name][$this->loop_term_key] = $this->arrayify($this->results[$this->loop_taxonomy_name][$this->loop_term_key]);
            $this->results[$this->loop_taxonomy_name][$this->loop_term_key]['_acf_'] = $this->get_all_ACF_fields();
            // $this->results[$this->loop_taxonomy_name][$this->loop_term_key]['acf'] = $this->get_all_ACF_field_objects();
        }
    }

    
    private function get_all_ACF_fields()
    {
        return get_fields( $this->loop_term_object );
    }


    private function get_all_ACF_field_objects()
    {
        return get_field_objects( $this->loop_term_object );
    }


    private function arrayify($data)
    {
        $json = json_encode($data);
        return json_decode($json, true);
    }
    
    

    public function get_results()
    {
        return $this->results;
    }

}