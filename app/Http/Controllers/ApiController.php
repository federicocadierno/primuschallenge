<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\ApiService;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\Log;

class ApiController extends Controller
{
    protected $apiService;

    public function __construct(ApiService $apiService)
    {
        $this->apiService = $apiService;
    }

    public function getToken(Request $request) {
        $rawJson = $request->getContent();
        $decodedData = json_decode($rawJson, true);
        
        $data = $this->apiService->getTokenRequest($decodedData); 
        
        return response()->json($data, 200);
    }

    public function sanitize_text_input($value) {
        //return htmlspecialchars(trim($value), ENT_QUOTES, 'UTF-8');
        return strip_tags($value);
    }

    public function getRates(Request $request)
    {
        $formData = $request->all();
        $vendorID = $request->get('vendorid');

        Log::error("getRates request". print_r($formData,true));
       
        unset($formData['_token_rates']);
        unset($formData['vendorid']);

        //dd($formData);
        
        $sanitized_data = array_map([$this, 'sanitize_text_input'],  $formData);
        $data = $this->apiService->getRates($vendorID, $sanitized_data);

        Log::error("data in controllers". print_r($data,true). " = ". count($data));
        //if (is_array($data) && count($data) > 0) {]}
        $result = ( isset($data['response']) && count($data['response']) > 0 ) ? $data['response']['data']['results']: [];
        if($result){
            $res = format_array_response($result);
            $html = view('partials.results', compact('res'))->render();
            return response()->json($html, 200);
        } else {
            return response()->json(["message" => "No results"], 204);
        }
        
       


       
    }
}
