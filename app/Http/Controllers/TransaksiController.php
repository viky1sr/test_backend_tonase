<?php

namespace App\Http\Controllers;

use App\Master\MasterJenisPengadaan;
use App\Models\ErrorHandle;
use App\Models\HistoryTopUp;
use App\Models\HistoryTransfer;
use App\Models\HistoryWithdraw;
use App\Models\SaldoUser;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\DataTables;
use Spatie\Activitylog\Models\Activity;

class TransaksiController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if(\request()->ajax()) {

            $data = Activity::where('log_name','Transfer_Saldo')
                ->whereHas('historytf', function ($query)  {
                    $get_user_id_saldo = SaldoUser::where('user_id', Auth::user()->id)->first();
                    if($get_user_id_saldo) {
                        $query->where('penerima',$get_user_id_saldo->number_card);
                        $query->orWhere('pengirim', Auth::user()->id);
                    } else {
                        $query->where('pengirim', Auth::user()->id);
                    }
                })
                ->get();

            return Datatables::of($data)
                ->addColumn('status', function ($data) {
                    $status_menerima = [];
                    $status_pengirim = [];
                    $get_cuaser = $data->causer_id === Auth::user()->id;

                    if($data->causer_id === Auth::user()->id) {
                        $status_pengirim = 'Mentransfer';
                    } else {
                        $status_menerima = 'DiTransfer';
                    }

                    return ($get_cuaser) ? $status_pengirim : $status_menerima ;

                })

                ->addColumn('name_info', function ($data) {
                    foreach($data->properties as $i) {
                        $get_name = User::where('id',$i['pengirim'])->first();
                        $status_pengirim = [];

                        foreach ($i['saldo_penerima'] as $penerima) {
                            $get_name_penerima =  SaldoUser::with('user')->where('user_id',$penerima['user_id'])->first();
                        }

                        if($data->causer_id === Auth::user()->id) {
                            $status_pengirim = 'Mentransfer';
                        }

                        return $status_pengirim ? "To : "."". $get_name_penerima->user->name : "Form : "."". $get_name->name;
                    }
                })

                ->addColumn('amount_info', function ($data) {
                    foreach($data->properties as $i) {
                        $amount_menerima = [];
                        $amount_pengirim = [];
                        $get_cuaser = $data->causer_id === Auth::user()->id;

                        if($data->causer_id === Auth::user()->id) {
                            $amount_pengirim = '<span class="btn-danger">- '.rupiah($i['amount']).'</span>';
                        } else {
                            $amount_menerima = '<span class="btn-success">+ '.rupiah($i['amount']).'</span>';
                        }

                        return ($get_cuaser) ? $amount_pengirim : $amount_menerima ;
                    }
                })

                ->addColumn('waktu', function ($data) {
                    return Carbon::parse($data->created_at)->format('d M Y g:i A');
                })

                ->addColumn('info_transfer', function ($data) {
                    foreach($data->properties as $i) {
                        $nbcard_menerima = [];
                        $nbcard_pengirim = [];
                        $get_cuaser = $data->causer_id === Auth::user()->id;

                        foreach ($i['saldo_penerima'] as $card_pengirim) {
                            if($data->causer_id === Auth::user()->id) {
                                $nbcard_pengirim = $card_pengirim['number_card'];
                            } else {
                               foreach($i['saldo_pengirim'] as $card_menerima) {
                                   $nbcard_menerima =  $card_menerima['number_card'];
                               }
                            }
                            return ($get_cuaser) ? $nbcard_pengirim : $nbcard_menerima ;
                        }
                    }
                })

                ->rawColumns(['status','name_info','amount_info','waktu','info_transfer'])
                ->addIndexColumn()
                ->make(true);
        }
    }

    public function indexTopUp() {

        if(\request()->ajax()) {
            $data = Activity::where('log_name','Top_Up_Saldo')->where('causer_id', Auth::user()->id)->get();
            return Datatables::of($data)
                ->addColumn('status', function ($data) {
                    $name_success = "Top Up Saldo";
                    if($data->log_name === "Top_Up_Saldo") {
                        return $name_success;
                    }
                })

                ->addColumn('name_info', function ($data) {
                    return $data->causer_id === Auth::user()->id ? Auth::user()->name : "";
                })

                ->addColumn('amount_info', function ($data) {
                    foreach($data->properties as $i) {
                        $amount_top_up = [];

                        if($data->causer_id === Auth::user()->id) {
                            $amount_top_up = '<span class="btn-success">+ '.rupiah($i['amount']).'</span>';
                        }

                        return $amount_top_up ;
                    }
                })

                ->addColumn('waktu', function ($data) {
                    return Carbon::parse($data->created_at)->format('d M Y g:i A');
                })

                ->addColumn('info_transfer', function ($data) {
                    foreach($data->properties as $i) {
                       return $i['card_id'];
                    }
                })


                ->rawColumns(['status','name_info','amount_info','waktu','info_transfer'])
                ->addIndexColumn()
                ->make(true);
        }
    }

    public function indexWithdraw() {
        if(\request()->ajax()) {
            $data = Activity::where('log_name','Withdraw_Saldo')->where('causer_id', Auth::user()->id)->get();
            return Datatables::of($data)
                ->addColumn('status', function ($data) {
                    $name_success = "Withdraw Saldo";
                    if($data->log_name === "Withdraw_Saldo") {
                        return $name_success;
                    }
                })

                ->addColumn('name_info', function ($data) {
                    return $data->causer_id === Auth::user()->id ? Auth::user()->name : "";
                })

                ->addColumn('amount_info', function ($data) {
                    foreach($data->properties as $i) {
                        $amount_top_up = [];

                        if($data->causer_id === Auth::user()->id) {
                            $amount_top_up = '<span class="btn-danger">- '.rupiah($i['amount']).'</span>';
                        }

                        return $amount_top_up ;
                    }
                })

                ->addColumn('waktu', function ($data) {
                    return Carbon::parse($data->created_at)->format('d M Y g:i A');
                })

                ->addColumn('info_transfer', function ($data) {
                    foreach($data->properties as $i) {
                        return $i['card_id'];
                    }
                })

                ->rawColumns(['status','name_info','amount_info','waktu','info_transfer'])
                ->addIndexColumn()
                ->make(true);
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    public function storeAcc(Request $request) {
        $data = $request->all();

        $validator = Validator::make($data,[
            'number_card' => 'required|numeric|unique:saldo_users|digits:11'
        ]);

        if($validator->fails()) {
            return response()->json([
                'status'    => "fails",
                'messages' => $validator->errors()->first(),
            ],422);
        }

        $r = ['.',',00','Rp'];
        $input = [
            'user_id' =>  Auth::user()->id,
            'number_card' => (int) $data['number_card'],
            'amount' => str_replace($r,'',  $data['amount']),
        ];


        SaldoUser::firstOrCreate($input);
        return response()->json([
            'status'    => "ok",
            'messages' => "Berhasil Membuat Account Saldo",
        ], 200);
    }

    public function storeTransfer(Request $request)
    {
        $data = $request->all();

        $validator = Validator::make($data,[
            'penerima' => 'required|numeric|digits:11'
        ]);

        $get_user = SaldoUser::where('user_id',Auth::user()->id)->first();
        $get_users = SaldoUser::where('number_card',$data['penerima'])->get();


        foreach ($get_users as $item) {
            if($item->number_card != $data['penerima']) {
                return response()->json([
                    'status' => 'fail',
                    'messages' => 'Penerima tidak ada / Number card salah',
                ],422);
            }
        }

        if(isset($get_user->amount) ? $get_user->amount === null : '' ) {
            return response()->json([
                'status' => 'fail',
                'messages' => 'Anda belum mempunyain rekening',
            ],422);
        }


        $r = ['.',',00','Rp'];

        if(isset($get_user->amount) ? $get_user->amount  < str_replace($r,'',  $data['amount']) : '') {
            return response()->json([
                'status' => 'fail',
                'messages' => 'Jumlah saldo anda tidak mencukupin',
            ],422);
        }

        if($validator->fails()) {
            return response()->json([
                'status' => 'fail',
                'messages' => $validator->errors()->first(),
            ],422);
        }

        $input = [
            'pengirim' => Auth::user()->id,
            'penerima' => (int)$data['penerima'],
            'amount' => str_replace($r,'',  $data['amount']),
        ];


        $trasnfer = HistoryTransfer::create($input);


        $pengirim = [
            'amount' => $get_user->amount - str_replace($r,'',  $data['amount'])
        ];

        SaldoUser::where('user_id',Auth::user()->id)->update($pengirim);

        $get_penerima = SaldoUser::where('number_card',$trasnfer->penerima)->first();

        $penerima = [
            'amount' => $get_penerima->amount + str_replace($r,'',  $data['amount'])
        ];

        SaldoUser::where('number_card',$trasnfer->penerima)->update($penerima);


        return response()->json([
            'status' => 'ok',
            'messages' => "Berhasil transaksi",
        ], 200);

    }

    public function storeTopUp(Request $request) {
        $data = $request->all();

        $get_error_1064 = ErrorHandle::where('code',1064)->first();

        $alert = [
            'amount.required' => $get_error_1064->message,
        ];

        $validator = Validator::make($data,[
            'amount' => 'required'
        ],$alert);


        if($validator->fails()) {
            return response()->json([
                'status'    => "fail",
                'messages' => $validator->errors()->first(),
            ],422);
        }

        $r = ['.',',00','Rp'];

//        jika ingin mengunakan unit testing $get_user harp di komen dulu line 328

        $get_user = SaldoUser::where('user_id',Auth::user()->id)->first();

        if(str_replace($r,'',  $data['amount']) == 0) {
            return response()->json([
                'status'    => "fail",
                'messages' =>$get_error_1064->message,
            ],422);
        }

        if(str_replace($r,'',  $data['amount']) < 50000) {
            return response()->json([
                'status'    => "fail",
                'messages' => 'Miniaml Top Up Rp. 50.000 !',
            ],422);
        }

        $input = [
            'card_id' =>  $get_user->number_card,
            'amount' => str_replace($r,'',  $data['amount'])
        ];


        HistoryTopUp::firstOrCreate($input);

//        jika ingin mengunakan unit testing $top_up di komentarin dulu line 354-358

        $top_up = [
            'amount' => $get_user->amount + str_replace($r,'',  $data['amount'])
        ];

        SaldoUser::where('user_id',Auth::user()->id)->update($top_up);

        return response()->json([
            'status' => 'ok',
            'messages' => "Berhasil Top Up",
        ], 200);
    }

    public function storeWithdraw(Request $request) {
        $data = $request->all();

        $get_error_1064 = ErrorHandle::where('code',1064)->first();

        $alert = [
            'amount.required' => $get_error_1064->message,
        ];

        $validator = Validator::make($data,[
            'amount' => 'required'
        ],$alert);

        if($validator->fails()) {
            return response()->json([
                'status'    => "fails",
                'messages' => $validator->errors()->first(),
            ],422);
        }

        $r = ['.',',00','Rp'];
        $get_user = SaldoUser::where('user_id',Auth::user()->id)->first();

        if(str_replace($r,'',  $data['amount']) == 0) {
            return response()->json([
                'status'    => "fails",
                'messages' =>$get_error_1064->message,
            ],422);
        }

        if(str_replace($r,'',  $data['amount']) < 50000) {
            return response()->json([
                'status'    => "fails",
                'messages' => 'Miniaml Withdraw Rp. 50.000 !',
            ],422);
        }

        if(isset($get_user->amount) ? $get_user->amount  < str_replace($r,'',  $data['amount']) : '') {
            return response()->json([
                'status' => 'fails',
                'messages' => 'Jumlah saldo anda tidak mencukupin',
            ],422);
        }


        $input = [
            'card_id' => (int) $get_user->number_card,
            'amount' => str_replace($r,'',  $data['amount'])
        ];

        $get_card_id = HistoryWithdraw::create($input);


        $withdraw = [
            'amount' => (int) $get_user->amount - (int) $get_card_id->amount
        ];

//        dd($withdraw);

        SaldoUser::where('user_id',$get_user->user_id)->update($withdraw);

        return response()->json([
            'status' => 'ok',
            'messages' => "Berhasil Withdraw",
        ], 200);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request) {

        $data = $request->all();

        $validator = Validator::make($data,[
            'code' => 'required',
            'message' => 'required',
        ]);

        if($validator->fails()) {
            return response()->json([
                'status'    => "fails",
                'messages' => $validator->errors()->first(),
            ],422);
        }

        $input = [
            'code' => $data['code'],
            'message' => $data['message'],
        ];

        ErrorHandle::create($input);

        return response()->json([
            'status' => 'ok',
            'messages' => "Berhasil create data",
        ], 200);

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
