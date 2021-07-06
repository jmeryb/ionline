@extends('layouts.app')

@section('title', 'Gestion de Turnos')

@section('content')

	@include("rrhh.shift_management.tabs", array('actuallyMenu' => 'availableShifts'))

	<h3>Turnos Disponibles</h3>
	<br>

		<form method="post" action="{{ route('rrhh.shiftManag.indexF') }}" >
        	@csrf
        	{{ method_field('post') }}  <!-- equivalente a: @method('POST') -->

        	<!-- Menu de Filtros  -->
			<div class="form-row">
            	<!-- <div class="form-group col-md-5" >
                	<label for="for_name">Unidad organizacional</label>
                	<select class="form-control selectpicker"  id="for_orgunitFilter" name="orgunitFilter" data-live-search="true" required
                            data-size="5">
                        @foreach($ouRoots as $ouRoot)
                            @if($ouRoot->name != 'Externos')
                                <option value="{{ $ouRoot->id }}"  {{($ouRoot->id==$actuallyOrgUnit->id)?'selected':''}}> 
                                {{($ouRoot->id ?? '')}}-{{ $ouRoot->name }}
                                </option>
                                @foreach($ouRoot->childs as $child_level_1)
                                    <option value="{{ $child_level_1->id }}" {{($child_level_1->id==$actuallyOrgUnit->id)?'selected':''}}>
                                        &nbsp;&nbsp;&nbsp;
                                        {{($child_level_1->id ?? '')}}-{{ $child_level_1->name }}
                                    </option>
                                    @foreach($child_level_1->childs as $child_level_2)
                                        <option value="{{ $child_level_2->id }}" {{($child_level_2->id==$actuallyOrgUnit->id)?'selected':''}}>
                                            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                            {{($child_level_2->id ?? '')}}-{{ $child_level_2->name }}
                                        </option>
                                        @foreach($child_level_2->childs as $child_level_3)
                                            <option value="{{ $child_level_3->id }}" {{($child_level_3->id==$actuallyOrgUnit->id)?'selected':''}}>
                                                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                                {{($child_level_3->id ?? '')}}-{{ $child_level_3->name }}
                                            </option>
                                            @foreach($child_level_3->childs as $child_level_4)
                                                <option value="{{ $child_level_4->id }}" {{($child_level_4->id==$actuallyOrgUnit->id)?'selected':''}}>
                                                    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                                    {{($child_level_4->id ?? '')}}-{{ $child_level_4->name }}
                                                </option>
                                            @endforeach
                                        @endforeach
                                    @endforeach
                                @endforeach
                            @endif
                        @endforeach
                    </select>
            	</div> -->

   				<div class="form-group col-md-2">	
                	<label for="for_name">Año</label>
                	<select class="form-control" id="for_yearFilter" name="yearFilter">
                    	@for($i = (intval($actuallyYear)-2); $i< (intval($actuallyYear) + 4); $i++)
                        	<option value="{{$i}}" {{ ($i == $actuallyYear )?"selected":"" }}> {{$i}}</option>
                    	@endfor	
                	</select>
            	</div>

            	<div class="form-group col-md-2">    	
                	<label for="for_name">Mes</label>
                	<select class="form-control" id="for_monthFilter" name="monthFilter">
                    	@foreach($months AS $index => $month)
                        	<option value="{{ $index }}" {{ ($index == $actuallyMonth )?"selected":"" }}>{{$loop->iteration}} - {{$month}} </option>
                    	@endforeach
                	</select> 		
            	</div>

            	<div class="form-group col-md-1">
                	<label for="for_submit">&nbsp;</label>
                	<button type="submit" class="btn btn-primary form-control">Filtrar  </button>
            	</div>
        	</div>
  		</form>
	<br>

	<h5><b>Disponibles:</b></h5>
	<br>
	<div class="alert alert-primary" role="alert">
		Sin días disponibles para solicitar
	</div>

	<div class="card " >
  		<ul class="list-group list-group-flush overflow-auto">
    		<li class="list-group-item">
    			<b>Propietario</b>
    			<p>18.004.474-4 - Armando Barra Perez</p>
    			
    			<b>Día</b>
    			<p> 05/07/2021, Jornada: L - Larga</p>
    			<button class="btn btn-success">Solicitar</button>

    		</li>
    		<li class="list-group-item">
    			<b>Propietario</b>
    			<p>18.004.474-4 - Armando Barra Perez</p>
    			
    			<b>Día</b>
    			<p> 05/07/2021, Jornada: L - Larga</p>
    			<button class="btn btn-success">Solicitar</button>

    		</li>  		
    		<li class="list-group-item">
    			<b>Propietario</b>
    			<p>18.004.474-4 - Armando Barra Perez</p>
    			
    			<b>Día</b>
    			<p> 05/07/2021, Jornada: L - Larga</p>
    			<button class="btn btn-success">Solicitar</button>

    		</li>
  		</ul>
	</div>
	<br>

	<h5><b>Mis solicitudes:</b></h5>
	<br>
	<div class="alert alert-primary" role="alert">
		Sin registro de solicitudes realizadas este mes
	</div>
	<br>

	<div class="card overflow-auto"  >
  		<ul class="list-group list-group-flush">
    		<li class="list-group-item">
    			<b>Propietario</b>
    			<p>18.004.474-4 - Armando Barra Perez</p>
    			
    			<b>Día</b>
    			<p> 05/07/2021, Jornada: L - Larga</p>

    			<b>Solicitud</b>
    			<p> Solicitado en 05/07/2021 20:30:00</p>
    			<b>Estado</b>
    			<p style="color:yellow"> Espera de confirmacion</p>
    			<button class="btn btn-danger">Cancelar</button>
    		</li>
    		<li class="list-group-item">
    			<b>Propietario</b>
    			<p>18.004.474-4 - Armando Barra Perez</p>
    			
    			<b>Día</b>
    			<p> 05/07/2021, Jornada: L - Larga</p>

    			<b>Solicitud</b>
    			<p> Solicitado en 05/07/2021 20:30:00</p>
    			<b>Estado</b>
    			<p style="color:red"> Rechazado</p>
    		</li>
    		<li class="list-group-item">
    			<b>Propietario</b>
    			<p>18.004.474-4 - Armando Barra Perez</p>
    			
    			<b>Día</b>
    			<p> 05/07/2021, Jornada: L - Larga</p>

    			<b>Solicitud</b>
    			<p> Solicitado en 05/07/2021 20:30:00</p>
    			<b>Estado</b>
    			<p style="color:green"> Confirmado</p>
    		</li>
  		</ul>
	</div>
@endsection
