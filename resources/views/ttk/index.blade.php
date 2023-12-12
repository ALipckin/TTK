<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Dashboard') }}
        </h2>
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.3.1/dist/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    </x-slot>

    <div>
        <div>
            <a href="{{route('ttk.create')}}" type="button" class="btn btn-primary mb-3">Создать</a>
        </div>
        @foreach($ttks as $ttk)
        <div><a href="{{route('ttk.show', $ttk->id)}}">{{$ttk->id}}. {{$ttk->name}}</a></div>
        <div>
            <a href="{{ route('ttk.menu', $ttk->id) }}" type="button" class="btn btn-primary mb-3">Меню создания</a>
        </div>
        @endforeach
    </div>
</x-app-layout>