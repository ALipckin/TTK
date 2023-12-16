@extends('layouts.app')
@section('content')
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.3.1/dist/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <div class="container">
        <div class="row">
            <div class="col-md-6">
                <form action="{{route('requirement.update', $ttk)}}" method = "post">
                    @csrf  
                    @method('PATCH')
                    <div class="mb-3 form-group">
                        <label for="description" class="form-label">Требования к оформлению, подаче и реализации</label>
                        <input value="{{ old('description', $requirement->description) }}" type="text" name="description" class="form-control" id="description" aria-describedby="description" placeholder="&quot Опишите требования к оформлению, подаче и реализации&quot" >
                        @error('description')
                        <p class="text-danger">{{$message}}</p>
                        @enderror
                    </div>
                    <button type="submit" class="btn btn-primary">Создать</button>
                </form>
            </div>
        </div>
    </div>
@endsection
