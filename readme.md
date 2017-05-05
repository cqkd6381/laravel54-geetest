<p align="center"><img src="https://laravel.com/assets/img/components/logo-laravel.svg"></p>

<p align="center">
<a href="https://travis-ci.org/laravel/framework"><img src="https://travis-ci.org/laravel/framework.svg" alt="Build Status"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://poser.pugx.org/laravel/framework/d/total.svg" alt="Total Downloads"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://poser.pugx.org/laravel/framework/v/stable.svg" alt="Latest Stable Version"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://poser.pugx.org/laravel/framework/license.svg" alt="License"></a>
</p>

# 极验证 Composer Package

## 视频教程: [Laravist](https://laravist.com/series/tools-that-are-dame-good-for-developer/episodes/1)

>说明：由于geetest本身的composer package有很多不必要的文件，这里是最精简的版本，只用于验证码验证。

## 演示

![geetesst](https://cloud.githubusercontent.com/assets/6011686/12508320/385a56a6-c136-11e5-9353-b686c85bd37a.gif)

## Usage

安装 （目前的版本是 1.0）：

```
composer require laravist/geecaptcha
```

1. 实例化
```php
 $captcha = new \Laravist\GeeCaptcha\GeeCaptcha($captcha_id, $private_key);
```

2. 使用的使用可以这样判断验证码是否验证成功（通常是post路由里）：

```php
 if ($captcha->isFromGTServer() && $captcha->success()) 
 {
     // 登录的代码逻辑在这里   
 }

```
> 注意: 上面第一个判断是检测GT(geetest.com)的服务器是否正常，第二个才是检测验证码是否正确。

3. 对于需要重新生成验证码的时候（通常放在get方式的路由里）：

```php
$captcha = new \Laravist\GeeCaptcha\GeeCaptcha($captcha_id, $private_key);
echo $captcha->GTServerIsNormal();
```

## Laravel 使用用例

routes/web.php

```php
Route::get('/captcha', function () {
    $captcha = new \Laravist\GeeCaptcha\GeeCaptcha(env('CAPTCHA_ID'), env('PRIVATE_KEY'));

    echo $captcha->GTServerIsNormal();
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
```
login视图:

```html
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

```

Controllers/Auth/LoginController.php
```php
use Illuminate\Http\Request;

 public function login(Request $request)
    {
        $this->verify();
        $this->validateLogin($request);

        // If the class is using the ThrottlesLogins trait, we can automatically throttle
        // the login attempts for this application. We'll key this by the username and
        // the IP address of the client making these requests into this application.
        if ($this->hasTooManyLoginAttempts($request)) {
            $this->fireLockoutEvent($request);

            return $this->sendLockoutResponse($request);
        }

        if ($this->attemptLogin($request)) {
            return $this->sendLoginResponse($request);
        }

        // If the login attempt was unsuccessful we will increment the number of attempts
        // to login and redirect the user back to the login form. Of course, when this
        // user surpasses their maximum number of attempts they will get locked out.
        $this->incrementLoginAttempts($request);

        return $this->sendFailedLoginResponse($request);
    }

    public function verify()
    {
        $captcha = new \Laravist\GeeCaptcha\GeeCaptcha(env('CAPTCHA_ID'), env('PRIVATE_KEY'));
        if ($captcha->isFromGTServer()) {
            if($captcha->success()){
                return 'success';
            }
            // return 'no';
            exit('非法请求');
        }else{
            exit('非法请求');
        }
        if ($captcha->hasAnswer()) {
                return "answer";
        }
        // return "no answer";
        exit('验证服务器异常，请重试！');
    }

```


