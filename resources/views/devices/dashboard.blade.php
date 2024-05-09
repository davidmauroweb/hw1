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



        <div class="container" style="width:80%">
            <div class="row"> 
             <div class="col"><canvas id="amountChart"></canvas></div>
             <div class="col"><canvas id="quantityChart"></canvas></div>
            </div></div>
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
                    </tr>
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
                                                                               <a href="{{ route('devices.pdfu', base64_encode($customer->customer_x))}}" class="btn btn-success active" role="button" aria-pressed="true"><i class="fa fa-file-pdf" aria-hidden="true" data-toggle="tooltip" data-placement="top" title='Descargar PDF'></i></a></div> </div>
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



               var myChart = new Chart($('#amountChart'), {
                            type: 'bar',
                            data: {
                               labels:[ @php echo $label; @endphp ],
                               datasets: [{
                                    label: '$',
                                    data: [ @php echo $values; @endphp ],
                                    backgroundColor: [
                                        'rgba(255, 99, 132, 0.2)',
                                        'rgba(54, 162, 235, 0.2)',
                                        'rgba(255, 206, 86, 0.2)',
                                        'rgba(75, 192, 192, 0.2)',
                                        'rgba(153, 102, 255, 0.2)',
                                        'rgba(255, 159, 64, 0.2)'
                                    ],
                                    borderColor: [
                                        'rgba(255, 99, 132, 1)',
                                        'rgba(54, 162, 235, 1)',
                                        'rgba(255, 206, 86, 1)',
                                        'rgba(75, 192, 192, 1)',
                                        'rgba(153, 102, 255, 1)',
                                        'rgba(255, 159, 64, 1)'
                                    ],
                                    borderWidth: 1
                                }]
                            },
                            options: {
                                indexAxis: 'y',
                                responsive: true,
                                 maintainAspectRatio: false,
                                 plugins: {
                                legend: {
                                    display: false}}
                        }
                        });

                           var myChart2 = new Chart($('#quantityChart'), {
                            type: 'doughnut',
                            data: {
                                labels:[ @php echo $label; @endphp ],
                                datasets: [{
                                    label: '$',
                                    data: [ @php echo $values; @endphp ],
                                    backgroundColor: [
                                        'rgba(255, 99, 132, 0.2)',
                                        'rgba(54, 162, 235, 0.2)',
                                        'rgba(255, 206, 86, 0.2)',
                                        'rgba(75, 192, 192, 0.2)',
                                        'rgba(153, 102, 255, 0.2)',
                                        'rgba(255, 159, 64, 0.2)'
                                    ],
                                    borderColor: [
                                        'rgba(255, 99, 132, 1)',
                                        'rgba(54, 162, 235, 1)',
                                        'rgba(255, 206, 86, 1)',
                                        'rgba(75, 192, 192, 1)',
                                        'rgba(153, 102, 255, 1)',
                                        'rgba(255, 159, 64, 1)'
                                    ],
                                    borderWidth: 1
                                }]
                            },
                            options: {
                                responsive: true,
                                 maintainAspectRatio: false,
                        }
                        });
                    

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