import React, { useEffect, useState } from "react";
import NavbarSearch from "../components/layout/partials/navbarSearch";
import MainNavbar from "../components/layout/partials/mainNavbar";
import MainFooter from "../components/layout/partials/mainFooter";
import HomeSignup from "../components/layout/partials/homeSignup";
import HomeShopCart from "../components/layout/partials/homeShopCart";
import { Link, useNavigate, useParams } from "react-router-dom";
import axios from "axios";
import { toast } from "react-toastify";
import { Bars } from "react-loader-spinner";

import "react-toastify/dist/ReactToastify.css";
import { Button, Modal } from "react-bootstrap";
function AccountAddress() {
    const [loading, setLoading] = useState(false);
    const [showModal, setShowModal] = useState(false);

    const [address, setAddress] = useState("");
    const [name, setName] = useState("");

    const [city, setCity] = useState("");
    const [phone, setPhone] = useState("");

    const handleEditAddress = () => {
        axios
            .get("/api/address/show", {
                headers: {
                    Authorization: `Bearer ${localStorage.getItem(
                        "userToken"
                    )}`,
                },
            })
            .then((response) => {
                console.log("Show Api:", response.data);
                setName(response.data.result[0].name);
                setAddress(response.data.result[0].address);
                setCity(response.data.result[0].city);
                setPhone(response.data.result[0].phone);
                setShowModal(true);
            })
            .catch((error) => {
                console.error("Error fetching address:", error);
            });
    };

    const handleCloseModal = () => {
        setShowModal(false);
    };

    const handleSaveAddress = (event) => {
        event.preventDefault(); // Prevents the default form submission

        const formData = new FormData(); // Create a new instance of FormData

        // Append form fields and their values manually
        formData.append("name", name);
        formData.append("address", address);
        formData.append("city", city);
        formData.append("phone", phone);
        axios
            .post("/api/address/update", formData, {
                headers: {
                    Authorization: `Bearer ${localStorage.getItem(
                        "userToken"
                    )}`,
                },
            })
            .then((response) => {
                setName(response.data.result.name);
                setAddress(response.data.result.address);
                setCity(response.data.result.city);
                setPhone(response.data.result.phone);

                localStorage.setItem("address", response.data.result.address);

                toast.success("Address Added successfully!");
                console.log(response.data.result);
                setShowModal(false);
            })
            .catch((error) => {
                console.error("Error updating address:", error);
            });
    };

    const handleUpdateAddress = (event) => {
        event.preventDefault();
        // Code for updating the address
        setShowModal(false);
    };

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
                    <section>
                        <div className="container">
                            <div className="row">
                                <div className="col-12">
                                    <div className="d-flex justify-content-between align-items-center d-md-none py-4">
                                        <h3 className="fs-5 mb-0">
                                            Account Setting
                                        </h3>
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
                                <div className="col-lg-3 col-md-4 col-12 border-end  d-none d-md-block">
                                    <div className="pt-10 pe-lg-10">
                                        <ul className="nav flex-column nav-pills nav-pills-dark">
                                            {/* nav item */}
                                            <li className="nav-item">
                                                <Link
                                                    to="/account-orders"
                                                    className="nav-link"
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
                                            <li
                                                className="nav-item"
                                                onClick={handleLogout}
                                            >
                                                <a
                                                    className="nav-link "
                                                    href="../index.html"
                                                >
                                                    <i className="feather-icon icon-log-out me-2" />
                                                    Log out
                                                </a>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                                <div className="col-lg-9 col-md-8 col-12">
                                    <div className="py-6 p-md-6 p-lg-10">
                                        <div className="mb-6">
                                            {/* heading */}
                                            <h2 className="mb-0">
                                                Account Address
                                            </h2>
                                        </div>
                                        <div>
                                            <div className="row">
                                                <div className="col-lg-5">
                                                    {/* form */}
                                                    <form
                                                        onSubmit={
                                                            handleSaveAddress
                                                        }
                                                    >
                                                        <div className="mb-3">
                                                            <label className="form-label">
                                                                Name
                                                            </label>
                                                            <input
                                                                type="text"
                                                                className="form-control"
                                                                // placeholder={
                                                                //     name
                                                                // }
                                                                name="name"
                                                                // value={name}
                                                                // onChange={(e) =>
                                                                //     setName(
                                                                //         e.target
                                                                //             .value
                                                                //     )
                                                                // }
                                                            />
                                                        </div>
                                                        <div className="mb-3">
                                                            <label className="form-label">
                                                                Address
                                                            </label>
                                                            <input
                                                                type="text"
                                                                className="form-control"
                                                                // placeholder={
                                                                //     email
                                                                // }
                                                                name="address"
                                                                // value={email}
                                                            />
                                                        </div>
                                                        <div className="mb-5">
                                                            <label className="form-label">
                                                                City
                                                            </label>
                                                            <input
                                                                type="text"
                                                                className="form-control"
                                                                // placeholder={
                                                                //     phone
                                                                // }
                                                                name="city"
                                                                // value={phone}
                                                                // onChange={(e) =>
                                                                //     setPhone(
                                                                //         e.target
                                                                //             .value
                                                                //     )
                                                                // }
                                                            />
                                                        </div>
                                                        <div className="mb-5">
                                                            <label className="form-label">
                                                                Phone
                                                            </label>
                                                            <input
                                                                type="text"
                                                                className="form-control"
                                                                // placeholder={
                                                                //     phone
                                                                // }
                                                                name="phone"
                                                                // value={phone}
                                                                // onChange={(e) =>
                                                                //     setPhone(
                                                                //         e.target
                                                                //             .value
                                                                //     )
                                                                // }
                                                            />
                                                        </div>
                                                        {/* button */}
                                                        <div className="mb-3">
                                                            <button className="btn btn-primary">
                                                                Save Details
                                                            </button>
                                                        </div>
                                                    </form>
                                                    <div className="mb-3">
                                                        <button
                                                            className="btn btn-primary"
                                                            onClick={
                                                                handleEditAddress
                                                            }
                                                            style={{
                                                                display:
                                                                    "inline-block",
                                                            }}
                                                        >
                                                            Edit
                                                        </button>
                                                    </div>
                                                    {/* Modal */}
                                                    <Modal
                                                        show={showModal}
                                                        onHide={
                                                            handleCloseModal
                                                        }
                                                    >
                                                        <Modal.Header
                                                            closeButton
                                                        >
                                                            <Modal.Title>
                                                                Edit Address
                                                            </Modal.Title>
                                                        </Modal.Header>
                                                        <Modal.Body>
                                                            <form>
                                                                {/* Modal form fields */}
                                                                <div className="mb-3">
                                                                    <label className="form-label">
                                                                        Name
                                                                    </label>
                                                                    <input
                                                                        type="text"
                                                                        className="form-control"
                                                                        name="name"
                                                                        value={
                                                                            name
                                                                        }
                                                                        onChange={(
                                                                            event
                                                                        ) =>
                                                                            setName(
                                                                                event
                                                                                    .target
                                                                                    .value
                                                                            )
                                                                        }
                                                                    />
                                                                </div>
                                                                <div className="mb-3">
                                                                    <label className="form-label">
                                                                        Address
                                                                    </label>
                                                                    <input
                                                                        type="Address"
                                                                        className="form-control"
                                                                        name="address"
                                                                        value={
                                                                            address
                                                                        }
                                                                        onChange={(
                                                                            event
                                                                        ) =>
                                                                            setAddress(
                                                                                event
                                                                                    .target
                                                                                    .value
                                                                            )
                                                                        }
                                                                    />
                                                                </div>
                                                                <div className="mb-3">
                                                                    <label className="form-label">
                                                                        City
                                                                    </label>
                                                                    <input
                                                                        type="text"
                                                                        className="form-control"
                                                                        name="city"
                                                                        value={
                                                                            city
                                                                        }
                                                                        onChange={(
                                                                            event
                                                                        ) =>
                                                                            setCity(
                                                                                event
                                                                                    .target
                                                                                    .value
                                                                            )
                                                                        }
                                                                    />
                                                                </div>
                                                                <div className="mb-3">
                                                                    <label className="form-label">
                                                                        Phone
                                                                    </label>
                                                                    <input
                                                                        type="text"
                                                                        className="form-control"
                                                                        name="phone"
                                                                        value={
                                                                            phone
                                                                        }
                                                                        onChange={(
                                                                            e
                                                                        ) =>
                                                                            setPhone(
                                                                                e
                                                                                    .target
                                                                                    .value
                                                                            )
                                                                        }
                                                                    />
                                                                </div>
                                                            </form>
                                                        </Modal.Body>
                                                        <Modal.Footer>
                                                            {/* Update Address button */}
                                                            <Button
                                                                variant="primary"
                                                                onClick={
                                                                    handleSaveAddress
                                                                }
                                                            >
                                                                Update Address
                                                            </Button>
                                                            <Button
                                                                variant="secondary"
                                                                onClick={
                                                                    handleCloseModal
                                                                }
                                                            >
                                                                Close
                                                            </Button>
                                                        </Modal.Footer>
                                                    </Modal>
                                                </div>
                                            </div>
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
                    {/* offcanvac header */}
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
                    {/* offcanvac body */}
                    <div className="offcanvas-body">
                        {/* nav */}
                        <ul className="nav flex-column nav-pills nav-pills-dark">
                            {/* nav item */}
                            <li className="nav-item">
                                <Link to="/account-orders" className="nav-link">
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
                            {/* nav */}
                            <ul className="nav flex-column nav-pills nav-pills-dark">
                                {/* nav item */}
                                <li className="nav-item" onClick={handleLogout}>
                                    <span className="nav-link">
                                        <i className="feather-icon icon-log-out me-2" />
                                        Log out
                                    </span>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </>

            <MainFooter />
        </>
    );
}

export default AccountAddress;
