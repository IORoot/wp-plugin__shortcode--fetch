<?php

namespace andyp\fetch\query;

class set_taxonomy_args {



    private $attributes;
    private $config;
    private $query_args = [];



    public function __construct($attributes, $config)
    {
        $this->attributes = $attributes;
        $this->config = $config;
        $this->run();
    }



    public function run()
    {

        if (!array_key_exists('taxonomy', $this->attributes)){ return; }
        if (!array_key_exists('term', $this->attributes)){ return; }

        $this->query_args['tax_query'] = [
            [
                'taxonomy' => $this->attributes['taxonomy'],
                'field'    => 'slug',
                'terms'    => $this->attributes['term'],
            ],
        ];

        unset($this->attributes['taxonomy']);
        unset($this->attributes['term']);
        
    }

    public function get_args()
    {
        return $this->query_args;
    }

}