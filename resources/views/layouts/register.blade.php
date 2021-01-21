<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>
        @section('page_title')
        {{ env('APP_NAME') }}
        @show
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
<body class="hold-transition register-page bg-image">
    <div class="register-box">
        <div class="register-logo">
            <a> {{ env('APP_NAME') }}</a>
        </div>
        @auth
        <div class="card p-3">
            <div class="alert alert-danger">
                قبلا ثبت نام انجام شده است
            </div>
            <a href="/" class="btn btn-block btn-success"> بازگشت</a>
        </div>
        @endauth
        @isset($error)
        <div class="alert alert-danger">
            <ul>
                <li>{{ $error }}</li>
            </ul>
        </div>
        @endisset
        @guest
        @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
        @endif
        <div class="register-box-body card p-3">
            <p class="login-box-msg">ثبت نام ورزشکار</p>
            <form id="frm1" action="{{ route('sendsms') }}" method="post">
                @csrf
                <div class="input-group mb-3">
                    <div class="input-group-append">
                        <div class="input-group-text">
                            <span class="fas fa-user"></span>
                        </div>
                    </div>
                    <input value="{{ old('fname') }}" type="text" class="form-control" placeholder="نام" id="fname" name="fname">
                </div>
                <div class="input-group mb-3">
                    <div class="input-group-append">
                        <div class="input-group-text">
                            <span class="fas fa-envelope"></span>
                        </div>
                    </div>
                    <input value="{{ old('lname') }}" type="text" class="form-control" placeholder="نام خانوادگی" id="lname" name="lname">
                </div>
                <div class="input-group mb-3">
                    <div class="input-group-append">
                        <div class="input-group-text">
                            <span class="fas fa-lock"></span>
                        </div>
                    </div>
                    <input value="{{ old('mobile') }}" type="text" class="form-control" placeholder="تلفن همراه" id="mobile" name="mobile">
                </div>
            </form>

        </div><!-- /.form-box -->
        @endguest
    </div><!-- /.register-box -->
    <!-- jQuery -->
    <script src="/plugins/jquery/jquery.min.js"></script>
    <!-- Bootstrap 4 -->
    <script src="/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>

    @isset($first_step)
    <script>
        $(document).ready(() => {
            $("#first_step").on('click', () => {
                let ok = true;
                $("#frm1 :input").each(function() {
                    $(this).css("border", "1px solid rgb(206, 212, 218)");
                    if ($(this).prop('id') != "") {
                        if ($(this).val() == "") {
                            $(this).css("border", "solid 1px red");
                            ok = false;
                        }
                    }
                });
                if (!ok) {
                    $("#msg").html('لطفا کلیه موارد را وارد کنید');
                    $("#msg").addClass("alert").addClass("alert-danger");
                    return;
                }
                $("#frm1").submit();
            });
        });

    </script>
    @endisset


    @isset($final_step)
    <script>
        $(document).ready(() => {
            setTimeout(() => {
                window.location = "{{ route('login') }}";
            }, 4000);
        });

    </script>
    @endisset
</body>
</html>
