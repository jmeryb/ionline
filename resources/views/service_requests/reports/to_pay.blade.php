@extends('layouts.app')

@section('title', 'Reporte para pagos')

@section('content')

@include('service_requests.partials.nav')

<h3 class="mb-3">Reporte para pagos</h3>


<h4 class="mb-3 mt-3">Pendientes de pago</h4>
    <a href="{{route('rrhh.service-request.report.bank-payment-file')}}" class="btn btn-sm btn-outline-primary" > <i class="fas fa-file"></i> Archivo de pago banco (En pruebas)</a>
<table class="table table-sm table-bordered">
    <tr>
        <th>Id</th>
        <th>Tipo</th>
        <th>Jornada</th>
        <th>Nombre</th>
        <th nowrap>Rut</th>
        <th>Periodo</th>
        <th>Banco - N° Cuenta</th>
        <th>Telefono</th>
        <th>Certif.</th>
        <th>Boleta</th>
        <th>Resolución</th>
        <th>Editar</th>
        @canany(['Service Request: fulfillments finance'])
          <th width="30%">Apto para pago</th>
        @endcanany
    </tr>
    @foreach($fulfillments->whereNull('total_paid') as $key => $fulfillment)
      <tr>
          <td>{{$fulfillment->serviceRequest->id}}</td>
          <td>{{$fulfillment->serviceRequest->program_contract_type}}</td>
          <td>{{$fulfillment->serviceRequest->working_day_type}}</td>
          <td>{{$fulfillment->serviceRequest->name}}</td>
          <td>{{$fulfillment->serviceRequest->rut}}</td>
          <td>{{$fulfillment->year}} - {{$fulfillment->month}}</td>
          <td>{{$fulfillment->serviceRequest->bank->name ?? ''}} - {{$fulfillment->serviceRequest->account_number?? ''}}</td>
          <td>{{$fulfillment->serviceRequest->phone_number ?? ''}}</td>
          <td>
              <a href="{{ route('rrhh.service-request.fulfillment.certificate-pdf',$fulfillment) }}" target="_blank">
                 <i class="fas fa-paperclip"></i>
              </a>
          </td>
          <td>
            @if($fulfillment->has_invoice_file)
              <a href="{{route('rrhh.service-request.fulfillment.download_invoice', $fulfillment)}}"
                 target="_blank" class="mr-4">
                 <i class="fas fa-paperclip"></i>
              </a>
            @endif
          </td>
          <td>
            @if($fulfillment->serviceRequest->has_resolution_file)
              <a href="{{route('rrhh.service-request.fulfillment.download_resolution', $fulfillment->serviceRequest)}}"
                 target="_blank" class="mr-4">
                 <i class="fas fa-paperclip"></i>
              </a>
            @endif
          </td>
          <td>
              <a href="{{ route('rrhh.service-request.fulfillment.edit',$fulfillment->serviceRequest) }}">
      					<span class="fas fa-edit" aria-hidden="true"></span>
      				</a>
          </td>
          @canany(['Service Request: fulfillments finance'])
            <td>
              @livewire('service-request.payment-ready-toggle', ['fulfillment' => $fulfillment])
            </td>
          @endcanany
      </tr>
    @endforeach
</table>

<hr>

<h4 class="mb-3 mt-3">Pagados</h4>
<table class="table table-sm table-bordered">
    <tr>
        <th>Id</th>
        <th>Tipo</th>
        <th>Jornada</th>
        <th>Nombre</th>
        <th>Rut</th>
        <th>Periodo</th>
        <th>Certif.</th>
        <th>Boleta</th>
        <th>Resolución</th>
        <th>Fecha de pago</th>
        <th></th>
    </tr>
    @foreach($fulfillments->whereNotNull('total_paid') as $key => $fulfillment)
      <tr>
          <td>{{$fulfillment->serviceRequest->id}}</td>
          <td>{{$fulfillment->serviceRequest->program_contract_type}}</td>
          <td>{{$fulfillment->serviceRequest->working_day_type}}</td>
          <td>{{$fulfillment->serviceRequest->name}}</td>
          <td nowrap>{{$fulfillment->serviceRequest->rut}}</td>
          <td>{{$fulfillment->year}} - {{$fulfillment->month}}</td>
          <td>
              <a href="{{ route('rrhh.service-request.fulfillment.certificate-pdf',$fulfillment) }}" target="_blank">
                 <i class="fas fa-paperclip"></i>
              </a>
          </td>
          <td>
            @if($fulfillment->has_invoice_file)
              <a href="{{route('rrhh.service-request.fulfillment.download_invoice', $fulfillment)}}"
                 target="_blank" class="mr-4">
                 <i class="fas fa-paperclip"></i>
              </a>
            @endif
          </td>
          <td>
            @if($fulfillment->has_resolution_file)
              <a href="{{route('rrhh.service-request.fulfillment.download_resolution', $fulfillment)}}"
                 target="_blank" class="mr-4">
                 <i class="fas fa-paperclip"></i>
              </a>
            @endif
          </td>
          <td>
            {{$fulfillment->payment_date->format('Y-m-d')}}
          </td>
          <td>
              <a href="{{ route('rrhh.service-request.fulfillment.edit',$fulfillment->serviceRequest) }}">
      					<span class="fas fa-edit" aria-hidden="true"></span>
      				</a>
          </td>
      </tr>
    @endforeach
</table>
@endsection

@section('custom_js')


@endsection
