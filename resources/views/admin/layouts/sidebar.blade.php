<aside class="s7__sidebar">
  <button type="button" class="sidebar-close-btn"><i class="las la-times-circle"></i></button>
  <div class="s7__logo">
     <a href="{{route('admin.home')}}" class="long-logo"><img src="{{asset('public/images/logo/logo.png')}}" alt="logo image"></a>
     <a href="{{route('admin.home')}}" class="short-logo-icon"><img class="cust-short-logo" src="{{asset('public/images/logo/favicon.png')}}" alt="logo image"></a>
  </div>
  <div class="s7__sidebar-nav-wrapper" data-simplebar>
     <ul class="s7__sidebar-nav" id="s7__sidebar-nav">
        <li>
           <a class="sidebar-link" href="{{route('admin.home')}}">
           <span data-feather="home" class="nav-icon"></span>
           <span class="s7__nav-caption">{{__('Dashboard')}}</span>
           </a>
        </li>

        @can('category-index')
        <li>
          <a href="{{route('category.index')}}" class="sidebar-link">
          <span data-feather="layout" class="nav-icon"></span>
          <span class="s7__nav-caption">{{__('Category')}}</span>
          </a>
        </li>
        @endcan

        @can('tournament-index')
        <li>
          <a href="{{route('tournament.index')}}" class="sidebar-link">
          <span data-feather="layout" class="nav-icon"></span>
          <span class="s7__nav-caption">{{__('Tournament')}}</span>
          </a>
        </li>
        @endcan

        @can('admin-all-bets')
        <li class="has-child">
          <a href="#0" aria-expanded="false">
          <span data-feather="users" class="nav-icon"></span>
          <span class="s7__nav-caption">{{__('Match')}}</span>
          </a>
          <ul class="s7__sub-nav" aria-expanded="false">
             <li>
                <a class="sidebar-link" href="{{route('admin.all.matches')}}">
                <span class="s7__nav-caption">{{__('All Event')}}</span>
                </a>
             </li>
             @can('admin-runing-matches')
             <li>
                <a class="sidebar-link" href="{{route('admin.runing.matches')}}">
                <span class="s7__nav-caption">{{__('Runing Event')}}</span>
                </a>
             </li>
             @endcan
             @can('admin-upcoming-matches')
             <li>
                <a class="sidebar-link" href="{{route('admin.upcoming.matches')}}">
                <span class="s7__nav-caption">{{__('Upcoming Event')}}</span>
                </a>
             </li>
             @endcan
             @can('admin-close-event')
             <li>
                <a class="sidebar-link" href="{{route('admin.close.event')}}">
                <span class="s7__nav-caption">{{__('Close Event')}}</span>
                </a>
             </li>
             @endcan
          </ul>
        </li>
        @endcan


        @can('admin-all-bets')
        <li class="has-child">
          <a href="#0" aria-expanded="false">
          <span data-feather="users" class="nav-icon"></span>
          <span class="s7__nav-caption">{{__('Bets Log')}}</span>
          </a>
          <ul class="s7__sub-nav" aria-expanded="false">
             <li>
                <a class="sidebar-link" href="{{route('admin.all.bets')}}">
                <span class="s7__nav-caption">{{__('All Bets')}}</span>
                </a>
             </li>
             @can('admin-pending-bets')
             <li>
                <a class="sidebar-link" href="{{route('admin.pending.bets')}}">
                <span class="s7__nav-caption">{{__('Pending Bets')}}</span>
                </a>
             </li>
             @endcan
             @can('admin-won-bets')
             <li>
                <a class="sidebar-link" href="{{route('admin.won.bets')}}">
                <span class="s7__nav-caption">{{__('Won Bets')}}</span>
                </a>
             </li>
             @endcan
             @can('admin-lost-bets')
             <li>
                <a class="sidebar-link" href="{{route('admin.lost.bets')}}">
                <span class="s7__nav-caption">{{__('Lost Bets')}}</span>
                </a>
             </li>
             @endcan
             @can('admin-refunded-bets')
             <li>
                <a class="sidebar-link" href="{{route('admin.refunded.bets')}}">
                <span class="s7__nav-caption">{{__('Refunded Bets')}}</span>
                </a>
             </li>
             @endcan
          </ul>
        </li>
        @endcan

        @can('admin-awaiting-winner')
        <li>
          <a href="{{route('admin.awaiting.winner')}}" class="sidebar-link">
          <span data-feather="layout" class="nav-icon"></span>
          <span class="s7__nav-caption">{{__('Result')}}</span>
          </a>
        </li>
        @endcan

        @can('permissions-index')
        <li class="has-child">
          <a href="#0" aria-expanded="false">
          <span data-feather="users" class="nav-icon"></span>
          <span class="s7__nav-caption">{{__('ACL Manage')}}</span>
          </a>
          <ul class="s7__sub-nav" aria-expanded="false">
             <li>
                <a class="sidebar-link" href="{{route('permissions.index')}}">
                <span class="s7__nav-caption">{{__('Permissions')}}</span>
                </a>
             </li>
             @can('roles-index')
             <li>
                <a class="sidebar-link" href="{{route('roles.index')}}">
                <span class="s7__nav-caption">{{__('Roles')}}</span>
                </a>
             </li>
             @endcan
             @can('admin-users-index')
             <li>
                <a class="sidebar-link" href="{{route('admin-users.index')}}">
                <span class="s7__nav-caption">{{__('Auth Users')}}</span>
                </a>
             </li>
             @endcan
          </ul>
        </li>
        @endcan


        @can('admin-deposit-depositlog')
        <li class="has-child">
          <a href="#0" aria-expanded="false">
          <span data-feather="users" class="nav-icon"></span>
          <span class="s7__nav-caption">{{__('Deposits')}}</span>
          </a>
          <ul class="s7__sub-nav" aria-expanded="false">
             <li>
                <a class="sidebar-link" href="{{route('admin.deposit.depositLog')}}">
                <span class="s7__nav-caption">{{__('Deposit Log')}}</span>
                </a>
             </li>
             @can('admin-deposit-pending')
             <li>
                <a class="sidebar-link" href="{{route('admin.deposit.pending')}}">
                <span class="s7__nav-caption">{{__('Pending Deposit')}}</span>
                </a>
             </li>
             @endcan
             @can('admin-deposit-acceptedrequests')
             <li>
                <a class="sidebar-link" href="{{route('admin.deposit.acceptedRequests')}}">
                <span class="s7__nav-caption">{{__('Accepted Deposit')}}</span>
                </a>
             </li>
             @endcan
             @can('admin-deposit-rejectedrequests')
             <li>
                <a class="sidebar-link" href="{{route('admin.deposit.rejectedRequests')}}">
                <span class="s7__nav-caption">{{__('Rejected Deposit')}}</span>
                </a>
             </li>
             @endcan
          </ul>
        </li>
        @endcan


        @can('subscriber-index')
        <li>
          <a href="{{route('subscriber.index')}}" class="sidebar-link">
          <span data-feather="layout" class="nav-icon"></span>
          <span class="s7__nav-caption">{{__('Subscriber List')}}</span>
          </a>
        </li>
        @endcan

        <li class="s7__menu-title">
           <span>{{__('MANAGE USER')}} </span>
        </li>

        @can('admin-user-manage')
        <li class="has-child">
          <a href="#0" aria-expanded="false">
          <span data-feather="users" class="nav-icon"></span>
          <span class="s7__nav-caption">{{__('Manage User')}}</span>
          </a>
          <ul class="s7__sub-nav" aria-expanded="false">
             <li>
                <a class="sidebar-link" href="{{route('admin.user.manage')}}">
                <span class="s7__nav-caption">{{__('All User')}}</span>
                </a>
             </li>
             @can('active-user-manage')
             <li>
                <a class="sidebar-link" href="{{route('active.user.manage')}}">
                <span class="s7__nav-caption">{{__('Active Users')}}</span>
                </a>
             </li>
             @endcan
             @can('ban-user-manage')
             <li>
                <a class="sidebar-link" href="{{route('ban.user.manage')}}">
                <span class="s7__nav-caption">{{__('Banned Users')}}</span>
                </a>
             </li>
             @endcan
             @can('email-unverified-user')
             <li>
                <a class="sidebar-link" href="{{route('email.unverified.user')}}">
                <span class="s7__nav-caption">{{__('Unverified')}}</span>
                </a>
             </li>
             @endcan
          </ul>
        </li>
        @endcan

        
        <li class="s7__menu-title">
           <span>{{__('COMMISSION SETTING')}} </span>
        </li>
         @can('admin-referral-index')
        <li>
           <a class="sidebar-link" href="{{route('admin.referral.index')}}">
           <span data-feather="link" class="nav-icon"></span>
           <span class="s7__nav-caption">{{__('Referral')}}</span>
           </a>
        </li>
         @endcan

        <li class="s7__menu-title">
           <span>{{__('PAYMENT SETTINGS')}} </span>
        </li>

        @can('gateway-index')
        <li class="has-child">
          <a href="#0" aria-expanded="false">
          <span data-feather="users" class="nav-icon"></span>
          <span class="s7__nav-caption">{{__('Gateways')}}</span>
          </a>
          <ul class="s7__sub-nav" aria-expanded="false">
             <li>
                <a class="sidebar-link" href="{{route('gateway.index')}}">
                <span class="s7__nav-caption">{{__('Automatic')}}</span>
                </a>
             </li>
             @can('admin-manual-gateway')
             <li>
                <a class="sidebar-link" href="{{route('admin.manual.gateway')}}">
                <span class="s7__nav-caption">{{__('Manual')}}</span>
                </a>
             </li>
             @endcan
          </ul>
        </li>
        @endcan

         

        <li class="s7__menu-title">
           <span>{{__('WITHDRAW SETTINGS')}} </span>
        </li>

        @can('withdraw-index')
        <li class="has-child">
          <a href="#0" aria-expanded="false">
          <span data-feather="users" class="nav-icon"></span>
          <span class="s7__nav-caption">{{__('Withdraw')}}</span>
          </a>
          <ul class="s7__sub-nav" aria-expanded="false">
             <li>
                <a class="sidebar-link" href="{{route('withdraw.index')}}">
                <span class="s7__nav-caption">{{__('Withdrawal Methods')}}</span>
                </a>
             </li>
             @can('admin-withdraw-request')
             <li>
                <a class="sidebar-link" href="{{route('admin.withdraw.request')}}">
                <span class="s7__nav-caption">{{__('Pending Withdraw')}}</span>
                </a>
             </li>
             @endcan
             @can('admin-withdraw-viewlog')
             <li>
                <a class="sidebar-link" href="{{route('admin.withdraw.viewlog')}}">
                <span class="s7__nav-caption">{{__('Withdraw Log')}}</span>
                </a>
             </li>
             @endcan
          </ul>
        </li>
        @endcan
         

        <li class="s7__menu-title">
           <span>{{__('ALL TRANSACTION')}} </span>
         </li>
         @can('transaction-log-admin')
         <li>
           <a href="{{route('transaction.log.admin')}}" class="sidebar-link">
           <span data-feather="list" class="nav-icon"></span>
           <span class="s7__nav-caption">{{__('Transaction Log')}}</span>
           </a>
         </li>
         @endcan

        <li class="s7__menu-title">
           <span>{{__('SUPPORT TICKETS')}} </span>
        </li>
        
        @can('support-index')
        <li>
          <a href="{{route('support.index')}}" class="sidebar-link">
          <span data-feather="layout" class="nav-icon"></span>
          <span class="s7__nav-caption">{{__('Support')}}</span>
          </a>
        </li>
        @endcan
        
        <li class="s7__menu-title">
           <span>{{__('CONTROLS')}} </span>
        </li>

        @can('advertise-create')
        <li class="has-child">
          <a href="#0" aria-expanded="false">
          <span data-feather="users" class="nav-icon"></span>
          <span class="s7__nav-caption">{{__('Advertise')}}</span>
          </a>
          <ul class="s7__sub-nav" aria-expanded="false">
             <li>
                <a class="sidebar-link" href="{{route('advertise.create')}}">
                <span class="s7__nav-caption">{{__('Add Advertise')}}</span>
                </a>
             </li>
             @can('admin-advertise-banner')
             <li>
                <a class="sidebar-link" href="{{route('admin.advertise.banner')}}">
                <span class="s7__nav-caption">{{__('Banner Advertise')}}</span>
                </a>
             </li>
             @endcan
             @can('admin-advertise-script')
             <li>
                <a class="sidebar-link" href="{{route('admin.advertise.script')}}">
                <span class="s7__nav-caption">{{__('Script Advertise')}}</span>
                </a>
             </li>
             @endcan
          </ul>
        </li>
        @endcan

        @can('admin-web-index')
        <li class="has-child">
          <a href="#0" aria-expanded="false">
          <span data-feather="users" class="nav-icon"></span>
          <span class="s7__nav-caption">{{__('Manage Web')}}</span>
          </a>
          <ul class="s7__sub-nav" aria-expanded="false">
             @can('slider-index')
             <li>
                <a class="sidebar-link" href="{{route('slider.index')}}">
                <span class="s7__nav-caption">{{__('Slider')}}</span>
                </a>
             </li>
             @endcan
             @can('service-index')
             <li>
                <a class="sidebar-link" href="{{route('service.index')}}">
                <span class="s7__nav-caption">{{__('Service')}}</span>
                </a>
             </li>
             @endcan
             @can('admin-about-index')
             <li>
                <a class="sidebar-link" href="{{route('admin.about.index')}}">
                <span class="s7__nav-caption">{{__('About Us')}}</span>
                </a>
             </li>
             @endcan
             @can('testimonial-index')
             <li>
                <a class="sidebar-link" href="{{route('testimonial.index')}}">
                <span class="s7__nav-caption">{{__('Testimonial')}}</span>
                </a>
             </li>
             @endcan
             @can('social-index')
             <li>
                <a class="sidebar-link" href="{{route('social.index')}}">
                <span class="s7__nav-caption">{{__('Social')}}</span>
                </a>
             </li>
             @endcan
             @can('faq-index')
             <li>
                <a class="sidebar-link" href="{{route('faq.index')}}">
                <span class="s7__nav-caption">{{__('FAQS')}}</span>
                </a>
             </li>
             @endcan
             @can('admin-contact-index')
             <li>
                <a class="sidebar-link" href="{{route('admin.contact.index')}}">
                <span class="s7__nav-caption">{{__('Contact')}}</span>
                </a>
             </li>
             @endcan
          </ul>
        </li>
        @endcan


        @can('news-index')
        <li class="has-child">
          <a href="#0" aria-expanded="false">
          <span data-feather="users" class="nav-icon"></span>
          <span class="s7__nav-caption">{{__('News')}}</span>
          </a>
          <ul class="s7__sub-nav" aria-expanded="false">
             @can('news-category-index')
             <li>
                <a class="sidebar-link" href="{{route('news-category.index')}}">
                <span class="s7__nav-caption">{{__('News Category')}}</span>
                </a>
             </li>
             @endcan
             <li>
                <a class="sidebar-link" href="{{route('news.index')}}">
                <span class="s7__nav-caption">{{__('Manage News')}}</span>
                </a>
             </li>
          </ul>
        </li>
        @endcan

        @can('section-index')
        <li class="has-child">
          <a href="#0" aria-expanded="false">
          <span data-feather="users" class="nav-icon"></span>
          <span class="s7__nav-caption">{{__('Pages')}}</span>
          </a>
          <ul class="s7__sub-nav" aria-expanded="false">
             <li>
                <a class="sidebar-link" href="{{route('section.index')}}">
                <span class="s7__nav-caption">{{__('Manage Section')}}</span>
                </a>
            </li>
             @can('extra-page-index')
             <li>
                <a class="sidebar-link" href="{{route('extra-page.index')}}">
                <span class="s7__nav-caption">{{__('Others Pages')}}</span>
                </a>
             </li>
             @endcan
          </ul>
        </li>
        @endcan


        <li class="s7__menu-title">
           <span>{{__('THEME SETTINGS')}} </span>
        </li>

        @can('general-nav-sidebar')
        <li class="has-child">
          <a href="#0" aria-expanded="false">
          <span data-feather="users" class="nav-icon"></span>
          <span class="s7__nav-caption">{{__('Settings')}}</span>
          </a>
          <ul class="s7__sub-nav" aria-expanded="false">
             @can('admin-gnl-index')
             <li>
                <a class="sidebar-link" href="{{route('admin.gnl.index')}}">
                <span class="s7__nav-caption">{{__('General')}}</span>
                </a>
             </li>
             @endcan
             @can('admin-logo-favicon-index')
             <li>
                <a class="sidebar-link" href="{{route('admin.logo-favicon.index')}}">
                <span class="s7__nav-caption">{{__('Logo & Favicon')}}</span>
                </a>
             </li>
             @endcan
             @can('language-index')
             <li>
                <a class="sidebar-link" href="{{route('language.index')}}">
                <span class="s7__nav-caption">{{__('Language')}}</span>
                </a>
             </li>
             @endcan
             @can('admin-seo-global')
             <li>
                <a class="sidebar-link" href="{{route('admin.seo.global')}}">
                <span class="s7__nav-caption">{{__('SEO Manager')}}</span>
                </a>
             </li>
             @endcan
             @can('extension-index')
             <li>
                <a class="sidebar-link" href="{{route('extension.index')}}">
                <span class="s7__nav-caption">{{__('Extensions')}}</span>
                </a>
             </li>
             @endcan
             @can('sports-api-index')
             <li>
                <a class="sidebar-link" href="{{route('sports.api.index')}}">
                <span class="s7__nav-caption">{{__('Sports Api')}}</span>
                </a>
             </li>
             @endcan
          </ul>
        </li>
        @endcan

        @can('manage-section-index')
        <li>
          <a href="{{route('manage.section.index')}}" class="sidebar-link">
          <span data-feather="layout" class="nav-icon"></span>
          <span class="s7__nav-caption">{{__('Manage Section')}}</span>
          </a>
        </li>
        @endcan

        @can('email-template-index')
        <li class="has-child">
          <a href="#0" aria-expanded="false">
          <span data-feather="users" class="nav-icon"></span>
          <span class="s7__nav-caption">{{__('Email Settings')}}</span>
          </a>
          <ul class="s7__sub-nav" aria-expanded="false">
             <li>
                <a class="sidebar-link" href="{{route('email-template.index')}}">
                <span class="s7__nav-caption">{{__('Email Template')}}</span>
                </a>
            </li>
             @can('admin-global-template')
             <li>
                <a class="sidebar-link" href="{{route('admin.global-template')}}">
                <span class="s7__nav-caption">{{__('Global Template')}}</span>
                </a>
             </li>
             @endcan
             @can('admin-email-controls')
             <li>
                <a class="sidebar-link" href="{{route('admin.email-controls')}}">
                <span class="s7__nav-caption">{{__('Email Controls')}}</span>
                </a>
             </li>
             @endcan
          </ul>
        </li>
        @endcan

        @can('admin-custom-css')
        <li>
          <a href="{{route('admin.custom.css')}}" class="sidebar-link">
          <span data-feather="layout" class="nav-icon"></span>
          <span class="s7__nav-caption">{{__('Custom CSS')}}</span>
          </a>
        </li>
        @endcan

        
  

     </ul>
  </div>
</aside>
