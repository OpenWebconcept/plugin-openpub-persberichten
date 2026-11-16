<?php

class WP_Query
{
    public $query = [];
    public $query_vars = [];
    public $posts = [];
    public $found_posts = 0;
    public $max_num_pages = 0;

    public function __construct($query = '')
    {
        $this->query = $this->query_vars = (array) $query;
    }

    public function get($query_var, $default_value = '')
    {
        return $this->query_vars[$query_var] ?? $default_value;
    }
}
