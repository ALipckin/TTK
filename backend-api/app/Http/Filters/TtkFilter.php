<?php


namespace App\Http\Filters;


use App\Models\TtkCategory;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Log;

class TtkFilter extends AbstractFilter
{
    public const NAME = 'name';
    public const USER_ID = 'user_id';
    public const CATEGORY_ID = 'category_id';

    protected function getCallbacks(): array
    {
        return [
            self::NAME => [$this, self::NAME],
            self::USER_ID => [$this, self::USER_ID],
            self::CATEGORY_ID => [$this, 'category_id'],
        ];
    }
    public function name(Builder $builder, $value)
    {
        $builder->where('name', 'like', "%{$value}%");
    }
    public function user_id(Builder $builder, $ids)
    {
        Log::info("ids = ". json_encode($ids));

        // Убедимся, что $ids является массивом
        if (!is_array($ids)) {
            $ids = [$ids]; // Приводим к массиву
        }

        $builder->whereIn('user_id', $ids);
    }
    public function category_id(Builder $builder, $value)
    {
        // Если $value не массив, делаем его массивом
        if (!is_array($value)) {
            $value = [$value];
        }
        $ids = [];

        foreach ($value as $category_id) {
            // Получаем все дочерние категории для каждой категории из массива
            $childCategories = $this->getChildCategories($category_id);
            // Добавляем основную категорию и дочерние в массив $ids
            $ids = array_merge($ids, [$category_id], $childCategories);
        }

        // Применяем фильтр whereIn для всех категорий
        $builder->whereIn('category_id', $ids);
    }

    private function getChildCategories($category_id)
    {
        // Предположим, у вас есть модель Category с методом для получения дочерних категорий
        $category = TtkCategory::find($category_id);

        if (!$category) {
            return [];
        }

        // Рекурсивно получаем дочерние категории
        $children = $category->children()->pluck('id')->toArray();

        foreach ($children as $childId) {
            $children = array_merge($children, $this->getChildCategories($childId));
        }

        return $children;
    }
}
