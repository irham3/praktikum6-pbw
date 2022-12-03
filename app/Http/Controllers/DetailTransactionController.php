<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\Facades\DataTables;

class DetailTransactionController extends Controller
{
    public function getAllDetailTransactions($transactionId)
    {
        $detail_transactions = DB::table('detail_transactions as dt')
        ->select(
            'dt.id',
            'dt.tanggalKembali as tanggalKembali',
            't.tanggalPinjam as tanggalPinjam',
            'dt.status as statusType',
            DB::raw('(
                CASE WHEN dt.status="1" THEN "Pinjam"
                WHEN dt.status="2" THEN "Kembali"
                WHEN dt.status="3" THEN "Hilang"
                )'
            ),
            'c.nama as koleksi')
        ->join('collections as c', 'c.id', '=', 'collectionId')
        ->join('transactions as t', 't.id', '=', 'transactionId')
        ->where('transactionId', '=', $transactionId)->get();

        return DataTables::of($detail_transactions)
        ->addColumn('action', function($detail_transactions) {
                $html = '';
                if($detail_transactions->statusType == "1") {
                    $html='
                    <a class="btn btn-info" href="'.url('detailTransactionKembalikan')."/".$detail_transactions->id.'">Edit</a>
                    ';
                }
                return $html;
            })
        ->make(true);
    }
}
