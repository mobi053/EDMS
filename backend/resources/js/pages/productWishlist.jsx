import React from "react";
import NavbarSearch from "../components/layout/partials/navbarSearch";
import MainNavbar from "../components/layout/partials/mainNavbar";
import MainFooter from "../components/layout/partials/mainFooter";
import HomeSignup from "../components/layout/partials/homeSignup";
import HomeShopCart from "../components/layout/partials/homeShopCart";
import { useState, useEffect } from "react";
import { useNavigate } from "react-router-dom";
import { Bars } from "react-loader-spinner";

import { toast } from "react-toastify";
import "react-toastify/dist/ReactToastify.css";
import axios from "axios";

function ProductWishlist() {
    const [products, setProducts] = useState([]);
    const navigate = useNavigate(); // import useNavigate hook
    const [loading, setLoading] = useState(false);

    useEffect(() => {
        setLoading(true);
        axios
            .get("/api/wishlist/list", {
                headers: {
                    Authorization: `Bearer ${localStorage.getItem(
                        "userToken"
                    )}`,
                },
            })
            .then((response) => {
                setProducts(response.data.result);
                console.log(response.data.result);
            })
            .catch((error) => {
                console.log(error);
            })
            .finally(() => {
                setLoading(false);
            });
    }, []);

    const removeFromWishlist = (productId) => {
        axios
            .delete(`/api/wishlist/remove/${productId}`, {
                headers: {
                    Authorization: `Bearer ${localStorage.getItem(
                        "userToken"
                    )}`,
                },
            })
            .then((response) => {
                if (response.status === 200) {
                    axios
                        .get("/api/wishlist/list", {
                            headers: {
                                Authorization: `Bearer ${localStorage.getItem(
                                    "userToken"
                                )}`,
                            },
                        })
                        .then((response) => {
                            setProducts(response.data.result);
                        })
                        .catch((error) => {
                            console.log(error);
                        });

                    toast.success("Product Removed From wishlist!");

                    navigate("/product-wishlist");
                } else {
                    toast.error("Failed to Remove the item from wishList");
                }
            })
            .catch((error) => {
                // handle error
                console.error(error);
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
            <HomeShopCart />

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
                                        <a href="#!">Home</a>
                                    </li>
                                    <li className="breadcrumb-item">
                                        <a href="#!">Products</a>
                                    </li>
                                    <li
                                        className="breadcrumb-item active"
                                        aria-current="page"
                                    >
                                        My Wishlist
                                    </li>
                                </ol>
                            </nav>
                        </div>
                    </div>
                </div>
            </div>
            <section className="mt-8 mb-14">
                <div className="container">
                    {/* row */}
                    <div className="row">
                        <div className="col-lg-12">
                            <div className="mb-8">
                                <h1 className="mb-1">My Wishlist</h1>
                            </div>
                            <div>
                                {/* table */}
                                <div className="table-responsive">
                                    <table className="table text-nowrap table-with-checkbox">
                                        <thead className="table-light">
                                            <tr>
                                                <th>
                                                    {/* form check */}
                                                    <div className="form-check">
                                                        {/* input */}
                                                        <input
                                                            className="form-check-input"
                                                            type="checkbox"
                                                            defaultValue=""
                                                            id="checkAll"
                                                        />
                                                        {/* label */}
                                                        <label
                                                            className="form-check-label"
                                                            htmlFor="checkAll"
                                                        ></label>
                                                    </div>
                                                </th>
                                                <th />
                                                <th>Product</th>
                                                <th>Amount</th>
                                                <th>Status</th>
                                                <th>Actions</th>
                                                <th>Remove</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            {products.map((product) => (
                                                <tr key={product.id}>
                                                    <td className="align-middle">
                                                        <div className="form-check">
                                                            <input
                                                                className="form-check-input"
                                                                type="checkbox"
                                                                defaultValue=""
                                                                id="chechboxTwo"
                                                            />

                                                            <label
                                                                className="form-check-label"
                                                                htmlFor="chechboxTwo"
                                                            ></label>
                                                        </div>
                                                    </td>
                                                    <td className="align-middle">
                                                        <a href="#">
                                                            <img
                                                                src={`/storage/images/${product.image?.path}`}
                                                                className="icon-shape icon-xxl"
                                                                alt=""
                                                            />
                                                        </a>
                                                    </td>
                                                    <td className="align-middle">
                                                        <div>
                                                            <h5 className="fs-6 mb-0">
                                                                <a
                                                                    href="#"
                                                                    className="text-inherit"
                                                                >
                                                                    {
                                                                        product
                                                                            .product
                                                                            .name
                                                                    }
                                                                </a>
                                                            </h5>
                                                            <small>
                                                                $.98 / lb
                                                            </small>
                                                        </div>
                                                    </td>
                                                    <td className="align-middle">
                                                        $35.00
                                                    </td>
                                                    <td className="align-middle">
                                                        <span className="badge bg-success">
                                                            In Stock
                                                        </span>
                                                    </td>
                                                    <td className="align-middle">
                                                        <div
                                                            className="btn btn-primary btn-sm"
                                                            onClick={() =>
                                                                handleAddToCart(
                                                                    product.id
                                                                )
                                                            }
                                                        >
                                                            Add to Cart
                                                        </div>
                                                    </td>
                                                    <td className="align-middle ">
                                                        <a
                                                            href="#"
                                                            className="text-muted"
                                                            data-bs-toggle="tooltip"
                                                            data-bs-placement="top"
                                                            title="Cancel"
                                                            onClick={() =>
                                                                removeFromWishlist(
                                                                    product.id
                                                                )
                                                            }
                                                        >
                                                            <i className="feather-icon icon-trash-2" />
                                                        </a>
                                                    </td>
                                                </tr>
                                            ))}
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>

            <MainFooter />
        </>
    );
}

export default ProductWishlist;
