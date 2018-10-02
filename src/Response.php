<?php

namespace KyleBlanker\Omdb;

class Response
{
    /**
     * @var mixed $results Results of the response
     */
    protected $results;

    /**
     * @var int $count Count of the results
     */
    protected $count = 1;

    /**
     * @var int $page Current page of the results
     */
    protected $page = 1;

    public function __construct(string $content,int $page)
    {
        $results = json_decode($content);
        if(property_exists($results,'Search')) {
            $this->results = $results->Search;
            $this->count = (int) $results->totalResults;
        } else {
            $this->results = [$results];
        }

        $this->page = $page;
    }

    /**
     * Returns the results of the response
     * 
     * @return mixed
     */
    public function results()
    {
        return $this->results;
    }

    /**
     * Returns the count
     * 
     * @return int
     */
    public function totalResults(): int
    {
        return $this->count;
    }

    /**
     * Returns the current page
     * 
     * @return int
     */
    public function page(): int
    {
        return $this->page;
    }
}