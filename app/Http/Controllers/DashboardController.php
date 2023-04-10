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
        $rekapizin = DB::table('pengajuan_izins')
        ->selectRaw('SUM(IF(status="i",1,0)) as jmlizin,SUM(IF(status="s",1,0)) as jmlsakit')
        ->where('nik',$nik)
        ->whereRaw('MONTH(tgl_izin)="'.$bulanIni.'"')
        ->whereRaw('YEAR(tgl_izin)="'.$tahunIni.'"')
        ->where('status_approved',1)
        ->first() ;
        return view('dashboard.dashboard',compact('presensiHariIni','historiBulanIni','namaBulan','bulanIni','tahunIni','rekapPresensi','leaderboard','rekapizin'));
    }
    public function dashboardadmin(){
        return view('dashboard.dashboardadmin');
    }
}
