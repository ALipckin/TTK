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
                <form action="{{route('product.update', $product->id)}}" method = "post">
                    @csrf  
                    @method('patch')
                    <div class="mb-3 form-group">
                    <label for="name" class="form-label">Название</label>
                    <input type="text" name="name" class="form-control" id="name" aria-describedby="name" value="{{$product->name}}">
                    </div>
                    <div class="mb-3 form-group">
                        <label for="fat" class="form-label">Жиры</label>
                        <input type="text" name ="fat" class="form-control" id="fat" aria-describedby="fat" value="{{$product->fat}}">
                    </div>
                    <div class="mb-3 form-group">
                        <label for="protein" class="form-label">Белки</label>
                        <input type="text" name="protein" class="form-control" id="protein" aria-describedby="protein" value="{{$product->protein}}">
                    </div>
                    <div class="mb-3 form-group">
                        <label for="carbs" class="form-label">Углеводы</label>
                        <input type="text" name ="carbs" class="form-control" id="carbs" aria-describedby="carbs" value="{{$product->carbs}}">
                    </div>
                    <div class="mb-3 form-group">
                        <label for="water" class="form-label">Вода</label>
                        <input type="text" name ="water" class="form-control" id="water" aria-describedby="water" value="{{$product->water}}">
                    </div>
                    <div class="mb-3 form-group">
                        <label for="ash" class="form-label">Зола</label>
                        <input type="text" name ="ash" class="form-control" id="ash" aria-describedby="ash" value="{{$product->ash}}">
                    </div>
                    <div class="mb-3 form-group">
                        <label for="fiber" class="form-label" >Клетчатка</label>
                        <input type="text" name ="fiber" class="form-control" id="fiber" aria-describedby="fiber" value="{{$product->fiber}}">
                    </div>
                    <div class="mb-3 form-group">
                        <label for="category" class="form-label">Категория</label>
                        <select class="form-control" aria-label="Default select example" name="category_id">
                           @foreach($categories as $category)
                            <option 
                                {{$category->id === $product->category_id ? 'selected' : ''}}
                            value="{{$category->id}}">{{$category->title}}</option>
                            @endforeach
                          </select>
                    </div>
                    <button type="submit" class="btn btn-primary">Изменить</button>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
