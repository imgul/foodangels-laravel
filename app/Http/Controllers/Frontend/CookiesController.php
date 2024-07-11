<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Http\Controllers\FrontendController;
use App\Models\Testimonial;
use Illuminate\Http\Request;

class CookiesController extends FrontendController
{
    public function cookies(Request $request)
    {
        $cookies =[];
        $cookies['userAgent']  = $_SERVER['HTTP_USER_AGENT'];
        $cookies['userIP']     =  $request->ip();
        return json_encode($cookies);

    }

    public function cookiesCancel(Request $request)
    {
        $cookies =[];
        $cookies['userAgent']  = null;
        $cookies['userIP']     =  null;
        return json_encode($cookies);

    }
}
