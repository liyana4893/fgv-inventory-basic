@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header text-white" style="background-color:rgb(139, 3, 28);">{{ __('User Create') }}</div>

                <div class="card-body">
                    <form action="" method="post">
                         @csrf
                        <div class="form-group">
                            <label for="name">{{ __('Name')}} </label>
                            <input type="text" name="name" class="form-control">
                        </div>
                        <div class="form-group">
                            <label for="email">{{ __('Email')}} </label>
                            <input type="text" name="email" class="form-control">
                        </div>
                        
                       
                       
                        <button type="submit" class="btn btn-warning mt-3" >{{ __('Store User')}}</button>
                    
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
