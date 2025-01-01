@auth('client')
    <!-- Profile modal -->
    <div class="modal fade" tabindex="-1" id="profileModal" aria-labelledby="profileModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered ">
            <div class="modal-content">
                <div class="modal-header border-0">
                    <button type="button" class="btn btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="d-flex justify-content-between align-items-start border-bottom pb-2">
                        <div>
                            <h5 class="fw-bold mb-3">
                                <i class="fas fa-user-circle main-color"></i>
                                <span>{{ Auth::guard('client')->user()->name }}</span>
                            </h5>
                            <small class="text-muted" dir="ltr">
                                <img src="SiteAssets/images/egypt.png" alt="" />
                                <span>{{ Auth::guard('client')->user()->phone }} </span>
                            </small>
                            <small class="text-muted d-block">
                                {{ Auth::guard('client')->user()->email ?? '' }}
                            </small>
                        </div>
                        <button class="btn reversed main-color" type="button"
                            onclick="window.location.href='{{ route('website.profile.view') }}';">
                            @lang('header.editprofile')
                        </button>
                    </div>
                    <ul class="profile-list list-unstyled px-0 pt-4">
                        <li>
                            <a href="{{ route('orders.show') }}">
                                <h6 class="fw-bold">
                                    <i class="fas fa-clipboard-list main-color ms-2"></i>

                                    @lang('header.previousorder')

                                </h6>
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('orders.tracking') }}">
                                <h6 class="fw-bold">
                                    <i class="fas fa-map-marked-alt main-color ms-2"></i>

                                    @lang('header.trackorder')

                                </h6>
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('showAddress') }}">
                                <h6 class="fw-bold">
                                    <i class="fas fa-map-marker-alt main-color ms-2"></i>

                                    @lang('header.myaddress')

                                </h6>
                            </a>
                        </li>
                        <li>
                            <a href="">
                                <h6 class="fw-bold">
                                    <i class="fas fa-star main-color ms-2"></i>
                                    @lang('header.rate')

                                </h6>
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('show.favorites') }}">
                                <h6 class="fw-bold">
                                    <i class="fas fa-heart main-color ms-2"></i>
                                    @lang('header.favorite')

                                </h6>
                            </a>
                        </li>
                        <li>
                            <a href="">
                                <h6 class="fw-bold">
                                    <i class="fas fa-bell main-color ms-2"></i>
                                    @lang('header.notification')

                                </h6>
                            </a>
                            <div class="form-check form-switch">
                                <input class="form-check-input" type="checkbox" role="switch" id="flexSwitchCheckDefault">
                            </div>
                        </li>
                        <li>
                            <a href="{{ route('shoe.faq') }}">
                                <h6 class="fw-bold">
                                    <i class="fas fa-file-alt main-color ms-2"></i>
                                    @lang('header.questions')

                                </h6>
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('terms') }}">
                                <h6 class="fw-bold">
                                    <i class="fas fa-file-alt main-color ms-2"></i>
                                    @lang('header.policy')

                                </h6>
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('privacy') }}">
                                <h6 class="fw-bold">
                                    <i class="fas fa-clipboard-list main-color ms-2"></i>
                                    @lang('header.privacy')

                                </h6>
                            </a>
                        </li>
                        <li>
                            <a href="">
                                <h6 class="fw-bold">
                                    <i class="fas fa-headset main-color ms-2"></i>
                                    @lang('header.support')
                                </h6>
                            </a>
                            <img src="{{ asset('front/AlKout-Resturant/SiteAssets/images/logos_whatsapp-icon.png') }} " />
                        </li>
                        <li>
                            <a data-bs-toggle="modal" data-bs-target="#logoutModal">
                                <h6 class="fw-bold">
                                    <i class="fas fa-sign-out-alt main-color ms-2"></i>
                                    @lang('header.logout')
                                </h6>
                            </a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
@endauth
