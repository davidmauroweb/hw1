<!DOCTYPE html>
<html lang="es">  
<head>    
    <title>{{$business_name}}</title>    
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
 <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
<style>
    @page {
margin: 80px 25px;
}
    header{
        position: fixed;
top: -60px;
left: 0px;
right: 0px;
height: 50px;
    }
</style>
</head>
<body>
<header>
<div class="row py-1"></div>
<img src="mark-b.png" style="width: 138px; height: 40px">
</header>
<H4 style="text-align:center">Listado de Equipamiento de {{$business_name}}</H4>
<H6 style="text-align:center">Total de quipos: {{$total}}</H6> 
<main>
<div class="row py-1"></div>
<div class="container-x px-2 mx-2">

                            @foreach($devices as $device)
                        <table class="table table-striped table-sm">
                        <tbody>
                            <tr class="table-secondary">
                                <tr>
                                <td><h5># : {{ $device->num }}</h5></td><td>Usuario : {{ $device->usuario}}</td></tr>
                                <tr><td>Descripción : {{ $device->description}}</td><td>Ubicación : {{ $device->location}}</td></tr>
                                <tr><td>Serie : {{ $device->serie}}</td><td>Registro : {{date('d/m/Y', strtotime($device->created_at))}}</td></tr>
                                <tr><td>Costo : {{ $device->s_components}}</td><td></td></tr>
                                </tr>
                                    <tr><th>Componente - Descripcion</th><th>Monto</th></tr>
                                    @foreach($comp as $c)
                                    @if($device->device_id == $c->device_id)
                                    <tr class="table-light" ><td>{{$c->trademark}} - {{$c->features}}</td><td>{{$c->amount}}</td></tr>
                                    @endif
                                    @endforeach
                                    </tbody>
                    </table>
                            @endforeach

</div>
<div class="row py-3"></div>
<hr>
<div class="row py-3"><div class="col text-end mx-5">PcAssi - {{ date('d/m/Y') }}</div></div>
</main>
</body>
</html>
