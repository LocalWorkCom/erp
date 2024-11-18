@if (count($breadcrumb) > 0)
    <div class="mb-3 overflow-hidden position-relative">
        <div class="px-3">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb mb-0">
                    @php
                        $count = 0;
                    @endphp

                    @foreach ($breadcrumb as $row)
                        <li class="breadcrumb-item"><a href="{{ $row['url'] }}">{{ $row['title'] }}</a></li>
                    @endforeach

                </ol>
            </nav>
        </div>
    </div>

@endif
