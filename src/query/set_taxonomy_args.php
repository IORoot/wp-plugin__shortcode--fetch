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

        $this->strings_to_arrays();
        $this->generate_single_tax_query();
        $this->generate_multiple_tax_query();
        
    }

    public function get_args()
    {
        return $this->query_args;
    }


    private function strings_to_arrays()
    {
        if (!is_array($this->attributes)){ return; }

        foreach ($this->attributes as $key => $attribute)
        {
            if( strpos($attribute, ',') !== false ) {
                $this->attributes[$key] = explode(',', $attribute);
            }
        }
    }


    private function generate_single_tax_query()
    {
        if(!is_string($this->attributes["taxonomy"])){ return; }

        $this->query_args['tax_query'] = [
            [
                'taxonomy' => $this->attributes['taxonomy'],
                'field'    => 'slug',
                'terms'    => $this->attributes['term'],
            ],
        ];
    }


    private function generate_multiple_tax_query()
    {
        if(is_string($this->attributes["taxonomy"])){ return; }

        $new_query['relation'] = 'OR';

        foreach ($this->attributes["taxonomy"] as $loop_taxonomy)
        {
            $new_query[] =
                [
                    'taxonomy' => $loop_taxonomy,
                    'field'    => 'slug',
                    'terms'    => $this->attributes['term'],
                ];
        }

        $this->query_args['tax_query'] = $new_query;

    }
}