import MainFooter from "../components/layout/partials/mainFooter";
import React, { useEffect, useState } from "react";
import { Link, useNavigate } from "react-router-dom";
import axios from "axios";
import { toast } from "react-toastify";
import { Bars } from "react-loader-spinner";
function ForgetPassword() {
    const [email, setEmail] = useState("");
    const handleSubmit = (e) => {
        e.preventDefault();

        const { token, email } = useParams();

        axios
            .post(
                "/api/password/forgot",
                { email: email },
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
                    toast.success("Email Sent!");
                } else {
                    toast.error("Failed to sent Email!");
                }
                console.log(response.data); // handle the response data
            })
            .catch((error) => {
                console.log(error); // handle the error
            });
    };
    return (
        <>
            {/* navigation */}
            <div className="border-bottom shadow-sm">
                <nav className="navbar navbar-light py-2">
                    <div className="container justify-content-center justify-content-lg-between">
                        <Link to="/" className="navbar-brand d-none d-lg-block">
                            <img
                                src="/logo/logo-c.png"
                                alt="FenceLine Logo"
                                className="img-fluid "
                                style={{
                                    maxWidth: "14%",
                                    height: "auto",
                                }}
                            />
                        </Link>
                        <span className="navbar-text">
                            Already have an account?{" "}
                            <a href="../pages/signin.html">Sign in</a>
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
                                    src="../assets/images/svg-graphics/fp-g.svg"
                                    alt=""
                                    className="img-fluid"
                                />
                            </div>
                            <div className="col-12 col-md-6 offset-lg-1 col-lg-4 order-lg-2 order-1 d-flex align-items-center">
                                <div>
                                    <div className="mb-lg-9 mb-5">
                                        {/* heading */}
                                        <h1 className="mb-2 h2 fw-bold">
                                            Forgot your password?
                                        </h1>
                                        <p>
                                            Please enter the email address
                                            associated with your account and We
                                            will email you a link to reset your
                                            password.
                                        </p>
                                    </div>
                                    {/* form */}
                                    <form onSubmit={handleSubmit}>
                                        {/* row */}
                                        <div className="row g-3">
                                            {/* col */}
                                            <div className="col-12">
                                                {/* input */}
                                                <input
                                                    type="email"
                                                    className="form-control"
                                                    id="inputEmail4"
                                                    placeholder="Email"
                                                    required=""
                                                    value={email}
                                                    onChange={(e) =>
                                                        setEmail(e.target.value)
                                                    }
                                                />
                                            </div>
                                            {/* btn */}
                                            <div className="col-12 d-grid gap-2">
                                                <button
                                                    type="submit"
                                                    className="btn btn-primary"
                                                >
                                                    Send Mail
                                                </button>
                                                <Link
                                                    to="/"
                                                    className="btn btn-light"
                                                >
                                                    Back
                                                </Link>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </section>
            </main>
            {/* Footer */}
            {/* footer */}

            <MainFooter />
        </>
    );
}

export default ForgetPassword;
