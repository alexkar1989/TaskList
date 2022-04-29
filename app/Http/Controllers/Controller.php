<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    /**
     * "vue": "^3.2.33",
     * "vue-loader": "^17.0.0",
     * "vue-router": "^4.0.14",
     * "vue-template-compiler": "^2.6.14"
     */
}
