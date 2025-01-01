@extends('website.layouts.master')

@section('content')
    <div class="modal fade" id="exampleModalToggle" aria-hidden="true" aria-labelledby="exampleModalToggleLabel" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-body register" id="registerBody">
                    <div class="row justify-content-center text-center">
                        <div class="col-12">
                            <i class="fas fa-gift text-warning fs-1 my-3"></i>
                            <h2 class="fw-bold main-color"> @lang('header.surprise')</h2>
                            <h5 class="text-muted">@lang('header.getcopun')</h5>
                            <h3 class="fw-bold text-dark">@lang('header.isdelivered')</h3>
                            <div class="d-flex justify-content-center py-4">
                                <a href="#" class="btn mx-1 w-50" data-bs-target="#exampleModalToggle2"
                                    data-bs-toggle="modal" data-bs-dismiss="modal"> @lang('header.yes')</a>
                                <a href="#" class="btn-no-modal mx-1 w-50" data-bs-dismiss="modal" aria-label="Close">
                                    @lang('header.no')</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="exampleModalToggle2" aria-hidden="true" aria-labelledby="exampleModalToggleLabel2"
        tabindex="-1">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header border-0">
                    <button type="button" class="btn btn-close text-light" data-bs-dismiss="modal"
                        aria-label="Close"></button>
                </div>
                <div class="modal-body register" id="registerBody">
                    <div class="row justify-content-center text-center">
                        <div class="col-12">
                            <i class="fas fa-gift text-warning fs-1 my-3"></i>
                            <h2 class="fw-bold main-color"> @lang('header.congrate')</h2>
                            <h5 class="text-muted"> @lang('header.getcopon')</h5>
                            <h4 class="fw-bold">#58768467 </h4>
                            <div class="d-flex justify-content-center py-4">
                                <a href="#" class="btn mx-1 w-100"> @lang('header.copy')</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <section class="inner-header pt-5 mt-5">
        <div class="container pt-sm-5 pt-4">
            <nav style="--bs-breadcrumb-divider: '>';" aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('home') }}">@lang('header.home')</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('orders.show') }}"> @lang('header.myorder')</a></li>
                    <li class="breadcrumb-item active" aria-current="page"> @lang('header.track-order')</li>
                </ol>
            </nav>
        </div>
    </section>

    <section>
        <div class="container py-2">
            <div class="row">
                <div class="col-12">
                    @foreach ($orders as $order)
                        @if ($order->type === 'Delivery')
                            <div class="card mt-2 p-3">
                                <div class="card-header bg-white">
                                    <div class="d-flex justify-content-between">
                                        <h5 class="card-title fw-bold mb-3"> @lang('header.orderstatus')</h5>
                                        <button class="btn reversed main-color d-flex fw-bold" type="button">
                                            @lang('header.cancelorder')
                                        </button>
                                    </div>
                                    @php
                                        $lastTracking = $order->tracking->last();

                                        $orderCreationTime = $order->time;

                                        $fromTime = $orderCreationTime
                                            ? \Carbon\Carbon::parse($orderCreationTime)
                                            : null;
                                        $toTime = $fromTime
                                            ? $fromTime->copy()->addMinutes(getSetting('delivery_time'))
                                            : null;

                                        $estimatedMinutes = $lastTracking?->time;
                                    @endphp

                                    <h6 class="mb-3"> @lang('header.deliverytimeexpect')</h6>
                                    <h5 class="main-color fw-bold mb-3 d-flex flex-wrap">
                                        <span class="to-time">
                                            {{ $fromTime ? $fromTime->format('h:i') : 'N/A' }}
                                            @lang($fromTime && $fromTime->format('A') === 'AM' ? 'header.am' : 'header.pm') -
                                        </span>
                                        <span class="from-time">
                                            {{ $toTime ? $toTime->format('h:i') : 'N/A' }}
                                            @lang($toTime && $toTime->format('A') === 'AM' ? 'header.am' : 'header.pm')
                                        </span>
                                        <span class="p-1 mx-1 bg-warning text-dark rounded">
                                            <small>
                                                {{ getSetting('delivery_time') ? getSetting('delivery_time') . ' ' . __('header.min') : 'N/A' }}
                                            </small>
                                        </span>
                                    </h5>

                                    <h5 class="p-1 bg-warning text-dark rounded d-inline-block">
                                        @lang('header.ordernum') {{ $order->order_number }} #
                                    </h5>
                                </div>

                                <div class="card-body p-0">
                                    <div class="wizard my-3">
                                        <ul class="nav nav-tabs justify-content-between w-100 timeline" id="myTab"
                                            role="tablist">
                                            @php
                                                // Define statuses and icons
                                                $statuses = [
                                                    'pending' => [
                                                        'label' => 'فى انتظار الموافقه',
                                                        'icon' => 'fa-mobile-alt',
                                                    ],
                                                    'in_progress' => [
                                                        'label' => 'يتم تحضير طلبك',
                                                        'icon' => 'fa-utensils',
                                                    ],
                                                    'on_way' => [
                                                        'label' => 'طلبك فى الطريق اليك',
                                                        'icon' => 'fa-map-marker-alt',
                                                    ],
                                                    'completed' => [
                                                        'label' => 'تم التوصيل',
                                                        'icon' => 'fa-check-circle',
                                                    ],
                                                ];

                                                // Fetch the statuses from the tracking table
                                                $trackingStatuses = $order->tracking->pluck('order_status')->toArray();
                                                $currentStatus = last($trackingStatuses);
                                            @endphp

                                            @foreach ($statuses as $key => $status)
                                                @php
                                                    $isCompleted = in_array($key, $trackingStatuses);
                                                    $isActive = $key === $currentStatus;
                                                @endphp
                                                <li class="nav-item" role="presentation">
                                                    <a class="nav-link rounded-circle d-flex align-items-center justify-content-center
                                                    {{ $isActive ? 'active' : '' }}
                                                    {{ $isCompleted && !$isActive ? 'completed' : '' }}
                                                    {{ !$isCompleted && !$isActive ? 'disabled' : '' }}"
                                                        href="javascript:void(0);" id="step{{ $loop->index }}-tab"
                                                        {{ !$isActive ? 'aria-disabled="true"' : '' }} role="tab">
                                                        <i class="fas {{ $status['icon'] }}"></i>
                                                    </a>
                                                    <span class="d-block mt-2">{{ $status['label'] }}</span>
                                                </li>
                                            @endforeach
                                        </ul>

                                    </div>

                                    <div class="bg-dark-gray p-3 my-4">
                                        <h5 class="fw-bold"> @lang('header.ordererevioun')</h5>
                                    </div>
                                    <div class="bg-dark-gray p-3 my-4">
                                        <h5 class="fw-bold"> <i class="fas fa-file-alt main-color fa-xs fs-5 mx-1"></i>
                                            @lang('header.deliveryinfo')
                                        </h5>
                                        @if ($order->address)
                                            <p>
                                                <strong> @lang('header.address') :</strong>
                                                {{ $order->address->address }}
                                            </p>
                                            <p>
                                                <strong>@lang('header.state') :</strong>
                                                {{ $order->address->state }}
                                            </p>
                                            <p>
                                                <strong> @lang('header.extranote') :</strong>
                                                @if ($order->address->building || $order->address->floor_number || $order->address->apartment_number)
                                                    {{ $order->address->building ? ': ' . __('header.bulding') . $order->address->building : '' }}
                                                    {{ $order->address->floor_number ? ': ' . __('header.Floor') . ', ' . $order->address->floor_number : '' }}
                                                    {{ $order->address->apartment_number ? ': ' . __('header.apartment') . ', ' . $order->address->apartment_number : '' }}
                                                @else
                                                    @lang('header.noextrainfo')
                                                @endif
                                            </p>
                                            <p>
                                                <strong>@lang('header.note') :</strong>
                                                {{ $order->address->notes ?? __('header.nonote') }}
                                            </p>
                                            <p>
                                                <strong> @lang('header.phone') :</strong>
                                                {{ $order->address->address_phone ?? __('header.nophone') }}
                                            </p>
                                        @else
                                            <p>@lang('header.noaddress')</p>
                                        @endif
                                        <p><strong> @lang('header.name') :</strong> {{ $order->client?->name }}</p>
                                    </div>
                                    <div class="bg-dark-gray p-3 my-4">
                                        <h5 class="fw-bold"> <i class="fas fa-file-alt main-color fa-xs fs-5 mx-1"></i>
                                            @lang('header.paymentinfo')

                                        </h5>
                                        @if ($order->orderTransactions->isNotEmpty())
                                            @foreach ($order->orderTransactions as $transaction)
                                                <p><strong>
                                                        @lang('header.paymentmethod')
                                                        <strong>
                                                            @switch($transaction->payment_method)
                                                                @case('cash')
                                                                    <span class="p-1 bg-success text-light rounded">
                                                                        @lang('header.cash') </span>
                                                                @break

                                                                @case('credit_card')
                                                                    <span class="p-1 bg-success text-light rounded">
                                                                        @lang('header.credit_card') </span>
                                                                @break

                                                                @case('online')
                                                                    <span class="p-1 bg-success text-light rounded">
                                                                        @lang('header.online') </span>
                                                                @break

                                                                @default
                                                                    <span class="p-1 bg-success text-light rounded">
                                                                        @lang('header.cash') </span>
                                                            @endswitch
                                                </p>
                                            @endforeach
                                        @else
                                            <p>
                                                @lang('header.nopaymentmethod')
                                            </p>
                                        @endif
                                    </div>
                                    <div class="bg-dark-gray p-3 my-4">
                                        <h5 class="fw-bold"> <i class="fas fa-file-alt main-color fa-xs fs-5 mx-1"></i>
                                            @lang('header.orderdetails')
                                        </h5>
                                        @foreach ($order->orderDetails as $detail)
                                            <div class="d-flex justify-content-between align-items-center">
                                                <div>
                                                    <span
                                                        class="p-1 bg-secondary text-light rounded">{{ $detail->quantity }}</span>
                                                    <span class="mx-1">x</span>
                                                    <span>{{ $detail->dish?->name ?? __('header.nodish') }}</span>
                                                    <p class="text-muted mt-1 mb-0 mx-4">
                                                        {{ is_array(getDishRecipeNames($detail->dish?->id, null))
                                                            ? implode(', ', getDishRecipeNames($detail->dish?->id, null))
                                                            : getDishRecipeNames($detail->dish?->id, null) ?? __('header.nodish') }}
                                                        ,
                                                        @foreach ($order->orderAddons as $addon)
                                                            <small>
                                                                {{ $addon->Addon?->addons?->name ?? __('header.noaddons') }}
                                                            </small>
                                                        @endforeach

                                                    </p>
                                                </div>
                                                <p class="mb-0 fw-bold">{{ $detail->total }}
                                                    {{ $order->Branch->country->currency_symbol }}</p>
                                            </div>
                                        @endforeach
                                    </div>

                                    <div class="bg-dark-gray p-3 my-4">
                                        <h5 class="fw-bold"> <i class="fas fa-file-alt main-color fa-xs fs-5 mx-1"></i>
                                            @lang('header.reset')
                                        </h5>
                                        <div class="d-flex justify-content-between">
                                            <p>@lang('header.totalorder')</p>
                                            <p>{{ $order->total_price_befor_tax }}
                                                {{ $order->Branch->country->currency_symbol }} </p>
                                        </div>
                                        @if ($order->coupon_id)
                                            <div class="d-flex justify-content-between">
                                                <p class="main-color"> @lang('header.coupon')</p>
                                                @if ($order->coupon->type === 'percentage')
                                                    <p class="main-color">
                                                        -{{ ($order->total_price_befor_tax * $order->coupon->value) / 100 }}
                                                        {{ $order->Branch->country->currency_symbol }} </p>
                                                @elseif ($order->coupon->type === 'fixed')
                                                    <p class="main-color">
                                                        -{{ $order->coupon->value }}
                                                        {{ $order->Branch->country->currency_symbol }}
                                                    </p>
                                                @endif
                                            </div>
                                        @endif
                                        <div class="d-flex justify-content-between">
                                            <p> @lang('header.feesdelivery')</p>
                                            <p>{{ $order->delivery_fees ?? 0 }}
                                                {{ $order->Branch->country->currency_symbol }} </p>
                                        </div>
                                        <div class="d-flex justify-content-between">
                                            <p> @lang('header.fees') </p>
                                            <p>{{ $order->service_fees ?? 0 }}
                                                {{ $order->Branch->country->currency_symbol }} </p>
                                        </div>
                                        <div class="d-flex justify-content-between border-top pt-2">
                                            <h5 class="fw-bold"> @lang('header.total') </h5>
                                            <h5 class="fw-bold">{{ $order->total_price_after_tax }}
                                                {{ $order->Branch->country->currency_symbol }} </h5>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @elseif ($order->type === 'Takeaway')
                            <div class="card mt-2 p-3">
                                <div class="card-header bg-white">
                                    <div class="d-flex justify-content-between">
                                        <h5 class="card-title fw-bold mb-3"> @lang('header.orderstatus')</h5>
                                        <button class="btn reversed main-color d-flex fw-bold" type="button">
                                            @lang('header.cancelorder')
                                        </button>
                                    </div>
                                    @php
                                        $lastTracking = $order->tracking->last();

                                        $orderCreationTime = $order->created_at;

                                        $fromTime = $orderCreationTime
                                            ? \Carbon\Carbon::parse($orderCreationTime)
                                            : null;
                                        $toTime = $fromTime ? $fromTime->copy()->addMinutes(15) : null;

                                        $estimatedMinutes = $lastTracking?->time;
                                    @endphp

                                    <h6 class="mb-3"> @lang('header.deliverytimeexpect')</h6>
                                    <h5 class="main-color fw-bold mb-3 d-flex flex-wrap">
                                        <span class="to-time">
                                            {{ $fromTime ? $fromTime->format('h:i A') : 'N/A' }} -
                                        </span>
                                        <span class="from-time">
                                            {{ $toTime ? $toTime->format('h:i A') : 'N/A' }}
                                        </span>
                                        <span class="p-1 mx-1 bg-warning text-dark rounded">
                                            <small>
                                                {{ $estimatedMinutes ? $estimatedMinutes . __('header.min') : 'N/A' }}
                                            </small>
                                        </span>
                                    </h5>
                                    <h5 class="p-1 bg-warning text-dark rounded d-inline-block">
                                        @lang('header.ordernum'){{ $order->order_number }}#
                                    </h5>
                                </div>

                                <div class="card-body p-0">
                                    <div class="wizard my-3">
                                        <ul class="nav nav-tabs justify-content-between w-100 timeline" id="myTab"
                                            role="tablist">
                                            @php
                                                $statuses = [
                                                    'pending' => [
                                                        'label' => 'فى انتظار الموافقه',
                                                        'icon' => 'fa-mobile-alt',
                                                    ],
                                                    'in_progress' => [
                                                        'label' => 'يتم تحضير طلبك',
                                                        'icon' => 'fa-utensils',
                                                    ],
                                                    'completed' => [
                                                        'label' => 'جاهز للاستلام',
                                                        'icon' => 'fa-check-circle',
                                                    ],
                                                ];

                                                $trackingStatuses = $order->tracking->pluck('order_status')->toArray();
                                                $currentStatus = last($trackingStatuses);
                                            @endphp

                                            @foreach ($statuses as $key => $status)
                                                @php
                                                    $isCompleted = in_array($key, $trackingStatuses);
                                                    $isActive = $key === $currentStatus;
                                                @endphp
                                                <li class="nav-item" role="presentation">
                                                    <a class="nav-link rounded-circle d-flex align-items-center justify-content-center
                                                {{ $isActive ? 'active' : '' }}
                                                {{ $isCompleted && !$isActive ? 'completed' : '' }}
                                                {{ !$isCompleted && !$isActive ? 'disabled' : '' }}"
                                                        href="javascript:void(0);" id="step{{ $loop->index }}-tab"
                                                        {{ !$isActive ? 'aria-disabled="true"' : '' }} role="tab">
                                                        <i class="fas {{ $status['icon'] }}"></i>
                                                    </a>
                                                    <span class="d-block mt-2">{{ $status['label'] }}</span>
                                                </li>
                                            @endforeach
                                        </ul>

                                    </div>

                                    <div class="bg-dark-gray p-3 my-4">
                                        <h5 class="fw-bold">@lang('header.ordererevioun') </h5>
                                    </div>
                                    <div class="bg-dark-gray p-3 my-4">
                                        <h5 class="fw-bold"> <i class="fas fa-file-alt main-color fa-xs fs-5 mx-1"></i>
                                            @lang('header.resivefrom')
                                        </h5>
                                        <p class="fw-bold mb-0">
                                            <span><i class="fas fa-map-marker-alt ms-2 main-color"></i></span>
                                            {{ $order->branch->address_ar }}
                                        </p>
                                        <p class="text-muted"> {{ $order->branch->name_ar }} </p>
                                    </div>
                                    <div class="bg-dark-gray p-3 my-4">
                                        <h5 class="fw-bold"> <i
                                                class="fas fa-file-alt main-color fa-xs fs-5 mx-1"></i>@lang('header.paymentinfo')

                                        </h5>
                                        @if ($order->orderTransactions->isNotEmpty())
                                            @foreach ($order->orderTransactions as $transaction)
                                                <p><strong>
                                                        @lang('header.paymentmethod')
                                                        <strong>
                                                            @switch($transaction->payment_method)
                                                                @case('cash')
                                                                    <span class="p-1 bg-success text-light rounded">
                                                                        @lang('header.cash') </span>
                                                                @break

                                                                @case('credit_card')
                                                                    <span class="p-1 bg-success text-light rounded">
                                                                        @lang('header.credit_card') </span>
                                                                @break

                                                                @case('online')
                                                                    <span class="p-1 bg-success text-light rounded">
                                                                        @lang('header.online') </span>
                                                                @break

                                                                @default
                                                                    <span class="p-1 bg-success text-light rounded">
                                                                        @lang('header.cash') </span>
                                                            @endswitch
                                                </p>
                                            @endforeach
                                        @else
                                            <p>
                                                @lang('header.nopaymentmethod')
                                            </p>
                                        @endif
                                    </div>
                                    <div class="bg-dark-gray p-3 my-4">
                                        <h5 class="fw-bold"> <i class="fas fa-file-alt main-color fa-xs fs-5 mx-1"></i>
                                            @lang('header.orderdetails')

                                        </h5>
                                        @foreach ($order->orderDetails as $detail)
                                            <div class="d-flex justify-content-between align-items-center">
                                                <div>
                                                    <span
                                                        class="p-1 bg-secondary text-light rounded">{{ $detail->quantity }}</span>
                                                    <span class="mx-1">x</span>
                                                    <span>{{ $detail->dish?->name ?? 'N/A' }}</span>
                                                    <p class="text-muted mt-1 mb-0 mx-4">
                                                        {{ is_array(getDishRecipeNames($detail->dish?->id, null))
                                                            ? implode(', ', getDishRecipeNames($detail->dish?->id, null))
                                                            : getDishRecipeNames($detail->dish?->id, null) ?? __('header.nodish') }}
                                                        ,
                                                        @foreach ($order->orderAddons as $addon)
                                                            <small>
                                                                {{ $addon->Addon?->addons?->name ?? __('header.noaddons') }}
                                                            </small>
                                                        @endforeach
                                                    </p>
                                                </div>
                                                <p class="mb-0 fw-bold">{{ $detail->total }}
                                                    {{ $order->Branch->country->currency_symbol }}</p>
                                            </div>
                                        @endforeach
                                    </div>

                                    <div class="bg-dark-gray p-3 my-4">
                                        <h5 class="fw-bold"> <i class="fas fa-file-alt main-color fa-xs fs-5 mx-1"></i>
                                            @lang('header.reset')

                                        </h5>
                                        <div class="d-flex justify-content-between">
                                            <p>@lang('header.totalorder') </p>
                                            <p>{{ $order->total_price_befor_tax }}
                                                {{ $order->Branch->country->currency_symbol }}</p>
                                        </div>
                                        @if ($order->coupon_id)
                                            <div class="d-flex justify-content-between">
                                                <p class="main-color"> @lang('header.coupon') </p>
                                                @if ($order->coupon->type === 'percentage')
                                                    <p class="main-color">
                                                        -{{ ($order->total_price_befor_tax * $order->coupon->value) / 100 }}
                                                        {{ $order->Branch->country->currency_symbol }} </p>
                                                @elseif ($order->coupon->type === 'fixed')
                                                    <p class="main-color">
                                                        -{{ $order->coupon->value }}
                                                        {{ $order->Branch->country->currency_symbol }}
                                                    </p>
                                                @endif
                                            </div>
                                        @endif
                                        <div class="d-flex justify-content-between">
                                            <p>@lang('header.feesdelivery') </p>
                                            <p>{{ $order->delivery_fees ?? 0 }}
                                                {{ $order->Branch->country->currency_symbol }}</p>
                                        </div>
                                        <div class="d-flex justify-content-between">
                                            <p> @lang('header.fees')</p>
                                            <p>{{ $order->service_fees ?? 0 }}
                                                {{ $order->Branch->country->currency_symbol }}</p>
                                        </div>
                                        <div class="d-flex justify-content-between border-top pt-2">
                                            <h5 class="fw-bold"> @lang('header.total') </h5>
                                            <h5 class="fw-bold">{{ $order->total_price_after_tax }}
                                                {{ $order->Branch->country->currency_symbol }}</h5>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @else
                            <div class="card p-5 w-50 text-center mx-auto mt-5">
                                <img class="noAddress-img"
                                    src="{{ asset('front/AlKout-Resturant/SiteAssets/images----/order.png') }}"
                                    alt="" />
                                <h4 class="my-4 fw-bold">@lang('header.noorders')</h4>
                            </div>
                        @endif
                    @endforeach
                </div>
            </div>
        </div>
    </section>
@endsection
