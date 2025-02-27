<table>
@foreach($devices as $device)
        <tbody>
                <tr><td># : {{ $device->num }}</td><td>Usuario : {{ $device->usuario}}</td></tr>
                <tr><td>Descripción : {{ $device->description}}</td><td>Ubicación : {{ $device->location}}</td></tr>
                <tr><td>Serie : {{ $device->serie}}</td><td>Registro : {{date('d/m/Y', strtotime($device->created_at))}}</td></tr>
                <tr><td>Costo : {{ $device->s_components}}</td><td></td></tr>
                    <tr><th>Componente - Descripcion</th><th>Monto</th></tr>
                    @foreach($comp as $c)
                    @if($device->device_id == $c->device_id)
                    <tr><td>{{$c->trademark}} - {{$c->features}}</td><td>{{$c->amount}}</td></tr>
                    @endif
                    @endforeach
        </tbody>
@endforeach
</table>