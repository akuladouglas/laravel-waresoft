@extends("layouts.main_template")

@section('content')
<!-- Widgets -->
            <div class="block-header">
                <h2> Orders </h2>
            </div>

            <legend></legend>
            
            <div class="row clearfix">
                <!-- Task Info -->
                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                    <div class="card">
                      
                      <div class="header">
                        <h2> Orders List </h2>
                      </div>
                      
                        <div class="body">
                            <div class="table-responsive">
                                <table id="ordersTable" class="table table-hover table-bordered dashboard-task-infos">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>Customer</th>
                                            <th>Amount</th>
                                            <th>Date Made</th>
                                            <th> </th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                       @foreach($orders as $order)
                                        <tr>
                                            <td> {{ $order->id }} </td>
                                            <td> {{ $order->number }} </td>
                                            <td> {{ $order->email }} </td>
                                            <td> {{ $order->shopify_created_at }} </td>
                                            <td> <a href="#" class="btn btn-xs btn-primary">View More</a> </td>
                                        </tr>
                                       @endforeach
                                    </tbody>
                                </table>
                              
                                <ul class="pagination-sm text-center">
                                  {{ $orders->links() }}
                                </ul>
                              
                            </div>
                        </div>
                      
                      
                      
                    </div>
                  
                </div>
                <!-- #END# Task Info -->
                
            </div>
@endsection