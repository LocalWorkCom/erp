<div class="modal fade" tabindex="-1" id="productModal" aria-labelledby="productModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">
            <div class="modal-header border-0">
                <button type="button" class="btn btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <h2 class="text-center mb-4"> من فضلك قم بتخصيص وجبتك </h2>
                <div class="row mx-0">
                    <div class="col-md-6">
                        <div class="product-details ">
                            <h4>اختيارات من الحجم
                            </h4>
                                    <div class="choices my-3"  id="div-sizes">
                                    <div class="form-check">
                                        <div>
                                            <input class="form-check-input" type="radio" name="options" id="option1"
                                                value="option1">
                                            <label class="form-check-label" for="option1">
                                                ربع فرخة
                                            </label>
                                        </div>
                                        <span>100 ج.م</span>

                                    </div>
                                  
                                </div>
                            <h4> اضافات
                            </h4>
                            <div class="choices my-3">
                                <form>
                                    <div class="form-check">
                                        <div>
                                            <input class="form-check-input" type="checkbox" name="options"
                                                id="option11" value="option11">

                                            <label class="form-check-label" for="option11">
                                                دقوس </label>
                                        </div>
                                        <span>100 ج.م</span>

                                    </div>
                                    <div class="form-check">
                                        <div>
                                            <input class="form-check-input" type="checkbox" name="options"
                                                id="option22" value="option22">
                                            <label class="form-check-label" for="option22">
                                                جمبري
                                            </label>
                                        </div>
                                        <span>200 ج.م</span>
                                    </div>
                                    <div class="form-check">
                                        <div>
                                            <input class="form-check-input" type="checkbox" name="options"
                                                id="option33" value="option33">
                                            <label class="form-check-label" for="option33">
                                                رز
                                            </label>
                                        </div>
                                        <span>400 ج.م</span>

                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="product">
                            <figure class="product-img m-0">
                                <img src="SiteAssets/images/plate1.png" alt="">
                                <figcaption class="pt-3">
                                    <h5>كبسة فراخ </h5>
                                    <span class="badge bg-warning text-dark">
                                        <i class="fas fa-star"></i>
                                        الاعلى تقييم
                                    </span>
                                    <small class="text-muted d-block py-2">
                                        عيش مع نصف دجاجه يقدم مع معبوج أخضر ومعبوج أحمر ودقوس او مرق باميه
                                    </small>
                                    <h4 class="fw-bold"> 300 ج . م</h4>
                                    <div class="qty mt-3 d-flex justify-content-center align-items-center">
                                        <span class="pro-dec me-3" onclick="decreaseQuantity()">
                                            <i class="fa fa-minus" aria-hidden="true"></i>
                                        </span>
                                        <span class="num fs-4" id="quantity">1</span>
                                        <span class="pro-inc ms-3" onclick="increaseQuantity()">
                                            <i class="fa fa-plus" aria-hidden="true"></i>
                                        </span>
                                    </div>


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
                                <label for="floatingTextarea2">من فضلك اكتب ملاحظتك</label>
                            </div>
                        </div>
                        <button class="btn w-100 d-flex justify-content-between mt-3">
                            <span> + أضف الي العربة
                                (1)</span>
                            <span>300 ج . م</span>
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
