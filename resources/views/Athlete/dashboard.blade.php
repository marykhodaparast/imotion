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
                    <form method="POST" action="{{ route('athletecreate') }}">
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
                        @foreach ($user_slots as $date => $slots)
                        <tr>
                            <th scope="row">
                                @foreach ($arrOfDays as $index => $day)
                                @if ((jdate()->format('w') + $i) % 7 == $index)
                                {{ $day }}
                                @endif
                                @endforeach
                            </th>
                            @for ($j = 1; $j <= 16; $j++) @if ((jdate()->format('w') + $i) % 7) <td class="{{ isset($slots['slot-' . $j]) ? $athlete::showCssClass($slots['slot-' . $j]['seat_count'], $slots['slot-' . $j]['is_mine'], $slots['is_mine']) : 'cursor_pointer hoverable' }}" data-date="{{ jdate()->addDays($i - 1)->format('Y-m-d') }}" data-nameOfDay="{{ jdate()->addDays($i - 1)->format('l') }}">
                                    <div class="row width-50 mx-auto">
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
    // let arrayOfTimes = [];
    // $(".arrow-left").click(function(){
    //      $(this).data('clicked', true);
    // });
    // $(".arrow-right").click(function(){
    //      $(this).data('clicked', true);
    // });
    // $('.arrow-left').on('click', function(){
    //     $('td').each(function(){
    //         $(this).find("div").find("i").removeClass('fas fa-user');
    //         $(this).find("div").find("i").addClass('far fa-user');
    //        $(this).removeClass('text-lightgray');
    //        $(this).addClass('cursor_pointer hoverable');
    //     });
    //     $('.arrow-right').css('display', 'block');
    //     $.ajax({
    //      url: '{{ route('ajaxtableleft') }}'
    //     ,type: 'POST'
    //     ,data: {
    //         "_token": "{{ csrf_token() }}"
    //     }
    //     ,success: function(result) {
    //         arrayOfTimes = result;
    //         var i = 0;
    //         $.each(arrayOfTimes, function(key, value) {
    //             $("#id_"+ i).text(value);
    //             $('#id_'+ i).data('time', key);
    //             $('#id_'+ i).attr('data-time', key);
    //             i++;
    //         });
    //         var todayTime = '{{ $todayTime }}';
    //         var todayDate = '{{ $todayDate }}';
    //         $('td').each(function() {
    //         if ($(this).hasClass('text-lightgray')) {
    //             $(this).find("div").find("i").removeClass('far fa-user');
    //             $(this).find("div").find("i").addClass('fas fa-user');
    //         }
    //         var column = $(this).closest("td").index();
    //         if ($(this).data('date') == todayDate) {
    //             column = $('tr').children('.c_' + column).data('time');
    //             arrOfTimes = column.split(' - ');
    //             console.log(todayTime, arrOfTimes);
    //             if (todayTime > arrOfTimes[1] || (todayTime > arrOfTimes[0] && todayTime < arrOfTimes[1])) {
    //                 $(this).find("div").find("i").removeClass('far fa-user');
    //                 $(this).find("div").find("i").addClass('fas fa-user');
    //                 $(this).addClass('text-lightgray');
    //                 $(this).removeClass('cursor_pointer hoverable');
    //             }
    //         }
    //     });
    //     }
    //     ,error: function() {
    //         console.log('error');
    //     }
    //     });
    // });
    // $('.arrow-right').on('click', function(){
    //     $('.arrow-right').css('display', 'none');
    //     $.ajax({
    //      url: '{{ route('ajaxtableright') }}'
    //     ,type: 'POST'
    //     ,data: {
    //         "_token": "{{ csrf_token() }}"
    //     }
    //     ,success: function(result) {
    //         arrayOfTimes = result;
    //         var i = 0;
    //         $.each(arrayOfTimes, function(key, value) {
    //             $("#id_"+ i).text(value);
    //             $('#id_'+ i).attr('data-time', key);
    //             i++;
    //         });
           
    //     }
    //     ,error: function() {
    //         console.log('error');
    //     }
    //     });
    // })
    // var arrOfTimes = [];
    // var todayTime = null;
    // var todayDate = null;

    // function toPersianNum(num, dontTrim) {

    //     var i = 0,

    //         dontTrim = dontTrim || false,

    //         num = dontTrim ? num.toString() : num.toString().trim()
    //         , len = num.length,

    //         res = ''
    //         , pos,

    //         persianNumbers = typeof persianNumber == 'undefined' ? ['۰', '۱', '۲', '۳', '۴', '۵', '۶', '۷', '۸', '۹'] :
    //         persianNumbers;

    //     for (; i < len; i++)
    //         if ((pos = persianNumbers[num.charAt(i)]))
    //             res += pos;
    //         else
    //             res += num.charAt(i);

    //     return res;
    // }
    // $(document).ready(function() {
    //     $('select.select2').select2();
    //     todayTime = '{{ $todayTime }}';
    //     todayDate = '{{ $todayDate }}';
    //     if(!$('.arrow-left').data('clicked') && !$('.arrow-right').data('clicked')) {
    //        // alert('yes');
    //     //       $('td').each(function() {
    //     //     if ($(this).hasClass('text-lightgray')) {
    //     //         $(this).find("div").find("i").removeClass('far fa-user');
    //     //         $(this).find("div").find("i").addClass('fas fa-user');
    //     //     }
    //     //     var column = $(this).closest("td").index();
    //     //     if ($(this).data('date') == todayDate) {
    //     //         column = $('tr').children('.c_' + column).data('time');
    //     //         arrOfTimes = column.split(' - ');
    //     //         if (todayTime > arrOfTimes[1] || (todayTime > arrOfTimes[0] && todayTime < arrOfTimes[1])) {
    //     //             $(this).find("div").find("i").removeClass('far fa-user');
    //     //             $(this).find("div").find("i").addClass('fas fa-user');
    //     //             $(this).addClass('text-lightgray');
    //     //             $(this).removeClass('cursor_pointer hoverable');
    //     //         }
    //     //     }
    //     // });       
    //     }
    //     $('td').each(function() {
    //         if ($(this).hasClass('text-lightgray')) {
    //             $(this).find("div").find("i").removeClass('far fa-user');
    //             $(this).find("div").find("i").addClass('fas fa-user');
    //         }
    //         var column = $(this).closest("td").index();
    //         if ($(this).data('date') == todayDate) {
    //             column = $('tr').children('.c_' + column).data('time');
    //             arrOfTimes = column.split(' - ');
    //             if (todayTime > arrOfTimes[1] || (todayTime > arrOfTimes[0] && todayTime < arrOfTimes[1])) {
    //                 $(this).find("div").find("i").removeClass('far fa-user');
    //                 $(this).find("div").find("i").addClass('fas fa-user');
    //                 $(this).addClass('text-lightgray');
    //                 $(this).removeClass('cursor_pointer hoverable');
    //             }
    //         }
    //     });
    //     $('td').on('click', function() {
    //         if (!$(this).hasClass('text-lightgray')) {
    //             $('#saveBtn').removeClass('display_none');
    //         }
    //         if ($(this).siblings().hasClass('text-lightgray') && $(this).data('date') != todayDate) {
    //             $('#saveBtn').text('لغو');
    //             $('#saveBtn').removeClass('btn-primary');
    //             $('#saveBtn').addClass('btn-danger');
    //         } else {
    //             $('#saveBtn').text('ذخیره');
    //             $('#saveBtn').addClass('btn-primary');
    //             $('#saveBtn').removeClass('btn-danger');
    //         }
    //         var row = $(this).closest("tr").index() + 1;
    //         //console.log(row);
    //         var column = $(this).closest("td").index();
    //         var date = $(this).data('date');
    //         var nameofday = $(this).data('nameofday');
    //         column = $('tr').children('.c_' + column).data('time');
    //         var res = column.split(" - ");
    //         if (nameofday != 'جمعه' && !$(this).hasClass('text-lightgray') && !$(this).hasClass('bg-danger')) {
    //             $('#day').css('display', 'flex');
    //             $('#time').css('display', 'block');
    //             $('#day').text(toPersianNum(date) + ' ' + nameofday);
    //             $('#time').text(column);
    //             $('#hidden_day').val(date);
    //             $('#hidden_time1').val(res[0]);
    //             $('#hidden_time2').val(res[1]);
    //         }
    //     });

    // });

</script>
<script src="/dist/js/pages/athleteDashboard.js"></script>
@endsection
