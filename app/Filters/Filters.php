<?php
namespace App\Filters;
use Illuminate\Http\Request;

abstract class Filters
{

    protected $request,$builder;
    protected $filters = [];

    public function __construct(Request $request)
    {
        $this->request = $request;
    }

    public function apply($builder)
    {
        $this->builder = $builder;

        collect($this->getFilters())
            ->filter(function ($value,$filter){
                return method_exists($this,$filter);
            })
            ->each(function ($value,$filter){
                $this->$filter($value);
            });

//        foreach($this->getFilters() as $filter=>$value){
//             if ( ! $this->hasFilter($filter)) return;
//                 $this->$filter($value);
//        }

        return $this->builder;
    }

    /**
     * @param $filter
     * @return bool
     */
    protected function hasFilter($filter): bool
    {
        return method_exists($this, $filter) && $this->request->has($filter);
    }

    /**
     * @return array
     */
    protected function getFilters(): array
    {
        return $this->request->only($this->filters);
    }
}