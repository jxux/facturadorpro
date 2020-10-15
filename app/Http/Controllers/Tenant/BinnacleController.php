<?php

namespace App\Http\Controllers\Tenant;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Tenant\Person;

use App\Models\Tenant\Binnacle;
use App\Http\Resources\Tenant\BinnacleCollection;
use App\Http\Requests\Tenant\BinnacleRequest;

use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use App\CoreFacturalo\Requests\Inputs\Common\PersonInput;


class BinnacleController extends Controller{

    public function index(){
        return view('tenant.binnacles.index');
    }

    public function columns(){
        return [
            'description' => 'Descripción',
            'customer' => 'Cliente',
        ];
    }

    public function records(Request $request){

        $records = Binnacle::where('user_id', auth()->id())
                            ->where($request->column, 'like', "%{$request->value}%")
                            ->orderBy('date','desc')
                            ->orderBy('end_time','desc');

        return new BinnacleCollection($records->paginate(config('tenant.items_per_page')));
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
