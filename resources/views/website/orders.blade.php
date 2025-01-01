@extends('website.layouts.master')

@section('content')
    <section class="inner-header pt-5 mt-5">
        <div class="container pt-sm-5 pt-4">
            <nav style="--bs-breadcrumb-divider: '>';" aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('home') }}">@lang('header.home')</a></li>
                    <li class="breadcrumb-item active" aria-current="page"> @lang('header.myorder')</li>
                </ol>
            </nav>
        </div>
    </section>
    <section class="my-orders">
        <div class="container py-2">
            <h4 class="fw-bold "> @lang('header.myorder')</h4>
            <div class="card p-4">
                <h5>
                    <i class="fas fa-file-alt main-color fa-xs"></i> @lang('header.ordersum')
                </h5>
                @forelse ($orders as $order)
                    <div class="card-body border-bottom">
                        <div class="d-flex justify-content-between pt-3">
                            <h5 class="fw-bold m-0">
                                {{ $order->created_at->translatedFormat('j F .g:i A') }}
                            </h5>
                            @if ($order->status == 'completed')
                                <p class="bg-warning text-dark rounded fw-bold p-1 mb-0">@lang('header.completed')</p>
                            @elseif ($order->status == 'cancelled')
                                <p class="bg-danger text-dark rounded fw-bold p-1 mb-0"> @lang('header.cancelled')</p>
                            @elseif ($order->status == 'pending')
                                <p class="bg-danger text-dark rounded fw-bold p-1 mb-0"> @lang('header.pending')</p>
                            @elseif ($order->status == 'inprogress')
                                <p class="bg-danger text-dark rounded fw-bold p-1 mb-0"> @lang('header.inprogress')</p>
                            @endif
                        </div>
                        <small class="text-muted py-1"> @lang('header.ordermark') : {{ $order->order_number }}</small>
                        @foreach ($order->orderDetails as $detail)
                            <p class="mb-0 py-1">
                                <span class="p-1 bg-secondary text-light rounded">{{ $detail->quantity }}</span>
                                <span class="mx-1">x</span>
                                <span>{{ $detail->dish?->name ?? 'N/A' }}</span>
                            </p>
                            <p class="text-muted mt-1 mb-0 mx-4">
                                {{ is_array(getDishRecipeIds($detail->dish?->id, null)) ? implode(', ', getDishRecipeIds($detail->dish?->id, null)) : getDishRecipeIds($detail->dish?->id, null) ?? __('header.nodish') }}
                            </p>
                            <p class="fw-bold mb-0 py-1">{{ $order->total_price_after_tax }}
                                {{ $order->Branch->country->currency_symbol }}</p>
                        @endforeach
                        <a href="{{ route('order.paymentdetails', ['id' => $order->id]) }}"
                            class="text-decoration-underline py-1 fw-bold"> @lang('header.paymentdetails')</a>
                        <div class="d-flex justify-content-end">
                            <button class="btn reversed main-color"
                                onclick="window.location.href='{{ route('order.tracking', ['id' => $order->id]) }}'">
                                @lang('header.trackorder')</button>
                        </div>
                    </div>
                @empty
                    <div class="card p-5 w-50 text-center mx-auto mt-5">
                        <img class="noAddress-img" src="{{ asset('front/AlKout-Resturant/SiteAssets/images----/order.png') }}"
                            alt="" />
                        <h4 class="my-4 fw-bold">@lang('auth.noorders')</h4>
                    </div>
                @endforelse
            </div>
        </div>
    </section>
@endsection
