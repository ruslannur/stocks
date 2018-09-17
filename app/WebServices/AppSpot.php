<?php

namespace App\WebServices;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\RequestException;
use GuzzleHttp\Psr7;
use Illuminate\Support\Arr;

 
class AppSpot
{
	public function getData()
	{
		$data =  $this->getJson();
		return $this->parseJson($data);
	}

	public function getJson()
    {
    	try {
	    	$client = new Client(
	    		[
	    		'base_uri' => 'http://phisix-api3.appspot.com',
	    	    ]
	    	);
	    	
	    	$response = $client->request('GET', 'stocks.json');    	
	    	$data = [
	    		'status' => $response->getStatusCode(),
	    		'data' => $response->getBody()->getContents()
	    	]; 
	    	return $data;
	   	} catch (RequestException $e) {
			return [
				'status' => '500',
				'data' => ($e->hasResponse() ? Psr7\str($e->getResponse()) : '')
			]; 
		}
   	}
 
    public static function parseJson($data)
    {
        if ($data['status'] != '200') {
    		return [
    			'error' => '1',
    			'error_txt' => $data['data']
    		]; 
    	}

        $array =  json_decode($data['data'], true);
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