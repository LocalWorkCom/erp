<div class="modal fade" tabindex="-1" id="productModal_v1" aria-labelledby="productModalLabel" aria-modal="true"
    role="dialog">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">
            <div class="modal-header border-0">
                <button type="button" class="btn btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <div class="modal-body">
                <input type="hidden" name="dish_id" id="dish_id_v1">
                <input type="hidden" name="currency_symbol" id="currency_symbol_v1">
                <h2 class="text-center mb-4"> من فضلك قم بتخصيص وجبتك </h2>
                <div class="row mx-0">
                    <div class="col-md-6">
                        <div class="product-details">
                            <div id="sizes-div" style="display: none">

                                <h4>اختيارات من الحجم
                                </h4>
                                <div class="choices my-3" id="div-sizes">

                                </div>
                            </div>
                            <div id="addons-div" style="display: none">

                                <h4> اضافات
                                </h4>
                                <div class="choices my-3 addon" id="div-addons">

                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="product">
                            <figure class="product-img m-0">
                                <img src="" alt="" id="dish-img_v1">
                                <figcaption class="pt-3" id="div-detail_v1">

                                </figcaption>
                            </figure>
                        </div>
                        <div class="notes my-3">
                            <h4>
                                <i class="fas fa-file-alt main-color fa-xs"></i>
                                لديك اى ملاحظات اضافيه؟
                            </h4>
                            <div class="form-floating mt-3">
                                <textarea class="form-control" placeholder="من فضلك اكتب ملاحظتك" id="note_v1" style="height: 100px"></textarea>
                            </div>
                        </div>
                        <button class="btn w-100 d-flex justify-content-between mt-3 submit" id="submit_v1">
                            <span id="dish-quantity"> + أضف الي العربة
                            </span>
                            <span id="dish-total_v1"></span>
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" tabindex="-1" id="productModal_v2" aria-labelledby="productModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header border-0">
                <button type="button" class="btn btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <input type="hidden" name="dish_id" id="dish_id_v2">
                <input type="hidden" name="currency_symbol" id="currency_symbol_v2">


                <h2 class="text-center mb-4"> من فضلك قم بتخصيص وجبتك </h2>
                <div>
                    <div class="product">
                        <figure class="product-img m-0">
                            <img src="SiteAssets/images/plate1.png" alt="" id="dish-img_v2">
                            <figcaption class="pt-3" id="div-detail_v2">

                            </figcaption>
                        </figure>
                    </div>
                    <div class="notes my-3">
                        <h4>
                            <i class="fas fa-file-alt main-color fa-xs"></i>
                            لديك اى ملاحظات اضافيه؟
                        </h4>
                        <div class="form-floating mt-3">
                            <textarea class="form-control" placeholder="من فضلك اكتب ملاحظتك" id="note_v2" style="height: 100px"></textarea>
                            <label for="note">من فضلك اكتب ملاحظتك</label>
                        </div>
                    </div>
                    <button class="btn w-100 d-flex justify-content-between mt-3 submit" id="submit_v2">
                        <span id="dish-quantity_v2"> + أضف الي العربة
                        </span>
                        <span id="dish-total_v2"></span>
                    </button>

                </div>
            </div>
        </div>
    </div>
</div>
