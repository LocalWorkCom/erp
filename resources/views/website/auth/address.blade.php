@extends('website.layouts.master')

@section('content')
    <section class="inner-header pt-5 mt-5">
        <div class="container pt-sm-5 pt-4">
            <nav style="--bs-breadcrumb-divider: '>';" aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('home') }}"> @lang('auth.home')</a></li>
                    <li class="breadcrumb-item active" aria-current="page"> @lang('header.myaddress')</li>
                </ol>
            </nav>
        </div>

    </section>
    <section class="addresses">
        <div class="container pb-sm-5 pb-4">
            <div class="d-flex justify-content-between align-items-center">
                <h4 class="my-4 fw-bold">@lang('header.myaddress')</h4>
                <button class="btn fw-bold fs-5" type="button"
                    onclick="window.location.href='{{ route('create.Address') }}'">
                    <span>+</span> @lang('auth.addaddress')
                </button>

            </div>

            @if ($address->isNotEmpty())
                @foreach ($address as $item)
                    <div class="card p-5 w-75 mx-auto mt-5">
                        <ul class="list-unstyled px-0">
                            <li class="d-flex justify-content-between align-items-start mb-4">
                                <div>
                                    <h5>
                                        <i class="fas fa-city text-muted fa-xs ms-2"></i>
                                        {{ $item->building }}
                                    </h5>
                                    <small class="text-muted">
                                        @if ($item->building === 'apartment')
                                            {{ $item->address_type . ' , ' . $item->apartment_number . ' , ' . $item->floor_number . ' , ' . $item->floor_number . ' , ' . $item->address . ' , ' . $item->state . ' , ' . $item->city . ' , ' . $item->country }}
                                        @else
                                            {{ $item->apartment_number . ' , ' . $item->state . ' , ' . $item->city . ' , ' . $item->country }}
                                        @endif
                                    </small>

                                </div>
                                <div class="dropdown">
                                    <a id="dropdownMenuButton" data-bs-toggle="dropdown" aria-expanded="false">
                                        <i class="fas fa-ellipsis-v"></i>
                                    </a>
                                    <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                        <li>
                                            <button class="dropdown-item w-100"
                                                onclick="window.location.href='{{ route('edit.Address', ['id' => $item->id]) }}'">
                                                @lang('auth.edit')
                                            </button>
                                        </li>
                                        <li>
                                            <button class="dropdown-item w-100"> @lang('auth.delete')</button>
                                        </li>
                                    </ul>
                                </div>
                            </li>
                        </ul>
                    </div>
                @endforeach
            @else
                <div class="card p-5 w-50 text-center mx-auto mt-5">
                    <img class="noAddress-img"
                        src="{{ asset('front/AlKout-Resturant/SiteAssets/images/mdi_file-location.png') }}"
                        alt="" />
                    <h4 class="my-4 fw-bold">@lang('auth.noaddress')</h4>
                </div>
            @endif



        </div>
    </section>
@endsection
