@extends('layouts.app')
@section('title', 'Flujos de Pago')
@section('content')
    @include('finance.nav')
    <h3 class="mb-3">Bandeja de Pagos Rechazados</h3>

    <table class="table table-sm table-bordered">
        <thead>
            <tr>
                <th>ID</th>
                <th>Establecimiento</th>
                <th>Documento</th>
                <th width="140px">OC</th>
                <th>FR</th>
                <th>Usuario que Rechazo</th>
                <th>Motivo de Rechazo</th>
                <th>Fecha y Hora de Rechazo</th>
            </tr>
        </thead>

        <tbody>
            @foreach ($dtes as $dte)
                <tr>
                    <td class="small">{{ $dte->id }}</td>
                    <td class="small">{{ $dte->establishment->name }}</td>
                    <td class="small">
                        @if ($dte->tipo_documento != 'boleta_honorarios')
                            <a href="http://dipres2303.acepta.com/ca4webv3/PdfView?url={{ $dte->uri }}" target="_blank"
                                class="btn btn-sm mb-1 btn-outline-secondary">
                                <i class="fas fa-file-pdf text-danger"></i> {{ $dte->folio }}
                            </a>
                        @else
                            <a href="{{ $dte->uri }}" target="_blank" class="btn btn-sm mb-1 btn-outline-secondary">
                                <i class="fas fa-file-pdf text-danger"></i> {{ $dte->folio }}
                            </a>
                        @endif
                        <br>
                        {{ $dte->tipo_documento }}
                        <br>
                        {{ $dte->emisor }}
                    </td>
                    <td class="small">
                        @livewire('finance.get-purchase-order', ['dte' => $dte], key($dte->id))
                    </td>
                    <td class="small">
                        @if ($dte->requestForm)
                            <a class="btn btn-outline-primary btn-block"
                                href="{{ route('request_forms.show', $dte->requestForm->id) }}" target="_blank">
                                <i class="fas fa-file-alt"></i> {{ $dte->requestForm->folio }}
                            </a>
                        @endif
                    </td>
                    <td class="small">{{ $dte->rejectedUser->short_name }}</td>
                    <td>
                        <textarea class="form-control" readonly>
                            {{ $dte->reason_rejection }}
                            </textarea>
                    </td>
                    </textarea>
                    <td class="small">{{ $dte->rejected_at }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>


@endsection
