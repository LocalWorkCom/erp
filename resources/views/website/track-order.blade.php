@extends('website.layouts.master')

@section('content')
    <div class="modal fade" id="exampleModalToggle" aria-hidden="true" aria-labelledby="exampleModalToggleLabel" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-body register" id="registerBody">
                    <div class="row justify-content-center text-center">
                        <div class="col-12">
                            <i class="fas fa-gift text-warning fs-1 my-3"></i>
                            <h2 class="fw-bold main-color">مفاجأة</h2>
                            <h5 class="text-muted">احصل على كوبونات خصم أو توصيل مجاني المرة القادمة</h5>
                            <h3 class="fw-bold text-dark">هل تم توصيل طلبك بنجاح؟</h3>
                            <div class="d-flex justify-content-center py-4">
                                <a href="#" class="btn mx-1 w-50" data-bs-target="#exampleModalToggle2"
                                    data-bs-toggle="modal" data-bs-dismiss="modal">نعم</a>
                                <a href="#" class="btn-no-modal mx-1 w-50" data-bs-dismiss="modal"
                                    aria-label="Close">لا</a>
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
                            <h2 class="fw-bold main-color">مبرووك</h2>
                            <h5 class="text-muted">حصلت على كوبون خصم 10% عند الطلب فى المرة القادمة</h5>
                            <h4 class="fw-bold">#58768467</h4>
                            <div class="d-flex justify-content-center py-4">
                                <a href="#" class="btn mx-1 w-100">نسخ الكوبون</a>
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
                    <li class="breadcrumb-item"><a href="{{ route('home') }}">الرئيسية</a></li>
                    <li class="breadcrumb-item active" aria-current="page">متابعة الطلب</li>
                </ol>
            </nav>
        </div>
    </section>

    <section>
        <div class="container py-2">
            <div class="row">
                <div class="col-12">
                    <div class="card mt-2 p-3">
                        <div class="card-header bg-white">
                            <div class="d-flex justify-content-between">
                                <h5 class="card-title fw-bold mb-3">حالة الطلب الحالية</h5>
                                <button class="btn reversed main-color d-flex fw-bold" type="button">إلغاء الطلب</button>
                            </div>
                            @php
                                // Fetch the last tracking entry
                                $lastTracking = $order->tracking->last();

                                // Get the order creation time
                                $orderCreationTime = $order->created_at; // Original order creation time

                                // Calculate the from-time by adding 15 minutes to the order creation time
                                $fromTime = $orderCreationTime ? \Carbon\Carbon::parse($orderCreationTime) : null;
                                $toTime = $fromTime ? $fromTime->copy()->addMinutes(15) : null;

                                // Admin estimated minutes from the tracking table
                                $estimatedMinutes = $lastTracking?->time;
                            @endphp

                            <h6 class="mb-3">الوقت المتوقع للتوصيل</h6>
                            <h5 class="main-color fw-bold mb-3 d-flex flex-wrap">
                                <span class="to-time">
                                    {{ $fromTime ? $fromTime->format('h:i A') : 'N/A' }} -
                                </span>
                                <span class="from-time">
                                    {{ $toTime ? $toTime->format('h:i A') : 'N/A' }}
                                </span>
                                <span class="p-1 mx-1 bg-warning text-dark rounded">
                                    <small>
                                        {{ $estimatedMinutes ? $estimatedMinutes . ' دقيقة' : 'N/A' }}
                                    </small>
                                </span>
                            </h5>
                            <h5 class="p-1 bg-warning text-dark rounded d-inline-block">
                                رقم الطلب {{ $order->order_number }}#
                            </h5>
                        </div>

                        <div class="card-body p-0">
                            <div class="wizard my-3">
                                <ul class="nav nav-tabs justify-content-between w-100 timeline" id="myTab"
                                    role="tablist">
                                    @php
                                        // Define statuses and icons
                                        $statuses = [
                                            'pending' => ['label' => 'فى انتظار الموافقه', 'icon' => 'fa-mobile-alt'],
                                            'in_progress' => ['label' => 'يتم تحضير طلبك', 'icon' => 'fa-utensils'],
                                            'on_way' => [
                                                'label' => 'طلبك فى الطريق اليك',
                                                'icon' => 'fa-map-marker-alt',
                                            ],
                                            'completed' => ['label' => 'تم التوصيل', 'icon' => 'fa-check-circle'],
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
                                <h5 class="fw-bold">ملخص الطلب</h5>
                            </div>
                            <div class="bg-dark-gray p-3 my-4">
                                <h5 class="fw-bold"> <i class="fas fa-file-alt main-color fa-xs fs-5 mx-1"></i>معلومات
                                    التوصيل</h5>
                                @if ($order->address)
                                    <p>
                                        <strong>العنوان:</strong>
                                        {{ $order->address->address }}
                                    </p>
                                    <p>
                                        <strong>المحافظة:</strong>
                                        {{ $order->address->state }}
                                    </p>
                                    <p>
                                        <strong>تفاصيل إضافية:</strong>
                                        @if ($order->address->building || $order->address->floor_number || $order->address->apartment_number)
                                            {{ $order->address->building ? 'المبنى: ' . $order->address->building : '' }}
                                            {{ $order->address->floor_number ? ', الدور: ' . $order->address->floor_number : '' }}
                                            {{ $order->address->apartment_number ? ', الشقة: ' . $order->address->apartment_number : '' }}
                                        @else
                                            لا يوجد تفاصيل إضافية
                                        @endif
                                    </p>
                                    <p>
                                        <strong>ملاحظات:</strong>
                                        {{ $order->address->notes ?? 'N/A' }}
                                    </p>
                                    <p>
                                        <strong>رقم الهاتف:</strong>
                                        {{ $order->address->address_phone ?? 'N/A' }}
                                    </p>
                                @else
                                    <p>لا يوجد عنوان مسجل.</p>
                                @endif
                                <p><strong>الاسم:</strong> {{ $order->client?->name }}</p>
                            </div>
                            <div class="bg-dark-gray p-3 my-4">
                                <h5 class="fw-bold"> <i class="fas fa-file-alt main-color fa-xs fs-5 mx-1"></i>معلومات الدفع
                                </h5>
                                @if ($order->orderTransactions->isNotEmpty())
                                    @foreach ($order->orderTransactions as $transaction)
                                        <p><strong>طريقة الدفع:</strong>
                                            @switch($transaction->payment_method)
                                                @case('cash')
                                                    الدفع نقدًا
                                                @break

                                                @case('credit_card')
                                                    الدفع ببطاقة الائتمان
                                                @break

                                                @case('online')
                                                    الدفع عبر الإنترنت
                                                @break

                                                @default
                                                    طريقة دفع غير معروفة
                                            @endswitch
                                        </p>
                                    @endforeach
                                @else
                                    <p>لم يتم تسجيل أي معاملات دفع.</p>
                                @endif
                            </div>
                            <div class="bg-dark-gray p-3 my-4">
                                <h5 class="fw-bold"> <i class="fas fa-file-alt main-color fa-xs fs-5 mx-1"></i>تفاصيل الطلب
                                </h5>
                                @foreach ($order->orderDetails as $detail)
                                    <div class="d-flex justify-content-between align-items-center">
                                        <div>
                                            <span
                                                class="p-1 bg-secondary text-light rounded">{{ $detail->quantity }}</span>
                                            <span class="mx-1">x</span>
                                            <span>{{ $detail->dish?->name ?? 'N/A' }}</span>
                                            <p class="text-muted mt-1 mb-0 mx-4">
                                                <small>{{ $detail->addons?->pluck('name')->join(', ') ?? 'No Addons' }}</small>
                                            </p>
                                        </div>
                                        <p class="mb-0 fw-bold">{{ $detail->total }} ج.م</p>
                                    </div>
                                @endforeach
                            </div>

                            <div class="bg-dark-gray p-3 my-4">
                                <h5 class="fw-bold"> <i class="fas fa-file-alt main-color fa-xs fs-5 mx-1"></i>الفاتورة
                                </h5>
                                <div class="d-flex justify-content-between">
                                    <p>مجموع طلبي</p>
                                    <p>{{ $order->total_price_befor_tax }} ج.م</p>
                                </div>
                                <div class="d-flex justify-content-between">
                                    <p>رسوم التوصيل</p>
                                    <p>{{ $order->delivery_fees }} ج.م</p>
                                </div>
                                <div class="d-flex justify-content-between border-top pt-2">
                                    <h5 class="fw-bold">المجموع الكلي</h5>
                                    <h5 class="fw-bold">{{ $order->total_price_after_tax }} ج.م</h5>
                                </div>
                            </div>
                        </div> <!-- End of Card Body -->
                    </div> <!-- End of Card -->
                </div> <!-- End of Col-12 -->
            </div> <!-- End of Row -->
        </div> <!-- End of Container -->
    </section>
@endsection
