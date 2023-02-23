<?php

namespace App\Http\Controllers\Integration;

use App\Components\IntegrationFactory;
use App\Http\Controllers\Controller;
use App\Http\Requests\Integration\IntegrationRequest;
use App\Models\RequestStatus;
use App\Models\UserData;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;


class IntegrationController extends Controller
{

    public function __invoke(IntegrationRequest $request): object
    {
        $data = $request->validated();

        $credentials = $request->only('name', 'lastName', 'phone', 'email');

        $password = Hash::make(str($request->only('password')['password']));

        $integrationName = IntegrationFactory::integrationList()[$data['integration_id']];

        try {
            UserData::firstOrCreate($credentials);

            $integrationClass = IntegrationFactory::make($integrationName);

            if ($integrationClass !== null) {

                if (!$request->hasHeader('Authorization')) {

                    $result = $integrationClass->sendRequest($credentials);

                } else {

                    $credentials['password'] = $password;

                    $result = $integrationClass->sendRequestWithApiKey($credentials);

                }

                $arr = (array)json_decode($result);

                unset($credentials['password']);

                $credentials['status'] = $arr['status'];

                RequestStatus::create($credentials);

                return $result;
            }
        } catch (\Exception $e) {

            return response()->json(['status' => 'не ок', 'data' => 'Щось пішло не по плану']);

        }

    }

}
