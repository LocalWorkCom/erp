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
                        <a href="javascript:void(0);"
                            onclick="window.location.href='{{ route('products.list') }}'">@lang('product.Products')</a>
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
                            <div class="card-title">@lang('product.Product Colors')</div>
                        </div>
                        <div class="card-body">
                            @if ($errors->any())
                                @foreach ($errors->all() as $error)
                                    <div class="alert alert-solid-danger alert-dismissible fade show">
                                        {{ $error }}
                                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close">
                                            <i class="bi bi-x"></i>
                                        </button>
                                    </div>
                                @endforeach
                            @endif
                            <form action="{{ route('product.units.save', $product->id) }}" method="POST">
                                @csrf
                                <div class="col-xl-12">
                                    <table class="table table-bordered">
                                        <thead>
                                            <tr>
                                                <th>@lang('product.Color')</th>
                                                <th>@lang('product.Actions')</th>
                                            </tr>
                                        </thead>
                                        <tbody id="Colors-table" data-color-count="{{ count($product->productColors) }}">
                                            @foreach ($product->productColors as $index => $productColor)
                                                <tr>
                                                    <td>
                                                        <select name="colors[{{ $index }}][color_id]"
                                                            class="form-control" required>
                                                            <option value="">Select Color</option>
                                                            @foreach ($Colors as $color)
                                                                <option value="{{ $color->id }}"
                                                                    @if ($productColor->color_id == $color->id) selected @endif>
                                                                    {{ $color->name_ar }}
                                                                </option>
                                                            @endforeach
                                                        </select>
                                                    </td>
                                                    {{-- <td>
                                                        <input type="hidden" name="product_unit_id[]"
                                                            value="{{ $productUnit->id }}">
                                                        <input type="number" name="Colors[{{ $index }}][factor]"
                                                            class="form-control" value="{{ $productUnit->factor }}"
                                                            required>
                                                    </td> --}}
                                                    <td>
                                                        <button type="button" class="btn btn-danger btn-sm remove-unit"
                                                            data-unit-id="{{ $unit->pivot->unit_id ?? 'No Color ID' }}"
                                                            data-product-id="{{ $product->id }}">
                                                            @lang('product.Remove')
                                                        </button>

                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                                <button type="button" id="add-color"
                                    class="btn btn-success btn-sm">@lang('product.Add Color')</button>

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
        function confirmDelete() {
            return confirm("@lang('validation.DeleteConfirm')");
        }
        $(document).ready(function() {
            $('.select2').select2();

            // Initialize the color index
            let colorIndex = $('#Colors-table').data('color-count') || 0;

            // Function to add a new color row
            function addColorRow() {
                const rowHtml = `
        <tr>
            <td>
                <select name="colors[${colorIndex}][color_id]" class="form-control select2" required>
                    @foreach ($colors as $color)
                        <option value="{{ $color->id }}">{{ $color->name_ar }}</option>
                    @endforeach
                </select>
            </td>
            <td>
                <button type="button" class="btn btn-danger btn-sm remove-color">
                    @lang('product.Remove')
                </button>
            </td>
        </tr>`;
                $('#Colors-table').append(rowHtml);
                $('.select2').select2();
                colorIndex++;
            }

            // Add color on button click
            $('#add-color').on('click', function() {
                addColorRow();
            });

            // Remove color and re-index rows
            $(document).on('click', '.remove-color', function() {
                $(this).closest('tr').remove();
                $('#Colors-table tr').each(function(index) {
                    $(this).find('select, input').each(function() {
                        let name = $(this).attr('name');
                        if (name) {
                            $(this).attr('name', name.replace(/\[\d+\]/, `[${index}]`));
                        }
                    });
                });
                colorIndex = $('#Colors-table tr').length;
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
