<?php

namespace App\Http\Controllers\Administrators;

use App\Http\Controllers\Controller;

class DashboardController extends Controller {

    /**
     * Exibe a tela do dashboard
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index(){
        return view('administrator.dashboard.index');
    }
}
