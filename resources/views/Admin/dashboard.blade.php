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
                        <form method="POST" action="{{ route('admin_save_slot') }}">
                            @csrf
                            <input type="hidden" id="hidden_day" name="date">
                            <input type="hidden" id="hidden_time" name="time">
                            <div class="row">
                                <div class="col">
                                    <select name="first_athlete" id="first_athlete" class="form-select display_none">
                                        <option value="null">-</option>
                                        @foreach($athletes as $athlete)
                                          <option value="{{ $athlete->id }}">{{ $athlete->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col">
                                    <select name="second_athlete" id="second_athlete" class="form-select display_none">
                                        <option value="null">-</option>
                                        @foreach($athletes as $athlete)
                                          <option value="{{ $athlete->id }}">{{ $athlete->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col">
                                    <select name="third_athlete" id="third_athlete" class="form-select display_none">
                                        <option value="null">-</option>
                                        @foreach($athletes as $athlete)
                                          <option value="{{ $athlete->id }}">{{ $athlete->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col">
                                    <button class="btn btn-primary mt-2" id="saveBtn">
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
            <div class="col-12">
                {{-- <div class="card"> --}}
                {{-- <div class="table-responsive my_rounded">
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
                                       @if((jdate()->format('w') + $i) % 7 == 0)
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


                                        @if(!is_array($user_slot))
                                        @if(strpos($user_slot,'banned'))
                                        <td class="{{ (jdate()->format('w') + $i) % 7 != 0 && substr($user_slot,0,1) == $j? 'bg-danger bordered cursor_pointer' : 'bg-maryam  cursor_pointer bordered' }}"
                                            data-date="{{ jdate()->addDays($i - 1)->format('Y-m-d') }}" data-nameOfDay = "{{jdate()->addDays($i - 1)->format('l')}}">
                                        </td>
                                        @elseif($user_slot>=0 && $user_slot!="")
                                        <td class="{{ (jdate()->format('w') + $i) % 7 != 0 && $user_slot == $j ? 'bg-red bordered cursor_pointer' : 'bg-maryam bordered cursor_pointer' }}"
                                            data-date="{{ jdate()->addDays($i - 1)->format('Y-m-d') }}" data-nameOfDay = "{{jdate()->addDays($i - 1)->format('l')}}">
                                        </td>
                                        @else
                                        <td class="{{ (jdate()->format('w') + $i) % 7 != 0 ? 'cursor_pointer bg-maryam bordered' : 'table_inactive bordered' }}"
                                            data-date="{{ jdate()->addDays($i - 1)->format('Y-m-d') }}" data-nameOfDay = "{{jdate()->addDays($i - 1)->format('l')}}"></td>
                                        @endif
                                        @else
                                        @if($j <= count($user_slot))

                                        <td class="{{ (jdate()->format('w') + $i) % 7 != 0 && $user_slot[$j-1] == $j ? 'bg-danger bordered cursor_pointer' : 'bg-maryam  cursor_pointer bordered' }}"
                                            data-date="{{ jdate()->addDays($i - 1)->format('Y-m-d') }}" data-nameOfDay = "{{jdate()->addDays($i - 1)->format('l')}}">
                                        </td>
                                        @else
                                        <td class="bg-maryam  cursor_pointer bordered"
                                            data-date="{{ jdate()->addDays($i - 1)->format('Y-m-d') }}" data-nameOfDay = "{{jdate()->addDays($i - 1)->format('l')}}">
                                        </td>
                                        @endif
                                        @endif


                                    @endfor

                                </tr>
                                @php $i++; @endphp
                            @endforeach
                        </tbody>
                    </table>
                </div> --}}
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
                                        @if((jdate()->format('w') + $i) % 7)
                                        @if(!$user_slot[2])
                                        <td class="cursor_pointer hoverable"
                                            data-date="{{ jdate()->addDays($i - 1)->format('Y-m-d') }}" data-nameOfDay = "{{jdate()->addDays($i - 1)->format('l')}}">
                                            <div class="row justify-content-center">
                                                @for($k = 0;$k < 3; $k++)
                                                <i class="far fa-user"></i>
                                               @endfor
                                            </div>
                                        </td>
                                        @elseif($user_slot[2] == 1 && $user_slot[0] == $j)
                                        <td class="cursor_pointer hoverable"
                                            data-date="{{ jdate()->addDays($i - 1)->format('Y-m-d') }}" data-nameOfDay = "{{jdate()->addDays($i - 1)->format('l')}}">
                                            <div class="row justify-content-center">
                                                <i class="fas fa-user accepted"></i>
                                                <i class="far fa-user"></i>
                                                <i class="far fa-user"></i>
                                            </div>
                                        </td>
                                        @elseif(($user_slot[2] == 1 || $user_slot[2] == 2)  && $user_slot[0] != $j)
                                        <td class="cursor_pointer hoverable"
                                            data-date="{{ jdate()->addDays($i - 1)->format('Y-m-d') }}" data-nameOfDay = "{{jdate()->addDays($i - 1)->format('l')}}">
                                            <div class="row justify-content-center">
                                                @for($k = 0;$k < 3; $k++)
                                                <i class="far fa-user"></i>
                                               @endfor
                                            </div>
                                        </td>
                                        @elseif($user_slot[2] == 2 && $user_slot[0] == $j)
                                        <td class="cursor_pointer hoverable"
                                        data-date="{{ jdate()->addDays($i - 1)->format('Y-m-d') }}" data-nameOfDay = "{{jdate()->addDays($i - 1)->format('l')}}">
                                        <div class="row justify-content-center">
                                                <i class="fas fa-user accepted"></i>
                                                <i class="fas fa-user accepted"></i>
                                                <i class="far fa-user"></i>
                                        </div>
                                    </td>
                                        @elseif($user_slot[2] == 3 && $user_slot[0] == $j)
                                        <td class="cursor_pointer hoverable"
                                        data-date="{{ jdate()->addDays($i - 1)->format('Y-m-d') }}" data-nameOfDay = "{{jdate()->addDays($i - 1)->format('l')}}">
                                        <div class="row justify-content-center">
                                             @for($k = 0;$k < 3; $k++)
                                                <i class="fas fa-user danger"></i>
                                             @endfor
                                        </div>
                                    </td>
                                        @elseif($user_slot[2] == 3 && $user_slot[0] != $j)
                                        <td class="cursor_pointer hoverable"
                                        data-date="{{ jdate()->addDays($i - 1)->format('Y-m-d') }}" data-nameOfDay = "{{jdate()->addDays($i - 1)->format('l')}}">
                                        <div class="row justify-content-center">
                                             @for($k = 0;$k < 3; $k++)
                                                <i class="far fa-user"></i>
                                             @endfor
                                        </div>

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
            {{-- </div> --}}
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
        // function makeSelectToBeDisabled(item,id){
        //     if(item!= null){
        //         $(id).prop('disabled','disabled');
        //     }
        // }
        // function makeDisabledToBeFalse(){
        //     $('#first_athlete').prop('disabled',false);
        //     $('#second_athlete').prop('disabled',false);
        //     $('#third_athlete').prop('disabled',false);
        // }
        $(document).ready(function() {
            $('select.select2').select2();
            $('td').on('click', function() {
                var row = $(this).closest("tr").index() + 1;
                var column = $(this).closest("td").index();
                var date = $(this).data('date');
                var nameofday = $(this).data('nameofday');
                column = $('tr').children('.c_' + column).data('time');
                $.ajax({
                    url:'{{ route('admin_ajax') }}',
                    type:'POST',
                    data:{
                        'theTime':column,
                        'theDate':date,
                        "_token": "{{ csrf_token() }}",
                    },
                    success:function(result){
                       var res = result.data;
                       if(nameofday != 'جمعه'){
                        $('#hidden_day').val(date);
                        $('#hidden_time').val(column);
                        $('#first_athlete').css('display','block');
                        $('#second_athlete').css('display','block');
                        $('#third_athlete').css('display','block');
                       if(res.length < 1 || res == undefined){
                        $('#saveBtn').prop('disabled',false);
                        //makeDisabledToBeFalse();
                        $('#first_athlete').val(0);
                        $('#second_athlete').val(0);
                        $('#third_athlete').val(0);
                       }else{
                        $('#saveBtn').prop('disabled',false);
                        //makeDisabledToBeFalse();
                        //if(res[0][0])makeSelectToBeDisabled(res[0][0],'#first_athlete');
                        //if(res[1][0])makeSelectToBeDisabled(res[1][0],'#second_athlete');
                        //if(res[2][0])makeSelectToBeDisabled(res[2][0],'#third_athlete');
                        $('#first_athlete').val(res[0][0]);
                        $('#second_athlete').val(res[1][0]);
                        $('#third_athlete').val(res[2][0]);
                        if($('#first_athlete').val()!= null && $('#second_athlete').val()!= null && $('#third_athlete').val() != null){
                            //$('#saveBtn').prop('disabled','disabled');
                        }
                       }
                       }

                    },
                    error:function(){
                       console.log(error);
                    }
                })
            });

        });

    </script>
@endsection
