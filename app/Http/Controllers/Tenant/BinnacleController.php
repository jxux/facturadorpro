<?php

namespace App\Http\Controllers\Tenant;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Tenant\Person;

use App\Models\Tenant\Binnacle;
use App\Http\Resources\Tenant\BinnacleCollection;
use App\Http\Requests\Tenant\BinnacleRequest;

use App\Models\Tenant\Category;
use App\Models\Tenant\Service;


use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use App\CoreFacturalo\Requests\Inputs\Common\PersonInput;


class BinnacleController extends Controller{

    public function index(){
        return view('tenant.binnacles.index');
    }

    public function catalogs(){
        return view('tenant.binnacles.catalog.index');     
    }

    public function columns(){
        return [
            'description' => 'Descripción',
            'customer' => 'Cliente',
        ];
    }

    public function records(Request $request){

        // $records = $this->getRecords($request);

        $records = Binnacle::where('user_id', auth()->id())
                            ->where($request->column, 'like', "%{$request->value}%")
                            ->orderBy('date','desc')
                            ->orderBy('end_time','desc');

        return new BinnacleCollection($records->paginate(config('tenant.items_per_page')));
    }

    public function tables(){
        $clients = $this->table('clients');
        $categorys = $this->table('categorys');
        $services = $this->table('services');


        // $company = Company::active();

        return compact('clients', 'categorys', 'services');
    }

    public function table($table){
        switch ($table) {
            case 'clients':
                $clients = Person::whereType('clients')->orderBy('code')->get()->transform(function($row) {
                    return [
                        'id' => $row->id,
                        'code' => $row->code,
                        'description' =>$row->code.' - '.$row->number.' - '.$row->name,
                        'name' => $row->name,
                        'number' => $row->number,
                    ];
                });
                return $clients;
                break;

            case 'categorys':
                $categorys = Category::get()->transform(function($row){
                    return [
                        'id' => $row->id,
                        'code' => $row->code,
                        'name' => $row->name,
                        'description' =>$row->code.' - '.$row->name,
                    ];
                });
               return $categorys;
                break;
            
            case 'services':
                $services = Service::get()->transform(function($row){
                    return [
                        'id' => $row->id,
                        'category' => $row->category_id,
                        // 'name' => $row->name,
                        'description' =>$row->code.' - '.$row->name,
                    ];
                });
                return $services;
                break;
            
            default:

                return [];

                break;
        }
    }


    public static function convert($inputs){
        $company = Company::active();
        $values = [
            'user_id' => auth()->id(),
            'external_id' => Str::uuid()->toString(),
            'client' => PersonInput::set($inputs['client_id']),
            'soap_type_id' => $company->soap_type_id,
            'group_id' => ($inputs->document_type_id === '01') ? '01':'02',
            'state_type_id' => '01'
        ]; 

        $inputs->merge($values);

        return $inputs->all();
    }

    public function create(){
        return view('tenant.binnacles.form');
    }

    public function store(Request $request){
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
