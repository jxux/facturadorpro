<?php

namespace App\Http\Controllers\tenant;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Tenant\Service;
use App\Http\Resources\Tenant\ServiceCollection;
use App\Http\Resources\Tenant\ServiceResource;

class BinnacleServicesController extends Controller{

    public function records(){

        $records = Service::all();
        return new ServiceCollection($records);

    }

    public function record($id){
        $record = new ServiceResource(Service::findOrFail($id));

        return $record;
    }
}
