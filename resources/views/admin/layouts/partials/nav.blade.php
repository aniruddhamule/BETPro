<nav class="s7__nav {{$general->admin_nav}}">
  <button type="button" class="sidebar-collapse-btn">
    <span class="line"></span>
  </button>
  <button type="button" class="sidebar-open-btn">
    <i data-feather="align-justify"></i>
  </button>
  <form class="s7__nav-search-form d-none d-md-block" onsubmit="return false;">
    <input type="search" name="navbar_search" id="navbar_search" autocomplete="off" aria-label="Search" placeholder="Search...">
    <button type="submit"><i data-feather="search"></i></button>

    <div id="navbar_search_area">
        <ul class="navbar_search_result"></ul>
    </div>
  </form>
  
  <ul class="s7__nav-right">
    <li>
      <label id="switch" class="switch">
        <input type="checkbox" onchange="toggleTheme()" id="slider">
        <span class="switch-icons">
          <i data-feather="moon"></i>
          <i data-feather="sun"></i>
        </span>
      </label>
    </li>
    <li class="nav-search-btn">
      <button type="button">
        <i data-feather="search"></i>
        <i data-feather="x"></i>
      </button>
    </li>
    <li class="dropdown">
      <button type="button" data-bs-toggle="dropdown" class="has-notification" aria-expanded="false">
      <i data-feather="bell"></i>
      @if($adminNotifications->count() > 0)
         <span class="count"></span>
      @endif
      </button>
      <ul class="dropdown-menu notification-dropdown pt-0">
         <div class="notification-dropdown-header">
            <h6 class="mb-0">{{__('Notification')}}</h6>
            <a href="{{ route('admin.notifications') }}" class="s7__text-primary text-small">View All</a>
         </div>
         <div class="notification-dropdown-wrapper">
            
            @forelse ($adminNotifications as $data)
            <li>
               <a class="dropdown-item" href="{{ route('admin.notification.read', $data->id) }}">
                  <div class="d-flex flex-wrap align-items-center">
                     <div class="notification-icon s7__bg-primary-lighten s7__text-primary h5 mb-0 rounded">
                        <i class="fas fa-info"></i>
                     </div>
                     <div class="notification-content">
                        <p class="text-line-1 white-space-initial mb-0">{{$data->title}}</p>
                        <span class="text-small s7__text-muted"><i class="far fa-clock"></i> {{ $data->created_at->diffForHumans() }}</span>
                        <span></span>
                     </div>
                  </div>
               </a>
            </li>
            @empty
            <li>
               <a class="nav-link pt-3 text-center text-dark" href="javascript:void(0);" v-else>
                   <strong>@lang('No notification found')</strong>
               </a>
           </li>
            @endforelse
         </div>
      </ul>
   </li>
    <li class="dropdown">
      <button type="button" data-bs-toggle="dropdown" aria-expanded="false">
        <i data-feather="user"></i> 
      </button>
      <ul class="dropdown-menu">
        <li><a class="dropdown-item d-flex align-items-center" href="{{route('admin.changeProfile')}}"> <i data-feather="user"></i> {{__('Profile')}}</a></li>
          <li><a class="dropdown-item d-flex align-items-center" href="{{route('admin.logout')}}"> <i data-feather="log-out"></i> {{__('Logout')}}</a></li>
      </ul>
    </li>
  </ul>
</nav>