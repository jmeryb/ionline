<div>
<div class="table-responsive">
        <table class="table table-bordered table-striped table-sm small">
            <thead>
                <tr class="text-center">
                    <th rowspan="2">ID</th>
                    <th rowspan="2">Estado</th>
                    <th rowspan="2">Fecha Creación</th>
                    <th rowspan="2">Funcionario</th>
                    <th rowspan="2">Nombre de la Actividad</th>
                    <th colspan="2">Fecha</th>
                    <th rowspan="2"></th>
                </tr>
                <tr class="text-center">
                    <th>Inicio</th>
                    <th>Termino</th>
                </tr>
            </thead>
            <tbody>
                @foreach($trainings as $key => $training)
                <tr>
                    <th class="text-center" width="4%">{{ $training->id }}</th>
                    <td width="7%" class="text-center">
                        @switch($training->StatusValue)
                            @case('Guardado')
                                <span class="{{ ($bootstrap == 'v4') ? 'badge badge-primary' : 'badge text-bg-primary' }}">{{ $training->StatusValue }}</span>
                                @break
                            
                            @case('Enviado')
                                <span class="{{ ($bootstrap == 'v4') ? 'badge badge-warning' : 'badge text-bg-warning' }}">{{ $training->StatusValue }}</span>
                                @break

                            @case('Rechazado')
                                <span class="badge text-bg-danger">{{ $training->StatusValue }}</span>
                                @break
                            
                            @case('Finalizado')
                                <span class="badge text-bg-success">{{ $training->StatusValue }}</span>
                                @break
                        @endswitch
                    </td>
                    <td width="7%">{{ $training->created_at->format('d-m-Y H:i:s') }}</td>
                    <td width="30%">
                        {{ (auth()->guard('external')->check() == true) ? $training->userTraining->FullName : $training->userTraining->TinnyName }} <br><br>
                        <small><b>{{ ($training->userTrainingOu) ? $training->userTrainingOu->name : 'Funcionario Externo'}}</b></small> <br>
                        <small><b>{{ ($training->userTrainingEstablishment) ? $training->userTrainingEstablishment->name : '' }}</b></small>
                    </td>
                    <td width="30%">
                        {{ $training->activity_name }}<br><br>
                        <small><b>Tipo de Actividad:</b> {{ $training->activity_type }}</b></small> <br>
                    </td>
                    <td class="text-center" width="7%">{{ $training->activity_date_start_at }}</td>
                    <td class="text-center" width="7%">{{ $training->activity_date_end_at }}</td>
                    <td width="8%" class="text-center">
                        @if($training->StatusValue == 'Guardado')
                            @if(auth()->guard('external')->check() == true)
                                <a href="{{ route('external_trainings.external_edit', $training) }}"
                                    class="btn btn-outline-secondary btn-sm">
                                    <i class="fas fa-edit"></i> 
                                </a>
                            @else
                                @if($training->user_creator_id == auth()->id())
                                    <a href="{{ route('trainings.edit', $training) }}"
                                        class="btn btn-outline-secondary btn-sm">
                                        <i class="fas fa-edit"></i> 
                                    </a>
                                @else
                                    <a href="{{ route('trainings.show', $training) }}"
                                        class="btn btn-outline-secondary btn-sm">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                @endif
                            @endif
                        @else
                            @if(auth()->guard('external')->check() == true)
                                <a href="{{ route('external_trainings.external_show', $training) }}"
                                    class="btn btn-outline-secondary btn-sm">
                                    <i class="fas fa-eye"></i>
                                </a>
                            @else
                                <a href="{{ route('trainings.show', $training) }}"
                                    class="btn btn-outline-secondary btn-sm">
                                    <i class="fas fa-eye"></i>
                                </a>
                            @endif
                        @endif

                        @if($training->StatusValue == 'Finalizado')
                            @if(auth()->guard('external')->check() == true)
                                <a href="{{ route('external_trainings.external_show', $training) }}"
                                    class="btn btn-outline-secondary btn-sm">
                                    <i class="fas fa-eye fa-fw"></i>
                                </a>
                            @else
                                <a class="btn btn-outline-primary btn-sm"
                                    target="_blank"
                                    href="{{ route('trainings.show_summary_pdf', $training) }}">
                                    <i class="fas fa-file-pdf fa-fw"></i>
                                </a>
                            @endif
                        @endif
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
