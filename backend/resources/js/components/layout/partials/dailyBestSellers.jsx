import React from "react";
function DailyBestSeller() {
    return (
        <div className="container">
            <div className="row">
                <div className="col-md-12 mb-6">
                    <h3 className="mb-0">Daily Best Sells</h3>
                </div>
            </div>
            <div className="table-responsive-xl pb-6">
                <div className="row row-cols-lg-4 row-cols-1 row-cols-md-2 g-4 flex-nowrap">
                    <div className="col">
                        <div
                            className=" pt-8 px-6 px-xl-8 rounded"
                            style={{
                                background:
                                    "url(/front/dist/assets/images/banner/img3.jpg)no-repeat",
                                backgroundSize: "cover",
                                height: 470,
                            }}
                        >
                            <div>
                                <h3 className="fw-bold text-white">
                                    Quality guaranteed.
                                </h3>
                                <p className="text-white">
                                    Get the best deal before close.
                                </p>
                                <a href="#!" className="btn btn-primary">
                                    Shop Now{" "}
                                    <i className="feather-icon icon-arrow-right ms-1" />
                                </a>
                            </div>
                        </div>
                    </div>
                    <div className="col">
                        <div className="card card-product">
                            <div className="card-body">
                                <div className="text-center  position-relative ">
                                    {" "}
                                    <a href="./pages/shop-single.html">
                                        <img
                                            src="/front/dist/assets/images/products/img1.jpg"
                                            alt="Grocery Ecommerce Template"
                                            className="mb-3 img-fluid"
                                        />
                                    </a>
                                    <div className="card-product-action">
                                        <a
                                            href="#!"
                                            className="btn-action"
                                            data-bs-toggle="modal"
                                            data-bs-target="#quickViewModal"
                                        >
                                            <i
                                                className="bi bi-eye"
                                                data-bs-toggle="tooltip"
                                                data-bs-html="true"
                                                title="Quick View"
                                            />
                                        </a>
                                        <a
                                            href="#!"
                                            className="btn-action"
                                            data-bs-toggle="tooltip"
                                            data-bs-html="true"
                                            title="Wishlist"
                                        >
                                            <i className="bi bi-heart" />
                                        </a>
                                        <a
                                            href="#!"
                                            className="btn-action"
                                            data-bs-toggle="tooltip"
                                            data-bs-html="true"
                                            title="Compare"
                                        >
                                            <i className="bi bi-arrow-left-right" />
                                        </a>
                                    </div>
                                </div>
                                <div className="text-small mb-1">
                                    <a
                                        href="#!"
                                        className="text-decoration-none text-muted"
                                    >
                                        <small>Tea, Coffee &amp; Drinks</small>
                                    </a>
                                </div>
                                <h2 className="fs-6">
                                    <a
                                        href="./pages/shop-single.html"
                                        className="text-inherit text-decoration-none"
                                    >
                                        Roast Ground Coffee
                                    </a>
                                </h2>
                                <div className="d-flex justify-content-between align-items-center mt-3">
                                    <div>
                                        <span className="text-dark">$13</span>{" "}
                                    </div>
                                    <div>
                                        <small className="text-warning">
                                            {" "}
                                            <i className="bi bi-star-fill" />
                                            <i className="bi bi-star-fill" />
                                            <i className="bi bi-star-fill" />
                                            <i className="bi bi-star-fill" />
                                            <i className="bi bi-star-half" />
                                        </small>
                                        <span>
                                            <small>4.5</small>
                                        </span>
                                    </div>
                                </div>
                                <div className="d-grid mt-2">
                                    <a href="#!" className="btn btn-primary ">
                                        <svg
                                            xmlns="http://www.w3.org/2000/svg"
                                            width={16}
                                            height={16}
                                            viewBox="0 0 24 24"
                                            fill="none"
                                            stroke="currentColor"
                                            strokeWidth={2}
                                            strokeLinecap="round"
                                            strokeLinejoin="round"
                                            className="feather feather-plus"
                                        >
                                            <line
                                                x1={12}
                                                y1={5}
                                                x2={12}
                                                y2={19}
                                            />
                                            <line
                                                x1={5}
                                                y1={12}
                                                x2={19}
                                                y2={12}
                                            />
                                        </svg>{" "}
                                        Add to cart{" "}
                                    </a>
                                </div>
                                <div className="d-flex justify-content-start text-center mt-3">
                                    <div
                                        className="deals-countdown w-100"
                                        data-countdown="2028/10/10 00:00:00"
                                    />
                                </div>
                            </div>
                        </div>
                    </div>
                    <div className="col">
                        <div className="card card-product">
                            <div className="card-body">
                                <div className="text-center  position-relative ">
                                    {" "}
                                    <a href="./pages/shop-single.html">
                                        <img
                                            src="/front/dist/assets/images/products/img2.jpg"
                                            alt="Grocery Ecommerce Template"
                                            className="mb-3 img-fluid"
                                        />
                                    </a>
                                    <div className="card-product-action">
                                        <a
                                            href="#!"
                                            className="btn-action"
                                            data-bs-toggle="modal"
                                            data-bs-target="#quickViewModal"
                                        >
                                            <i
                                                className="bi bi-eye"
                                                data-bs-toggle="tooltip"
                                                data-bs-html="true"
                                                title="Quick View"
                                            />
                                        </a>
                                        <a
                                            href="#!"
                                            className="btn-action"
                                            data-bs-toggle="tooltip"
                                            data-bs-html="true"
                                            title="Wishlist"
                                        >
                                            <i className="bi bi-heart" />
                                        </a>
                                        <a
                                            href="#!"
                                            className="btn-action"
                                            data-bs-toggle="tooltip"
                                            data-bs-html="true"
                                            title="Compare"
                                        >
                                            <i className="bi bi-arrow-left-right" />
                                        </a>
                                    </div>
                                </div>
                                <div className="text-small mb-1">
                                    <a
                                        href="#!"
                                        className="text-decoration-none text-muted"
                                    >
                                        <small>Fruits &amp; Vegetables</small>
                                    </a>
                                </div>
                                <h2 className="fs-6">
                                    <a
                                        href="./pages/shop-single.html"
                                        className="text-inherit text-decoration-none"
                                    >
                                        Crushed Tomatoes
                                    </a>
                                </h2>
                                <div className="d-flex justify-content-between align-items-center mt-3">
                                    <div>
                                        <span className="text-dark">$13</span>{" "}
                                    </div>
                                    <div>
                                        <small className="text-warning">
                                            {" "}
                                            <i className="bi bi-star-fill" />
                                            <i className="bi bi-star-fill" />
                                            <i className="bi bi-star-fill" />
                                            <i className="bi bi-star-fill" />
                                            <i className="bi bi-star-half" />
                                        </small>
                                        <span>
                                            <small>4.5</small>
                                        </span>
                                    </div>
                                </div>
                                <div className="d-grid mt-2">
                                    <a href="#!" className="btn btn-primary ">
                                        <svg
                                            xmlns="http://www.w3.org/2000/svg"
                                            width={16}
                                            height={16}
                                            viewBox="0 0 24 24"
                                            fill="none"
                                            stroke="currentColor"
                                            strokeWidth={2}
                                            strokeLinecap="round"
                                            strokeLinejoin="round"
                                            className="feather feather-plus"
                                        >
                                            <line
                                                x1={12}
                                                y1={5}
                                                x2={12}
                                                y2={19}
                                            />
                                            <line
                                                x1={5}
                                                y1={12}
                                                x2={19}
                                                y2={12}
                                            />
                                        </svg>{" "}
                                        Add to cart{" "}
                                    </a>
                                </div>
                                <div className="d-flex justify-content-start text-center mt-3 w-100">
                                    <div
                                        className="deals-countdown w-100"
                                        data-countdown="2028/12/9 00:00:00"
                                    />
                                </div>
                            </div>
                        </div>
                    </div>
                    <div className="col">
                        <div className="card card-product">
                            <div className="card-body">
                                <div className="text-center  position-relative ">
                                    {" "}
                                    <a href="./pages/shop-single.html">
                                        <img
                                            src="/front/dist/assets/images/products/img3.jpg"
                                            alt="Grocery Ecommerce Template"
                                            className="mb-3 img-fluid"
                                        />
                                    </a>
                                    <div className="card-product-action">
                                        <a
                                            href="#!"
                                            className="btn-action"
                                            data-bs-toggle="modal"
                                            data-bs-target="#quickViewModal"
                                        >
                                            <i
                                                className="bi bi-eye"
                                                data-bs-toggle="tooltip"
                                                data-bs-html="true"
                                                title="Quick View"
                                            />
                                        </a>
                                        <a
                                            href="#!"
                                            className="btn-action"
                                            data-bs-toggle="tooltip"
                                            data-bs-html="true"
                                            title="Wishlist"
                                        >
                                            <i className="bi bi-heart" />
                                        </a>
                                        <a
                                            href="#!"
                                            className="btn-action"
                                            data-bs-toggle="tooltip"
                                            data-bs-html="true"
                                            title="Compare"
                                        >
                                            <i className="bi bi-arrow-left-right" />
                                        </a>
                                    </div>
                                </div>
                                <div className="text-small mb-1">
                                    <a
                                        href="#!"
                                        className="text-decoration-none text-muted"
                                    >
                                        <small>Fruits &amp; Vegetables</small>
                                    </a>
                                </div>
                                <h2 className="fs-6">
                                    <a
                                        href="./pages/shop-single.html"
                                        className="text-inherit text-decoration-none"
                                    >
                                        Golden Pineapple
                                    </a>
                                </h2>
                                <div className="d-flex justify-content-between align-items-center mt-3">
                                    <div>
                                        <span className="text-dark">$13</span>{" "}
                                    </div>
                                    <div>
                                        <small className="text-warning">
                                            {" "}
                                            <i className="bi bi-star-fill" />
                                            <i className="bi bi-star-fill" />
                                            <i className="bi bi-star-fill" />
                                            <i className="bi bi-star-fill" />
                                            <i className="bi bi-star-half" />
                                        </small>
                                        <span>
                                            <small>4.5</small>
                                        </span>
                                    </div>
                                </div>
                                <div className="d-grid mt-2">
                                    <a href="#!" className="btn btn-primary ">
                                        <svg
                                            xmlns="http://www.w3.org/2000/svg"
                                            width={16}
                                            height={16}
                                            viewBox="0 0 24 24"
                                            fill="none"
                                            stroke="currentColor"
                                            strokeWidth={2}
                                            strokeLinecap="round"
                                            strokeLinejoin="round"
                                            className="feather feather-plus"
                                        >
                                            <line
                                                x1={12}
                                                y1={5}
                                                x2={12}
                                                y2={19}
                                            />
                                            <line
                                                x1={5}
                                                y1={12}
                                                x2={19}
                                                y2={12}
                                            />
                                        </svg>{" "}
                                        Add to cart{" "}
                                    </a>
                                </div>
                                <div className="d-flex justify-content-start text-center mt-3">
                                    <div
                                        className="deals-countdown w-100"
                                        data-countdown="2028/11/11 00:00:00"
                                    />
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    );
}
export default DailyBestSeller;
