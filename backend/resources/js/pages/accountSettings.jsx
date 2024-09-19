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
import Swal from "sweetalert2";

import "react-toastify/dist/ReactToastify.css";

function AccountSettings() {
    const { token, email: myemail } = useParams();
    const navigate = useNavigate(); // import useNavigate hook
    const [loading, setLoading] = useState(false);
    const [passwords, setPasswords] = useState({
        old_password: "",
        new_password: "",
        confirm_password: "",
    });
    const [name, setName] = useState("");
    const [email, setEmail] = useState("");
    const [phone, setPhone] = useState("");
    const [message, setMessage] = useState("");
    let userInfo;

    useEffect(() => {
        axios
            .get("/api/auth/user", {
                headers: {
                    Authorization: `Bearer ${localStorage.getItem(
                        "userToken"
                    )}`,
                },
            })
            .then((response) => {
                userInfo = response.data.result.info;
                setName(userInfo.name);
                setEmail(userInfo.email);
                setPhone(userInfo.phone);
                console.log(userInfo);
            })
            .catch((error) => {
                console.log(error);
            });
    }, []);

    function handleDelete() {
        Swal.fire({
            title: "Are you sure?",
            text: "This action is irreversible",
            icon: "warning",
            showCancelButton: true,
            confirmButtonText: "Yes, delete it!",
            cancelButtonText: "No, keep it",
        }).then((result) => {
            if (result.isConfirmed) {
                axios
                    .delete("/api/auth/delete", {
                        headers: {
                            Authorization: `Bearer ${localStorage.getItem(
                                "userToken"
                            )}`,
                        },
                    })
                    .then((response) => {
                        if (response.status === 200) {
                            localStorage.removeItem("userToken");
                            localStorage.removeItem("userName");
                            localStorage.removeItem("userEmail");
                            toast.success("Account deleted Successfully!");

                            navigate("/");
                        } else {
                            toast.error("Failed to delete Account!");
                        }
                    })
                    .catch((error) => {
                        // handle error response
                    });
                console.log("Deleting...");
            }
        });
    }

    const handleSubmitProfile = (e) => {
        e.preventDefault();

        const data = {
            name: name,
            email: email,
            phone: phone,
        };

        axios
            .post("/api/auth/profile-update", data, {
                headers: {
                    Authorization: `Bearer ${localStorage.getItem(
                        "userToken"
                    )}`,
                },
            })
            .then((response) => {
                if (response.data.code === "SUCCESS") {
                    setMessage("Profile updated successfully.");
                } else {
                    setMessage("Failed to update profile.");
                }
            })
            .catch((error) => {
                console.log(error);
                setMessage("Failed to update profile.");
            });
    };
    const handleChange = (e) => {
        setPasswords({
            ...passwords,
            [e.target.name]: e.target.value,
        });
    };

    const handleSubmit = (e) => {
        e.preventDefault();

        const data = {
            old_password: passwords.old_password,
            new_password: passwords.new_password,
        };

        axios
            .post("/api/password/change", data, {
                headers: {
                    Authorization: `Bearer ${localStorage.getItem(
                        "userToken"
                    )}`,
                },
            })
            .then((response) => {
                if (response.status === 200) {
                    alert("Password changed successfully");
                } else {
                    alert("Failed to change password");
                }
            })
            .catch((error) => {
                console.log(error);
                alert("Failed to change password");
            });
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
                                            Account Setting
                                        </h2>
                                    </div>
                                    <div>
                                        {/* heading */}
                                        <h5 className="mb-4">
                                            Account details
                                        </h5>
                                        <div className="row">
                                            <div className="col-lg-5">
                                                {/* form */}
                                                <form
                                                    onSubmit={
                                                        handleSubmitProfile
                                                    }
                                                >
                                                    <div className="mb-3">
                                                        <label className="form-label">
                                                            Name
                                                        </label>
                                                        <input
                                                            type="text"
                                                            className="form-control"
                                                            placeholder={name}
                                                            name="name"
                                                            value={name}
                                                            onChange={(e) =>
                                                                setName(
                                                                    e.target
                                                                        .value
                                                                )
                                                            }
                                                        />
                                                    </div>
                                                    <div className="mb-3">
                                                        <label className="form-label">
                                                            Email
                                                        </label>
                                                        <input
                                                            type="email"
                                                            className="form-control"
                                                            placeholder={email}
                                                            name="email"
                                                            value={email}
                                                            readOnly
                                                        />
                                                    </div>
                                                    <div className="mb-5">
                                                        <label className="form-label">
                                                            Phone
                                                        </label>
                                                        <input
                                                            type="text"
                                                            className="form-control"
                                                            placeholder={phone}
                                                            name="phone"
                                                            value={phone}
                                                            onChange={(e) =>
                                                                setPhone(
                                                                    e.target
                                                                        .value
                                                                )
                                                            }
                                                        />
                                                    </div>
                                                    {/* button */}
                                                    <div className="mb-3">
                                                        <button className="btn btn-primary">
                                                            Save Details
                                                        </button>
                                                    </div>
                                                    {/* message */}
                                                    {message && (
                                                        <p>{message}</p>
                                                    )}
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                    <hr className="my-10" />
                                    <div className="pe-lg-14">
                                        {/* heading */}
                                        <h5 className="mb-4">Password</h5>
                                        <form
                                            className=" row row-cols-1 row-cols-lg-2"
                                            onSubmit={handleSubmit}
                                        >
                                            {/* input */}
                                            <div className="mb-3 col">
                                                <label className="form-label">
                                                    New Password
                                                </label>
                                                <input
                                                    type="password"
                                                    className="form-control"
                                                    name="new_password"
                                                    value={
                                                        passwords.new_password
                                                    }
                                                    onChange={handleChange}
                                                    placeholder="New Password"
                                                />
                                            </div>
                                            {/* input */}
                                            <div className="mb-3 col">
                                                <label className="form-label">
                                                    Current Password
                                                </label>
                                                <input
                                                    type="password"
                                                    className="form-control"
                                                    name="old_password"
                                                    value={
                                                        passwords.old_password
                                                    }
                                                    onChange={handleChange}
                                                    placeholder="Old Password"
                                                />
                                            </div>
                                            {/* input */}
                                            <div className="col-12">
                                                <p className="mb-4">
                                                    Can’t remember your current
                                                    password?{" "}
                                                    <Link
                                                        to={`/forget-password/:${token}/:${myemail}`}
                                                    >
                                                        Reset your password
                                                    </Link>
                                                </p>
                                                <button
                                                    type="submit"
                                                    className="btn btn-primary"
                                                >
                                                    Save Password
                                                </button>
                                            </div>
                                        </form>
                                    </div>
                                    <hr className="my-10" />
                                    <div>
                                        {/* heading */}
                                        <h5 className="mb-4">Delete Account</h5>
                                        <p className="mb-2">
                                            Would you like to delete your
                                            account?
                                        </p>
                                        <p className="mb-5">
                                            This is will permanently delete your
                                            Account.
                                        </p>
                                        {/* btn */}
                                        <button
                                            className="btn btn-outline-danger"
                                            onClick={handleDelete}
                                        >
                                            I want to delete my account
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </section>
            </main>
            {/* modal */}
            <div
                className="offcanvas offcanvas-start"
                tabIndex={-1}
                id="offcanvasAccount"
                aria-labelledby="offcanvasAccountLabel"
            >
                {/* offcanvas header */}
                <div className="offcanvas-header">
                    <h5 className="offcanvas-title" id="offcanvasAccountLabel">
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
                            <Link to="/account-orders" className="nav-link">
                                <i className="feather-icon icon-settings me-2" />
                                Your Orders
                            </Link>
                        </li>
                        {/* nav item */}
                        <li className="nav-item">
                            <Link to="/account-settings" className="nav-link">
                                <i className="feather-icon icon-settings me-2" />
                                Settings
                            </Link>
                        </li>
                        {/* nav item */}
                        <li className="nav-item">
                            <Link to="/account-address" className="nav-link">
                                <i className="feather-icon icon-settings me-2" />
                                Address
                            </Link>
                        </li>
                        {/* nav item */}
                        <li className="nav-item">
                            <Link to="/account-payment" className="nav-link">
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
                        {/* navs */}
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

            <MainFooter />
        </>
    );
}

export default AccountSettings;
