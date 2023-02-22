<?php

namespace App\Http\Controllers\Integration;

use App\Components\IntegrationFactory;
use App\Http\Controllers\Controller;
use App\Http\Requests\Integration\IntegrationRequest;
use App\Models\RequestStatus;
use App\Models\UserData;
use Illuminate\Support\Facades\DB;


class IntegrationController extends Controller
{

    public function __invoke(IntegrationRequest $request)
    {

        $data = $request->validated();

        $credentials = $request->only('name', 'lastName', 'phone', 'email');

        $integrationName = IntegrationFactory::integrationList()[$data['integration_id']];

        try {
            DB::beginTransaction();

            UserData::firstOrCreate($credentials);

            $authorization = $data['authorization'];

            //unset($data['name'], $data['lastName'], $data['phone'], $data['email'], $data['integration_id'], $data['authorization']);

            $integrationClass = IntegrationFactory::make($integrationName);

            if ($integrationClass !== null) {

                if (!$authorization) {

                    $result = $integrationClass->sendRequest($credentials);

                }else {

                    $result = $integrationClass->sendRequestWithApiKey($credentials);
                }

                $arr = (array)json_decode($result);

                $credentials['status'] = $arr['status'];

                $credentials['data'] = $arr['data'];

                RequestStatus::create($credentials);

                return $result ;

            }
            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();

            return response()->json(['status' => 'не ок', 'data' => 'Щось пішло не по плану']);

        }


    }

}
