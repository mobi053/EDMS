import React from "react";
import NavbarSearch from "../components/layout/partials/navbarSearch";
import MainNavbar from "../components/layout/partials/mainNavbar";
import MainFooter from "../components/layout/partials/mainFooter";
import HomeSignup from "../components/layout/partials/homeSignup";
import HomeShopCart from "../components/layout/partials/homeShopCart";
import { toast } from "react-toastify";
import "react-toastify/dist/ReactToastify.css";
import axios from "axios";
import { useState, useEffect } from "react";
import { Bars } from "react-loader-spinner";
function Contact() {
    const [loading, setLoading] = useState(false);

    const [formData, setFormData] = useState({
        name: "",
        email: "",
        subject: "",
        message: "",
    });

    const handleChange = (e) => {
        setFormData({
            ...formData,
            [e.target.name]: e.target.value,
        });
    };

    const handleSubmit = (e) => {
        setLoading(true);
        e.preventDefault();

        axios
            .post("/api/contact/store", formData, {
                headers: {
                    Authorization: `Bearer ${localStorage.getItem(
                        "userToken"
                    )}`,
                },
            })
            .then((response) => {
                if (response.status === 200) {
                    toast.success("Message Submitted");
                } else {
                    toast.error("Failed to submit Message");
                }
                console.log(response.data);
            })
            .catch((error) => {
                // Handle error response
                console.error(error);
            })
            .finally(() => {
                setLoading(false);
            });
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

            <section className="my-lg-14 my-8">
                {/* container */}
                <div className="container">
                    <div className="row">
                        {/* col */}
                        <div className="offset-lg-2 col-lg-8 col-12">
                            <div className="mb-8">
                                {/* heading */}
                                <h1 className="h3">Contact Us</h1>
                                <p className="lead mb-0">
                                    Have a question? Want to leave feedback or
                                    just say hi? Please don't hesitate to
                                    complete the form below and we will get back
                                    in touch.
                                </p>
                            </div>
                            {/* form */}
                            <form className="row" onSubmit={handleSubmit}>
                                {/* input */}
                                <div className="col-md-12 mb-3">
                                    <label
                                        className="form-label"
                                        htmlFor="yname"
                                    >
                                        Your Name
                                        <span className="text-danger">*</span>
                                    </label>
                                    <input
                                        type="name"
                                        id="name"
                                        name="name"
                                        className="form-control"
                                        placeholder="Enter Your Name"
                                        onChange={handleChange}
                                        required
                                    />
                                </div>

                                <div className="col-md-12 mb-3">
                                    {/* input */}
                                    <label
                                        className="form-label"
                                        htmlFor="title"
                                    >
                                        {" "}
                                        Subject
                                    </label>
                                    <input
                                        type="text"
                                        id="subject"
                                        name="subject"
                                        className="form-control"
                                        placeholder="Your Title"
                                        onChange={handleChange}
                                        required
                                    />
                                </div>
                                <div className="col-md-12 mb-3">
                                    <label
                                        className="form-label"
                                        htmlFor="emailContact"
                                    >
                                        Email
                                        <span className="text-danger">*</span>
                                    </label>
                                    <input
                                        type="email"
                                        id="emailContact"
                                        name="email"
                                        className="form-control"
                                        placeholder="Enter Your First Name"
                                        onChange={handleChange}
                                        required
                                    />
                                </div>

                                <div className="col-md-12 mb-3">
                                    {/* input */}
                                    <label
                                        className="form-label"
                                        htmlFor="comments"
                                    >
                                        {" "}
                                        Your Message
                                    </label>
                                    <textarea
                                        rows={3}
                                        id="message"
                                        name="message"
                                        className="form-control"
                                        placeholder="Additional Comments"
                                        onChange={handleChange}
                                        defaultValue={""}
                                        required
                                    />
                                </div>
                                <div className="col-md-12">
                                    {/* btn */}
                                    <button
                                        type="submit"
                                        className="btn btn-primary"
                                    >
                                        Submit
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </section>

            <MainFooter />
        </>
    );
}

export default Contact;
