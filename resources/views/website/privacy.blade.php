@extends('website.layouts.master')

@section('content')
    <section class="inner-header pt-5 mt-5">
        <div class="container pt-sm-5 pt-4">
            <nav style="--bs-breadcrumb-divider: '>';" aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('home') }}">الرئيسية</a></li>
                    <li class="breadcrumb-item active" aria-current="page"><a href="{{ route('privacy') }}"> سياسة الخصوصية</a></li>
                </ol>
            </nav>
        </div>
    </section>

    <section class="contact-us">
        <div class="container py-2">
            <div class="row">
                <div class="col-12">
                    <div class="col-12">
                        <h4 class="fw-bold "> سياسة الخصوصية</h4>
                    </div>
                    <div class="col-12">
                        @foreach($privaciesArray as $privacy)
                            <div class="card mt-4 p-4">
                                <div class="card-header bg-white border-bottom">
                                    <h5 class="card-title fw-bold">{{ $privacy['title'] }}</h5>
                                </div>
                                <div class="card-body">
                                    <p class="text-muted">{!! $privacy['description'] !!}</p>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
