<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;

class PoolController extends Controller
{
    public function index()
    {
        return view('admin.pool.index');
    }
}
