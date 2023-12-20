@extends('frontend.master', ['activePage' => 'sevice'])

@section('content')

    <section class="" style="background-color: #d2c9ff;">
        <div class="container py-5 h-100">
            <div class="row d-flex justify-content-center align-items-center h-100">
                <div class="col-12">
                    <div class=" card-registration card-registration-2" style="border-radius: 15px;">
                        <div class="card-body p-0">
                            <div class="col-4 offset-4 text-center">
                                <img src="{{ url('frontend/images/online_payment.jpg')}}" class="img-fluid rounded-3" alt="Online Payment">

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    @push('EveryPageCustomJS')
        <script>

        </script>
    @endpush

@endsection





