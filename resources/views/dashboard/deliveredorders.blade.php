@extends("layouts.main_template")

@section('content')
<!-- Widgets -->
            <div class="row clearfix">
                <!-- Task Info -->
                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                    <div class="card">
                      
                      <div class="header">
                        <h2> Delivered Orders </h2>
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
                                       
                                    </tbody>
                                </table>
                              
                                <ul class="pagination-sm text-center">
                                </ul>
                              
                            </div>
                        </div>
                      
                      
                      
                    </div>
                  
                </div>
                <!-- #END# Task Info -->
                
            </div>
@endsection