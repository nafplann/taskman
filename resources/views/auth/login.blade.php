@extends('auth.master')

@section('title', 'Login')

@section('style')
@endsection

@section('content')
    <div class="card-content center-align">
        <form class="mb-15" id="form-login" method="POST">
            <div class="row">
                <div class="input-field col s12">
                    <input name="email" id="email" type="text" class="validate">
                    <label for="email">Email</label>
                </div>
                <div class="input-field col s12">
                    <input name="password" id="password" type="password" class="validate">
                    <label for="password">Password</label>
                </div>
                <div class="col s12 left-align">
                    <label>
                        <input type="checkbox" class="filled-in" name="remember_me" />
                        <span>Remember me</span>
                    </label>
                </div>
                <div class="input-field col s12">
                    {{ csrf_field() }}
                    <button type="submit" class="btn waves-effect waves-light submit full orange darken-4" disabled>Login</button>
                </div>
            </div>
        </form>

        <a href="/auth/register">Didn't have an account?</a> <br>
        <a href="/auth/reset">Forgot password?</a>
    </div>
@endsection

@section('script')
    <script>
        $(document).ready(function() {
            var auth_box = $('#auth-box');
            var loader = $('#main-preloader');

            $('button[type="submit"]').attr('disabled', false);

            $('#form-login').on('submit', function(e) {
                e.preventDefault();
                
                var form = $(this);
                var submit_button = form.find('button[type="submit"]');

                loader.removeClass('hidden');
                submit_button.attr('disabled', true);

                $.ajax({
                    url: '/auth/login',
                    type: 'POST',
                    data: form.serialize()
                })
                .always(function() {
                    loader.addClass('hidden');
                    submit_button.attr('disabled', false);
                })
                .done(function(response) {
                    if (! response.status) {
                        auth_box.addClass('animated shake');
                        
                        setTimeout(function() {
                            auth_box.removeClass('animated shake');
                        }, 1000);
                        
                        return;
                    }
    
                    window.location.href = response.redirectTo;
                })
            });
        });
    </script>
@endsection