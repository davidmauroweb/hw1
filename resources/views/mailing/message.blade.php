@extends('layouts.app')
@section('content')
<form action="{{route('messages.store')}}" method="POST" enctype="multipart/form-data">
@csrf    
<div class="row">
    <div class="col">
        <div class="mb-3">
            <label for="template_id" class="form-label">Template (REQUERIDO)</label>
            <select class="form-control" id="template_id" name = "template" required>
            <option>SELECCIONE PLANTILLA</option>
                @foreach ($templates as $template)
                <option value="{{$template->template_id}}">{{$template->name}}</option>
            @endforeach
            </select>   
        </div>
    </div>    
    <div class="col">   
        <div class="mb-3">
            <label for="subject_id" class="form-label">Asunto (REQUERIDO)</label>
            <input type="text" class="form-control" id="subject_id" name = "subject" @if (isset($message->subject)) value="{{$message->subject}}" @endif maxlength="100" required>
        </div> 
    </div>
</div>
<div class="row">
    <div class="col">
        <div class="mb-3">
            <label for="title_id" class="form-label">Título / Primer Línea (Énfasis)</label>
        <input type="text" class="form-control" id="title_id" name = "title" @if (isset($message->title)) value="{{$message->title}}" @endif maxlength="100">
        </div> 
    </div>
</div> 
<div class="row">
    <div class="col">
        <div class="mb-3">
            <label for="header_id" class="form-label">Encabezado (Primer Bloque)</label>
            <textarea class="form-control" id="header_id" name="header" rows="1"maxlength="500"> @if (isset($message->body)){{$message->body}}@endif</textarea>
        </div>
    </div>
</div> 
<div class="row">
    <div class="col">
        <div class="mb-3">
            <label for="body_id" class="form-label">Cuerpo / Mensaje</label>
            <textarea class="form-control" id="body_id" name="body" rows="2"maxlength="2500"> @if (isset($message->body)){{$message->body}}@endif</textarea>
        </div>
    </div>
</div>    
<div class="row">
    <div class="col">
        <div class="mb-3">
            <label for="footer_id" class="form-label">Pie / Firma</label>
            <input type="text" class="form-control" id="footer_id" name = "footer" @if (isset($message->footer)) value="{{$message->footer}}" @endif maxlength="500">
        </div>
    </div>
</div> 
<div class="row">
    <div class="col">
        <div class="mb-3">
            <label for="sender_id" class="form-label">Remitente (REQUERIDO)</label>
            <input type="email" class="form-control" id="sender_id" name = "sender" maxlength="100" @if (isset($message->sender)) value="{{$message->sender}}" @endif required>
        </div>
    </div>
    <div class="col">
        <div class="mb-3">
            <label for="button_id" class="form-label">Botón o Enlace (REQUERIDO)</label>
            <input type="text" class="form-control" id="button_id" name = "button" maxlength="50" @if (isset($message->button)) value="{{$message->button}}" @endif required>
        </div>
    </div>      
    <div class="col">   
        <div class="mb-3">
            <label for="logo_id" class="form-label">Logo</label>
        <input type="file" class="form-control" id="logo_id" name = "logo">
        </div> 
    </div>
    @if(isset($message->logo))
    <div class="col">   
        <div class="mb-3">
        <img src="{{route('messages.image', $message->logo)}}" height="80" width="120">
        </div> 
    </div>
    @endif
</div>
<input type="hidden" value="@if(isset($message->message_id)){{$message->message_id}}@else 0 @endif" name="message_id">
<button type="submit" class="btn btn-primary">ACEPTAR</button>
</form>
@endsection