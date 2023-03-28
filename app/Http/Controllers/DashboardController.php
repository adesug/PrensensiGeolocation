<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index() {
        $hariIni = date("Y-m-d");
        $bulanIni = date('m')*1;
        $tahunIni = date('Y');
        $nik = Auth::guard('karyawan')->user()->nik;
        $presensiHariIni = DB::table('presensis')->where('nik',$nik)->where('tgl_presensi',$hariIni)->first();
        $historiBulanIni = DB::table('presensis')->where('nik',$nik)->whereRaw('MONTH(tgl_presensi)="'.$bulanIni.'"')
        ->whereRaw('YEAR(tgl_presensi)="'.$tahunIni.'"')
        ->orderBy('tgl_presensi')
        ->get();
        $rekapPresensi = DB::table('presensis')
        ->selectRaw('COUNT(nik) as jmlhadir, SUM(IF(jam_in > "07:00",1,0)) as jmlterlambat')
        ->where('nik',$nik)
        ->whereRaw('MONTH(tgl_presensi)="'.$bulanIni.'"')
        ->whereRaw('YEAR(tgl_presensi)="'.$tahunIni.'"')
        ->first();

        $leaderboard = DB::table('presensis')
        ->join('karyawans','presensis.nik', '=', 'karyawans.nik')
        ->where('tgl_presensi', $hariIni)
        ->orderBy('jam_in')
        ->get();
        // dd($leaderboard);
        $namaBulan = ["","Januari","February","Maret","April","Mei","Juni","Juli","Agustus","September","Oktober","November","Desember"];
        return view('dashboard.dashboard',compact('presensiHariIni','historiBulanIni','namaBulan','bulanIni','tahunIni','rekapPresensi','leaderboard'));
    }
}
