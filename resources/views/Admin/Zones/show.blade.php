@extends('adminlte::page')

@section('title', 'Dashboard')

@section('content_header')
@stop

@section('content')
<div class="container card mt-4">
    <div class="card-header">
        <h4 class="float-left">Esta editando la Zona {{ $zone->id }}</h4>
        <button class="btn btn-success float-right ">Agregar coordenada</button>
    </div>
    <div class="card-body">
        <div class="row">
            <div class="col-4">
                <ul class="list-group list-group-flush">
                    <li class="list-group-item">Nombre: {{ $zone->name }}</li>
                    <li class="list-group-item">Area {{ $zone->area }}</li>
                    <li class="list-group-item">Descripcion {{ $zone->description }}</li>
                </ul>
            </div>
            <div class="col-8">
                <table class="table">
                    <thead>
                        <tr>
                            <th scope="col">Id</th>
                            <th scope="col">Latitud</th>
                            <th scope="col">Longitud</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($coords as $cordenada)
                        <tr>
                            <td>{{ $cordenada->id }}</td>
                            <td>{{ $cordenada->latitude }}</td>
                            <td>{{ $cordenada->longitude }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
        <div class="row">
            <div class="col"></div>
        </div>
    </div>
</div>
@stop

@section('css')
    {{-- Add here extra stylesheets --}}
    <link rel="stylesheet" href="/css/admin_custom.css">
@stop

@section('js')
@stop
