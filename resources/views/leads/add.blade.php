@extends("layouts.main_template_select")

@section('content')
<!-- Widgets -->
<div class="row clearfix">
  <!-- Task Info -->
  <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
    <div class="card">

      <div class="header">
        <h2> Add New Lead </h2>
      </div>

      <form action="{{ url("leads/process-add") }}">
      
      <div class="body">
        
        <div class="form-group">
          <div class="form-line">
            <input type="text" name="client_name" class="form-control" placeholder="Customer Name" />
          </div>
        </div>
        
        <div class="form-group">
          <div class="form-line">
            <input type="number" name="client_phone" class="form-control" placeholder="Customer Phone" />
          </div>
        </div>
        
        <div class="form-group">
          <div class="form-line">
            <input type="text" name="client_facebook_name" class="form-control" placeholder="Customer Facebook Name" />
          </div>
        </div>
        
        <div class="form-group">
          <div class="form-line">
            <select class="form-control" name="interested_in">
              @foreach($interested_reasons as $reasons)
              <option value="{{ $reasons }}"> {{ $reasons }} </option>
              @endforeach
            </select>
          </div>
        </div>
        
        <div class="form-group">
          <div class="form-line">
            <textarea class="form-control" placeholder="Comments"></textarea>
          </div>
        </div>
        
        <button type="submit" class="btn btn-primary"> Submit </button>
        
      </div>
      
      </form>
      
    </div>

  </div>
  <!-- #END# Task Info -->

</div>
@endsection