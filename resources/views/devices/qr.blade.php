@extends('layouts.app')
@section('legend_id')
<H4 style="text-align:center">Empresa : {{$equipo->business_name}}</H4>
<h6 style="text-align:center">usuario: {{$equipo->username}}</h6>
@endsection
@section('content')


<div class="container">
    <div class="container">
    <div class="table-responsive">
    <b>Equipo:</b> {{$equipo->description}}<br>
    <b>Ubicación:</b> {{$equipo->description}}<br>
    <b>Serie:</b> {{$equipo->serie}}<br>
    <b>Observaciones:</b> {{$equipo->obs}}
                <table id="customersTable" class="table table-bordered table-sm table-hover;">
                    <thead>
                        <tr class="table-secondary">
                        <th>Tipo</th>
                        <th>Mrca</th>
                        <th>Detalle</th>
                        <th>Precio</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php $total = 0;
                            $hoy = \Carbon\Carbon::parse(date("Y-m-d"));
                        @endphp
                        @foreach ($components as $comp)
                        @php
                                    $expira = \Carbon\Carbon::parse($comp->date_of_expiry);
                                    if ($hoy <= $expira) {  
                                                $dias = $hoy->diffInDays($expira);  
                                            } else {  
                                                $dias = -$hoy->diffInDays($expira);  
                                            }
                            @endphp
                        <tr @if($comp->denomination == 'ANTIVIRUS') class="table-danger" @endif>
                            <td>@php echo $comp->icon;
                                if(isset($comp->date_of_expiry)AND($dias < 30)){
                                    echo '<i class="fa-solid fa-stopwatch" style="color:red"></i>';
                                } @endphp 
                                
                            </td>
                            <td>{{$comp->trademark}}</td>
                            <td>{{$comp->features}}
                                @if ($comp->original == 1)
                                <i style="color:orange" class="fa-solid fa-star"></i>
                                @endif
                            </td>
                            </td>
                            <td>{{$comp->amount}}</td>
                            @php $total = $total+$comp->amount; @endphp
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            <b>Total:</b> ${{$total}}   
              </div>
    </div>
</div>
@endsection
