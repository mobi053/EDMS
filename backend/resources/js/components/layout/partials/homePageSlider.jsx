import React from "react";

function HomePageSlider() {
    return (
        <div
            id="hero-slider"
            className="carousel slide"
            data-bs-ride="carousel"
        >
            <div className="carousel-inner">
                <div className="carousel-item active">
                    <div
                        style={{
                            background:
                                "url(/front/dist/assets/images/slider/img1.jpg)no-repeat",
                            backgroundSize: "cover",
                            borderRadius: ".5rem",
                            backgroundPosition: "center",
                        }}
                        className="img-fluid"
                    >
                        <div className="ps-lg-12 py-lg-16 col-xxl-5 col-md-7 py-14 px-8 text-xs-center">
                            <h2 className="text-white display-5 fw-bold mt-4">
                                The Fence Line - Best in class
                            </h2>
                            <p className="lead text-yellow">
                                Introducing a new line of premium Fences.
                            </p>
                            <a href="#!" className="btn btn-dark mt-3">
                                Shop Now
                                <i className="feather-icon icon-arrow-right ms-1" />
                            </a>
                        </div>
                    </div>
                </div>
                <div className="carousel-item">
                    <div
                        style={{
                            background:
                                "url(/front/dist/assets/images/slider/img2.jpg)no-repeat",
                            backgroundSize: "cover",
                            borderRadius: ".5rem",
                            backgroundPosition: "center",
                        }}
                        className="img-fluid"
                    >
                        <div className="ps-lg-12 py-lg-16 col-xxl-5 col-md-7 py-14 px-8 text-xs-center">
                            <span className="badge text-bg-warning">
                                Free Shipping - orders over $100
                            </span>
                            <h2 className="text-white display-5 fw-bold mt-4">
                                Free Shipping on <br /> orders over{" "}
                                <span className="text-primary">$100</span>s
                            </h2>
                            <p className="lead">
                                Free Shipping to First-Time Customers Only,
                                After promotions and discounts are applied.
                            </p>
                            <a href="#!" className="btn btn-dark mt-3">
                                Shop Now{" "}
                                <i className="feather-icon icon-arrow-right ms-1" />
                            </a>
                        </div>
                    </div>
                </div>
            </div>
            <button
                className="carousel-control-prev"
                type="button"
                data-bs-target="#hero-slider"
                data-bs-slide="prev"
            >
                <span
                    className="carousel-control-prev-icon"
                    aria-hidden="true"
                ></span>
                <span className="visually-hidden">Previous</span>
            </button>
            <button
                className="carousel-control-next"
                type="button"
                data-bs-target="#hero-slider"
                data-bs-slide="next"
            >
                <span
                    className="carousel-control-next-icon"
                    aria-hidden="true"
                ></span>
                <span className="visually-hidden">Next</span>
            </button>
        </div>
    );
}

export default HomePageSlider;
