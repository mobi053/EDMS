import axios from "axios";
import React, { useEffect, useRef, useState } from "react";
import { Link } from "react-router-dom";
import { FaUser } from "react-icons/fa";
import { NavLink } from "react-router-dom";

function NavbarSearch() {
    const [wishlistCount, setWishlistCount] = useState(0);
    const [cartCount, setCartCount] = useState(0);
    const [loggedIn, setLoggedIn] = useState(false);
    const [categories, setCategories] = useState([]);
    const [showSuggestions, setShowSuggestions] = useState(false);
    const [searchResults, setSearchResults] = useState([]);
    const suggestionsRef = useRef(null);

    useEffect(() => {
        document.addEventListener("click", handleClickOutside);
        return () => {
            document.removeEventListener("click", handleClickOutside);
        };
    }, []);

    //closing the dropdown
    const handleClickOutside = (event) => {
        const searchInput = document.querySelector('input[name="searchInput"]');
        if (
            suggestionsRef.current &&
            !suggestionsRef.current.contains(event.target) &&
            event.target !== searchInput
        ) {
            setShowSuggestions(false);
        }
    };

    useEffect(() => {
        axios.get("/api/category/list").then((response) => {
            setCategories(response.data.result);
        });
    }, []);

    useEffect(() => {
        if (!loggedIn) return;

        axios
            .get(`/api/home/counters`, {
                headers: {
                    Authorization: `Bearer ${localStorage.getItem(
                        "userToken"
                    )}`,
                },
            })
            .then((response) => {
                setWishlistCount(response.data.result.whishlist);
                setCartCount(response.data.result.cart);
            })
            .catch((error) => {
                console.error(error);
            });
    }, []);

    useEffect(() => {
        const accessToken = localStorage.getItem("userToken");
        if (accessToken) {
            setLoggedIn(true);
        } else {
            setLoggedIn(false);
        }
    }, []);

    const handleSearch = async (event) => {
        event.preventDefault();
        console.log(event.target.tagName);

        let searchQuery;
        if (event.target.tagName === "FORM") {
            searchQuery = event.target.elements.searchInput.value;
        } else {
            searchQuery = event.target.value;
        }

        try {
            if (searchQuery) {
                const response = await axios.get(
                    `/api/product/search/${searchQuery}`
                );
                const products = response.data;
                setSearchResults(response.data?.result);
            } else {
                setSearchResults([]);
            }

            // Handle the retrieved products data
        } catch (error) {
            // Handle error
        }
    };

    const handleSearchBarClick = () => {
        setShowSuggestions(true);
    };

    const handleProductClick = () => {
        setShowSuggestions(false);
    };
    return (
        <div className="py-4 pt-lg-3 pb-lg-0">
            <div className="container">
                <div className="row w-100 align-items-center gx-lg-2 gx-0">
                    <div className="col-xxl-2 col-lg-3">
                        <Link to="/" className="navbar-brand d-none d-lg-block">
                            <img
                                src="/logo/psca-logo.png"
                                alt="FenceLine Logo"
                                className="img-fluid "
                                style={{ maxWidth: "70%", height: "auto" }}
                            />
                        </Link>
                        <div className="d-flex justify-content-between w-100 d-lg-none">
                            <Link to="/" className="navbar-brand ">
                                <img
                                    src="/logo/psca-logo.png"
                                    alt="FenceLine Logo"
                                    className="img-fluid "
                                    style={{ maxWidth: "30%", height: "auto" }}
                                />
                            </Link>
                            <div className="d-flex align-items-center lh-1">
                                <div className="list-inline me-4">
                                    <div className="list-inline-item">
                                        <a
                                            className="text-muted position-relative "
                                            data-bs-toggle="offcanvas"
                                            data-bs-target="#offcanvasRight"
                                            href="#offcanvasExample"
                                            role="button"
                                            aria-controls="offcanvasRight"
                                        >
                                            <svg
                                                xmlns="http://www.w3.org/2000/svg"
                                                width={20}
                                                height={20}
                                                viewBox="0 0 24 24"
                                                fill="none"
                                                stroke="currentColor"
                                                strokeWidth={2}
                                                strokeLinecap="round"
                                                strokeLinejoin="round"
                                                className="feather feather-shopping-bag"
                                            >
                                                <path d="M6 2L3 6v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2V6l-3-4z" />
                                                <line
                                                    x1={3}
                                                    y1={6}
                                                    x2={21}
                                                    y2={6}
                                                />
                                                <path d="M16 10a4 4 0 0 1-8 0" />
                                            </svg>
                                            <span className="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-success">
                                                {cartCount}
                                                <span className="visually-hidden">
                                                    unread messages
                                                </span>
                                            </span>
                                        </a>
                                    </div>
                                </div>
                                {/* Button */}
                                <button
                                    className="navbar-toggler collapsed"
                                    type="button"
                                    data-bs-toggle="offcanvas"
                                    data-bs-target="#navbar-default"
                                    aria-controls="navbar-default"
                                    aria-expanded="false"
                                    aria-label="Toggle navigation"
                                >
                                    <svg
                                        xmlns="http://www.w3.org/2000/svg"
                                        width={32}
                                        height={32}
                                        fill="currentColor"
                                        className="bi bi-text-indent-left text-primary"
                                        viewBox="0 0 16 16"
                                    >
                                        <path d="M2 3.5a.5.5 0 0 1 .5-.5h11a.5.5 0 0 1 0 1h-11a.5.5 0 0 1-.5-.5zm.646 2.146a.5.5 0 0 1 .708 0l2 2a.5.5 0 0 1 0 .708l-2 2a.5.5 0 0 1-.708-.708L4.293 8 2.646 6.354a.5.5 0 0 1 0-.708zM7 6.5a.5.5 0 0 1 .5-.5h6a.5.5 0 0 1 0 1h-6a.5.5 0 0 1-.5-.5zm0 3a.5.5 0 0 1 .5-.5h6a.5.5 0 0 1 0 1h-6a.5.5 0 0 1-.5-.5zm-5 3a.5.5 0 0 1 .5-.5h11a.5.5 0 0 1 0 1h-11a.5.5 0 0 1-.5-.5z" />
                                    </svg>
                                </button>
                            </div>
                        </div>
                    </div>
                    <div className="col-xxl-8 col-lg-5 d-none d-lg-block">
                        {/* <form action="#">
                            <div className="input-group ">
                                <input
                                    className="form-control rounded"
                                    type="search"
                                    placeholder="Search for products"
                                />
                                <span className="input-group-append">
                                    <button
                                        className="btn bg-white border border-start-0 ms-n10 rounded-0 rounded-end"
                                        type="button"
                                    >
                                        <svg
                                            xmlns="http://www.w3.org/2000/svg"
                                            width={16}
                                            height={16}
                                            viewBox="0 0 24 24"
                                            fill="none"
                                            stroke="currentColor"
                                            strokeWidth={2}
                                            strokeLinecap="round"
                                            strokeLinejoin="round"
                                            className="feather feather-search"
                                        >
                                            <circle cx={11} cy={11} r={8} />
                                            <line
                                                x1={21}
                                                y1={21}
                                                x2="16.65"
                                                y2="16.65"
                                            />
                                        </svg>
                                    </button>
                                </span>
                            </div>
                        </form> */}
                        <form
                            onSubmit={handleSearch}
                            style={{ position: "relative" }}
                        >
                            <div className="input-group">
                                <input
                                    className="form-control rounded"
                                    type="text"
                                    placeholder="Search for products"
                                    name="searchInput"
                                    onClick={handleSearchBarClick}
                                    onKeyUp={handleSearch}
                                />
                                <span className="input-group-append">
                                    <button
                                        className="btn bg-white border border-start-0 ms-n10 rounded-0 rounded-end"
                                        type="submit"
                                    >
                                        <svg
                                            xmlns="http://www.w3.org/2000/svg"
                                            width={16}
                                            height={16}
                                            viewBox="0 0 24 24"
                                            fill="none"
                                            stroke="currentColor"
                                            strokeWidth={2}
                                            strokeLinecap="round"
                                            strokeLinejoin="round"
                                            className="feather feather-search"
                                        >
                                            <circle cx={11} cy={11} r={8} />
                                            <line
                                                x1={21}
                                                y1={21}
                                                x2="16.65"
                                                y2="16.65"
                                            />
                                        </svg>
                                    </button>
                                </span>
                            </div>
                            {showSuggestions && searchResults.length > 0 && (
                                <ul
                                    className="suggestions"
                                    ref={suggestionsRef}
                                >
                                    {searchResults.map((product) => (
                                        <li
                                            key={product.id}
                                            onClick={handleProductClick}
                                        >
                                            <NavLink
                                                to={`/productPage/${product.id}`}
                                                style={{ color: "black" }}
                                            >
                                                {product.name}
                                            </NavLink>
                                        </li>
                                    ))}
                                </ul>
                            )}
                        </form>
                    </div>
                    <div className="col-md-2 col-xxl-1 d-none d-lg-block">
                        {/* Button trigger modal */}
                        {/*<button
                            type="button"
                            className="btn  btn-outline-gray-400 text-muted"
                            data-bs-toggle="modal"
                            data-bs-target="#locationModal"
                        >
                            <i className="feather-icon icon-map-pin me-2" />
                            Location
                        </button>*/}
                    </div>
                    <div className="col-md-2 col-xxl-1 text-end d-none d-lg-block ">
                        <div className="list-inline">
                            {loggedIn ? (
                                <>
                                    <div className="list-inline-item  mx-3">
                                        <Link
                                            to="/product-wishlist"
                                            className="text-muted position-relative"
                                        >
                                            <svg
                                                xmlns="http://www.w3.org/2000/svg"
                                                width={20}
                                                height={20}
                                                viewBox="0 0 24 24"
                                                fill="none"
                                                stroke="currentColor"
                                                strokeWidth={2}
                                                strokeLinecap="round"
                                                strokeLinejoin="round"
                                                className="feather feather-heart"
                                            >
                                                <path d="M20.84 4.61a5.5 5.5 0 0 0-7.78 0L12 5.67l-1.06-1.06a5.5 5.5 0 0 0-7.78 7.78l1.06 1.06L12 21.23l7.78-7.78 1.06-1.06a5.5 5.5 0 0 0 0-7.78z"></path>
                                            </svg>
                                            {wishlistCount != 0 && (
                                                <span className="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-success">
                                                    {wishlistCount}
                                                    <span className="visually-hidden">
                                                        whishlist counter
                                                    </span>
                                                </span>
                                            )}
                                        </Link>
                                    </div>

                                    <div className="list-inline-item">
                                        <a
                                            className="text-muted position-relative "
                                            data-bs-toggle="offcanvas"
                                            data-bs-target="#offcanvasRight"
                                            href="#offcanvasExample"
                                            role="button"
                                            aria-controls="offcanvasRight"
                                        >
                                            <svg
                                                xmlns="http://www.w3.org/2000/svg"
                                                width={20}
                                                height={20}
                                                viewBox="0 0 24 24"
                                                fill="none"
                                                stroke="currentColor"
                                                strokeWidth={2}
                                                strokeLinecap="round"
                                                strokeLinejoin="round"
                                                className="feather feather-shopping-bag"
                                            >
                                                <path d="M6 2L3 6v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2V6l-3-4z" />
                                                <line
                                                    x1={3}
                                                    y1={6}
                                                    x2={21}
                                                    y2={6}
                                                />
                                                <path d="M16 10a4 4 0 0 1-8 0" />
                                            </svg>
                                            {cartCount != 0 && (
                                                <span className="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-success">
                                                    {cartCount}
                                                    <span className="visually-hidden">
                                                        unread messages
                                                    </span>
                                                </span>
                                            )}
                                        </a>
                                    </div>
                                    {/* <Link
                                        to="/account-orders"
                                        className="account-icon"
                                    >
                                        <FaUser />
                                    </Link> */}
                                    <div className="list-inline-item">
                                        <Link
                                            to="/account-orders"
                                            className="text-muted"
                                        >
                                            <svg
                                                xmlns="http://www.w3.org/2000/svg"
                                                width="20"
                                                height="20"
                                                viewBox="0 0 24 24"
                                                fill="none"
                                                stroke="currentColor"
                                                strokeWidth="2"
                                                strokeLinecap="round"
                                                strokeLinejoin="round"
                                                className="feather feather-user"
                                            >
                                                <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path>
                                                <circle
                                                    cx="12"
                                                    cy="7"
                                                    r="4"
                                                ></circle>
                                            </svg>
                                        </Link>
                                    </div>
                                </>
                            ) : (
                                <>
                                    <Link
                                        to="/signin"
                                        className="btn btn-primary"
                                    >
                                        Sign In
                                    </Link>
                                </>
                            )}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    );
}

export default NavbarSearch;
