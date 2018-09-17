<?php

namespace App\WebServices;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\RequestException;
use GuzzleHttp\Psr7;
use Illuminate\Support\Arr;

 
class AppSpot
{
    private $base_uri = '';
    private $file = '';
    private $data = '';
	
	public function getData($base_uri, $file)
	{
		$this->setServer($base_uri, $file);
		$this->getJson();
		return $this->parseJson();
	}

	public function setServer($base_uri, $file)
	{
		$this->base_uri = $base_uri;
		$this->file = $file;
	}

	public function getJson()
    {
    	try {
	    	$client = new Client(
	    		[
	    		'base_uri' => $this->base_uri,
	    	    ]
	    	);
	    	
	    	$response = $client->request('GET', $this->file);    	
	    	$this->data = [
	    		'status' => $response->getStatusCode(),
	    		'data' => $response->getBody()->getContents()
	    	];
	    	
	   	} catch (RequestException $e) {
			$this->data = [
				'status' => '500',
				'data' => ($e->hasResponse() ? Psr7\str($e->getResponse()) : '')
			]; 
		}
   	}
 
    public function parseJson()
    {
        if ($this->data['status'] != '200') {
    		return [
    			'error' => '1',
    			'error_txt' => $this->data['data']
    		]; 
    	}

        $array =  json_decode($this->data['data'], true);
        if (!Arr::exists($array, 'stock')) {
        	return [
        		'error' => '1',
        		'error_txt' => 'Key is absent'
        	]; 
        }

        $result = [];
        foreach($array['stock'] as $k=>$v) {
        	$result[] = [
        		'name'=> $v['name'],
        		'volume'=> $v['volume'],
        		'amount'=> $v['price']['amount']
        	];
        }

        return ['error' => '0', 'stocks' => $result];
        
    }
 
}