@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header text-white" style="background-color:rgb(139, 3, 28);">{{ __('User Info') }}</div>

                <div class="card-body">
                   
                        <div class="form-group">
                            <label for="name">{{ __('Name')}} </label>
                            <input type="text" name="name" class="form-control" value="{{ $user->name}}"readonly>
                        </div>
                        <div class="form-group">
                            <label for="email">{{ __('Email')}} </label>
                            <input type="text" name="email" class="form-control" value="{{ $user->email}}"readonly>
                        </div>
                       
                       
                        <a href="{{ route('users.index', $user)}}" class="btn btn-warning btn-sm mt-3">{{ __('Back')}}</a>
                        
                    
                    
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
