@extends('auth.master')

@section('title', 'Registration')

@section('style')
@endsection

@section('content')
    <div class="card-content center-align">
        <form class="mb-15" id="form-register" action="">
            <div class="row">
                <div class="input-field col s12">
                    <input name="name" id="name" type="text" class="validate">
                    <label for="name">Full Name</label>
                </div>
                <div class="input-field col s12">
                    <input name="email" id="email" type="email" class="validate">
                    <label for="email">Email</label>
                </div>
                <div class="input-field col s12">
                    <input name="password" id="password" type="password" class="validate">
                    <label for="password">Password</label>
                </div>
                <div class="input-field col s12">
                    <input name="password_confirmation" id="password_confirmation" type="password" class="validate">
                    <label for="password_confirmation">Password Confirmation</label>
                </div>
                <div class="input-field col s12">
                    {{ csrf_field() }}
                    <button type="submit" class="btn waves-effect waves-light submit full orange darken-4">Register Now</button>
                </div>
            </div>
        </form>

        <a href="/auth/login">Already registered? Login here</a>
    </div>
@endsection

@section('script')
    <script>
        $(document).ready(function() {
            var auth_box = $('#auth-box');
            var loader = $('#main-preloader');

            $('button[type="submit"]').attr('disabled', false);

            $('#form-register').on('submit', function(e) {
                e.preventDefault();
                
                var form = $(this);
                var submit_button = form.find('button[type="submit"]');

                loader.removeClass('hidden');
                submit_button.attr('disabled', true);

                $.ajax({
                    url: '/auth/register',
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
                       