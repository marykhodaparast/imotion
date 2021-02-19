@extends('layouts.index')
@section('css')
    <meta name="csrf-token" content="{{ csrf_token() }}">
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
                                <div  class="col-4" id="first_select">
                                    <select name="first_athlete" id="first_athlete" class="form-control select2">
                                        <option value="0">-</option>
                                        @foreach($athletes as $athlete)
                                          <option value="{{ $athlete->id}}">{{ $athlete->first_name.' '.$athlete->last_name.'-'.$athlete->phone }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-4" id="second_select" >
                                    <select name="second_athlete" id="second_athlete" class="form-control select2">
                                        <option value="0">-</option>
                                        @foreach($athletes as $athlete)
                                          <option value="{{ $athlete->id }}">{{ $athlete->first_name.' '.$athlete->last_name.'-'.$athlete->phone }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-4" id="third_select">
                                    <select name="third_athlete" id="third_athlete" class="form-control select2">
                                        <option value="0">-</option>
                                        @foreach($athletes as $athlete)
                                          <option value="{{ $athlete->id }}">{{ $athlete->first_name.' '.$athlete->last_name.'-'.$athlete->phone }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col">
                                    <button class="btn btn-primary mt-2" id="saveBtn" disabled>
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
                            @foreach ($user_slots as $date=>$slots)
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
                                      <td class="cursor_pointer hoverable" data-date="{{ jdate()->addDays($i - 1)->format('Y-m-d') }}" data-nameOfDay="{{jdate()->addDays($i - 1)->format('l')}}">
                                          <div class="row justify-content-center">
                                              <i class="fas fa-user accepted"></i>
                                              <i class="far fa-user"></i>
                                              <i class="far fa-user"></i>
                                          </div>
                                      </td>
                                      @elseif($slots["slot-".$j]["seat_count"] == null)
                                      <td class="cursor_pointer hoverable" data-date="{{ jdate()->addDays($i - 1)->format('Y-m-d') }}" data-nameOfDay="{{jdate()->addDays($i - 1)->format('l')}}">
                                          <div class="row justify-content-center">
                                              <i class="far fa-user"></i>
                                              <i class="far fa-user"></i>
                                              <i class="far fa-user"></i>
                                          </div>
                                       </td>
                                      @elseif($slots["slot-".$j]["seat_count"] == 2)
                                      <td class="cursor_pointer hoverable"
                                      data-date="{{ jdate()->addDays($i - 1)->format('Y-m-d') }}"
                                      data-nameOfDay="{{jdate()->addDays($i - 1)->format('l')}}">
                                      <div class="row justify-content-center">
                                          <i class="fas fa-user accepted"></i>
                                          <i class="fas fa-user accepted"></i>
                                          <i class="far fa-user"></i>
                                      </div>
                                      </td>
                                        @elseif($slots["slot-".$j]["seat_count"] == 3)
                                        <td class="cursor_pointer hoverable"
                                        data-date="{{ jdate()->addDays($i - 1)->format('Y-m-d') }}"
                                        data-nameOfDay="{{jdate()->addDays($i - 1)->format('l')}}">
                                        <div class="row justify-content-center">
                                            @for($k = 0;$k < 3; $k++) <i class="fas fa-user danger"></i>
                                                @endfor
                                        </div>
                                      </td>
                                    @endif
                                        @else
                                        <td class="cursor_pointer hoverable" data-date="{{ jdate()->addDays($i - 1)->format('Y-m-d') }}" data-nameOfDay="{{jdate()->addDays($i - 1)->format('l')}}">
                                          <div class="row justify-content-center">
                                              <i class="far fa-user"></i>
                                              <i class="far fa-user"></i>
                                              <i class="far fa-user"></i>
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
        $(document).ready(function() {
            $('select').next(".select2-container").hide();
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
                       $('#saveBtn').prop('disabled',false);
                       var res = result.data;
                       if(nameofday != 'جمعه'){
                        $('#hidden_day').val(date);
                        $('#hidden_time').val(column);
                        $('select').next(".select2-container").show();
                       }
                       if(!res.length  || res == undefined){
                        $('#saveBtn').prop('disabled',false);
                        $('#first_athlete').val(0);
                        $('#first_athlete').trigger('change');
                        $('#second_athlete').val(0);
                        $('#second_athlete').trigger('change');
                        $('#third_athlete').val(0);
                        $('#third_athlete').trigger('change');
                       }else{
                        $('#saveBtn').prop('disabled',false);
                        $('#first_athlete').val(res[0][0]);
                        $('#first_athlete').trigger('change');
                        $('#second_athlete').val(res[1][0]);
                        $('#second_athlete').trigger('change');
                        $('#third_athlete').val(res[2][0]);
                        $('#third_athlete').trigger('change');
                       }
                    },
                    error:function(){
                       //console.log(error);
                    }
                })
            });

        });

    </script>
    <script type="text/javascript">
    function removeItem(first,second,third){
        $(first).on('change',function(){
         var theValue = $(this).val();
         $(second).each(function(){
            if(this.value == theValue){
                this.value = 0;
                $(this).trigger('change.select2');
            }
         });
         $(third).each(function(){
            if(this.value == theValue){
                this.value = 0;
                $(this).trigger('change.select2');
            }
         });
        });
    }

    removeItem('#first_athlete', '#second_athlete', '#third_athlete');
    removeItem('#second_athlete', '#first_athlete', '#third_athlete');
    removeItem('#third_athlete', '#first_athlete', '#second_athlete');
    </script>
    <script type="text/javascript">
        function select2_load_remote_data_with_ajax(item) {
            // CSRF Token
            var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
            $(item).select2({
                ajax: {
                    url: "{{ route('admin_get_selects') }}"
                    , type: 'post'
                    , dataType: 'json'
                    , delay: 250
                    , data: function(params) {
                        return {
                            _token: CSRF_TOKEN
                            , search: params.term
                        };
                    }
                    , processResults: function(response) {
                        return {
                            results: response
                        };
                    }
                    , cache: true
                }
                //,
                //minimumInputLength: 3
            });
        }
        select2_load_remote_data_with_ajax('#first_athlete');
        select2_load_remote_data_with_ajax('#second_athlete');
        select2_load_remote_data_with_ajax('#third_athlete');
    </script>
@endsection
