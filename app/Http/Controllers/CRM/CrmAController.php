<?php

namespace App\Http\Controllers\CRM;

use App\Http\Controllers\Controller;

use Illuminate\Http\Request;

class CrmAController extends Controller
{

    public function __invoke(Request $request)
    {
        $data = $request->all();

        if($request->headers->has('nameCRM') &&  $request->headers->has('passwordCrm')) {

            //Ніби наша умовна CRM провірила і відповіла

            return response()->json([ 'status' => 'login-ok',], 201)->withHeaders([
                'api_key' => 'mokeJwt'
            ]);
        }

        if ($request->headers->has('Authorization')) {

            return response()->json([ 'status' => 'ok', 'auth' => true, 'data' => $data], 201);
        }

        return response()->json(['status' => 'ok', 'auth' => false, 'data' => $data], 200);
    }

}
