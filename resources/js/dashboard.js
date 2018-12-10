const Dashboard = {
    index() {
        $(document).on('click', '.action-delete', function(e) {
            e.preventDefault();
            let id = $(this).data('id');
            Dashboard.delete(id);
        });

        $('.collapsible').collapsible();
        $('.fixed-action-btn').floatingActionButton();
        $('.tap-target').tapTarget();
        $('.tap-target').tapTarget('open');

        $('#add-project').click(function(e) {
            e.preventDefault();
            Dashboard.createProject();
        });

        Dashboard.fetchProject();
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
    createProject() {
        let modal = App.loadModal();
        let body = modal.find('.modal-body');

        App.ajax('/projects/create', 'GET', 'text/html', null)
            .then(results => {
                modal.html(results);
                // App.datepicker('.datepicker');
            });

        modal.on('submit', 'form', function(e) {
            e.preventDefault();

            let form = $(this);
            let url = form.attr('action');
            let method = form.attr('method');
            let formData = new FormData(form[0]);

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
                    Dashboard.fetchProject();
                });
        });
    },
}

export default Dashboard;