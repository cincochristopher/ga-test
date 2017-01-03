<?php

namespace App\Repositories;

use DB;

use App\Models\Provider;
use App\Repositories\ProgramRepository;

use Illuminate\Support\Collection;

use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;

/**
 * Class GaArticleRepositoryEloquent
 * @package namespace App\Repositories;
 */
class ProviderRepositoryEloquent extends BaseRepository implements ProgramRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return Provider::class;
    }

    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }

    public function fetchProviderByAlias($alias)
    {
        $model = $this->model
            ->distinct()
            ->where('urlAlias', $alias)
            ->first();

        return $model;
    }

}
