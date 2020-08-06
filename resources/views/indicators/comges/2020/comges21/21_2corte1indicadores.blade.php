<table class="table table-sm table-bordered small mb-4">
    <thead>
        <tr class="text-center">
            <th colspan="100%">ACCIÓN 1</th>
        </tr>
        <tr class="text-center">
            <th class="label">Indicador</th>            
            <th>Ene</th>
            <th>Feb</th>
            <th>Mar</th>
            <th>Acum</th>
            <th nowrap>% Cump. Obt</th>
            <th nowrap>% Cump. Esp</th>
            <th nowrap>Resultado</th>
            <th>Peso Medio Ponderado</th>
            <th>% de Cumplimiento Ponderado</th>
        </tr>
    </thead>
    <tbody>
        <tr class="text-center">
            <td class="text-left glosa">
                {{ $data21_2 ['label']['numerador'] }}
            </td>            
            @foreach($data21_2['numeradores'] as $numerador)
            @if ($loop->iteration <= 3)            
            @if (Auth::check())
            <td class="text-right"><a href="{{ route('indicators.comgescreate2020', [$numerador ? $numerador->id: 0, 21.2, $loop->iteration, 'numerador']) }}">{{ number_format( $numerador? $numerador->value: 0, 0, ',', '.') }}</a></td>
            @else
            <td class="text-right">{{ number_format( $numerador? $numerador->value: 0, 0, ',', '.') }}</td>
            @endif
            @endif
            @endforeach
                <td><strong>{{$data21_2['numerador_acumulado']}}</strong></td>
                <td rowspan="2" class="align-middle text-center"> <span class="{{ ($data21_2['cumplimiento'] >= preg_replace("/[^0-9]/", '', $data21_2['meta'])) ? 'text-success':'text-danger' }}">{{ number_format($data21_2['cumplimiento'], 2, ',', '.') }}% </span></td>
                <td rowspan="2" class="align-middle text-center">{{ $data21_2['meta'] }}</td>
                <td rowspan="2" class="align-middle text-center"><a href="#" data-toggle="tooltip" title="{{$data21_2['calculo']}}">{{ $data21_2['resultado'] }}%</a></td>
                <td rowspan="2" class="align-middle text-center">{{ $data21_2[1]['ponderacion'] }}%</td>
                <td rowspan="2" class="align-middle text-center">{{$data21_2['cumplimientoponderado']}}%</td>
        </tr>

        <tr class="text-center">
        <td class="text-left">
                {{ $data21_2['label']['denominador'] }}
            </td>
            @foreach($data21_2['denominadores'] as $denominador)
            @if ($loop->iteration <= 3)            
            @if (Auth::check())
            <td class="text-right"><a href="{{ route('indicators.comgescreate2020', [$denominador ? $denominador->id: 0, 21.2, $loop->iteration, 'denominador']) }}">{{ number_format( $denominador? $denominador->value: 0, 0, ',', '.') }}</a></td>
            @else
            <td class="text-right">{{ number_format( $denominador? $denominador->value: 0, 0, ',', '.') }}</td>
            @endif
            @endif
            @endforeach
            <td><strong>{{$data21_2['denominador_acumulado']}}</strong></td>
        </tr>
    </tbody>

</table>