import { useEffect, useState } from "react";
import React from "react";
import MainFooter from "../components/layout/partials/mainFooter";
import { Link } from "react-router-dom";
import axios from "axios";
import { useNavigate } from "react-router-dom";
import Loader from "react-loader-spinner";
import { toast } from "react-toastify";
import "react-toastify/dist/ReactToastify.css";

function Signinpage() {
    const [email, setEmail] = useState();
    const [password, setPassword] = useState();
    const [loading, setLoading] = useState(false);
    const navigate = useNavigate(); // import useNavigate hook
    const [showPassword, setShowPassword] = useState(false);

    const handleTogglePassword = () => {
        setShowPassword(!showPassword);
    };

    const handleSubmit = async (event) => {
        event.preventDefault();
        const email = event.target.email.value;
        const password = event.target.password.value;
        try {
            const response = await axios.post("/api/auth/login", {
                email,
                password,
            });
            if (response.status === 200) {
                const userData = response.data;
                localStorage.setItem("userToken", userData.result.access_token);
                localStorage.setItem("userEmail", userData.result.email);
                localStorage.setItem("userName", userData.result.name);
                toast.success("Login successful!");

                navigate("/");
            } else {
                toast.error("Failed to login!");
            }
        } catch (error) {
            toast.error(error.response.data.message);
        }
    };

    return (
        <>
            <div className="border-bottom shadow-sm">
                <nav className="navbar navbar-light py-2">
                    <div className="container justify-content-center justify-content-lg-between">
                        <img
                            src="/logo/psca-logo.png"
                            alt=""
                            className="d-inline-block align-text-top"
                            style={{ maxWidth: "15%", height: "auto" }}
                        />
                        <span className="">
                            Don’t have an account?{" "}
                            <Link to="/signup">Sign Up</Link>
                        </span>
                    </div>
                </nav>
            </div>

            <main>
                {/* section */}
                <section className="my-lg-14 my-8">
                    <div className="container">
                        {/* row */}
                        <div className="row justify-content-center align-items-center">
                            <div className="col-12 col-md-6 col-lg-4 order-lg-1 order-2">
                                {/* img */}
                                <img
                                    src="/front/dist/assets/images/svg-graphics/signin-g.svg"
                                    alt=""
                                    className="img-fluid"
                                />
                            </div>
                            {/* col */}
                            <div className="col-12 col-md-6 offset-lg-1 col-lg-4 order-lg-2 order-1">
                                <div className="mb-lg-9 mb-5">
                                    <h1 className="mb-1 h2 fw-bold">
                                        Sign in to The Fence Line
                                    </h1>
                                    <p>
                                        Welcome back to The Fence Line! Enter
                                        your email to get started.
                                    </p>
                                </div>

                                <form onSubmit={handleSubmit}>
                                    <div className="row g-3">
                                        {/* row */}
                                        <div className="col-12">
                                            {/* input */}
                                            <input
                                                type="email"
                                                className="form-control"
                                                name="email"
                                                id="inputEmail4"
                                                placeholder="Email"
                                                required=""
                                            />
                                        </div>
                                        <div className="col-12">
                                            {/* input */}
                                            <div className="password-field position-relative">
                                                <input
                                                    type={
                                                        showPassword
                                                            ? "text"
                                                            : "password"
                                                    }
                                                    name="password"
                                                    id="fakePassword"
                                                    placeholder="Enter Password"
                                                    className="form-control"
                                                    required=""
                                                />
                                                <span>
                                                    <i
                                                        id="passwordToggler"
                                                        className={
                                                            showPassword
                                                                ? "bi bi-eye"
                                                                : "bi bi-eye-slash"
                                                        }
                                                        onClick={
                                                            handleTogglePassword
                                                        }
                                                    />
                                                </span>
                                            </div>
                                        </div>
                                        <div className="d-flex justify-content-between">
                                            {/* form check */}
                                            <div className="form-check">
                                                <input
                                                    className="form-check-input"
                                                    type="checkbox"
                                                    defaultValue=""
                                                    id="flexCheckDefault"
                                                />

                                                <label
                                                    className="form-check-label"
                                                    htmlFor="flexCheckDefault"
                                                >
                                                    Remember me
                                                </label>
                                            </div>
                                            <div>
                                                Forgot password?{" "}
                                                <Link to="/forget-password">
                                                    Reset it
                                                </Link>
                                            </div>
                                        </div>
                                        {/* btn */}
                                        <div className="col-12 d-grid">
                                            <button
                                                type="submit"
                                                className="btn btn-primary"
                                            >
                                                Sign In
                                            </button>
                                        </div>
                                        {/* link */}
                                        <div>
                                            Don’t have an account?{" "}
                                            <Link to="/signup">Sign Up</Link>
                                            {/* <a href="../pages/signup.html">
                                                {" "}
                                                Sign Up
                                            </a> */}
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </section>
            </main>

            <MainFooter />
        </>
    );
}

export default Signinpage;
