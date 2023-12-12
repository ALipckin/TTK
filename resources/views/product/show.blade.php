<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Dashboard') }}
        </h2>
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.3.1/dist/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    </x-slot>

        <div>{{$product->id}}. {{$product->name}}.</div>
        <ul class="list-group">
            <li class="list-group-item">Жиры: {{$product->protein}}</li>
            <li class="list-group-item">Белки: {{$product->carbs}}</li>
            <li class="list-group-item">Углеводы: {{$product->fat}}</li>
            <li class="list-group-item">Вода: {{$product->water}}</li>
            <li class="list-group-item">Клетчатка: {{$product->fiber}}</li>
            <li class="list-group-item">Зола: {{$product->ash}}</li>
        </ul>
 
    <div>
        <a href="{{ route('product.edit', $product->id) }}">Edit</a>
    </div>
    <div>
        <form action="{{route('product.delete', $product->id)}}"  method="POST">
            @csrf
            @method('delete')
            <input type="submit" value="Delete" class="btn btn-danger">
        </form>
    </div>
    <div>
        <a href="{{route('product.index')}}">Back</a>
    </div>
</x-app-layout>