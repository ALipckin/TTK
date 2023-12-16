@extends('layouts.app')
@section('content')
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.3.1/dist/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <div class="col-md-6 mt-5">
        <h5 class="mb-3">{{$ttk->name}}.</h5>
    
        <img class="mb-3" src="{{ asset('images/'.$ttk->image) }}" alt="Image" width="500" height="600">
        
        <div class="mb-3 form-check">
            <input class="form-check-input" type="checkbox" name="flexRadioDisabled" id="flexRadioDisabled" {{$ttk->open == true ? 'checked' : ''}} disabled>
            <label class="form-check-label" for="flexRadioCheckedDisabled">
              Публикация
            </label>
        </div>
            
        <div class="mb-2">
            <a href="{{ route('ttk.edit', $ttk->id) }}">Edit</a>
        </div>
        <div class="mb-2">
            <form action="{{route('ttk.delete', $ttk->id)}}"  method="POST">
                @csrf
                @method('delete')
                <input type="submit" value="Delete" class="btn btn-danger">
            </form>
        </div>
    
        <div class="mb-2">
            <a href="{{route('ttk.index')}}">Назад</a>
        </div>
    </div>
@endsection