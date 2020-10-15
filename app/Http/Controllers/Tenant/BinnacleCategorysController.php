<?php

namespace App\Http\Controllers\tenant;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Tenant\Category;
use App\Http\Resources\Tenant\CategoryCollection;
use App\Http\Resources\Tenant\CategoryResource;
use App\Models\Tenant\Bank;
use App\Http\Resources\Tenant\BankCollection;



class BinnacleCategorysController extends Controller{

    public function records(){
        
        // $records = Category::all();

        $records = Category::all();
        return new CategoryCollection($records);


        // return new BankCollection($records);
    }

    public function record($id){
        $record = new CategoryResource(Category::findOrFail($id));

        return $record;
    }
}