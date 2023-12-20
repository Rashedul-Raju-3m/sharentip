@extends('frontend.master', ['activePage' => 'home'])



@section('content')
    <!-- ======= Hero Section ======= -->
    <section id="hero" class="d-flex align-items-center">

        <div class="container">
            <div class="row">
                <div class="col-lg-6 d-flex flex-column justify-content-center pt-4 pt-lg-0 order-2 order-lg-1"
                     data-aos="fade-up" data-aos-delay="200">
                    <h1>Better Solutions For Your Next Event</h1>
                    <h2>We are team of talented designers making websites with Bootstrap</h2>
                    <div class="d-flex justify-content-center justify-content-lg-start">
                        <a href="#about" class="btn-get-started scrollto">Get Started</a>
                        <a href="https://www.youtube.com/watch?v=eoQC79Vojy4" class="glightbox btn-watch-video"><i
                                class="bi bi-play-circle"></i><span>Watch Video</span></a>
                    </div>
                </div>
                <div class="col-lg-6 order-1 order-lg-2 hero-img" data-aos="zoom-in" data-aos-delay="200">
                    <img src="assets/img/hero-img.png" class="img-fluid animated" alt="">
                </div>
            </div>
        </div>

    </section>
    <!-- End Hero -->
    <section class="section-property">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <div class=" d-flex justify-content-between">
{{--                        <form method="post" action="{{route('event_service_search')}}" style="width: 100%;">--}}
{{--                            {{csrf_token()}}--}}
                            <form method="POST" action="{{ route('event_service_search') }}" style="width: 100%;" autocomplete="nope">
                                {{ csrf_field() }}
                            <div class="input-group">
                                <input type="text" name="search" id="search" required placeholder="Search events and categories" class="form-control">
                                <span class="input-group-btn" style="margin-left: 5px">
                                    <input type="submit" name="commit" value="Search" class="btn btn-primary" data-disable-with="Search">
                                </span>
                                <span class="input-group-btn" style="margin-left: 5px">
                                    <button type="button" class="btn btn-success advance_search">Advance Search</button>
                                </span>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>



    <section class="section-property section-b4">
        <div class="container">
          <div class="row">
            <div class="col-md-12">
              <div class="title-wrap d-flex justify-content-between">
                <div class="title-box">
                  <h2 class="title-a">{{__('Latest Events')}}</h2>
                </div>

              </div>
            </div>
          </div>
          <div id="" class="event-section owl-theme">
            <div class="row">
              @foreach ($events as $item)
                @if($loop->iteration <= 6)
                <div class="carousel-item-b col-lg-4 col-md-6 col-sm-6 mb-4">
                  <div class="fav-section">
                    @if(Auth::guard('appuser')->check())
                      <button type="button" onclick="addFavorite({{$item->id}},'event')" class="btn p-0"> <i class="fa fa-heart {{in_array($item->id,array_filter(explode(',',Auth::guard('appuser')->user()->favorite)))==true?'active':''}}"></i></button>
                    @else
                      <button type="button" class="btn p-0"> <a href="{{url('user/login')}}"><i class="fa fa-heart"></i></a></button>
                    @endif
                  </div>
                  <div class="card-box-a card-shadow box-shadow radius-10">
                    <div class="img-box-a">
                      <img src="{{url('images/upload/'.$item->image)}}" alt="" class="img-a img-fluid">
                    </div>
                    <div class="card-overlay">
                      <div class="card-overlay-a-content">
                        <div class="card-header-a">
                          <h2 class="card-title-a">
                            <a href="{{url('event/'.$item->id.'/'.preg_replace('/\s+/', '-', $item->name))}}">{{ $item->name}}</a>
                          </h2>
                        </div>
                        <div class="card-body-a">
                          <div class="price-box d-flex">
                            <span class="price-a">{{$item->start_time->format('l').', '.$item->start_time->format('d F Y')}}</span>
                          </div>
                          <a href="{{url('event/'.$item->id.'/'.preg_replace('/\s+/', '-', $item->name))}}" class="link-a">{{__('More Detail')}}
                            <span class="ion-ios-arrow-forward"></span>
                          </a>
                        </div>
                        <div class="card-footer-a">
                          <ul class="card-info d-flex justify-content-around">
                            <li>
                              <h4 class="card-info-title">{{__('Type')}}</h4>
                              <span>{{$item->category->name}}</span>
                            </li>
                            <li>
                              <h4 class="card-info-title">{{__('People')}}</h4>
                              <span>{{$item->people}}</span>
                            </li>
                            <li>
                              <h4 class="card-info-title">{{__('Sold')}}</h4>
                              <span>{{$item->sold.' ticket'}} </span>
                            </li>
                            <li>
                              <h4 class="card-info-title">{{__('Available')}}</h4>
                              <span>{{(int)$item->people-(int)$item->sold.' ticket'}}</span>
                            </li>
                          </ul>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
                @endif
              @endforeach
            </div>
          </div>
        </div>
      </section>

    <section class="section-property section-b4">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <div class="title-wrap d-flex justify-content-between">
                        <div class="title-box">
                            <h2 class="title-a">Service Category</h2>
                        </div>

                    </div>
                </div>
            </div>
            <div id="" class="event-section owl-theme">
                <div class="row">
                    @foreach ($serviceCategorys as $serviceCategory)
                            <div class="carousel-item-b col-md-2 mb-4">
                                <div class="fav-section">
                                    @if(Auth::guard('appuser')->check())
                                        <button type="button" onclick="addFavorite({{$serviceCategory->id}},'event')" class="btn p-0"> <i class="fa fa-heart {{in_array($serviceCategory->id,array_filter(explode(',',Auth::guard('appuser')->user()->favorite)))==true?'active':''}}"></i></button>
                                    @else
                                        <button type="button" class="btn p-0"> <a href="{{url('user/login')}}"><i class="fa fa-heart"></i></a></button>
                                    @endif
                                </div>
                                <div class="card-box-a card-shadow box-shadow" style="border-radius: 0px;height: 100px;">
                                    <div class="img-box-a">
                                        <img src="{{url('images/upload/'.$serviceCategory->image)}}" alt="" class="img-a img-fluid">
                                    </div>
                                    <div class="card-overlay">
                                        <div class="card-overlay-a-content">
                                            <div class="card-header-a">
                                                <h2 class="card-title-a">
{{--                                                    <a href="{{route('service_category_details',[$serviceCategory->id,preg_replace('/\s+/', '-', $serviceCategory->name)])}}">{{ $serviceCategory->name}}</a>--}}
                                                    <a href="{{route('tour_cart_page',[$serviceCategory->id,preg_replace('/\s+/', '-', $serviceCategory->name)])}}">{{ $serviceCategory->name}}</a>
                                                </h2>
                                            </div>
                                            <div class="card-footer-a">
                                                <ul class="card-info d-flex justify-content-around">
                                                    <li>
                                                        <h4 class="card-info-title">{{__('Type')}}</h4>
                                                        <span>{{$serviceCategory->name}}</span>
                                                    </li>
                                                </ul>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                    @endforeach
                </div>
            </div>
        </div>
    </section>

    <section class="section-news section-t4 section-b4 mt-4 bg-gray">
      <div class="container">
        <div class="row">
          <div class="col-md-12">
            <div class="title-wrap d-flex justify-content-between">
              <div class="title-box">
                <h2 class="title-a">{{__('Featured Category')}}</h2>
              </div>
            </div>
          </div>
        </div>
        <div id="" class="category-section">
          <div class="row">
            @foreach ($category as $item)
              <div class="carousel-item-c col-lg-3 col-md-6 col-sm-6">
                <div class="card-box-b card-shadow news-box radius-10">
                  <div class="img-box-b">
                    <img src="{{url('images/upload/'.$item->image)}}" alt="" class="img-b img-fluid">
                  </div>
                  <div class="card-overlay">
                    <div class="card-header-b">
                      <div class="card-title-b">
                        <h2 class="title-2">
                          <a href="{{url('events-category/'.$item->id.'/'. preg_replace('/\s+/', '-', $item->name))}}">{{$item->name}}</a>
                        </h2>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            @endforeach
          </div>
        </div>
      </div>
    </section>


    <section class="section-blog section-t8">
      <div class="container">
        <div class="row">
          <div class="col-md-12">
            <div class="title-wrap d-flex justify-content-between">
              <div class="title-box">
                <h2 class="title-a">{{__('Our Latest Blog')}}</h2>
              </div>
            </div>
          </div>
        </div>
        <div id="" class="category-section">
          <div class="row">
            @foreach ($blog as $item)
              <div class="carousel-item-c col-lg-3 col-md-6 col-sm-6">
                  <div class="fav-section">
                      @if(Auth::guard('appuser')->check())
                          <button type="button" onclick="addFavorite({{$item->id}},'blog')" class="btn p-0"> <i class="fa fa-heart {{in_array($item->id,array_filter(explode(',',Auth::guard('appuser')->user()->favorite_blog)))==true?'active':''}}"></i></button>
                      @else
                          <button type="button" class="btn p-0"> <a href="{{url('user/login')}}"><i class="fa fa-heart"></i></a></button>
                      @endif
                  </div>
                <div class="card-box-b card-shadow news-box radius-10">
                  <div class="img-box-b">
                      <img src="{{url('images/upload/'.$item->image)}}" alt="" class="img-b img-fluid">
                  </div>
                  <div class="card-overlay">
                    <div class="card-header-b">
                      <div class="card-title-b">
                        <h2 class="title-2">
                            <a href="{{url('blog-detail/'.$item->id.'/'.preg_replace('/\s+/', '-', $item->title))}}" title="{{$item->title}}">{{strlen($item->title)>=50? substr($item->title,0,50).'...':$item->title}} </a>
                        </h2>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            @endforeach
          </div>
        </div>
      </div>
    </section>
{{--    <section class="section-blog section-t8">
      <div class="container">
        <div class="row">
          <div class="col-md-12">
            <div class="title-wrap d-flex justify-content-between">
              <div class="title-box">
                <h2 class="title-a">{{__('Our Latest Blog')}} </h2>
              </div>
            </div>
          </div>
        </div>
        <div id="blog-carousel" class="owl-carousel owl-theme blog-section">
          @foreach ($blog as $item)
            <div class="carousel-item-c">
              <div class="fav-section">
                @if(Auth::guard('appuser')->check())
                  <button type="button" onclick="addFavorite({{$item->id}},'blog')" class="btn p-0"> <i class="fa fa-heart {{in_array($item->id,array_filter(explode(',',Auth::guard('appuser')->user()->favorite_blog)))==true?'active':''}}"></i></button>
                @else
                  <button type="button" class="btn p-0"> <a href="{{url('user/login')}}"><i class="fa fa-heart"></i></a></button>
                @endif
              </div>
              <div class="card-box-b card-shadow news-box radius-10">
                <div class="img-box-b">
                  <img src="{{url('images/upload/'.$item->image)}}" alt="" class="img-b img-fluid">
                </div>
                <div class="card-overlay"></div>
              </div>
              <div class="card-header-b">
                <div class="card-title-b">
                  <h2 class="title-2">
                    <a href="{{url('blog-detail/'.$item->id.'/'.preg_replace('/\s+/', '-', $item->title))}}" title="{{$item->title}}">{{strlen($item->title)>=50? substr($item->title,0,50).'...':$item->title}} </a>
                  </h2>
                </div>
                <div class="card-category-b">
                  <span><i class="fa fa-sitemap mt-6 float-left"></i>{{$item->category->name}}</span>
                  <span class="date-b"><i class="fa fa-calendar"></i>{{$item->created_at->format('d M.Y')}}</span>
                </div>
              </div>
            </div>
          @endforeach
        </div>
      </div>
    </section>--}}

    <div class="modal fade" id="modal-lg">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" style="font-size: 20px;
font-weight: bold;">Advance search</h4>
                    <button style="margin-top: -29px;
color: #000;" type="button" class="close model-close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="container">
                        <form method="POST" action="{{ route('advance_search') }}" autocomplete="nope">
                            {{ csrf_field() }}
                            <div class="form-row">
                                <div class="form-group col-md-6">
                                    <label for="district" class="mr-2 col-form-label-sm">District&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</label>
                                    <select id="district" class="form-control form-control-sm" style="display: inline-block;width: 67%;">
                                        <option selected>Choose...</option>
                                        <option>Dhaka</option>
                                        <option>Gazipur</option>
                                    </select>
                                </div>
                                <div class="form-group col-md-6">
                                    <label for="district" class="mr-2 col-form-label-sm">State&nbsp;</label>
                                    <select id="district" class="form-control form-control-sm" style="display: inline-block;width: 82%;">
                                        <option selected>Choose...</option>
                                        <option>Dhaka</option>
                                        <option>Gazipur</option>
                                    </select>
                                </div>
                            </div>

                            <div class="form-row">
                                <div class="form-group col-md-6">
                                    <label for="companyName" class="mr-2 col-form-label-sm">Capacity from&nbsp;</label>
                                    <input type="text" class="form-control form-control-sm" autocomplete="off" name="companyName" style="display: inline-block;width: 67%;">
                                </div>
                                <div class="form-group col-md-6">
                                    <label for="version" class="mr-2 col-form-label-sm">to&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</label>
                                    <input type="text" class="form-control form-control-sm" autocomplete="off" name="version" style="display: inline-block;width: 82%;">
                                </div>
                            </div>

                            <div class="form-row">
                                <div class="form-group col-md-6">
                                    <label for="companyName" class="mr-2 col-form-label-sm">Date from&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</label>
                                    <input type="date" class="form-control form-control-sm" autocomplete="off" name="companyName" style="display: inline-block;width: 67%;">
                                </div>
                                <div class="form-group col-md-6">
                                    <label for="version" class="mr-2 col-form-label-sm">to&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</label>
                                    <input type="date" class="form-control form-control-sm" autocomplete="off" name="version" style="display: inline-block;width: 82%;">
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="form-group col-lg-12">
                                    <button type="submit" class="btn btn-primary btn-sm">Search</button>
                                    <button type="button" class="btn btn-light btn-sm ml-1 model-close">Cancel</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
