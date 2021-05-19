<?php

namespace andyp\fetch\parse;

class parse_moustaches
{

    private $query_results;
    private $content;

    private $content_moustaches;
    private $loop_key;
    private $loop_post;

    private $sanitize_on;
    private $loop_moustache_key;
    private $loop_moustache_field;
    private $array_path_for_moustache_value;
    private $moustache_value;

    private $results;



    public function __construct($query_results, $content)
    {
        $this->query_results = $query_results;
        $this->content = $content;
        $this->run();
    }



    
    private function run()
    {
        $this->get_content_moustaches();
        $this->loop_query_results();
    }



    private function get_content_moustaches()
    {
        preg_match_all('/{{(.*?)}}/', $this->content, $this->content_moustaches);   
    }



    private function loop_query_results()
    {

        foreach ($this->query_results as $this->loop_key => $this->loop_post)
        {
            // start by copying the content "template" into the results.
            $this->loop_result[$this->loop_key] = $this->content;
            
            // now replace any moustaches in that template.
            $this->replace_moustaches();

            // replace content template with all results with values replaced
            $this->results .= $this->loop_result[$this->loop_key];

            // run through a second time because the post_content field may contain {{moustaches}}
            // that won't be replaced the first time.
            // $this->html .= $this->replace_moustaches($first_pass);
        }
    }


    private function replace_moustaches()
    {

        foreach ($this->content_moustaches[1] as $this->loop_moustache_key => $this->loop_moustache_field)
        {

            $this->explode_moustaches();

            $this->get_moustache_value();

            $this->sanitize();

            $this->replace_moustache_with_value();
        }
    }



    private function explode_moustaches()
    {
        $removed_minus_minus_function = preg_replace('/--.*/','', $this->loop_moustache_field);
        $this->array_path_for_moustache_value = explode('::', $removed_minus_minus_function);
    }




    private function sanitize()
    {
        $sanitize = new functions\sanitize($this->loop_moustache_field, $this->moustache_value);
        $this->moustache_value = $sanitize->get_results();
    }





    private function get_moustache_value()
    {
        $this->moustache_value = $this->query_results[$this->loop_key];
        
        foreach ($this->array_path_for_moustache_value as $level_name)
        {
            if (!array_key_exists($level_name,$this->moustache_value)){ 
                $this->moustache_value = "<br/>[Error. Array Key \"".$level_name."\" not found in {{".$this->loop_moustache_field."}} moustaches.]"; 
                continue;
            }

            $this->moustache_value = $this->moustache_value[$level_name];
        }

    }


    private function replace_moustache_with_value()
    {
        $this->loop_result[$this->loop_key] = str_replace($this->content_moustaches[0][$this->loop_moustache_key], $this->moustache_value, $this->loop_result[$this->loop_key]);
    }

    
    public function get_results()
    {
        return $this->results;
    }

}