<div class="row">
  <legend></legend>
</div>

<div class="menu">
  <ul class="list">
    <li class="header"> Navigation </li>

    <li class="<?php echo Request::segment(1) == "home" ? "active" : ""; ?>" >
      <a href="{{ url('home') }}">
        <i class="material-icons">home</i>
        <span> Dashboard </span>
      </a>
    </li>

    <li class="<?php echo Request::segment(1) == "reward" ? "active" : ""; ?>" >
      <a href="#" class="menu-toggle">
        <i class="material-icons">view_comfy</i>
        <span> Loyalty & Rewards </span>
      </a>
      <ul class="ml-menu">
        <li>
          <a class="" href="{{ url('reward/customers') }}">
            <i class="material-icons col-light-green">group</i>
            <span>Rewards Customers</span>
          </a>
        </li>
        <li>
          <a href="{{ url('reward/activitys') }}">
            <i class="material-icons col-light-green">view_headline</i>
            <span>Rewards Activities</span>
          </a>
        </li>
        <li>
          <a href="{{ url('reward/sms') }}">
            <i class="material-icons col-light-green">notifications_active</i>
            <span>Rewards Sms Outbox</span>
          </a>
        </li>
      </ul>
    </li>

    <li class="<?php echo Request::segment(1) == "order" ? "active" : ""; ?>" >
      <a href="{{ url('order') }}">
        <i class="material-icons">view_headline</i>
        <span>Orders</span>
      </a>
    </li>

    <li class="hidden <?php echo Request::segment(1) == "delivery" ? "active" : ""; ?>" >
      <a href="{{ url('delivery') }}">
        <i class="material-icons">view_headline</i>
        <span>Deliveries</span>
      </a>
    </li>
    <li class="hidden <?php echo Request::segment(1) == "product" ? "active" : ""; ?>" >
      <a href="{{ url('product') }}">
        <i class="material-icons">apps</i>
        <span>Products</span>
      </a>
    </li>

    <li class="hidden <?php echo Request::segment(1) == "combination" ? "active" : ""; ?>" >
      <a href="{{ url('combination') }}">
        <i class="material-icons">format_align_justify</i>
        <span>Combinations</span>
      </a>
    </li>

    <li class="hidden <?php echo Request::segment(1) == "stock" ? "active" : ""; ?>" >
      <a href="{{ url('stock') }}">
        <i class="material-icons">list</i>
        <span>Stock</span>
      </a>
    </li>

    <li class="hidden <?php echo Request::segment(1) == "report" ? "active" : ""; ?>" >
      <a href="#" class="menu-toggle">
        <i class="material-icons">vertical_split</i>
        <span>Reports</span>
      </a>
      <ul class="ml-menu">
        <li>
          <a href="{{ url('report') }}">
            <i class="material-icons col-light-green">donut_large</i>
            <span>Report 1</span>
          </a>
        </li>
        <li>
          <a href="{{ url('report') }}">
            <i class="material-icons col-light-green">donut_large</i>
            <span>Report 2</span>
          </a>
        </li>
        <li>
          <a href="{{ url('report') }}">
            <i class="material-icons col-light-green">donut_large</i>
            <span>Report 3</span>
          </a>
        </li>
      </ul>
    </li>
    <li> <a> &nbsp; </a> </li>
    <li> <a> &nbsp; </a> </li>
  </ul>
</div>

<div class="legal">
  <div class="copyright">
    &copy; <?php echo date("Y"); ?> <a href="//beautyclick.co.ke">Africanhair Ltd.</a>
  </div>
  <div class="version">
    <b> Version: </b> 1.0.0
  </div>
</div>