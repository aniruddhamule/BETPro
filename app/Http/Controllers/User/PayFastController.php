<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Deposit;
use Illuminate\Support\Facades\Session;

class PayFastController extends Controller
{
    public function success(DepositController $controller)
    {
        $track = Session::get('Track');
        $deposit = Deposit::where('trx',$track)->first();
        if($deposit instanceof Deposit){
            return $controller->userDataUpdate($deposit);
        }
        return redirect()->route('deposit.index')->with('alert', 'Something went wrong.');
    }

    public function cancel(Request $request)
    {
        return redirect()->route('deposit.index')->with('alert', 'Sorry you payment is canceled');
    }

    public function notify(Request $request)
    {
        return redirect()->route('deposit.index')->with('alert', 'Notify Page Viewed.');
    }
}
