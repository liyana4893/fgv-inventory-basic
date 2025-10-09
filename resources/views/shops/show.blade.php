@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header text-white" style="background-color:rgb(139, 3, 28);">{{ __('Shop Information') }}</div>

                <div class="card-body">
                
                         
                        <div class="form-group">
                            <label for="name">{{ __('Name')}} </label>
                            <input type="text" name="name" class="form-control"  value="{{ $shop->name}}"readonly>
                        </div>
                        <div class="form-group">
                            <label for="ssm_no">{{ __('SSM No')}} </label>
                            <input type="text" name="ssm_no" class="form-control" value="{{ $shop->ssm_no}}"readonly >
                        </div>
                        <div class="form-group">
                            <label for="phone">{{ __('Phone')}} </label>
                            <input type="number" name="phone" class="form-control" value="{{ $shop->phone}}"readonly>
                        </div>
                        <div class="form-group">
                            <label for="address">{{ __('Address')}} </label>
                            <input type="text" name="address" class="form-control" value="{{ $shop->address}}"readonly>

                        </div>
                        <div class="form-group">
                            <label for="city">{{ __('City')}} </label>
                            <input type="text" name="city" class="form-control" value="{{ $shop->city}}"readonly>

                        </div>
                        <div class="form-group">
                            <label for="state">{{ __('State')}} </label>
                            <input type="text" name="state" class="form-control" value="{{ $shop->state}}"readonly>
                        </div>
                        <div class="form-group">
                            <label for="country">{{ __('Country')}} </label>
                            <input type="text" name="country" class="form-control" value="{{ $shop->country}}"readonly>
                        </div>
                        <div class="form-group">
                            <label for="email">{{ __('Email')}} </label>
                            <input type="text" name="email" class="form-control" value="{{ $shop->email}}"readonly>
                        </div>
                        <a href="{{ route('shops.index', $shop)}}" class="btn btn-warning btn-sm mt-3">{{ __('Back')}}</a>
                    
                    
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
