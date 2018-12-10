<form action="/projects/create" method="POST">
    <div class="modal-content">
        <h4>Create New Project</h4>
        <div class="row">
            <div class="input-field col s12">
                <input id="name" name="name" type="text" class="validate">
                <label for="name" class="">Project Name</label>
            </div>
        </div>
        <div class="row">
            <div class="input-field col s12">
                <input id="description" name="description" type="text" class="validate">
                <label for="description" class="">Description</label>
            </div>
        </div>
    </div>
    <div class="modal-footer">
        {{ csrf_field() }}
        <a href="#!" class="modal-close waves-effect waves-green btn-flat">Cancel</a>
        <button type="submit" class="waves-effect waves-green btn-flat">Submit</button>
    </div>
</form>