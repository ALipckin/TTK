<?php


namespace App\Http\Filters;


use Illuminate\Database\Eloquent\Builder;

class ProductFilter extends AbstractFilter
{
    public const NAME = 'name';
    public const CATEGORY_ID = 'category_id';

    protected function getCallbacks(): array
    {
        return [
            self::NAME => [$this, 'name'],
            self::CATEGORY_ID => [$this, 'categoryId'],
        ];
    }

    public function name(Builder $builder, $value)
    {
        $builder->where('name', 'like', "%{$value}%");
    }

    public function categoryId(Builder $builder, $value)
    {
        // Проверяем, является ли $value массивом
        if (is_array($value)) {
            // Если массив, используем whereIn для фильтрации по нескольким категориям
            $builder->whereIn('category_id', $value);
        } else {
            // Если одиночное значение, используем обычный where
            $builder->where('category_id', $value);
        }
    }
}
