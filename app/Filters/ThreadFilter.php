<?php
namespace App\Filters;
use App\User;
use Illuminate\Http\Request;
use phpDocumentor\Reflection\Types\This;

class ThreadFilter extends Filters
{
    protected $filters = ['by','popular'];

    /**
     * Filter the Query by username
     * @param $username
     * @return mixed
     */
    public function by($username)
    {
        $user = User::where('name', $username)->firstOrFail();
        return $this->builder->where('user_id', $user->id);
    }

    /**
     * Filter the Query according to most popular threads
     * @return This
     */
    public function popular()
    {
        $this->builder->getQuery()->orders = [];
        return $this->builder->orderBy('replies_count','desc');
    }
}