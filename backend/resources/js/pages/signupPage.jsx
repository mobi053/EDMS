import React, { useState } from "react";
import MainFooter from "../components/layout/partials/mainFooter";
import { Link, useNavigate } from "react-router-dom";
import axios from "axios";
import { toast } from "react-toastify";
import "react-toastify/dist/ReactToastify.css";

function SignUpPage() {
    const navigate = useNavigate();
    const [showPassword, setShowPassword] = useState(false);

    const handleTogglePassword = () => {
        setShowPassword(!showPassword);
    };

    const handleSubmit = async (event) => {
        event.preventDefault();
        const name = event.target.name.value;
        const email = event.target.email.value;
        const password = event.target.password.value;
        const phone = event.target.phoneNumber.value;
        try {
            const response = await axios.post("/api/auth/signup", {
                name,
                email,
                phone,
                password,
            });
            if (response.status === 200) {
                toast.success("SignUp successful!");

                navigate("/signin");
            } else {
                toast.error("Failed to SignUp!");
            }
        } catch (error) {
            toast.error(error.response.data.message);
        }
    };
    return (
        <>
            {/* navigation */}
            <div className="border-bottom shadow-sm">
                <nav className="navbar navbar-light py-2">
                    <div className="container justify-content-center justify-content-lg-between">
                        <img
                            src="/logo/logo-c.png"
                            alt=""
                            className="d-inline-block align-text-top"
                            style={{ maxWidth: "10%", height: "auto" }}
                        />
                        <span className="">
                            Already have an account?{" "}
                            <Link to="/signin">Sign In</Link>
                        </span>
                    </div>
                </nav>
            </div>
            <main>
                {/* section */}
                <section className="my-lg-14 my-8">
                    {/* container */}
                    <div className="container">
                        {/* row */}
                        <div className="row justify-content-center align-items-center">
                            <div className="col-12 col-md-6 col-lg-4 order-lg-1 order-2">
                                {/* img */}
                                <img
                                    src="/front/dist/assets/images/svg-graphics/signup-g.svg"
                                    alt=""
                                    className="img-fluid"
                                />
                            </div>
                            {/* col */}
                            <div className="col-12 col-md-6 offset-lg-1 col-lg-4 order-lg-2 order-1">
                                <div className="mb-lg-9 mb-5">
                                    <h1 className="mb-1 h2 fw-bold">
                                        Get Start Shopping
                                    </h1>
                                    <p>
                                        Welcome to Fence Line! Enter your email
                                        to get started.
                                    </p>
                                </div>
                                {/* form */}
                                <form onSubmit={handleSubmit}>
                                    <div className="row g-3">
                                        {/* col */}
                                        <div className="col">
                                            {/* input */}
                                            <input
                                                type="text"
                                                className="form-control"
                                                name="name"
                                                placeholder="Name"
                                                aria-label="Name"
                                                required=""
                                            />
                                        </div>

                                        <div className="col-12">
                                            {/* input */}
                                            <input
                                                type="email"
                                                name="email"
                                                className="form-control"
                                                id="inputEmail4"
                                                placeholder="Email"
                                                required=""
                                            />
                                        </div>
                                        <div className="col-12">
                                            {/* input */}

                                            <input
                                                type="tel"
                                                name="phoneNumber"
                                                placeholder="Enter your phone number"
                                                className="form-control"
                                                id="inputEmail4"
                                                required=""
                                            />
                                        </div>
                                        <div className="col-12">
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
                                        {/* btn */}
                                        <div className="col-12 d-grid">
                                            {" "}
                                            <button
                                                type="submit"
                                                className="btn btn-primary"
                                            >
                                                Register
                                            </button>
                                        </div>
                                        {/* text */}
                                        <p>
                                            <small>
                                                By continuing, you agree to our{" "}
                                                <a href="#!">
                                                    {" "}
                                                    Terms of Service
                                                </a>{" "}
                                                &amp;{" "}
                                                <a href="#!">Privacy Policy</a>
                                            </small>
                                        </p>
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
export default SignUpPage;
