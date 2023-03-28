@extends('layouts.presensi');
@section('header')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0-beta/css/materialize.min.css">

{{-- header --}}
<div class="appHeader bg-primary text-light ">
    <div class="left">
        <a href="javascript:;" class="headerButton goBack">
            <ion-icon name="chevron-back-outline"></ion-icon>
        </a>
    </div>
    <div class="pageTitle">Form Izin / Sakit</div>
    <div class="right"></div>
</div>
{{-- form --}}

@endsection
@section('content')
<div class="row" style="margin-top: 70px">
    <div class="col">
        <form  method="POST" action="/presensi/storeIzin" id="frmIzin">
            @csrf
            <div class="row">
                <div class="col">
                    <div class="form-group">
                        <input type="text" class="form-control datepicker" name="tgl_izin" id="tgl_izin" placeholder="tanggal">
                    </div>
                    <div class="form-group">
                        <select class="form-control" name="status" id="status">
                            <option value="">Izin/Sakit</option>
                            <option value="i">Izin</option>
                            <option value="s">Sakit</option>
                        </select>
                    </div>

                    <div class="form-group">
                        <textarea name="keterangan" id="keterangan" class="form-control" cols="5" rows="5"
                            placeholder="keterangan"></textarea>
                    </div>
                </div>
            </div>
            <div class="form-group">
                <button type="submit" class="btn btn-primary w-100">Kirim</button>
            </div>
        </form>
    </div>
</div>
@endsection
@push('myscript')
<script>
    var currYear = (new Date()).getFullYear();
    $(document).ready(function () {
        $(".datepicker").datepicker({

            format: 'yyyy-mm-dd'
        });
        $("#frmIzin").submit(function() {
            var tgl_izin = $("#tgl_izin").val();
            var status = $("#status").val();
            var keterangan = $("#keterangan").val();
            if(tgl_izin == "") {
               Swal.fire({
                    title: 'Oops !',
                    text :'Tanggal Harus Diisi',
                    icon : 'warning',
               });
                return false;
            }else if(status == "") {
                Swal.fire({
                    title: 'Oops !',
                    text :'Status Harus Diisi',
                    icon : 'warning',
               });
                return false
            }else if(keterangan == ""){
                Swal.fire({
                    title: 'Oops !',
                    text :'Keterangan Harus Diisi',
                    icon : 'warning',
               });
               return false;
            }
        });
       
    });
   

</script>
@endpush
