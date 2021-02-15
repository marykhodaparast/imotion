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
                    <form method="POST" action="{{ route('athletedashboard') }}">
                        @csrf
                        <input type="hidden" id="hidden_day" name="date">
                        <input type="hidden" id="hidden_time" name="time">
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
                        @for ($i = 1; $i <= 30; $i++)
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
                                  {{-- @if($slots["slot-".$j]["seat_count"] == 1) --}}
                                <td class="cursor_pointer hoverable" data-date="{{ jdate()->addDays($i - 1)->format('Y-m-d') }}" data-nameOfDay="{{jdate()->addDays($i - 1)->format('l')}}">
                                    <div class="row justify-content-center">
                                        <i class="far fa-user"></i>
                                        <i class="far fa-user"></i>
                                        <i class="far fa-user"></i>
                                    </div>
                                </td>
                                  {{-- @else --}}
                                  {{-- <td>hello</td> --}}
                                  {{-- @endif --}}

                              @endif
                            @endfor


                                {{-- @foreach($slots as $index => $s)

                                    @endforeach --}}
                                {{-- @for ($j = 1; $j <= 20; $j++)
                                        @if((jdate()->format('w') + $i) % 7) --}}

                                {{-- @if(!$user_slot[2])
                                        <td class="cursor_pointer hoverable"
                                            data-date="{{ jdate()->addDays($i - 1)->format('Y-m-d') }}" data-nameOfDay
                                = "{{jdate()->addDays($i - 1)->format('l')}}">
                                <div class="row justify-content-center">
                                    @for($k = 0;$k < 3; $k++) <i class="far fa-user"></i>
                                        @endfor
                                </div>
                                </td>
                                @elseif($user_slot[2] == 1 && $user_slot[0] == $j)
                                <td class="cursor_pointer hoverable"
                                    data-date="{{ jdate()->addDays($i - 1)->format('Y-m-d') }}"
                                    data-nameOfDay="{{jdate()->addDays($i - 1)->format('l')}}">
                                    <div class="row justify-content-center">
                                        <i class="fas fa-user accepted"></i>
                                        <i class="far fa-user"></i>
                                        <i class="far fa-user"></i>
                                    </div>
                                </td>
                                @elseif(($user_slot[2] == 1 || $user_slot[2] == 2) && $user_slot[0] != $j)
                                <td class="{{ $user_slot[1] == 0 ? 'cursor_pointer hoverable':'table_inactive'}}"
                                    data-date="{{ jdate()->addDays($i - 1)->format('Y-m-d') }}"
                                    data-nameOfDay="{{jdate()->addDays($i - 1)->format('l')}}">
                                    <div class="row justify-content-center">
                                        @for($k = 0;$k < 3; $k++) <i class="far fa-user"></i>
                                            @endfor
                                    </div>
                                </td>
                                @elseif($user_slot[2] == 2 && $user_slot[0] == $j)
                                <td class="cursor_pointer hoverable"
                                    data-date="{{ jdate()->addDays($i - 1)->format('Y-m-d') }}"
                                    data-nameOfDay="{{jdate()->addDays($i - 1)->format('l')}}">
                                    <div class="row justify-content-center">
                                        <i class="fas fa-user accepted"></i>
                                        <i class="fas fa-user accepted"></i>
                                        <i class="far fa-user"></i>
                                    </div>
                                </td>
                                @elseif($user_slot[2] == 3 && $user_slot[0] == $j)
                                <td class="{{ $user_slot[1] == 'selfBanned' ? 'cursor_pointer hoverable' : '' }}"
                                    data-date="{{ jdate()->addDays($i - 1)->format('Y-m-d') }}"
                                    data-nameOfDay="{{jdate()->addDays($i - 1)->format('l')}}">
                                    <div class="row justify-content-center">
                                        @for($k = 0;$k < 3; $k++) <i class="fas fa-user danger"></i>
                                            @endfor
                                    </div>
                                </td>
                                @elseif($user_slot[2] == 3 && $user_slot[0] != $j)
                                <td class="{{ $user_slot[1] == 'selfBanned' ? 'table_inactive' : 'cursor_pointer hoverable' }}"
                                    data-date="{{ jdate()->addDays($i - 1)->format('Y-m-d') }}"
                                    data-nameOfDay="{{jdate()->addDays($i - 1)->format('l')}}">
                                    <div class="row justify-content-center">
                                        @for($k = 0;$k < 3; $k++) <i class="far fa-user"></i>
                                            @endfor
                                    </div>

                                </td>
                                @endif --}}
                                {{-- @endif --}}
                                {{-- @endfor --}}
                        </tr>
                        {{-- @php $i++; @endphp --}}
                        @endfor
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
            $('td').on('click', function() {
                $('#saveBtn').removeClass('display_none');
                if($(this).siblings().hasClass('table_inactive')){
                    console.log('hello');
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
                if(nameofday != 'جمعه' && !$(this).hasClass('table_inactive') && !$(this).hasClass('bg-danger')){
                    $('#day').css('display','flex');
                    $('#time').css('display','block');
                    $('#day').text(toPersianNum(date) + ' ' +  nameofday);
                    $('#time').text(column);
                    $('#hidden_day').val(date);
                    $('#hidden_time').val(column);
                }
            });

        });

</script>
@endsection
