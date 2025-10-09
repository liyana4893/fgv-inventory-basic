@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header text-white" style="background-color:rgb(139, 3, 28);">{{ __('Inventory Information') }}</div>

                <div class="card-body">
                    
                        <div class="form-group">
                            <label for="name">{{ __('Name')}} </label>
                            <input type="text" name="name" class="form-control" value="{{ $inventory->name}}"readonly>

                        </div>
                        <div class="form-group">
                            <label for="description">{{ __('Description')}} </label>
                            <input type="text" name="description" class="form-control" value="{{ $inventory->description}}" readonly>
                        </div>
                        <div class="form-group">
                            <label for="quantity">{{ __('Quantity')}} </label>
                            <input type="number" name="quantity" class="form-control" value="{{ $inventory->quantity}}" readonly>
                        </div>
                        <a href="{{ route('inventories.index', $inventory)}}" class="btn btn-warning btn-sm mt-3">{{ __('Back')}}</a>
                       
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
