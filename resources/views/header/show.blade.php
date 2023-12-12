<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Dashboard') }}
        </h2>
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.3.1/dist/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    </x-slot>

    <div class="container">
        <div class="row">
            <div class="col-md-6">
                    <div class="mb-3 form-group">
                        <label for="company" class="form-label">Шапка документа</label>
                        <input value="{{$header->company}}" readonly type="text" name="company" class="form-control" id="company" aria-describedby="company">
                    </div>
                    <div class="mb-3 form-group">
                        <input value="{{$header->property }}" readonly type="property" name="property" class="form-control" id="property" aria-describedby="property">
                    </div>
                    <div class="mb-3 row">
                        <label for="position" class="col-sm-2 col-form-label">Утверждаю</label>
                        <div class="col-sm-10">
                            <input value="{{ $header->position }}" readonly type="text" name ="position" class="form-control" id="position" aria-describedby="position">
                        </div>
                    </div>
                    <div class="mb-3 form-group">
                        <input value="{{ $header->approver}}" readonly type="text" name ="approver" class="form-control" id="approver" aria-describedby="approver">
                    </div>
                    <div class="mb-3 row">
                        <label for="card" class="col-sm-7 col-form-label">Технико-технологическая карта №</label>
                        <div class="col-sm-4">
                            <input value="{{ $header->card }}" readonly readonly type="text" name ="card" class="form-control" id="card" aria-describedby="card">
                        </div>
                    </div>
                    <div class="mb-3 row">
                        <label for="created_date" class="col-sm-2 col-form-label">от</label>
                        <div class="col-sm-10">
                            <input value="{{$header->created_date}}" readonly type="text" name ="created_date" class="form-control" id="created_date" aria-describedby="created_date">
                        </div>
                    </div>
                    <div class="mb-3 form-group">
                        <input value="{{ $header->dish }}" readonly type="text" name ="dish" class="form-control" id="dish" aria-describedby="dish">
                    </div>

                    <label for="company" class="form-label">Конец документа</label>
                    <div class="mb-3 row">
                        <label for="dev" class="col-sm-2 col-form-label">Разработчик</label>
                        <div class="col-sm-10">
                            <input value="{{ $header->dev }}" readonly type="text" name ="dev" class="form-control" id="dev" aria-describedby="dev">
                        </div>
                    </div>
                    <div class="mb-3 form-group">
                        <input value="{{ $header->approver2_position }}" readonly type="text" name ="approver2_position" class="form-control" id="approver2_position" aria-describedby="approver2_position">
                    </div>
                    <div class="mb-3 form-group">
                        <input value="{{ $header->approver2 }}" readonly type="text" name ="approver2" class="form-control" id="approver2" aria-describedby="approver2">
                    </div>
               
            </div>
        </div>
    </div>
</x-app-layout>
