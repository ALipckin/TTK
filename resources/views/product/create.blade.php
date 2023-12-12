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
                <form action="{{route('product.store')}}" method = "post">
                    @csrf  
                    <div class="mb-3 form-group">
                    <label for="name" class="form-label">Названиие</label>
                    <input value="{{ old('name') }}" type="text" name="name" class="form-control" id="name" aria-describedby="Название">
                    @error('name')
                    <p class="text-danger">{{$message}}</p>
                    @enderror
                    </div>
                    <div class="mb-3 form-group">
                        <label for="fat" class="form-label">Жиры</label>
                        <input value="{{ old('fat') }}" type="text" name ="fat" class="form-control" id="fat" aria-describedby="fat">
                        @error('fat')
                        <p class="text-danger">{{$message}}</p>
                        @enderror
                    </div>
                    <div class="mb-3 form-group">
                        <label for="protein" class="form-label">Белки</label>
                        <input value="{{ old('protein') }}" type="text" name="protein" class="form-control" id="protein" aria-describedby="protein">
                        @error('protein')
                        <p class="text-danger">{{$message}}</p>
                        @enderror
                    </div>
                    <div class="mb-3 form-group">
                        <label for="carbs" class="form-label">Углеводы</label>
                        <input value="{{ old('carbs') }}" type="text" name ="carbs" class="form-control" id="carbs" aria-describedby="carbs">
                        @error('carbs')
                        <p class="text-danger">{{$message}}</p>
                        @enderror
                    </div>
                    <div class="mb-3 form-group">
                        <label for="water" class="form-label">Вода</label>
                        <input value="{{ old('water') }}" type="text" name ="water" class="form-control" id="water" aria-describedby="water">
                        @error('water')
                        <p class="text-danger">{{$message}}</p>
                        @enderror
                    </div>
                    <div class="mb-3 form-group">
                        <label for="ash" class="form-label">Зола</label>
                        <input value="{{ old('ash') }}" type="text" name ="ash" class="form-control" id="ash" aria-describedby="ash">
                        @error('ash')
                        <p class="text-danger">{{$message}}</p>
                        @enderror
                    </div>
                    <div class="mb-3 form-group">
                        <label for="fiber" class="form-label">Клетчатка</label>
                        <input value="{{ old('fiber') }}" type="text" name ="fiber" class="form-control" id="fiber" aria-describedby="fiber">
                        @error('fiber')
                        <p class="text-danger">{{$message}}</p>
                        @enderror
                    </div>
                    <div class="mb-3 form-group">
                        <label for="category" class="form-label">Категория</label>
                        <select class="form-control" aria-label="Default select example" name="category_id">
                           @foreach($categories as $category)
                            <option 
                                {{old('category_id') == $category->id ? 'selected' : ''}}
                            value="{{$category->id}}">{{$category->title}}</option>
                            @endforeach
                          </select>
                          @error('category_id')
                          <p class="text-danger">{{$message}}</p>
                          @enderror
                    </div>
                    <button type="submit" class="btn btn-primary">Создать</button>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
