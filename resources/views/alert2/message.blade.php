@if(Session::has('insert'))
<div class="alert alert-success alert-dismissible">
    <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
    <strong>{{Session::get('insert')}}</strong>
</div>

@endif
@if(Session::has('status'))
<div class="alert alert-success alert-dismissible">
    <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
    <strong>{{Session::get('status')}}</strong>
</div>

@endif
@if(Session::has('update'))
<div class="alert alert-primary alert-dismissible">
    <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
    <strong>{{Session::get('update')}}</strong>
</div>
@endif
@if(Session::has('delete'))
<div class="alert alert-danger alert-dismissible">
    <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
    <strong>{{Session::get('delete')}}</strong>
</div>
@endif
