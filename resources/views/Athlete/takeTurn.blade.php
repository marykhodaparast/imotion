@extends('layouts.index')
@section('css')
<link href="/plugins/select2/css/select2.min.css" rel="stylesheet" />
<style>
    .cursor_pointer{
        cursor:pointer;
    }
    .table_inactive{
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
                <form method="POST"  action="{{ route('athletetaketurn') }}">
                @csrf
                <div class="row">
                    {{-- <div class="col">
                        <div class="form-group">
                            <label for="from_date">تاریخ نوبت گیری</label>
                            <input type="text" id="from_date" name="from_date" class="form-control pdate" value="{{ ($from_date)?jdate($from_date)->format("Y/m/d"):jdate()->format("Y/m/d") }}" />
                        </div>
                    </div>
                    <div class="col">
                        <div class="form-group">
                            <label for="time">بازه های زمانی</label>
                            <select id="time" name="time" class="form-control">
                                @foreach($arrOfTimes as $time)
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
                          <th scope="col" class="1">{{ $arrOfTimes[0] }}</th>
                          <th scope="col" class="2">{{ $arrOfTimes[1] }}</th>
                          <th scope="col" class="3">{{ $arrOfTimes[2] }}</th>
                          <th scope="col" class="4">{{ $arrOfTimes[3] }}</th>
                          <th scope="col" class="5">{{ $arrOfTimes[4] }}</th>
                          <th scope="col" class="6">{{ $arrOfTimes[5] }}</th>
                          <th scope="col" class="7">{{ $arrOfTimes[6] }}</th>
                          <th scope="col" class="8">{{ $arrOfTimes[7] }}</th>
                          <th scope="col" class="9">{{ $arrOfTimes[8] }}</th>
                          <th scope="col" class="10">{{ $arrOfTimes[9] }}</th>
                          <th scope="col" class="11">{{ $arrOfTimes[10] }}</th>
                          <th scope="col" class="12">{{ $arrOfTimes[11] }}</th>
                          <th scope="col" class="13">{{ $arrOfTimes[12] }}</th>
                          <th scope="col" class="14">{{ $arrOfTimes[13] }}</th>
                          <th scope="col" class="15">{{ $arrOfTimes[14] }}</th>
                          <th scope="col" class="16">{{ $arrOfTimes[15] }}</th>
                          <th scope="col" class="17">{{ $arrOfTimes[16] }}</th>
                          <th scope="col" class="18">{{ $arrOfTimes[17] }}</th>
                          <th scope="col" class="19">{{ $arrOfTimes[18] }}</th>
                          <th scope="col" class="20">{{ $arrOfTimes[19] }}</th>
                        </tr>
                      </thead>
                      <tbody>
                        {{-- @foreach($slots as $slot)
                        <tr class="{{ ($slot->first_athlete && $slot->second_athlete && $slot->third_athlete) ? 'bg-danger' : '' }}">
                          <th scope="row">{{ $i++ }}</th>
                          <td>{{ $slot->start }}</td>
                          <td>{{ $slot->end }}</td>
                          <td>{{ ($slot->date)?jdate($slot->date)->format("Y/m/d"):jdate()->format("Y/m/d") }}</td>
                          <td>{{ ($slot->first_athlete) ? $slot->first_athlete->user->name : '-' }}</td>
                          <td>{{ ($slot->second_athlete) ? $slot->second_athlete->user->name : '-' }}</td>
                          <td>{{ ($slot->third_athlete) ? $slot->third_athlete->user->name : '-' }}</td>
                        </tr>

                        @endforeach --}}
                        @for($i = 1; $i <= 10; $i++)
                           <tr data-day="{{ (jdate()->format('w')  + $i) % 7 }}">
                               <th scope="row">{{ $i }}</th>
                               <td class="cursor_pointer bg-success table_inactive" >{{ (jdate()->format('w')  + $i) % 7}}</td>
                               <td class="cursor_pointer bg-success" ></td>
                               <td class="cursor_pointer bg-success" ></td>
                               <td class="cursor_pointer bg-success" ></td>
                               <td class="cursor_pointer bg-success" ></td>
                               <td class="cursor_pointer bg-success" ></td>
                               <td class="cursor_pointer bg-success" ></td>
                               <td class="cursor_pointer bg-success" ></td>
                               <td class="cursor_pointer bg-success" ></td>
                               <td class="cursor_pointer bg-success" ></td>
                               <td class="cursor_pointer bg-success" ></td>
                               <td class="cursor_pointer bg-success" ></td>
                               <td class="cursor_pointer bg-success" ></td>
                               <td class="cursor_pointer bg-success" ></td>
                               <td class="cursor_pointer bg-success" ></td>
                               <td class="cursor_pointer bg-success" ></td>
                               <td class="cursor_pointer bg-success" ></td>
                               <td class="cursor_pointer bg-success" ></td>
                               <td class="cursor_pointer bg-success" ></td>
                               <td class="cursor_pointer bg-success" ></td>
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
    // console.log(arr);
    // function getColumn(i){

    // }
    // var x = '.1';
    // console.log($('tr').children(x).text());

    $(document).ready(function(){
        $('select.select2').select2();
    });
    $('td').on('click',function(){
        var row = $(this).closest("tr").index() + 1;
        var column = $(this).closest("td").index();
        column = $('tr').children('.' + column).text();
        console.log(row,column);
    });
</script>
@endsection
