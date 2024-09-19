import React, { useEffect, useRef } from "react";
import { Link } from "react-router-dom";
import { useState } from "react";
import axios from "axios";
import { Dropdown } from "react-bootstrap";
import { NavLink } from "react-router-dom";

function MainNavbar() {
    const [categories, setCategory] = useState([]);
    const [loggedIn, setLoggedIn] = useState(false);
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
            setCategory(response.data.result);
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
    const handleLogout = () => {
        localStorage.removeItem("userToken");
        localStorage.removeItem("userName");
        localStorage.removeItem("userEmail");
        // navigate to logout page or redirect to login page
        setLoggedIn(false);
    };
    const [showCategoriesDropdown, setShowCategoriesDropdown] = useState(false);
    const [showInformationDropdown, setShowInformationDropdown] =
        useState(false);

    const handleCategoriesToggle = () => {
        setShowCategoriesDropdown(!showCategoriesDropdown);
    };

    const handleInformationToggle = () => {
        setShowInformationDropdown(!showInformationDropdown);
    };

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
        <nav className="navbar navbar-expand-lg navbar-light navbar-default py-0 py-lg-4">
            <div className="container px-0 px-md-3">
                <div
                    className="offcanvas offcanvas-start p-4 p-lg-0"
                    id="navbar-default"
                >
                    <div class="d-flex justify-content-between align-items-center mb-2 d-block d-lg-none">
                        <Link to="/" className="navbar-brand ">
                            <img
                                src="/logo/psca-logo.png"
                                alt="FenceLine Logo"
                                className="img-fluid "
                                style={{ maxWidth: "30%", height: "auto" }}
                            />
                        </Link>
                        <button
                            type="button"
                            class="btn-close"
                            data-bs-dismiss="offcanvas"
                            aria-label="Close"
                        ></button>
                    </div>
                    <div class="d-block d-lg-none my-4">
                        {/* <form action="#">
                            <div class="input-group ">
                                <input
                                    class="form-control rounded"
                                    type="text"
                                    placeholder="Search for products"
                                />
                                <span class="input-group-append">
                                    <button
                                        class="btn bg-white border border-start-0 ms-n10 rounded-0 rounded-end"
                                        type="button"
                                    >
                                        <svg
                                            xmlns="http://www.w3.org/2000/svg"
                                            width="16"
                                            height="16"
                                            viewBox="0 0 24 24"
                                            fill="none"
                                            stroke="currentColor"
                                            stroke-width="2"
                                            stroke-linecap="round"
                                            stroke-linejoin="round"
                                            class="feather feather-search"
                                        >
                                            <circle
                                                cx="11"
                                                cy="11"
                                                r="8"
                                            ></circle>
                                            <line
                                                x1="21"
                                                y1="21"
                                                x2="16.65"
                                                y2="16.65"
                                            ></line>
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
                                    className="suggestionstwo"
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
                    <div className="d-none d-lg-block">
                        <ul className="navbar-nav align-items-center ">
                            <li className="nav-item ">
                                <Link to="/" className="nav-link">
                                    Home
                                </Link>
                            </li>
                            <li className="nav-item">
                                <Link to="/products" className="nav-link">
                                    Products
                                </Link>
                            </li>
                            {/* <li className="nav-item dropdown">
                                <a
                                    className="nav-link dropdown-toggle"
                                    href="#"
                                    role="button"
                                    data-bs-toggle="dropdown"
                                    aria-expanded="false"
                                >
                                    Categories
                                </a>
                                <ul className="dropdown-menu">
                                    {categories.map((category, index) => (
                                        <li key={index}>
                                            <Link
                                                to={`/products/${category.id}`}
                                                className="dropdown-item"
                                            >
                                                {category.name}
                                            </Link>
                                        </li>
                                    ))}
                                </ul>
                            </li> */}
                            <Dropdown
                                show={showCategoriesDropdown}
                                onToggle={handleCategoriesToggle}
                                onMouseEnter={() =>
                                    setShowCategoriesDropdown(true)
                                }
                                onMouseLeave={() =>
                                    setShowCategoriesDropdown(false)
                                }
                            >
                                <Dropdown.Toggle
                                    as={NavLink}
                                    className="nav-link dropdown-toggle"
                                >
                                    Categories
                                </Dropdown.Toggle>
                                <Dropdown.Menu style={{ margin: 0 }}>
                                    {categories.map((category) => (
                                        <Dropdown.Item
                                            as={Link}
                                            key={category.id}
                                            to={`/products/${category.id}`}
                                        >
                                            {category.name}
                                        </Dropdown.Item>
                                    ))}
                                </Dropdown.Menu>
                            </Dropdown>

                            <Dropdown
                                show={showInformationDropdown}
                                onToggle={handleInformationToggle}
                                onMouseEnter={() =>
                                    setShowInformationDropdown(true)
                                }
                                onMouseLeave={() =>
                                    setShowInformationDropdown(false)
                                }
                            >
                                <Dropdown.Toggle
                                    as={NavLink}
                                    className="nav-link dropdown-toggle"
                                >
                                    Information and Guide
                                </Dropdown.Toggle>
                                <Dropdown.Menu style={{ margin: 0 }}>
                                    <Dropdown.Item
                                        as={Link}
                                        to="/InstallationGuide"
                                    >
                                        Installation Guides
                                    </Dropdown.Item>
                                    <Dropdown.Item as={Link} to="/FAQs">
                                        FAQs
                                    </Dropdown.Item>
                                    <Dropdown.Item as={Link} to="/redbrand">
                                        About Redbrand
                                    </Dropdown.Item>
                                </Dropdown.Menu>
                            </Dropdown>

                            <li className="nav-item ">
                                <Link to="/about" className="nav-link">
                                    About Us
                                </Link>
                            </li>
                            <li className="nav-item ">
                                <Link to="/contact" className="nav-link">
                                    Contact
                                </Link>
                            </li>
                            {/* <li className="nav-item ">
                                <Link to="/blog" className="nav-link">
                                    Blog
                                </Link>
                            </li> */}
                            {/* {!loggedIn && (
                                <li className="nav-item">
                                    <Link
                                        className="nav-link"
                                        to="/signin"
                                        style={{ color: "#21313c" }}
                                    >
                                        Login
                                    </Link>
                                </li>
                            )} */}
                        </ul>
                    </div>
                    <div className="d-block d-lg-none h-100" data-simplebar="">
                        <ul className="navbar-nav  m-0">
                            <li className="nav-item ">
                                <Link
                                    to="/"
                                    className="nav-link "
                                    role="button"
                                >
                                    Home
                                </Link>
                            </li>
                            <li className="nav-item">
                                <Link to="/products" className="nav-link">
                                    Products
                                </Link>
                            </li>

                            <Dropdown
                                show={showCategoriesDropdown}
                                onToggle={handleCategoriesToggle}
                            >
                                <Dropdown.Toggle
                                    as={NavLink}
                                    className="nav-link dropdown-toggle"
                                >
                                    Categories
                                </Dropdown.Toggle>
                                <Dropdown.Menu style={{ margin: 0 }}>
                                    {categories.map((category) => (
                                        <Dropdown.Item
                                            as={Link}
                                            key={category.id}
                                            to={`/products/${category.id}`}
                                        >
                                            {category.name}
                                        </Dropdown.Item>
                                    ))}
                                </Dropdown.Menu>
                            </Dropdown>

                            <Dropdown
                                show={showInformationDropdown}
                                onToggle={handleInformationToggle}
                            >
                                <Dropdown.Toggle
                                    as={NavLink}
                                    className="nav-link dropdown-toggle"
                                >
                                    Information and Guide
                                </Dropdown.Toggle>
                                <Dropdown.Menu style={{ margin: 0 }}>
                                    <Dropdown.Item
                                        as={Link}
                                        to="/InstallationGuide"
                                    >
                                        Installation Guides
                                    </Dropdown.Item>
                                    <Dropdown.Item as={Link} to="/FAQs">
                                        FAQs
                                    </Dropdown.Item>
                                    <Dropdown.Item as={Link} to="/redbrand">
                                        About Redbrand
                                    </Dropdown.Item>
                                </Dropdown.Menu>
                            </Dropdown>

                            <li className="nav-item ">
                                <Link to="/about" className="nav-link">
                                    About Us
                                </Link>
                            </li>
                            <li className="nav-item ">
                                <Link to="/contact" className="nav-link">
                                    Contact
                                </Link>
                            </li>
                            <li className="nav-item">
                                <Link to="/blog" className="nav-link">
                                    Blog
                                </Link>
                            </li>
                            {!loggedIn && (
                                <li className="nav-item">
                                    <Link
                                        className="nav-link"
                                        to="/signin"
                                        style={{ color: "#21313c" }}
                                    >
                                        Login
                                    </Link>
                                </li>
                            )}
                        </ul>
                    </div>
                </div>
            </div>
        </nav>
    );
}

export default MainNavbar;
