@extends('website.layouts.master')

@section('content')
    <section class="intro">
        <div class="container py-sm-5 py-4">
            <div class=" py-5 owl-slider owl-carousel owl-theme">
                @foreach ($sliders as $slider)
                    <div class="item">
                        <div class="row m-0 justify-content-center align-items-center">
                            <div class="col-md-6">
                                <h1 class="slide-title">
                                    {{ app()->getLocale() == 'ar' ? $slider->name_ar : $slider->name_en }}</h1>
                                <p class="slide-text my-5 ">
                                    {{ app()->getLocale() == 'ar' ? $slider->description_ar : $slider->description_en }}
                                </p>
                                <a href="{{ route('menu') }}"
                                    class="btn">{{ app()->getLocale() == 'ar' ? 'اطلب الان' : 'Order now' }}</a>
                            </div>
                            <div class="col-md-6">
                                <figure class="intro-img">
                                    <img src="{{ asset($slider->image ?? 'front\AlKout-Resturant\SiteAssets\images\logo-with-white-bg.png') }}"
                                        alt="">
                                </figure>
                            </div>
                        </div>
                    </div>
                @endforeach

            </div>
        </div>

        <div class="container overflow-plates ">
            <div class="d-flex justify-content-between">

                <img src="{{ asset('front/AlKout-Resturant/SiteAssets/images/overflow-left.png') }}" class="small-img right"
                    data-aos="zoom-in" />
                <img src="{{ asset('front/AlKout-Resturant/SiteAssets/images/overflow-plate.png') }}" class="big-img"
                    data-aos="zoom-in" />
                <img src="{{ asset('front/AlKout-Resturant/SiteAssets/images/overflow-right.png') }}" class="small-img left"
                    data-aos="zoom-in" />
            </div>
        </div>
    </section>
    <section class="categories pt-5">
        <div class="container px-0 py-sm-5 py-4">
            <div class="section-titles d-flex justify-content-between" data-aos="fade-down">
                <h2 class="fw-bold"> @lang('header.menuopen')</h2>
                <div class="section-titles d-flex justify-content-end mb-2" data-aos="fade-down">
                    <a href="{{ route('menu') }}" class="section-btn text-decoration-none">
                        <span class="ms-2"> @lang('header.viewall')</span>
                        <span class="icon">
                            <i class="fas fa-arrow-left"></i>
                        </span>
                    </a>
                </div>
            </div>
            <div class="categories-slider owl-carousel owl-theme">
                @foreach ($menuCategories as $menuCategory)
                    @if ($menuCategory->is_active && $menuCategory->dish_categories && $menuCategory->dish_categories->is_active)
                        <div class="item mb-4 category position-relative" data-aos="zoom-in">
                            <a href="{{ route('menu', ['category_id' => $menuCategory->dish_categories->id]) }}">
                                <figure class="category-img m-0">
                                    <img src="{{ asset($menuCategory->dish_categories->image_path ?? 'front\AlKout-Resturant\SiteAssets\images\logo-with-white-bg.png') }}"
                                        alt="{{ $menuCategory->dish_categories->name_ar }}">
                                    <figcaption class="pt-4">
                                        <h5>{{ $menuCategory->dish_categories->name_ar }}</h5>
                                    </figcaption>
                                </figure>
                            </a>
                        </div>
                    @endif
                @endforeach
            </div>
        </div>
    </section>
    <section class="offers">
        <div class="container py-sm-5 py-4">
            <div class="section-titles d-flex justify-content-end mb-2" data-aos="fade-down">
                <a href="{{ route('menu') }}" class="section-btn text-decoration-none">
                    <span class="ms-2">@lang('header.viewall')</span>
                    <span class="icon">
                        <i class="fas fa-arrow-left"></i>
                    </span>
                </a>
            </div>

            <div class="offers-slider owl-carousel owl-theme">
                @if ($discounts->isNotEmpty())
                @foreach ($discounts as $discount)
                <div class="item mb-4 category position-relative" data-aos="zoom-in">
                    <div class="item three row mx-0 p-4" data-aos="zoom-in">
                        <div class="col-md-5">
                            <img class="offer-img"
                                src="{{ asset($discount->dish->image ?? 'front/AlKout-Resturant/SiteAssets/images/logo-with-white-bg.png') }}"
                                alt="{{ $discount->dish->name_ar }}">
                        </div>
                        <div class="col-md-7">
                            <h2 class="main-color fw-bold">
                                @lang('header.discount')
                                {{ $discount->discount->type == 'percentage' ? '%' : $discount->currency_symbol }}
                                {{ (int) $discount->discount->value }}
                            </h2>
                            <h5 class="pb-4">{{ $discount->dish->name_ar }}</h5>
                            <a href="#" class="btn">
                                <h4 class="fw-bold">@lang('header.ordernow')</h4>
                            </a>
                        </div>
                    </div>
                </div>
            @endforeach
            
                @endif



            </div>
        </div>
    </section>
    <section class="plates">
        <div class="container py-sm-5 py-4">
            <h2 class="fw-bold" data-aos="fade-down">@lang('header.mostpopular')</h2>
            <p class="text-muted pt-4" data-aos="fade-down"> @lang('header.popularnote')
            </p>
            <div class="plates-slider owl-carousel owl-theme">

                @foreach ($popularDishes as $dish)
                    <div class="item mb-4" data-aos="zoom-in">
                        <div class="plate">
                            <a href="#">
                                <figure class="plate-img m-0">
                                    <img src="{{ asset($dish->image ?? 'front\AlKout-Resturant\SiteAssets\images\logo-with-white-bg.png') }}"
                                        alt="{{ $dish->name_ar }}">
                                </figure>
                            </a>
                            <div class="fav">
                                <form action="{{ route('add.favorite') }}" method="POST" class="favorite-form">
                                    @csrf
                                    <input type="hidden" name="dish_id" value="{{ $dish->id }}">
                                    <button type="submit" class="btn">
                                        <i class="{{ in_array($dish->id, $userFavorites) ? 'fas' : 'far' }} fa-heart"></i>
                                    </button>
                                </form>
                            </div>
                            <div class="text-center pt-4">
                                <h5>{{ $dish->name_ar }}</h5>
                                <span class="badge bg-warning text-dark">
                                    <i class="fas fa-star"></i> @lang('header.rateall')
                                </span>
                                <div class="d-flex justify-content-between pt-4">
                                    <button class="btn add-to-cart-btn"onclick="fill_cart('{{ $dish->id }}')">
                                        @lang('header.addtocart') + </button>
                                    <span> {{ $dish->price }} {{ $dish->currency_symbol }}</span>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </section>
    <section class="info">
        <div class="container py-sm-5 py-4">
            <div class="row m-0 justify-content-cennter align-items-center">
                <div class="col-md-5 offset-md-1" data-aos="fade-left">
                    <h1 class="fw-bold"> @lang('header.orderonline')</h1>
                    <p class="text-muted my-5 "> @lang('header.fewmin')
                    </p>
                    <a href="{{ route('menu') }}" class="btn btn-lg">@lang('header.ordernow')</a>
                </div>
                <div class="col-md-6" data-aos="fade-right">
                    <figure class="info-img">
                        <img src="{{ asset('front/AlKout-Resturant/SiteAssets/images/info.png') }}" alt="">
                    </figure>
                </div>
            </div>
        </div>

    </section>
    <section class="apps">
        <div class="container pt-sm-5 pt-4">
            <div class="row m-0 justify-content-cennter align-items-center text-center">
                <div class="col-md-6" data-aos="fade-left">
                    <h3 class="mb-5"> @lang('header.downloadapp')</h3>

                    <a href="#" class="app-store-btn">
                        <div>
                            <small> @lang('header.download')</small>
                            <h5> @lang('header.app')</h5>
                        </div>
                        <i class="fab fa-apple"></i>
                    </a>
                    <a href="#" class="google-play-btn">
                        <div>
                            <small> @lang('header.get')</small>
                            <h5> @lang('header.play')</h5>
                        </div>
                        <i class="fab fa-google-play"></i>
                    </a>
                </div>
                <div class="col-md-6" data-aos="fade-right">
                    <img class="apps-img" src="{{ asset('front/AlKout-Resturant/SiteAssets/images/apps-img.png') }}" />
                </div>
            </div>
        </div>
    </section>
    @include('website.cart-modal')
@endsection
