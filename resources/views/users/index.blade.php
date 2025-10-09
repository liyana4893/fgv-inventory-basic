
@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header d-flex text-white justify-content-between align-items-center" style="background-color:rgb(139, 3, 28);">{{ __('User Index') }} 
                    <a href="{{ route('users.create') }}" class="btn btn-light btn-sm text-dark"> Add User
                    </a>
                </div>

                <div class="card-body">
                  <table class="table">
                    <thead>
                        <tr>
                            <th>{{ __('Name')}}</th>
                            <th>{{ __('Email')}}</th>
                            <th>{{ __('Total Inventories')}}</th>                         
                            <th>{{ __('Total Shops')}}</th>
                         
                        </tr>
                    </thead>
                    <tbody> 
                        @foreach ($users as $user) 
                        <tr>
                            <td> {{$user->name}}</td> 
                            <td> {{$user->email}}</td> 
                            <td> {{$user->inventories->count()}}</td> 
                            <td> {{$user->shops->count()}}</td> 
                           
                            <td>
                                <a href="{{ route('users.show', $user)}}" class="btn btn-info btn-sm">{{ __('View')}}</a>
                                <span style="margin-right:5px;"></span>
                                <a href="{{ route('users.edit', $user)}}" class="btn btn-warning btn-sm">{{ __('Edit')}}</a>
                                <span style="margin-right:5px;"></span>
                                <a href="{{ route('users.delete', $user)}}" class="btn btn-danger btn-sm">{{ __('Delete')}}</a>
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
