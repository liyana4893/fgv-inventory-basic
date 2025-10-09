
@extends('layouts.app') 

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
            <div class="card-header d-flex text-white justify-content-between align-items-center" style="background-color:rgb(139, 3, 28);">{{ __('Shop Index') }} 
                    <a href="{{ route('shops.create') }}" class="btn btn-light btn-sm text-dark"> Add Shop
                    </a>
                </div>

                <div class="card-body">
                  <table class="table">
                    <thead>
                        <tr>
                            <th>{{ __('Name')}}</th>
                            <th>{{ __('SSM No')}}</th>
                            <th>{{ __('Phone')}}</th>
                            <th>{{ __('Address')}}</th>
                            <th>{{ __('City')}}</th>
                            <th>{{ __('State')}}</th>
                            <th>{{ __('Country')}}</th>
                            <th>{{ __('Email')}}</th>
                            <th>{{ __('User')}}</th>
                            <th>{{ __('Action')}}</th>
                        </tr>
                    </thead>
                
                    <tbody> 
                        @foreach ($shops as $shop) 
                        <tr>
                            <td> {{$shop->name}}</td> 
                            <td> {{$shop->ssm_no}}</td> 
                            <td> {{$shop->phone}}</td>
                            <td> {{$shop->address}}</td> 
                            <td> {{$shop->city}}</td> 
                            <td> {{$shop->state}}</td>
                            <td> {{$shop->country}}</td>
                            <td> {{$shop->email}}</td> 
                            <td> {{$shop->user->name}}</td>  
                            <td>
                                <a href="{{ route('shops.show', $shop)}}" class="btn btn-info btn-sm">{{ __('View')}}</a>
                                <span style="margin-right:5px;"></span>
                                <a href="{{ route('shops.edit', $shop)}}" class="btn btn-warning btn-sm">{{ __('Edit')}}</a>
                                <span style="margin-right:5px;"></span>
                                <a href="{{ route('shops.delete', $shop)}}" class="btn btn-danger btn-sm">{{ __('Delete')}}</a>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
