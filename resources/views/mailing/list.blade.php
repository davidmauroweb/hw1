@extends('layouts.app')
@section('content')

<div class="modal fade" id="SendModal" tabindex="-1" role="dialog" aria-labelledby="SendModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="SendModalLabel">ENVIAR MENSAJE</h5>
        </div>
        <div class="modal-body">
         <form id ="frmSend" method="POST">
         @csrf
         <div class="form-row">
            <div class="col-auto">
                <label for="email_id">CORREO ELECTRÓNICO</label>
                <input type="email" class="form-control form-control-sm" id="email_id" name = "email" maxlength="100" required>
            </div>
         </div>
         <div class="form-row">
            <div class="col-auto">
                <label for="name_id">NOMBRE</label>
                <input type="text" class="form-control form-control-sm" id="name_id" name = "name" maxlength="100" required>
            </div>
         </div>
        <hr>
       <input type="hidden" value="0" id = "message_id" name="message_id">
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

  <div class="modal fade" id="StateModal" tabindex="-1" role="dialog" aria-labelledby="StateModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title">TRAZABILIDAD</h5>
        </div>
        <div class="modal-body">
        <table class="table table-sm table-bordered">
          <thead>
          </thead>
          <tbody id="stateContent">
          </tbody>
        </table>
        </div>
        <div class="modal-footer">
           <button type="button" class="btn btn-info" data-bs-dismiss="modal"><i class="fas fa-times"></i></button>
        </div>
      </div>
  </div>
  </div>


<div class="row">
                <div class="col-sm-12 mx-auto">
                    <table id="messagesTable" class="table table-sm table-hover;">
                        <thead>
                            <tr style="background-color:gray ; color:white;">
                                <th>#</th>
                                <th>USUARIO</th>
                                <th>ASUNTO</th>
                                <th>TÍTULO</th>
                                <th>REMITENTE</td>
                                <th>&nbsp;</th>
                                <th>&nbsp;</th>
                                <th>&nbsp;</th>
                            </tr>
                        </thead>
                        <tbody>
                        @foreach ($messages as $message)
                        <tr id="{{$message->message_id}}">    
                        <td>{{$message->message_id}}</td>
                        <td>{{$message->username}}</td>
                        <td>{{$message->subject}}</td>
                        <td>{{$message->title}}</td>
                        <td>{{$message->sender}}</td>
                        <td><a href="{{ route('messages.create', $message->message_id) }}" class="btn btn-dark btn-sm" role="button" aria-pressed="true"><i class="fa-solid fa-pen-to-square" aria-hidden="true" data-toggle="tooltip" data-placement="top" title='Editar'></i></a></td>
                        <td><button data-bs-toggle="modal" data-bs-target="#SendModal" id = 'btnSend' class='btn btn-success btn-sm'><i class="fa-solid fa-envelopes-bulk" aria-hidden="true" data-toggle="tooltip" data-placement="top" title='Enviar Mensaje'></i></button></td>
                        <td><button data-bs-toggle="modal" data-bs-target="#StateModal" id = 'btnState' class='btn btn-info btn-sm'><i class="fa-regular fa-envelope-open" aria-hidden="true" data-toggle="tooltip" data-placement="top" title='Estados'></i></button></td>
                        </tr>
                        @endforeach    
                        </tbody>
                    </table>
                    <div class="d-flex">
                        {{ $messages->links() }} </div>
                </div>
            </div>
            <div class="row">
        <div class="col"><hr></div>
    </div>
   
      <div class="row d-flex h-100 justify-content-center">
        <div class="col-sm-auto">
          <a href="{{route('messages.create')}}"> <button id = "btnNuevo" class="btn btn-primary"><i class="fa-solid fa-file-pen fa-2x" aria-hidden="true" data-toggle="tooltip" data-placement="top" title='Nuevo Mensaje'></i></button></a></div>
      </div>       
  
<script>
$( document ).ready(function() {
    
$("body").tooltip({
                    selector: '[data-toggle="tooltip"]',
                    container: 'body'
}); 

$('#messagesTable tbody').on( 'click', '#btnSend', function () {
    var row = $(this).closest('tr');
   $('#message_id').val(row.attr('id'));
  });

$('#messagesTable tbody').on( 'click', '#btnState', function () {
    var row = $(this).closest('tr');
    var url = '{{ route("state.index", "_id") }}';
    url = url.replace('_id', row.attr('id')); 

 $.ajax({
 url: url,
 type: "GET",
 dataType: "json",
 success: function (data) {
   var states = '';
   if(data.length > 0) {
       $.each(data, function(i, item){
        states+= '<tr><td>' + item.created.substring(0,19).replace('T', ' ') + '</td><td>' + item.name + '</td><td>' + item.email + '</td><td>' + (item.checked == 1 ? '<i style="color:red" class="fa-regular fa-envelope-open"></i>' : '<i style="color:green" class="fa-regular fa-envelope"></i>') + '</td></tr>';
    });
}
$("#stateContent").html(states); 

}
})

  });

});


$("#frmSend").submit(function(e) {

e.preventDefault();
e.stopImmediatePropagation(); 

var handle201 = function(data, textStatus, jqXHR) {
       $('#alert_id').html('<div class="alert alert-success alert-dismissible fade show" role="alert">¡Correo electrónico enviado satisfactoriamente!<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button></div>');
};

var token = $("meta[name='csrf-token']").attr("content");
$.ajax({
       url: "{{route('receiver.store')}}",
       type: "POST",
       dataType : "json",
       data: $(this).serialize(),
       statusCode: { 201: handle201 }    
         });
});

</script>
@endsection