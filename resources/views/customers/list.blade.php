@extends('layouts.app')
@section('content')

<div class="modal fade" id="CustomerModal" tabindex="-1" role="dialog" aria-labelledby="CustomerModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="CustomerModalLabel">CLIENTES / EMPRESAS</h5>
        </div>
        <div class="modal-body">
         <form id ="frmCustomer" method="POST">
         @csrf
         <div class="form-row">
            <div class="col-auto">
                <label for="business_name_id">RAZÓN SOCIAL / NOMBRE</label>
                <input type="text" class="form-control form-control-sm" id="business_name_id" name = "business_name" maxlength="100" required>
            </div>
         </div>
         <div class="form-row">
            <div class="col-auto">
                <label for="id_user">USUARIO</label>
                <select class="form-control form-control-sm" id="user_id" name="user_id" required>
                        <option value="">SELECCIONE USUARIO</option>
                        @foreach($users as $user)
                        <option value="{{$user->user_id}}">{{$user->username}}</option>    
                        @endforeach
                </select>    
            </div>
        </div>
        <hr>
       <input type="hidden" value="0" id = "customer_id" name="customer_id">
       <button type="submit" class="btn btn-success"><i class="fas fa-check"></i></button>   
  </form>
        </div>
        <div class="modal-footer">
             <button type="button" class="btn btn-info" data-bs-dismiss="modal"><i class="fas fa-times"></i></button>
        </div>
      </div>
  </div>
  </div>

  <div class="container" style = "width:100%"> 
  <form id ="frmLicense" method="GET" action="{{ route('customers.index')}}">
         <div class="row">
         <div class="col-sm-10">
           <label for="string_id"><i class="fas fa-calendar-times"></i>DESCRIPCIÓN</label>
           <input type="text" class="form-control form-control-sm" id="string_id" name = "string" value="@if(isset($string)) {{$string}} @endif">
       </div>
          <div class="col-sm-auto">
          <div class="container d-flex h-100">
   <div class="row justify-content-center align-self-center">
       <div class="col-sm-auto"><button type="submit" id="id_btn_send" class="btn btn-info"><i class="fa-solid fa-magnifying-glass" aria-hidden="true" data-toggle="tooltip" data-placement="top" title='Buscar por nombre / razón social'></i></button></div>
   </div>
</div></div>
       </form>
</div>
    <div class="row">
                <div class="col-sm-12 mx-auto">
                    <table id="customersTable" class="table table-sm table-hover;">
                        <thead>
                            <tr style="background-color:gray ; color:white;">
                                <th>#</th>
                                <th>RAZÓN SOCIAL</th>
                                <th>USUARIO</th>
                                <th>DISPOSITIVOS</th>
                                <th style="display: none">&nbsp;</td>
                                <th>&nbsp;</th>
                                <th>&nbsp;</th>
                                <th>&nbsp;</th>
                                <th>&nbsp;</th>
                                <th>&nbsp;</th>
                                <th>&nbsp;</th>
                                <th>&nbsp;</th>
                                <th>&nbsp;</th>
                            </tr>
                        </thead>
                        <tbody>
                        @foreach ($customers as $customer)
                        <tr id="{{$customer->customer_id}}">    
                        <td>{{$customer->customer_id}}</td>
                        <td>{{$customer->business_name}}</td>
                        <td>{{$customer->username}}</td>
                        <td>{{$customer->q_devices}}</td>
                        <td style="display: none">{{$customer->user_id}}</td>
                        <td><button data-bs-toggle="modal" data-bs-target="#CustomerModal" id = 'btnEdit' class='btn btn-warning btn-sm'><i class="fas fa-edit" aria-hidden="true" data-toggle="tooltip" data-placement="top" title='Editar el registro'></i></button></td>
                        <td><a href="{{ route('devices.index', $customer->customer_id) }}" class="btn btn-dark btn-sm" role="button" aria-pressed="true"><i class="fa-solid fa-computer" aria-hidden="true" data-toggle="tooltip" data-placement="top" title='Gestionar hardware'></i></a></td>
                        <td><a href="{{ route('devices.pdf', $customer->customer_id) }}" class="btn btn-success btn-sm" role="button" aria-pressed="true"><i class="fa fa-file-pdf" aria-hidden="true" data-toggle="tooltip" data-placement="top" title='Descargar PDF'></i></a></td>
                        <td><a href="{{ route('devices.xls', $customer->customer_id)}}" class="btn btn-success active btn-sm" role="button" aria-pressed="true"><i class="fa-solid fa-file-excel" aria-hidden="true" data-toggle="tooltip" data-placement="top" title='Descargar XLS'></i></a></td>
                        <td><a href="{{ route('devices.pdf-qrls', $customer->customer_id) }}" class="btn btn-success btn-sm" role="button" aria-pressed="true"><i class="fa-solid fa-qrcode" aria-hidden="true" data-toggle="tooltip" data-placement="top" title='QRs en PDF'></i></a></td>
                        <td><a href="{{ route('hardware.dashboard', base64_encode($customer->customer_x)) }}" class="btn btn-primary btn-sm" role="button" aria-pressed="true"><i class="fa-solid fa-chart-simple" aria-hidden="true" data-toggle="tooltip" data-placement="top" title='Dashboard'></i></a></td>
                        <td>
                            <form action="{{ route('customers.state', $customer->customer_id) }}" method="POST">
                            @method('PATCH')
                            @csrf
                            <button type="submit" class="btn @if($customer->enabled)btn-secondary btn-sm"><i class="fas fa-ban" aria-hidden="true" data-toggle="tooltip" data-placement="top" title='Deshabilitar'></i>@else btn-success btn-sm"><i class='fas fa-check-circle' aria-hidden="true" data-toggle="tooltip" data-placement="top" title='Habilitar'></i>@endif</button>
                            </form>
                        </td>
                        <td>
                            <form action="{{ route('customers.delete', $customer->customer_id) }}" method="POST">
                            @method('delete')
                            @csrf
                            <button type="submit" class="btn btn-danger btn-sm" @if($customer->q_devices > 0) disabled @endif><i class="fas fa-trash" aria-hidden="true" data-toggle="tooltip" data-placement="top" title='Eliminar'></i></button>
                            </form>
                        </td>
                        </tr>
                        @endforeach    
                        </tbody>
                    </table>
                    <div class="d-flex">
                        {{ $customers->links() }} </div>
                </div>
            </div>
            <div class="row">
        <div class="col"><hr></div>
    </div>
   
      <div class="row d-flex h-100 justify-content-center">
        <div class="col-sm-auto">
            <button id = "btnNuevo" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#CustomerModal" onclick="$('#frmCustomer')[0].reset(); $('#customer_id').val(0);"><i class="fa-solid fa-building fa-2x" aria-hidden="true" data-toggle="tooltip" data-placement="top" title='Nuevo Usuario'></i></button></div>
      </div>       
  
<script>
$( document ).ready(function() {
    
$("body").tooltip({
                    selector: '[data-toggle="tooltip"]',
                    container: 'body'
});  

$('#customersTable tbody').on( 'click', '#btnEdit', function () {
    var row = $(this).closest('tr');
    $('#customer_id').val(row.attr('id'));
    $('#business_name_id').val(row.find("td").eq(1).html()); 
    $('#user_id').val(row.find("td").eq(4).html());
});

/*$("#frmSector").submit(function(e) {

e.preventDefault();
e.stopImmediatePropagation(); 

var handle201 = function(data, textStatus, jqXHR) {
   $('#frmSector')[0].reset();
   Fill();
};

$.ajax({
       url: "{{route('customers.index')}}",
       type: "POST",
       dataType : "json",
       data: $(this).serialize(),
       statusCode: { 201: handle201 }    
         });
});

}); 

function Delete(id, sector) {
    var url = '{{ route("customers.index", ["id" => "x", "sector" => "z"]) }}';
    url = url.replace('x', id); 
    url = url.replace('z', sector);     
    var token = $("meta[name='csrf-token']").attr("content");
    $.ajax({
           url:  url,
        type: "DELETE",
        data: { "_token": token},
        success: function (data) {
       Fill();
    }
});
}

function Fill() {

   var url; 
   url = '{{ route("customers.index", ":id") }}';
   url = url.replace(':id', $("#id_user_sector").val()); 
     
  $.ajax({
    url: url,
    type: "GET",
    dataType: "json",
    success: function (data) {
      var rows = "";
      if(data.length > 0) {
          $.each(data, function(i, item){
             rows+= '<div class="alert alert-success alert-dismissible fade show" role="alert"><strong>'+ item.description + '</strong><button type="button" class="btn-close" data-bs-dismiss="alert" onclick="Delete(' + item.id + ', ' + item.sector_id + ')" aria-label="Close"></button></div>'; 
            });
  }
  $("#contentprofile").html(rows); 
 
} */
}); 

</script>
@endsection
