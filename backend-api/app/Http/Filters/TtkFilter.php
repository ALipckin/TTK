<?php


namespace App\Http\Filters;


use Illuminate\Database\Eloquent\Builder;

class TtkFilter extends AbstractFilter
{
    public const NAME = 'name';
    public const CATEGORY_ID = 'category_id';


    protected function getCallbacks(): array
    {
        return [
            self::NAME => [$this, self::NAME],
            self::CATEGORY_ID => [$this, self::CATEGORY_ID],
        ];
    }

    public function name(Builder $builder, $value)
    {
        $builder->where('name', 'like', "%{$value}%");
    }

    public function category_id(Builder $builder, $value)
    {
        $builder->where('category_id', $value);
    }
}
