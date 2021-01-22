@extends('layouts.index')
@section('css')
<link href="/plugins/select2/css/select2.min.css" rel="stylesheet" />
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
                <table class="table">
                    <thead>
                      <tr>
                        <th scope="col">#</th>
                        <th scope="col">تایم شروع</th>
                        <th scope="col">تایم پایان</th>
                        <th scope="col">تاریخ</th>
                        <th scope="col">ورزشکار اول</th>
                        <th scope="col">ورزشکار دوم</th>
                        <th scope="col">ورزشکار سوم</th>
                      </tr>
                    </thead>
                    <tbody>
                      @foreach($slots as $slot)
                      <tr class="{{ ($slot->first_athlete && $slot->second_athlete && $slot->third_athlete) ? 'bg-danger' : '' }}">
                        <th scope="row">{{ $i++ }}</th>
                        <td>{{ $slot->start }}</td>
                        <td>{{ $slot->end }}</td>
                        <td>{{ ($slot->date)?jdate($slot->date)->format("Y/m/d"):jdate()->format("Y/m/d") }}</td>
                        <td>{{ ($slot->first_athlete) ? $slot->first_athlete->user->name : '-' }}</td>
                        <td>{{ ($slot->second_athlete) ? $slot->second_athlete->user->name : '-' }}</td>
                        <td>{{ ($slot->third_athlete) ? $slot->third_athlete->user->name : '-' }}</td>
                      </tr>

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
    $(document).ready(function(){
        $('select.select2').select2();
    });
</script>
@endsection
