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
                                    <button class="btn btn-primary mt-2">
                                        ذخیره
                                    </button>
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
                            @foreach ($user_slots as $date=>$user_slot)
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
                                    @for ($j = 1; $j <= 20; $j++)
                                           @if(!is_array($user_slot) && strpos($user_slot,'self') && !strpos($user_slot,'other'))
                                           <td class="{{ (jdate()->format('w') + $i) % 7 != 0 && $user_slot == $j ? 'bg-danger bordered ' : 'bg-maryam bordered table_inactive ' }}"
                                            data-date="{{ jdate()->addDays($i-1)->format('Y-m-d') }}" data-nameOfDay = "{{jdate()->addDays($i-1)->format('l')}}">
                                            </td>
                                             @elseif(!is_array($user_slot) && $user_slot>=0 && $user_slot!="" && !strpos($user_slot,'other'))
                                             <td class="{{ (jdate()->format('w') + $i) % 7 != 0 && $user_slot == $j ? 'table_inactive bg-red bordered' : 'table_inactive bordered' }}"
                                             data-date="{{ jdate()->addDays($i - 1)->format('Y-m-d') }}" data-nameOfDay = "{{jdate()->addDays($i - 1)->format('l')}}">
                                             </td>
                                             @elseif(!is_array($user_slot) && strpos($user_slot,'other'))
                                             <td class="{{ (jdate()->format('w') + $i) % 7 != 0 && $user_slot == $j ? 'bg-danger bordered' : 'bg-maryam cursor_pointer bordered' }}"
                                                data-date="{{ jdate()->addDays($i - 1)->format('Y-m-d') }}" data-nameOfDay = "{{jdate()->addDays($i - 1)->format('l')}}"></td>
                                            @elseif(!is_array($user_slot) && !strpos($user_slot,'other'))
                                            <td class="{{ (jdate()->format('w') + $i) % 7 != 0 ? 'cursor_pointer bg-maryam bordered' : 'table_inactive bordered' }}"
                                            data-date="{{ jdate()->addDays($i - 1)->format('Y-m-d') }}" data-nameOfDay = "{{jdate()->addDays($i - 1)->format('l')}}"></td>
                                            @elseif(is_array($user_slot))
                                            @if($user_slot[0] == $j && !strpos($user_slot[0],'other') && strpos($user_slot[0],'self'))
                                            <td class="bg-danger dbordered" data-date="{{ jdate()->addDays($i - 1)->format('Y-m-d') }}" data-nameOfDay = "{{jdate()->addDays($i - 1)->format('l')}}"></td>
                                            @elseif($user_slot[0] == $j && !strpos($user_slot[0],'other') && !strpos($user_slot[0],'self'))
                                            <td class="bg-red dbordered" data-date="{{ jdate()->addDays($i - 1)->format('Y-m-d') }}" data-nameOfDay = "{{jdate()->addDays($i - 1)->format('l')}}"></td>
                                            @elseif($user_slot[1] == $j && strpos($user_slot[1],'other'))
                                            <td class="bg-danger bordered" data-date="{{ jdate()->addDays($i - 1)->format('Y-m-d') }}" data-nameOfDay = "{{jdate()->addDays($i - 1)->format('l')}}"></td>
                                            @else
                                             <td class="table_inactive bordered" data-date="{{ jdate()->addDays($i - 1)->format('Y-m-d') }}" data-nameOfDay = "{{jdate()->addDays($i - 1)->format('l')}}"></td>
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
