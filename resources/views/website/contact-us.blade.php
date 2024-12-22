@extends('website.layouts.master')

@section('content')
    <section class="inner-header pt-5 mt-5">
        <div class="container pt-sm-5 pt-4">
            <nav style="--bs-breadcrumb-divider: '>';" aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('home') }}">الرئيسية</a></li>
                    <li class="breadcrumb-item active" aria-current="page"> تواصل معنا </li>
                </ol>
            </nav>
        </div>
    </section>

    <section class="contact-us">
        <div class="container py-2">
            <div class="row">
                <div class="col-12">
                    <h4 class="fw-bold"> تواصل معنا</h4>
                    <div class="d-flex justify-content-center align-items-center mb-1">
                        <img src="{{ asset('build/assets/images/media/contact-us.png') }}" alt="contactus">
                    </div>
                    <h5 class="text-center text-muted">
                        تحتاج الى التواصل مع شخص حقيقى يمكنك التواصل معنا
                    </h5>
                    <div class="card mt-4 p-4">
                        <div class="card-header bg-white custom-border">
                            <h5 class="card-title fw-bold text-center">
                                تواصل معنا من خلال
                            </h5>
                        </div>

                        <div class="card-body">
                            @foreach ($branches as $branch)
                                <div class="location border-bottom">
                                    <h5 class="fw-bold my-3">
                                        <i class="fas fa-map-marker-alt main-color mx-2"></i>
                                        {{ $branch->name_ar }}
                                    </h5>
                                    <p class="text-muted my-3">
                                        {{ $branch->address_ar }}
                                    </p>
                                    <h5 class="text-muted fw-bold my-3">
                                        <i class="fas fa-phone main-color mx-2"></i>
                                        {{ $branch->phone }}
                                    </h5>
                                    @if ($branch->email)
                                        <h5 class="text-muted fw-bold my-3">
                                            <i class="fas fa-envelope main-color mx-2"></i>
                                            {{ $branch->email }}
                                        </h5>
                                    @endif
                                    @if ($branch->opening_hour && $branch->closing_hour)
                                        <p class="text-muted my-3">
                                            <i class="fas fa-clock main-color mx-2"></i>
                                            {{ __('ساعات العمل:') }}
                                            {{ $branch->opening_hour }} - {{ $branch->closing_hour }}
                                        </p>
                                    @endif
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
