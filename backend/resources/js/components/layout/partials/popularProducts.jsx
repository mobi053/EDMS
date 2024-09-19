import React from "react";
import { useState, useEffect } from "react";
import axios from "axios";
import { Link } from "react-router-dom";
import { toast } from "react-toastify";
import "react-toastify/dist/ReactToastify.css";
import { useNavigate } from "react-router-dom";
import { Bars } from "react-loader-spinner";
import { useParams } from "react-router-dom";
import Rating from "../../shared/Ratings";

function PopularProducts() {
    const { loggedin, setLoggedin } = useState(false);
    const { productId } = useParams();
    const [products, setProducts] = useState([]);
    const [loading, setLoading] = useState(false);
    const [avgRating, setAvgRating] = useState();
    const [percentages, setPercentages] = useState([]);
    const navigate = useNavigate();

    // let product_Id;

    //call the popular product api to display them
    useEffect(() => {
        setLoading(true);
        axios
            .get("/api/product/popular", {
                headers: {
                    Authorization: `Bearer ${localStorage.getItem(
                        "userToken"
                    )}`,
                },
            })
            .then((response) => {
                setProducts(response.data.result);
                // product_Id = response.data.result.id;
            })
            .catch((error) => {
                console.log(error);
            })
            .finally(() => {
                setLoading(false);
            });
    }, []);

    // fucntion for adding products to wishlist
    function handleAddToWishlist(productID) {
        if (localStorage.getItem("userToken")) {
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
                    console.log(response);
                })
                .catch((error) => {
                    // Handle error response
                    console.error(error);
                })
                .finally(() => {
                    setLoading(false);
                });
        } else {
            navigate("/signin");
        }
    }

    function addToCart(productId, quantity) {
        if (localStorage.getItem("userToken")) {
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
        } else {
            navigate("/signin");
        }
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
            <div className="container">
                <div className="row">
                    <div className="col-12 mb-6">
                        <h3 className="mb-0">Popular Products</h3>
                    </div>
                </div>
                <div className="row g-4 row-cols-lg-5 row-cols-2 row-cols-md-3">
                    {products.map((product) => (
                        <div className="col" key={product.id}>
                            <div className="card card-product">
                                <div className="card-body">
                                    <div className="text-center position-relative ">
                                        <Link to={`/productPage/${product.id}`}>
                                            <img
                                                src={`/storage/images/${product.image?.path}`}
                                                alt="Grocery Ecommerce Template"
                                                className="mb-3 img-fluid"
                                            />
                                        </Link>
                                        <div className="card-product-action">
                                            <a
                                                href="#!"
                                                className="btn-action"
                                                data-bs-toggle="tooltip"
                                                data-bs-html="true"
                                                title="Wishlist"
                                                onClick={() =>
                                                    handleAddToWishlist(
                                                        product.id
                                                    )
                                                }
                                            >
                                                <i className="bi bi-heart" />
                                            </a>
                                        </div>
                                    </div>
                                    <div className="text-small mb-1">
                                        <a
                                            href="#!"
                                            className="text-decoration-none text-muted"
                                        >
                                            {product.category.name}
                                        </a>
                                    </div>
                                    <h2 className="fs-6">
                                        <a
                                            href="./pages/shop-single.html"
                                            className="text-inherit text-decoration-none"
                                        >
                                            {product.name}
                                        </a>
                                    </h2>
                                    <Rating
                                        value={product.ratings_avg_rating}
                                        color={"gold"}
                                    />

                                    <div className="d-flex justify-content-between align-items-center mt-3">
                                        <div>
                                            <span className="text-dark">
                                                ${product.price}
                                            </span>{" "}
                                        </div>
                                        <div>
                                            <a
                                                href="#!"
                                                className="btn btn-primary btn-sm"
                                                onClick={() =>
                                                    handleAddToCart(product.id)
                                                }
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
        </>
    );
}
export default PopularProducts;
