<!DOCTYPE html>
<html lang="tr">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ config('app.name') }}</title>
    <link href="{{ asset("vendors/bootstrap/dist/css/bootstrap.min.css") }}" rel="stylesheet">
    <link href="{{ asset("vendors/font-awesome/css/font-awesome.min.css") }}" rel="stylesheet">
    <link href="{{ asset("vendors/nprogress/nprogress.css") }}" rel="stylesheet">
    <link href="{{ asset("vendors/animate.css/animate.min.css") }}" rel="stylesheet">
    <link href="{{ asset("css/custom.min.css") }}" rel="stylesheet">
    <link href="{{ asset("vendors/pnotify/dist/pnotify.css") }}" rel="stylesheet">
    <meta name="robots" content="noindex, follow">
    <meta name="csrf-token" content="{{ csrf_token() }}">
</head>
<body class="login">
<div>
    <a class="hiddenanchor" id="reset"></a>
    <a class="hiddenanchor" id="signin"></a>
    <div class="login_wrapper">
        <div class="animate form login_form">
            <div class="text-center">
                <h1><i class="fa fa-paw"></i> {{ config('app.name') }}</h1>
            </div>
            <section class="login_content">
                <form class="form-horizontal" role="form" method="POST" id="login_form"
                      action="{{ route('user.login_action') }}">
                    {{ csrf_field() }}
                    <h1>Giriş</h1>
                    <div class="form-group">
                        <input type="email" name="email" id="email" class="form-control" placeholder="eMail">
                        <span class="help-block"></span>
                    </div>
                    <div class="form-group">
                        <input type="password" name="password" id="password" class="form-control" placeholder="Parola">
                        <span class="help-block"></span>
                    </div>
                    <div class="form-group">
                        <button type="submit" class="btn btn-primary submit" id="submitLogin" href="#">Giriş Yap
                        </button>
                        <span class="help-block"></span>
                    </div>
                    <div class="form-group">
                        <a class="btn btn-default" href="#reset">Parolanızı mı unuttunuz ?</a>
                    </div>
                    <div class="clearfix"></div>
                    <div class="separator">
                        <div class="clearfix"></div>
                        <br/>
                        <div>
                            <p>{{ config('app.name') }} by portg.net</p>
                        </div>
                    </div>
                </form>
            </section>
        </div>
    </div>
</div>
<script src="{{ asset("vendors/jquery/dist/jquery.min.js") }}"></script>
<script type="text/javascript">
    $('#login_form').submit(function (e) {
        $('#submitLogin').prop('disabled', true);
        setTimeout(function() {
            $('#submitLogin').prop('disabled', false);
        }, 3000); // 3 seconds
        $("#login_form #messages").html(null);
        var inputs = $('#login_form .form-group');
        inputs.removeClass('has-error');
        inputs.find('.help-block').html(null);
        e.preventDefault();
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        var form = $('#login_form')[0];
        var formData = new FormData(form);
        $.ajax({
            type: "POST",
            url: $(this).attr("action"),
            enctype: "multipart/form-data",
            data: formData,
            contentType: false,
            processData: false,
            cache: false,
            success: function (data) {
                new PNotify({
                    title: data.messages.title,
                    text: data.messages.message,
                    type: data.messages.status,
                    delay: 3000,
                    styling: 'bootstrap3'
                });
                if(data.messages.status === 'success'){
                    setTimeout(function () {
                        location.reload();
                    }, 3000);
                }
            },
            error: function (data) {
                var msg_field = '';
                $.each(data.responseJSON.errors, function (key, value) {
                    var formGroup = $("#login_form #" + key).closest(".form-group");
                    formGroup.addClass('has-error');
                    formGroup.find('.help-block').html(value[0]);
                    msg_field += '<li>' + value[0] + '</li>';
                });
                new PNotify({
                    title: 'Hata',
                    text: msg_field,
                    type: 'warning',
                    delay: 1500,
                    styling: 'bootstrap3'
                });
                if (!data.responseJSON.errors) {
                }
            }
        });
        return false;
    });
</script>
<script src="{{ asset("vendors/pnotify/dist/pnotify.js") }}"></script>
{{--
<script defer src="https://static.cloudflareinsights.com/beacon.min.js"
        data-cf-beacon='{"rayId":"665e80ae5cc16249","token":"cd0b4b3a733644fc843ef0b185f98241","version":"2021.5.2","si":10}'></script>
<!-- jQuery -->
--}}
</body>
</html>
