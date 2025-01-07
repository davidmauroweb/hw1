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
<H6 style="text-align:center">Listado QR de {{$business_name}} Total de quipos: {{$total}}</H6> 
<main>
<div class="row py-1"></div>
<div class="container-x px-2 mx-2">

                            @foreach($devices as $device)
                    <table class="table table-sm">
                        <tbody>
                            <tr>
                                <td>
                                    <h6>{{ $device->description }}</h6>
                                    Ubicación : {{ $device->location}}<br>
                                    Serie : {{ $device->serie}}<br>
                                    Registro : {{date('d/m/Y', strtotime($device->created_at))}}<br>
                                </td>
                                <td>
                                @php
        $png = QrCode::format('png')->size(200)->generate('https://inventario.pcassi.net/qr/'.base64_encode($device->device_id));
        $png = base64_encode($png);
        echo "<img src='data:image/png;base64," . $png . "'>";
        @endphp<br>
        {{ $device->location}}
                                </td>
                                <td style="vertical-align: middle;">
                                <img src="mark-b-pdf.jpg" style="width: 138px; height: 40px"><br>
                                <img src="mark-b.png" style="width: 138px; height: 40px">
                                </td>
                              </tr>
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
