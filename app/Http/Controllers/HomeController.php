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
//
//        $get_log_id_penerima = Activity::where('log_name','Transfer_Saldo')
//            ->whereHas('historytf', function ($query)  {
//                $get_user_id_saldo = SaldoUser::where('user_id', Auth::user()->id)->first();
//                if($get_user_id_saldo) {
//                    $query->where('penerima',$get_user_id_saldo->number_card);
//                    $query->orWhere('pengirim', Auth::user()->id);
//                }
//            })
//            ->get();
//
//        dd($get_log_id_penerima);

        return view('home',compact('data'));
    }
}
