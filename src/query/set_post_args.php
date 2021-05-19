<?php

namespace andyp\fetch\query;

class set_post_args {



    private $attributes;
    private $config;
    private $query_args;



    public function __construct($attributes, $config)
    {
        $this->attributes = $attributes;
        $this->config = $config;
        $this->run();
        
    }



    public function run()
    {
                
        $this->set_defaults();

        if (is_array($this->attributes)){
            $this->query_args = array_merge($this->query_args, $this->attributes);
        }
        
    }


    public function set_defaults()
    {
        $this->query_args['post_type']   = $this->config['post_type'];
        $this->query_args['post_status'] = 'publish';
        $this->query_args['posts_per_page'] = 3;
    }


    public function get_args()
    {
        return $this->query_args;
    }
}