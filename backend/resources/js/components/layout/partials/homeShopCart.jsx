import React, { useEffect } from "react";
import { useState } from "react";
import axios from "axios";
import { toast } from "react-toastify";
import "react-toastify/dist/ReactToastify.css";
import { Bars } from "react-loader-spinner";

function HomeShopCart({ isLoading }) {
    const [items, setItems] = useState([{ product: { image: {} } }]);

    useEffect(() => {
        if (!localStorage.getItem("userToken")) return;
        axios
            .get("/api/cart/list", {
                headers: {
                    Authorization: `Bearer ${localStorage.getItem(
                        "userToken"
                    )}`,
                },
            })
            .then((response) => {
                setItems(response.data.result);
            })
            .catch((error) => {
                console.log(error);
            });
    }, [isLoading]);

    console.log(items);
    const handleIncrement = (id) => {
        axios
            .get(`/api/cart/update/${id}`, {
                headers: {
                    Authorization: `Bearer ${localStorage.getItem(
                        "userToken"
                    )}`,
                },
            })
            .then((response) => {
                const tempItem = items.map((item) =>
                    item.id === id
                        ? { ...item, quantity: item.quantity + 1 }
                        : item
                );
                setItems(tempItem);
            })
            .catch((error) => {
                console.log(error);
            });
    };

    const handleDecrement = (id) => {
        axios
            .get(`/api/cart/update/${id}`, {
                headers: {
                    Authorization: `Bearer ${localStorage.getItem(
                        "userToken"
                    )}`,
                },
            })
            .then((response) => {
                const tempItem = items.map((item) =>
                    item.id === id && item.quantity > 1
                        ? { ...item, quantity: item.quantity - 1 }
                        : item
                );
                setItems(tempItem);
            })
            .catch((error) => {
                console.log(error);
            });
    };

    // Function to remove an item from the cart
    const handleRemove = (id) => {
        axios
            .delete(`/api/cart/remove/${id}`, {
                headers: {
                    Authorization: `Bearer ${localStorage.getItem(
                        "userToken"
                    )}`,
                },
            })
            .then((response) => {
                const tempItems = items.filter((item) => item.id !== id);
                setItems(tempItems);
            })
            .catch((error) => {
                console.log(error);
            });
    };

    const handleQuantityChange = (id) => {
        axios
            .get(`/api/cart/update/${id}`, {
                headers: {
                    Authorization: `Bearer ${localStorage.getItem(
                        "userToken"
                    )}`,
                },
            })
            .then((response) => {
                setItems(response.data.result);
            })
            .catch((error) => {
                console.log(error);
            });
    };

    function handleCheckout() {
        const userAddress = localStorage.getItem("address");
        // if (!userAddress) {
        //     toast.error("Please Enter Address in Account-Address page!");
        // } else {
        axios
            .post(`/api/order/store`, null, {
                headers: {
                    Authorization: `Bearer ${localStorage.getItem(
                        "userToken"
                    )}`,
                },
            })
            .then((response) => {
                if (response.status === 200) {
                    console.log(response.data.result);
                    setItems([]);
                    toast.success("Checkout Complete!");
                } else {
                    toast.error("Failed to Checkout");
                }
            })
            .catch((error) => {
                console.error(error);
            });
        // }
    }

    return (
        <>
            <div
                className="offcanvas offcanvas-end"
                tabIndex={-1}
                id="offcanvasRight"
                aria-labelledby="offcanvasRightLabel"
            >
                <div className="offcanvas-header ">
                    <div className="text-start">
                        <h5 id="offcanvasRightLabel" className="mb-0 fs-4">
                            Shop Cart
                        </h5>
                    </div>
                    {/* <button
                        type="button"
                        className="btn-close text-reset"
                        data-bs-dismiss="offcanvas"
                        aria-label="Close"
                    /> */}
                </div>
                <div className="offcanvas-body">
                    <div className="">
                        {/* alert */}

                        <ul className="list-group list-group-flush">
                            {items &&
                                items.map((item) => (
                                    <li
                                        key={item.id}
                                        className="list-group-item py-3 ps-0 border-top"
                                    >
                                        <div className="row align-items-center">
                                            <div className="col-3 col-md-2">
                                                <img
                                                    src={`/storage/images/${item.product.image.path}`}
                                                    alt="Ecommerce"
                                                    className="img-fluid"
                                                />
                                            </div>
                                            <div className="col-4 col-md-6 col-lg-5">
                                                <a className="text-inherit">
                                                    <h6 className="mb-0">
                                                        {item.product.name}
                                                    </h6>
                                                </a>
                                                {/* <span>
                                                <small className="text-muted">
                                                    {item.weight}
                                                </small>
                                            </span>  */}

                                                <div className="mt-2 small lh-1">
                                                    <a
                                                        className="text-decoration-none text-inherit"
                                                        onClick={() =>
                                                            handleRemove(
                                                                item.id
                                                            )
                                                        }
                                                    >
                                                        <span className="me-1 align-text-bottom">
                                                            <svg
                                                                xmlns="http://www.w3.org/2000/svg"
                                                                width={14}
                                                                height={14}
                                                                viewBox="0 0 24 24"
                                                                fill="none"
                                                                stroke="currentColor"
                                                                strokeWidth={2}
                                                                strokeLinecap="round"
                                                                strokeLinejoin="round"
                                                                className="feather feather-trash-2 text-success"
                                                            >
                                                                <polyline points="3 6 5 6 21 6" />
                                                                <path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"></path>
                                                                <line
                                                                    x1={10}
                                                                    y1={11}
                                                                    x2={10}
                                                                    y2={17}
                                                                />
                                                                <line
                                                                    x1={14}
                                                                    y1={11}
                                                                    x2={14}
                                                                    y2={17}
                                                                />
                                                            </svg>
                                                        </span>
                                                        <span
                                                            className="text-muted"
                                                            style={{
                                                                cursor: "pointer",
                                                            }}
                                                        >
                                                            Remove
                                                        </span>
                                                    </a>
                                                </div>
                                            </div>

                                            <div className="col-3 col-md-3 col-lg-3">
                                                <div className="input-group input-spinner  ">
                                                    <input
                                                        type="button"
                                                        defaultValue="-"
                                                        className="button-minus  btn  btn-sm "
                                                        data-field="quantity"
                                                        onClick={() =>
                                                            handleDecrement(
                                                                item.id
                                                            )
                                                        }
                                                    />
                                                    <input
                                                        type="number"
                                                        step={1}
                                                        max={10}
                                                        value={item.quantity}
                                                        name="quantity"
                                                        className="quantity-field form-control-sm form-input   "
                                                        onChange={(e) =>
                                                            handleQuantityChange(
                                                                e.target.value,
                                                                item.id
                                                            )
                                                        }
                                                    />
                                                    <input
                                                        type="button"
                                                        defaultValue="+"
                                                        className="button-plus btn btn-sm "
                                                        data-field="quantity"
                                                        onClick={() =>
                                                            handleIncrement(
                                                                item.id
                                                            )
                                                        }
                                                    />
                                                </div>
                                            </div>

                                            <div className="col-2 text-lg-end text-start text-md-end col-md-2">
                                                <span className="fw-bold text-danger">
                                                    {item.price_per_unit}
                                                </span>
                                                {/* <div className="text-decoration-line-through text-muted small">
                                                {item.oldPrice}
                                            </div> */}
                                            </div>
                                        </div>
                                    </li>
                                ))}
                        </ul>
                        {items.length === 0 ? (
                            <div>No Products in Cart</div>
                        ) : (
                            <div className="d-flex justify-content-between mt-4">
                                <a className="btn btn-primary">
                                    Continue Shopping
                                </a>
                                <a
                                    className="btn btn-dark"
                                    onClick={handleCheckout}
                                >
                                    Checkout
                                </a>
                            </div>
                        )}
                    </div>
                </div>
            </div>

            <div
                className="modal fade"
                id="locationModal"
                tabIndex={-1}
                aria-labelledby="locationModalLabel"
                aria-hidden="true"
            >
                <div className="modal-dialog modal-sm modal-dialog-centered">
                    <div className="modal-content">
                        <div className="modal-body p-6">
                            <div className="d-flex justify-content-between align-items-start ">
                                <div>
                                    <h5
                                        className="mb-1"
                                        id="locationModalLabel"
                                    >
                                        Choose your Delivery Location
                                    </h5>
                                    <p className="mb-0 small">
                                        Enter your address and we will specify
                                        the offer you area.{" "}
                                    </p>
                                </div>
                                <button
                                    type="button"
                                    className="btn-close"
                                    data-bs-dismiss="modal"
                                    aria-label="Close"
                                />
                            </div>
                            <div className="my-5">
                                <input
                                    type="search"
                                    className="form-control"
                                    placeholder="Search your area"
                                />
                            </div>
                            <div className="d-flex justify-content-between align-items-center mb-2">
                                <h6 className="mb-0">Select Location</h6>
                                <a
                                    href="#"
                                    className="btn btn-outline-gray-400 text-muted btn-sm"
                                >
                                    Clear All
                                </a>
                            </div>
                            <div>
                                <div data-simplebar="" style={{ height: 300 }}>
                                    <div className="list-group list-group-flush">
                                        <a
                                            href="#"
                                            className="list-group-item d-flex justify-content-between align-items-center px-2 py-3 list-group-item-action active"
                                        >
                                            <span>Alabama</span>
                                            <span>Min:$20</span>
                                        </a>
                                        <a
                                            href="#"
                                            className="list-group-item d-flex justify-content-between align-items-center px-2 py-3 list-group-item-action"
                                        >
                                            <span>Alaska</span>
                                            <span>Min:$30</span>
                                        </a>
                                        <a
                                            href="#"
                                            className="list-group-item d-flex justify-content-between align-items-center px-2 py-3 list-group-item-action"
                                        >
                                            <span>Arizona</span>
                                            <span>Min:$50</span>
                                        </a>
                                        <a
                                            href="#"
                                            className="list-group-item d-flex justify-content-between align-items-center px-2 py-3 list-group-item-action"
                                        >
                                            <span>California</span>
                                            <span>Min:$29</span>
                                        </a>
                                        <a
                                            href="#"
                                            className="list-group-item d-flex justify-content-between align-items-center px-2 py-3 list-group-item-action"
                                        >
                                            <span>Colorado</span>
                                            <span>Min:$80</span>
                                        </a>
                                        <a
                                            href="#"
                                            className="list-group-item d-flex justify-content-between align-items-center px-2 py-3 list-group-item-action"
                                        >
                                            <span>Florida</span>
                                            <span>Min:$90</span>
                                        </a>
                                        <a
                                            href="#"
                                            className="list-group-item d-flex justify-content-between align-items-center px-2 py-3 list-group-item-action"
                                        >
                                            <span>Arizona</span>
                                            <span>Min:$50</span>
                                        </a>
                                        <a
                                            href="#"
                                            className="list-group-item d-flex justify-content-between align-items-center px-2 py-3 list-group-item-action"
                                        >
                                            <span>California</span>
                                            <span>Min:$29</span>
                                        </a>
                                        <a
                                            href="#"
                                            className="list-group-item d-flex justify-content-between align-items-center px-2 py-3 list-group-item-action"
                                        >
                                            <span>Colorado</span>
                                            <span>Min:$80</span>
                                        </a>
                                        <a
                                            href="#"
                                            className="list-group-item d-flex justify-content-between align-items-center px-2 py-3 list-group-item-action"
                                        >
                                            <span>Florida</span>
                                            <span>Min:$90</span>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </>
    );
}
export default HomeShopCart;
