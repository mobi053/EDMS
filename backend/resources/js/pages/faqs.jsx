import React from "react";
import NavbarSearch from "../components/layout/partials/navbarSearch";
import MainNavbar from "../components/layout/partials/mainNavbar";
import MainFooter from "../components/layout/partials/mainFooter";
import HomeSignup from "../components/layout/partials/homeSignup";
import HomeShopCart from "../components/layout/partials/homeShopCart";

function FAQs() {
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
            <div className="container mt-4">
                <h2>Frequently Asked Questions from the Fence Line</h2>
                <p>
                    Frequently Asked Questions about our fencing products and
                    company
                </p>

                <div className="accordion" id="faqAccordion">
                    <div className="card mb-3">
                        <div className="card-header" id="heading1">
                            <h5 className="mb-0">
                                Q. Do you sell directly to members of the
                                public?
                            </h5>
                        </div>

                        <div
                            id="collapse1"
                            className="collapse show"
                            aria-labelledby="heading1"
                            data-parent="#faqAccordion"
                        >
                            <div className="card-body">
                                A. We are trade suppliers, supplying many trade
                                outlets; some are multi branch organisations
                                others are local suppliers. We will be pleased
                                to put you in contact with a supplier that will
                                be able to meet your needs in your locality.
                            </div>
                        </div>
                    </div>

                    {/* Add more FAQ items following the same structure */}
                    {/* Remember to update the question (Q.) and answer (A.) content */}
                </div>
                <div className="card mb-3">
                    <div className="card-header" id="heading1">
                        <h5 className="mb-0">
                            Q. Where can I buy your products from that is near
                            to where I live?
                        </h5>
                    </div>

                    <div
                        id="collapse1"
                        className="collapse show"
                        aria-labelledby="heading1"
                        data-parent="#faqAccordion"
                    >
                        <div className="card-body">
                            A. Please send us your enquiry and we will let you
                            know where you can buy our products.
                        </div>
                    </div>
                </div>
                <div className="card mb-3">
                    <div className="card-header" id="heading1">
                        <h5 className="mb-0">
                            Q. Where is Red Brand wire manufactured?
                        </h5>
                    </div>

                    <div
                        id="collapse1"
                        className="collapse show"
                        aria-labelledby="heading1"
                        data-parent="#faqAccordion"
                    >
                        <div className="card-body">
                            A. Red Brand is manufactured in the USA at the
                            Keystone Steel & Wire factory in Peoria near
                            Chicago.
                        </div>
                    </div>
                </div>

                <div className="card mb-3">
                    <div className="card-header" id="heading1">
                        <h5 className="mb-0">
                            Q. Since Red Brand wire is imported from USA do I
                            have to order a full container load?
                        </h5>
                    </div>

                    <div
                        id="collapse1"
                        className="collapse show"
                        aria-labelledby="heading1"
                        data-parent="#faqAccordion"
                    >
                        <div className="card-body">
                            A. You can order any quantity you require. Full
                            containers will be dispatched directly to you from
                            the US whilst smaller quantities are available
                            through our distribution arrangement here in the UK.
                        </div>
                    </div>
                </div>

                <div className="card mb-3">
                    <div className="card-header" id="heading1">
                        <h5 className="mb-0">
                            Q. Is Red Brand product available in mainland
                            Europe?
                        </h5>
                    </div>

                    <div
                        id="collapse1"
                        className="collapse show"
                        aria-labelledby="heading1"
                        data-parent="#faqAccordion"
                    >
                        <div className="card-body">
                            A. Yes. A number of products particularly horse
                            fence have been used throughout Europe, please let
                            us know your requirements.
                        </div>
                    </div>
                </div>
                <div className="card mb-3">
                    <div className="card-header" id="heading1">
                        <h5 className="mb-0">
                            Q. Is Red Brand product available in mainland
                            Europe?
                        </h5>
                    </div>

                    <div
                        id="collapse1"
                        className="collapse show"
                        aria-labelledby="heading1"
                        data-parent="#faqAccordion"
                    >
                        <div className="card-body">
                            A. Yes. A number of products particularly horse
                            fence have been used throughout Europe, please let
                            us know your requirements.
                        </div>
                    </div>
                </div>
            </div>

            <MainFooter />
        </>
    );
}
export default FAQs;
