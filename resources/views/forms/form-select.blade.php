@extends('layouts.master')

@section('styles')
 
      
@endsection

@section('content')

                    <!-- PAGE HEADER -->
                    <div class="d-sm-flex d-block align-items-center justify-content-between page-header-breadcrumb">
                        <h4 class="fw-medium mb-0">Form Select</h4>
                        <div class="ms-sm-1 ms-0">
                            <nav>
                                <ol class="breadcrumb mb-0">
                                    <li class="breadcrumb-item"><a href="javascript:void(0);">Form Elements</a></li>
                                    <li class="breadcrumb-item active" aria-current="page">Form Select</li>
                                </ol>
                            </nav>
                        </div>
                    </div>
                    <!-- END PAGE HEADER -->

                    <!-- APP CONTENT -->
                    <div class="main-content app-content">
                        <div class="container-fluid">

                            <!-- Start::row-1 -->
                            <div class="row">
                                <div class="col-xl-4">
                                    <div class="card custom-card">
                                        <div class="card-header">
                                            <div class="card-title">
                                                Default Select
                                            </div>
                                        </div>
                                        <div class="card-body">
                                            <select class="form-select" aria-label="Default select example">
                                                <option selected>Open this select menu
                                                </option>
                                                <option value="1">One</option>
                                                <option value="2">Two</option>
                                                <option value="3">Three</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-xl-4">
                                    <div class="card custom-card">
                                        <div class="card-header">
                                            <div class="card-title">
                                                Disabled Select
                                            </div>
                                        </div>
                                        <div class="card-body">
                                            <select class="form-select" aria-label="Disabled select example" disabled="">
                                                <option selected="">Open this select menu</option>
                                                <option value="1">One</option>
                                                <option value="2">Two</option>
                                                <option value="3">Three</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-xl-4">
                                    <div class="card custom-card">
                                        <div class="card-header">
                                            <div class="card-title">
                                                Rounded Select
                                            </div>
                                        </div>
                                        <div class="card-body">
                                            <select class="form-select rounded-pill" aria-label="Default select example">
                                                <option selected>Open this select menu
                                                </option>
                                                <option value="1">One</option>
                                                <option value="2">Two</option>
                                                <option value="3">Three</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!--End::row-1 -->

                            <!-- Start:: row-2 -->
                            <div class="row">
                                <div class="col-xl-12">
                                    <div class="card custom-card">
                                        <div class="card-header">
                                            <div class="card-title">
                                                Select Sizes
                                            </div>
                                        </div>
                                        <div class="card-body">
                                            <select class="form-select form-select-sm mb-3" aria-label=".form-select-sm example">
                                                <option selected="">Open this select menu</option>
                                                <option value="1">One</option>
                                                <option value="2">Two</option>
                                                <option value="3">Three</option>
                                            </select><select class="form-select mb-3" aria-label="Default select">
                                                <option selected>Open this select menu
                                                </option>
                                                <option value="1">One</option>
                                                <option value="2">Two</option>
                                                <option value="3">Three</option>
                                            </select>
                                            <select class="form-select form-select-lg"
                                                aria-label=".form-select-lg example">
                                                <option selected="">Open this select menu</option>
                                                <option value="1">One</option>
                                                <option value="2">Two</option>
                                                <option value="3">Three</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- End:: row-2 -->
                            
                            <!-- Start:: row-3 -->
                            <h6 class="fw-semibold mb-2">Choices:</h6>
                            <div class="row">
                                <div class="col-xl-6">
                                    <div class="row">
                                        <div class="col-xl-12">
                                            <div class="card custom-card">
                                                <div class="card-header d-flex align-items-center justify-content-between">
                                                    <h6 class="card-title">Multiple Select</h6>
                                                </div>
                                                <div class="card-body">
                                                    <p class="fw-semibold mb-2">Default</p>
                                                    <select class="form-control" data-trigger name="choices-multiple-default" id="choices-multiple-default" multiple>
                                                        <option value="Choice 1" selected>Choice 1</option>
                                                        <option value="Choice 2">Choice 4</option>
                                                        <option value="Choice 3">Choice 5</option>
                                                        <option value="Choice 4" disabled>Choice 6</option>
                                                    </select>
                                                    <p class="fw-semibold mb-2">With Remove Button</p>
                                                    <select class="form-control" name="choices-multiple-remove-button" id="choices-multiple-remove-button" multiple>
                                                        <option value="Choice 1" selected>Choice 1</option>
                                                        <option value="Choice 2">Choice 2</option>
                                                        <option value="Choice 3">Choice 3</option>
                                                        <option value="Choice 4">Choice 4</option>
                                                    </select>
                                                    <p class="fw-semibold mb-2">Option groups</p>
                                                    <select class="form-control" name="choices-multiple-groups" id="choices-multiple-groups" multiple>
                                                        <option value="">Choose a city</option>
                                                        <optgroup label="UK">
                                                        <option value="London">London</option>
                                                        <option value="Manchester">Manchester</option>
                                                        <option value="Liverpool">Liverpool</option>
                                                        </optgroup>
                                                        <optgroup label="FR">
                                                        <option value="Paris">Paris</option>
                                                        <option value="Lyon">Lyon</option>
                                                        <option value="Marseille">Marseille</option>
                                                        </optgroup>
                                                        <optgroup label="DE" disabled>
                                                        <option value="Hamburg">Hamburg</option>
                                                        <option value="Munich">Munich</option>
                                                        <option value="Berlin">Berlin</option>
                                                        </optgroup>
                                                        <optgroup label="US">
                                                        <option value="New York">New York</option>
                                                        <option value="Washington" disabled>Washington</option>
                                                        <option value="Michigan">Michigan</option>
                                                        </optgroup>
                                                        <optgroup label="SP">
                                                        <option value="Madrid">Madrid</option>
                                                        <option value="Barcelona">Barcelona</option>
                                                        <option value="Malaga">Malaga</option>
                                                        </optgroup>
                                                        <optgroup label="CA">
                                                        <option value="Montreal">Montreal</option>
                                                        <option value="Toronto">Toronto</option>
                                                        <option value="Vancouver">Vancouver</option>
                                                        </optgroup>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>  
                                        <div class="col-xl-12">
                                            <div class="card custom-card">
                                                <div class="card-header">
                                                    <div class="card-title">
                                                        Passing Through Options
                                                    </div>
                                                </div>
                                                <div class="card-body">
                                                    <input class="form-control" id="choices-text-preset-values" type="text" value="three" placeholder="This is a placeholder">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-xl-12">
                                            <div class="card custom-card">
                                                <div class="card-header">
                                                    <div class="card-title">
                                                        Options added via config with no search
                                                    </div>
                                                </div>
                                                <div class="card-body">
                                                    <select class="form-control" name="choices-single-no-search" id="choices-single-no-search">
                                                    <option value="0">Zero</option>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-xl-6">
                                    <div class="row">
                                        <div class="col-xl-12">
                                            <div class="card custom-card">
                                                <div class="card-header d-flex align-items-center justify-content-between">
                                                    <h6 class="card-title">Single Select</h6>
                                                </div>
                                                <div class="card-body">
                                                    <p class="fw-semibold mb-2">Default</p>
                                                    <select class="form-control" data-trigger name="choices-single-default" id="choices-single-default">
                                                        <option value="">This is a placeholder</option>
                                                        <option value="Choice 1">Choice 1</option>
                                                        <option value="Choice 2">Choice 2</option>
                                                        <option value="Choice 3">Choice 3</option>
                                                    </select>
                                                    <p class="fw-semibold mb-2">Option groups</p>
                                                    <select class="form-control" data-trigger name="choices-single-groups" id="choices-single-groups">
                                                        <option value="">Choose a city</option>
                                                        <optgroup label="UK">
                                                            <option value="London">London</option>
                                                            <option value="Manchester">Manchester</option>
                                                            <option value="Liverpool">Liverpool</option>
                                                        </optgroup>
                                                        <optgroup label="FR">
                                                            <option value="Paris">Paris</option>
                                                            <option value="Lyon">Lyon</option>
                                                            <option value="Marseille">Marseille</option>
                                                        </optgroup>
                                                        <optgroup label="DE" disabled>
                                                            <option value="Hamburg">Hamburg</option>
                                                            <option value="Munich">Munich</option>
                                                            <option value="Berlin">Berlin</option>
                                                        </optgroup>
                                                        <optgroup label="US">
                                                            <option value="New York">New York</option>
                                                            <option value="Washington" disabled>Washington</option>
                                                            <option value="Michigan">Michigan</option>
                                                        </optgroup>
                                                        <optgroup label="SP">
                                                            <option value="Madrid">Madrid</option>
                                                            <option value="Barcelona">Barcelona</option>
                                                            <option value="Malaga">Malaga</option>
                                                        </optgroup>
                                                        <optgroup label="CA">
                                                            <option value="Montreal">Montreal</option>
                                                            <option value="Toronto">Toronto</option>
                                                            <option value="Vancouver">Vancouver</option>
                                                        </optgroup>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-xl-12">
                                            <div class="card custom-card">
                                                <div class="card-header">
                                                    <div class="card-title">
                                                        Email Address Only
                                                    </div>
                                                </div>
                                                <div class="card-body">
                                                    <input class="form-control" id="choices-text-email-filter" type="text" placeholder="This is a placeholder">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-xl-12">
                                            <div class="card custom-card">
                                                <div class="card-header">
                                                    <div class="card-title">
                                                        Passing Unique Values 
                                                    </div>
                                                </div>
                                                <div class="card-body">
                                                    <input class="form-control" id="choices-text-unique-values" type="text" value="child-1, child-2" placeholder="This is a placeholder">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- End:: row-3 -->

                            <!-- Start:: row-4 -->
                            <div class="row">
                                <div class="col-xl-6">
                                    <div class="card custom-card">
                                        <div class="card-header">
                                            <div class="card-title">
                                                Multiple Attribute Select
                                            </div>
                                        </div>
                                        <div class="card-body">
                                            <select class="form-select" multiple="" aria-label="multiple select example">
                                                <option selected="">Open this select menu</option>
                                                <option value="1">One</option>
                                                <option value="2">Two</option>
                                                <option value="3">Three</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-xl-6">
                                    <div class="card custom-card">
                                        <div class="card-header">
                                            <div class="card-title">
                                                Using Size Attribute
                                            </div>
                                        </div>
                                        <div class="card-body">
                                            <select class="form-select" size="4" aria-label="size 3 select example">
                                                <option selected="">Open this select menu</option>
                                                <option value="1">One</option>
                                                <option value="2">Two</option>
                                                <option value="3">Three</option>
                                                <option value="4">Four</option>
                                                <option value="5">Five</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- End:: row-4 -->

                        </div>
                    </div>
                    <!-- END APP CONTENT -->

@endsection

@section('scripts')
  
        <!-- INTERNAL CHOICES JS -->
        @vite('resources/assets/js/choices.js')
        

@endsection