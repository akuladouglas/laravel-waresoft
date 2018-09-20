@extends("layouts.main_template_select")

@section('content')

<div class="row clearfix">
  <!-- Task Info -->
  <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
    <div class="card">

      @include('includes.notifications')

      <div class="header">
        <h2> Deliveries List  </h2>
      </div>

      <div class="body">
        <div class="table-responsive">
          <table class="table table-hover table-bordered dashboard-task-infos">
            <thead>
              <tr>
                <th>Date Made </th>
                <th>Customer </th>
                <th>Order </th>
                <th>Phone </th>
                <th>Price </th>
                <th>Fin. Status </th>
                <th>Rider </th>
                <th>Delivered</th>
                <th>Payment</th>
                <th></th>
              </tr>
            </thead>
            <tbody>
              @foreach($deliveries as $order)
              <tr>
                <td> {{ date("y/m/d", strtotime($order->shopify_created_at)) }} </td>
                <td> {{ $order->customer_firstname }} {{ $order->customer_lastname }} </td>
                <td> <a href="{{url("order/view/{$order->id}")}}"> {{ $order->name }} </a> </td>
                <td> {{ $order->customer_phone }} </td>
                <td> {{ number_format($order->total_price) }} </td>
                <td> {{ $order->financial_status }} </td>
                <td> 
                  <!--modal button-->
                  <button type="button" class="btn btn-primary btn-xs" data-toggle="modal" data-target="#riderModal">
                    Assign Rider
                  </button>
                  <!--end modal button-->
                  
                  <!--modal-->
                  
                  <!-- Modal -->
                  
                    <div class="modal fade" id="riderModal" tabindex="-1" role="dialog" aria-labelledby="riderModalLabel" aria-hidden="true">
                      <div class="modal-dialog" role="document">
                        <div class="modal-content">
                          <div class="modal-header">
                            <h5 class="modal-title" id="riderModalLabel"> Assign Rider to this delivery </h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                              <span aria-hidden="true">&times;</span>
                            </button>
                          </div>
                          
                          <form action="{{ url("delivery/assign-rider") }}">
                            
                          <div class="modal-body">
                            @csrf
                                
                            <input name="order_id" type="hidden" value="{{ $order->id }}">
                                              
                            <select name="rider_id" id="rider_id" class="form-control">
                              <option value=""> -- select rider below -- </option>
                              @foreach($riders as $rider)
                              <option value="{{ $rider->rider_id }}"> {{ $rider->name }} ( {{ $rider->phone }} ) </option>
                              @endforeach
                            </select>
                            
                          </div>
                          <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-primary"> Save Rider </button>
                          </div>
                            
                          </form>
                          
                        </div>
                      </div>
                    </div>
                  <!--end modal-->
                </td>
                
                <td> 
                   <a class="btn btn-primary btn-xs" href="{{ url("delivery/mark-delivered/".$order->id) }}"> Mark Delivered </a>
                </td>
                
                <td> 
                  <!--modal button-->
                  <button type="button" class="btn btn-primary btn-xs" data-toggle="modal" data-target="#deliveryModal">
                    Update Payment
                  </button>
                  <!--end modal button-->
                  
                  <!--modal-->
                  
                  <!-- Modal -->
                  
                    <div class="modal fade" id="deliveryModal" tabindex="-1" role="dialog" aria-labelledby="deliveryModalLabel" aria-hidden="true">
                      <div class="modal-dialog" role="document">
                        <div class="modal-content">
                          <div class="modal-header">
                            <h5 class="modal-title" id="deliveryModalLabel"> Mark delivered and update payment status </h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                              <span aria-hidden="true">&times;</span>
                            </button>
                          </div>
                          
                          <form action="{{ url("delivery/mark-paid") }}">
                            
                          <div class="modal-body">
                            @csrf
                                
                            <input name="order_id" type="hidden" value="{{ $order->id }}">
                                              
                            <select name="rider_id" id="rider_id" class="form-control">
                              <option value=""> -- select payment method below -- </option>
                              @foreach($payment_methods as $payment_method)
                              <option value="{{ $payment_method->payment_method_id }}"> {{ $payment_method->name }} </option>
                              @endforeach
                            </select>
                            
                          </div>
                          <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-primary"> Save Payment method </button>
                          </div>
                            
                          </form>
                          
                        </div>
                      </div>
                    </div>
                  <!--end modal-->
                </td>
                
                <td> 
                 <a href="{{url("delivery/edit/{$order->id}")}}" class="btn btn-xs btn-default"> Edit </a> 
                </td>
              </tr>
              @endforeach
            </tbody>
          </table>
        </div>
      </div>
    </div>

  </div>
  <!-- #END# Task Info -->

</div>
@endsection
