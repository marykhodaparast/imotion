<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>
        IMOTION
    </title>
    <!-- Tell the browser to be responsive to screen width -->
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="/plugins/fontawesome-free/css/all.min.css">
    <!-- Ionicons -->
    <link rel="stylesheet" href="/dist/css/ionicons.min.css">
    <!-- iCheck -->
    <link rel="stylesheet" href="/plugins/icheck-bootstrap/icheck-bootstrap.min.css">
    <!-- Theme style -->
    <link rel="stylesheet" href="/dist/css/adminlte.min.css">
    <!-- Bootstrap 4 RTL -->
    <link rel="stylesheet" href="/dist/css/bootstrap.min.css">
    <!-- Custom style for RTL -->
    <link rel="stylesheet" href="/dist/css/custom.css">
</head>
<body class="hold-transition register-page">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
          <div class="row mb-2">
            <div class="col-sm-6">
              <h1>فرم ثبت نام</h1>
            </div>
            <div class="col-sm-6">
              @if ($errors->any())
                <div class="alert alert-danger alert-dismissible">
                  <a href="#" class="close" data-dismiss="alert" aria-label="close" style="right: auto;">&times;</a>
                  <ul>
                    @foreach ($errors->all() as $error)
                      <li>{{ $error }}</li>
                    @endforeach
                  </ul>
                </div>
              @endif
              @if(isset($custom_error))
              <div class="alert alert-danger alert-dismissible">
                <a href="#" class="close" data-dismiss="alert" aria-label="close" style="right: auto;">&times;</a>
                {{$custom_error}}
              </div>
              @endif
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
                <form method="POST" enctype="multipart/form-data">
                @csrf
                <div class="row">
                    <div class="col">
                        <div class="form-group">
                            <label for="first_name">نام <span style="color: red;">*</span></label>
                            <input type="text" class="form-control" id="first_name" name="first_name" placeholder="نام" value="{{ old('first_name') }}" />
                        </div>

                        <div class="form-group">
                            <label for="email">ایمیل</label>
                            <input type="text" class="form-control" id="email" name="email" placeholder="ایمیل" value="{{ old('email') }}" />
                        </div>

                        <div class="form-group">
                            <label for="birthdate">تاریخ تولد</label>
                            <input type="text" class="form-control" id="birthdate" name="birthdate" placeholder="تاریخ تولد" value="{{ old('birthdate') }}" />
                        </div>

                        <div class="form-group">
                            <label for="id_number">شماره شناسنامه</label>
                            <input type="text" class="form-control" id="id_number" name="id_number" placeholder="شناسنامه" value="{{ old('id_number') }}" />
                        </div>

                        <div class="form-group">
                            <label for="job">شغل</label>
                            <input type="text" class="form-control" id="job" name="job" placeholder="شغل" value="{{ old('job') }}" />
                        </div>

                        <div class="form-group">
                            <label for="cell">تلفن همراه <span style="color: red;">*</span></label>
                            <input type="text" class="form-control" id="cell" name="cell" placeholder="موبایل" value="{{ old('cell') }}" />
                        </div>

                        <div class="form-group">
                            <label for="emergency_phone">تلفن ضروری (ترجیحا ثابت)</label>
                            <input type="text" class="form-control" id="emergency_phone" name="emergency_phone" placeholder="تلفن ضروری " value="{{ old('emergency_phone') }}" />
                        </div>

                        <div class="form-group">
                            <label for="ems_exp">آیا تجربه تمرین EMS داشته اید؟ چند جلسه؟</label>
                            <input type="number" class="form-control" id="ems_exp" name="ems_exp" placeholder="EMS" value="{{ old('ems_exp') }}" />
                        </div>

                        <div class="form-group">
                            <label for="diet_weekly_call">آیا تمایل دارید هفته ای یکبار جهت پیگیری رژیم غذایی با شما تماس گرفته شود؟</label>
                            <input type="checkbox" class="form-control" id="diet_weekly_call" name="diet_weekly_call" value="{{ old('diet_weekly_call') }}" />
                        </div>
                    </div>
                    <div class="col">
                        <div class="form-group">
                            <label for="last_name">نام خانوادگی <span style="color: red;">*</span></label>
                            <input type="text" class="form-control" id="last_name" name="last_name" placeholder="نام خانوادگی" value="{{ old('last_name') }}"  />
                        </div>

                        <div class="form-group">
                            <label for="father_name">نام پدر</label>
                            <input type="text" class="form-control" id="father_name" name="father_name" placeholder="نام پدر" value="{{ old('father_name') }}" />
                        </div>

                        <div class="form-group">
                            <label for="address">آدرس</label>
                            <input type="text" class="form-control" id="address" name="address" placeholder="آدرس" value="{{ old('address') }}" />
                        </div>

                        <div class="form-group">
                            <label for="education">تحصیلات</label>
                            <input type="text" class="form-control" id="education" name="education" placeholder="تحصیلات" value="{{ old('education') }}" />
                        </div>

                        <div class="form-group">
                            <label for="position">سمت</label>
                            <input type="text" class="form-control" id="position" name="position" placeholder="سمت" value="{{ old('position') }}" />
                        </div>

                        <div class="form-group">
                            <label for="cell_telegram">شماره تلگرام</label>
                            <input type="text" class="form-control" id="cell_telegram" name="cell_telegram" placeholder="تلگرام" value="{{ old('cell_telegram') }}" />
                        </div>

                        <div class="form-group">
                            <label for="referrer">معرف</label>
                            <input type="text" class="form-control" id="referrer" name="referrer" placeholder="معرف" value="{{ old('referrer') }}" />
                        </div>

                        <div class="form-group">
                            <label for="sport_exp">سوابق ورزشی</label>
                            <input type="number" class="form-control" id="sport_exp" name="sport_exp" placeholder="سوابق" value="{{ old('sport_exp') }}" />
                        </div>

                        <div class="form-group">
                            <label for="before_session_call">آیا تمایل دارید قبل از هرجلسه تمرینی جهت هماهنگی با شما تماس گرفته شود ؟</label>
                            <input type="checkbox" class="form-control" id="before_session_call" name="before_session_call" value="{{ old('before_session_call') }}" />
                        </div>
                    </div>
                </div>
                <div class="row">
                  <div class="col-12">
                    <h3>
                      هدف خود را از حضور در باشگاه iGym ذکر نمایید:
                    </h3>
                  </div>
                </div>
                <div class="row">
                  <div class="col">
                    <div class="form-group">
                      <label for="goal_muscle">عضله سازی کل بدن</label>
                      <input type="checkbox" class="form-control" id="goal_muscle" name="goal_muscle" value="{{ old('goal_muscle') }}" />
                    </div>

                    <div class="form-group">
                      <label for="goal_fat">چربی سوزی کل بدن</label>
                      <input type="checkbox" class="form-control" id="goal_fat" name="goal_fat" value="{{ old('goal_fat') }}" />
                    </div>

                    <div class="form-group">
                      <label for="goal_ass_small">کاهش سایز شکم</label>
                      <input type="checkbox" class="form-control" id="goal_ass_small" name="goal_ass_small" value="{{ old('goal_ass_small') }}" />
                    </div>

                    <div class="form-group">
                      <label for="goal_belly_nice">فرم دهی شکم(Six Pack)</label>
                      <input type="checkbox" class="form-control" id="goal_belly_nice" name="goal_belly_nice" value="{{ old('goal_belly_nice') }}" />
                    </div>

                    <div class="form-group">
                      <label for="goal_arm_muscle">عضله سازی بازو</label>
                      <input type="checkbox" class="form-control" id="goal_arm_muscle" name="goal_arm_muscle" value="{{ old('goal_arm_muscle') }}" />
                    </div>

                    <div class="form-group">
                      <label for="goal_arm_small">کاهش سایز بازو</label>
                      <input type="checkbox" class="form-control" id="goal_arm_small" name="goal_arm_small" value="{{ old('goal_arm_small') }}" />
                    </div>

                    <div class="form-group">
                      <label for="goal_back_nice">فرم دهی عضلات پشت بدن</label>
                      <input type="checkbox" class="form-control" id="goal_back_nice" name="goal_back_nice" value="{{ old('goal_back_nice') }}" />
                    </div>
                  </div>
                  <div class="col">
                    <div class="form-group">
                      <label for="goal_ass_nice">فرم دهی باسن</label>
                      <input type="checkbox" class="form-control" id="goal_ass_nice" name="goal_ass_nice" value="{{ old('goal_ass_nice') }}" />
                    </div>

                    <div class="form-group">
                      <label for="goal_ass_small">کاهش سایز باسن</label>
                      <input type="checkbox" class="form-control" id="goal_ass_small" name="goal_ass_small" value="{{ old('goal_ass_small') }}" />
                    </div>

                    <div class="form-group">
                      <label for="goal_tit_nice">فرم دهی سینه</label>
                      <input type="checkbox" class="form-control" id="goal_tit_nice" name="goal_tit_nice" value="{{ old('goal_tit_nice') }}" />
                    </div>

                    <div class="form-group">
                      <label for="goal_tit_small">کاهش سایز سینه</label>
                      <input type="checkbox" class="form-control" id="goal_tit_small" name="goal_tit_small" value="{{ old('goal_tit_small') }}" />
                    </div>

                    <div class="form-group">
                      <label for="goal_foot_nice">فرم دهی ران</label>
                      <input type="checkbox" class="form-control" id="goal_foot_nice" name="goal_foot_nice" value="{{ old('goal_foot_nice') }}" />
                    </div>

                    <div class="form-group">
                      <label for="goal_foot_small">کاهش سایز ران</label>
                      <input type="checkbox" class="form-control" id="goal_foot_small" name="goal_foot_small" value="{{ old('goal_foot_small') }}" />
                    </div>

                    <div class="form-group">
                      <label for="goal_other">سایر اهداف</label>
                      <input type="text" class="form-control" id="goal_other" name="goal_other" value="{{ old('goal_other') }}" />
                    </div>
                  </div>
                  <div class="col-12">
                    <div class="form-group">
                      <label for="description">توضیحات ضروری</label>
                      <input type="text" class="form-control" id="description" name="description" value="{{ old('description') }}" />
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
    <!-- jQuery -->
    <script src="/plugins/jquery/jquery.min.js"></script>
    <!-- Bootstrap 4 -->
    <script src="/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
</body>
</html>
