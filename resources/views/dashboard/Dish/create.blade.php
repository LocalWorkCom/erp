@extends('layouts.master')

@section('styles')
    <!-- SELECT2 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet">
@endsection

@section('content')
    <div class="d-sm-flex d-block align-items-center justify-content-between page-header-breadcrumb">
        <h4 class="fw-medium mb-0">@lang('dishes.CreateDish')</h4>
        <div class="ms-sm-1 ms-0">
            <nav>
                <ol class="breadcrumb mb-0">
                    <li class="breadcrumb-item"><a href="{{ route('dashboard.dishes.index') }}">@lang('dishes.Dishes')</a></li>
                    <li class="breadcrumb-item active" aria-current="page">@lang('dishes.CreateDish')</li>
                </ol>
            </nav>
        </div>
    </div>

    <div class="main-content app-content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-xl-12">
                    <div class="card custom-card">
                        <div class="card-header">
                            <div class="card-title">@lang('dishes.CreateDish')</div>
                        </div>
                        <div class="card-body">
                            @if ($errors->any())
                                @foreach ($errors->all() as $error)
                                    <div class="alert alert-solid-danger alert-dismissible fade show">
                                        {{ $error }}
                                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                                    </div>
                                @endforeach
                            @endif

                            <form method="POST" action="{{ route('dashboard.dishes.store') }}" enctype="multipart/form-data">
                                @csrf
                                <div class="row gy-4">
                                    <!-- Main Dish Info -->
                                    <div class="col-xl-6">
                                        <label for="name_ar" class="form-label">@lang('dishes.NameArabic')</label>
                                        <input type="text" class="form-control" id="name_ar" name="name_ar" required>
                                    </div>

                                    <div class="col-xl-6">
                                        <label for="name_en" class="form-label">@lang('dishes.NameEnglish')</label>
                                        <input type="text" class="form-control" id="name_en" name="name_en" required>
                                    </div>

                                    <div class="col-xl-6">
                                        <label for="description_ar" class="form-label">@lang('dishes.DescriptionArabic')</label>
                                        <textarea class="form-control" id="description_ar" name="description_ar"></textarea>
                                    </div>

                                    <div class="col-xl-6">
                                        <label for="description_en" class="form-label">@lang('dishes.DescriptionEnglish')</label>
                                        <textarea class="form-control" id="description_en" name="description_en"></textarea>
                                    </div>

                                    <div class="col-xl-6">
                                        <label for="category_id" class="form-label">@lang('dishes.Category')</label>
                                        <select name="category_id" class="form-control select2" required>
                                            @foreach ($categories as $category)
                                                <option value="{{ $category->id }}">{{ $category->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>

                                    <div class="col-xl-6">
                                        <label for="cuisine_id" class="form-label">@lang('dishes.Cuisine')</label>
                                        <select name="cuisine_id" class="form-control select2" required>
                                            @foreach ($cuisines as $cuisine)
                                                <option value="{{ $cuisine->id }}">{{ $cuisine->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>

                                    <div class="col-xl-6" id="price-section">
                                        <label for="price" class="form-label">@lang('dishes.Price')</label>
                                        <input type="number" class="form-control" id="price" name="price" step="0.01">
                                    </div>

                                    <div class="col-xl-6">
                                        <label for="image" class="form-label">@lang('dishes.Image')</label>
                                        <input type="file" class="form-control" id="image" name="image">
                                    </div>

                                    <div class="col-xl-6">
                                        <label for="has_sizes" class="form-label">@lang('dishes.HasSizes')</label>
                                        <select name="has_sizes" id="has_sizes" class="form-control select2" required>
                                            <option value="0">@lang('dishes.No')</option>
                                            <option value="1">@lang('dishes.Yes')</option>
                                        </select>
                                    </div>
                                    <div class="col-xl-6">
                                    <label for="has_addon" class="form-label">@lang('dishes.HasAddon')</label>
                                    <select name="has_addon" id="has_addon" class="form-control select2" required>
                                        <option value="0">@lang('dishes.No')</option>
                                        <option value="1">@lang('dishes.Yes')</option>
                                    </select>
                                </div>

                                    <div class="col-xl-6">
                                        <label for="is_active" class="form-label">@lang('dishes.IsActive')</label>
                                        <select name="is_active" id="is_active" class="form-control select2" required>
                                            <option value="1">@lang('dishes.Active')</option>
                                            <option value="0">@lang('dishes.Inactive')</option>
                                        </select>
                                    </div>

                                    <!-- Dish Sizes -->
                                    <div id="dish-sizes-section" class="col-xl-12 d-none">
                                        <h5 class="mb-3">@lang('dishes.DishSizes')</h5>
                                        <table class="table table-bordered">
                                            <thead>
                                                <tr>
                                                    <th>@lang('dishes.SizeNameArabic')</th>
                                                    <th>@lang('dishes.SizeNameEnglish')</th>
                                                    <th>@lang('dishes.Price')</th>
                                                    <th>@lang('dishes.Recipes')</th>
                                                    <th>@lang('dishes.DefaultSize')</th>
                                                    <th>@lang('dishes.Actions')</th>
                                                </tr>
                                            </thead>
                                            <tbody id="dish-sizes-table">
                                                <!-- Dynamic Rows -->
                                            </tbody>
                                        </table>
                                        <button type="button" id="add-dish-size" class="btn btn-success btn-sm">@lang('dishes.AddSize')</button>
                                    </div>

                                    <!-- Dish Addons -->
                                    <div class="col-xl-12">
                                      
                                            <div id="addon-categories-section" class="d-none">
                                            <h5 class="mb-3">@lang('dishes.DishAddons')</h5>
                                            <div class="addon-category mt-4">
                                                <div class="row gy-2">
                                                    <div class="col-xl-4">
                                                        <label for="addon_category" class="form-label">@lang('dishes.AddonCategory')</label>
                                                        <select name="addon_categories[${addonCategoryIndex}][addon_category_id]" class="form-control select2 addon-category" required>
                                                            @foreach ($addonCategories as $category)
                                                                <option value="{{ $category->id }}">{{ $category->name }}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                    <div class="col-xl-4">
                                                        <label for="min_addons" class="form-label">@lang('dishes.MinAddons')</label>
                                                        <input type="number" name="addon_categories[${addonCategoryIndex}][min_addons]" class="form-control" min="0" required>
                                                    </div>
                                                    <div class="col-xl-4">
                                                        <label for="max_addons" class="form-label">@lang('dishes.MaxAddons')</label>
                                                        <input type="number" name="addon_categories[${addonCategoryIndex}][max_addons]" class="form-control" min="0">
                                                    </div>
                                                </div>
                                                <div class="mt-3">
                                                    <table class="table table-bordered">
                                                        <thead>
                                                            <tr>
                                                                <th>@lang('dishes.Addon')</th>
                                                                <th>@lang('dishes.Quantity')</th>
                                                                <th>@lang('dishes.Price')</th>
                                                                <th>@lang('dishes.Actions')</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody id="addons-table-${addonCategoryIndex}">
                                                            <!-- Dynamic Rows -->
                                                        </tbody>
                                                    </table>
                                                    <button type="button" class="btn btn-success btn-sm add-addon" data-category-index="${addonCategoryIndex}">@lang('dishes.AddAddon')</button>
                                                </div>
                                                <button type="button" class="btn btn-danger btn-sm mt-3 remove-addon-category">@lang('dishes.RemoveAddonCategory')</button>
                                            </div>

                                           
                                            <button type="button" class="btn btn-primary btn-sm mt-3 add-addon-category">@lang('dishes.AddAddonCategory')</button>
                                        </div>
                                        </div>

                                    <!-- Submit -->
                                    <div class="col-xl-12">
                                        <button type="submit" class="btn btn-primary">@lang('dishes.Save')</button>
                                    </div>
                                </div>
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
$(document).ready(function () {
    $('.select2').select2();

    // Toggle sizes section
    $('#has_sizes').on('change', function () {
        if ($(this).val() == 1) {
            $('#dish-sizes-section').removeClass('d-none');
        } else {
            $('#dish-sizes-section').addClass('d-none');
        }
    });
    $('#has_sizes').on('change', function () {
    if ($(this).val() == 1) {
        $('#dish-sizes-section').removeClass('d-none');

        $('#price-section').addClass('d-none');
        $('#price').val(''); 
    } else {
        $('#dish-sizes-section').addClass('d-none');

        $('#price-section').removeClass('d-none');
    }
});
    // Dish Sizes
    let sizeIndex = 0;
    $('#add-dish-size').on('click', function () {
        $('#dish-sizes-table').append(`
        <tr>
    <td><input type="text" name="sizes[${sizeIndex}][size_name_ar]" class="form-control" required></td>
    <td><input type="text" name="sizes[${sizeIndex}][size_name_en]" class="form-control" required></td>
    <td><input type="number" name="sizes[${sizeIndex}][price]" class="form-control" step="0.01" required></td>
    <td>
        <table class="table">
            <thead>
                <tr>
                    <th>@lang('dishes.Recipe')</th>
                    <th>@lang('dishes.Quantity')</th>
                    <th>@lang('dishes.Actions')</th>
                </tr>
            </thead>
            <tbody id="recipes-table-${sizeIndex}">
                <tr>
                    <td>
                        <select name="sizes[${sizeIndex}][recipes][0][recipe_id]" class="form-control select2" required>
                            @foreach ($recipes as $recipe)
                                <option value="{{ $recipe->id }}">{{ $recipe->name }}</option>
                            @endforeach
                        </select>
                    </td>
                    <td><input type="number" name="sizes[${sizeIndex}][recipes][0][quantity]" class="form-control" step="0.01" required></td>
                    <td><button type="button" class="btn btn-danger btn-sm remove-row">@lang('dishes.Remove')</button></td>
                </tr>
            </tbody>
        </table>
        <button type="button" class="btn btn-sm btn-success add-recipe" data-size-index="${sizeIndex}">@lang('dishes.AddRecipe')</button>
    </td>
    <td><input type="radio" name="default_size" value="${sizeIndex}" class="form-check-input"></td>
    <td><button type="button" class="btn btn-danger btn-sm remove-row">@lang('dishes.Remove')</button></td>
</tr>
        `);
        sizeIndex++;
        $('.select2').select2();
    });

    // Dish Addons
    let addonCategoryIndex = 0;

// Add Addon Category
// Add Addon Category
$('.add-addon-category').on('click', function () {
    addonCategoryIndex++;
    $('#addon-categories-section').append(`
        <div class="addon-category mt-4">
            <div class="row gy-2">
                <div class="col-xl-4">
                    <label for="addon_category" class="form-label">@lang('dishes.AddonCategory')</label>
                    <select name="addon_categories[${addonCategoryIndex}][addon_category_id]" class="form-control select2 addon-category" required>
                        @foreach ($addonCategories as $category)
                            <option value="{{ $category->id }}">{{ $category->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-xl-4">
                    <label for="min_addons" class="form-label">@lang('dishes.MinAddons')</label>
                    <input type="number" name="addon_categories[${addonCategoryIndex}][min_addons]" class="form-control" min="0" required>
                </div>
                <div class="col-xl-4">
                    <label for="max_addons" class="form-label">@lang('dishes.MaxAddons')</label>
                    <input type="number" name="addon_categories[${addonCategoryIndex}][max_addons]" class="form-control" min="0">
                </div>
            </div>
            <div class="mt-3">
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>@lang('dishes.Addon')</th>
                            <th>@lang('dishes.Quantity')</th>
                            <th>@lang('dishes.Price')</th>
                            <th>@lang('dishes.Actions')</th>
                        </tr>
                    </thead>
                    <tbody id="addons-table-${addonCategoryIndex}">
                        <!-- Dynamic Rows -->
                    </tbody>
                </table>
                <button type="button" class="btn btn-success btn-sm add-addon" data-category-index="${addonCategoryIndex}">@lang('dishes.AddAddon')</button>
            </div>
            <button type="button" class="btn btn-danger btn-sm mt-3 remove-addon-category">@lang('dishes.RemoveAddonCategory')</button>
        </div>
    `);
    $('.select2').select2();
});
// Add Addon Row
$(document).on('click', '.add-addon', function () {
        let categoryIndex = $(this).data('category-index');
        let addonIndex = $(`#addons-table-${categoryIndex} tr`).length;

        $(`#addons-table-${categoryIndex}`).append(`
            <tr>
                <td>
                    <select name="addon_categories[${categoryIndex}][addons][${addonIndex}][addon_id]" class="form-control select2" required>
                        @foreach ($addons as $addon)
                            <option value="{{ $addon->id }}">{{ $addon->name }}</option>
                        @endforeach
                    </select>
                </td>
                <td><input type="number" name="addon_categories[${categoryIndex}][addons][${addonIndex}][quantity]" class="form-control" step="0.01" required></td>
                <td><input type="number" name="addon_categories[${categoryIndex}][addons][${addonIndex}][price]" class="form-control" step="0.01" required></td>
                <td><button type="button" class="btn btn-danger btn-sm remove-row">@lang('dishes.Remove')</button></td>
            </tr>
        `);
        $('.select2').select2();
    });


    // Remove Row
    $(document).on('click', '.remove-row', function () {
        $(this).closest('tr').remove();
    });
    $(document).on('change', 'input[name="default_size"]', function () {
        $('input[name="default_size"]').not(this).prop('checked', false);
    });
    $(document).on('click', '.add-recipe', function () {
    let sizeIndex = $(this).data('size-index');
    let recipeIndex = $(`#recipes-table-${sizeIndex} tr`).length;

    $(`#recipes-table-${sizeIndex}`).append(`
        <tr>
            <td>
                <select name="sizes[${sizeIndex}][recipes][${recipeIndex}][recipe_id]" class="form-control select2" required>
                    @foreach ($recipes as $recipe)
                        <option value="{{ $recipe->id }}">{{ $recipe->name }}</option>
                    @endforeach
                </select>
            </td>
            <td><input type="number" name="sizes[${sizeIndex}][recipes][${recipeIndex}][quantity]" class="form-control" step="0.01" required></td>
            <td><button type="button" class="btn btn-danger btn-sm remove-row">@lang('dishes.Remove')</button></td>
        </tr>
    `);

    $('.select2').select2();
});
$(document).on('change', 'input[name$="[min_addons]"], input[name$="[max_addons]"]', function () {
    let $row = $(this).closest('.row');
    let minAddons = parseInt($row.find('input[name$="[min_addons]"]').val()) || 0;
    let maxAddons = parseInt($row.find('input[name$="[max_addons]"]').val()) || 0;

    if (minAddons > maxAddons) {
        alert(messages.minMaxValidation);
        $(this).val('');
    }
});
$(document).on('click', '.remove-addon-category', function () {
    $(this).closest('.addon-category').remove();
});

$('#has_addon').on('change', function () {
    if ($(this).val() == 1) {
        $('#addon-categories-section').removeClass('d-none');
    } else {
        $('#addon-categories-section').addClass('d-none');
    }
});
});
</script>
@endsection
