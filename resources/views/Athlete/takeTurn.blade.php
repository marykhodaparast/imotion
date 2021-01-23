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
                        <form method="POST" action="{{ route('athletetaketurn') }}">
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
            <div class="col-12">
                <div class="card">
                    <table class="table table-responsive table-bordered">
                        <thead>
                            <tr>
                                <th scope="col">#</th>
                                @for($k = 0; $k<20; $k++)
                                   <th scope="col" class="{{ $k+1 }}">{{ $arrOfTimes[$k] }}</th>
                                @endfor
                            </tr>
                        </thead>
                        <tbody>
                            @php $i = 1; @endphp
                            @foreach ($user_slots as $date=>$user_slot)
                                <tr>
                                    <th scope="row">
                                       @if((jdate()->format('w') + $i) % 7 == 0)
                                       جمعه
                                       @elseif((jdate()->format('w') + $i) % 7 == 1)
                                       شنبه
                                       @elseif((jdate()->format('w') + $i) % 7 == 2)
                                       یکشنبه
                                       @elseif((jdate()->format('w') + $i) % 7 == 3)
                                       دوشنبه
                                       @elseif((jdate()->format('w') + $i) % 7 == 4)
                                       سه شنبه
                                       @elseif((jdate()->format('w') + $i) % 7 == 5)
                                       چهارشنبه
                                       @elseif((jdate()->format('w') + $i) % 7 == 6)
                                       پنج شنبه
                                       @endif

                                    </th>
                                    @for ($j = 1; $j <= 20; $j++)
                                        @if($user_slot>=0 && $user_slot!="")
                                        <td class="{{ (jdate()->format('w') + $i) % 7 != 0 && $user_slot == $j ? 'table_inactive bg-red bordered' : 'table_inactive bordered' }}"
                                            data-date="{{ jdate()->addDays($i - 1)->format('Y-m-d') }}" data-nameOfDay = "{{jdate()->addDays($i - 1)->format('l')}}">
                                        </td>
                                        @else
                                        <td class="{{ (jdate()->format('w') + $i) % 7 != 0 ? 'cursor_pointer bg-maryam bordered' : 'table_inactive bordered' }}"
                                            data-date="{{ jdate()->addDays($i - 1)->format('Y-m-d') }}" data-nameOfDay = "{{jdate()->addDays($i - 1)->format('l')}}"></td>
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
        $(document).ready(function() {
            $('select.select2').select2();
            $('td').on('click', function() {
                var row = $(this).closest("tr").index() + 1;
                var column = $(this).closest("td").index();
                var date = $(this).data('date');
                var nameofday = $(this).data('nameofday');
                column = $('tr').children('.' + column).text();
                if(nameofday != 'جمعه' && !$(this).hasClass('table_inactive')){
                    $('#day').css('display','flex');
                    $('#time').css('display','block');
                    $('#day').text(date + ' ' +  nameofday);
                    $('#time').text(column);
                    $('#hidden_day').val(date);
                    $('#hidden_time').val(column);
                }
            });

        });

    </script>
@endsection
