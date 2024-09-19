import React from "react";
import NavbarSearch from "../components/layout/partials/navbarSearch";
import MainNavbar from "../components/layout/partials/mainNavbar";
import MainFooter from "../components/layout/partials/mainFooter";
import HomeSignup from "../components/layout/partials/homeSignup";
import HomeShopCart from "../components/layout/partials/homeShopCart";

function Redbrand() {
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
            <div className="container mt-4" style={{backgroundColor: "lightgray",
                                                borderRadius: "5px",
                                                paddingTop: "5px",
                                                paddingBottom: "2px"}}>
                <h2>About Red Brand in the UK</h2>
                <p>Including a brief history of Keystone Steel and Wire.</p>
            </div>
            <div className="container mt-4">



                <h3>A brief history of Keystone Steel and Wire</h3>
                <p>
                    Keystone Steel & Wire Company, founded in 1889, represents
                    more than 110 years of American-made steel and wire
                    products. The company's name was derived from the
                    keystone-shaped mesh of the first fence manufactured near
                    Dillon, Illinois. Since the early 1900's, Red Brand® has
                    been a household name on American farms. The red-colored
                    wire, a familiar trademark, got its start from an early
                    marketing genius who decided to dip the top of Keystone
                    fence rolls into red paint. The Red Brand logo has come to
                    stand for the most complete line of high-quality wire,
                    fence, and nails that are produced in the United States.
                    This reputation has led Red Brand to be recognized in the
                    USA as "The most respected name in farm fence".
                </p>
                <p>
                    Today, Keystone is the market leader for farm fencing in the
                    US. The Company has the capacity to smelt up to one million
                    tonnes of steel per annum through its own in-house electric
                    arc furnace. Steel billets are cast and then hot rolled into
                    continuous wire rod coils. Using a series of precise dies,
                    rod is then drawn into wire of exact specifications for use
                    in many types of finished fencing product.
                </p>
                <p>
                    Wire is galvanized and converted in-house into finished
                    products, including stock fence, barbed wire, horse fence,
                    and many domestic fencing products. Keystone quality control
                    systems are strictly implemented throughout this process to
                    ensure that finished products meet the customers' exacting
                    standards.
                </p>

                <h3>Red Brand in the UK</h3>
                <p>
                    Keystone Steel and Wire has been marketing Red Brand
                    Keepsafe® Horse Fence in the UK for several years. This
                    product has been well accepted and is recognized as the
                    preferred product for the professional stud farm.
                </p>
                <p>
                    Keystone has now launched a wider range of products, and the
                    product range is now available through the Fence Line. The
                    range includes stock fence, barbed wire, non-climb horse
                    fence, HT plain wire, as well as Yard Garden and Kennel
                    fence from the LG range.
                </p>
                <p>
                    You may also visit the USA Redbrand site www.redbrand.com or
                    for more information on availability in the UK and Europe,
                    go to our enquiry page.
                </p>
            </div>

            <MainFooter />
        </>
    );
}

export default Redbrand;
