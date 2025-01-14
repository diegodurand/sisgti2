@extends('layouts.app')

@section('content')
    <div class="container">
        <h2>Reporte de Equipos Informáticos por Laboratorio</h2>

        @if($equipos->isEmpty())
            <p>No se encontraron equipos en los laboratorios seleccionados.</p>
        @else
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>Marca</th>
                        <th>Modelo</th>
                        <th>Estado</th>
                        <th>Laboratorio</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($equipos as $equipo)
                        <tr>
                            <td>{{ $equipo->marca }}</td>
                            <td>{{ $equipo->modelo }}</td>
                            <td>{{ $equipo->estado }}</td>
                            <td>{{ $equipo->laboratorio->nombre }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @endif
    </div>
@endsection
