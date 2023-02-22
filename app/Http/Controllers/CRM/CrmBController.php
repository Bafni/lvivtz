<?php

namespace App\Http\Controllers\CRM;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class CrmBController extends Controller
{

    public function __invoke(Request $request)
    {
        return 'B';
    }
}
