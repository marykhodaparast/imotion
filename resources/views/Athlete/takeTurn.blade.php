@extends('layouts.index')
@section('css')
    <link href="/plugins/select2/css/select2.min.css" rel="stylesheet" />
    <style>
        .cursor_pointer {
            cursor: pointer;
        }

        .table_inactive {
            background: lightgrey !important;
        }

    </style>
@endsection

@section('content')
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    {{-- <h1>دانش آموز</h1> --}}
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
                            <div class="row">
                                {{-- <div class="col">
                                    <div class="form-group">
                                        <label for="from_date">تاریخ نوبت گیری</label>
                                        <input type="text" id="from_date" name="from_date" class="form-control pdate"
                                            value="{{ $from_date ? jdate($from_date)->format('Y/m/d') : jdate()->format('Y/m/d') }}" />
                                    </div>
                                </div>
                                <div class="col">
                                    <div class="form-group">
                                        <label for="time">بازه های زمانی</label>
                                        <select id="time" name="time" class="form-control">
                                            @foreach ($arrOfTimes as $time)
                                                <option value="{{ $time }}">{{ $time }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div> --}}
                                <div class="col">

                                </div>
                            </div>
                            <div class="row">
                                <div class="col">
                                    <button class="btn btn-primary">
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
                            @for ($i = 1; $i <= 10; $i++)
                                <tr>
                                    <th scope="row">{{ $i }}</th>
                                    @for ($j = 0; $j < 20; $j++)
                                        <td class="{{ (jdate()->format('w') + $i) % 7 != 0 ? 'cursor_pointer bg-success' : 'table_inactive' }}"
                                            data-date="{{ jdate()->addDays($i - 1)->format('Y-m-d') }}"></td>
                                    @endfor
                                </tr>

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
        $(document).ready(function() {
            $('select.select2').select2();
            $('td').on('click', function() {
                var row = $(this).closest("tr").index() + 1;
                var column = $(this).closest("td").index();
                column = $('tr').children('.' + column).text();
                console.log($(this).data('date'), column);
            });

        });

    </script>
@endsection
