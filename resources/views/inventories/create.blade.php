@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header text-white" style="background-color:rgb(139, 3, 28);">{{ __('Inventory Create') }}</div>

                <div class="card-body">
                    <form action="" method="post">
                         @csrf
                        <div class="form-group">
                            <label for="name">{{ __('Name')}} </label>
                            <input type="text" name="name" class="form-control">
                        </div>
                        <div class="form-group">
                            <label for="description">{{ __('Description')}} </label>
                            <input type="text" name="description" class="form-control">
                        </div>
                        <div class="form-group">
                            <label for="quantity">{{ __('Quantity')}} </label>
                            <input type="number" name="quantity" class="form-control">
                        </div>
                        <button type="submit" class="btn btn-warning mt-3">{{ __('Store Inventory')}}</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
