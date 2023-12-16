@extends('layouts.app')
@section('content')
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.3.1/dist/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <div>
           @if($header != null)
            <a href="{{route('header.show',  $ttk->id, $header)}}">0. Шапка документа</a> 
            <div>
                <a href="{{ route('header.edit', $ttk->id, $header) }}" type="button" class="btn btn-primary mb-3">Редактировать</a>
            </div>
            @else
            <a href="{{route('header.create', $ttk->id)}}">0. Шапка документа</a> 
            @endif 

            
            @if($requirement != null)
            <a href="{{route('requirement.show',  $ttk->id, $requirement)}}">5. Требования к оформлению, подаче и реализации </a> 
            <div>       
                <a href="{{ route('requirement.edit', $ttk->id, $requirement) }}" type="button" class="btn btn-primary mb-3">Редактировать</a>
            </div>
            @else
            <a href="{{route('requirement.create', $ttk->id)}}">5. Требования к оформлению, подаче и реализации</a> 
            @endif 

        {{-- <a href="{{route('.show')}}">1. Область применения</a> --}}
        {{-- <a href="{{route('formulation.show')}}">3. Рецептура</a>
        <a href="{{route('tp.show')}}">4. Описание тех. процесса</a>
        <a href="{{route('form.show')}}">5. Требования к оформлению, подаче и реализации</a>
        <a href="{{route('org_characteristic.show')}}">6.1 Органолептические показатели</a> --}}
        {{-- <a href="{{route('.show')}}">6.2 Нормируемые физико-химические показатели</a> --}}
    </div>
@endsection