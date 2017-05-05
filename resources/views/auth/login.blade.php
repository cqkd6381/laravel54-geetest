@extends('layouts.app')

@section('content')
<script src="http://libs.baidu.com/jquery/1.9.0/jquery.js"></script>
<script src="http://api.geetest.com/get.php"></script>
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">Login</div>
                <div class="panel-body">
                    <form class="form-horizontal" role="form" method="POST" action="{{route('login')}}">
                        {{ csrf_field() }}

                        <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
                            <label for="email" class="col-md-4 control-label">E-Mail Address</label>

                            <div class="col-md-6">
                                <input id="email" type="email" class="form-control" name="email" value="{{ old('email') }}" required autofocus>

                                @if ($errors->has('email'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('email') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}">
                            <label for="password" class="col-md-4 control-label">Password</label>

                            <div class="col-md-6">
                                <input id="password" type="password" class="form-control" name="password" required>

                                @if ($errors->has('password'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('password') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>


                        <div class="form-group" id="div_geetest_lib">
                            <div id="captcha" class="col-md-6 col-md-offset-4"></div>
                            <script src="http://static.geetest.com/static/tools/gt.js"></script>
                            <script>
                                var handler = function (captchaObj) {
                                    // 将验证码加到id为captcha的元素里
                                    captchaObj.appendTo("#captcha");
                                };
                                $.ajax({
                                    // 获取id，challenge，success（是否启用failback）
                                    url: "captcha?rand="+Math.round(Math.random()*100),
                                    type: "get",
                                    dataType: "json", // 使用jsonp格式
                                    success: function (data) {
                                        // 使用initGeetest接口
                                        // 参数1：配置参数，与创建Geetest实例时接受的参数一致
                                        // 参数2：回调，回调的第一个参数验证码对象，之后可以使用它做appendTo之类的事件
                                        initGeetest({
                                            gt: data.gt,
                                            challenge: data.challenge,
                                            product: "float", // 产品形式
                                            offline: !data.success
                                        }, handler);
                                    }
                                });
                            </script>
                        </div>

                        <div class="form-group">
                            <div class="col-md-6 col-md-offset-4">
                                <div class="checkbox">
                                    <label>
                                        <input type="checkbox" name="remember" {{ old('remember') ? 'checked' : '' }}> Remember Me
                                    </label>
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="col-md-8 col-md-offset-4">
                                <button type="submit" class="btn btn-primary">
                                    Login
                                </button>

                                <a class="btn btn-link" href="{{ route('password.request') }}">
                                    Forgot Your Password?
                                </a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection

@section('script')
@endsection
