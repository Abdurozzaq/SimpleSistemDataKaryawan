<?php

namespace Modules\Frontend\Http\Controllers;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;

class FrontendController extends Controller
{
    public function index()
    {
        return view('frontend::index');
    }

    public function pegawai()
    {
        return view('frontend::pegawai/index');
    }

    public function jabatan()
    {
        return view('frontend::jabatan/index');
    }

    public function kontrak()
    {
        return view('frontend::kontrak/index');
    }
}
