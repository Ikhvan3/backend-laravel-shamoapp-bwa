<?php

namespace App\Http\Controllers\API;

use App\Helpers\ResponseFormatter;
use App\Http\Controllers\Controller;
use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TransactionController extends Controller
{
    public function all(Request $request)
    {
        $id = $request->input('id');
        $limit = $request->input('limit', 6);
        $status = $request->input('status');

        //ambil berdasarkan id
        if($id){
            $transaction = Transaction::with(['items.product'])->find($id);

            if($transaction)
            {
                return ResponseFormatter::success(
                    $transaction,
                    'Data transaksi berhasil diambil'
                );
            }
            else{
                return ResponseFormatter::error(
                    null,
                    'Data transaksi tidak ada',
                    404
                );
            }
        }

        //ambil berdasarkan semua data

        $transaction = Transaction::with(['items.product'])->where('users_id', Auth::user()->id);

        if($status)
        {
            $transaction->where('status', $status);
        }
        
        return ResponseFormatter::success(
            $transaction->paginate($limit),
            'Data list transaksi berhassil diambil'
        );
    }
}
