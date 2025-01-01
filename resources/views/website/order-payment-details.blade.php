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
    <section class="payment-details">
        <div class="container py-2">
            <h4 class="fw-bold "> @lang('header.myorder')</h4>
            <div class="card p-4">
                <div class="card-body">
                    <div class="d-flex justify-content-between pt-3">
                        <h5 class="fw-bold m-0">
                            {{ $order->created_at->translatedFormat('j F .g:i A') }} </h5>
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
                    <div class="accordion" id="accordionPanelsStayOpenExample">
                        <div class="accordion-item">
                            <h2 class="accordion-header py-2" id="panelsStayOpen-headingOne">
                                <button class="accordion-button p-0" type="button" data-bs-toggle="collapse"
                                    data-bs-target="#panelsStayOpen-collapseOne" aria-expanded="true"
                                    aria-controls="panelsStayOpen-collapseOne">
                                    <h6 class="fw-bold">
                                        <i class="fas fa-file-alt main-color fa-xs"></i>
                                          @lang('header.orderdetails')
                                    </h6>
                                </button>
                            </h2>
                            <div id="panelsStayOpen-collapseOne" class="accordion-collapse collapse show"
                                aria-labelledby="panelsStayOpen-headingOne">
                                <div class="accordion-body p-0">

                                    <ul class="list-unstyled p-0 mb-0">
                                        @foreach ($order->orderDetails as $detail)
                                            <li class="order-list">
                                                <p class="mb-0 py-1">
                                                    {{ $detail->quantity }} X {{ $detail->dish?->name ?? 'N/A' }}
                                                </p>
                                            </li>
                                        @endforeach
                                        <li class="order-list">
                                            <small class="text-muted py-1 d-block"> نص فرخة </small>
                                        </li>
                                        <li class="order-list">
                                            @foreach ($order->orderAddons as $addon)
                                                <small class="text-muted py-1 d-block">
                                                    {{ __('header.addons') . '(' . $addon->Addon?->addons?->name . ')' ?? __('header.noaddons') }}
                                                </small>
                                            @endforeach
                                        </li>
                                        <li class="order-list">
                                            <small class="text-muted py-1 d-block">
                                                @if ($order->note)
                                                @lang('header.note') : {{ $order->note }}
                                                @else
                                                    @lang('header.nonote')
                                                @endif
                                            </small>
                                        </li>
                                        <li class="order-list">
                                            <p class="mb-0">@lang('header.totalorder')

                                            </p>
                                            <p class="mb-0 py-1">
                                                {{ $order->total_price_after_tax }}
                                                {{ $order->Branch->country->currency_symbol }}
                                            </p>
                                        </li>
                                        <li class="order-list">
                                            <p class="mb-0">@lang('header.feesdelivery')

                                            </p>
                                            <p class="mb-0 py-1">
                                                @if ($order->delivery_fees)
                                                    {{ $order->delivery_fees }}
                                                    {{ $order->Branch->country->currency_symbol }}
                                                @else
                                                    @lang('header.nodliveryfees')
                                                @endif
                                            </p>
                                        </li>
                                        <li class="order-list">
                                            <p class="mb-0">@lang('header.fees')

                                            </p>
                                            <p class="mb-0 py-1">
                                                @if ($order->delivery_fees)
                                                    {{ $order->service_fees }}
                                                    {{ $order->Branch->country->currency_symbol }}
                                                @else
                                                    @lang('header.nofees')
                                                @endif
                                            </p>
                                        </li>

                                    </ul>
                                    @if ($order->tax_value != 0.0)
                                        <p class="mb-0">@lang('header.includefees')
                                            <span class="main-color fw-bold">
                                                {{ ($order->tax_value / $order->total_price_befor_tax) * 100 . '%' }}
                                            </span>@lang('header.anotherway')

                                            {{ $order->tax_value }} {{ $order->Branch->country->currency_symbol }}
                                        </p>
                                    @endif
                                    <ul class="list-unstyled p-0 mb-0">
                                        <li class="order-list">
                                            <p class="mb-0">   @lang('header.paymentmethod')

                                            </p>
                                            <p class="mb-0 py-1">
                                                {{ $order->orderTransactions->first()?->payment_method }}
                                            </p>
                                        </li>
                                        <li class="order-list">
                                            <p class="mb-0">@lang('header.deliveryTime')

                                            </p>
                                            <p class="mb-0 py-1">
                                                {{ getSetting('delivery_time')  .   __('header.min') }}
                                            </p>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
