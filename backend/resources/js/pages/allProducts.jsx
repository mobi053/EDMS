import React from "react";
import NavbarSearch from "../components/layout/partials/navbarSearch";
import MainNavbar from "../components/layout/partials/mainNavbar";
import MainFooter from "../components/layout/partials/mainFooter";
import HomeSignup from "../components/layout/partials/homeSignup";
import HomeShopCart from "../components/layout/partials/homeShopCart";
import { useState, useEffect } from "react";
import { useLocation, useNavigate, useParams } from "react-router-dom";
import axios from "axios";
import { Bars } from "react-loader-spinner";
import PaginatedLinks from "../components/shared/PaginatedLinks";
import { toast } from "react-toastify";
import "react-toastify/dist/ReactToastify.css";
import { useHistory } from "react-router-dom";
import { Link } from "react-router-dom";
import Rating from "../components/shared/Ratings";
import Slider from "rc-slider";
import "rc-slider/assets/index.css";

function AllProducts() {
    const [perPage, setPerPage] = useState(10);
    const [ratings, setRatings] = useState([]);
    const { categoryId: routeCategoryId } = useParams();
    const [categories, setCategories] = useState([]);
    const [sort, setSort] = useState("");
    // const [priceFrom, setPriceFrom] = useState(0);
    // const [priceTo, setPriceTo] = useState(0);
    const [priceRange, setPriceRange] = useState([0, 100000]);
    const [tagId, setTagId] = useState(0);
    const [groupId, setGroupId] = useState('');
    const [applicationId, setApplicationId] = useState(0);

    const [tags, setTags] = useState([]);
    const [groups, setGroups] = useState([]);
    const [applications, setApplications] = useState([]);

    const [loading, setLoading] = useState(false);
    const [currentPage, setCurrentPage] = useState(1);
    const [categoryId, setCategoryId] = useState("");

    const [products, setProducts] = useState({
        currentPage: 1,
        data: [
            // {
            //     image: {},
            //     category: {},
            //     tags: [{ pivot: {} }],
            //     groups: [{ pivot: {} }],
            //     applications: [{ pivot: {} }],
            // },
        ],
    });

    const handleCategoryClick = (id) => {
        setGroupId("");
        setCategoryId(id);
    };

    const handleAllClick = () => {
        setCategoryId("");
        setGroupId("");
    };

    const handleGroupClick = (id) => {
        setCategoryId("");
        setGroupId(id);
    };

    useEffect(() => {
        fetchData();
    }, []);

    const fetchData = async () => {
        try {
            const response = await axios.get("/api/home/filter");
            const data = response.data.result;
            const { categories, tags, groups, applications } = data;
            setCategories(categories);
            setTags(tags);
            setGroups(groups);
            setApplications(applications);
        } catch (error) {
            console.error("Error fetching data:", error);
        }
    };

    // useEffect(() => {
    //     axios
    //         .get("/api/product/list", {
    //             params: {
    //                 categoryId: routeCategoryId !== "" ? routeCategoryId : null,
    //                 priceRange,
    //                 perPage: 10, // Replace with the number of products you want to display per page
    //             },
    //         })
    //         .then((response) => {
    //             setProducts(response.data.result);
    //         })
    //         .catch((error) => {
    //             console.error(error);
    //         });
    // }, [priceRange]);

    // const handlePriceChange = (values) => {
    //     setPriceFrom(values[0]);
    //     setPriceTo(values[1]);
    // };

    const handlePriceChange = (value) => {
        setPriceRange(value);
    };
    useEffect(() => {
        setLoading(true);
        axios
            .get("/api/category/list")
            .then((response) => {
                setCategories(response.data.result);
            })
            .finally(() => {
                setLoading(false);
            });
    }, []);
    /// function for products by category for navbar and footer
    const handleCategoryRoute = () => {
        if (routeCategoryId) {
            setCategoryId(routeCategoryId);
            return true;
        }
        return false;
    };

    useEffect(() => {
        setLoading(true);

        axios
            .get(
                `/api/product/list?page=${currentPage}&perPage=${perPage}&categoryId=${
                    groupId ? "" : categoryId
                }&ratings=${ratings}&sort=${sort}&tagId=${tagId}&groupId=${
                    categoryId ? "" : groupId
                }&applicationId=${applicationId}&priceRange=${priceRange}`,
                {
                    headers: {
                        Authorization: `Bearer ${localStorage.getItem(
                            "userToken"
                        )}`,
                    },
                }
            )
            .then((response) => {
                setProducts(response.data.result);

                console.log(response.data.result);
            })
            .catch((error) => {
                console.log(error);
            })
            .finally(() => {
                setLoading(false);
            });
    }, [
        currentPage,
        perPage,
        categoryId,
        ratings,
        sort,
        tagId,
        groupId,
        applicationId,
        priceRange
    ]);
    //handling product by category for navbar and footer
    useEffect(() => {
        handleCategoryRoute();
    }, [routeCategoryId]);

    const handlePageChange = (pageNumber) => {
        // navigate(`?page=${pageNumber}&perPage=${perPage}`);
        setCurrentPage(pageNumber);
    };

    // const handleCategoryClick = (categoryName) => {
    //     // navigate(`/products?category=${encodeURIComponent(categoryName)}`);
    // };

    ///functon for adding product to wishlist
    function handleAddToWishlist(productID) {
        setLoading(true);
        axios
            .post(
                "/api/wishlist/store",
                {
                    product_id: productID,
                },
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
                    toast.success("Product added to WishList");
                } else {
                    toast.error("Failed to add to Wishlist");
                }
                // Handle successful response
                console.log(response);
            })
            .catch((error) => {
                // Handle error response
                console.error(error);
            })
            .finally(() => {
                setLoading(false);
            });
    }

    //function for shownig products by ratings
    const handleRatingChange = (event) => {
        const { id, checked } = event.target;
        if (checked) {
            setRatings([...ratings, id]);
        } else {
            const updatedRatings = ratings.filter((rating) => rating !== id);
            setRatings(updatedRatings);
        }
    };

    //funtion for showing products selected by option
    function handleSortingChange(event) {
        const selectedValue = event.target.value;
        setSort(selectedValue);

        const sortedProducts = [...products.data]; // create a copy of the original products array
        switch (selectedValue) {
            case "Low to High":
                sortedProducts.sort((a, b) => a.price - b.price);
                break;
            case "High to Low":
                sortedProducts.sort((a, b) => b.price - a.price);
                break;
            case "Avg. Rating":
                sortedProducts.sort((a, b) => b.avgRating - a.avgRating);
                break;
            default:
                break;
        }
        setProducts({ data: sortedProducts });
    }

    function addToCart(productId, quantity) {
        setLoading(true);
        axios
            .post(
                "/api/cart/store",
                {
                    product_id: productId,
                    quantity: quantity,
                },
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
                    toast.success("Product Added");
                } else {
                    toast.error("Failed to Add Product");
                }
                // Handle successful response

                console.log(response.data); // Handle the response data here
            })
            .catch((error) => {
                console.error(error); // Handle the error here
            })
            .finally(() => {
                setLoading(false);
            });
    }

    function handleAddToCart(id) {
        addToCart(id, 1); // Send the API request to add the product to the cart with a quantity of 1
    }

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

            <HomeSignup />

            <HomeShopCart isLoading={loading} />

            <div className="mt-4">
                <div className="container">
                    <div className="row ">
                        <div className="col-12">
                            <nav aria-label="breadcrumb">
                                <ol className="breadcrumb mb-0">
                                    <li className="breadcrumb-item">
                                        <a href="#!">Home</a>
                                    </li>
                                    <li className="breadcrumb-item">
                                        <a href="#!">Products</a>
                                    </li>
                                    <li
                                        className="breadcrumb-item active"
                                        aria-current="page"
                                    >
                                        All Products
                                    </li>
                                </ol>
                            </nav>
                        </div>
                    </div>
                </div>
            </div>
            <div className=" mt-8 mb-lg-14 mb-8">
                <div className="container">
                    {" "}
                    <div className="row gx-10">
                        <aside className="col-lg-3 col-md-4 mb-6 mb-md-0">
                            <div
                                className="offcanvas offcanvas-start offcanvas-collapse w-md-50 "
                                tabIndex={-1}
                                id="offcanvasCategory"
                                aria-labelledby="offcanvasCategoryLabel"
                            >
                                {/* <div className="offcanvas-header d-lg-none">
                                    <h5
                                        className="offcanvas-title"
                                        id="offcanvasCategoryLabel"
                                    >
                                        Filter
                                    </h5>
                                    <button
                                        type="button"
                                        className="btn-close"
                                        data-bs-dismiss="offcanvas"
                                        aria-label="Close"
                                    />
                                </div> */}
                                <div className="offcanvas-body ps-lg-2 pt-lg-0">
                                    {/* <div className="mb-8">
                                        <h5 className="mb-3">Categories</h5>
                                        <ul
                                            className="nav nav-category"
                                            id="categoryCollapseMenu"
                                        >
                                            {categories.map((category) => (
                                                <li
                                                    key={category.id}
                                                    className="nav-item border-bottom w-100 collapsed"
                                                    onClick={() =>
                                                        setCategoryId(
                                                            category.id
                                                        )
                                                    }
                                                >
                                                    <a
                                                        href="#"
                                                        className="nav-link"
                                                    >
                                                        {category.name}
                                                    </a>
                                                </li>
                                            ))}
                                        </ul>
                                    </div> */}
                                    {/* <div className="mb-8">
                                        <h5 className="mb-3">Categories</h5>
                                        <ul
                                            className="nav nav-category"
                                            id="categoryCollapseMenu"
                                        >
                                            {categories.map((category) => (
                                                <li
                                                    key={category.id}
                                                    className="nav-item border-bottom w-100 collapsed"
                                                    onClick={() =>
                                                        setCategoryId(
                                                            category.id
                                                        )
                                                    }
                                                >
                                                    <a
                                                        href="#"
                                                        className="nav-link"
                                                    >
                                                        {category.name}
                                                    </a>
                                                </li>
                                            ))}
                                        </ul>
                                    </div> */}
                                    <div className="mb-8">
                                        <h5 className="mb-3">Categories</h5>
                                        <ul
                                            className="nav nav-category"
                                            id="categoryCollapseMenu"
                                        >
                                            <li
                                                key="all"
                                                className={`nav-item border-bottom w-100`}
                                                onClick={handleAllClick}
                                            >
                                                <a
                                                    href="#"
                                                    className={`nav-link ${
                                                        categoryId === ''
                                                            ? "custom-active"
                                                            : ""
                                                    }`}
                                                >
                                                    All
                                                </a>
                                            </li>
                                            {categories.map((category) => (
                                                <li
                                                    key={category.id}
                                                    className={`nav-item border-bottom w-100`}
                                                    onClick={() =>
                                                        handleCategoryClick(
                                                            category.id
                                                        )
                                                    }
                                                >
                                                    <a
                                                        href="#"
                                                        className={`nav-link ${
                                                            categoryId === category.id
                                                                ? "custom-active"
                                                                : ""
                                                        }`}
                                                    >
                                                        {category.name}
                                                    </a>
                                                </li>
                                            ))}
                                        </ul>
                                    </div>

                                    {/* <div className="mb-8">
                                        <h5 className="mb-3">Tags</h5>
                                        <ul
                                            className="nav nav-category"
                                            id="tagsCollapseMenu"
                                        >
                                            {tags.map((tag) => (
                                                <li
                                                    key={tag.id}
                                                    className="nav-item border-bottom w-100 collapsed"
                                                    onClick={() =>
                                                        setTagId(tag.id)
                                                    }
                                                >
                                                    <a
                                                        href="#"
                                                        className="nav-link"
                                                    >
                                                        {tag.title}
                                                    </a>
                                                </li>
                                            ))}
                                        </ul>
                                    </div> */}

                                    <div className="mb-8">
                                        <h5 className="mb-3">Groups</h5>
                                        <ul
                                            className="nav nav-category"
                                            id="groupsCollapseMenu"
                                        >
                                            <li
                                                key="all"
                                                className={`nav-item border-bottom w-100`}
                                                onClick={handleAllClick}
                                            >
                                                <a
                                                    href="#"
                                                    className={`nav-link ${
                                                        groupId === ''
                                                            ? "custom-active"
                                                            : ""
                                                    }`}
                                                >
                                                    All
                                                </a>
                                            </li>
                                            {groups.map((group) => (
                                                <li
                                                    key={group.id}
                                                    className={`nav-item border-bottom w-100`}
                                                    onClick={() =>
                                                        handleGroupClick(
                                                            group.id
                                                        )
                                                    }
                                                >
                                                    <a
                                                        href="#"
                                                        className={`nav-link ${
                                                            groupId === group.id
                                                                ? "custom-active"
                                                                : ""
                                                        }`}
                                                    >
                                                        {group.title}
                                                    </a>
                                                </li>
                                            ))}
                                        </ul>
                                    </div>

                                    {/* <div className="mb-8">
                                        <h5 className="mb-3">Applications</h5>
                                        <ul
                                            className="nav nav-category"
                                            id="applicationsCollapseMenu"
                                        >
                                            {applications.map((application) => (
                                                <li
                                                    key={application.id}
                                                    className="nav-item border-bottom w-100 collapsed"
                                                    onClick={() =>
                                                        setApplicationId(
                                                            application.id
                                                        )
                                                    }
                                                >
                                                    <a
                                                        href="#"
                                                        className="nav-link"
                                                    >
                                                        {application.title}
                                                    </a>
                                                </li>
                                            ))}
                                        </ul>
                                    </div> */}
                                    {/* <div className="mb-8">
                                        <h5 className="mb-3">Price</h5>
                                        <div>
                                            <div
                                                id="priceRange"
                                                className="mb-3"
                                            />
                                            <small className="text-muted">
                                                Price:
                                            </small>{" "}
                                            <span
                                                id="priceRange-value"
                                                className="small"
                                            />
                                        </div>
                                    </div> */}

                                    {/* <div className="mb-8">
                                        <h5 className="mb-3">Price</h5>
                                        <div>
                                            <div
                                                id="priceRange"
                                                className="mb-3"
                                                onChange={handlePriceChange}
                                            />
                                            <small className="text-muted">
                                                Price:
                                            </small>{" "}
                                            <span
                                                id="priceRange-value"
                                                className="small"
                                            >
                                                {priceFrom} - {priceTo}
                                            </span>
                                        </div>
                                    </div> */}
                                    <div className="mb-8">
                                        <h5 className="mb-3">Price</h5>
                                        <div>
                                            <Slider
                                                range
                                                min={0}
                                                max={1000}
                                                value={priceRange}
                                                onChange={handlePriceChange}
                                            />
                                            <small className="text-muted">
                                                Price: $
                                            </small>{" "}
                                            <span className="small">
                                                {priceRange[0]} -{" "}
                                                {priceRange[1]}
                                            </span>
                                        </div>
                                    </div>

                                    <div className="mb-8">
                                        <h5 className="mb-3">Rating</h5>
                                        <div>
                                            <div className="form-check mb-2">
                                                <input
                                                    className="form-check-input"
                                                    type="checkbox"
                                                    id="ratingFive"
                                                    value="5"
                                                    onChange={
                                                        handleRatingChange
                                                    }
                                                />
                                                <label
                                                    className="form-check-label"
                                                    htmlFor="ratingFive"
                                                >
                                                    <i className="bi bi-star-fill text-warning" />
                                                    <i className="bi bi-star-fill text-warning " />
                                                    <i className="bi bi-star-fill text-warning " />
                                                    <i className="bi bi-star-fill text-warning " />
                                                    <i className="bi bi-star-fill text-warning " />
                                                </label>
                                            </div>
                                            <div className="form-check mb-2">
                                                <input
                                                    className="form-check-input"
                                                    type="checkbox"
                                                    id="ratingFour"
                                                    value="4"
                                                    defaultChecked=""
                                                    onChange={
                                                        handleRatingChange
                                                    }
                                                />
                                                <label
                                                    className="form-check-label"
                                                    htmlFor="ratingFour"
                                                >
                                                    <i className="bi bi-star-fill text-warning" />
                                                    <i className="bi bi-star-fill text-warning " />
                                                    <i className="bi bi-star-fill text-warning " />
                                                    <i className="bi bi-star-fill text-warning " />
                                                    <i className="bi bi-star text-warning" />
                                                </label>
                                            </div>
                                            <div className="form-check mb-2">
                                                <input
                                                    className="form-check-input"
                                                    type="checkbox"
                                                    id="ratingThree"
                                                    value="3"
                                                    onChange={
                                                        handleRatingChange
                                                    }
                                                />
                                                <label
                                                    className="form-check-label"
                                                    htmlFor="ratingThree"
                                                >
                                                    <i className="bi bi-star-fill text-warning" />
                                                    <i className="bi bi-star-fill text-warning " />
                                                    <i className="bi bi-star-fill text-warning " />
                                                    <i className="bi bi-star text-warning" />
                                                    <i className="bi bi-star text-warning" />
                                                </label>
                                            </div>
                                            <div className="form-check mb-2">
                                                <input
                                                    className="form-check-input"
                                                    type="checkbox"
                                                    id="ratingTwo"
                                                    value="2"
                                                    onChange={
                                                        handleRatingChange
                                                    }
                                                />
                                                <label
                                                    className="form-check-label"
                                                    htmlFor="ratingTwo"
                                                >
                                                    <i className="bi bi-star-fill text-warning" />
                                                    <i className="bi bi-star-fill text-warning" />
                                                    <i className="bi bi-star text-warning" />
                                                    <i className="bi bi-star text-warning" />
                                                    <i className="bi bi-star text-warning" />
                                                </label>
                                            </div>

                                            <div className="form-check mb-2">
                                                <input
                                                    className="form-check-input"
                                                    type="checkbox"
                                                    id="ratingOne"
                                                    value="1"
                                                    onChange={
                                                        handleRatingChange
                                                    }
                                                />
                                                <label
                                                    className="form-check-label"
                                                    htmlFor="ratingOne"
                                                >
                                                    <i className="bi bi-star-fill text-warning" />
                                                    <i className="bi bi-star text-warning" />
                                                    <i className="bi bi-star text-warning" />
                                                    <i className="bi bi-star text-warning" />
                                                    <i className="bi bi-star text-warning" />
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                    <div className="mb-8 position-relative">
                                        <div className="position-absolute p-5 py-8">
                                            <h3 className="mb-0 text-white">
                                                Hand Crafted
                                            </h3>
                                        </div>
                                        <img
                                            src="/front/dist/assets/images/banner/img7.jpg"
                                            alt=""
                                            className="img-fluid rounded "
                                        />
                                    </div>
                                </div>
                            </div>
                        </aside>
                        <section className="col-lg-9 col-md-12">
                            <div className="card mb-4 bg-light border-0">
                                <div className=" card-body p-9">
                                    <h2 className="mb-0 fs-1">
                                        The Fence Line Products
                                    </h2>
                                </div>
                            </div>
                            <div className="d-lg-flex justify-content-between align-items-center">
                                <div className="mb-3 mb-lg-0">
                                    <p className="mb-0">
                                        <span className="text-dark">
                                            {/* {products.total} */}
                                        </span>{" "}
                                        Products found
                                    </p>
                                </div>
                                <div className="d-md-flex justify-content-between align-items-center">
                                    <div className="d-flex align-items-center justify-content-between">
                                        {/* <div>
                                            <a className="text-muted me-3">
                                                <i className="bi bi-list-ul" />
                                            </a>
                                            <a className=" me-3 active">
                                                <i className="bi bi-grid" />
                                            </a>
                                            <a className="me-3 text-muted">
                                                <i className="bi bi-grid-3x3-gap" />
                                            </a>
                                        </div> */}
                                        <div className="ms-2 d-lg-none">
                                            <a
                                                className="btn btn-outline-gray-400 text-muted"
                                                data-bs-toggle="offcanvas"
                                                href="#offcanvasCategory"
                                                role="button"
                                                aria-controls="offcanvasCategory"
                                            >
                                                <svg
                                                    xmlns="http://www.w3.org/2000/svg"
                                                    width={14}
                                                    height={14}
                                                    viewBox="0 0 24 24"
                                                    fill="none"
                                                    stroke="currentColor"
                                                    strokeWidth={2}
                                                    strokeLinecap="round"
                                                    strokeLinejoin="round"
                                                    className="feather feather-filter me-2"
                                                >
                                                    <polygon points="22 3 2 3 10 12.46 10 19 14 21 14 12.46 22 3" />
                                                </svg>{" "}
                                                Filters
                                            </a>
                                        </div>
                                    </div>
                                    <div className="d-flex mt-2 mt-lg-0">
                                        <div className="me-2 flex-grow-1">
                                            <select
                                                className="form-select"
                                                value={perPage}
                                                onChange={(e) => {
                                                    setPerPage(e.target.value);
                                                    setCurrentPage(1);
                                                }}
                                            >
                                                <option value={10}>
                                                    Show: 10
                                                </option>
                                                <option value={20}>20</option>
                                                <option value={30}>30</option>
                                            </select>
                                        </div>
                                        <div>
                                            <select
                                                className="form-select"
                                                onChange={handleSortingChange}
                                            >
                                                <option value="Low-to-High">
                                                    Price: Low to High
                                                </option>
                                                <option value="High-to-Low">
                                                    {" "}
                                                    Price: High to Low
                                                </option>
                                                <option value="Avg-Rating">
                                                    {" "}
                                                    Avg. Rating
                                                </option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div className="row g-4 row-cols-xl-4 row-cols-lg-3 row-cols-2 row-cols-md-2 mt-2">
                                {products?.data.map((product) => (
                                    <div className="col" key={product.id}>
                                        <div className="card card-product">
                                            <div className="card-body">
                                                <div className="text-center position-relative ">
                                                    <Link
                                                        to={`/productPage/${product.id}`}
                                                    >
                                                        <img
                                                            src={`/storage/images/${product.image?.path}`}
                                                            alt="Grocery Ecommerce Template"
                                                            className="mb-3 img-fluid"
                                                        />
                                                    </Link>
                                                    <div className="card-product-action">
                                                        <a
                                                            className="btn-action"
                                                            data-bs-toggle="tooltip"
                                                            data-bs-html="true"
                                                            title="Wishlist"
                                                            onClick={() =>
                                                                handleAddToWishlist(
                                                                    product.id
                                                                )
                                                            }
                                                            style={{
                                                                cursor: "pointer",
                                                            }}
                                                        >
                                                            <i className="bi bi-heart" />
                                                        </a>
                                                    </div>
                                                </div>
                                                <div className="text-small mb-1">
                                                    <a
                                                        href="#!"
                                                        className="text-decoration-none text-muted"
                                                    >
                                                        <small>
                                                            {
                                                                product.category
                                                                    .name
                                                            }
                                                        </small>
                                                    </a>
                                                </div>
                                                <h2 className="fs-6">
                                                    <a
                                                        // href="shop-single.html"
                                                        className="text-inherit text-decoration-none"
                                                    >
                                                        {product.name};
                                                    </a>
                                                </h2>

                                                <Rating
                                                    value={
                                                        product.ratings_avg_rating
                                                    }
                                                    color={"gold"}
                                                />
                                                <div className="d-flex justify-content-between align-items-center mt-3">
                                                    <div>
                                                        <span className="text-dark">
                                                            ${product.price}
                                                        </span>{" "}
                                                    </div>
                                                    <div>
                                                        <a
                                                            href="#!"
                                                            className="btn btn-primary btn-sm"
                                                            onClick={() =>
                                                                handleAddToCart(
                                                                    product.id
                                                                )
                                                            }
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
                                                                className="feather feather-plus"
                                                            >
                                                                <line
                                                                    x1={12}
                                                                    y1={5}
                                                                    x2={12}
                                                                    y2={19}
                                                                />
                                                                <line
                                                                    x1={5}
                                                                    y1={12}
                                                                    x2={19}
                                                                    y2={12}
                                                                />
                                                            </svg>{" "}
                                                            Add
                                                        </a>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                ))}
                            </div>
                            <div className="row mt-8">
                                <div className="col">
                                    <PaginatedLinks
                                        data={products}
                                        currentPage={currentPage}
                                        lastPage={products.last_page}
                                        onPageChange={handlePageChange}
                                    />
                                </div>
                            </div>
                        </section>
                    </div>
                </div>
            </div>

            <MainFooter />
        </>
    );
}

export default AllProducts;
