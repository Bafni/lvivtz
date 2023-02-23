<?php

namespace App\Http\Controllers\CRM;

use App\Http\Controllers\Controller;

use Illuminate\Http\Request;

class CrmAController extends Controller
{

    public function __invoke(Request $request)
    {
        $data = $request->all();


        if ($request->headers->has('Authorization')) {

            return response()->json([ 'status' => 'ok', 'data' => $data], 201);
        }

        return response()->json(['status' => 'ok', 'data' => $data], 200);
    }

}
