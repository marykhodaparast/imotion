@extends('layouts.index')
@section('css')
<link href="/plugins/select2/css/select2.min.css" rel="stylesheet" />
<link href="/dist/css/custom.css" rel="stylesheet">
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
                <table class="table table-bordered bg-white">
                    <thead>
                        <tr>
                            <th scope="col">#</th>
                            @php $k = 0; @endphp
                            @foreach($arrOfTimes as $key => $item)
                            <th scope="col" class="c_{{ $k+1 }} text-center" data-time="{{ $key }}">{{ $item }}</th>
                            @php $k++ @endphp
                            @endforeach
                        </tr>
                    </thead>
                    <tbody>
                        @php $i = 1; @endphp
                        @foreach ($user_slots as $date => $slots)
                        <tr>
                            <th scope="row">
                                @if((jdate()->format('w') + $i ) % 7 == 0)
                                ج
                                @elseif((jdate()->format('w') + $i) % 7 == 1)
                                ش
                                @elseif((jdate()->format('w') + $i) % 7 == 2)
                                ی
                                @elseif((jdate()->format('w') + $i) % 7 == 3)
                                د
                                @elseif((jdate()->format('w') + $i) % 7 == 4)
                                س
                                @elseif((jdate()->format('w') + $i) % 7 == 5)
                                چ
                                @elseif((jdate()->format('w') + $i) % 7 == 6)
                                پ
                                @endif

                            </th>
                            @for($j = 1; $j <= 20; $j++)
                              @if((jdate()->format('w') + $i) % 7)
                                  @if(!empty($slots))
                                  @if($slots["slot-".$j]["seat_count"] == 1)
                                <td class="cursor_pointer hoverable" data-date="{{ jdate()->addDays($i - 1)->format('Y-m-d') }}"
                                    data-nameOfDay="{{jdate()->addDays($i - 1)->format('l')}}"
                                >
                                    <div class="row width-50 mx-auto">
                                        <i class="fas fa-user accepted"></i>
                                        <i class="far fa-user"></i>
                                        <i class="far fa-user"></i>
                                    </div>
                                </td>
                                @elseif($slots["slot-".$j]["seat_count"] == null && $slots["slot-".$j]["is_mine"] == null)
                                <td class="{{ $slots["is_mine"] == 1 ? 'table_inactive' : 'cursor_pointer hoverable' }}"
                                data-date="{{ jdate()->addDays($i - 1)->format('Y-m-d') }}"
                                data-nameOfDay="{{jdate()->addDays($i - 1)->format('l')}}"
                               >
                                    <div class="row  width-50 mx-auto">
                                        <i class="far fa-user"></i>
                                        <i class="far fa-user"></i>
                                        <i class="far fa-user"></i>
                                    </div>
                                 </td>
                                @elseif($slots["slot-".$j]["seat_count"] == 2)
                                <td class="cursor_pointer hoverable"
                                data-date="{{ jdate()->addDays($i - 1)->format('Y-m-d') }}"
                                data-nameOfDay="{{jdate()->addDays($i - 1)->format('l')}}"
                                >
                                <div class="row width-50 mx-auto">
                                    <i class="fas fa-user accepted"></i>
                                    <i class="fas fa-user accepted"></i>
                                    <i class="far fa-user"></i>
                                </div>
                                </td>
                                  @elseif($slots["slot-".$j]["seat_count"] == 3)
                                  <td class="{{ $slots["slot-".$j]["is_mine"] == 1 ? 'cursor_pointer hoverable' : ''}}"
                                  data-date="{{ jdate()->addDays($i - 1)->format('Y-m-d') }}"
                                  data-nameOfDay="{{jdate()->addDays($i - 1)->format('l')}}"
                                 >
                                  <div class="row width-50 mx-auto">
                                      @for($k = 0;$k < 3; $k++) <i class="fas fa-user danger"></i>
                                          @endfor
                                  </div>
                                </td>
                              @endif
                                  @else
                                  <td class="cursor_pointer hoverable"
                                  data-date="{{ jdate()->addDays($i - 1)->format('Y-m-d') }}"
                                  data-nameOfDay="{{jdate()->addDays($i - 1)->format('l')}}"
                                  >
                                    {{-- <div class="row justify-content-center width-50"> --}}
                                    <div class="row width-50 mx-auto">
                                        <i class="far fa-user"></i>
                                        <i class="far fa-user"></i>
                                        <i class="far fa-user"></i>
                                    </div>

                                    {{-- </div> --}}
                                    {{-- <div class="row">he</div> --}}
                                </td>
                                  @endif

                              @endif
                            @endfor
                        </tr>
                        @php $i++; @endphp
                        @endforeach
                    </tbody>
                </table>
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
<script>
    var arrOfTimes = [];
    var todayTime = null;
    var todayDate = null;
    function toPersianNum( num, dontTrim ) {

          var i = 0,

         dontTrim = dontTrim || false,

         num = dontTrim ? num.toString() : num.toString().trim(),
         len = num.length,

         res = '',
         pos,

        persianNumbers = typeof persianNumber == 'undefined' ?
        ['۰', '۱', '۲', '۳', '۴', '۵', '۶', '۷', '۸', '۹'] :
        persianNumbers;

        for (; i < len; i++)
          if (( pos = persianNumbers[num.charAt(i)] ))
            res += pos;
          else
        res += num.charAt(i);

        return res;
    }
        $(document).ready(function() {
            $('select.select2').select2();
            todayTime = '{{ $todayTime }}';
            todayDate = '{{ $todayDate }}';
            $('td').each(function(){
                var column = $(this).closest("td").index();
                if($(this).data('date') == todayDate){
                    column = $('tr').children('.c_' + column).data('time');
                    arrOfTimes = column.split(' - ');
                    if(todayTime > arrOfTimes[1] || (todayTime > arrOfTimes[0] && todayTime < arrOfTimes[1])){
                       $(this).addClass('table_inactive');
                       $(this).removeClass('cursor_pointer hoverable');
                    }
                }
            });
            $('td').on('click', function() {
                if(!$(this).hasClass('table_inactive')){
                    $('#saveBtn').removeClass('display_none');
                }
                if($(this).siblings().hasClass('table_inactive') && $(this).data('date') != todayDate){
                    $('#saveBtn').text('لغو');
                    $('#saveBtn').removeClass('btn-primary');
                    $('#saveBtn').addClass('btn-danger');
                }else{
                    $('#saveBtn').text('ذخیره');
                    $('#saveBtn').addClass('btn-primary');
                    $('#saveBtn').removeClass('btn-danger');
                }
                var row = $(this).closest("tr").index() + 1;
                var column = $(this).closest("td").index();
                var date = $(this).data('date');
                var nameofday = $(this).data('nameofday');
                column = $('tr').children('.c_' + column).data('time');
                var res = column.split(" - ");
                if(nameofday != 'جمعه' && !$(this).hasClass('table_inactive') && !$(this).hasClass('bg-danger')){
                    $('#day').css('display','flex');
                    $('#time').css('display','block');
                    //$('#time1').css('display', 'block');
                    //$('#time2').css('display', 'block');
                    $('#day').text(toPersianNum(date) + ' ' +  nameofday);
                    $('#time').text(column);
                    //$('#time1').text('11:);
                    //$('#time2').text('12:00');
                    $('#hidden_day').val(date);
                    $('#hidden_time1').val(res[0]);
                    $('#hidden_time2').val(res[1]);
                }
            });

        });

</script>
@endsection
