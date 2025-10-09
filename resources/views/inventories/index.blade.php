@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
            <div class="card-header d-flex text-white justify-content-between align-items-center" style="background-color:rgb(139, 3, 28);">{{ __('Inventories Index') }} 
                    @can('create', App\Models\Inventory::class)
                    <a href="{{ route('inventories.create') }}" class="btn btn-light btn-sm text-dark"> Add Inventories
                    </a>
                    @endcan
                </div>

                <div class="card-body">
                    <table class="table">
                        <thead>
                            <tr>
                                <th>{{ __('Name') }}</th>
                                <th>{{ __('Description') }}</th>
                                <th>{{ __('Quantity') }}</th>
                                <th>{{ __('User') }}</th>
                                <th>{{ __('Actions') }}</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($inventories as $inventory)
                                <tr>
                                    <td>{{ $inventory->name }}</td>
                                    <td>{{ $inventory->description }}</td>
                                    <td>{{ $inventory->quantity }}</td>
                                    <td>{{ $inventory->user->name }}</td>
                                    <td>
                                        @can('view', $inventory)
                                            <a href="{{ route('inventories.show', $inventory) }}" class="btn btn-primary">{{ __('View') }}</a>
                                        @endcan
                                        @can('update', $inventory)
                                            <a href="{{ route('inventories.edit', $inventory) }}" class="btn btn-success">{{ __('Edit') }}</a>
                                        @endcan
                                        @can('delete', $inventory)
                                            <a href="{{ route('inventories.delete', $inventory) }}" class="btn btn-danger">{{ __('Delete') }}</a>
                                        @endcan
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>

            <br>

            <div class="card">
                <div class="card-header text-white" style="background-color:rgb(139, 3, 28);">{{ __('Deleted Inventories Index') }}</div>

                <div class="card-body">
                    <table class="table">
                        <thead>
                            <tr>
                                <th>{{ __('Name') }}</th>
                                <th>{{ __('Description') }}</th>
                                <th>{{ __('Quantity') }}</th>
                                <th>{{ __('User') }}</th>
                                <th>{{ __('Actions') }}</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($deletedInventories as $inventory)
                                <tr>
                                    <td>{{ $inventory->name }}</td>
                                    <td>{{ $inventory->description }}</td>
                                    <td>{{ $inventory->quantity }}</td>
                                    <td>{{ $inventory->user->name }}</td>
                                    <td>
                                        <a href="{{ route('inventories.restore', $inventory) }}" class="btn btn-primary">{{ __('Restore') }}</a>
                                        <a href="{{ route('inventories.forceDelete', $inventory) }}" class="btn btn-success">{{ __('Force Delete') }}</a>
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
@endsection