@extends('layouts.app')
@section('legend_id')
<H4 style="text-align:center">Listado de Equipamiento de {{$business_name}}</H4>  
@endsection
@section('content')

<div class="modal fade" id="ComponentModal" tabindex="-1" role="dialog" aria-labelledby="ComponentModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="ComponentModalLabel">COMPONENTES</h5>
        </div>
        <div class="modal-body">
         <form id ="frmComponent" method="POST">
         @csrf
        <div class="form-row">
            <div class="col-auto">
                <label for="hardware_id">COMPONENTE</label>
                <select class="form-control form-control-sm" id="hardware_id" name="hardware_id" required>
                        <option value="">SELECCIONE HARDWARE/SOFTWARE</option>
                        @foreach($hardware as $hardware)
                        <option value="{{$hardware->hardware_id}}">{{$hardware->denomination}}</option>    
                        @endforeach
                </select>    
            </div>
        </div>
        <div class="form-row">
            <div class="col-auto">
                <label for="trademark_id">MARCA</label>
                <input type="text" class="form-control form-control-sm" id="trademark_id" name = "trademark" maxlength="100" required>
            </div>
            <div class="col-auto">
                <label for="features_id">CARACTERÍSTICAS</label>
                <input type="text" class="form-control form-control-sm" id="features_id" name = "features" maxlength="100" required>
            </div>
         </div>
         <div class="form-row">
            <div class="form-check form-switch">
                <input class="form-check-input" type="checkbox" id="original_id" name="original">
                <label class="form-check-label" for="original_id">ORIGINAL</label>
              </div>
              <div class="col-auto">
                <label for="acquired_id">ADQUIRIDO</label>
                <input type="date" class="form-control form-control-sm" id="acquired_id" name = "acquired" required>
            </div>              
            <div class="col-auto">
                <label for="date_of_expiry_id">FECHA CADUCIDAD</label>
                <input type="date" class="form-control form-control-sm" id="date_of_expiry_id" name = "date_of_expiry">
            </div>
            <div class="col-auto">
                <label for="amount_id">PRECIO</label>
                <input type="number" class="form-control form-control-sm" id="amount_id" name = "amount" required>
            </div>
         </div>
        <hr>
       <input type="hidden" value="0" id = "device_id" name="device_id">
       <div id="alert_id"></div>
       <button type="submit" class="btn btn-success"><i class="fas fa-check"></i></button>   
  </form>
        </div>
        <div class="modal-footer">
           <button type="button" class="btn btn-info" data-bs-dismiss="modal"><i class="fas fa-times"></i></button>
        </div>
      </div>
  </div>
  </div>

  <div class="modal fade" id="ListModal" tabindex="-1" role="dialog" aria-labelledby="ListModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
        <div class="modal-header">
          <div class="modal-title" id="ListModalLabel"><h4 id="det"></h4></div>
        </div>
        <div id="listContent" class="modal-body">
         
        </div>
        <div class="modal-footer">
             <button type="button" class="btn btn-info" data-bs-dismiss="modal"><i class="fas fa-times"></i></button>
        </div>
      </div>
  </div>
  </div>

  <div class="modal fade" id="EditModal" tabindex="-1" role="dialog" aria-labelledby="EditModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="EditModalLabel">EDITAR COMPONENTE</h5>
        </div>
        <div id="formEdit" class="modal-body">
         
        </div>
        <div class="modal-footer">
             <button type="button" class="btn btn-info" data-bs-dismiss="modal"><i class="fas fa-times"></i></button>
        </div>
      </div>
  </div>
  </div>


<div class="container">
        <div class="container" style = "width:100%"> 
                <form id ="frmLicense" method="GET" action="{{ route('devices.index', $customer_id)}}">
                       <div class="row">
                       <div class="col-sm-10">
                         <label for="string_find_id"><i class="fas fa-calendar-times"></i>DESCRIPCIÓN</label>
                         <input type="text" class="form-control form-control-sm" id="string_find_id" name = "string_find" value="@if(isset($string_find)) {{$string_find}} @endif">
                     </div>
                        <div class="col-sm-2">
                        <div class="container d-flex h-100">
                 <div class="row justify-content-center align-self-center">
                     <div class="col-sm-auto"><button type="submit" id="id_btn_send" class="btn btn-success"><i class="fas fa-check-square" aria-hidden="true" data-toggle="tooltip" data-placement="top" title='Buscar por categoría y descripción'></i></button></div>
                 </div>
              </div></div>
                     </form>
              </div>
                <div class="row">
                <div class="col-sm-12 mx-auto">
                    <table id="componentsTable" class="table table-sm">
                        <thead>
                            <tr style="text-align:center; background-color:gray ; color:white;">
                                <th>#</th>
                                <th>DESCRIPCIÓN</th>
                                <th>REGISTRADO</th>
                                <th>COSTO</th>
                                <th>COMPONENTES</th>
                                <th>&nbsp;</th>
                                <th>&nbsp;</th>
                                <th>&nbsp;</th>
                                <th>&nbsp;</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($devices as $device)
                            <tr style="text-align: center" id="{{$device->device_id}}">
                                <td>{{ $device->device_id }}</td>
                                <td>{{ $device->description}}</td>
                                <td>{{ $device->created_at}}</td>
                                <td>{{ $device->s_components}}</td>
                                <td>{{ $device->q_components}}</td>
                                <td><button data-bs-toggle="modal" data-bs-target="#ComponentModal" id = 'btnComponents' class='btn btn-primary btn-sm'><i class="fa-solid fa-desktop" aria-hidden="true" data-toggle="tooltip" data-placement="top" title='Agregar Componente'></i></button></td>
                                <td><button data-bs-toggle="modal" data-bs-target="#ListModal" id = 'btnActives' onclick="Fill({{$device->device_id}}, 0, '{{$device->description}}')" class='btn btn-success btn-sm'><i class="fa-solid fa-memory" aria-hidden="true" data-toggle="tooltip" data-placement="top" title='Ver Componentes Activos'></i></button></td>
                                <td><button data-bs-toggle="modal" data-bs-target="#ListModal" id = 'btnLow' onclick="Fill({{$device->device_id}}, 1, '{{$device->description}}')" class='btn btn-secondary btn-sm'><i class="fa-solid fa-microchip" aria-hidden="true" data-toggle="tooltip" data-placement="top" title='Ver Componentes Reemplazados'></i></button></td>
                                 <td>
                                    <form action="{{ route('devices.destroy', $device->device_id) }}" method="POST">
                                        @method('DELETE')
                                        @csrf
                                        <button type="submit" class="btn btn-danger btn-sm"><i class="fas fa-window-close" aria-hidden="true" data-toggle="tooltip" data-placement="top" title="Eliminar definitivamente del Sistema"></i></button>
                                    </form>
                                </td>
                              </tr>
                            @endforeach
                        </tbody>
                    </table>
                    <div class="d-flex">
                {{ $devices->links() }}
            </div>
                </div>
            </div>
            <div class="row">
        <div class="col"><hr></div>
    </div>
     </div>
     <div class="container" style = "width:100%"> 
     <div class="h-100 p-2 bg-light border rounded-3"> 
<form id ="frmLicense" method="POST" action="{{ route('devices.store')}}">
          @csrf
          <div class="row">
          <div class="col-sm-10">
            <label for="description_id"><i class="fas fa-calendar-times"></i>DESCRIPCIÓN</label>
            <input type="text" class="form-control form-control-sm" id="description_id" name = "description" required>
        </div>
        <div class="col-sm-auto">
           <input type="hidden" value="{{$customer_id}}" name="customer_id">
           <div class="container d-flex h-100">
    <div class="row justify-content-center align-self-center">
        <div class="col-sm-auto"><button type="submit" id="id_btn_send" class="btn btn-success"><i class="fas fa-check-square" aria-hidden="true" data-toggle="tooltip" data-placement="top" title='Ingresar dispositivo o componente de hardware'></i></button></div>
    </div>
</div></div>
        </form>
</div>   
     </div>
     <hr>
     <div class="row d-flex justify-content-center">
     <div class="col text-center"><a href="{{ route('customers.index')}}" class="btn btn-primary active" role="button" aria-pressed="true">Regresar al Listado General</a></div>
     <div class="col text-center"><a href="{{ route('devices.pdf', $customer_id) }}" class="btn btn-success" role="button" aria-pressed="true">Descargar PDF</a></div>
     </div> 

<script>
$( document ).ready(function() {
    $("body").tooltip({
                        selector: '[data-toggle="tooltip"]',
                        container: 'body'  }); 

$('#componentsTable tbody').on( 'click', '#btnComponents', function () {
    var row = $(this).closest('tr');
   $('#device_id').val(row.attr('id'));
  });

 });



$("#frmComponent").submit(function(e) {

e.preventDefault();
e.stopImmediatePropagation(); 

var handle201 = function(data, textStatus, jqXHR) {
    $('#hardware_id').val('');
    $('#trademark_id').val('');
    $('#features_id').val('');
    $('#original_id').prop('checked', false); 
    $('#acquired_id').val('');
    $('#date_of_expiry_id').val('');
    $('#amount_id').val('');
    $('#alert_id').html('<div class="alert alert-success alert-dismissible fade show" role="alert">¡Componente registrado correctamente!<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button></div>');
};

var token = $("meta[name='csrf-token']").attr("content");
$.ajax({
       url: "{{route('components.store')}}",
       type: "POST",
       dataType : "json",
       data: $(this).serialize(),
       statusCode: { 201: handle201 }    
         });
});

$("#editComponent").submit(function(e) {

e.preventDefault();
e.stopImmediatePropagation(); 

var handle201 = function(data, textStatus, jqXHR) {
    $('#hardware_id').val('');
    $('#trademark_id').val('');
    $('#features_id').val('');
    $('#original_id').prop('checked', false); 
    $('#acquired_id').val('');
    $('#date_of_expiry_id').val('');
    $('#amount_id').val('');
    $('#alert_id').html('<div class="alert alert-success alert-dismissible fade show" role="alert">¡Componente actualizado correctamente!<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button></div>');
};

var token = $("meta[name='csrf-token']").attr("content");
$.ajax({
       url: "{{route('components.update')}}",
       type: "POST",
       dataType : "json",
       data: $(this).serialize(),
       statusCode: { 201: handle201 }    
         });
});

function Delete(id, dev, desc) {
    var url; 
    url = '{{ route("components.destroy", "x") }}';
    url = url.replace('x', id);    
    var token = $("meta[name='csrf-token']").attr("content");
    $.ajax({
           url:  url,
        type: "DELETE",
        data: { "_token": token},
        success: function (data) {
       Fill(dev, 0, desc);
    }
});
}

function Low(id, dev, desc) {
    var url; 
    url = '{{ route("components.low", "x") }}';
    url = url.replace('x', id);    
    var token = $("meta[name='csrf-token']").attr("content");
    $.ajax({
           url:  url,
        type: "PATCH",
        data: { "_token": token},
        success: function (data) {
       Fill(dev, 0, desc);
    }
});
}

function Fill(id, type, desc) {
var url = '{{ route("components.index", ["id" => "x", "type" => "z"]) }}';
url = url.replace('x', id); 
url = url.replace('z', type);
$.ajax({
    url: url,
    type: "GET",
    dataType: "json",
        success: function (data) {
        var cards = '<div class="row row-cols-1 row-cols-md-3 g-4">';
        if(data.length > 0) {
            $.each(data, function(i, item){
                if(type==0)
                cards+='<div class="col"><div class="card border-success mb-3" style="max-width: 18rem;"><div class="card-header">' + item.icon + ' <span class="badge bg-success">' + item.denomination + '</span><br> <button data-bs-toggle="modal" data-bs-target="#EditModal" id = "btnLow" onclick="Edit(' + item.component_id + ')" class="btn btn-secondary btn-sm"><i class="fa-solid fa-pencil" aria-hidden="true" data-toggle="tooltip" data-placement="top" title="Editar Componente"></i></button> <button class="btn btn-danger btn-sm" onclick="Delete(' + item.component_id + ',' + item.device_id + ',\'' + desc + '\')"><i class="fa-solid fa-trash" aria-hidden="true" data-toggle="tooltip" data-placement="top" title="Eliminar componente"></i></button> <button class="btn btn-warning btn-sm" onclick="Low(' + item.component_id + ',' + item.device_id + ',\'' + desc + '\')"><i class="fa-solid fa-down-long" aria-hidden="true" data-toggle="tooltip" data-placement="top" title="Dar de baja"></i></button></div><div class="card-body text-success"><h6 class="card-title"><span class="badge bg-success">' + item.trademark + ' ' + item.features + '</span></h6><ul class="list-group"><li class="list-group-item">Adquirido: ' + (item.acquired != null ? item.acquired : '') +  '</li><li class="list-group-item">Caducidad: ' + (item.date_of_expiry != null ? item.date_of_expiry : '') +  '</li><li class="list-group-item">Precio: $ ' +  (item.amount != null ? item.amount : '') + '</li><li class="list-group-item">Antigüedad: ' + item.time + ' </li></ul></div></div></div>';
                else    
                cards+='<div class="col"><div class="card border-danger mb-3" style="max-width: 18rem;"><div class="card-header">' + item.icon + ' <span class="badge bg-danger">' + item.denomination + '</span></div><div class="card-body text-success"><h6 class="card-title"><span class="badge bg-danger">' + item.trademark + ' ' + item.features + '</span></h6><ul class="list-group"><li class="list-group-item">Adquirido: ' + (item.acquired != null ? item.acquired : '') +  '</li><li class="list-group-item">Caducidad: ' + (item.date_of_expiry != null ? item.date_of_expiry : '') +  '</li><li class="list-group-item">Precio: $ ' +  (item.amount != null ? item.amount : '') + '</li><li class="list-group-item">Baja: ' + (item.discharge_date != null ? item.discharge_date : '') + ' </li></ul></div></div></div>';
                });
            }
        cards+='</div>';
        $("#listContent").html(cards);
        $("#det").html("<b> Componentes de: </b>" + desc); 
    }
})
} 
////// Traigo Hardware para el select del formulario
function hw(id) {
var url = '{{ route("components.hw") }}';
$.ajax({
    url: url,
    type: "GET",
    dataType: "json",
        success: function (data) {
            var op;
            $.each(data,function(i, hw) {
                op+='<option value=' + hw.hardware_id + (hw.hardware_id = id ? '' : 'selected') + '>' + hw.denomination + '</option>';
                });
            $("#hardware_id_edit").html(op); 
    }
})
} 
/////
function Edit(id) {
var url = '{{ route("components.show", ["id" => "x"]) }}';
url = url.replace('x', id);
$.ajax({
    url: url,
    type: "GET",
    dataType: "json",
        success: function (data) {
        var cards = '<div class="row">';
        if(data.length > 0) {
            $.each(data, function(i, item){
                cards+='<form action="../components-u" method="POST">@csrf<div class="form-row"><div class="col-auto"><label for="hardware_id_edit">COMPONENTE</label><select class="form-control form-control-sm" id="hardware_id_edit" name="hardware_id" onfocus="hw(' + item.hardware_id + ')" required>';
                cards+='<option id="opt" value="' + item.hardware_id + '">' + item.denomination + '</option>';
                cards+='</select></div></div>';
                cards+='<div class="form-row"><div class="col-auto"><label for="trademark_id">MARCA</label><input type="text" class="form-control form-control-sm" id="trademark_id" name="trademark" maxlength="100" value="' + item.trademark + '" required></div>';
                cards+='<div class="col-auto"><label for="features_id">CARACTERÍSTICAS</label><input type="text" class="form-control form-control-sm" id="features_id" name="features" maxlength="100" value="' + item.features + '" required></div></div>';
                cards+='<div class="form-row"><div class="form-check form-switch"><input class="form-check-input" type="checkbox" id="original_id" name="original" ' + (item.original != 1 ? '' : 'checked') + ' ><label class="form-check-label" for="original_id">ORIGINAL</label></div>';
                cards+='<div class="col-auto"><label for="acquired_id">ADQUIRIDO</label><input type="date" class="form-control form-control-sm" id="acquired_id" name="acquired" value="' + item.acquired + '" required></div>';
                cards+='<div class="col-auto"><label for="date_of_expiry_id">FECHA CADUCIDAD</label><input type="date" class="form-control form-control-sm" id="date_of_expiry_id" name="date_of_expiry" value="' + item.date_of_expiry + '"></div>';
                cards+='<div class="col-auto"><label for="amount_id">PRECIO</label><input type="number" class="form-control form-control-sm" id="amount_id" name="amount" value="' + item.amount + '" required></div></div>';
                cards+='<hr><input type="hidden" id = "device_id" name="device_id" value="' + item.device_id + '"><input type="hidden" value="'+ item.component_id + '" id="component_id" name="component_id"><input type="hidden" value="'+ item.customer_id + '" id="customer_id" name="customer_id">';
                cards+='<div id="alert_id_edit"></div>';
                cards+='<button type="submit" class="btn btn-success"><i class="fas fa-check"></i></button></form>';
                });
            }
        cards+='</div>';
        $("#formEdit").html(cards); 

    }
})
} 
</script>
@endsection
