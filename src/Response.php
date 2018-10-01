<?php

namespace KyleBlanker\Omdb;

class Response
{
    protected $results;
    protected $count;
    protected $page;

    public function __construct(string $content,int $page)
    {
        $results = json_decode($content);
        if(property_exists($results,'Search')) {
            $this->results = $results->Search;
            $this->count = (int) $results->totalResults;
        } else {
            $this->results = $results;
            $this->count = 1;
        }

        $this->page = $page;
    }

    public function results()
    {
        return $this->results;
    }

    public function totalResults()
    {
        return $this->count;
    }

    public function page()
    {
        return $this->page;
    }
}