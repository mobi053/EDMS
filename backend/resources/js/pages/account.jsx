import React, { useEffect, useState } from "react";
import NavbarSearch from "../components/layout/partials/navbarSearch";
import MainNavbar from "../components/layout/partials/mainNavbar";
import MainFooter from "../components/layout/partials/mainFooter";
import HomeSignup from "../components/layout/partials/homeSignup";
import HomeShopCart from "../components/layout/partials/homeShopCart";
import { Link, useNavigate } from "react-router-dom";
import axios from "axios";
import { toast } from "react-toastify";
import { Bars } from "react-loader-spinner";
import moment from "moment";
import "react-toastify/dist/ReactToastify.css";
import { Button, Modal } from "react-bootstrap";

function Accounts() {
    const [showModal, setShowModal] = useState(false);
    const [logoutSuccess, setLogoutSuccess] = useState(false);
    const navigate = useNavigate();
    const [orders, setOrders] = useState([]);
    const [loading, setLoading] = useState(false);
    const [items, setItems] = useState([]);
    useEffect(() => {
        setLoading(true);
        axios
            .get("/api/order/list", {
                headers: {
                    Authorization: `Bearer ${localStorage.getItem(
                        "userToken"
                    )}`,
                },
            })
            .then((response) => {
                setOrders(response.data.result);
            })
            .catch((error) => {
                console.log(error);
            })
            .finally(() => {
                setLoading(false);
            });
    }, []);
    const handleLogout = async () => {
        try {
            const response = await axios.post(
                "/api/auth/logout",
                {},
                {
                    headers: {
                        Authorization: `Bearer ${localStorage.getItem(
                            "userToken"
                        )}`,
                    },
                }
            );
            if (response.status === 200) {
                setLogoutSuccess(true);
                localStorage.removeItem("userToken");
                toast.success("Logout successful!");
                window.location.reload();

                // navigate("/");
            }
        } catch (error) {
            console.log(error);
        }
    };
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
            {/* Modal */}
            <HomeSignup />
            {/* Shop Cart */}
            <HomeShopCart />

            <>
                <main>
                    <section style={{ minHeight: "50vh" }}>
                        <div className="container">
                            {/* row */}
                            <div className="row">
                                {/* col */}
                                <div className="col-12">
                                    <div className="d-flex justify-content-between align-items-center d-md-none py-4">
                                        {/* heading */}
                                        <h3 className="fs-5 mb-0">
                                            Account Setting
                                        </h3>
                                        {/* button */}
                                        <button
                                            className="btn btn-outline-gray-400 text-muted d-md-none btn-icon btn-sm ms-3 "
                                            type="button"
                                            data-bs-toggle="offcanvas"
                                            data-bs-target="#offcanvasAccount"
                                            aria-controls="offcanvasAccount"
                                        >
                                            <i className="bi bi-text-indent-left fs-3" />
                                        </button>
                                    </div>
                                </div>
                                {/* col */}
                                <div className="col-lg-3 col-md-4 col-12 border-end  d-none d-md-block">
                                    <div className="pt-10 pe-lg-10">
                                        {/* nav */}
                                        <ul className="nav flex-column  ">
                                            {/* nav item */}
                                            <li className="nav-item">
                                                <Link
                                                    to="/account-orders"
                                                    className="nav-link active"
                                                >
                                                    <i className="feather-icon icon-settings me-2" />
                                                    Your Orders
                                                </Link>
                                            </li>
                                            {/* nav item */}
                                            <li className="nav-item">
                                                <Link
                                                    to="/account-settings"
                                                    className="nav-link active"
                                                >
                                                    <i className="feather-icon icon-settings me-2" />
                                                    Settings
                                                </Link>
                                            </li>
                                            {/* nav item */}
                                            <li className="nav-item">
                                                <Link
                                                    to="/account-address"
                                                    className="nav-link active"
                                                >
                                                    <i className="feather-icon icon-settings me-2" />
                                                    Address
                                                </Link>
                                            </li>
                                            {/* nav item */}
                                            <li className="nav-item">
                                                <Link
                                                    to="/account-payment"
                                                    className="nav-link active"
                                                >
                                                    <i className="feather-icon icon-settings me-2" />
                                                    Payment Method
                                                </Link>
                                            </li>
                                            {/* nav item */}
                                            {/* <li className="nav-item">
                                        <Link
                                            to="/account-notification"
                                            className="nav-link"
                                        >
                                            <i className="feather-icon icon-settings me-2" />
                                            Notification
                                        </Link>
                                    </li> */}
                                            {/* nav item */}
                                            <li className="nav-item">
                                                <hr />
                                            </li>

                                            <li
                                                className="nav-item"
                                                onClick={handleLogout}
                                            >
                                                <Link
                                                    to="/"
                                                    className="nav-link active"
                                                >
                                                    <i className="feather-icon icon-settings me-2" />
                                                    Log out
                                                </Link>
                                            </li>
                                        </ul>
                                        {logoutSuccess && (
                                            <p>
                                                Logout successful. Redirecting
                                                to home page...
                                            </p>
                                        )}
                                    </div>
                                </div>
                                <div className="col-lg-9 col-md-8 col-12">
                                    <div className="py-6 p-md-6 p-lg-10">
                                        {/* heading */}
                                        <h2 className="mb-6">Your Orders</h2>
                                        <div className="table-responsive-xxl border-0">
                                            {/* Table */}
                                            <table className="table mb-0 text-nowrap table-centered ">
                                                {/* Table Head */}
                                                <thead className="bg-light">
                                                    <tr>
                                                        <th>Order</th>
                                                        <th>Date</th>
                                                        <th>Items</th>
                                                        <th>Status</th>
                                                        <th>Amount</th>
                                                        <th />
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    {orders.map((order) => (
                                                        <tr key={order.id}>
                                                            {/* <td className="align-middle border-top-0 w-0">
                                                        <a href="#">
                                                            {" "}
                                                            <img
                                                                src={`/storage/images/${order.cart_details[0].product.image.path}`}
                                                                alt={
                                                                    order
                                                                        .cart_details[0]
                                                                        .product
                                                                        .name
                                                                }
                                                                className="icon-shape icon-xl"
                                                            />
                                                        </a>
                                                    </td>
                                                    <td className="align-middle border-top-0">
                                                        <a
                                                            href="#"
                                                            className="fw-semi-bold text-inherit"
                                                        >
                                                            <h6 className="mb-0">
                                                                {
                                                                    order
                                                                        .cart_details[0]
                                                                        .product
                                                                        .name
                                                                }
                                                            </h6>
                                                        </a>
                                                    </td> */}
                                                            <td className="align-middle border-top-0">
                                                                <a
                                                                    href="#"
                                                                    className="text-inherit"
                                                                >
                                                                    #{order.id}
                                                                </a>
                                                            </td>
                                                            <td className="align-middle border-top-0">
                                                                {moment(
                                                                    order.created_at
                                                                ).format(
                                                                    "MMMM D, YYYY"
                                                                )}
                                                            </td>
                                                            <td className="align-middle border-top-0">
                                                                {
                                                                    order
                                                                        .cart_details
                                                                        .length
                                                                }
                                                            </td>
                                                            <td className="align-middle border-top-0">
                                                                <span
                                                                    className={`badge bg-${
                                                                        order.status ===
                                                                        "Pending"
                                                                            ? "warning"
                                                                            : "success"
                                                                    }`}
                                                                >
                                                                    {
                                                                        order.status
                                                                    }
                                                                </span>
                                                            </td>
                                                            <td className="align-middle border-top-0">
                                                                $
                                                                {
                                                                    order.total_amount
                                                                }
                                                            </td>
                                                            <td className="text-muted align-middle border-top-0">
                                                                <a
                                                                    className="text-inherit"
                                                                    data-bs-toggle="tooltip"
                                                                    data-bs-placement="top"
                                                                    data-bs-title="View"
                                                                    onClick={() => {
                                                                        setShowModal(
                                                                            true
                                                                        );
                                                                        setItems(
                                                                            order.cart_details
                                                                        );
                                                                    }}
                                                                >
                                                                    <i className="feather-icon icon-eye" />
                                                                </a>{" "}
                                                                <a
                                                                    className="text-inherit"
                                                                    data-bs-toggle="tooltip"
                                                                    data-bs-placement="top"
                                                                    data-bs-title="View"
                                                                    href={`/invoice/${order.id}`}
                                                                    target="_blank"
                                                                >
                                                                    <i className="feather-icon icon-file" />
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
                </main>
                <div
                    className="offcanvas offcanvas-start"
                    tabIndex={-1}
                    id="offcanvasAccount"
                    aria-labelledby="offcanvasAccountLabel"
                >
                    {/* offcanvas header */}
                    <div className="offcanvas-header">
                        <h5
                            className="offcanvas-title"
                            id="offcanvasAccountLabel"
                        >
                            My Account
                        </h5>
                        <button
                            type="button"
                            className="btn-close"
                            data-bs-dismiss="offcanvas"
                            aria-label="Close"
                        />
                    </div>
                    {/* offcanvas body */}
                    <div className="offcanvas-body">
                        <ul className="nav flex-column nav-pills nav-pills-dark">
                            {/* nav item */}
                            <li className="nav-item">
                                <Link
                                    to="/account-orders"
                                    className="nav-link active"
                                >
                                    <i className="feather-icon icon-settings me-2" />
                                    Your Orders
                                </Link>
                            </li>
                            {/* nav item */}
                            <li className="nav-item">
                                <Link
                                    to="/account-settings"
                                    className="nav-link"
                                >
                                    <i className="feather-icon icon-settings me-2" />
                                    Settings
                                </Link>
                            </li>
                            {/* nav item */}
                            <li className="nav-item">
                                <Link
                                    to="/account-address"
                                    className="nav-link"
                                >
                                    <i className="feather-icon icon-settings me-2" />
                                    Address
                                </Link>
                            </li>
                            {/* nav item */}
                            <li className="nav-item">
                                <Link
                                    to="/account-payment"
                                    className="nav-link"
                                >
                                    <i className="feather-icon icon-settings me-2" />
                                    Payment Method
                                </Link>
                            </li>
                            {/* nav item */}
                            {/* <li className="nav-item">
                            <Link
                                to="/account-notification"
                                className="nav-link"
                            >
                                <i className="feather-icon icon-settings me-2" />
                                Notification
                            </Link>
                        </li> */}
                            {/* nav item */}
                            <li className="nav-item">
                                <hr />
                            </li>
                        </ul>
                        <hr className="my-6" />
                        <div>
                            {/* nav  */}
                            <ul className="nav flex-column nav-pills nav-pills-dark">
                                {/* nav item */}
                                <li className="nav-item" onClick={handleLogout}>
                                    <span className="nav-link">
                                        <i className="feather-icon icon-log-out me-2" />
                                        Log out
                                    </span>
                                </li>
                                <li></li>
                            </ul>

                            <Modal
                                show={showModal}
                                onHide={() => setShowModal(false)}
                            >
                                <Modal.Header closeButton>
                                    <Modal.Title>Order Details</Modal.Title>
                                </Modal.Header>
                                <Modal.Body>
                                    <ul className="list-group list-group-flush">
                                        {items &&
                                            items.map((item) => (
                                                <li
                                                    key={item.id}
                                                    className="list-group-item py-3 ps-0 "
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
                                                                    {
                                                                        item
                                                                            .product
                                                                            .name
                                                                    }
                                                                </h6>
                                                            </a>

                                                            {/* <div className="mt-2 small lh-1">
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
                                                                        width={
                                                                            14
                                                                        }
                                                                        height={
                                                                            14
                                                                        }
                                                                        viewBox="0 0 24 24"
                                                                        fill="none"
                                                                        stroke="currentColor"
                                                                        strokeWidth={
                                                                            2
                                                                        }
                                                                        strokeLinecap="round"
                                                                        strokeLinejoin="round"
                                                                        className="feather feather-trash-2 text-success"
                                                                    >
                                                                        <polyline points="3 6 5 6 21 6" />
                                                                        <path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"></path>
                                                                        <line
                                                                            x1={
                                                                                10
                                                                            }
                                                                            y1={
                                                                                11
                                                                            }
                                                                            x2={
                                                                                10
                                                                            }
                                                                            y2={
                                                                                17
                                                                            }
                                                                        />
                                                                        <line
                                                                            x1={
                                                                                14
                                                                            }
                                                                            y1={
                                                                                11
                                                                            }
                                                                            x2={
                                                                                14
                                                                            }
                                                                            y2={
                                                                                17
                                                                            }
                                                                        />
                                                                    </svg>
                                                                </span>
                                                                <span className="text-muted">
                                                                    Remove
                                                                </span>
                                                            </a>
                                                        </div> */}
                                                        </div>

                                                        <div className="col-3 col-md-3 col-lg-3">
                                                            <div className="input-group input-spinner  ">
                                                                <input
                                                                    type="number"
                                                                    step={1}
                                                                    max={10}
                                                                    value={
                                                                        item.quantity
                                                                    }
                                                                    name="quantity"
                                                                    className="quantity-field form-control-sm form-input   "
                                                                    onChange={(
                                                                        e
                                                                    ) =>
                                                                        handleQuantityChange(
                                                                            e
                                                                                .target
                                                                                .value,
                                                                            item.id
                                                                        )
                                                                    }
                                                                    readOnly="true"
                                                                />
                                                            </div>
                                                        </div>

                                                        <div className="col-2 text-lg-end text-start text-md-end col-md-2">
                                                            <span className="fw-bold text-danger">
                                                                $
                                                                {
                                                                    item.price_per_unit
                                                                }
                                                            </span>
                                                            {/* <div className="text-decoration-line-through text-muted small">
                                                {item.oldPrice}
                                            </div> */}
                                                        </div>
                                                    </div>
                                                </li>
                                            ))}
                                    </ul>
                                </Modal.Body>
                                <Modal.Footer>
                                    <Button
                                        variant="secondary"
                                        onClick={() => setShowModal(false)}
                                    >
                                        Close
                                    </Button>
                                </Modal.Footer>
                            </Modal>
                        </div>
                    </div>
                </div>
            </>
            <MainFooter />
        </>
    );
}

export default Accounts;
