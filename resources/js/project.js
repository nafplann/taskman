const Project = {
    show() {
        $('.fixed-action-btn').floatingActionButton();
        $('.tooltipped').tooltip();
        $('.nestable').nestable({
            maxDepth: 1,
            group: 1
        });

        $('#add-member').click(function(e) {
            e.preventDefault();
            Project.invite();
        });

        $('.task-form').on('submit', function(e) {
            e.preventDefault();

            let form = $(this);
            let url = form.attr('action');
            let method = form.attr('method');
            let type = form.find('[name="type"]').val();
            let formData = new FormData(form[0]);
            formData.append('id', $('#project-container').data('id'));

            App.ajaxFile(url, method, 'application/json', formData)
                .then(results => {
                    form[0].reset();
                    Project.fetchTasks(type);
                });
        });

        $(document).on('click', '.card-task', function() {
            alert('oi');
        });

        Project.fetchTasks('todo');
        Project.fetchTasks('doing');
        Project.fetchTasks('testing');
        Project.fetchTasks('done');
    },
    fetchProject() {
        let projectList = $('#project-list');
        App.loading(true);

        App.ajax('/projects', 'GET', 'application/json', null)
            .then(results => {
                projectList.empty();

                results.forEach(project => {
                    projectList.append(`
                        <li>
                            <div class="collapsible-header">${project.name}</div>
                            <div class="collapsible-body">
                                <div class="row m-0">
                                    <div class="col s6">
                                        <span>${project.description}</span> <br>
                                    </div>
                                    <div class="col s6 right-align">
                                        <a href="/projects/show/${project.id}" class="waves-effect waves-light btn-small">View</a>
                                        <a href="#" class="waves-effect waves-light btn-small">Delete</a>
                                    </div>
                                </div>
                            </div>
                        </li>
                    `);
                });

                if (! results.length) {
                    projectList.append(`
                        <li>
                            <div class="collapsible-header">You don't have any project yet.</div>
                        </li>
                    `);
                }
                
                App.loading(false);
            });
    },
    fetchTasks(type) {
        let id = $('#project-container').data('id');
        let container = $(`#${type}-container`);
        let lists = container.find('.dd.nestable');
        let loader = container.find('.progress');
        
        loader.removeClass('hidden');

        App.ajax('/tasks/get', 'GET', 'application/json', { id, type })
            .then(results => {
                lists.empty();

                if (! results.length) {
                    lists.append('<div class="dd-empty"></div>');
                } else {
                    lists.append('<ol class="dd-list"></ol>');
                }

                results.forEach(task => {
                    lists.find('ol').append(`
                        <li class="dd-item dd3-item card-task" data-id="${task.id}">
                            <div class="card-panel dd-handle">
                                <span>${task.content}</span>
                                <img src="//materializecss.com/images/yuna.jpg" alt="" class="circle responsive-img valign tooltipped" data-position="top" data-tooltip="Assigned to Ms. Fulanah" style="width: 30px; float: right;">
                            </div>
                        </li>
                    `);
                });

                loader.addClass('hidden');
            });
    },
    invite() {
        let modal = App.loadModal();
        let body = modal.find('.modal-body');

        App.ajax('/projects/invite', 'GET', 'text/html', null)
            .then(results => {
                modal.html(results);
            });

        modal.on('submit', 'form', function(e) {
            e.preventDefault();

            let form = $(this);
            let url = form.attr('action');
            let method = form.attr('method');
            let formData = new FormData(form[0]);
            formData.append('id', $('#project-container').data('id'));

            App.disableSubmit(form);
            App.ajaxFile(url, method, 'json', formData)
                .fail(xhr => {
                    App.formFailed(form, `Code ${xhr.status}: ${xhr.statusText}`);
                })
                .then(results => {
                    if (! results.status) {
                        App.formFailed(form, results.message);
                        return;
                    }
                    
                    App.alert('Success', results.message, 'success');
                    modal.modal('close');
                });
        });
    },
}

export default Project;