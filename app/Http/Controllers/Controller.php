<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    protected $apiUrl;
    protected $apiToken;

    public function __construct() {
        $this->apiUrl = env('GO_REST_API_URL');
        $this->apiToken = env('GO_REST_API_TOKEN');
    }
}
