@extends('website.layouts.master')

@section('content')
    <section class="inner-header pt-5 mt-5">
        <div class="container pt-sm-5 pt-4">
            <nav style="--bs-breadcrumb-divider: '>';" aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="index.html">الرئيسية</a></li>
                    <li class="breadcrumb-item active" aria-current="page"> طلباتى</li>
                </ol>
            </nav>
        </div>
    </section>
    <section class="my-orders">
        <div class="container py-2">
            <h4 class="fw-bold "> طلباتى</h4>
            <div class="card p-4">
                <h5>
                    <i class="fas fa-file-alt main-color fa-xs"></i>
                    مجموع طلباتى
                </h5>
                @forelse ($orders as $order)
                    <div class="card-body border-bottom">
                        <div class="d-flex justify-content-between pt-3">
                            <h5 class="fw-bold m-0">
                                {{ $order->created_at->translatedFormat('j F .g:i A') }}
                            </h5>
                            @if ($order->status == 'completed')
                                <p class="bg-warning text-dark rounded fw-bold p-1 mb-0">تم الاستلام</p>
                            @else
                                <p class="bg-danger text-dark rounded fw-bold p-1 mb-0">ملغي </p>
                            @endif
                        </div>
                        <small class="text-muted py-1">رمز الطلب: {{ $order->order_number }}</small>
                        @foreach ($order->orderDetails as $detail)
                            <p class="mb-0 py-1">
                                <span class="p-1 bg-secondary text-light rounded">{{ $detail->quantity }}</span>
                                <span class="mx-1">x</span>
                                <span>{{ $detail->dish?->name ?? 'N/A' }}</span>
                            </p>
                            <p class="text-muted mt-1 mb-0 mx-4">
                                <small>{{ $detail->addons?->pluck('name')->join(', ') ?? 'No Addons' }}</small>
                            </p>
                            <p class="fw-bold mb-0 py-1">{{ $order->total_price_after_tax }} ج.م</p>
                        @endforeach
                        <a href="#" class="text-decoration-underline py-1 fw-bold">تفاصيل الدفع </a>
                    </div>
                @empty
                    <p class="text-center">لا يوجد طلبات سابقة.</p>
                @endforelse
            </div>
        </div>
    </section>
    <section class="before-footer"></section>
@endsection
