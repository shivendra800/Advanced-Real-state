<nav class="sidebar">
    <div class="sidebar-header">
        <a href="#" class="sidebar-brand">
            Shivendra<span>Dev</span>
        </a>
        <div class="sidebar-toggler not-active">
            <span></span>
            <span></span>
            <span></span>
        </div>
    </div>
    <div class="sidebar-body">
        <ul class="nav">
            <li class="nav-item nav-category">Main</li>
            <li class="nav-item">
                <a href="dashboard.html" class="nav-link">
                    <i class="link-icon" data-feather="box"></i>
                    <span class="link-title">Dashboard</span>
                </a>
            </li>
            <li class="nav-item nav-category">RealEstate</li>
            @if(Auth::user()->can('type.menu'))
            <li class="nav-item">
                <a class="nav-link" data-bs-toggle="collapse" href="#emails" role="button" aria-expanded="false" aria-controls="emails">
                    <i class="link-icon" data-feather="mail"></i>
                    <span class="link-title">Property Type</span>
                    <i class="link-arrow" data-feather="chevron-down"></i>
                </a>
                <div class="collapse" id="emails">
                    <ul class="nav sub-menu">
                      @if(Auth::user()->can('all.type'))
                        <li class="nav-item">
                            <a href="{{ url('all-Proptype') }}" class="nav-link">All Type</a>
                        </li>
                        @endif
                        @if(Auth::user()->can('add.type'))
                        <li class="nav-item">
                            <a href="{{ url('add-type') }}" class="nav-link">Add Type</a>
                        </li>
                        @endif
                    </ul>
                </div>
            </li>
            @endif

            
  {{-- @if(Auth::user()->can('state.menu'))
  <li class="nav-item">
    <a class="nav-link" data-bs-toggle="collapse" href="#state" role="button" aria-expanded="false" aria-controls="emails">
      <i class="link-icon" data-feather="mail"></i>
      <span class="link-title">Property State </span>
      <i class="link-arrow" data-feather="chevron-down"></i>
    </a>
    <div class="collapse" id="state">
      <ul class="nav sub-menu">
         @if(Auth::user()->can('state.all'))
        <li class="nav-item">
          <a href="{{ route('all.state') }}" class="nav-link">All State</a>
        </li>
        @endif
         @if(Auth::user()->can('state.add'))
        <li class="nav-item">
          <a href="{{ route('add.state') }}" class="nav-link">Add State</a>
        </li>
        @endif
      </ul>
    </div>
  </li>
@endif --}}


            <li class="nav-item">
                <a class="nav-link" data-bs-toggle="collapse" href="#amenitie" role="button" aria-expanded="false" aria-controls="emails">
                  <i class="link-icon" data-feather="mail"></i>
                  <span class="link-title">Amenitie  </span>
                  <i class="link-arrow" data-feather="chevron-down"></i>
                </a>
                <div class="collapse" id="amenitie">
                  <ul class="nav sub-menu">
                    <li class="nav-item">
                      <a href="{{ url('all-amenitie') }}" class="nav-link">All Amenitie</a>
                    </li>
                    <li class="nav-item">
                      <a href="{{ url('add-amenitie') }}" class="nav-link">Add Amenitie</a>
                    </li>
                    
                  </ul>
                </div>
              </li>

              <li class="nav-item">
                <a class="nav-link" data-bs-toggle="collapse" href="#property" role="button" aria-expanded="false" aria-controls="emails">
                  <i class="link-icon" data-feather="mail"></i>
                  <span class="link-title">Property  </span>
                  <i class="link-arrow" data-feather="chevron-down"></i>
                </a>
                <div class="collapse" id="property">
                  <ul class="nav sub-menu">
                    <li class="nav-item">
                      <a href="{{ route('all.property') }}" class="nav-link">All Property</a>
                    </li>
                    <li class="nav-item">
                      <a href="{{ route('add.property') }}" class="nav-link">Add Property</a>
                    </li>
                    
                  </ul>
                </div>
              </li>

             

              <li class="nav-item nav-category">User All Function</li>
          

              <li class="nav-item">
                <a class="nav-link" data-bs-toggle="collapse" href="#uiComponents" role="button" aria-expanded="false" aria-controls="uiComponents">
                  <i class="link-icon" data-feather="feather"></i>
                  <span class="link-title">Manage Agent </span>
                  <i class="link-arrow" data-feather="chevron-down"></i>
                </a>
                <div class="collapse" id="uiComponents">
                  <ul class="nav sub-menu">
                    <li class="nav-item">
                      <a href="{{ route('all.agent') }}" class="nav-link">All Agent </a>
                    </li>
                    <li class="nav-item">
                      <a href="pages/ui-components/alerts.html" class="nav-link">Add Agent</a>
                    </li>
                    
                  </ul>
                </div>
              </li>

              <li class="nav-item">
                <a href="{{ route('admin.package.history') }}" class="nav-link">
                  <i class="link-icon" data-feather="calendar"></i>
                  <span class="link-title">Package History</span>
                </a>
              </li>

              <li class="nav-item">
                <a href="{{ route('admin.property.message') }}" class="nav-link">
                  <i class="link-icon" data-feather="calendar"></i>
                  <span class="link-title">Property Message </span>
                </a>
              </li>
    
              <li class="nav-item">
                <a href="{{ route('smtp.setting') }}" class="nav-link">
                  <i class="link-icon" data-feather="calendar"></i>
                  <span class="link-title">SMTP Setting </span>
                </a>
              </li>
    
              <li class="nav-item">
                <a href="{{ route('site.setting') }}" class="nav-link">
                  <i class="link-icon" data-feather="calendar"></i>
                  <span class="link-title">Site Setting </span>
                </a>
              </li>
              
          
            <li class="nav-item nav-category">Role & Permission</li>
          <li class="nav-item">
            <a class="nav-link" data-bs-toggle="collapse" href="#advancedUI" role="button" aria-expanded="false" aria-controls="advancedUI">
              <i class="link-icon" data-feather="anchor"></i>
              <span class="link-title">Role & Permission</span>
              <i class="link-arrow" data-feather="chevron-down"></i>
            </a>
            <div class="collapse" id="advancedUI">
              <ul class="nav sub-menu">
                <li class="nav-item">
                  <a href="{{ route('all.permission') }}" class="nav-link">All Permission</a>
                </li>
                <li class="nav-item">
                  <a href="{{ route('all.roles') }}" class="nav-link">All Roles </a>
                </li>

                 <li class="nav-item">
                  <a href="{{ route('add.roles.permission') }}" class="nav-link">Role in Permission </a>
                </li>

                <li class="nav-item">
                  <a href="{{ route('all.roles.permission') }}" class="nav-link">All Role in Permission </a>
                </li>
                
              </ul>
            </div>
          </li>

          <li class="nav-item">
            <a class="nav-link" data-bs-toggle="collapse" href="#admin" role="button" aria-expanded="false" aria-controls="admin">
              <i class="link-icon" data-feather="anchor"></i>
              <span class="link-title">Manage Admin User</span>
              <i class="link-arrow" data-feather="chevron-down"></i>
            </a>
            <div class="collapse" id="admin">
              <ul class="nav sub-menu">
                <li class="nav-item">
                  <a href="{{ route('all.admin') }}" class="nav-link">All Admin</a>
                </li>
                <li class="nav-item">
                  <a href="{{ route('add.admin') }}" class="nav-link">Add Admin </a>
                </li> 
              </ul>
            </div>
          </li>

        </ul>
    </div>
 </nav>
<!-- partial -->

