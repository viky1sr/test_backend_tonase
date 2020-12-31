<?php

namespace App\Http\Controllers;

use App\Models\ErrorHandle;
use App\Models\HistoryTransfer;
use App\Models\SaldoUser;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Spatie\Activitylog\Models\Activity;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {

        $data = (object) [
            'LogInfo' => Activity::where('log_name','Transfer_Saldo')->get(),
            'UserSaldo' => SaldoUser::with('user')->where('user_id',Auth::user()->id)->first(),
            'User' => User::with('saldo_user')->where('id',Auth::user()->id)->first(),
            'SaldoUsers' => SaldoUser::with('user')->get(),
            'HistoryTransfer' => HistoryTransfer::with('saldo_pengirim','saldo_penerima')->get(),
        ];

//        dd($data->LogInfo[5]->properties);

        foreach($data->LogInfo as $i) {
            $status_menerima = [];
            $status_pengirim = [];
            $get_cuaser = $i->causer_id === Auth::user()->id;

//            dd($i);

            if($i->causer_id === Auth::user()->id) {
                $status_pengirim = 'Mentransfer';
            } else {
                $status_menerima = 'DiTransfer';
            }

//            dd(($get_cuaser) ? $status_pengirim : $status_menerima );
        }

//        foreach($data->LogInfo as $i) {
//            $i->properties;
//            dd($i);
//            foreach ($i->properties as $p) {
//                dd($p['saldo_penerima'][0]['amount']);
//            }
//        }

//        dd($data->LogInfo[0]->properties);

        return view('home',compact('data'));
    }
}
