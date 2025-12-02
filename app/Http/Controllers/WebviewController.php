<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class WebviewController extends Controller
{
    public function home()
    {
        return view('web.index');
    }

    public function privacy()
    {
        return view('web.privacy');
    }
    public function about()
    {
        return view('web.about');
    }

      public function refund()
    {
        return view('web.refund');
    }

      public function licesne()
    {
        return view('web.licesne');
    }

      public function contact_us()
    {
        return view('web.contact_us');
    }
}
