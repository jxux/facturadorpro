<?php

namespace App\Models\Tenant;

// use Illuminate\Database\Eloquent\Model;

class Binnacle extends ModelTenant{
    
    // protected $table = 'Binnacles';
    // protected $with = ['users','persons', 'category_partdiarys', 'service_partdiarys'];
    protected $fillable = [
        'user_id',
        'external_id',
        'date',
        'start_time',
        'end_time',
        'hour',
        'customer_work',
        'customer_work_id',
        'category_id',
        'period',
        'service_id',
        'description',
        'status',
    ];

    protected $casts = [
        // 'start_time' => 'datetime',
        // 'end_time' => 'times',
        // 'date' => 'date',
        // 'created_at'=> 'date',
        // 'updated_at'=> 'date',
    ];

    protected $dates = [
        'date',
        'period',
        'start_time',
        'end_time',
    ];


    public function getCustomerWorkAttribute($value){
        return (is_null($value))?null:(object) json_decode($value);
    }

    public function setCustomerWorkAttribute($value){
        $this->attributes['customer'] = (is_null($value))?null:json_encode($value);
    }

    public function customer_work() {
        return $this->belongsTo(CurrencyType::class, 'customer_id');
    }

    // public function user(){
    //     return $this->belongsTo(User::class);
    // }
}
