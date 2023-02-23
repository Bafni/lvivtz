<?php

namespace App\Http\Controllers\CRM;

use App\Http\Controllers\Controller;

use Illuminate\Http\Request;

class CrmAController extends Controller
{

    public function __invoke(Request $request)
    {

        if ($request->headers->has('Authorization')) {

            return response()->json([ 'status' => 'ok', 'data' => 'CRM save with authorization'], 201);
        }

        return response()->json(['status' => 'ok', 'data' => 'CRM save without authorization'], 201);
    }

}
