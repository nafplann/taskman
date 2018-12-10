<form action="/projects/invite" method="POST">
    <div class="modal-content">
        <h4>Invite Member</h4>
        <div class="row">
            <div class="input-field col s12">
                <input id="email" name="email" type="text" class="validate">
                <label for="email" class="">Email Address</label>
            </div>
        </div>
    </div>
    <div class="modal-footer">
        {{ csrf_field() }}
        <a href="#!" class="modal-close waves-effect waves-green btn-flat">Cancel</a>
        <button type="submit" class="waves-effect waves-green btn-flat">Submit</button>
    </div>
</form>