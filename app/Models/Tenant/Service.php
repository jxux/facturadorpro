<?php

namespace App\Models\Tenant;
use Illuminate\Database\Eloquent\Builder;
use Hyn\Tenancy\Traits\UsesTenantConnection;

class Service extends ModelTenant{
    // use UsesTenantConnection;
    protected $table = 'service_binnacles';

    protected $fillable = [
        
        'code',
        'name',
    ];

    // protected static function boot()
    // {
    //     parent::boot();

    //     static::addGlobalScope('active', function (Builder $builder) {
    //         $builder->where('active', 1);
    //     });
    // }
}