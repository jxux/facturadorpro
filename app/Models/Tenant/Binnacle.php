<?php

namespace App\Models\Tenant;

// use App\Models\Tenant\Category;
// use App\Models\Tenant\Service;

// use Illuminate\Database\Eloquent\Model;

class Binnacle extends ModelTenant{
    
    // protected $table = 'Binnacles';
    // protected $with = ['category_binnacles', 'service_binnacles'];
    protected $fillable = [
        'user_id',
        'external_id',
        'date',
        'start_time',
        'end_time',
        'hour',
        'client_id',
        'client',
        'category_id',
        'category',
        'period',
        'service_id',
        'service',
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

    


    public function getCategoryAttribute($value){
        return (is_null($value))?null:(object) json_decode($value);
    }

    public function setCategoryAttribute($value){
        $this->attributes['category'] = (is_null($value))?null:json_encode($value);
    }

    public function Category() {
        return $this->belongsTo(Category::class, 'category_id');
    }



    public function getServiceAttribute($value){
        return (is_null($value))?null:(object) json_decode($value);
    }

    public function setServiceAttribute($value){
        $this->attributes['service'] = (is_null($value))?null:json_encode($value);
    }

    public function Service() {
        return $this->belongsTo(Service::class, 'service_id');
    }



    // public function user(){
    //     return $this->belongsTo(User::class);
    // }
}
