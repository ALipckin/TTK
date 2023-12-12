<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Dashboard') }}
        </h2>
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.3.1/dist/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    </x-slot>

        <div>{{$header->id}}. {{$header->name}}.</div>
        <ul class="list-group">
            <li class="list-group-item">Название предприятия: {{$header->company}}</li>
            <li class="list-group-item">Название заведения: {{$header->property}}</li>
            <li class="list-group-item">Должность: {{$header->position}}</li>
            <li class="list-group-item">ФИО: {{$header->approver}}</li>
            <li class="list-group-item">Технико-технологическая карта №: {{$header->card}}</li>
            <li class="list-group-item">от: {{$header->created_date}}</li>
            <li class="list-group-item">Название блюда: {{$header->dish}}</li>
            <h3>Конец документа</h3>
            <li class="list-group-item">Разработчик: {{$header->dev}}</li>
            <li class="list-group-item">Должность: {{$header->approver2_position}}</li>
            <li class="list-group-item">ФИО: {{$header->approver2}}</li>
        </ul>
 
        <div class="mb-2">
            <a href="{{ route('header.edit', $ttk->id, $header->id) }}">Редактировать</a>
        </div>
        <div class="mb-2">
            <form action="{{route('header.delete', $ttk->id, $header->id)}}"  method="POST">
                @csrf
                @method('delete')
                <input type="submit" value="Delete" class="btn btn-danger">
            </form>
        </div>
    
        <div class="mb-2">
            <a href="{{route('ttk.index')}}">Назад</a>
        </div>
</x-app-layout>