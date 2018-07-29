@extends("layouts.main_template")

@section('content')
<!-- Widgets -->
            <div class="block-header">
                <h2> Rewards Customers </h2>
            </div>

            <legend></legend>
            
            <div class="row clearfix">
                <!-- Task Info -->
                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                    <div class="card">
                      
                      <div class="header">
                        <h2> Rewards Customers List </h2>
                      </div>
                      
                        <div class="body">
                            <div class="table-responsive">
                                <table id="ordersTable" class="table table-bordered table-striped table-hover dataTable js-exportable">
                                    <thead>
                                        <tr>
                                            <th>Name</th>
                                            <th>Created At</th>
                                            <th>Total Spent</th>
                                            <th>Total Orders</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                          @foreach($customers as $customer)
                                           <tr>
                                               <td> {{ $customer->firstName }}  {{ $customer->lastName }} </td>
                                               <td> {{ date("Y-m-d", strtotime($customer->createdAt)) }} </td>
                                               <td> {{ $customer->totalSpent }} </td>
                                               <td> {{ $customer->totalOrders }} </td>
                                           </tr>
                                          @endforeach
                                    </tbody>
                                </table>
                              
                                <ul class="pagination-sm text-center">
                                    {{ $customers->links() }}
                                </ul>
                              
                            </div>
                        </div>
                      
                      
                      
                    </div>
                  
                </div>
                <!-- #END# Task Info -->
                
            </div>
@endsection