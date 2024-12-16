@extends('layouts.master')

@section('styles')
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet">
@endsection

@section('content')
    <div class="d-sm-flex d-block align-items-center justify-content-between page-header-breadcrumb">
        <h4 class="fw-medium mb-0">@lang('recipes.EditRecipe')</h4>
        <div class="ms-sm-1 ms-0">
            <nav>
                <ol class="breadcrumb mb-0">
                    <li class="breadcrumb-item"><a href="{{ route('dashboard.recipes.index') }}">@lang('recipes.Recipes')</a></li>
                    <li class="breadcrumb-item active" aria-current="page">@lang('recipes.EditRecipe')</li>
                </ol>
            </nav>
        </div>
    </div>

    <!-- APP-CONTENT START -->
    <div class="main-content app-content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-xl-12">
                    <div class="card custom-card">
                        <div class="card-header">
                            <div class="card-title">@lang('recipes.EditRecipe')</div>
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

                            <form method="POST" action="{{ route('dashboard.recipes.update', $recipe->id) }}" enctype="multipart/form-data">
                                @csrf
                                @method('PUT')
                                <div class="row gy-4">
                                    <div class="col-xl-6 col-lg-8 col-md-8 col-sm-12">
                                        <label for="name_ar" class="form-label">@lang('recipes.NameArabic')</label>
                                        <input type="text" class="form-control" id="name_ar" name="name_ar" value="{{ old('name_ar', $recipe->name_ar) }}" required>
                                    </div>

                                    <div class="col-xl-6 col-lg-8 col-md-8 col-sm-12">
                                        <label for="name_en" class="form-label">@lang('recipes.NameEnglish')</label>
                                        <input type="text" class="form-control" id="name_en" name="name_en" value="{{ old('name_en', $recipe->name_en) }}" required>
                                    </div>

                                    <div class="col-xl-6">
                                        <label for="description_ar" class="form-label">@lang('recipes.DescriptionArabic')</label>
                                        <textarea class="form-control" id="description_ar" name="description_ar">{{ old('description_ar', $recipe->description_ar) }}</textarea>
                                    </div>

                                    <div class="col-xl-6">
                                        <label for="description_en" class="form-label">@lang('recipes.DescriptionEnglish')</label>
                                        <textarea class="form-control" id="description_en" name="description_en">{{ old('description_en', $recipe->description_en) }}</textarea>
                                    </div>

                                    <div class="col-xl-6">
                                        <label for="type" class="form-label">@lang('recipes.Type')</label>
                                        <select class="form-control select2" name="type" required>
                                            <option value="1" {{ $recipe->type == 1 ? 'selected' : '' }}>@lang('recipes.MainDish')</option>
                                            <option value="2" {{ $recipe->type == 2 ? 'selected' : '' }}>@lang('recipes.Drink')</option>
                                        </select>
                                    </div>

                                    <!-- <div class="col-xl-6">
                                        <label for="price" class="form-label">@lang('recipes.Price')</label>
                                        <input type="number" class="form-control" id="price" name="price" value="{{ old('price', $recipe->price) }}" min="0" step="0.01" required>
                                    </div> -->

                                    <div class="col-xl-12">
                                        <label for="ingredients" class="form-label">@lang('recipes.Ingredients')</label>
                                        <table class="table table-bordered">
                                            <thead>
                                                <tr>
                                                    <th>@lang('recipes.Product')</th>
                                                    <th>@lang('recipes.Quantity')</th>
                                                    <th>@lang('recipes.LossPercent')</th>
                                                    <th>@lang('recipes.Actions')</th>
                                                </tr>
                                            </thead>
                                            <tbody id="ingredients-table">
                                                @foreach ($recipe->ingredients as $index => $ingredient)
                                                    <tr>
                                                        <td>
                                                            <select name="ingredients[{{ $index }}][product_id]" class="form-control select2" required>
                                                                @foreach ($products as $product)
                                                                    <option value="{{ $product->id }}" {{ $product->id == $ingredient->product_id ? 'selected' : '' }}>{{ $product->name }}</option>
                                                                @endforeach
                                                            </select>
                                                        </td>
                                                        <td>
                                                            <input type="number" name="ingredients[{{ $index }}][quantity]" class="form-control" value="{{ $ingredient->quantity }}" min="0" step="0.01" required>
                                                        </td>
                                                        <td>
                                                            <input type="number" name="ingredients[{{ $index }}][loss_percent]" class="form-control" value="{{ $ingredient->loss_percent }}" min="0" max="100" step="0.01">
                                                        </td>
                                                        <td>
                                                            <button type="button" class="btn btn-danger btn-sm remove-ingredient">@lang('recipes.Remove')</button>
                                                        </td>
                                                    </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                        <button type="button" id="add-ingredient" class="btn btn-success btn-sm">@lang('recipes.AddIngredient')</button>
                                    </div>

                                    <div class="col-xl-12">
                                        <label for="images" class="form-label">@lang('recipes.Images')</label>
                                        @if ($recipe->images && $recipe->images->isNotEmpty())
                                            @foreach ($recipe->images as $image)
                                                <div class="mb-3">
                                                    <img src="{{ asset($image->image_path) }}" alt="Recipe Image" width="150" height="150">
                                                </div>
                                            @endforeach
                                        @else
                                            <p class="form-text">@lang('recipes.NoImages')</p>
                                        @endif
                                        <input class="form-control" type="file" id="images" name="images[]" multiple>
                                    </div>

                                    <div class="col-xl-6">
                                        <label for="is_active" class="form-label">@lang('recipes.IsActive')</label>
                                        <div>
                                            <input type="radio" name="is_active" value="1" {{ $recipe->is_active ? 'checked' : '' }}> @lang('recipes.Yes')
                                            <input type="radio" name="is_active" value="0" {{ !$recipe->is_active ? 'checked' : '' }}> @lang('recipes.No')
                                        </div>
                                    </div>

                                    <div class="col-xl-12">
                                        <input type="submit" class="btn btn-primary" value="@lang('recipes.Save')">
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
            let ingredientIndex = {{ $recipe->ingredients->count() }};

            $('#add-ingredient').on('click', function () {
                $('#ingredients-table').append(`
                    <tr>
                        <td>
                            <select name="ingredients[${ingredientIndex}][product_id]" class="form-control select2" required>
                                @foreach ($products as $product)
                                    <option value="{{ $product->id }}">{{ $product->name }}</option>
                                @endforeach
                            </select>
                        </td>
                        <td>
                            <input type="number" name="ingredients[${ingredientIndex}][quantity]" class="form-control" min="0" step="0.01" required>
                        </td>
                        <td>
                            <input type="number" name="ingredients[${ingredientIndex}][loss_percent]" class="form-control" min="0" max="100" step="0.01">
                        </td>
                        <td>
                            <button type="button" class="btn btn-danger btn-sm remove-ingredient">@lang('recipes.Remove')</button>
                        </td>
                    </tr>
                `);
                ingredientIndex++;
                $('.select2').select2();
            });

            $(document).on('click', '.remove-ingredient', function () {
                $(this).closest('tr').remove();
            });
        });
    </script>
@endsection
