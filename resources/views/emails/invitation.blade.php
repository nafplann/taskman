<h1>Welcome to Taskman</h1>
<p>{{ $project->owner->name }} has invite you to join their project.</p>
<p><a href="{{ env('APP_URL') }}/projects/join/{{ $project->id }}">Click Here</a> to accept.</p>