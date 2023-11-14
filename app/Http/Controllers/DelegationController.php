<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\DB ;
use Illuminate\View\View;
use App\Models\Delegation;

class DelegationController extends Controller
{    
    /**
     * Just a view for delegation list
     * 
     * @return View
     */
    public function list() : View {
        return view( 'delegation/list' ) ; 
    }

    /**
     * Just a view for adding new delegation 
     * 
     * @return View
     */
    public function add() : View {
        $countryRateList = DB::table( 'countryrate' )->orderby( 'countrycode' )->get() ;

        return view( 'delegation/add', [ 'countryRateList' => $countryRateList ] ) ;
    }
}