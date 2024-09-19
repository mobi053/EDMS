import React, { useState } from "react";
import ReactDOM from "react-dom/client";
import NavbarInfo from "./layout/partials/navbarInfo";
import NavbarSearch from "./layout/partials/navbarSearch";
import MainNavbar from "./layout/partials/mainNavbar";
import MainFooter from "./layout/partials/mainFooter";
import HomePageSlider from "./layout/partials/homePageSlider";
import HomeCategorySlider from "./layout/partials/homeCategorySlider";
import HomeBanners from "./layout/partials/homeBanners";
import PopularProducts from "./layout/partials/popularProducts";
import DailyBestSeller from "./layout/partials/dailyBestSellers";
import OtherFeatures from "./layout/partials/otherFeatures";
import { BrowserRouter } from "react-router-dom";
import HomeSignup from "./layout/partials/homeSignup";
import HomeShopCart from "./layout/partials/homeShopCart";

// import { Routes, Route } from "react-router-dom";

function Home() {
    const [loading, setLoading] = useState(false);
    return (
        <>
            <div className="border-bottom ">
                {/* <NavbarInfo /> */}
                <NavbarSearch />
                <MainNavbar />
            </div>
            {/* Modal */}
            <HomeSignup />
            {/* Shop Cart */}
            <HomeShopCart isLoading={loading} />
            <main>
                <section className="mt-8">
                    <div className="container">
                        <HomePageSlider />
                    </div>
                </section>
                {/* Category Section Start*/}
                <section className="mb-lg-10 mt-lg-14 my-8">
                    <div className="container">
                        {/* <div className="row">
                            <div className="col-12 mb-6">
                                <h3 className="mb-0">Featured Categories</h3>
                            </div>
                        </div> */}
                        {/* <HomeCategorySlider /> */}
                    </div>
                </section>
                {/* Category Section End*/}
                <section>
                    <HomeBanners />
                </section>
                {/* Popular Products Start*/}
                <section className="my-lg-14 my-8">
                    <PopularProducts />
                </section>
                {/* Popular Products End*/}
                <section>{/* <DailyBestSeller /> */}</section>
                <section className="my-lg-14 my-8">
                    {/* <OtherFeatures /> */}
                </section>
            </main>
            {/* Modal */}
            <div
                className="modal fade"
                id="quickViewModal"
                tabIndex={-1}
                aria-hidden="true"
            >
                <div className="modal-dialog modal-xl modal-dialog-centered">
                    <div className="modal-content">
                        <div className="modal-body p-8">
                            <div className="position-absolute top-0 end-0 me-3 mt-3">
                                <button
                                    type="button"
                                    className="btn-close"
                                    data-bs-dismiss="modal"
                                    aria-label="Close"
                                />
                            </div>
                            <div className="row">
                                <div className="col-lg-6">
                                    {/* img slide */}
                                    <div
                                        className="product productModal"
                                        id="productModal"
                                    >
                                        <div
                                            className="zoom"
                                            onMouseMove={(event) => zoom(event)}
                                            style={{
                                                backgroundImage:
                                                    "url(/front/dist/assets/images/products/product-single-img-1.jpg)",
                                            }}
                                        >
                                            {/* img */}
                                            <img
                                                src="/front/dist/assets/images/products/product-single-img-1.jpg"
                                                alt=""
                                            />
                                        </div>
                                        <div>
                                            <div
                                                className="zoom"
                                                onMouseMove={(event) =>
                                                    zoom(event)
                                                }
                                                style={{
                                                    backgroundImage:
                                                        "url(/front/dist/assets/images/products/product-single-img-2.jpg)",
                                                }}
                                            >
                                                {/* img */}
                                                <img
                                                    src="/front/dist/assets/images/products/product-single-img-2.jpg"
                                                    alt=""
                                                />
                                            </div>
                                        </div>
                                        <div>
                                            <div
                                                className="zoom"
                                                onMouseMove={(event) =>
                                                    zoom(event)
                                                }
                                                style={{
                                                    backgroundImage:
                                                        "url(/front/dist/assets/images/products/product-single-img-3.jpg)",
                                                }}
                                            >
                                                {/* img */}
                                                <img
                                                    src="/front/dist/assets/images/products/product-single-img-3.jpg"
                                                    alt=""
                                                />
                                            </div>
                                        </div>
                                        <div>
                                            <div
                                                className="zoom"
                                                onMouseMove={(event) =>
                                                    zoom(event)
                                                }
                                                style={{
                                                    backgroundImage:
                                                        "url(/front/dist/assets/images/products/product-single-img-4.jpg)",
                                                }}
                                            >
                                                {/* img */}
                                                <img
                                                    src="/front/dist/assets/images/products/product-single-img-4.jpg"
                                                    alt=""
                                                />
                                            </div>
                                        </div>
                                    </div>
                                    {/* product tools */}
                                    <div className="product-tools">
                                        <div
                                            className="thumbnails row g-3"
                                            id="productModalThumbnails"
                                        >
                                            <div className="col-3">
                                                <div className="thumbnails-img">
                                                    {/* img */}
                                                    <img
                                                        src="/front/dist/assets/images/products/product-single-img-1.jpg"
                                                        alt=""
                                                    />
                                                </div>
                                            </div>
                                            <div className="col-3">
                                                <div className="thumbnails-img">
                                                    {/* img */}
                                                    <img
                                                        src="/front/dist/assets/images/products/product-single-img-2.jpg"
                                                        alt=""
                                                    />
                                                </div>
                                            </div>
                                            <div className="col-3">
                                                <div className="thumbnails-img">
                                                    {/* img */}
                                                    <img
                                                        src="/front/dist/assets/images/products/product-single-img-3.jpg"
                                                        alt=""
                                                    />
                                                </div>
                                            </div>
                                            <div className="col-3">
                                                <div className="thumbnails-img">
                                                    {/* img */}
                                                    <img
                                                        src="/front/dist/assets/images/products/product-single-img-4.jpg"
                                                        alt=""
                                                    />
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div className="col-lg-6">
                                    <div className="ps-lg-8 mt-6 mt-lg-0">
                                        <a href="#!" className="mb-4 d-block">
                                            Bakery Biscuits
                                        </a>
                                        <h2 className="mb-1 h1">
                                            Napolitanke Ljesnjak
                                        </h2>
                                        <div className="mb-4">
                                            <small className="text-warning">
                                                <i className="bi bi-star-fill" />
                                                <i className="bi bi-star-fill" />
                                                <i className="bi bi-star-fill" />
                                                <i className="bi bi-star-fill" />
                                                <i className="bi bi-star-half" />
                                            </small>
                                            <a href="#" className="ms-2">
                                                (30 reviews)
                                            </a>
                                        </div>
                                        <div className="fs-4">
                                            <span className="fw-bold text-dark">
                                                $32
                                            </span>
                                            <span className="text-decoration-line-through text-muted">
                                                $35
                                            </span>
                                            <span>
                                                <small className="fs-6 ms-2 text-danger">
                                                    26% Off
                                                </small>
                                            </span>
                                        </div>
                                        <hr className="my-6" />
                                        <div className="mb-4">
                                            <button
                                                type="button"
                                                className="btn btn-outline-secondary"
                                            >
                                                250g
                                            </button>
                                            <button
                                                type="button"
                                                className="btn btn-outline-secondary"
                                            >
                                                500g
                                            </button>
                                            <button
                                                type="button"
                                                className="btn btn-outline-secondary"
                                            >
                                                1kg
                                            </button>
                                        </div>
                                        <div>
                                            {/* input */}
                                            {/* input */}
                                            <div className="input-group input-spinner  ">
                                                <input
                                                    type="button"
                                                    defaultValue="-"
                                                    className="button-minus  btn  btn-sm "
                                                    data-field="quantity"
                                                />
                                                <input
                                                    type="number"
                                                    step={1}
                                                    max={10}
                                                    defaultValue={1}
                                                    name="quantity"
                                                    className="quantity-field form-control-sm form-input   "
                                                />
                                                <input
                                                    type="button"
                                                    defaultValue="+"
                                                    className="button-plus btn btn-sm "
                                                    data-field="quantity"
                                                />
                                            </div>
                                        </div>
                                        <div className="mt-3 row justify-content-start g-2 align-items-center">
                                            <div className="col-lg-4 col-md-5 col-6 d-grid">
                                                {/* button */}
                                                {/* btn */}
                                                <button
                                                    type="button"
                                                    className="btn btn-primary"
                                                >
                                                    <i className="feather-icon icon-shopping-bag me-2" />
                                                    Add to cart
                                                </button>
                                            </div>
                                            <div className="col-md-4 col-5">
                                                {/* btn */}
                                                <a
                                                    className="btn btn-light"
                                                    href="#"
                                                    data-bs-toggle="tooltip"
                                                    data-bs-html="true"
                                                    aria-label="Compare"
                                                >
                                                    <i className="bi bi-arrow-left-right" />
                                                </a>
                                                <a
                                                    className="btn btn-light"
                                                    href="#!"
                                                    data-bs-toggle="tooltip"
                                                    data-bs-html="true"
                                                    aria-label="Wishlist"
                                                >
                                                    <i className="feather-icon icon-heart" />
                                                </a>
                                            </div>
                                        </div>
                                        <hr className="my-6" />
                                        <div>
                                            <table className="table table-borderless">
                                                <tbody>
                                                    <tr>
                                                        <td>Product Code:</td>
                                                        <td>FBB00255</td>
                                                    </tr>
                                                    <tr>
                                                        <td>Availability:</td>
                                                        <td>In Stock</td>
                                                    </tr>
                                                    <tr>
                                                        <td>Type:</td>
                                                        <td>Fruits</td>
                                                    </tr>
                                                    <tr>
                                                        <td>Shipping:</td>
                                                        <td>
                                                            <small>
                                                                01 day shipping.
                                                                <span className="text-muted">
                                                                    ( Free
                                                                    pickup
                                                                    today)
                                                                </span>
                                                            </small>
                                                        </td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            {/* footer */}
            <MainFooter />
            {/* <Routers /> */}
        </>
    );
}

export default Home;
