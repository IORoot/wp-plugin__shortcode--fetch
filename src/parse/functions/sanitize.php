<?php

namespace andyp\fetch\parse\functions;

class sanitize
{

    private $results;

    public function __construct($moustache, $value)
    {
        $this->results = $value;

        if (strpos($moustache, '--sanitize') !== false)
        {
            $this->results = \sanitize_title($value);
        }

    }

    

    public function get_results()
    {
        return $this->results;
    }
    
}