@extends('frontend.master', ['activePage' => 'event'])

@section('content')

    @include('frontend.layout.breadcrumbs', [
        'title' => 'Advance Search',
        'page' => 'Advance Search',
    ])

    {{--<section class="property-grid grid" style="padding: 0px">
        <div class="container">
          <div class="row">
            <div class="col-sm-12">
              <div class="text-left">

              </div>
            </div>
          </div>
        </div>
    </section>--}}

    <div class="container-xxl py-5 health-search-page section-gap">
        <div class="container">
            <div class="row g-5">
                <div class="col-lg-12 wow fadeInUp" data-wow-delay="0.1s">
                    <div class="col-lg-12">
                        <div class="health-plan-grid">
                            <div class="inner">
                                <div class="company-logo" style="position: relative">
                                    <div class="compare-btn-wrap">
                                        <div class="compare-btn" id="compare-id-83" style="position: absolute;
top: -50px;
left: -16px;
background-color: #37517e;
padding: 5px 5px;
color: #fff;
font-size: 15px;">
                                            <i class="fa fa-plus"></i> Add to Compare
                                        </div>
                                    </div>

                                    <img width="100%"
                                         src="https://bimabdcompany.s3-ap-southeast-1.amazonaws.com/media/39523/1567078720624ab73dd70c3.png"
                                         alt="Green Delta Insurance">
                                </div>



    <div class="plan-content">
    <ul>
        <div class="row">
            <div class="col-md-6">
                <li>
                    <span class="label">Plan Name</span>
                    <h6 class="value">GHI Advanced
                        <a href="https://bimafy.com/health-insurance/ghi-advanced" target="_blank">
                            <i class="fa-solid fa-arrow-up-right-from-square fa-xs"></i>
                        </a>
                    </h6>
                </li>
            </div>

            <div class="col-md-6">
            <li>
                <span class="label">Coverage</span>

                <div class="coverage-detail">
                    <h6 class="value">BDT. 100,000 (for 2 persons)</h6>
                    <span class="tooltip-title" data-bs-toggle="tooltip" data-bs-placement="left" data-tippy-content="Family floater plan provides coverage to multiple family members under a single policy. Insurance coverage amount can be shared among the family members." title="Family floater plan provides coverage to multiple family members under a single policy. Insurance coverage amount can be shared among the family members.">
                        <i class="fa-solid fa-circle-info"></i> Family Floater Plan
                    </span>
                </div>
            </li>
        </div>
        </div>
        <li>
            <span class="label">Insurance Provider</span>
            <h6 class="value">Green Delta Insurance</h6>
        </li>
    </ul>
    </div>


                                <div class="plan-action">
                                    <div class="plan-premium">
                                        <h6 class="price">BDT. 3,399 / Year</h6>
                                    </div>
                                    <div class="group-btn">
                                        {{--<a class="details-btn" id="more-details-83" href="#" title="More Details"
                                           data-bs-toggle="offcanvas" data-bs-target="#offcanvas83"
                                           aria-controls="offcanvas83">More Details</a>--}}
                                        <a class="details-btn" id="more-details-83" href="#" title="More Details"
                                           >More Details</a>
                                        <a class="buy-btn" href="#" title="Buy Now"
                                           wire:click.prevent="purchase_insurance(83)">Buy Now</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-12">
                        <div class="health-plan-grid">
                            <div class="inner">
                                <div class="company-logo" style="position: relative">
                                    <div class="compare-btn-wrap">
                                        <div class="compare-btn" id="compare-id-83" style="position: absolute;
top: -50px;
left: -16px;
background-color: #37517e;
padding: 5px 5px;
color: #fff;
font-size: 15px;">
                                            <i class="fa fa-plus"></i> Add to Compare
                                        </div>
                                    </div>

                                    <img width="100%"
                                         src="https://bimabdcompany.s3-ap-southeast-1.amazonaws.com/media/39523/1567078720624ab73dd70c3.png"
                                         alt="Green Delta Insurance">
                                </div>



    <div class="plan-content">
    <ul>
        <div class="row">
            <div class="col-md-6">
                <li>
                    <span class="label">Plan Name</span>
                    <h6 class="value">GHI Advanced
                        <a href="https://bimafy.com/health-insurance/ghi-advanced" target="_blank">
                            <i class="fa-solid fa-arrow-up-right-from-square fa-xs"></i>
                        </a>
                    </h6>
                </li>
            </div>

            <div class="col-md-6">
            <li>
                <span class="label">Coverage</span>

                <div class="coverage-detail">
                    <h6 class="value">BDT. 100,000 (for 2 persons)</h6>
                    <span class="tooltip-title" data-bs-toggle="tooltip" data-bs-placement="left" data-tippy-content="Family floater plan provides coverage to multiple family members under a single policy. Insurance coverage amount can be shared among the family members." title="Family floater plan provides coverage to multiple family members under a single policy. Insurance coverage amount can be shared among the family members.">
                        <i class="fa-solid fa-circle-info"></i> Family Floater Plan
                    </span>
                </div>
            </li>
        </div>
        </div>
        <li>
            <span class="label">Insurance Provider</span>
            <h6 class="value">Green Delta Insurance</h6>
        </li>
    </ul>
    </div>


                                <div class="plan-action">
                                    <div class="plan-premium">
                                        <h6 class="price">BDT. 3,399 / Year</h6>
                                    </div>
                                    <div class="group-btn">
                                        {{--<a class="details-btn" id="more-details-83" href="#" title="More Details"
                                           data-bs-toggle="offcanvas" data-bs-target="#offcanvas83"
                                           aria-controls="offcanvas83">More Details</a>--}}
                                        <a class="details-btn" id="more-details-83" href="#" title="More Details"
                                           >More Details</a>
                                        <a class="buy-btn" href="#" title="Buy Now"
                                           wire:click.prevent="purchase_insurance(83)">Buy Now</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection
