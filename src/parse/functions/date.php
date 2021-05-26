<?php

namespace andyp\fetch\parse\functions;

class date
{

    private $results;

    public function __construct($moustache, $value)
    {
        $this->results = $value;

        preg_match('/--date\(\'(.*)\'\)/',$moustache, $new_date_format);

        if (!isset($new_date_format[1])){ return; }
    
        $current_date = strtotime($value);
        $this->results = date($new_date_format[1], $current_date);
    }

    

    public function get_results()
    {
        return $this->results;
    }
    
}