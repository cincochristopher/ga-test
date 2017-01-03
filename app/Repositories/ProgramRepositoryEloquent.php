<?php

namespace App\Repositories;

use DB;

use App\Models\Program;
use App\Repositories\ProgramRepository;

use Illuminate\Support\Collection;

use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;

/**
 * Class GaArticleRepositoryEloquent
 * @package namespace App\Repositories;
 */
class ProgramRepositoryEloquent extends BaseRepository implements ProgramRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return Program::class;
    }

    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }

    public function fetchProgramsByProviderID($providerID)
    {
        $model = $this->model
            ->distinct()
            ->where('clientID', $providerID)
            ->take(10)
            ->get();
        return $model;
    }

}
