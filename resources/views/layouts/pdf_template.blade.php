<html>
  <head>
    <link href="{{ asset('css/pdf_print.css') }}" rel="stylesheet">
    
    <style>
      table th {
        font-size: 14px;
      }
      .pdf_title {
        font-size: 16px;
        font-weight: bold;
        padding-bottom: 0px;
        margin-bottom: 0px;
      }
    </style>
    
  </head>
  <body>
    <div class="container-fluid">
      @yield('content')
    </div>
  </body>
</html>