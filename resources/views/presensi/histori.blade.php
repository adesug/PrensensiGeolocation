@extends('layouts.presensi');
@section('header')
{{-- header --}}
    <div class="appHeader bg-primary text-light ">
        <div class="left">
            <a href="javascript:;" class="headerButton goBack">
                <ion-icon name="chevron-back-outline"></ion-icon>
            </a>
        </div>
        <div class="pageTitle">Histori</div>
        <div class="right"></div>
    </div>
{{-- form --}}

@endsection
@section('content')
<div class="row" style="margin-top: 70px">
    <div class="col">
        <div class="row">
            <div class="col-12">
                <div class="form-group">
                    <select name="bulan" id="bulan" class="form-control">
                        <option value="">Bulan</option>
                        @for($i=1; $i<=12; $i++)
                            <option value="{{$i}}" {{date('m') == $i ? 'selected' : ''}}>{{$namaBulan[$i]}}</option>
                        @endfor
                    </select>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-12">
                <div class="form-group">
                    <select name="tahun" id="tahun" class="form-control">
                        <option value="">Tahun</option>
                        @php
                            $tahunmulai = 2022;
                            $tahunskrng = date('Y');

                        @endphp
                        @for($tahun = $tahunmulai; $tahun <= $tahunskrng; $tahun++)
                            <option value="{{$tahun}}" {{date('Y') == $tahun ? 'selected' : ''}}>{{$tahun}}</option>
                        @endfor
                    </select>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-12">
                <div class="form-group">
                    <button id="getData" class="btn btn-primary btn-block"><ion-icon name="search-outline"></ion-icon>Cari Data</button>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="row">
    <div class="col" id="showHistori">

    </div>
</div>
@endsection
@push('myscript')
    <script>
        $(function() {
            $("#getData").click(function(e) {
                var bulan  = $('#bulan').val();
                var tahun = $('#tahun').val();
                $.ajax({
                    type:'POST',
                    url : '/getHistori',
                    data : {
                        _token :  "{{csrf_token()}}",
                        bulan : bulan,
                        tahun : tahun,
                    },
                    cache:false,
                    success:function(respond) {
                        console.log(respond);
                        $("#showHistori").html(respond);
                    }
                })
            })
        })
    </script>
@endpush