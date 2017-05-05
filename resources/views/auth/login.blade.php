@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">Login</div>
                <div class="panel-body">
                    <form class="form-horizontal" role="form" method="POST" action="{{ route('login') }}" id="my-form">
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
                        <div id="captcha">
            <p id="wait" class="show" style="display: none;">正在加载验证码......</p>
        <div class="geetest_holder geetest_wind geetest_detect" style="width: 300px;"><div class="geetest_form"><input type="hidden" name="geetest_challenge"><input type="hidden" name="geetest_validate"><input type="hidden" name="geetest_seccode"></div><div class="geetest_slide"><div class="geetest_slide_tip"><span class="geetest_slide_tip_content"></span></div><div class="geetest_btn_bg"></div><div class="geetest_target"></div></div><div class="geetest_btn"><div class="geetest_radar_btn"><div class="geetest_radar"><div class="geetest_ring"><div class="geetest_small"></div></div><div class="geetest_sector" style="transform: rotate(258.203deg);"><div class="geetest_small"></div></div><div class="geetest_cross"><div class="geetest_h"></div><div class="geetest_v"></div></div><div class="geetest_dot"></div><div class="geetest_scan"><div class="geetest_h"></div></div><div class="geetest_status"><div class="geetest_bg"></div><div class="geetest_hook"></div></div></div><div class="geetest_ie_radar"></div><div class="geetest_radar_tip"><span class="geetest_radar_tip_content">点击按钮进行验证</span><span class="geetest_reset_tip_content">请点击重试</span></div><a class="geetest_logo" target="_blank" href="http://www.geetest.com/first_page"></a><div class="geetest_other_offline geetest_offline"></div></div><div class="geetest_ghost_success"><div class="geetest_success_btn"><div class="geetest_success_box"><div class="geetest_success_show"><div class="geetest_success_pie"></div><div class="geetest_success_filter"></div><div class="geetest_success_mask"></div></div><div class="geetest_success_correct"><div class="geetest_success_icon"></div></div></div><div class="geetest_success_radar_tip"><span class="geetest_success_radar_tip_content"></span></div><a class="geetest_success_logo" target="_blank" href="http://www.geetest.com/first_page"></a><div class="geetest_success_offline geetest_offline"></div></div></div><div class="geetest_slide_icon"></div></div><div class="geetest_wait"><span class="geetest_wait_dot geetest_dot_1"></span><span class="geetest_wait_dot geetest_dot_2"></span><span class="geetest_wait_dot geetest_dot_3"></span></div><div class="geetest_fullpage_click"><div class="geetest_fullpage_ghost"></div><div class="geetest_fullpage_click_wrap"><div class="geetest_fullpage_click_box"></div><div class="geetest_fullpage_pointer"><div class="geetest_fullpage_pointer_out"></div><div class="geetest_fullpage_pointer_in"></div></div></div></div><div class="geetest_goto" style="display: none;"><div class="geetest_goto_ghost"></div><div class="geetest_goto_wrap"><div class="geetest_goto_content"><div class="geetest_goto_content_tip"></div></div><div class="geetest_goto_cancel"></div><a class="geetest_goto_confirm"></a></div></div><div class="geetest_panel"><div class="geetest_panel_ghost"></div><div class="geetest_panel_box"><div class="geetest_panel_loading"><div class="geetest_panel_loading_icon"></div><div class="geetest_panel_loading_title"></div><div class="geetest_panel_loading_content"></div></div><div class="geetest_panel_success"><div class="geetest_panel_success_icon"></div><div class="geetest_panel_success_title"></div></div><div class="geetest_panel_error"><div class="geetest_panel_error_icon"></div><div class="geetest_panel_error_title"></div><div class="geetest_panel_error_content"></div></div><div class="geetest_panel_footer"><div class="geetest_panel_footer_logo"></div><div class="geetest_panel_footer_copyright"></div></div><div class="geetest_panel_next"></div></div></div></div></div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection

@section('script')
    <script src="http://static.geetest.com/static/tools/gt.js"></script>
    <script type="text/javascript">
        var handler = function (captchaObj) {
            captchaObj.appendTo('#captcha');
            captchaObj.onReady(function () {
                $("#wait").hide();
            });
            $('#btn').click(function () {
                var result = captchaObj.getValidate();
                if (!result) {
                    return alert('请完成验证');
                }
                $.ajax({
                    url: 'gt/validate-slide',
                    type: 'POST',
                    dataType: 'json',
                    data: {
                        username: $('#username2').val(),
                        password: $('#password2').val(),
                        geetest_challenge: result.geetest_challenge,
                        geetest_validate: result.geetest_validate,
                        geetest_seccode: result.geetest_seccode
                    },
                    success: function (data) {
                        if (data.status === 'success') {
                            alert('登录成功');
                        } else if (data.status === 'fail') {
                            alert('登录失败，请完成验证');
                            captchaObj.reset();
                        }
                    }
                });
            })
            // 更多接口说明请参见：http://docs.geetest.com/install/client/web-front/
            window.gt = captchaObj;
        };

        $.ajax({
            url: "gt/register-slide?t=" + (new Date()).getTime(), // 加随机数防止缓存
            type: "get",
            dataType: "json",
            success: function (data) {

                // 调用 initGeetest 进行初始化
                // 参数1：配置参数
                // 参数2：回调，回调的第一个参数验证码对象，之后可以使用它调用相应的接口
                initGeetest({
                    // 以下 4 个配置参数为必须，不能缺少
                    gt: data.gt,
                    challenge: data.challenge,
                    offline: !data.success, // 表示用户后台检测极验服务器是否宕机
                    new_captcha: data.new_captcha, // 用于宕机时表示是新验证码的宕机

                    product: "float", // 产品形式，包括：float，popup
                    width: "300px"
                    // 更多配置参数说明请参见：http://docs.geetest.com/install/client/web-front/
                }, handler);
            }
        });
    </script>
@endsection
