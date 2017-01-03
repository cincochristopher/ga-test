<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;

use Illuminate\Http\Request;

use App\Models\Provider;
use App\Models\Program;

use App\Repositories\ProgramRepositoryEloquent;
use App\Repositories\ProviderRepositoryEloquent;
use Cache;

class ProviderController extends Controller
{

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
    }

    /**
     * Display providers page.
     *
     * @return view
     */
    public function getProviders(Request $request, $alias)
    {
        $alias = $alias;

        $title = "CIS Abroad";

        $programs = array(
                "0" => array(
                    "name"=> "Semester in Florence",
                    "description"=> "Spend a summer studying abroad in the Florence. You will take two classes for six credits, and get the opportunity to live abroad for a summer and receive university credit. ",
                    "directory"=> array(
                        "id"=> 1,
                        "name"=> "Study Abroad",
                        "alias"=> "study-abroad",
                        "abbreviation"=> "SA"
                    )
                ),
                "1" => array(
                    "name"=> "Adventure in Africa",
                    "description"=> "Africa is an amazing place to call home during your summer abroad! Summer in Africa lets you choose just how long your summer program lasts and how many ",
                    "directory"=> array(
                        "id"=> 1,
                        "name"=> "Adventure Travel",
                        "alias"=> "study-abroad",
                        "abbreviation"=> "SA"
                    )
                )
            );
        return view('pages.provider', compact('title', 'programs'));
    }

    public function getProvider($providerAlias, ProviderRepositoryEloquent $providerRepositoryEloquent, ProgramRepositoryEloquent $programRepositoryEloquent)
    {

        $provider = remember('provider.'.$providerAlias, 60, $providerRepositoryEloquent->fetchProviderByAlias($providerAlias));
        $programs = remember('program.'.$provider->clientID, 60, $programRepositoryEloquent->fetchProgramsByProviderID($provider ? $provider->clientID : -1));

        return view('provider', compact('programs', 'provider'));
    }//end getProvider()
}
