@extends('layouts.presensi');
@section('header')
{{-- header --}}
<div class="appHeader bg-primary text-light ">
    <div class="left">
        <a href="javascript:;" class="headerButton goBack">
            <ion-icon name="chevron-back-outline"></ion-icon>
        </a>
    </div>
    <div class="pageTitle">Izin</div>
    <div class="right"></div>
</div>
{{-- form --}}

@endsection
<div class="row" style="margin-top: 70px">
    <div class="col">
        @php
        $messagesuccess = Session::get('success');
        $messageerror = Session::get('error')
        @endphp
        @if(Session::get('success'))
        <div class="alert alert-success">
            {{$messagesuccess}}
        </div>
        @elseif(Session::get('error'))
        <div class="alert alert-danger">
            {{$messageerror}}
        </div>
        @endif
    </div>
</div>
<div class="row">
    <div class="col">
        @foreach ($dataizin as $item)

        <ul class="listview image-listview">
            <li>
                <div class="item">

                    <div class="in">
                        <div>
                            <b>{{date('d-m-Y', strtotime($item->tgl_izin))}} ({{$item->status == "s" ? "Sakit" : "Izin"}})</b><br>
                            <small class="text-muted">{{$item->keterangan}}</small>
                        </div>
                        @if($item->status_approved == 0) 
                            <span class="badge bg-warning">Waiting</span>
                        @elseif($item->status_approved == 1)
                            <span class="badge bg-success">Approved</span>
                        @elseif($item->status_approved == 2 ) 
                            <span class="badge bg-danger">Decline</span>
                        @endif
                    </div>
                </div>

            </li>
        </ul>
        @endforeach
    </div>
</div>
@section('content')

<div class="fab-button bottom-right" style="margin-bottom: 70px">
    <a href="/presensi/buatizin" class="fab">
        <ion-icon name="add-circle-outline"></ion-icon>
    </a>
</div>
@endsection
