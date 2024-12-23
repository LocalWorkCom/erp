@extends('website.layouts.master')

@section('content')
    <section class="inner-header pt-5 mt-5">
        <div class="container pt-sm-5 pt-4">
            <nav style="--bs-breadcrumb-divider: '>';" aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('home') }}">الرئيسية</a></li>
                    <li class="breadcrumb-item active" aria-current="page">قائمة الطعام</li>
                </ol>
            </nav>
        </div>
    </section>

    <section class="plates mb-5">
        <div class="container pb-sm-5 pb-4">

            {{-- Display Validation Messages --}}
            @if (session('success'))
                <div class="alert alert-success">
                    {{ session('success') }}
                </div>
            @endif

            @if (session('error'))
                <div class="alert alert-danger">
                    {{ session('error') }}
                </div>
            @endif

            {{-- Filter Buttons --}}
            <div class="d-flex justify-content-end mb-3 gap-2">
                <button id="showAllButton" class="btn">عرض الكل</button>
                <button id="showFavoritesButton" class="btn">عرض المفضلة</button>
            </div>


            <ul class="nav nav-pills mb-3 px-0 align-items-center" id="pills-tab" role="tablist">
                @foreach ($menuCategories as $key => $menuCategory)
                    @if ($menuCategory->dish_categories)
                        <li class="nav-item" role="presentation">
                            <button class="nav-link {{ $key == 0 ? 'active' : '' }}" id="pills-{{ $menuCategory->id }}-tab"
                                data-bs-toggle="pill" data-bs-target="#pills-{{ $menuCategory->id }}" type="button"
                                role="tab" aria-controls="pills-{{ $menuCategory->id }}"
                                aria-selected="{{ $key == 0 ? 'true' : 'false' }}">
                                <div class="category-button">
                                    <img src="{{ asset($menuCategory->dish_categories->image_path ?? 'front/AlKout-Resturant/SiteAssets/images/logo-with-white-bg.png') }}"
                                        alt="{{ $menuCategory->dish_categories->name_ar }}" />
                                    <p class="me-3 mb-0">{{ $menuCategory->dish_categories->name_ar }}</p>
                                </div>
                            </button>
                        </li>
                    @endif
                @endforeach
                <li class="nav-item" role="presentation">
                    <form id="searchForm">
                        <input id="searchInput" class="form-control py-2" type="search" placeholder="ابحث في القائمة"
                            aria-label="Search">
                    </form>
                </li>
            </ul>

            <div class="d-flex justify-content-end">
                <select class="form-select form-select-lg mb-3 w-25" aria-label=".form-select-lg example">
                    <option selected>ترتيب حسب </option>
                    <option value="1">الاعلى تقييم</option>
                    <option value="2">اضيف حديثا</option>
                </select>
            </div>


            <div class="tab-content pt-5" id="pills-tabContent">
                @foreach ($menuCategories as $key => $menuCategory)
                    @if ($menuCategory->dish_categories)
                        <div class="tab-pane fade {{ $key == 0 ? 'show active' : '' }}" id="pills-{{ $menuCategory->id }}"
                            role="tabpanel" aria-labelledby="pills-{{ $menuCategory->id }}-tab">
                            <div class="row mx-0">
                                @foreach ($menuCategory->dish_categories->dishes as $dish)
                                    <div class="col-md-4 mb-4 dish-card {{ in_array($dish->id, $userFavorites) ? 'favorite' : '' }}"
                                        data-dish-id="{{ $dish->id }}" data-dish-name="{{ $dish->name_ar }}"
                                        data-aos="zoom-in">
                                        <div class="plate">
                                            <a href="#">
                                                <figure class="plate-img m-0">
                                                    <img src="{{ asset($dish->image ?? 'front/AlKout-Resturant/SiteAssets/images/logo-with-white-bg.png') }}"
                                                        alt="{{ $dish->name_ar }}">
                                                </figure>
                                            </a>
                                            <div class="fav">
                                                <form action="{{ route('add.favorite') }}" method="POST"
                                                    class="favorite-form">
                                                    @csrf
                                                    <input type="hidden" name="dish_id" value="{{ $dish->id }}">
                                                    <button type="submit" class="btn">
                                                        <i
                                                            class="{{ in_array($dish->id, $userFavorites) ? 'fas' : 'far' }} fa-heart"></i>
                                                    </button>
                                                </form>
                                            </div>

                                            <div class="text-center pt-4">
                                                <h5>{{ $dish->name_ar }}</h5>
                                                <span class="badge bg-warning text-dark">
                                                    <i class="fas fa-star"></i>
                                                    الاعلى تقييم
                                                </span>
                                                <div class="d-flex justify-content-between pt-4">
                                                    <button class="btn" data-bs-toggle="modal"
                                                        data-bs-target="#productModal">
                                                        + أضف الي العربة
                                                    </button>
                                                    <span>{{ $dish->price }} ج . م</span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    @endif
                @endforeach
            </div>

            <button type="button" class="btn cart-btn" onclick="openCart()">
                <i class="fas fa-shopping-cart"></i>
            </button>
        </div>
    </section>
@endsection

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const showFavoritesButton = document.getElementById('showFavoritesButton');
        const showAllButton = document.getElementById('showAllButton');
        const dishCards = document.querySelectorAll('.dish-card');

        showFavoritesButton.addEventListener('click', function() {
            dishCards.forEach(function(card) {
                if (!card.classList.contains('favorite')) {
                    card.style.display = 'none';
                }
            });
        });

        showAllButton.addEventListener('click', function() {
            dishCards.forEach(function(card) {
                card.style.display = 'block';
            });
        });
    });
</script>
