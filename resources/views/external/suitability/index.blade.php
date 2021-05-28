@extends('layouts.external')

@section('content')

<h3 class="mb-3">Listado de Solicitudes para el Colegio {{$psirequests->first()->school->name}}</h3>

<table class="table">
    <thead>
        <tr>
            <th>Solicitud N°</th>
            <th>Run</th>
            <th>Nombre Completo</th>
            <th>Cargo</th>
            <th>Correo</th>
            <th>Estado</th>
            <th>Descargar Certificado <small>En caso que esté aprobado y no salga para descargar, significa que está en proceso de firma electrónica</small></th>
        </tr>
    </thead>
    <tbody>
        @forelse($psirequests as $psirequest)
        <tr>
            <td>{{$psirequest->id}}</td>
            <td>{{$psirequest->user_external_id}}</td>
            <td>{{$psirequest->user->fullName}}</td>
            <td>{{$psirequest->job}}</td>
            <td>{{$psirequest->user->email}}</td>
            <td>{{$psirequest->status}}</td>
            <td></td>
        </tr>
        @empty
        <tr><td colspan="6" style="text-align: center; vertical-align: middle;" >No Hay Solicitudes Creadas</td></tr>

        @endforelse

    </tbody>
</table>




@endsection