<!DOCTYPE html>
<html lang="es">  
<head>    
    <title>{{$business_name}}</title>    
    <meta charset="UTF-8">
 <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
</head>
<body>
<div class="row py-1"></div>
<H2 style="text-align:center">Listado de Equipamiento de {{$business_name}}</H2>  
<div class="row py-1"></div>
<div class="container-x px-2 mx-2">
                    <table class="table table-striped">
                        <thead class="bg-primary text-white">
                            <tr>
                                <th>#</th>
                                <th>DESCRIPCIÓN</th>
                                <th>REGISTRADO</th>
                                <th>COSTO</th>
                            </tr>
                        </thead>
                        <tbody class="table-group-divider">
                            @foreach($devices as $device)
                            <tr class="bg-secondary text-white">
                                <td>{{ $device->device_id }}</td>
                                <td>{{ $device->description}}</td>
                                <td>{{date('d/m/Y', strtotime($device->created_at))}}</td>
                                <td>{{ $device->s_components}}</td>
                              </tr>
                                    <tr class="table-secondary"><th></th><th>Componente - Descripcion</th><th>Monto</th><th></th></tr>
                                    @foreach($comp as $c)
                                    @if($device->device_id == $c->device_id)
                                    <tr class="table-light" ><td></td><td>{{$c->trademark}} - {{$c->features}}</td><td>{{$c->amount}}</td><td></td></tr>
                                    @endif
                                    @endforeach
                            @endforeach
                        </tbody>
                    </table>
</div>
<div class="row py-3"></div>
<hr>
<div class="row py-3"><div class="col text-end mx-5">PcAssi - {{ date('d/m/Y') }}</div></div>

</body>
</html>
