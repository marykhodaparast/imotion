@inject('athlete', 'App\Http\Controllers\AthleteController')
@extends('layouts.index')
@section('css')
<link href="/plugins/select2/css/select2.min.css" rel="stylesheet" />
<link href="/dist/css/custom.css" rel="stylesheet">
<link href="/dist/css/responsive.css" rel="stylesheet">
@endsection

@section('content')
<!-- Content Header (Page header) -->
<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
            </div>
            <div class="col-sm-6">

            </div>
        </div>
    </div><!-- /.container-fluid -->
</section>

<!-- Main content -->
<section class="content">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                </div>
                <!-- /.card-header -->
                <div class="card-body">
                    <form method="POST" action="{{ route('slotcreate') }}">
                        @csrf
                        <input type="hidden" id="hidden_day" name="date">
                        <input type="hidden" id="hidden_time1" name="time1">
                        <input type="hidden" id="hidden_time2" name="time2">
                        <div class="row">
                            <div class="col form-control display_none" id="day"> </div>
                            <div class="col form-control display_none" id="time"> </div>
                        </div>
                        <div class="row">
                            <div class="col">
                                <button class="btn mt-2 display_none" id="saveBtn"></button>
                            </div>
                        </div>
                    </form>
                </div>
                <!-- /.card-body -->
            </div>
            <!-- /.card -->
        </div>
        <!-- /.col -->
    </div>
    <!-- /.row -->
    <div class="row">
        <div class="col">
            <div class="table-responsive my_rounded">
                <table class="table bg-white" id="athlete_table">
                    {{-- <div class="div-arrow-up-img">
                            <img src="/dist/img/arrow-right.png" alt="arrow" class="arrow-up">
                        </div> --}}
                    <div id="div-arrow-right-img">
                        <img src="/dist/img/arrow-right.png" alt="arrow" class="arrow-right">
                    </div>
                    <div id="div-arrow-left-img">
                        <img src="/dist/img/arrow-right.png" alt="arrow" class="arrow-left">
                    </div>
                    <thead>
                        <tr>
                            <th scope="col" class="firstTh">#</th>
                            @php $k = 0; @endphp
                                @foreach ($arrOfTimes as $key => $item)
                                    <th scope="col" id="id_{{$k}}" class="c_{{ $k + 1 }} text-center" data-time="{{ $key }}">{{ $item }}</th>
                            @php $k++ @endphp
                                @endforeach
                        </tr>
                    </thead>
                    <tbody>
                        @php $i = 1; @endphp
                        @foreach ($fullUserSlots as $date => $slots)
                        <tr>
                            <th scope="row">
                                @foreach ($arrOfDays as $index => $day)
                                @if ((jdate()->format('w') + $i) % 7 == $index)
                                {{ $day }}
                                @endif
                                @endforeach
                            </th>
                            @for ($j = 1; $j <= $slotCounter; $j++) @if ((jdate()->format('w') + $i) % 7) <td class="{{ isset($slots['slot-' . $j]) ? $athlete::showCssClass($slots['slot-' . $j]['seat_count'], $slots['slot-' . $j]['is_mine'], $slots['is_mine']) : 'cursor_pointer hoverable' }}" data-date="{{ jdate()->addDays($i - 1)->format('Y-m-d') }}" data-nameOfDay="{{ jdate()->addDays($i - 1)->format('l') }}">
                                    <div class="row width-50 mx-auto class_{{$j}}">
                                        {!! !empty($slots) && isset($showUsersInView[$slots['slot-' . $j]['seat_count']]) ? $showUsersInView[$slots['slot-' . $j]['seat_count']] : $noUser !!}
                                    </div>

                                </td> @endif
                                @endfor
                        </tr>
                        @php $i++; @endphp
                        @endforeach
                        {{-- <tr class="trForBottomArrow"></tr> --}}
                    </tbody>

                </table>
                {{-- <div class="div-arrow-bottom-img">
                        <img src="/dist/img/arrow-right.png" alt="arrow" class="arrow-bottom">
                    </div> --}}
            </div>
            <!-- /.card -->
        </div>
        <!-- /.col -->
    </div>
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    راهنما
                    <div class="row">
                        <div class="col-xs-12 col-lg-3">
                             صندلی خالی
                             <i class="far fa-user"></i><i class="far fa-user"></i><i class="far fa-user"></i>
                        </div>
                        <div class="col-xs-12 col-lg-3">
                            صندلی پر
                            <i class="fas fa-user danger"></i><i class="fas fa-user danger"></i><i class="fas fa-user danger"></i>
                        </div>
                        <div class="col-xs-12 col-lg-3">
                             صندلی نیمه پر
                             <i class="fas fa-user accepted"></i><i class="fas fa-user accepted"></i><i class="far fa-user"></i>
                        </div>
                        <div class="col-xs-12 col-lg-3">
                            صندلی غیرفعال
                            <i class="fas fa-user text-lightgray"></i><i class="fas fa-user text-lightgray"></i><i class="fas fa-user text-lightgray"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- /.row -->
</section>
<!-- /.content -->
@endsection

@section('js')
<!-- Select2 -->
<script src="/plugins/select2/js/select2.full.min.js"></script>
<script src="/js/persian-date.js" type="text/javascript"></script>
<script>
    var todayTime = '{{ $todayTime }}';
    var todayDate = '{{ $todayDate }}';
    var csrf_token = '{{ csrf_token() }}';
    var route_ajaxtableleft = "{{ route('ajaxtableleft')}}";
    var route_ajaxtableright = "{{ route('ajaxtableright')}}";
    var route_ajaxtableleftmobile = "{{ route('ajaxtableleftmobile')}}";
    var user_slots = @json($user_slots);
    var full_user_slots = @json($fullUserSlots);
    var slotCounter = "{{ $slotCounter }}";
</script>
<script src="/dist/js/pages/athleteDashboard.js"></script>
@endsection
