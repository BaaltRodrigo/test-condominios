<?php

namespace App\Http\Controllers;

use App\Models\Cobro;
use App\Models\Pago;
use Illuminate\Http\Request;
use Transbank\WebPay\WebPayPlus;
use Transbank\WebPay\WebPayPlus\Transaction;

class TransbankController extends Controller
{
    public function __construnct()
    {
        //
        if (app()->environment('production'))
        {
            WebPayPlus.configureForProduction(
                env('webpay_plus_cc'),
                env('webpay_plus_api_key')
            );
            return self;
        }
        WebPayPlus.configureForTesting();
    }

    public function iniciar(Cobro $cobro, Request $request)
    {
        // Generate webpay transaction
        $pago = Pago::create(["cobro_id" => $cobro->id, "total"=> $cobro->value]);

        $transact = (new Transaction)->create(
            $pago->id, //buyOrder
            $pago->cobro_id, //session_idm
            $pago->total,
            $request->return_url
            // route('transbank.confirm')
        );

        $url = "{$transact->getUrl()}?token_ws={$transact->getToken()}";
        return $url;
        // return URL to pay
    }

    public function confirmar(Request $request)
    {
        $confirm = (new Transaction)->commit($request->token_ws);

        $pago = Pago::where('id', $confirm->buyOrder )->first();

        if ($confirm->isApproved()) {
            // Cambio el estado del cargo a pagado.
            $cobro = $pago->cobro();
            $cobro->update(['status' => 1]);
        }

        return response()->json(['message' => "Payment finished. Please Check"], 200);
    }
}
