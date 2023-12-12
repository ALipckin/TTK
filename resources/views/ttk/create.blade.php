<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Dashboard') }}
        </h2>
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.3.1/dist/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    </x-slot>

    <div class="container">
        <div class="row">
            <div class="col-md-6 mt-5">
                <form action="{{route('ttk.store')}}" method = "post" enctype="multipart/form-data">
                    @csrf  
                    <div class="mb-3 form-group">
                        <label for="name" class="form-label">Название</label>
                        <input type="text" name="name" class="form-control" id="name" aria-describedby="name">
                    </div>
                    <div class="mb-3 form-group">
                        <label for="image" class="form-label">Изображение</label>
                        <input type="file" name="image" class="form-control" id="image" aria-describedby="image">
                    </div>
                    <div class="mb-3 form-check">
                        <input type="checkbox" name="open" class="form-check-input" id="open" aria-describedby="open" default="0">
                        <label for="open" class="form-check-label">Публикация</label>
                    </div>
                    <button type="submit" class="btn btn-primary">Создать</button>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
