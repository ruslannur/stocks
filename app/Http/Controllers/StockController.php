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
        $result = $this->appSpot->getData();
        return $result;
    }
}
