<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Exception;

class GoogleBooksService
{
    protected string $apiKey;
    protected $baseUrl;

    public function __construct () 
    {
        $this->apiKey = config('services.google_books.api_key');
        $this->baseUrl = config('services.google_books.api_url');
    }

    public function search (String $query) : array
    {
        try {
            // Make API call to get matching books data  
            $response = Http::timeout(10)
                ->get($this->baseUrl, [
                    'q' => $query,
                    'key' => $this->apiKey,
                    'maxResults' => 20,
                ]);

            // This throws a RequestException if there's a 400 or 500 error
            if ($response->failed()) {
                throw new Exception("Google Books API error: " . $response->status() . " - " . $response->reason());
            }

            // If successful, return matching books information
            return $response->json()['items'] ?? [];

        } catch (Exception $e) {
            logger()->error('Google Books API error: ', ['error' => $e->getMessage(), 'query' => $query]);

            throw $e;
        }

    }
    
    public function selectBook ($id) : array
    {
        try {
            // Make API call to get specific book data
            $response = Http::timeout(10)
                        ->get($this->baseUrl . '/' . $id, [
                            'key' => $this->apiKey
                        ]);
                        
            // This throws a RequestException if there's a 400 or 500 error
            if ($response->failed()) {
                throw new Exception("Google Books API error: " . $response->status() . " - " . $response->reason());
            }
            
            /* 
              If API call is successful, extract the necessary information from json response
            */
            $bookInfo = [];

            // Convert json into php array
            $volumeInfo = $response->json('volumeInfo'); 

            // Get required data from php array
            $bookInfo['title']       = data_get($volumeInfo, 'title', 'Title unknown');
            // If authors is none, give empty array. *Just for info: data_get(target, key, default)
            $bookInfo['author'] = implode(', ', data_get($volumeInfo, 'authors', [])) ?: 'Author unknown';
            // Get pageCount
            $bookInfo['total_pages'] = data_get($volumeInfo, 'pageCount', 0);
            // Get thumbnail path
            $bookInfo['cover_url']   = data_get($volumeInfo, 'imageLinks.thumbnail');
    
            return $bookInfo;
            
        } catch (Exception $e) {
            logger()->error('Google Books API error: ', ['error' => $e->getMessage(), 'bookId' => $id]);

            throw $e;
        }

    }

    
}