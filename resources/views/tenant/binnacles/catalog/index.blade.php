@extends('tenant.layouts.app')

@section('content')
    <div class="row">
        <div class="col-lg-6 col-md-12 ui-sortable">
            <tenant-binnacles-catalogs :type-user="{{json_encode(Auth::user()->type)}}"></tenant-binnacles-catalogs>
        </div>
        <div class="col-lg-6 col-md-12 ui-sortable">
            <tenant-binnacles-services :type-user="{{json_encode(Auth::user()->type)}}"></tenant-binnacles-services>
        </div>
        <div class="col-lg-4 col-md-12 ui-sortable">


        </div>
    </div>
@endsection
