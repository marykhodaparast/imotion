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
              <div class="card-header">
              </div>
              <!-- /.card-header -->
              <div class="card-body">
                <form method="POST"  action="{{ route('athletetaketurn') }}">
                @csrf
                <div class="row">
                    <div class="col">
                        {{-- <div class="form-group">
                            <label for="sources_id">منبع</label>
                            <select  id="sources_id" name="sources_id" class="form-control select2" required>
                                <option value="0"></option>
                            </select>
                        </div> --}}
                        <div class="form-group">
                            <label for="from_date">تاریخ نوبت گیری</label>
                            <input type="text" id="from_date" name="from_date" class="form-control pdate" value="{{ ($from_date)?jdate($from_date)->format("Y/m/d"):jdate()->format("Y/m/d") }}" />
                        </div>
                    </div>
                    <div class="col">
                        <div class="form-group">
                            <label for="time">بازه های زمانی</label>
                            <select id="sources_id" name="time" class="form-control">
                                <option value="0">-</option>
                                @foreach($arrOfTimes as $time)
                                   <option value="{{ $time }}">{{ $time }}</option>
                                @endforeach
                                {{-- @foreach ($sources as $item)
                                @if(isset($sources_id) && $sources_id==$item->id)
                                <option value="{{ $item->id }}" selected>
                                    @else
                                <option value="{{ $item->id }}">
                                    @endif
                                    {{ $item->name }}
                                </option>
                                @endforeach --}}
                            </select>
                        </div>
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
