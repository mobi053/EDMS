import MainFooter from "../components/layout/partials/mainFooter";
import React, { useEffect, useState } from "react";
import { Link, useNavigate, useParams } from "react-router-dom";
import axios from "axios";
import { toast } from "react-toastify";
import { Bars } from "react-loader-spinner";

function ResetPassword() {
    const { token, email: myemail } = useParams();
    const [newPassword, setNewPassword] = useState("");
    const [confirmPassword, setConfirmPassword] = useState("");

    const handleSubmit = (e) => {
        e.preventDefault();
        if (newPassword !== confirmPassword) {
            alert("Passwords do not match");
            return;
        }

        const data = {
            email: myemail,
            password: newPassword,
            token: token,
        };

        axios
            .post("/api/password/reset", data)
            .then((response) => {
                if (response.status === 200) {
                    toast.success("Passowrd Reset Successfull!");
                } else {
                    toast.error("Failed to reset password!");
                }
                console.log(response.data);
                // handle successful response here
            })
            .catch((error) => {
                console.log(error);
                // handle error here
            });
    };
    return (
        <>
            {/* navigation */}
            <div className="border-bottom shadow-sm">
                <nav className="navbar navbar-light py-2">
                    <div className="container justify-content-center justify-content-lg-between">
                        <a className="navbar-brand" href="../index.html">
                            <img
                                src="/logo/logo-c.png"
                                alt=""
                                className="d-inline-block align-text-top"
                            />
                        </a>
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
                                    src="/front/dist/assets/images/svg-graphics/fp-g.svg"
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
                                        <p>Please reset your password.</p>
                                    </div>
                                    {/* form */}
                                    <form onSubmit={handleSubmit}>
                                        {/* row */}
                                        <div className="row g-3">
                                            {/* col */}
                                            <div className="col-12">
                                                {/* input */}
                                                <input
                                                    type="password"
                                                    className="form-control"
                                                    id="inputpassword1"
                                                    placeholder="New Password"
                                                    required=""
                                                    value={newPassword}
                                                    onChange={(e) =>
                                                        setNewPassword(
                                                            e.target.value
                                                        )
                                                    }
                                                />
                                                <input
                                                    type="password"
                                                    className="form-control"
                                                    id="inputpassword2"
                                                    placeholder="Confirm Password"
                                                    required=""
                                                    value={confirmPassword}
                                                    onChange={(e) =>
                                                        setConfirmPassword(
                                                            e.target.value
                                                        )
                                                    }
                                                />
                                            </div>
                                            {/* btn */}
                                            <div className="col-12 d-grid gap-2">
                                                <Link
                                                    to="/"
                                                    className="btn btn-primary"
                                                >
                                                    Reset Password
                                                </Link>
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

export default ResetPassword;
