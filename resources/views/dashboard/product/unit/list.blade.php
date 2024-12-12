@extends('layouts.master')

@section('styles')
    <!-- DATA-TABLES CSS -->
    <link rel="stylesheet" href="https://cdn.datatables.net/1.12.1/css/dataTables.bootstrap5.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/responsive/2.3.0/css/responsive.bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.2.3/css/buttons.bootstrap5.min.css">
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet">
@endsection

@section('content')
<div class="d-sm-flex d-block align-items-center justify-content-between page-header-breadcrumb">
    <h4 class="fw-medium mb-0">@lang('product.Products')</h4>
    <div class="ms-sm-1 ms-0">
        <nav>
            <ol class="breadcrumb mb-0">
                <li class="breadcrumb-item">
                    <a href="{{ route('dashboard.home') }}">@lang('sidebar.Main')</a>
                </li>
                <li class="breadcrumb-item active" aria-current="page">
                    <a href="javascript:void(0);" onclick="window.location.href='{{ route('products.list') }}'">@lang('product.Products')</a>
                </li>
            </ol>
        </nav>
    </div>
</div>

<div class="main-content app-content">
    <div class="container-fluid">
        <!-- Product Units Form -->
        <div class="row">
            <div class="col-xl-12">
                <div class="card custom-card">
                    <div class="card-header">
                        <div class="card-title">@lang('product.Product Units')</div>
                    </div>
                    <div class="card-body">
                        <form action="{{ route('product.units.save', $product->id) }}" method="POST">
                            @csrf
                            <div class="col-xl-12">
                                <table class="table table-bordered">
                                    <thead>
                                        <tr>
                                            <th>@lang('product.Unit')</th>
                                            <th>@lang('product.Factor')</th>
                                            <th>@lang('product.Actions')</th>
                                        </tr>
                                    </thead>
                                    <tbody id="units-table">
                                        @foreach ($product->productUnits as $index => $productUnit)
                                            <tr>
                                                <td>
                                                    <select name="units[{{ $index }}][unit_id]" class="form-control" required>
                                                        <option value="">Select Unit</option>
                                                        @foreach($units as $unit)
                                                            <option value="{{ $unit->id }}" 
                                                                @if($productUnit->unit_id == $unit->id) selected @endif>
                                                                {{ $unit->name_ar }}
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                </td>
                                                <td>
                                                    <input type="number" name="units[{{ $index }}][factor]" class="form-control" value="{{ $productUnit->factor }}" required>
                                                </td>
                                                <td>
                                                    <button type="button" class="btn btn-danger btn-sm remove-unit">@lang('product.Remove')</button>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                            <button type="button" id="add-unit" class="btn btn-success btn-sm">@lang('product.Add Unit')</button>

                            <button type="submit" class="btn btn-primary mt-3">@lang('product.Save')</button>
                        </form>
                        
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<script>
    $(document).ready(function() {
        $('.select2').select2();
        let unitIndex = 1;

        // Add Unit Row
        $('#add-unit').on('click', function() {
            $('#units-table').append(`
                <tr>
                    <td>
                        <select name="units[${unitIndex}][unit_id]" class="form-control select2" required>
                            @foreach ($units as $unit)
                                <option value="{{ $unit->id }}">{{ $unit->name_ar }}</option>
                            @endforeach
                        </select>
                    </td>
                    <td>
                        <input type="number" name="units[${unitIndex}][factor]" class="form-control" required>
                    </td>
                    <td>
                        <button type="button" class="btn btn-danger btn-sm remove-unit">@lang('product.Remove')</button>
                    </td>
                </tr>
            `);
            unitIndex++;
            $('.select2').select2();
        });

        // Remove Unit Row
        $(document).on('click', '.remove-unit', function() {
            // Check if the row represents an existing unit
            if ($(this).data('unit-id')) {
                const unitId = $(this).data('unit-id');

                // Send an AJAX request to soft delete the unit
                if (confirm('@lang("Are you sure you want to remove this unit?")')) {
                    $.ajax({
                        url: `/units/remove/${unitId}`, // Update with your correct route
                        type: 'DELETE',
                        data: {
                            _token: '{{ csrf_token() }}',
                        },
                        success: function(response) {
                            if (response.status) {
                                alert(response.message);
                                // Remove the row from the table
                                $(`tr[data-unit-id="${unitId}"]`).remove();
                            } else {
                                alert('@lang("Failed to remove unit.")');
                            }
                        },
                        error: function() {
                            alert('@lang("An error occurred.")');
                        }
                    });
                }
            } else {
                // For new rows, simply remove them from the DOM
                $(this).closest('tr').remove();
            }
        });
    });
</script>


<!-- DATA-TABLES CDN -->
<script src="https://cdn.datatables.net/1.12.1/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.12.1/js/dataTables.bootstrap5.min.js"></script>
<script src="https://cdn.datatables.net/responsive/2.3.0/js/dataTables.responsive.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.2.3/js/dataTables.buttons.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.2.3/js/buttons.print.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.2.6/pdfmake.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
<script src="https://cdn.datatables.net/buttons/2.2.3/js/buttons.html5.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.10.1/jszip.min.js"></script>
@endsection
