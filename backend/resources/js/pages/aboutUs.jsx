import React from "react";
import NavbarSearch from "../components/layout/partials/navbarSearch";
import MainNavbar from "../components/layout/partials/mainNavbar";
import MainFooter from "../components/layout/partials/mainFooter";
import HomeSignup from "../components/layout/partials/homeSignup";
import HomeShopCart from "../components/layout/partials/homeShopCart";
import { useState, useEffect } from "react";
import axios from "axios";
import { Bars } from "react-loader-spinner";
import { Link } from "react-router-dom";

function AboutUs() {
    return (
        <>
            <div className="border-bottom ">
                <NavbarSearch />
                <MainNavbar />
            </div>
            {/* Modal */}
            <HomeSignup />
            {/* Shop Cart */}
            <HomeShopCart />

            <>
                <section className="mt-lg-14 mt-8">
                    {/* container */}
                    <div className="container">
                        {/* row */}
                        <div className="row">
                            {/* col */}
                            <div className="offset-lg-1 col-lg-10 col-12">
                                <div className="row align-items-center mb-14">
                                    <div className="col-md-6">
                                        {/* text */}
                                        <div className="ms-xxl-14 me-xxl-15 mb-8 mb-md-0 text-center text-md-start">
                                            <h1 className="mb-6">
                                                The Fence Line:
                                            </h1>
                                            <p className="mb-0 lead">
                                                We are long established
                                                distributors of the Redbrand
                                                range of wire fencing products
                                                and hold stocks of the Keystone
                                                RedBrand range.
                                            </p>
                                        </div>
                                    </div>
                                    {/* col */}
                                    <div className="col-md-6">
                                        <div className=" me-6">
                                            {/* img */}
                                            <img
                                                src={`http://127.0.0.1:8000/images/slide_img1.jpg`}
                                                alt=""
                                                className="img-fluid rounded"
                                            />
                                        </div>
                                    </div>
                                </div>
                                {/* row */}
                                <div className="row mb-12">
                                    <div className="col-12">
                                        <div className="mb-8">
                                            {/* heading */}
                                            <h2>Ready to get started?</h2>
                                        </div>
                                    </div>
                                    <div className="col-md-4">
                                        {/* card */}
                                        <div className="card bg-light mb-6 border-0">
                                            {/* card body */}
                                            <div className="card-body p-8">
                                                <div className="mb-4">
                                                    {/* img */}
                                                    <img
                                                        src={`http://127.0.0.1:8000/images/care.jpg`}
                                                        alt=""
                                                        className="img-fluid rounded"
                                                    />
                                                </div>
                                                <h4>
                                                    Going 'the extra mile' for
                                                    customers
                                                </h4>
                                                <p>
                                                    providing outstanding
                                                    customer service remains
                                                    central to The Fence Line
                                                    philosophy .{" "}
                                                </p>
                                            </div>
                                        </div>
                                    </div>
                                    <div className="col-md-4">
                                        {/* card */}
                                        <div className="card bg-light mb-6 border-0">
                                            {/* card body */}
                                            <div className="card-body p-8">
                                                <div className="mb-4">
                                                    {/* img */}
                                                    <img
                                                        src={`http://127.0.0.1:8000/images/trust.jpg`}
                                                        alt=""
                                                        className="img-fluid rounded"
                                                    />
                                                </div>
                                                <h4>
                                                    Trusted relationships with
                                                    many suppliers
                                                </h4>
                                                <p>
                                                    Established links with
                                                    hundreds of trade customers,
                                                    encompassing fencing
                                                    companies, agricultural
                                                    merchants and retail
                                                    outlets, right across the UK
                                                    and Europe who return again
                                                    and again.{" "}
                                                </p>
                                            </div>
                                        </div>
                                    </div>
                                    <div className="col-md-4">
                                        {/* card */}
                                        <div className="card bg-light mb-6 border-0">
                                            {/* card body */}
                                            <div className="card-body p-8">
                                                <div className="mb-4">
                                                    {/* img */}
                                                    <img
                                                        src={`http://127.0.0.1:8000/images/trade.jpg`}
                                                        alt=""
                                                        className="img-fluid rounded"
                                                    />
                                                </div>
                                                <h4>
                                                    A long history in fencing
                                                    and agriculture
                                                </h4>
                                                <p>
                                                    We are the European import
                                                    agent and authorised dealer
                                                    for the world leading,
                                                    USA-based Red Brand wire
                                                    fencing range.
                                                </p>
                                                {/* btn */}
                                            </div>
                                        </div>
                                    </div>
                                    <div className="col">
                                        {/* text */}
                                        <p>
                                            For using The Fence Line products,
                                            please
                                            <Link to="/contact"> Contact </Link>
                                            us.
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </section>
                {/* section */}
                <section className="bg-success py-14">
                    <div className="container">
                        <div className="row">
                            {/* col */}
                            <div className="offset-lg-1 col-lg-10">
                                <div className="row">
                                    {/* col */}
                                    <div className="col-xl-12 col-md-12">
                                        <div className="text-white me-8 mb-12">
                                            {/* text */}
                                            <h1 className="text-white mb-4 ">
                                                We are always looking to
                                                innovate
                                            </h1>
                                            <p>
                                                The Fence Line has also
                                                introduced proven innovations to
                                                the UK market with new additions
                                                such as Vicebite fencing stay
                                                brackets, manufactured in
                                                Australia.
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </section>
                {/* section */}
            </>

            <MainFooter />
        </>
    );
}

export default AboutUs;
