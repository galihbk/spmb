<?php

namespace App\Http\Controllers;

use App\Models\Ppdb;
use Illuminate\Http\Request;

class SettingController extends Controller
{

    public function persyaratan()
    {
        return view('setting.persyaratan');
    }
    public function faq()
    {
        return view('home.faq');
    }
}
