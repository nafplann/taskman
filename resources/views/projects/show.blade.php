@extends('layouts.master')

@section('title', 'Project Details')

@section('style')
    <style>
        #project-progress {
            height: 15px;
        }
    </style>
@endsection

@section('content')
    <div class="container mt-30" id="project-container" data-id="{{ $project->id }}">
        <div class="row m-0">
            <div class="col s6">
                <h4>{{ $project->name }}</h4>
                <h5>{{ $project->description }}</h5>
                {{-- <div class="progress" id="project-progress">
                    <div class="determinate" style="width: 70%"></div>
                </div> --}}
            </div>
            <div class="col s6 right-align">
                <h5>Online Users</h5>
                <img src="//www.w3schools.com/howto/img_avatar.png" alt="" class="circle responsive-img valign tooltipped" data-position="top" data-tooltip="John" style="width: 30px;">
                <img src="//www.w3schools.com/howto/img_avatar2.png" alt="" class="circle responsive-img valign tooltipped" data-position="top" data-tooltip="Clara" style="width: 30px;">
                <img src="//www.w3schools.com/w3images/avatar6.png" alt="" class="circle responsive-img valign tooltipped" data-position="top" data-tooltip="Smith" style="width: 30px;">
            </div>
        </div>
        <div class="row">
            <div class="col m3 s12" id="todo-container">
                <div class="card p-0 mt-30 z-depth-3">
                    <div class="progress hidden">
                        <div class="indeterminate"></div>
                    </div>
                    <div class="card-content">
                        <span class="card-title">To Do</span>
                        <div class="row">
                            <form action="/tasks/create" method="POST" class="task-form" enctype="multipart/form-data">
                                <div class="input-field col s12">
                                    <input id="task_todo" name="content" type="text" class="validate">
                                    <label for="task_todo" class="inactive">Add a Task</label>
                                </div>
                                <input type="hidden" name="type" value="todo">
                                {{ csrf_field() }}
                            </form>
                        </div>
                        <div class="dd nestable">
                            <ol class="dd-list">
                                {{-- <li class="dd-item dd3-item" data-id="16">
                                    <div class="card-panel dd-handle">
                                        <span>I am a very simple card. I am good at containing small bits of information.</span>
                                        <img src="//materializecss.com/images/yuna.jpg" alt="" class="circle responsive-img valign tooltipped" data-position="top" data-tooltip="Assigned to Ms. Fulanah" style="width: 30px; float: right;">
                                    </div>
                                </li> --}}
                            </ol>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col m3 s12" id="doing-container">
                <div class="card p-0 mt-30 z-depth-3">
                    <div class="progress hidden">
                        <div class="indeterminate"></div>
                    </div>
                    <div class="card-content">
                        <span class="card-title">Doing</span>
                        <div class="row">
                            <form action="/tasks/create" method="POST" class="task-form" enctype="multipart/form-data">
                                <div class="input-field col s12">
                                    <input id="task_doing" name="content" type="text" class="validate">
                                    <label for="task_doing" class="inactive">Add a Task</label>
                                </div>
                                <input type="hidden" name="type" value="doing">
                                {{ csrf_field() }}
                            </form>
                        </div>
                        <div class="dd nestable">
                            <ol class="dd-list">
                            </ol>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col m3 s12" id="testing-container">
                <div class="card p-0 mt-30 z-depth-3">
                    <div class="progress hidden">
                        <div class="indeterminate"></div>
                    </div>
                    <div class="card-content">
                        <span class="card-title">Testing</span>
                        <div class="row">
                            <form action="/tasks/create" method="POST" class="task-form" enctype="multipart/form-data">
                                <div class="input-field col s12">
                                    <input id="task_testing" name="content" type="text" class="validate">
                                    <label for="task_testing" class="inactive">Add a Task</label>
                                </div>
                                <input type="hidden" name="type" value="testing">
                                {{ csrf_field() }}
                            </form>
                        </div>
                        <div class="dd nestable">
                            <ol class="dd-list">
                            </ol>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col m3 s12" id="done-container">
                <div class="card p-0 mt-30 z-depth-3">
                    <div class="progress hidden">
                        <div class="indeterminate"></div>
                    </div>
                    <div class="card-content">
                        <span class="card-title">Done</span>
                        <div class="row">
                            <form action="/tasks/create" method="POST" class="task-form" enctype="multipart/form-data">
                                <div class="input-field col s12">
                                    <input id="task_done" name="content" type="text" class="validate">
                                    <label for="task_done" class="inactive">Add a Task</label>
                                </div>
                                <input type="hidden" name="type" value="done">
                                {{ csrf_field() }}
                            </form>
                        </div>
                        <div class="dd nestable">
                            <ol class="dd-list">
                            </ol>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="fixed-action-btn">
            <a class="btn-floating btn-large red">
                <i class="large material-icons">more_vert</i>
            </a>
            <ul>
                <li>
                    <a class="btn-floating green tooltipped" data-position="left" data-tooltip="Project History">
                        <i class="material-icons">history</i>
                    </a>
                </li>
                <li>
                    <a id="add-member" class="btn-floating blue tooltipped" data-position="left" data-tooltip="Invite Members">
                        <i class="material-icons">group_add</i>
                    </a>
                </li>
            </ul>
        </div>
    </div>
@endsection

@section('script')
    <script> 
        $(document).ready(function() {
            Project.show();
        });
    </script>
@endsection