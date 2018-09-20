@extends("layouts.main_template_select")

@section('content')
<!-- Widgets -->
<div class="row clearfix">
  <!-- Task Info -->
  <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
    <div class="card">

      <div class="header">
        <h2> Update Delivery </h2>
      </div>

      <div class="body">
        
        <div class="">
          <div class="well">
            <table class="table">
              <tbody>
                <tr> 
                  <th> Customer Name </th>
                  <td> {{ $delivery->customer_firstname }} {{ $delivery->customer_lastname }} </td>
                </tr>
                <tr> 
                  <th> Order Reference </th>
                  <td> {{ $delivery->name }} </td>
                </tr>
              </tbody>
            </table>
          </div>
        </div>
        
        <div class="form-group">
          <label>
            Rider
          </label>
          <div class="form-line">
            <select class="form-control" name="rider_id">
              @foreach($riders as $rider)
               <option value="{{ $rider->rider_id }}"> {{ $rider->name }} </option>
              @endforeach
            </select>
          </div>
        </div>
        
        <div class="form-group">
          <label>
            Payment Method
          </label>
          <div class="form-line">
            <select class="form-control" name="rider_id">
              @foreach($payment_methods as $payment_method)
               <option value="{{ $payment_method->payment_method_id }}"> {{ $payment_method->name }} </option>
              @endforeach
            </select>
          </div>
        </div>
        
        <div class="form-group">
          
          <div class="form-line">
            
          </div>
        </div>
        
        <div class="form-group">
          <div class="form-line">
          </div>
        </div>
        
         <div class="form-group">
          <div class="form-line">
            <textarea class="form-control" placeholder="Comments">
              
            </textarea>
          </div>
        </div>
        
        
      </div>

    </div>

  </div>
  <!-- #END# Task Info -->

</div>
@endsection