@extends('layouts.master')

@section('title', 'Dashboard')

@section('style')
@endsection

@section('content')
    <div class="container">
        <div class="row">
            <div class="col s12 mt-30">
                <h4>My Projects</h4>
                
                <div class="card p-0 mt-30 z-depth-3">
                    <div class="card-content p-0">
                        {{-- <a href="/auth/login">Login</a> <br>
                        <a href="/auth/register">Register</a> <br>
                        <a href="/auth/reset">Reset Password</a> <br>
                        <a href="/auth/logout">Logout</a> --}}   
                        <ul class="collapsible" id="project-list">
                        </ul>
                    </div>
                </div>
            </div>
        </div>

        {{-- <a id="menu" class="waves-effect waves-light btn btn-floating"><i class="material-icons">add</i></a> --}}

        <div class="fixed-action-btn">
            <a class="waves-effect waves-light btn-floating btn-large red" id="add-project">
                <i class="large material-icons">add</i>
            </a>
        </div>

        <!-- Tap Target Structure -->
        <div class="tap-target" data-target="add-project">
            <div class="tap-target-content">
                <h5>Action</h5>
                <p>You can add new project from here</p>
            </div>
        </div>
    </div>
@endsection

@section('script')
    <script> 
        $(document).ready(function() {
            Dashboard.index();
        });
    </script>
@endsection