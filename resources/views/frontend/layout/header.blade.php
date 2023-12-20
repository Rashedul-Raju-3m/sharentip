{{--
<nav class="navbar navbar-default navbar-trans navbar-expand-lg top-header fixed-top {{url()->current() == url('/')?'':'navbar-another'}}">
    <div class="container">
      <a class="navbar-brand text-brand" href="{{url('/')}}">
        <img src="{{url('frontend/images/logo.png')}}">
      </a>
      <div class="navbar-collapse collapse justify-content-center">
        <div class="search-location">
          <input type="text" name="location" id="search_address" placeholder="{{__('Search Location')}}">
          <i class="fa fa-map-marker"></i>
        </div>
      </div>
      <button type="button" class="btn btn-b-n navbar-toggle-box-collapse d-none d-md-block search-btn" data-bs-toggle="collapse" data-bs-target="#navbarTogglerDemo01" aria-expanded="false">
        <span class="fa fa-search" aria-hidden="true"></span>
      </button>
      @if(Auth::guard('appuser')->check())
        <div class="dropdown ml-2 profileDropdown">
            <a class="dropdown-toggle" href="javascript:void(0)" id="profileDropdown" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
              <img class="header-profile-img" src="{{url('images/upload/'.Auth::guard('appuser')->user()->image)}}">
            </a>
            <div class="dropdown-menu" aria-labelledby="profileDropdown">
              <a class="dropdown-item" href="{{url('user/profile')}}">{{__('Profile')}}</a>
              <a class="dropdown-item" href="{{url('my-tickets')}}">{{__('My Tickets')}}</a>
              <a class="dropdown-item" href="{{ route('logout') }}" onclick="event.preventDefault();
              document.getElementById('logout-form').submit();">{{__('Logout')}}</a>
              <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                @csrf
              </form>
            </div>
        </div>

      @endif

    </div>
</nav>

<nav class="navbar navbar-default navbar-trans navbar-expand-lg menu-header second-menu">
  <div class="container">
    <button class="navbar-toggler collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#navbarDefault" aria-controls="navbarDefault" aria-expanded="false" aria-label="Toggle navigation">
      <span></span>
      <span></span>
      <span></span>
    </button>
    <button type="button" class="btn btn-link nav-search navbar-toggle-box-collapse d-md-none" data-bs-toggle="collapse" data-bs-target="#navbarTogglerDemo01" aria-expanded="false">
      <span class="fa fa-search" aria-hidden="true"></span>
    </button>
    <div class="navbar-collapse collapse" id="navbarDefault">
      <ul class="navbar-nav">
        <li class="nav-item">
          <a class="nav-link {{ $activePage == 'home'  ? 'active' : ''}}" href="{{url('/')}}"><i class="fa fa-home"></i>{{__('Home')}}</a>
        </li>
        <li class="nav-item">
          <a class="nav-link {{ $activePage == 'event'  ? 'active' : ''}}" href="{{url('all-events')}}"><i class="fa fa-calendar"></i>{{__('Events')}}</a>
        </li>
         <li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle {{ $activePage == 'category'  ? 'active' : ''}}" href="javascript:void(0)" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
            <i class="fa fa-bars"></i>{{__('Explore Category')}}
          </a>
          <?php $category = App\Models\Category::where('status',1)->orderBy('id','DESC')->get(); ?>
          <div class="dropdown-menu active" aria-labelledby="navbarDropdown">
            @foreach ($category as $item)
              <a class="dropdown-item {{ request()->is('events-category/'.$item->id.'/'. preg_replace('/\s+/', '-', $item->name))  ? 'active' : ''}}" href="{{url('events-category/'.$item->id.'/'. preg_replace('/\s+/', '-', $item->name))}}">{{$item->name}}</a>
            @endforeach
            <a class="dropdown-item {{ request()->is('all-category')  ? 'active' : ''}}" href="{{url('all-category')}}">{{__('All Category')}}</a>
          </div>
        </li>

        <li class="nav-item">
          <a class="nav-link {{ $activePage == 'blog'  ? 'active' : ''}}" href="{{url('all-blogs')}}"><i class="fa fa-file"></i>{{__('Blogs')}}</a>
        </li>
        <li class="nav-item">
          <a class="nav-link {{ $activePage == 'contact'  ? 'active' : ''}}" href="{{url('contact')}}"><i class="fa fa-id-badge"></i>{{__('Contact')}}</a>
        </li>
        @if(!Auth::guard('appuser')->check())
          @php
              Auth::logout();
          @endphp
        <li class="nav-item">
          <a class="nav-link" href="{{url('user/login')}}"><i class="fa fa-lock"></i>{{__('Sign in')}}</a>
        </li>
        @else
        <li class="nav-item">
          <a class="nav-link {{ $activePage == 'ticket'  ? 'active' : ''}}" href="{{url('my-tickets')}}"><i class="fa fa-ticket"></i>{{__('My Tickets')}}</a>
        </li>
        @endif
      </ul>
    </div>

  </div>
</nav>

  @if(url()->current() == url('/'))

  <?php $banner = App\Models\Banner::where('status',1)->orderBy('id','DESC')->get(); ?>
    <div class="intro intro-carousel">
      <div id="carousel" class="owl-carousel owl-theme">
        @foreach ($banner as $item)
          <div class="carousel-item-a intro-item bg-image" style="background-image: url({{url('images/upload/'.$item->image)}})">
            <div class="overlay overlay-a"></div>
            <div class="intro-content display-table">
              <div class="table-cell">
                <div class="container">
                  <div class="row">
                    <div class="col-lg-8">
                      <div class="intro-body">
                        <h1 class="intro-title mb-4">
                          <span class="color-b">{{explode(' ',$item->title)[0]}} </span>
                          @foreach (explode(' ',$item->title) as $item)
                            {{$loop->iteration>1?$item:''}}
                          @endforeach
                        </h1>
                        <p class="intro-subtitle intro-price">
                          <a href="{{url('all-events')}}"><span class="price-a">{{__('Book Now')}}</span></a>
                        </p>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        @endforeach
      </div>
    </div>

  @endif
--}}

<body>

<!-- ======= Header ======= -->
<header id="header" class="fixed-top">
    <div class="container d-flex align-items-center">

        <!--  <h1 class="logo me-auto"><a href="index.html">Arsha</a></h1> -->
        <!-- Uncomment below if you prefer to use an image logo -->
        <a href="{{url('/')}}" class="logo me-auto">
{{--            <img src="assets/img/logo.png" alt="" class="img-fluid">--}}
            <img src="{{ url('assets/img/logo.png')}}" class="img-fluid">

        </a>

        <nav id="navbar" class="navbar">
            <ul>
                <li><a class="nav-link scrollto " href="{{url('/')}}">Home</a></li>
                <li><a class="nav-link scrollto" href="{{url('all-events')}}">Events</a></li>
                <li><a class="nav-link scrollto" href="#services">Services</a></li>

                <!--<li class="dropdown"><a href="#"><span>Explore Category</span> <i class="bi bi-chevron-down"></i></a>-->
                <!--  <ul>-->
                <!--    <li><a href="#">Category Down 1</a></li>-->

                <!--    <li><a href="#">Category Down 2</a></li>-->
                <!--    <li><a href="#">Category Down 3</a></li>-->
                <!--    <li><a href="#">Category Down 4</a></li>-->
                <!--  </ul>-->
                <!--</li>-->
                <li><a class="nav-link scrollto" href="{{url('all-blogs')}}">Blog</a></li>
                <li><a class="nav-link scrollto" href="{{url('contact')}}">Contact</a></li>
                <li><a class="nav-link scrollto" href="{{route('faq_page')}}">FAQ</a></li>
{{--                <li><a class="nav-link scrollto" href="#" id="selfCoupleFamily">Test&nbsp;</a></li>--}}
{{--                <li><a class="nav-link scrollto" href="#team">&nbsp;</a></li>--}}
                {{--<li>
                    <a class="nav-link scrollto" href="{{route('cart_details')}}" style="position: relative;">
                        Cart
                        <span class="total_item" style="
position: absolute;
font-size: 15px;
font-weight: bolder;
line-height: 22px;
background: #fe7c00;
color: #fff;
text-align: center;
width: 21px;
height: 23px;
border-radius: 50%;
font-style: normal;
z-index: 1;
right: -17px;
top: -3px;
">{{Session::get('cart') && count(Session::get('cart'))>0 ? count(Session::get('cart')):0}}</span>
                    </a>
                </li>--}}
                @if(!Auth::guard('appuser')->check())
                <li> <a href="{{url('/user/login')}}" title="Please Sign up">Log In</a></li>
                <li> <a href="{{url('/user/login')}}" class="getstarted scrollto" title="Please Sign up">Sign Up</a></li>
                @endif
                {{--<li> <a href="#" class="language-setting" title="Twitter"><i class="fas language-icon fa-flag-usa"></i> En</a>
                </li>--}}

                @if(Auth::guard('appuser')->check())
                    <nav class="navbar navbar-expand-lg navbar-dark">
                        <div class="container-fluid">
                            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#main_nav"  aria-expanded="false" aria-label="Toggle navigation">
                                <span class="navbar-toggler-icon"></span>
                            </button>
                            <div class="collapse navbar-collapse" id="main_nav">
                                <ul class="navbar-nav float-right">
                                    <li class="nav-item dropdown">
                                        <a class="nav-link  dropdown-toggle" href="#" data-bs-toggle="dropdown">
                                            <img class="header-profile-img" src="{{url('images/upload/'.Auth::guard('appuser')->user()->image)}}">

                                        </a>
                                        <ul class="dropdown-menu">
                                            <li><a class="dropdown-item" href="{{url('user/profile')}}">{{__('Profile')}}</a></li>
                                            <li><a class="dropdown-item" href="{{ route('logout') }}" onclick="event.preventDefault();
              document.getElementById('logout-form').submit();">{{__('Logout')}}</a>
                                                <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                                    @csrf
                                                </form></li>
                                        </ul>
                                    </li>
                                </ul>
                            </div> <!-- navbar-collapse.// -->
                        </div> <!-- container-fluid.// -->

                    </nav>


                @endif




            </ul>
            <i class="bi bi-list mobile-nav-toggle"></i>
        </nav>

    </div>
</header><!-- End Header -->


