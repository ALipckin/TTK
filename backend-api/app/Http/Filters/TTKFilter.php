<?php


namespace App\Http\Filters;


use Illuminate\Database\Eloquent\Builder;

class TTKFilter extends AbstractFilter
{
    public const NAME = 'name';
    public const USER_ID = 'user_ID';


    protected function getCallbacks(): array
    {
        return [
            self::NAME => [$this, 'name'],
            self::USER_ID => [$this, 'user_ID'],
        ];
    }

    public function name(Builder $builder, $value)
    {
        $builder->where('name', 'like', "%{$value}%");
    }

    public function user_ID(Builder $builder, $value)
    {
        $builder->where('user_ID', $value);
    }
}
