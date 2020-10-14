<?php

namespace App\Http\Requests\Tenant;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;


class BinnacleRequest extends FormRequest{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize(){
        return true;
    }

    public function rules(){    
        return [
            // $id = $this->input('id');
            'date' => [
                'required',
            ],
            'start_time' => [
                'required',
            ],
            'end_time' => [
                'required',
            ],
            'hour' => [
                'required',
            ],
            'customer_work_id' => [
                'required',
            ],
            'category_id' => [
                'required'
            ],
            'service_id' => [
                'required'
            ],
            'period' => [
                'required',
            ],
            'description' => [
                'required',
            ],
            'status' => [
                'required',
                'numeric',
            ],
        ];
    }
}
