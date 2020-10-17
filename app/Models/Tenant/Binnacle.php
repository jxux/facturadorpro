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
        'client',
        'client_id',
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


    public function getClientAttribute($value){
        return (is_null($value))?null:(object) json_decode($value);
    }

    public function setClientAttribute($value){
        $this->attributes['client'] = (is_null($value))?null:json_encode($value);
    }

    public function Client() {
        return $this->belongsTo(CurrencyType::class, 'client_id');
    }

    // public function user(){
    //     return $this->belongsTo(User::class);
    // }
}
