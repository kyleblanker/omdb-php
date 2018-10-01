<?php

namespace KyleBlanker\Omdb;

use Exception;
use GuzzleHttp\Client as GuzzleHttpClient;
use KyleBlanker\Omdb\Exceptions\AuthException;
use KyleBlanker\Omdb\Exceptions\RequestException;
use KyleBlanker\Omdb\Exceptions\WrongTypeException;

class Client
{
    /**
     * The main api url
     */
    const API_URL = 'www.omdbapi.com';

    /**
     * The poster api url
     */
    const IMAGE_API_URL = 'img.omdbapi.com';

    /**
     * The omdb api key that's required for any request
     * 
     * @var string $apiKey
     */
    protected $apiKey;

    /**
     * The guzzle http client
     * 
     * @var GuzzleHttpClient $httpClient
     */
    protected $httpClient;

    /**
     * Query array that will be used with the guzzle http client
     * 
     * @var array $query
     */
    protected $query = [];

    public function __construct(string $apiKey)
    {
        $this->apiKey = $apiKey;
        $this->httpClient = new GuzzleHttpClient(['http_errors' => false]);
        $this->baseQuery();
    }

    /**
     * Sets the imdb id query parameter
     * 
     * @return Response
     */
    public function getByImdbId(string $id): Response
    {
        $this->query['i'] = $id;

        return $this->get();
    }

    /**
     * The year the movie was released
     * 
     * @param int $year
     * @return self
     */
    public function year(int $year): self
    {
        $this->query['y'] = $year;

        return $this;
    }

    /**
     * Sets the search query parameter
     * 
     * @return self
     */
    public function search(string $search): self
    {
        $this->query['s'] = $search;
        return $this;
    }

    /**
     * Type of result to return
     * 
     * @throws WrongTypeException if the stype is not in the defined array
     * 
     * @param string $type
     * @return self
     */
    public function type(string $type): self
    {
        if(!in_array($type,['movie', 'series', 'episode'])) {
            throw new WrongTypeException($type .' is an invalid type');
        }

        $this->query['type'] = $type;
        return $this;
    }

    /**
     * Returns the full plot of an imdb ID/title result
     * 
     * @return self
     */
    public function fullPlot(): self
    {
        $this->query['plot'] = 'full';

        return $this;
    }

    /**
     * Sets the page number for search results
     * 
     * @param int $pageNumber
     * @return self
     */
    public function page(int $pageNumber): self
    {
        $this->query['page'] = $pageNumber;

        return $this;
    }

    /**
     * Returns the api response
     * 
     * @throws AuthException if the status code is 401
     * @throws RequestException if the status code is not 200
     * 
     * @return Response
     */
    public function get(): Response
    {
        $response = $this->httpClient->request('GET',self::API_URL,['query' => $this->query]);
        $statusCode = $response->getStatusCode();
        
        if($statusCode === 401) {
            $decoded = json_decode($response->getBody());
            throw new AuthException($decoded->Error);
        }

        if($statusCode !== 200)
        {
            throw new RequestException($response->getBody()->getContents());
        }

        $content = $response->getBody()->getContents();
        $page = $this->query['page'] ?? 1;
        $this->baseQuery();
 
        return new Response($content,$page);
    }

    /**
     * Gets the poster for the media
     * 
     * @param string $imdbId
     * @return array
     */
    public function getPoster(string $imdbId): array
    {
        $query = ['apikey' => $this->apiKey,'i' => $imdbId];
        $response = $this->httpClient->request('GET',self::IMAGE_API_URL,['query' => $query]);
        
        $statusCode = $response->getStatusCode();

        if($statusCode !== 200)
        {
            return null;
        }

        $contents = $response->getBody()->getContents();
        $mimeType = $response->getHeaderLine('Content-Type');
        return ["content" => $contents,"mime" => $mimeType];
    }

    /**
     * Sets the base http query
     * 
     * @return void
     */
    private function baseQuery()
    {
        $this->query = ['apikey' => $this->apiKey];
    }
}