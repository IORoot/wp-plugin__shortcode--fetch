<?php

namespace andyp\fetch;


/**
 * 
 * Use {{help}} to see ALL fields.
 * 
 * 
 * Data Types
 * --------------
 * 
 * {{type::field::level1::level2::level3--function}}
 * 
 * Types: post, meta, image, taxonomy, extra, help
 * 
 * 
 * 
 * Available Functions
 * --------------
 * 
 * --sanitize
 *
 * 
 * Simple Example:
 * ---------------
 * [tutorial_posts] Show the {{post::post_title}} [/tutorial_posts]
 * 
 * 
 * Add attributes:
 * ---------------
 * [tutorial_posts posts_per_page='10'] Show the {{post::post_title}} [/tutorial_posts]
 * [tutorial_posts post_type='demonstration'] Show the {{post::post_title}} for demonstrations [/tutorial_posts]
 * 
 * 
 * Different content fields:
 * -------------------------
 * [tutorial_posts posts_per_page='1']
 * 
 *      <h2>Post Fields</h2>
 *      {{post::post_title}} 
 *      {{extras::permalink}} 
 * 
 *      <h2>Sanitize Fields to make them like a slug</h2>
 *      {{post::post_title--sanitize}} 
 * 
 *      <h2>Meta Fields</h2>
 *      {{meta::meta_field}} 
 * 
 *      <h2>Image Fields</h2>
 *      {{image::url}} 
 *      {{image::path}} 
 *      {{image::metadata::width}} 
 *      {{image::metadata::sizes::thumbnail::file}} 
 * 
 * [/tutorial_posts]
 * 
 * 
 * Add taxonomy / tag filters:
 * ---------------------------
 * You can change the taxonomy or term in the initial query.
 *  ['tax_query'] =
        [
            'taxonomy' => $taxonomy,
            'field'    => 'slug',
            'terms'    => $term,
        ],
 * [tutorial_posts taxonomy="tutorial_category" term="cat-leaps"] Show the {{post_title}} [/tutorial_posts]
 * 
 * 
 * Content Note:
 * -------------
 * If the post_content contains {{moustaches}} itself, these will NOT be parsed for now.
 * 
 */

class fetch
{

    private $config;
    private $query_args = [];        // Create the arguments to query the DB.
    private $all_posts;              // all posts returned from query.

    /**
     *  1 => [
     *      post => [],
     *      meta => [],
     *      image => [],
     *      taxonomy => [],
     *      extra => [],
     * ],
     * 2 => [
     * ]
     */
    private $results;     

    public $attributes;
    public $content;

    public $new_content;

    public $html;


    public function set_config($config)
    {
        $this->config = $config;
    }


    public function register()
    {
        add_shortcode( 'fetch', [$this, 'run'] );
    }


    public function run($atts = array(), $content = null)
    {

        $this->attributes = $atts;
        $this->content = $content;

        $this->html = '';
        $this->query_args = [];

        $this->set_taxonomy_args();
        $this->set_post_args();
        $this->get_posts();
        $this->loop_posts();

        $this->all();

        $this->parse_content();

        return $this->html;
    }


    /**
     * Looks for 'taxonomy' and 'term' attributes 
     * and adds in a ['tax_query'] with them set.
     * The (array) force is incase of null.
     */
    private function set_taxonomy_args()
    {
        $tax_query = new query\set_taxonomy_args($this->attributes, $this->config);
        $this->query_args = array_merge((array) $this->query_args, $tax_query->get_args());
    }

    /**
     * Sets any other attributes to be query args.
     * post_type, post_status and posts_per_page 
     * are set by default.
     * The (array) force is incase of null.
     */
    private function set_post_args()
    {
        $post_query = new query\set_post_args($this->attributes, $this->config);
        $this->query_args = array_merge((array) $this->query_args, $post_query->get_args());
    }


    /**
     * Get all the post objects from the query.
     * Will return an object, not an array, so
     */
    private function get_posts()
    {
        $this->all_posts = \get_posts($this->query_args);
    }

    private function loop_posts()
    {
        $this->results = [];

        foreach ($this->all_posts as $this->loop_key => $this->loop_post)
        {
            $this->get_post_data();
            $this->get_meta_data();
            $this->get_image_data();
            $this->get_taxonomy_data();
            $this->get_extra_data();
        }
    }


    private function get_post_data()
    {
        $post = new data\post_data($this->loop_post);
        $this->results[$this->loop_key]['post'] = $post->get_results();
    }


    private function get_meta_data()
    {
        $meta = new data\meta_data($this->loop_post);
        $this->results[$this->loop_key]['meta'] = $meta->get_results();
    }


    private function get_image_data()
    {
        $image = new data\image_data($this->loop_post);
        $this->results[$this->loop_key]['image'] = $image->get_results();
    }


    private function get_taxonomy_data()
    {
        $taxonomy = new data\taxonomy_data($this->loop_post, $this->attributes, $this->config);
        $this->results[$this->loop_key]['taxonomy'] = $taxonomy->get_results();
    }


    private function get_extra_data()
    {
        $extra = new data\extra_data($this->loop_post);
        $this->results[$this->loop_key]['extra'] = $extra->get_results();
    }


    private function parse_content()
    {
        if (preg_match('/{{help}}/',$this->content)){ return; }
        $parse = new parse\parse_moustaches($this->results, $this->content);
        $this->html = $parse->get_results();
    }   


    private function all()
    {
        if (!preg_match('/{{help}}/',$this->content)){ return; }
        $this->html = '<pre style="background:#242424; color:#fff; padding:20px; font-size:0.6em;">'.print_r($this->results, true) .'</pre>';
    }

}