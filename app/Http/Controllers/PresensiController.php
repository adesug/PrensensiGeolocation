<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Redirect;


class PresensiController extends Controller
{
    function distance($lat1 , $lon1 , $lat2 , $lon2)
    {
        $theta = $lon1 - $lon2;
        $miles = (sin(deg2rad($lat1)) * sin(deg2rad($lat2))) + (cos(deg2rad($lat1)) * cos(deg2rad($lat2)) * cos(deg2rad($theta)));
        $miles = acos($miles) ;
        $miles = rad2deg($miles) ;
        $miles = $miles * 60 * 1.1515 ;
        $feet = $miles * 5280 ;
        $yards = $feet/3 ;
        $kilometers = $miles * 1.609344;
        $meters = $kilometers * 1000;
        return compact('meters');
    }
    public function create() 
    {
        $hariini = date("Y-m-d");
        $nik = Auth::guard('karyawan')->user()->nik;
        $cek= DB::table('presensis')->where('tgl_presensi', $hariini)->where('nik',$nik)->count();
        return view('presensi.create',compact('cek'));
    }
    public function store(Request $request) 
    {
        $nik = Auth::guard('karyawan')->user()->nik;
        $tgl_presensi = date('Y-m-d');
        $jam = date('H:i:s');
        // $latitudeKantor = -6.9173019768128485; 
        // $longitudeKantor = 107.61007456296822;
        $lokasi = $request->lokasi;

        $lokasiUser = explode(",", $lokasi);
       
        $latitudeUser = $lokasiUser[0];
        $longitudeUser = $lokasiUser[1];
        $latitudeKantor = $latitudeUser;
        $longitudeKantor = $longitudeUser;

        $jarak = $this->distance($latitudeKantor,$longitudeKantor,$latitudeUser,$longitudeUser);
        $radius =  round($jarak["meters"]);
        $cek= DB::table('presensis')->where('tgl_presensi', $tgl_presensi)->where('nik',$nik)->count();
        if( $cek > 0 ) {
            $ket = "in";
        }else {
            $ket = "out";
        }
        $image = $request->image;
        $folderPath = "public/uploads/absensi/";
        $formatName = $nik . "-" . $tgl_presensi . "-" . $ket;
        $image_parts = explode(";base64", $image);
        $image_base64 = base64_decode($image_parts[1]);
        $fileName = $formatName . ".png" ;
        $file = $folderPath . $fileName ;

        if($radius > 20 ) {
            echo "error|Mohon maaf jarak anda diluar radius, jarak anda " .$radius. " meter dari kantor|radius";
        }else {
            if($cek > 0 ) {
                $data_pulang = [
                    'jam_out' => $jam,
                    'foto_out' => $fileName,
                    'lokasi_out' => $lokasi,
                ];
                $update = DB::table('presensis')->where('tgl_presensi',$tgl_presensi)->where('nik',$nik)->update($data_pulang);
                if($update) {
                    echo "success|Terimakasih, Hati Hati Di jalan|out";
                    Storage::put($file, $image_base64);
                }else {
                    echo 'error|Maaf Gagal Absen, Hubungi Tim IT|out';
                }
            }else {
                $data = [
                    'nik' => $nik,
                    'tgl_presensi' => $tgl_presensi, 
                    'jam_in' => $jam,
                    'foto_in' => $fileName,
                    'lokasi_in' => $lokasi,
                ];
               
                $simpan = DB::table('presensis')->insert($data);
                if($simpan) {
                    echo "success|Terimakasih, Selamat Bekerja|in";
                    Storage::put($file, $image_base64);
                }else {
                    echo 'error|Maaf Gagal Absen, Hubungi Tim IT|in';
                }
            }
        }
       
        
      
        
    }
    public function editProfile() {
        $nik = Auth::guard('karyawan')->user()->nik;
        $karyawan = DB::table('karyawans')->where('nik',$nik)->first();

        return view('presensi.editProfile', compact('karyawan'));
    }
    public function updateProfile(Request $request) {
        $nik = Auth::guard('karyawan')->user()->nik;
        $nama_lengkap = $request->nama_lengkap;
        $no_hp = $request->no_hp;
        $password = Hash::make($request->password);
        $karyawan = DB::table('karyawans')->where('nik',$nik)->first();

        if($request->hasFile('foto')){
            $foto = $nik . "." . $request->file('foto')->getClientOriginalExtension();
        }else {
            $foto = $karyawan->foto;
        }

        if(empty($requets->password)) {
            $data = [
                'nama_lengkap' => $nama_lengkap,
                'no_hp' => $no_hp,  
                'foto' => $foto
            ];
        }else{
            $data = [
                'nama_lengkap' => $nama_lengkap,
                'no_hp' => $no_hp,
                'password' => $password,
                'foto' => $foto
            ];
        }

        $update = DB::table('karyawans')->where('nik',$nik)->update($data);

        if($update) {
            if($request->hasFile('foto')){
                $folderPath = "public/uploads/karyawan/"; 
                $request->file('foto')->storeAs($folderPath,$foto);
            }
            return Redirect::back()->with(['success'=>'Data berhasil diupdate']);
        }else{
            return Redirect::back()->with(['error'=>'Data gagal diupdate']);
        }

       
    }
    public function histori() {
        $namaBulan = ["","Januari","Feburari","Maret","April","Mei","Juni","Juli","Agustus","September","Oktober","November","Desember"];
        return view('presensi.histori',compact('namaBulan'));
    }

    public function getHistori (Request $request) {
        $bulan = $request->bulan;
        $tahun = $request->tahun;
        $nik = Auth::guard('karyawan')->user()->nik;

        $histori = DB::table('presensis')
        ->whereRaw('MONTH(tgl_presensi)="' . $bulan . '"')
        ->whereRaw('YEAR(tgl_presensi)="' . $tahun . '"')
        ->where('nik',$nik)
        ->orderBy('tgl_presensi')->get();
       
    
            return view('presensi.getHistori',compact('histori'));
        
      
    }
    
}
