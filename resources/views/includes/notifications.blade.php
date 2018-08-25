@if(session('success'))
<div class="clearfix"></div>
<div class="col-md-12">
  <div class="alert alert-success alert-dismissible">
    <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
    <strong> Success! </strong>
    <p> {{ session('success') }} </p>
  </div>
</div>
<div class="clearfix"></div>
@endif