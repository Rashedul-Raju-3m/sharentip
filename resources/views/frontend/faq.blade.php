@extends('frontend.master', ['activePage' => 'event'])

@section('content')
    @include('frontend.layout.breadcrumbs', [
        'title' => 'FAQ',
        'page' => 'faq',
    ])

<section class="property-grid grid" style="padding: 0px">
    <div class="container">
      <div class="row">
        <div class="col-sm-12">
            <div id="accordion">
                <div class="card mb-2">
                    <div class="card-header" id="headingOne">
                        <h5 class="mb-0">
                            <button class="btn btn-link" data-toggle="collapse" data-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne"  style="color: black;font-weight: bolder;">
                                1. Use service data to identify your most common questions.
                            </button>
                        </h5>
                    </div>

                    <div id="collapseOne" class="collapse show" aria-labelledby="headingOne" data-parent="#accordion">
                        <div class="card-body">
                            Your FAQ page should address the most common questions customers have about your products, services, and brand as a whole. The best way to identify those questions is to tap into your customer service data and see which problems customers are consistently reaching out to you with.
                        </div>
                    </div>
                </div>
                <div class="card mb-2">
                    <div class="card-header" id="headingTwo">
                        <h5 class="mb-0">
                            <button class="btn btn-link collapsed" data-toggle="collapse" data-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo" style="color: black;font-weight: bolder;">
                                2. Include space for live support options.
                            </button>
                        </h5>
                    </div>
                    <div id="collapseTwo" class="collapse" aria-labelledby="headingTwo" data-parent="#accordion">
                        <div class="card-body">
                            FAQ pages are intended as an initial support option for customers looking for an immediate answer to a quick question or problem. It shouldn't replace your knowledge base or your entire support team, but rather supplement your support channels as an additional, lightweight resource.
                        </div>
                    </div>
                </div>
            </div>
        </div>
      </div>
    </div>
</section>

@endsection
