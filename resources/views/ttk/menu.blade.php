<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Dashboard') }}
        </h2>
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.3.1/dist/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    </x-slot>

    <div>
           @if($header != null)
            <a href="{{route('header.show',  $ttk->id, $header->id)}}">0. Шапка документа</a> 
            @else
            <a href="{{route('header.create', $ttk->id)}}">0. Шапка документа</a> 
            @endif 
        </a>
        
        

        {{-- <a href="{{route('.show')}}">1. Область применения</a> --}}
        {{-- <a href="{{route('requirement.show')}}">2. Требования к качеству сырья</a>
        <a href="{{route('formulation.show')}}">3. Рецептура</a>
        <a href="{{route('tp.show')}}">4. Описание тех. процесса</a>
        <a href="{{route('form.show')}}">5. Требования к оформлению, подаче и реализации</a>
        <a href="{{route('org_characteristic.show')}}">6.1 Органолептические показатели</a> --}}
        {{-- <a href="{{route('.show')}}">6.2 Нормируемые физико-химические показатели</a> --}}
    </div>
</x-app-layout>