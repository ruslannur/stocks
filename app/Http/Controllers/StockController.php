<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\WebServices\AppSpot;

class StockController extends Controller
{
    protected $appSpot;
 
   public function __construct(AppSpot $appSpot) {
       $this->appSpot = $appSpot;
   }

    //
    public function index()
    {
        $base_uri = 'http://phisix-api3.appspot.com'; 
        $file = 'stocks.json';
        $result = $this->appSpot->getData($base_uri, $file);
        return $result;
    }
}
