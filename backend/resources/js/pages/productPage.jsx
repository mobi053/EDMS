import React from "react";
import NavbarSearch from "../components/layout/partials/navbarSearch";
import MainNavbar from "../components/layout/partials/mainNavbar";
import MainFooter from "../components/layout/partials/mainFooter";
import HomeSignup from "../components/layout/partials/homeSignup";
import HomeShopCart from "../components/layout/partials/homeShopCart";
import { Link } from "react-router-dom";
import { useParams } from "react-router-dom";
import { toast } from "react-toastify";
import "react-toastify/dist/ReactToastify.css";
import { useHistory } from "react-router-dom";
import { Bars } from "react-loader-spinner";
import { useState, useEffect } from "react";
import { useNavigate } from "react-router-dom";
import axios from "axios";
import Rating from "../components/shared/Ratings";
import ProductSlider from "../components/shared/productpageslider";

function ProductPage() {
    const { productId } = useParams();
    const [loggedin, setLoggedIn] = useState(false);
    const [currentImage, setCurrentImage] = useState(0);
    const [ratings, setRatings] = useState(5);

    const [page, setPage] = useState(1);
    const [hasMoreReviews, setHasMoreReviews] = useState(true);

    useEffect(() => {
        const accessToken = localStorage.getItem("userToken");
        if (accessToken) {
            setLoggedIn(true);
        } else {
            setLoggedIn(false);
        }
    }, []);

    const handleThumbnailClick = (index) => {
        setCurrentImage(index);
    };

    // const [itemAdded, setItemAdded] = useState([]);

    const [reviews, setReviews] = useState([]);
    const [product, setProduct] = useState({
        images: [],
        tags: [],
        groups: [],
        applications: [],
        ratings_avg_rating: 0,
    });
    console.log("Product:", product);
    const [loading, setLoading] = useState(false);
    const [relatedProducts, setRelatedProducts] = useState([]);
    const [percentageData, setPercentageData] = useState();
    const navigate = useNavigate(); // import useNavigate hook
    console.log("percentage :", percentageData);

    const [title, setTitle] = useState("");
    const [description, setDescription] = useState("");
    const [rating, setRating] = useState(null);

    //product list api
    useEffect(() => {
        setLoading(true);
        axios
            .get(`/api/product/show/${productId}`)
            .then((response) => {
                setProduct(response.data.result);
                // console.log(response.data.result);
            })
            .finally(() => {
                setLoading(false);
            });
    }, [productId]);

    /// reviews list api call

    // useEffect(() => {
    //     console.log("reviews api!");
    //     axios
    //         .get(`/api/review/list/${productId}?rating=${ratings}&page=${page}`)
    //         .then((response) => {
    //             // setReviews(response.data.result.data);
    //             const newReviews = response.data.result.data;
    //             const totalReviews = response.data.result.total;

    //             setReviews((prevReviews) => [...prevReviews, ...newReviews]);

    //             if (reviews.length + newReviews.length >= totalReviews) {
    //                 setHasMoreReviews(false);
    //             }
    //             // console.log(response.data.result.data);
    //         })
    //         .catch((error) => {
    //             console.log(error);
    //         });
    // }, []);

    useEffect(() => {
        getReviews(false, 1);
    }, []);

    const onChangeReviewPage = (pageNo) => {
        getReviews(true, pageNo);
    };

    const getReviews = (shouldAppend, pageNo, rating) => {
        axios
            .get(
                `/api/review/list/${productId}?rating=${rating}&page=${pageNo}`
            )
            .then((response) => {
                // setReviews(response.data.result.data);
                const newReviews = response.data.result.data;
                const totalReviews = response.data.result.total;

                if (shouldAppend) {
                    setReviews((prevReviews) => [
                        ...prevReviews,
                        ...newReviews,
                    ]);
                } else {
                    setReviews((prevReviews) => [...newReviews]);
                }

                if (reviews.length + newReviews.length >= totalReviews) {
                    setHasMoreReviews(false);
                }
                // console.log(response.data.result.data);
            })
            .catch((error) => {
                console.log(error);
            });
    };

    const handleReadMoreReviews = () => {
        getReviews(true, page + 1);
        setPage(page + 1);
    };

    ///Related Product Api

    useEffect(() => {
        setLoading(true);
        axios
            .get(`/api/product/related/${productId}`, {
                headers: {
                    Authorization: `Bearer ${localStorage.getItem(
                        "userToken"
                    )}`,
                },
            })
            .then((response) => {
                setRelatedProducts(response.data.result);
            })
            .catch((error) => {
                console.log(error);
            })
            .finally(() => {
                setLoading(false);
            });
    }, []);
    //api call for getting percentages

    useEffect(() => {
        axios
            .get(`/api/review/percentage/${productId}`)
            .then((response) => {
                setPercentageData(response.data.result);
                // console.log(response.data.result);
            })
            .catch((error) => console.log(error));
    }, [productId]);

    //Add to wishlist fucntion
    function handleAddToWishlist(productID) {
        setLoading(true);
        axios
            .post(
                "/api/wishlist/store",
                {
                    product_id: productID,
                },
                {
                    headers: {
                        Authorization: `Bearer ${localStorage.getItem(
                            "userToken"
                        )}`,
                    },
                }
            )
            .then((response) => {
                if (response.status === 200) {
                    toast.success("Product added to WishList");
                } else {
                    toast.error("Failed to add to Wishlist");
                }
                // Handle successful response
                // console.log(response);
            })
            .catch((error) => {
                // Handle error response
                console.error(error);
            })
            .finally(() => {
                setLoading(false);
            });
    }

    ///Review Submitt Function
    const handleRatingClick = (value) => {
        setRating(value);
    };

    const handleSubmit = (e) => {
        e.preventDefault();
        setLoading(true);

        const data = {
            product_id: productId,
            rating: rating,
            title: title,
            description: description,
        };

        axios
            .post("/api/review/store", data, {
                headers: {
                    Authorization: `Bearer ${localStorage.getItem(
                        "userToken"
                    )}`,
                },
            })
            .then((response) => {
                if (response.status === 200) {
                    toast.success("Review Submitted");
                    getReviews(false, 1);
                    // navigate(`/productpage/${productId}`);
                } else {
                    toast.error("Failed to Submit Review");
                }
                // Handle successful response

                // console.log(response.data);
            })
            .catch((error) => {
                console.log(error);
            })
            .finally(() => {
                setLoading(false);
            });
    };

    function addToCart(productId, quantity) {
        setLoading(true);
        axios
            .post(
                "/api/cart/store",
                {
                    product_id: productId,
                    quantity: quantity,
                },
                {
                    headers: {
                        Authorization: `Bearer ${localStorage.getItem(
                            "userToken"
                        )}`,
                    },
                }
            )
            .then((response) => {
                if (response.status === 200) {
                    toast.success("Product Added");
                } else {
                    toast.error("Failed to Add Product");
                }
                // Handle successful response

                console.log(response.data); // Handle the response data here
            })
            .catch((error) => {
                console.error(error); // Handle the error here
            })
            .finally(() => {
                setLoading(false);
            });
    }

    function handleRatingChange(event) {
        const selectedValue = event.target.value;
        setRatings(selectedValue);
        setPage(1);
        setHasMoreReviews(true);
        getReviews(false, 1, event.target.value);
    }

    function handleAddToCart(id) {
        addToCart(id, 1); // Send the API request to add the product to the cart with a quantity of 1
    }

    return (
        <>
            <Bars
                height="80"
                width="80"
                color="#4fa94d"
                ariaLabel="bars-loading"
                wrapperStyle={{}}
                wrapperClass="loading-spinner-overlay"
                visible={loading}
            />
            <div className="border-bottom ">
                <NavbarSearch />
                <MainNavbar />
            </div>
            <HomeSignup />
            <HomeShopCart isLoading={loading} />
            <main>
                <div className="mt-4">
                    <div className="container">
                        {/* row */}
                        <div className="row ">
                            {/* col */}
                            <div className="col-12">
                                {/* breadcrumb */}

                                <nav aria-label="breadcrumb">
                                    <ol className="breadcrumb mb-0">
                                        <li className="breadcrumb-item">
                                            <a href="#">Home</a>
                                        </li>
                                        <li className="breadcrumb-item">
                                            <a href="#">
                                                {product.category?.name}
                                            </a>
                                        </li>
                                        <li
                                            className="breadcrumb-item active"
                                            aria-current="page"
                                        >
                                            {product?.name}
                                        </li>
                                    </ol>
                                </nav>
                            </div>
                        </div>
                    </div>
                </div>
                <section className="mt-8">
                    <div className="container">
                        <div className="row">
                            <div className="col-md-6">
                                <div
                                    id="productSlider"
                                    className="carousel slide"
                                    data-bs-ride="carousel"
                                >
                                    <div className="carousel-inner">
                                        {product.images.map((image, index) => {
                                            return (
                                                <div
                                                    className={`carousel-item ${
                                                        index === 0
                                                            ? "active"
                                                            : ""
                                                    }`}
                                                >
                                                    <img
                                                        src={`/storage/images/${image.path}`}
                                                        className="d-block w-100"
                                                        alt={`Product ${index}`}
                                                    />
                                                </div>
                                            );
                                        })}
                                    </div>

                                    <div className="product-tools">
                                        <div
                                            className="thumbnails row g-3"
                                            id="productThumbnails"
                                        >
                                            {product.images.map(
                                                (image, index) => {
                                                    return (
                                                        <div className="col-3">
                                                            <div className="thumbnails-img">
                                                                <img
                                                                    src={`/storage/images/${image.path}`}
                                                                    alt={`Product ${index}`}
                                                                    className={`img-thumbnail ${
                                                                        index ===
                                                                        0
                                                                            ? "active"
                                                                            : ""
                                                                    }`}
                                                                    data-bs-target="#productSlider"
                                                                    data-bs-slide-to={
                                                                        index
                                                                    }
                                                                />
                                                            </div>
                                                        </div>
                                                    );
                                                }
                                            )}
                                        </div>
                                    </div>

                                    <button
                                        className="carousel-control-prev"
                                        type="button"
                                        data-bs-target="#productSlider"
                                        data-bs-slide="prev"
                                    >
                                        <span
                                            className="carousel-control-prev-icon"
                                            aria-hidden="true"
                                        ></span>
                                        <span className="visually-hidden">
                                            Previous
                                        </span>
                                    </button>
                                    <button
                                        className="carousel-control-next"
                                        type="button"
                                        data-bs-target="#productSlider"
                                        data-bs-slide="next"
                                    >
                                        <span
                                            className="carousel-control-next-icon"
                                            aria-hidden="true"
                                        ></span>
                                        <span className="visually-hidden">
                                            Next
                                        </span>
                                    </button>
                                </div>
                            </div>
                            <div className="col-md-6">
                                <div className="ps-lg-10 mt-6 mt-md-0">
                                    {/* content */}
                                    <a href="#!" className="mb-4 d-block">
                                        {product.category?.name}
                                    </a>
                                    {/* heading */}
                                    <h1 className="mb-1">{product?.name}</h1>
                                    <Rating
                                        value={product.ratings_avg_rating}
                                        color={"gold"}
                                    />
                                    <div className="fs-4">
                                        {/* price */}
                                        <span className="fw-bold text-dark">
                                            {product.price}
                                        </span>
                                    </div>
                                    {/* hr */}
                                    <hr className="my-6" />

                                    <div>
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
                                        <div className="col-xxl-4 col-lg-4 col-md-5 col-5 d-grid">
                                            <button
                                                type="button"
                                                className="btn btn-primary"
                                                onClick={() =>
                                                    handleAddToCart(product.id)
                                                }
                                            >
                                                <i className="feather-icon icon-shopping-bag me-2" />
                                                Add to cart
                                            </button>
                                        </div>
                                        <div className="col-md-4 col-4">
                                            {/* btn */}
                                            {/* <a
                                            className="btn btn-light "
                                            href="#"
                                            data-bs-toggle="tooltip"
                                            data-bs-html="true"
                                            aria-label="Compare"
                                        >
                                            <i className="bi bi-arrow-left-right" />
                                        </a> */}
                                            <a
                                                className="btn btn-light "
                                                data-bs-toggle="tooltip"
                                                data-bs-html="true"
                                                aria-label="Wishlist"
                                                onClick={() =>
                                                    handleAddToWishlist(
                                                        product.id
                                                    )
                                                }
                                            >
                                                <i className="feather-icon icon-heart" />
                                            </a>
                                        </div>
                                    </div>
                                    {/* hr */}
                                    <hr className="my-6" />
                                    <div>
                                        {/* table */}
                                        <table className="table table-borderless mb-0">
                                            <tbody>
                                                <tr>
                                                    <td>Fence Line Code:</td>
                                                    <td>
                                                        {product.fenceline_code}
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>Availability:</td>
                                                    <td>In Stock</td>
                                                </tr>
                                                <tr>
                                                    <td>Quality:</td>
                                                    <td>{product.quality} </td>
                                                </tr>
                                                <tr>
                                                    <td>Usage:</td>
                                                    <td>
                                                        {product.applications.map(
                                                            (app) => (
                                                                <p>
                                                                    {app.title}
                                                                </p>
                                                            )
                                                        )}
                                                    </td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                    <div className="mt-8">
                                        {/* dropdown */}
                                        <div className="dropdown">
                                            <a
                                                className="btn btn-outline-secondary dropdown-toggle"
                                                href="#"
                                                role="button"
                                                data-bs-toggle="dropdown"
                                                aria-expanded="false"
                                            >
                                                Share
                                            </a>
                                            <ul className="dropdown-menu">
                                                <li>
                                                    <a
                                                        className="dropdown-item"
                                                        href="#"
                                                    >
                                                        <i className="bi bi-facebook me-2" />
                                                        Facebook
                                                    </a>
                                                </li>
                                                <li>
                                                    <a
                                                        className="dropdown-item"
                                                        href="#"
                                                    >
                                                        <i className="bi bi-twitter me-2" />
                                                        Twitter
                                                    </a>
                                                </li>
                                                <li>
                                                    <a
                                                        className="dropdown-item"
                                                        href="#"
                                                    >
                                                        <i className="bi bi-instagram me-2" />
                                                        Instagram
                                                    </a>
                                                </li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </section>
                <section className="mt-lg-14 mt-8 ">
                    <div className="container">
                        <div className="row">
                            <div className="col-md-12">
                                <ul
                                    className="nav nav-pills nav-lb-tab"
                                    id="myTab"
                                    role="tablist"
                                >
                                    {/* nav item */}
                                    <li
                                        className="nav-item"
                                        role="presentation"
                                    >
                                        {/* btn */}{" "}
                                        <button
                                            className="nav-link active"
                                            id="product-tab"
                                            data-bs-toggle="tab"
                                            data-bs-target="#product-tab-pane"
                                            type="button"
                                            role="tab"
                                            aria-controls="product-tab-pane"
                                            aria-selected="true"
                                        >
                                            Product Details
                                        </button>
                                    </li>

                                    <li
                                        className="nav-item"
                                        role="presentation"
                                    >
                                        {/* btn */}{" "}
                                        <button
                                            className="nav-link"
                                            id="reviews-tab"
                                            data-bs-toggle="tab"
                                            data-bs-target="#reviews-tab-pane"
                                            type="button"
                                            role="tab"
                                            aria-controls="reviews-tab-pane"
                                            aria-selected="false"
                                        >
                                            Reviews
                                        </button>
                                    </li>
                                </ul>
                                {/* tab content */}
                                <div className="tab-content" id="myTabContent">
                                    {/* tab pane */}
                                    <div
                                        className="tab-pane fade show active"
                                        id="product-tab-pane"
                                        role="tabpanel"
                                        aria-labelledby="product-tab"
                                        tabIndex={0}
                                    >
                                        <div className="my-8">
                                            <div className="mb-5">
                                                {/* text */}
                                                <h4 className="mb-1">
                                                    Description
                                                </h4>
                                                <p className="mb-0">
                                                    {product.description}
                                                </p>
                                            </div>
                                            <h4 className="mb-1">Group</h4>

                                            {product.groups.map((app) => (
                                                <div className="mb-5">
                                                    <p className="mb-0">
                                                        {app.title}
                                                    </p>
                                                </div>
                                            ))}
                                            {/* content */}
                                            <h4 className="mb-1">Tags</h4>
                                            {product.tags.map((app) => (
                                                <div className="mb-5">
                                                    <p className="mb-0">
                                                        {app.title}
                                                    </p>
                                                </div>
                                            ))}
                                            <h4 className="mb-1">Usage</h4>
                                            {product.applications.map((app) => (
                                                <p>{app.title}</p>
                                            ))}
                                        </div>
                                    </div>

                                    <div
                                        className="tab-pane fade"
                                        id="reviews-tab-pane"
                                        role="tabpanel"
                                        aria-labelledby="reviews-tab"
                                        tabIndex={0}
                                    >
                                        <div className="my-8">
                                            <div className="row">
                                                <div className="col-md-4">
                                                    <div className="me-lg-12 mb-6 mb-md-0">
                                                        <div className="mb-5">
                                                            {/* title */}
                                                            <h4 className="mb-3">
                                                                Customer reviews
                                                            </h4>
                                                            {/* <span>
                                                                <Rating
                                                                    value={
                                                                        percentageData &&
                                                                        percentageData.avg_rating
                                                                    }
                                                                    color={
                                                                        "gold"
                                                                    }
                                                                />
                                                            </span>

                                                            <span className="ms-3">
                                                                {percentageData &&
                                                                    parseFloat(
                                                                        percentageData.avg_rating
                                                                    ).toFixed(
                                                                        2
                                                                    )}
                                                            </span> */}
                                                            <span
                                                                style={{
                                                                    display:
                                                                        "inline-flex",
                                                                    alignItems:
                                                                        "center",
                                                                }}
                                                            >
                                                                <Rating
                                                                    value={
                                                                        percentageData &&
                                                                        percentageData.avg_rating
                                                                    }
                                                                    color="gold"
                                                                />
                                                                <span className="ms-3">
                                                                    {percentageData &&
                                                                        parseFloat(
                                                                            percentageData.avg_rating
                                                                        ).toFixed(
                                                                            2
                                                                        )}
                                                                </span>
                                                            </span>
                                                        </div>
                                                        {percentageData && (
                                                            <div className="mb-8">
                                                                {/* progress */}
                                                                {[
                                                                    1, 2, 3, 4,
                                                                    5,
                                                                ].map(
                                                                    (
                                                                        rating
                                                                    ) => {
                                                                        const data =
                                                                            percentageData.percentage.find(
                                                                                (
                                                                                    item
                                                                                ) =>
                                                                                    item.rating ===
                                                                                    rating
                                                                            ) || {
                                                                                rating: rating,
                                                                                count: 0,
                                                                                percentage: 0,
                                                                            };

                                                                        return (
                                                                            <div
                                                                                className="d-flex align-items-center mb-2"
                                                                                key={
                                                                                    rating
                                                                                }
                                                                            >
                                                                                <div className="text-nowrap me-3 text-muted">
                                                                                    <span className="d-inline-block align-middle text-muted">
                                                                                        {
                                                                                            data.rating
                                                                                        }
                                                                                    </span>
                                                                                    <i
                                                                                        className="bi bi-star-fill"
                                                                                        style={{
                                                                                            color: "gold",
                                                                                        }}
                                                                                    />
                                                                                </div>
                                                                                <div className="w-100">
                                                                                    <div
                                                                                        className="progress"
                                                                                        style={{
                                                                                            height: 6,
                                                                                        }}
                                                                                    >
                                                                                        <div
                                                                                            className="progress-bar bg-warning"
                                                                                            role="progressbar"
                                                                                            style={{
                                                                                                width: `${data.percentage}%`,
                                                                                            }}
                                                                                            aria-valuenow={
                                                                                                data.count
                                                                                            }
                                                                                            aria-valuemin={
                                                                                                0
                                                                                            }
                                                                                            aria-valuemax={
                                                                                                100
                                                                                            }
                                                                                        />
                                                                                    </div>
                                                                                </div>
                                                                                <span className="text-muted ms-3">
                                                                                    {data.percentage &&
                                                                                        parseFloat(
                                                                                            data.percentage
                                                                                        ).toFixed(
                                                                                            2
                                                                                        )}

                                                                                    %
                                                                                </span>
                                                                            </div>
                                                                        );
                                                                    }
                                                                )}
                                                            </div>
                                                        )}

                                                        {!loggedin && (
                                                            <div className="d-grid">
                                                                <h4>
                                                                    Review this
                                                                    product
                                                                </h4>
                                                                <p className="mb-0">
                                                                    Share your
                                                                    thoughts
                                                                    with other
                                                                    customers.
                                                                </p>
                                                                {/* <a
                                                                href="#"
                                                                className="btn btn-outline-gray-400 mt-4 text-muted"
                                                            > */}
                                                                <Link
                                                                    to="/signin"
                                                                    className="btn btn-outline-gray-400 mt-4 text-muted"
                                                                >
                                                                    Write the
                                                                    Review
                                                                </Link>

                                                                {/* </a> */}
                                                            </div>
                                                        )}
                                                    </div>
                                                </div>
                                                {/* col */}
                                                <div className="col-md-8">
                                                    <div className="mb-10">
                                                        <div className="d-flex justify-content-between align-items-center mb-8">
                                                            <div>
                                                                {/* heading */}
                                                                <h4>Reviews</h4>
                                                            </div>
                                                            <div>
                                                                <select
                                                                    className="form-select"
                                                                    onChange={
                                                                        handleRatingChange
                                                                    }
                                                                >
                                                                    <option
                                                                        selected=""
                                                                        value={
                                                                            5
                                                                        }
                                                                    >
                                                                        Top
                                                                        Review
                                                                    </option>
                                                                    <option
                                                                        value={
                                                                            4
                                                                        }
                                                                    >
                                                                        Four
                                                                        Stars
                                                                    </option>
                                                                    <option
                                                                        value={
                                                                            3
                                                                        }
                                                                    >
                                                                        Three
                                                                        Stars
                                                                    </option>
                                                                    <option
                                                                        value={
                                                                            2
                                                                        }
                                                                    >
                                                                        Two
                                                                        Stars
                                                                    </option>
                                                                    <option
                                                                        value={
                                                                            1
                                                                        }
                                                                    >
                                                                        One
                                                                        Stars
                                                                    </option>
                                                                </select>
                                                            </div>
                                                        </div>
                                                        {reviews.length !==
                                                        0 ? (
                                                            reviews.map(
                                                                (review) => (
                                                                    <div
                                                                        className="d-flex border-bottom pb-6 mb-6"
                                                                        key={
                                                                            review.id
                                                                        }
                                                                    >
                                                                        <img
                                                                            src="../images/user.png"
                                                                            alt=""
                                                                            className="rounded-circle avatar-lg"
                                                                        />
                                                                        <div className="ms-5">
                                                                            <h6 className="mb-1">
                                                                                {
                                                                                    review
                                                                                        .user
                                                                                        .name
                                                                                }
                                                                            </h6>
                                                                            {/* select option */}
                                                                            {/* content */}
                                                                            <p className="small">
                                                                                {" "}
                                                                                <span className="text-muted">
                                                                                    {
                                                                                        review.created_at
                                                                                    }
                                                                                </span>
                                                                            </p>
                                                                            {/* rating */}
                                                                            <div className="mb-2">
                                                                                <Rating
                                                                                    value={
                                                                                        review.rating
                                                                                    }
                                                                                    color={
                                                                                        "gold"
                                                                                    }
                                                                                />
                                                                                <span className="text-dark fw-bold">
                                                                                    {
                                                                                        review.title
                                                                                    }
                                                                                </span>
                                                                            </div>
                                                                            {/* text*/}
                                                                            <p>
                                                                                {
                                                                                    review.description
                                                                                }
                                                                            </p>
                                                                        </div>
                                                                    </div>
                                                                )
                                                            )
                                                        ) : (
                                                            <div>
                                                                <p>
                                                                    No reviews
                                                                </p>
                                                            </div>
                                                        )}

                                                        {hasMoreReviews && (
                                                            <button
                                                                className="btn btn-outline-gray-400 text-muted"
                                                                onClick={
                                                                    handleReadMoreReviews
                                                                }
                                                            >
                                                                Read More
                                                                Reviews
                                                            </button>
                                                        )}
                                                    </div>
                                                    {loggedin && (
                                                        <div>
                                                            {/* rating */}
                                                            <h3 className="mb-5">
                                                                Create Review
                                                            </h3>
                                                            <div className="border-bottom py-4 mb-4">
                                                                <h4 className="mb-3">
                                                                    Overall
                                                                    rating
                                                                </h4>
                                                                <Rating
                                                                    value={
                                                                        rating ||
                                                                        0
                                                                    }
                                                                    color="gold"
                                                                    onClick={
                                                                        handleRatingClick
                                                                    }
                                                                />
                                                            </div>

                                                            {/* form control */}
                                                            <div className="border-bottom py-4 mb-4">
                                                                <h5>
                                                                    Add a title
                                                                </h5>
                                                                <input
                                                                    type="text"
                                                                    className="form-control"
                                                                    placeholder="What’s most important to know"
                                                                    value={
                                                                        title
                                                                    }
                                                                    onChange={(
                                                                        e
                                                                    ) =>
                                                                        setTitle(
                                                                            e
                                                                                .target
                                                                                .value
                                                                        )
                                                                    }
                                                                />
                                                            </div>

                                                            <div className=" py-4 mb-4">
                                                                <h5>
                                                                    Add a
                                                                    written
                                                                    review
                                                                </h5>
                                                                <textarea
                                                                    className="form-control"
                                                                    rows={3}
                                                                    placeholder="What did you like or dislike? What did you use this product for?"
                                                                    value={
                                                                        description
                                                                    }
                                                                    onChange={(
                                                                        e
                                                                    ) =>
                                                                        setDescription(
                                                                            e
                                                                                .target
                                                                                .value
                                                                        )
                                                                    }
                                                                />
                                                            </div>

                                                            <div className="d-flex justify-content-end">
                                                                <a
                                                                    href="#"
                                                                    className="btn btn-primary"
                                                                    onClick={
                                                                        handleSubmit
                                                                    }
                                                                >
                                                                    Submit
                                                                    Review
                                                                </a>
                                                            </div>
                                                        </div>
                                                    )}
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    {/* tab pane */}
                                    <div
                                        className="tab-pane fade"
                                        id="sellerInfo-tab-pane"
                                        role="tabpanel"
                                        aria-labelledby="sellerInfo-tab"
                                        tabIndex={0}
                                    >
                                        ...
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </section>
                {/* section */}
                <section className="my-lg-14 my-14">
                    <div className="container">
                        {/* row */}
                        <div className="row">
                            <div className="col-12">
                                {/* heading */}
                                <h3>Related Items</h3>
                            </div>
                        </div>
                        {/* row */}
                        <div className="row g-4 row-cols-lg-5 row-cols-2 row-cols-md-2 mt-2">
                            {relatedProducts?.map((product) => (
                                <div className="col">
                                    <div className="card card-product">
                                        <div className="card-body">
                                            <div className="text-center position-relative ">
                                                <a href="#!">
                                                    {/* img */}
                                                    <img
                                                        src={`/storage/images/${product.image?.path}`}
                                                        alt="Grocery Ecommerce Template"
                                                        className="mb-3 img-fluid"
                                                    />
                                                </a>
                                                {/* action btn */}
                                                <div className="card-product-action">
                                                    <a
                                                        className="btn btn-light "
                                                        data-bs-toggle="tooltip"
                                                        data-bs-html="true"
                                                        aria-label="Wishlist"
                                                        onClick={() =>
                                                            handleAddToWishlist(
                                                                product.id
                                                            )
                                                        }
                                                    >
                                                        <i className="feather-icon icon-heart" />
                                                    </a>
                                                </div>
                                            </div>
                                            {/* heading */}
                                            <div className="text-small mb-1">
                                                <a
                                                    href="#!"
                                                    className="text-decoration-none text-muted"
                                                >
                                                    <small>
                                                        {product.category.name}
                                                    </small>
                                                </a>
                                            </div>
                                            <h2 className="fs-6">
                                                <a
                                                    href="#!"
                                                    className="text-inherit text-decoration-none"
                                                >
                                                    {product.name}
                                                </a>
                                            </h2>
                                            <Rating
                                                value={
                                                    product.ratings_avg_rating
                                                }
                                                color={"gold"}
                                            />
                                            {/* price */}
                                            <div className="d-flex justify-content-between align-items-center mt-3">
                                                <div>
                                                    <span className="text-dark">
                                                        ${product.price}
                                                    </span>{" "}
                                                </div>
                                                {/* btn */}
                                                <div>
                                                    <a
                                                        href="#!"
                                                        className="btn btn-primary btn-sm"
                                                    >
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
                                                        Add
                                                    </a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            ))}
                        </div>
                    </div>
                </section>
            </main>

            <MainFooter />
        </>
    );
}

export default ProductPage;
