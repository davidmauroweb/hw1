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
                        <th>Exp.</th>
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
                            <td>{{$expira->format('d/m/Y')}} ({{$dias}} d)</td>
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
<div id='calendar'></div>
@endsection
@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.15/index.global.min.js"></script>
<script>

document.addEventListener('DOMContentLoaded', function() {
  const calendarEl = document.getElementById('calendar');
  const calendar = new FullCalendar.Calendar(calendarEl, {
    initialView: 'multiMonthFourMonth',
    
  views: {
    multiMonthFourMonth: {
      type: 'multiMonth',
      duration: { months: 6 }
    }
  },
    locale: 'es',
    events:@json($marca),
    eventColor: '#803030'
  });
  calendar.render();
});

</script>
@endpush