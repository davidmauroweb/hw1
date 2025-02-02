@extends('layouts.app')
@section('legend_id')
<H4 style="text-align:center">Lista de Componentes Próximos a Expirar</H4>
<h6 style="text-align:center">Hasta el {{date('d/m/Y', strtotime($hasta))}}</h6>
@endsection
@section('content')


<div class="container">
    <div class="container">
    <div class="table-responsive">
    <table id="customersTable" class="table table-bordered table-sm table-hover;">
    <thead>
                        <tr class="table-secondary">
                        <th>Tipo</th>
                        <th>Dias</th>
                        <th></th>
                        <th></th>
                        <th>Usuario</th>
                        </tr>
    </thead>
    <tbody>
                        @php $total = 0;
                            $hoy = \Carbon\Carbon::parse(date("Y-m-d"));
                        @endphp
                        @foreach ($ls as $l)
                        @php
                            $expira = \Carbon\Carbon::parse($l->date_of_expiry);
                            $dias = $hoy->diffInDays($expira);
                        @endphp
                        <tr>
                            <td>@php echo $l->icon;@endphp - {{$l->denomination}}</td>
                            <td>{{$dias}}</td>
                            <td>{{$l->description}} - S: {{$l->serie}}</td>
                            <td>{{$l->business_name}}</td>
                            <td>{{$l->username}}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>  
              </div>
    </div>
</div>
@endsection
