@extends('layouts.app')
@section('legend_id')
<H4 style="text-align:center">Dashboard de {{$customer}}</H4>  
@endsection
@section('content')

<div class="modal fade" id="HardwareModal" tabindex="-1" role="dialog" aria-labelledby="HardwareModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="HardwareModalLabel">DETALLE</h5>
        </div>
        <div class="modal-body">
            <div class="table-responsive">
                <table id="customersTable" class="table table-bordered table-sm table-hover;">
                    <thead>
                        <tr style="background-color:gray ; color:white;">
                        <th>TIPO</th>
                        <th>MARCA</th>
                        <th>CARACTERÍSTICAS</th> 
                        <th>ADQUISICIÓN</th>
                        <th>CADUCIDAD</th>
                        <th>PRECIO</th>
                        <th>BAJA</th>   
                        </tr>
                    </thead>
                    <tbody id="hardwareContent">
                    </tbody>
                </table>
                
              </div>
        </div>
        <div class="modal-footer">
             <button type="button" class="btn btn-info" data-bs-dismiss="modal"><i class="fas fa-times"></i></button>
        </div>
      </div>
  </div>
  </div>







        <hr>
        <div class="row"> 
            <div class="col"><div class="alert alert-info" role="alert"><i class="fa-solid fa-computer fa-2x"></i> <b>  DISPOSITIVOS: </b> {{$counts[0]->q_devices}} </div></div>
            <div class="col"><div class="alert alert-warning" role="alert"><i class="fa-solid fa-memory fa-2x"></i> <b>  COMPONENTES: </b> {{$counts[0]->q_components}} </div></div>
            <div class="col"><div class="alert alert-success" role="alert"><i class="fa-solid fa-sack-dollar fa-2x"></i> <b>  TOTAL: </b> {{$counts[0]->s_components}} </div></div>
           </div>
        <hr>
        <div class="row">
            <div class="col-sm-12 mx-auto">
                <table id="hardwareTable" class="table table-sm table-striped;">
                    <thead>
                        <tr style="background-color:gray ; color:white;">
                            <th>&nbsp;</th>
                            <th>DISPOSITIVO</th>
                            <th>COMPONENTES</th>
                            <th>MONTO TOTAL</th>
                            <th>&nbsp;</th>
                            <th>QR</th>
                        </tr>
                    </thead>
                    <tbody>
                    @foreach ($devices as $item)
                    <tr class="align-middle" id="{{$item->device_id}}"> 
                    <td><i style="color:blue" class="fa-solid fa-computer fa-2x"></i></td>   
                    <td>{{$item->description}}</td>
                    <td>{{$item->q_components}}</td>
                    <td>{{$item->s_components}}</td>
                    <td><button style="border-radius: 50%;" data-bs-toggle="modal" data-bs-target="#HardwareModal" id = 'btnDetail' class='btn btn-info btn-sm'><i class="fa-solid fa-circle-info" aria-hidden="true" data-toggle="tooltip" data-placement="top" title='Ver detalle'></i></button></td>
                    <td><button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#qrModal{{$item->device_id}}"><i class="fa-solid fa-qrcode"></i></button></td>
                </tr>
  <!-- QR Modal -->
  <div class="modal fade" id="qrModal{{$item->device_id}}" tabindex="-1" role="dialog" aria-labelledby="rqModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="rqModalLabel">{{$customer}} - {{$item->description}}</h5>
      </div>
      <div class="modal-body text-center">
        @php
        $png = QrCode::format('png')->size(200)->generate('https://inventario.pcassi.net/qr/'.base64_encode($item->device_id));
        $png = base64_encode($png);
        echo "<img src='data:image/png;base64," . $png . "'>";
        @endphp
      </div>
      <div class="modal-footer">
             <button type="button" class="btn btn-info" data-bs-dismiss="modal"><i class="fas fa-times"></i></button>
        </div>
    </div>
  </div>
</div>
                    @endforeach    
                 </tbody>
                </table>
      
                @if (Auth::user()->is_admin == 1)
                <div class="d-flex justify-content-center"><a href="{{ route('customers.index')}}" class="btn btn-primary active" role="button" aria-pressed="true">Regresar al Listado General</a></div> 
                @else
                <div class="container">
                    <div class="row">
                @foreach($customers as $customer)
                <div class="col-sm"><div class="d-flex justify-content-center"><a href="{{ route('hardware.dashboard', base64_encode($customer->customer_x))}}" class="btn btn-primary active" role="button" aria-pressed="true">{{$customer->business_name}}</a> 
                                                                               <a href="{{ route('devices.pdfu', base64_encode($customer->customer_x))}}" class="btn btn-success active mx-2" role="button" aria-pressed="true"><i class="fa fa-file-pdf" aria-hidden="true" data-toggle="tooltip" data-placement="top" title='Descargar PDF'></i></a></div> </div>
                @endforeach
                </div>
                </div>  
                @endif

<script>
   @php
    $label = '';
    $values = '';
   @endphp
  
   @foreach($data as $d)
    @php $label.= "'".$d->denomination."',"; 
         $values.= "'".$d->w."',";
    @endphp
   @endforeach

$( document ).ready(function() {



               
                    

$("body").tooltip({
                        selector: '[data-toggle="tooltip"]',
                        container: 'body'  
                    }); 

$('#hardwareTable tbody').on( 'click', '#btnDetail', function () {
   var row = $(this).closest('tr');
   var url; 
   url = '{{ route("list.index", [$_id, ":id"]) }}';
   url = url.replace(':id', row.attr('id')); 
     
  $.ajax({
    url: url,
    type: "GET",
    dataType: "json",
    success: function (data) {
      var rows = "";
      if(data.length > 0) {
          $.each(data, function(i, item){
             rows+= '<tr ' + (item.low != '' ? 'class="table-danger"' : '') + '><td>' + item.icon + ' ' + item.denomination +  '</td><td>' + item.trademark + '</td><td>' + item.features + (item.original == 1 ? ' <i style="color:orange" class="fa-solid fa-star"></i>' : '') + '</td><td>' + (item.acquired != null ? item.acquired : '') + '</td><td>' +  (item.date_of_expiry != null ? item.date_of_expiry : '') + '</td><td>' +  (item.amount != null ? item.amount : '') + '</td><td>' +  item.low + '</td></tr>'; 
            });
  }
  $("#hardwareContent").html(rows); 
 
}
   
});                        
});

});
</script>
@endsection