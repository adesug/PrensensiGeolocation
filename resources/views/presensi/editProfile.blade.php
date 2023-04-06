@extends('layouts.presensi')
@section('header')
{{-- header --}}
<div class="appHeader bg-primary text-light ">
    <div class="left">
        <a href="javascript:;" class="headerButton goBack">
            <ion-icon name="chevron-back-outline"></ion-icon>
        </a>
    </div>
    <div class="pageTitle">Edit Profile</div>
    <div class="right"></div>
</div>
{{-- form --}}

@endsection
@section('content')
<div class="row" style="margin-top:4rem">
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
<form action="/presensi/{{$karyawan->nik}}/updateprofile" method="POST" enctype="multipart/form-data"
    style="margin-top: 5rem">
    @csrf

    <div class="col">
        <div class="form-group boxed">
            <div class="input-wrapper">
                <input type="text" class="form-control" value="{{$karyawan->nama_lengkap}}" name="nama_lengkap"
                    placeholder="Nama Lengkap" autocomplete="off">
            </div>
        </div>
        <div class="form-group boxed">
            <div class="input-wrapper">
                <input type="text" class="form-control" value="{{$karyawan->no_hp}}" name="no_hp" placeholder="No. HP"
                    autocomplete="off">
            </div>
        </div>
        <div class="form-group boxed">
            <div class="input-wrapper">
                <input type="password" class="form-control" name="password" placeholder="Password" autocomplete="off">
            </div>
        </div>
        <div class="custom-file-upload" id="fileUpload1">
            <input type="file" name="foto" id="fileuploadInput" accept=".png, .jpg, .jpeg">
            <label for="fileuploadInput">
                <span>
                    <strong>
                        <ion-icon name="cloud-upload-outline" role="img" class="md hydrated"
                            aria-label="cloud upload outline"></ion-icon>
                        <i>Tap to Upload</i>
                    </strong>
                </span>
            </label>
            <p id="error1" style="display:none; color:#FF0000;">
                Invalid Image Format! Image Format Must Be JPG, JPEG, PNG or GIF.
            </p>
            <p id="error2" style="display:none; color:#FF0000;">
                Maximum File Size Limit is 1MB.
            </p>
        </div>
        <div class="form-group boxed">
            <div class="input-wrapper">
                <button name="submit" id="submit" type="submit" class="btn btn-primary btn-block">
                    <ion-icon name="refresh-outline"></ion-icon>
                    Update
                </button>
            </div>
        </div>
    </div>
</form>
@endsection
@push('mysript')
<script>
        $('input[type="submit"]').prop("disabled", true);
        var a = 0;
        //binds to onchange event of your input field
        $('#fileuploadInput').bind('change', function () {
            if ($('input:submit').attr('disabled', false)) {
                $('input:submit').attr('disabled', true);
            }
            var ext = $('#fileuploadInput').val().split('.').pop().toLowerCase();
            if ($.inArray(ext, ['gif', 'png', 'jpg', 'jpeg']) == -1) {
                $('#error1').slideDown("slow");
                $('#error2').slideUp("slow");
                a = 0;
            } else {
                var picsize = (this.files[0].size);
                if (picsize > 1000000) {
                    $('#error2').slideDown("slow");
                    a = 0;
                } else {
                    a = 1;
                    $('#error2').slideUp("slow");
                }
                $('#error1').slideUp("slow");
                if (a == 1) {
                    $('input:submit').attr('disabled', false);
                }
            }
        });


</script>
@endpush
