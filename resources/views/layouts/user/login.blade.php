<!DOCTYPE html>
<html lang="en">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Gentelella Alela! | </title>

    <link href="{{ asset("vendors/bootstrap/dist/css/bootstrap.min.css") }}" rel="stylesheet">

    <link href="{{ asset("vendors/font-awesome/css/font-awesome.min.css") }}" rel="stylesheet">

    <link href="{{ asset("vendors/nprogress/nprogress.css") }}" rel="stylesheet">

    <link href="{{ asset("vendors/animate.css/animate.min.css") }}" rel="stylesheet">

    <link href="{{ asset("css/custom.min.css") }}" rel="stylesheet">
    <meta name="robots" content="noindex, follow">
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
                <form>
                    <h1>Giriş</h1>
                    <div>
                        <input type="text" class="form-control" placeholder="eMail" required=""/>
                    </div>
                    <div>
                        <input type="password" class="form-control" placeholder="Parola" required=""/>
                    </div>
                    <div>
                        <a class="btn btn-primary submit" href="#">Giriş Yap</a>
                    </div>
                    <div>
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
        <div id="register" class="animate form registration_form">
            <div class="text-center">
                <h1><i class="fa fa-paw"></i> {{ config('app.name') }}</h1>
            </div>
            <section class="login_content">
                <form>
                    <div>
                        <input type="email" class="form-control" placeholder="eMail" required=""/>
                    </div>
                    <div>
                        <input type="password" class="form-control" placeholder="Parola" required=""/>
                    </div>
                    <div>
                        <a class="btn btn-default submit" href="#">Kayıt Ol</a>
                    </div>
                    <div class="clearfix"></div>
                    <div class="separator">
                        <p class="change_link">Zaten hesabınız var mı ?
                            <a href="#signin" class="to_register"> Giriş yap</a>
                        </p>
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
<script defer src="https://static.cloudflareinsights.com/beacon.min.js"
        data-cf-beacon='{"rayId":"665e80ae5cc16249","token":"cd0b4b3a733644fc843ef0b185f98241","version":"2021.5.2","si":10}'></script>
</body>
</html>
