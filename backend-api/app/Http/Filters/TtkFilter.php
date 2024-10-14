<?php


namespace App\Http\Filters;


use App\Models\TtkCategory;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Log;

class TtkFilter extends AbstractFilter
{
    public const NAME = 'name';
    public const CATEGORY_ID = 'category_id';

    protected function getCallbacks(): array
    {
        return [
            self::NAME => [$this, self::NAME],
            self::CATEGORY_ID => [$this, 'categoryId'],
        ];
    }

    public function name(Builder $builder, $value)
    {
        $builder->where('name', 'like', "%{$value}%");
    }

    public function categoryId(Builder $builder, $value)
    {
        // Если $value не массив, делаем его массивом
        if (!is_array($value)) {
            $value = [$value];
        }
        $ids = [];

        foreach ($value as $categoryId) {
            // Получаем все дочерние категории для каждой категории из массива
            $childCategories = $this->getChildCategories($categoryId);
            // Добавляем основную категорию и дочерние в массив $ids
            $ids = array_merge($ids, [$categoryId], $childCategories);
        }

        // Применяем фильтр whereIn для всех категорий
        $builder->whereIn('category_id', $ids);
    }

    private function getChildCategories($categoryId)
    {
        // Предположим, у вас есть модель Category с методом для получения дочерних категорий
        $category = TtkCategory::find($categoryId);

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
