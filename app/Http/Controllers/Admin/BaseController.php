<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Helper;

class BaseController extends Controller
{
    public function GetAdminData() {
        Helper::checkAdminAccess();
        
        // $Data = ExecuteStoredProcedure('GetAdminData', ['UserId' => Auth::user()->id]);
        $Data = null;
        $AdminData['AdminMenu'] = $Data; //$Data[0];
        return $AdminData;
    }
}
