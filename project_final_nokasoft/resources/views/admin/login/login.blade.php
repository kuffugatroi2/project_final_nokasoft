<!DOCTYPE html>
<html lang="en">

<head>
    <base href="{{ asset('') }}">
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <!-- Meta, title, CSS, favicons, etc. -->
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Vertu - Đồng hồ chính hãng | Luôn có sẵn tất cả các mẫu BH trọn đời</title>

    <!-- Bootstrap -->
    <link href="gentelella-master/vendors/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link href="gentelella-master/vendors/font-awesome/css/font-awesome.min.css" rel="stylesheet">
    <!-- NProgress -->
    <link href="gentelella-master/vendors/nprogress/nprogress.css" rel="stylesheet">
    <!-- Animate.css -->
    <link href="gentelella-master/vendors/animate.css/animate.min.css" rel="stylesheet">

    <!-- Custom Theme Style -->
    <link href="gentelella-master/build/css/custom.min.css" rel="stylesheet">
</head>

<body class="login">
    <div class="login_wrapper">
        <div class="animate form login_form">
            <section class="login_content">
                <img src="img-logo/VT_luxury.png" alt="Logo">
                <div id="alert" style="opacity: 1; transition: opacity 2s;">
                    @include('Layout.message')
                </div>
                <form action="{{ route('admin_authentication.login') }}" method="POST">
                    @csrf
                    <h1>Login Form</h1>
                    <div>
                        <input type="email" name="email" class="form-control" placeholder="Username" required="" />
                    </div>
                    <div>
                        <input type="password" name="password" class="form-control" placeholder="Password" required="" />
                    </div>
                    <div>
                        <button class="btn btn-default submit">Login</button>
                        <a class="reset_pass" href="#">Lost your password?</a>
                    </div>
                    <div class="separator">
                        <p class="change_link">VĂN TÚ LUXURY</p>
                        <p>Thế giới vertu & đồng hồ sang trọng</p>
                    </div>
                </form>
            </section>
        </div>
    </div>
</body>

<script>
    /*
        Trong đoạn mã này sẽ:
        Đặt giá trị 'opacity' của phần tử có id "alert" thành 0 sau 10s
        Sau đó, đặt thuộc tính 'display' thành none sau 2s để ẩn phần tử
        (Hiệu ứng mờ dần sẽ diễn ra trong vòng 2s)
    */
    setTimeout(function() {
        // Lấy thẻ div chứa thông báo
        var alertDiv = document.getElementById('alert');
        alertDiv.style.opacity = 0;
        setTimeout(function() {
            alertDiv.style.display = 'none';
        }, 2000); // Mất sau 2 giây
    }, 5000); // Hiển thị trong 10 giây

</script>

</html>
