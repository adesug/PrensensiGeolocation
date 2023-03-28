
    @if($histori->isEmpty() )
        <div class="aler alert-outline-danger text-center">Data Tidak Ada</div>
    @endif
    @foreach ($histori as $item)

   <ul class="listview image-listview">
    <li>
        <div class="item">
            @php
                $path = Storage::url('uploads/absensi/'.$item->foto_in);
            @endphp
            <img src="{{url($path)}}" alt="image" class="image">
                <div class="in">
                    <div>
                        <b>{{date('d-m-Y', strtotime($item->tgl_presensi))}}</b><br>
                    </div>
                    <span class="badge" {{$item->jam_in < "07:00" ? "bg-success" : "bg-danger"}}>
                        {{$item->jam_in}}
                    </span>
                    <span class="badge bg-primary">{{$item->jam_out}}</span>
                </div>
        </div>

    </li>
   </ul>
@endforeach


