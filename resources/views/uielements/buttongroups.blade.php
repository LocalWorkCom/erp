@extends('layouts.master')

@section('styles')
 
      
@endsection

@section('content')

                    <!-- PAGE HEADER -->
                    <div class="d-sm-flex d-block align-items-center justify-content-between page-header-breadcrumb">
                        <h4 class="fw-medium mb-0">Button Groups</h4>
                        <div class="ms-sm-1 ms-0">
                            <nav>
                                <ol class="breadcrumb mb-0">
                                    <li class="breadcrumb-item"><a href="javascript:void(0);">Ui Elements</a></li>
                                    <li class="breadcrumb-item active" aria-current="page">Button Groups</li>
                                </ol>
                            </nav>
                        </div>
                    </div>
                    <!-- END PAGE HEADER -->

                    <!-- APP-CONTENT START -->
                    <div class="main-content app-content">
                        <div class="container-fluid">

                            <!--ROW-START-->
                            <div class="row">
                                <div class="col-xl-3">
                                    <div class="card custom-card">
                                        <div class="card-header">
                                            <div class="card-title">
                                                Basic example
                                            </div>
                                        </div>
                                        <div class="card-body">
                                            <div class="btn-group" role="group" aria-label="Basic example">
                                                <button aria-label="button" type="button" class="btn btn-info btn-wave"><i class="bi bi-skip-backward"></i></button>
                                                <button aria-label="button" type="button" class="btn btn-info btn-wave"><i class="bi bi-pause"></i></button>
                                                <button aria-label="button" type="button" class="btn btn-info btn-wave"><i class="bi bi-skip-forward"></i></button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-xl-3">
                                    <div class="card custom-card">
                                        <div class="card-header">
                                            <div class="card-title">
                                                Navigation
                                            </div>
                                        </div>
                                        <div class="card-body">
                                            <div class="btn-group">
                                                <a href="javascript:void(0);" class="btn btn-primary active btn-wave" aria-current="page">Active
                                                    link</a>
                                                <a href="javascript:void(0);" class="btn btn-primary">Link</a>
                                                <a href="javascript:void(0);" class="btn btn-primary">Link</a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-xl-3">
                                    <div class="card custom-card">
                                        <div class="card-header">
                                            <div class="card-title">
                                                Mixed Style
                                            </div>
                                        </div>
                                        <div class="card-body">
                                            <div class="btn-group" role="group" aria-label="Basic mixed styles example">
                                                <button type="button" class="btn btn-danger btn-wave">Left</button>
                                                <button type="button" class="btn btn-warning btn-wave">Middle</button>
                                                <button type="button" class="btn btn-success btn-wave">Right</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-xl-3">
                                    <div class="card custom-card">
                                        <div class="card-header">
                                            <div class="card-title">
                                                Outline styled
                                            </div>
                                        </div>
                                        <div class="card-body">
                                            <div class="btn-group btn-group2" role="group" aria-label="Basic outlined example">
                                                <button type="button" class="btn btn-outline-primary btn-wave">Left</button>
                                                <button type="button" class="btn btn-outline-primary btn-wave">Middle</button>
                                                <button type="button" class="btn btn-outline-primary btn-wave">Right</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-xl-6">
                                    <div class="card custom-card">
                                        <div class="card-header">
                                            <div class="card-title">
                                                Checkbox button groups
                                            </div>
                                        </div>
                                        <div class="card-body">
                                            <div class="btn-group btn-group2" role="group" aria-label="Basic checkbox toggle button group">
                                                <input type="checkbox" class="btn-check" id="btncheck1">
                                                <label class="btn btn-outline-primary" for="btncheck1">Checkbox 1</label>

                                                <input type="checkbox" class="btn-check" id="btncheck2">
                                                <label class="btn btn-outline-primary" for="btncheck2">Checkbox 2</label>

                                                <input type="checkbox" class="btn-check" id="btncheck3">
                                                <label class="btn btn-outline-primary" for="btncheck3">Checkbox 3</label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-xl-6">
                                    <div class="card custom-card">
                                        <div class="card-header">
                                            <div class="card-title">
                                                Radio button groups
                                            </div>
                                        </div>
                                        <div class="card-body">
                                            <div class="btn-group btn-group2" role="group" aria-label="Basic radio toggle button group">
                                                <input type="radio" class="btn-check" name="btnradio" id="btnradio1"
                                                    checked>
                                                <label class="btn btn-outline-primary" for="btnradio1">Radio 1</label>

                                                <input type="radio" class="btn-check" name="btnradio" id="btnradio2"
                                                >
                                                <label class="btn btn-outline-primary" for="btnradio2">Radio 2</label>

                                                <input type="radio" class="btn-check" name="btnradio" id="btnradio3"
                                                >
                                                <label class="btn btn-outline-primary" for="btnradio3">Radio 3</label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-xl-6">
                                    <div class="row">
                                        <div class="col-xl-12">
                                            <div class="card custom-card">
                                                <div class="card-header">
                                                    <div class="card-title">
                                                        Sizing
                                                    </div>
                                                </div>
                                                <div class="card-body">
                                                    <div class="btn-group btn-group-lg my-1" role="group" aria-label="Large button group">
                                                        <button type="button" class="btn btn-outline-success">Left</button>
                                                        <button type="button" class="btn btn-outline-success">Middle</button>
                                                        <button type="button" class="btn btn-outline-success">Right</button>
                                                    </div>
                                                    <div class="btn-group my-1" role="group" aria-label="Default button group">
                                                        <button type="button" class="btn btn-outline-success">Left</button>
                                                        <button type="button" class="btn btn-outline-success">Middle</button>
                                                        <button type="button" class="btn btn-outline-success">Right</button>
                                                    </div>
                                                    <div class="btn-group btn-group-sm my-1" role="group" aria-label="Small button group">
                                                        <button type="button" class="btn btn-outline-success">Left</button>
                                                        <button type="button" class="btn btn-outline-success">Middle</button>
                                                        <button type="button" class="btn btn-outline-success">Right</button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div> <div class="col-xl-12">
                                            <div class="card custom-card">
                                                <div class="card-header">
                                                    <div class="card-title">
                                                        Button toolbar
                                                    </div>
                                                </div>
                                                <div class="card-body">
                                                    <div class="btn-toolbar mb-4" role="toolbar"
                                                        aria-label="Toolbar with button groups">
                                                        <div class="btn-group me-2 my-1" role="group" aria-label="First group">
                                                            <button type="button" class="btn btn-primary">1</button>
                                                            <button type="button" class="btn btn-primary">2</button>
                                                            <button type="button" class="btn btn-primary">3</button>
                                                            <button type="button" class="btn btn-primary">4</button>
                                                        </div>
                                                        <div class="btn-group me-2 my-1" role="group" aria-label="Second group">
                                                            <button type="button" class="btn btn-secondary">5</button>
                                                            <button type="button" class="btn btn-secondary">6</button>
                                                            <button type="button" class="btn btn-secondary">7</button>
                                                        </div>
                                                        <div class="btn-group my-1" role="group" aria-label="Third group">
                                                            <button type="button" class="btn btn-info">8</button>
                                                        </div>
                                                    </div>
                                                    <div class="btn-toolbar mb-3" role="toolbar"
                                                        aria-label="Toolbar with button groups">
                                                        <div class="btn-group me-2 my-1" role="group" aria-label="First group">
                                                            <button type="button" class="btn btn-outline-secondary">1</button>
                                                            <button type="button" class="btn btn-outline-secondary">2</button>
                                                            <button type="button" class="btn btn-outline-secondary">3</button>
                                                            <button type="button" class="btn btn-outline-secondary">4</button>
                                                        </div>
                                                        <div class="input-group">
                                                            <div class="input-group-text" id="btnGroupAddon">@</div>
                                                            <input type="text" class="form-control"
                                                                placeholder="Input group example"
                                                                aria-label="Input group example"
                                                                aria-describedby="btnGroupAddon">
                                                        </div>
                                                    </div>
                                                    <div class="btn-toolbar justify-content-between" role="toolbar"
                                                        aria-label="Toolbar with button groups">
                                                        <div class="btn-group my-1" role="group" aria-label="First group">
                                                            <button type="button" class="btn btn-outline-secondary">1</button>
                                                            <button type="button" class="btn btn-outline-secondary">2</button>
                                                            <button type="button" class="btn btn-outline-secondary">3</button>
                                                            <button type="button" class="btn btn-outline-secondary">4</button>
                                                        </div>
                                                        <div class="input-group">
                                                            <div class="input-group-text" id="btnGroupAddon2">@</div>
                                                            <input type="text" class="form-control"
                                                                placeholder="Input group example"
                                                                aria-label="Input group example"
                                                                aria-describedby="btnGroupAddon2">
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-xl-12">
                                            <div class="card custom-card">
                                                <div class="card-header">
                                                    <div class="card-title">
                                                        Nesting
                                                    </div>
                                                </div>
                                                <div class="card-body">
                                                    <div class="btn-group" role="group"
                                                        aria-label="Button group with nested dropdown">
                                                        <button type="button" class="btn btn-primary">1</button>
                                                        <button type="button" class="btn btn-primary">2</button>

                                                        <div class="btn-group" role="group">
                                                            <button id="btnGroupDrop1" type="button"
                                                                class="btn btn-primary dropdown-toggle"
                                                                data-bs-toggle="dropdown" aria-expanded="false">
                                                                Dropdown
                                                            </button>
                                                            <ul class="dropdown-menu" aria-labelledby="btnGroupDrop1">
                                                                <li><a class="dropdown-item" href="javascript:void(0);">Dropdown link</a></li>
                                                                <li><a class="dropdown-item" href="javascript:void(0);">Dropdown link</a></li>
                                                            </ul>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-xl-6">
                                    <div class="row">
                                        <div class="col-xl-12">
                                            <div class="card custom-card">
                                                <div class="card-header">
                                                    <div class="card-title">
                                                        Vertical variation
                                                    </div>
                                                </div>
                                                <div class="card-body">
                                                    <div class="row gap-2">
                                                        <div class="col-sm-3">
                                                            <div class="btn-group-vertical" role="group" aria-label="Vertical button group">
                                                                <button type="button" class="btn btn-primary">Button</button>
                                                                <button type="button" class="btn btn-primary">Button</button>
                                                                <div class="btn-group" role="group">
                                                                    <button id="btnGroupVerticalDrop1" type="button"
                                                                        class="btn btn-primary dropdown-toggle" data-bs-toggle="dropdown"
                                                                        aria-expanded="false">
                                                                        Dropdown
                                                                    </button>
                                                                    <ul class="dropdown-menu" aria-labelledby="btnGroupVerticalDrop1">
                                                                        <li><a class="dropdown-item" href="javascript:void(0);">Dropdown link</a></li>
                                                                        <li><a class="dropdown-item" href="javascript:void(0);">Dropdown link</a></li>
                                                                    </ul>
                                                                </div>
                                                                <button type="button" class="btn btn-primary">Button</button>
                                                                <button type="button" class="btn btn-primary">Button</button>
                                                                <div class="btn-group" role="group">
                                                                    <button id="btnGroupVerticalDrop2" type="button"
                                                                        class="btn btn-primary dropdown-toggle" data-bs-toggle="dropdown"
                                                                        aria-expanded="false">
                                                                        Dropdown
                                                                    </button>
                                                                    <ul class="dropdown-menu" aria-labelledby="btnGroupVerticalDrop2">
                                                                        <li><a class="dropdown-item" href="javascript:void(0);">Dropdown link</a></li>
                                                                        <li><a class="dropdown-item" href="javascript:void(0);">Dropdown link</a></li>
                                                                    </ul>
                                                                </div>
                                                                <div class="btn-group" role="group">
                                                                    <button id="btnGroupVerticalDrop3" type="button"
                                                                        class="btn btn-primary dropdown-toggle" data-bs-toggle="dropdown"
                                                                        aria-expanded="false">
                                                                        Dropdown
                                                                    </button>
                                                                    <ul class="dropdown-menu" aria-labelledby="btnGroupVerticalDrop3">
                                                                        <li><a class="dropdown-item" href="javascript:void(0);">Dropdown link</a></li>
                                                                        <li><a class="dropdown-item" href="javascript:void(0);">Dropdown link</a></li>
                                                                    </ul>
                                                                </div>
                                                                <div class="btn-group" role="group">
                                                                    <button id="btnGroupVerticalDrop4" type="button"
                                                                        class="btn btn-primary dropdown-toggle" data-bs-toggle="dropdown"
                                                                        aria-expanded="false">
                                                                        Dropdown
                                                                    </button>
                                                                    <ul class="dropdown-menu" aria-labelledby="btnGroupVerticalDrop4">
                                                                        <li><a class="dropdown-item" href="javascript:void(0);">Dropdown link</a></li>
                                                                        <li><a class="dropdown-item" href="javascript:void(0);">Dropdown link</a></li>
                                                                    </ul>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-sm-3">
                                                            <div class="btn-group-vertical" role="group" aria-label="Vertical button group">
                                                                <button type="button" class="btn btn-info">Button</button>
                                                                <button type="button" class="btn btn-info">Button</button>
                                                                <button type="button" class="btn btn-info">Button</button>
                                                                <button type="button" class="btn btn-info">Button</button>
                                                                <button type="button" class="btn btn-info">Button</button>
                                                                <button type="button" class="btn btn-info">Button</button>
                                                            </div>
                                                        </div>
                                                        <div class="col-sm-3">
                                                            <div class="btn-group-vertical" role="group"
                                                                aria-label="Vertical radio toggle button group">
                                                                <input type="radio" class="btn-check" name="vbtn-radio" id="vbtn-radio1"
                                                                    checked>
                                                                <label class="btn btn-outline-danger" for="vbtn-radio1">Radio 1</label>
                                                                <input type="radio" class="btn-check" name="vbtn-radio" id="vbtn-radio2"
                                                                >
                                                                <label class="btn btn-outline-danger" for="vbtn-radio2">Radio 2</label>
                                                                <input type="radio" class="btn-check" name="vbtn-radio" id="vbtn-radio3"
                                                                >
                                                                <label class="btn btn-outline-danger" for="vbtn-radio3">Radio 3</label>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-xl-12">
                                            <div class="card custom-card">
                                                <div class="card-header">
                                                    <div class="card-title">Social Group Buttons</div>
                                                </div>
                                                <div class="card-body">
                                                    <div class="btn-group" role="group" aria-label="Basic example">
                                                        <button aria-label="button" type="button" class="btn btn-icon btn-facebook btn-wave">
                                                            <i class="ri-facebook-line"></i>
                                                        </button>
                                                        <button aria-label="button" type="button" class="btn btn-icon btn-twitter btn-wave">
                                                            <i class="ri-twitter-line"></i>
                                                        </button>
                                                        <button aria-label="button" type="button" class="btn btn-icon btn-instagram btn-wave">
                                                            <i class="ri-instagram-line"></i>
                                                        </button>
                                                        <button aria-label="button" type="button" class="btn btn-icon btn-github btn-wave">
                                                            <i class="ri-github-line"></i>
                                                        </button>
                                                        <button aria-label="button" type="button" class="btn btn-icon btn-youtube btn-wave">
                                                            <i class="ri-youtube-line"></i>
                                                        </button>
                                                        <button aria-label="button" type="button" class="btn btn-icon btn-google btn-wave">
                                                            <i class="ri-google-line"></i>
                                                        </button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!--ROW-END-->
                        </div>
                    </div>
                    <!-- APP-CONTENT CLOSE -->
            
@endsection

@section('scripts')
  

@endsection