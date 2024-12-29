<div class="modal fade" tabindex="-1" id="productModal" aria-labelledby="productModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">
            <div class="modal-header border-0">
                <button type="button" class="btn btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <div class="modal-body">
                <input type="hidden" name="dish_id" id="dish_id">
                <h2 class="text-center mb-4"> من فضلك قم بتخصيص وجبتك </h2>
                <div class="row mx-0">
                    <div class="col-md-6">
                        <div class="product-details">
                            <h4>اختيارات من الحجم
                            </h4>
                            <div class="choices my-3" id="div-sizes">

                            </div>
                            <h4> اضافات
                            </h4>
                            <div class="choices my-3" id="div-addons">

                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="product">
                            <figure class="product-img m-0">
                                <img src="" alt="" id="dish-img">
                                <figcaption class="pt-3" id="div-detail">

                                </figcaption>
                            </figure>
                        </div>
                        <div class="notes my-3">
                            <h4>
                                <i class="fas fa-file-alt main-color fa-xs"></i>
                                لديك اى ملاحظات اضافيه؟
                            </h4>
                            <div class="form-floating mt-3">
                                <textarea class="form-control" placeholder="من فضلك اكتب ملاحظتك" id="floatingTextarea2" style="height: 100px"></textarea>
                            </div>
                        </div>
                        <button class="btn w-100 d-flex justify-content-between mt-3" id="submit">
                            <span id="dish-quantity"> + أضف الي العربة
                            </span>
                            <span id="dish-total"></span>
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
