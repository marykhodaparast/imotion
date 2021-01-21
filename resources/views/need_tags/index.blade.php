@extends('layouts.index')

@section('content')
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
          <div class="row mb-2">
            <div class="col-sm-6">
              <h1>برچسب های نیازسنجی</h1>
            </div>
            <div class="col-sm-6">
              <!--
              <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="#">Home</a></li>
                <li class="breadcrumb-item active">DataTables</li>
              </ol>
              -->
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
                <h3 class="card-title">
                    <a class="btn btn-success" href="{{ route('need_tag_create') }}">برچسب جدید</a>
                </h3>
              </div>
              <!-- /.card-header -->
              <div class="card-body">
                <table id="example2" class="table table-bordered table-hover">
                  <thead>
                  <tr>
                    <th>ردیف</th>
                    <th>کد</th>
                    <th>نام</th>
                    <th>برچسب اصلی</th>
                    <th>برچسب فرعی 1</th>
                    <th>برچسب فرعی 2</th>
                    <th>برچسب فرعی 3</th>
                    <th>ثبت کننده</th>
                    <th>#</th>
                  </tr>
                  </thead>
                  <tbody>
                      @foreach ($tags as $index => $item)
                      <tr>
                        <td>{{ $index + 1 }}</td>
                        <td>{{ $item->id }}</td>
                        <td>{{ ($item->product)?$item->product->name:'' }}</td>
                        <td>{{ ($item->need_parent_one)?$item->need_parent_one->name:'-' }}</td>
                        <td>{{ ($item->need_parent_two)?$item->need_parent_two->name:'-' }}</td>
                        <td>{{ ($item->need_parent_three)?$item->need_parent_three->name:'-' }}</td>
                        <td>{{ ($item->need_parent_four)?$item->need_parent_four->name:'-' }}</td>
                        <td>{{ ($item->user)?$item->user->first_name . ' ' . $item->user->last_name:'-' }}</td>
                        <td>
                            <a class="btn btn-primary" href="{{ route('need_tag_edit', $item->id) }}">
                                ویرایش
                            </a>
                            <a class="btn btn-danger" href="{{ route('need_tag_delete', $item->id) }}">
                                حذف
                            </a>
                        </td>
                      </tr>
                      @endforeach
                  </tbody>
                  <!--
                  <tfoot>
                  <tr>
                    <th>Rendering engine</th>
                    <th>Browser</th>
                    <th>Platform(s)</th>
                    <th>Engine version</th>
                    <th>CSS grade</th>
                  </tr>
                  </tfoot>
                  -->
                </table>
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
<!-- DataTables -->
<script src="../../plugins/datatables/jquery.dataTables.js"></script>
<script src="../../plugins/datatables-bs4/js/dataTables.bootstrap4.js"></script>
<!-- page script -->
<script>
    $(function () {
    //   $("#example1").DataTable();
      $('#example2').DataTable({
        "paging": true,
        "lengthChange": false,
        "searching": false,
        "ordering": true,
        "info": true,
        "autoWidth": false,
        "language": {
            "paginate": {
                "previous": "قبل",
                "next": "بعد"
            },
            "emptyTable":     "داده ای برای نمایش وجود ندارد",
            "info":           "نمایش _START_ تا _END_ از _TOTAL_ داده",
            "infoEmpty":      "نمایش 0 تا 0 از 0 داده",
        }
      });

      $(".btn-danger").click(function(e){
          if(!confirm('آیا مطمئنید؟')){
            e.preventDefault();
          }
      });
    });
  </script>
@endsection
