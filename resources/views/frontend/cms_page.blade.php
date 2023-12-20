@extends('frontend.master', ['activePage' => 'event'])

@section('content')
    @php
        $title = '';
        if ($slug === 'terms_conditions'){
            $title = 'Terms & conditions';
        }elseif ($slug ==='privacy_policy'){
            $title = 'Privacy Policy';
        }elseif ($slug ==='refund_policy'){
            $title = 'Refund Policy';
        }
    @endphp
    @include('frontend.layout.breadcrumbs', [
        'title' => $title,
        'page' => $title,
    ])

<section class="property-grid grid" style="padding: 0px">
    <div class="container">
      <div class="row">
        <div class="col-sm-12">
          <div class="text-left">
              @if($slug === 'terms_conditions')
                  <h3>1. INTRODUCTION</h3>
                    <p style="text-align: justify">
                        Welcome to Event also hereby known as “we", "us" or "Event". We are an online marketplace and these are the terms and conditions governing your access and use of Event along with its related sub-domains, sites, mobile app, services and tools (the "Site"). By using the Site, you hereby accept these terms and conditions (including the linked information herein) and represent that you agree to comply with these terms and conditions (the "User Agreement"). This User Agreement is deemed effective upon your use of the Site which signifies your acceptance of these terms. If you do not agree to be bound by this User Agreement please do not access, register with or use this Site. This Site is owned and operated by <b> Event Bangladesh Limited, a company incorporated under the Companies Act, 1994, (Registration Number: 117773/14).</b>
                    </p>
                    <p style="text-align: justify">
                        The Site reserves the right to change, modify, add, or remove portions of these Terms and Conditions at any time without any prior notification. Changes will be effective when posted on the Site with no other notice provided. Please check these Terms and Conditions regularly for updates. Your continued use of the Site following the posting of changes to Terms and Conditions of use constitutes your acceptance of those changes.
                    </p>
              @endif
              @if($slug === 'privacy_policy')
                  <h3>1. INTRODUCTION</h3>
                    <p style="text-align: justify">
                        Welcome to Event also hereby known as “we", "us" or "Event". We are an online marketplace and these are the terms and conditions governing your access and use of Event along with its related sub-domains, sites, mobile app, services and tools (the "Site"). By using the Site, you hereby accept these terms and conditions (including the linked information herein) and represent that you agree to comply with these terms and conditions (the "User Agreement"). This User Agreement is deemed effective upon your use of the Site which signifies your acceptance of these terms. If you do not agree to be bound by this User Agreement please do not access, register with or use this Site. This Site is owned and operated by <b> Event Bangladesh Limited, a company incorporated under the Companies Act, 1994, (Registration Number: 117773/14).</b>
                    </p>
                    <p style="text-align: justify">
                        The Site reserves the right to change, modify, add, or remove portions of these Terms and Conditions at any time without any prior notification. Changes will be effective when posted on the Site with no other notice provided. Please check these Terms and Conditions regularly for updates. Your continued use of the Site following the posting of changes to Terms and Conditions of use constitutes your acceptance of those changes.
                    </p>
              @endif
              @if($slug === 'refund_policy')
                  <h3>1. INTRODUCTION</h3>
                    <p style="text-align: justify">
                        Welcome to Event also hereby known as “we", "us" or "Event". We are an online marketplace and these are the terms and conditions governing your access and use of Event along with its related sub-domains, sites, mobile app, services and tools (the "Site"). By using the Site, you hereby accept these terms and conditions (including the linked information herein) and represent that you agree to comply with these terms and conditions (the "User Agreement"). This User Agreement is deemed effective upon your use of the Site which signifies your acceptance of these terms. If you do not agree to be bound by this User Agreement please do not access, register with or use this Site. This Site is owned and operated by <b> Event Bangladesh Limited, a company incorporated under the Companies Act, 1994, (Registration Number: 117773/14).</b>
                    </p>
                    <p style="text-align: justify">
                        The Site reserves the right to change, modify, add, or remove portions of these Terms and Conditions at any time without any prior notification. Changes will be effective when posted on the Site with no other notice provided. Please check these Terms and Conditions regularly for updates. Your continued use of the Site following the posting of changes to Terms and Conditions of use constitutes your acceptance of those changes.
                    </p>
              @endif
          </div>
        </div>
      </div>
    </div>
</section>

@endsection
