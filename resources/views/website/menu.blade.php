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
            <ul class="nav nav-pills mb-3 px-0 align-items-center" id="pills-tab" role="tablist">
                @foreach ($menuCategories as $key => $menuCategory)
                    @if ($menuCategory->dish_categories)
                        <li class="nav-item" role="presentation">
                            <button class="nav-link {{ $key == 0 ? 'active' : '' }}" id="pills-{{ $menuCategory->id }}-tab"
                                data-bs-toggle="pill" data-bs-target="#pills-{{ $menuCategory->id }}" type="button"
                                role="tab" aria-controls="pills-{{ $menuCategory->id }}"
                                aria-selected="{{ $key == 0 ? 'true' : 'false' }}">
                                <div class="category-button">
                                    <img src="{{ asset($menuCategory->dish_categories->image_path ?? 'default-category.png') }}"
                                        alt="{{ $menuCategory->dish_categories->name_ar }}" />
                                    <p class="me-3 mb-0">{{ $menuCategory->dish_categories->name_ar }}</p>
                                </div>
                            </button>
                        </li>
                    @endif
                @endforeach

                <li class="nav-item" role="presentation">
                    <form>
                        <input class="form-control py-2" type="search" placeholder="ابحث في القائمة" aria-label="Search">
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
                                    <div class="col-md-4 mb-4" data-aos="zoom-in">
                                        <div class="plate">
                                            <a href="#">
                                                <figure class="plate-img m-0">
                                                    <img src="{{ asset($dish->image ?? 'default-dish.png') }}"
                                                        alt="{{ $dish->name_ar }}">
                                                </figure>
                                            </a>
                                            <div class="fav">
                                                <a href="#"><i class="far fa-heart"></i></a>
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

            <div id="blur-overlay" class="blur-overlay"></div>

            <div id="sideCart" class="sideCart">
                <div class="cart-header p-4">
                    <a href="javascript:void(0)" class="closebtn" onclick="closeCart()">&times;</a>
                    <h4>تفاصيل العربة</h4>
                    <div class="cart-total-items">3</div>
                </div>
                <div class="cart-content p-4">
                    <div class="sideCart-plate p-4 mb-4">
                        <a href="#">
                            <figure class="sideCart-plate-img m-0">
                                <img src="SiteAssets/images/plate1.png" alt="">
                            </figure>
                        </a>
                        <div class="cart-details">
                            <h5>كبسة فراخ</h5>
                            <div class="qty mt-3">
                                <span class="dec">
                                    <i class="fa fa-trash" aria-hidden="true"></i>
                                </span>
                                <span class="num">1</span>
                                <span class="inc">
                                    <i class="fa fa-plus" aria-hidden="true"></i>
                                </span>
                            </div>
                            <p class="fw-bold">300 ج . م</p>
                            <div class="btns">
                                <button class="btn reversed main-color" type="button">تعديل</button>
                                <button class="btn" type="button">حذف</button>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="cart-footer p-4">
                    <a class="btn w-100 d-flex justify-content-between" href="{{ route('home') }}">
                        <i class="fas fa-shopping-cart"></i>
                        <span>أذهب الي العربة</span>
                        <span>300 ج . م</span>
                    </a>
                </div>
            </div>
        </div>
    </section>
@endsection
