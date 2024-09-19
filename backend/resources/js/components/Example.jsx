import React from "react";
import ReactDOM from "react-dom/client";
import { BrowserRouter } from "react-router-dom";
import { Routes, Route } from "react-router-dom";
import Home from "./Home";
import AllProducts from "../pages/allProducts";
import Categories from "../pages/categories";
import Accounts from "../pages/account";
import ProductWishlist from "../pages/productWishlist";
import AboutUs from "../pages/aboutUs";
import Contact from "../pages/contact";
import Blog from "../pages/blog";
import NavbarSearch from "./layout/partials/navbarSearch";
import Signinpage from "../pages/signinPage";
import { ToastContainer } from "react-toastify";
import SignupPage from "../pages/signupPage";
import SignUpPage from "../pages/signupPage";
import ProductPage from "../pages/productPage";
import AccountSettings from "../pages/accountSettings";
import AccountAddress from "../pages/accountAddress";
import AccountPayment from "../pages/accountPayment";
import AccountNotification from "../pages/accountnotifications";
import ForgetPassword from "../pages/forgetPassword";
import ResetPassword from "../pages/resetpassword";
import InstallationGuide from "../pages/installationGuide";
import FAQs from "../pages/faqs";
import Redbrand from "../pages/aboutredbrand";
import TermsAndConditions from "../pages/termsandcondition";

function Example() {
    return (
        <>
            <Routes>
                <Route path="/" element={<Home />} />
                <Route path="/products" element={<AllProducts />} />
                <Route path="/categories" element={<Categories />} />
                <Route path="/account-orders" element={<Accounts />} />
                <Route path="/product-wishlist" element={<ProductWishlist />} />
                <Route path="/about" element={<AboutUs />} />
                <Route path="/contact" element={<Contact />} />
                <Route path="/blog" element={<Blog />} />
                <Route path="/" element={<NavbarSearch />} />
                <Route path="/signin" element={<Signinpage />} />
                <Route path="/signup" element={<SignUpPage />} />
                <Route
                    path="/productPage/:productId"
                    element={<ProductPage />}
                />
                <Route path="/products/:categoryId" element={<AllProducts />} />
                <Route path="/account-settings" element={<AccountSettings />} />
                <Route path="/account-address" element={<AccountAddress />} />
                <Route path="/account-payment" element={<AccountPayment />} />
                <Route
                    path="/account-notification"
                    element={<AccountNotification />}
                />
                <Route path="/forget-password" element={<ForgetPassword />} />
                <Route
                    path="/reset-password/:token/:email"
                    element={<ResetPassword />}
                />

                <Route
                    path="/InstallationGuide"
                    element={<InstallationGuide />}
                />
                <Route path="/FAQs" element={<FAQs />} />
                <Route
                    path="/termsandconditions"
                    element={<TermsAndConditions />}
                />

                <Route path="/redbrand" element={<Redbrand />} />
            </Routes>
        </>
    );
}

export default Example;

if (document.getElementById("app")) {
    const Index = ReactDOM.createRoot(document.getElementById("app"));

    Index.render(
        <React.StrictMode>
            <BrowserRouter>
                <Example />
                <ToastContainer />
            </BrowserRouter>
        </React.StrictMode>
    );
}
