@extends('layouts.app')
@section('content')
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.3.1/dist/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <div class="container">
        <div class="row">
            <div class="col-md-6">
                <form action="{{route('ttk.update', $ttk->id)}}" method = "post" enctype="multipart/form-data">
                    @csrf
                    @method('patch')
                    <div class="mb-3 form-group">
                        <label for="name" class="form-label">Название</label>
                        <input type="text" name="name" class="form-control" id="name" aria-describedby="name" value="{{$ttk->name}}">
                    </div>
                    <div class="mb-3 form-group">
                        <label for="image" class="form-label">Изображение</label>
                        <img class="mb-3" src="{{ asset('images/'.$ttk->image) }}" alt="Image" width="500" height="600">
                        <input type="file" name="image" class="form-control" id="image" aria-describedby="image" >
                    </div>
                    <div class="mb-3 form-check">
                        <input class="form-check-input" type="checkbox" name="open" id="open" default="off" aria-describedby="open" {{$ttk->open == true ? 'checked' : ''}}>
                        <label class="form-check-label" for="flexRadioCheckedDisabled">
                          Публикация
                        </label>
                    </div>
                    <button type="submit" class="btn btn-primary">Редактировать</button>
                </form>
            </div>
        </div>
    </div>
@endsection
