<aside class="main-sidebar">
    <!-- sidebar: style can be found in sidebar.less -->
    <section class="sidebar">
      <!-- Sidebar user panel -->
      <div class="user-panel">
        <div class="pull-left image">
          <img src="https://fakeimg.pl/160x160/" class="img-circle" alt="User Image">
        </div>
        <div class="pull-left info">
          <p>{{ auth()->user()->name }}</p>
          <a href="#"><i class="fa fa-circle text-success"></i> Online</a>
        </div>
      </div>
     
      <!-- sidebar menu: : style can be found in sidebar.less -->
      <ul class="sidebar-menu" data-widget="tree">
        <li class="header">MAIN NAVIGATION</li>
        
        
        <li>
          <a href="{{ route('dashboard') }}">
            <i class="fa fa-dashboard"></i> <span>Dashboard</span>
          </a>
        </li>
        

        <!-- <li class="treeview">
          <a href="#">
            <i class="fa fa-building"></i>
            <span>Major Cities</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>
          <ul class="treeview-menu">
            <li><a href="{{ route('major-cities.index') }}"><i class="fa fa-circle-o"></i> Citites</a></li>
            <li><a href=""><i class="fa fa-circle-o"></i> Add City</a></li>
          </ul>
        </li> -->
        
        <!-- <li class="treeview">
          <a href="#">
            <i class="fa fa-users"></i>
            <span>Employer</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>
          <ul class="treeview-menu">
            <li><a href="{{ route('health-care.index') }}"><i class="fa fa-circle-o"></i> Employers</a></li>
            <li><a href=""><i class="fa fa-circle-o"></i> Add Employer</a></li>
          </ul>
        </li> -->
        
        <li>
          <a href="{{ route('countries.index') }}">
            <i class="fa fa-globe"></i> <span>Manage Countries</span>
          </a>
        </li>
        <li>
          <a href="{{ route('healthcaresettings.index') }}">
            <i class="fa fa-hospital-o"></i> <span>Healthcare Settings</span>
          </a>
        </li>
        <li>
          <a href="{{ route('employers.index') }}">
            <i class="fa fa-users"></i> <span>Manage Employers</span>
          </a>
        </li>
        <li>
          <a href="{{ route('skills.index') }}">
            <i class="fa fa-user"></i> <span>Skills</span>
          </a>
        </li>
        <li>
          <a href="{{ route('inquiries.index') }}">
            <i class="fa fa-paper-plane"></i> <span>Inquiries</span>
          </a>
        </li>
        <li>
          <a href="{{ route('users.index') }}">
            <i class="fa fa-user"></i> <span>Users</span>
          </a>
        </li>

        <li class="treeview">
          <a href="#">
            <i class="fa fa-users"></i>
            <span>Preferences</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>
          <ul class="treeview-menu">
            <li><a href="{{ route('app-groups.index') }}"><i class="fa fa-circle-o"></i> App Groups</a></li>
          </ul>
        </li> 

      </ul>
    </section>
    <!-- /.sidebar -->
  </aside>