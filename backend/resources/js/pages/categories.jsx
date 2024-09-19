// import React from "react";
// import NavbarSearch from "../components/layout/partials/navbarSearch";
// import MainNavbar from "../components/layout/partials/mainNavbar";
// import MainFooter from "../components/layout/partials/mainFooter";
// import HomeSignup from "../components/layout/partials/homeSignup";
// import HomeShopCart from "../components/layout/partials/homeShopCart";
// function Categories() {
//     return (
//         <>
//             <div className="border-bottom ">
//                 <NavbarSearch />
//                 <MainNavbar />
//             </div>
//             {/* Modal */}
//             <HomeSignup />
//             {/* Shop Cart */}
//             <HomeShopCart />
//             <div class="mt-4">
//                 <div class="container">
//                     <div class="row ">
//                         <div class="col-12">
//                             <nav aria-label="breadcrumb">
//                                 <ol class="breadcrumb mb-0">
//                                     <li class="breadcrumb-item">
//                                         <a href="#!">Home</a>
//                                     </li>
//                                     <li class="breadcrumb-item">
//                                         <a href="#!">Categories</a>
//                                     </li>
//                                     <li
//                                         class="breadcrumb-item active"
//                                         aria-current="page"
//                                     >
//                                         Category Details
//                                     </li>
//                                 </ol>
//                             </nav>
//                         </div>
//                     </div>
//                 </div>
//             </div>

//             <section className="mt-8 ">
//                 {/* container */}
//                 <div className="container">
//                     {/* row */}
//                     <div className="row ">
//                         <div className="col-12 ">
//                             {/* heading */}
//                             <div className="bg-light d-flex justify-content-between ps-md-10 ps-6 rounded">
//                                 <div className="d-flex align-items-center">
//                                     <h1 className="mb-0 fw-bold">Categories</h1>
//                                 </div>
//                                 <div className="py-6">
//                                     {/* img */}
//                                     {/* img */}
//                                     <img
//                                         src="/front/dist/assets/images/svg-graphics/store-graphics.svg"
//                                         alt=""
//                                         className="img-fluid"
//                                     />
//                                 </div>
//                             </div>
//                         </div>
//                     </div>
//                 </div>
//             </section>
//             {/* section */}
//             <section className="mt-8 mb-lg-14 mb-8">
//                 <div className="container">
//                     {/* row */}
//                     <div className="row">
//                         {/* col */}
//                         <div className="col-12">
//                             <div className="mb-3">
//                                 {/* text */}
//                                 <h6>
//                                     We have{" "}
//                                     <span className="text-primary">36</span>{" "}
//                                     vendors now
//                                 </h6>
//                             </div>
//                         </div>
//                     </div>
//                     <div className="row row-cols-1 row-cols-lg-4 row-cols-md-3 g-4 g-lg-4">
//                         {/* col */}
//                         <div className="col">
//                             {/* card */}
//                             <div className="card p-6 card-product">
//                                 <div>
//                                     {" "}
//                                     {/* img */}
//                                     <img
//                                         src="/front/dist/assets/images/stores-logo/stores-logo-1.svg"
//                                         alt=""
//                                         className="rounded-circle icon-shape icon-xl"
//                                     />
//                                 </div>
//                                 <div className="mt-4">
//                                     {/* content */}
//                                     <h2 className="mb-1 h5">
//                                         <a href="#!" className="text-inherit">
//                                             E-Grocery Super Market
//                                         </a>
//                                     </h2>
//                                     <div className="small text-muted">
//                                         <span className="me-2">Organic </span>
//                                         <span className="me-2">Groceries</span>
//                                         <span>Butcher Shop</span>
//                                     </div>
//                                     <div className="py-3">
//                                         <ul className="list-unstyled mb-0 small">
//                                             <li>Delivery</li>
//                                             <li>Pickup available</li>
//                                         </ul>
//                                     </div>
//                                     <div>
//                                         {/* badge */}{" "}
//                                         <div className="badge text-bg-light border">
//                                             7.5 mi away
//                                         </div>
//                                         {/* badge */}{" "}
//                                         <div className="badge text-bg-light border">
//                                             In-store prices{" "}
//                                         </div>
//                                     </div>
//                                 </div>
//                             </div>
//                         </div>
//                         <div className="col">
//                             {/* card */}
//                             <div className="card p-6 card-product">
//                                 <div>
//                                     {" "}
//                                     {/* img */}
//                                     <img
//                                         src="/front/dist/assets/images/stores-logo/stores-logo-2.svg"
//                                         alt=""
//                                         className="rounded-circle icon-shape icon-xl"
//                                     />
//                                 </div>
//                                 <div className="mt-4">
//                                     {/* content */}
//                                     <h2 className="mb-1 h5">
//                                         <a href="#!" className="text-inherit">
//                                             DealShare Mart
//                                         </a>
//                                     </h2>
//                                     <div className="small text-muted">
//                                         <span className="me-2">Alcohol</span>
//                                         <span className="me-2">Groceries</span>
//                                     </div>
//                                     <div className="py-3">
//                                         <ul className="list-unstyled mb-0 small">
//                                             <li>Delivery</li>
//                                             <li>Pickup available</li>
//                                         </ul>
//                                     </div>
//                                     <div>
//                                         {/* badge */}{" "}
//                                         <div className="badge text-bg-light border">
//                                             7.2 mi away
//                                         </div>
//                                     </div>
//                                 </div>
//                             </div>
//                         </div>
//                         <div className="col">
//                             {/* card */}
//                             <div className="card p-6 card-product">
//                                 <div>
//                                     {" "}
//                                     {/* img */}
//                                     <img
//                                         src="/front/dist/assets/images/stores-logo/stores-logo-3.svg"
//                                         alt=""
//                                         className="rounded-circle icon-shape icon-xl"
//                                     />
//                                 </div>
//                                 <div className="mt-4">
//                                     {/* content */}
//                                     <h2 className="mb-1 h5">
//                                         <a href="#!" className="text-inherit">
//                                             DMart
//                                         </a>
//                                     </h2>
//                                     <div className="small text-muted">
//                                         <span className="me-2">Groceries</span>
//                                         <span className="me-2">Bakery</span>
//                                         <span>Deli</span>
//                                     </div>
//                                     <div className="py-3">
//                                         <ul className="list-unstyled mb-0 small">
//                                             <li>
//                                                 <span className="text-primary">
//                                                     Delivery by 10:30pm
//                                                 </span>
//                                             </li>
//                                             <li>Pickup available</li>
//                                         </ul>
//                                     </div>
//                                     <div>
//                                         {/* badge */}{" "}
//                                         <div className="badge text-bg-light border">
//                                             9.3 mi away
//                                         </div>
//                                     </div>
//                                 </div>
//                             </div>
//                         </div>
//                         <div className="col">
//                             {/* card */}
//                             <div className="card p-6 card-product">
//                                 <div>
//                                     {" "}
//                                     {/* img */}
//                                     <img
//                                         src="/front/dist/assets/images/stores-logo/stores-logo-4.svg"
//                                         alt=""
//                                         className="rounded-circle icon-shape icon-xl"
//                                     />
//                                 </div>
//                                 <div className="mt-4">
//                                     {/* content */}
//                                     <h2 className="mb-1 h5">
//                                         <a href="#!" className="text-inherit">
//                                             Blinkit Store
//                                         </a>
//                                     </h2>
//                                     <div className="small text-muted">
//                                         <span className="me-2">Meal Kits</span>
//                                         <span className="me-2">
//                                             Prepared Meals
//                                         </span>{" "}
//                                         <span>Organic</span>
//                                     </div>
//                                     <div className="py-3">
//                                         <ul className="list-unstyled mb-0 small">
//                                             <li>Delivery</li>
//                                             <li>Pickup available</li>
//                                         </ul>
//                                     </div>
//                                     <div>
//                                         {/* badge */}{" "}
//                                         <div className="badge text-bg-light border">
//                                             40.5 mi away
//                                         </div>
//                                     </div>
//                                 </div>
//                             </div>
//                         </div>
//                         <div className="col">
//                             {/* card */}
//                             <div className="card p-6 card-product">
//                                 <div>
//                                     {" "}
//                                     {/* img */}
//                                     <img
//                                         src="/front/dist/assets/images/stores-logo/stores-logo-5.svg"
//                                         alt=""
//                                         className="rounded-circle icon-shape icon-xl"
//                                     />
//                                 </div>
//                                 <div className="mt-4">
//                                     {/* content */}
//                                     <h2 className="mb-1 h5">
//                                         <a href="#!" className="text-inherit">
//                                             StoreFront Super Market
//                                         </a>
//                                     </h2>
//                                     <div className="small text-muted">
//                                         <span className="me-2">Groceries</span>
//                                         <span className="me-2">Bakery</span>
//                                     </div>
//                                     <div className="py-3">
//                                         <ul className="list-unstyled mb-0 small">
//                                             <li>
//                                                 <span className="text-primary">
//                                                     Delivery by 11:30pm
//                                                 </span>
//                                             </li>
//                                             <li>Pickup available</li>
//                                         </ul>
//                                     </div>
//                                     <div>
//                                         {/* badge */}{" "}
//                                         <div className="badge text-bg-light border">
//                                             28.1 mi away
//                                         </div>
//                                     </div>
//                                 </div>
//                             </div>
//                         </div>
//                         <div className="col">
//                             {/* card */}
//                             <div className="card p-6 card-product">
//                                 <div>
//                                     {" "}
//                                     {/* img */}
//                                     <img
//                                         src="/front/dist/assets/images/stores-logo/stores-logo-6.svg"
//                                         alt=""
//                                         className="rounded-circle icon-shape icon-xl"
//                                     />
//                                 </div>
//                                 <div className="mt-4">
//                                     {/* content */}
//                                     <h2 className="mb-1 h5">
//                                         <a href="#!" className="text-inherit">
//                                             BigBasket
//                                         </a>
//                                     </h2>
//                                     <div className="small text-muted">
//                                         <span className="me-2">Groceries</span>{" "}
//                                         <span className="me-2">Deli</span>
//                                     </div>
//                                     <div className="py-3">
//                                         <ul className="list-unstyled mb-0 small">
//                                             <li>
//                                                 <span className="text-primary">
//                                                     Delivery by 10:30pm
//                                                 </span>
//                                             </li>
//                                             <li>Pickup available</li>
//                                         </ul>
//                                     </div>
//                                     <div>
//                                         {/* badge */}{" "}
//                                         <div className="badge text-bg-light border">
//                                             7.5 mi away
//                                         </div>
//                                     </div>
//                                 </div>
//                             </div>
//                         </div>
//                         <div className="col">
//                             {/* card */}
//                             <div className="card p-6 card-product">
//                                 <div>
//                                     {" "}
//                                     {/* img */}
//                                     <img
//                                         src="/front/dist/assets/images/stores-logo/stores-logo-7.svg"
//                                         alt=""
//                                         className="rounded-circle icon-shape icon-xl"
//                                     />
//                                 </div>
//                                 <div className="mt-4">
//                                     {/* content */}
//                                     <h2 className="mb-1 h5">
//                                         <a href="#!" className="text-inherit">
//                                             Swiggy Instamart
//                                         </a>
//                                     </h2>
//                                     <div className="small text-muted">
//                                         <span className="me-2">Meal Kits</span>
//                                         <span className="me-2">
//                                             Prepared Meals
//                                         </span>{" "}
//                                         <span>Organic</span>
//                                     </div>
//                                     <div className="py-3">
//                                         <ul className="list-unstyled mb-0 small">
//                                             <li>Delivery</li>
//                                             <li>Pickup available</li>
//                                         </ul>
//                                     </div>
//                                     <div>
//                                         {/* badge */}{" "}
//                                         <div className="badge text-bg-light border">
//                                             40.5 mi away
//                                         </div>
//                                     </div>
//                                 </div>
//                             </div>
//                         </div>
//                         <div className="col">
//                             {/* card */}
//                             <div className="card p-6 card-product">
//                                 <div>
//                                     {" "}
//                                     {/* img */}
//                                     <img
//                                         src="/front/dist/assets/images/stores-logo/stores-logo-8.svg"
//                                         alt=""
//                                         className="rounded-circle icon-shape icon-xl"
//                                     />
//                                 </div>
//                                 <div className="mt-4">
//                                     {/* content */}
//                                     <h2 className="mb-1 h5">
//                                         <a href="#!" className="text-inherit">
//                                             Online Grocery Mart
//                                         </a>
//                                     </h2>
//                                     <div className="small text-muted">
//                                         <span className="me-2">Groceries</span>
//                                         <span className="me-2">Bakery</span>
//                                     </div>
//                                     <div className="py-3">
//                                         <ul className="list-unstyled mb-0 small">
//                                             <li>
//                                                 <span className="text-primary">
//                                                     Delivery by 11:30pm
//                                                 </span>
//                                             </li>
//                                             <li>Pickup available</li>
//                                         </ul>
//                                     </div>
//                                     <div>
//                                         {/* badge */}{" "}
//                                         <div className="badge text-bg-light border">
//                                             28.1 mi away
//                                         </div>
//                                     </div>
//                                 </div>
//                             </div>
//                         </div>
//                         <div className="col">
//                             {/* card */}
//                             <div className="card p-6 card-product">
//                                 <div>
//                                     {" "}
//                                     {/* img */}
//                                     <img
//                                         src="/front/dist/assets/images/stores-logo/stores-logo-9.svg"
//                                         alt=""
//                                         className="rounded-circle icon-shape icon-xl"
//                                     />
//                                 </div>
//                                 <div className="mt-4">
//                                     {/* content */}
//                                     <h2 className="mb-1 h5">
//                                         <a href="#!" className="text-inherit">
//                                             Spencers
//                                         </a>
//                                     </h2>
//                                     <div className="small text-muted">
//                                         <span className="me-2">Groceries</span>{" "}
//                                         <span className="me-2">Deli</span>
//                                     </div>
//                                     <div className="py-3">
//                                         <ul className="list-unstyled mb-0 small">
//                                             <li>
//                                                 <span className="text-primary">
//                                                     Delivery by 10:30pm
//                                                 </span>
//                                             </li>
//                                             <li>Pickup available</li>
//                                         </ul>
//                                     </div>
//                                     <div>
//                                         {/* badge */}{" "}
//                                         <div className="badge text-bg-light border">
//                                             7.5 mi away
//                                         </div>
//                                     </div>
//                                 </div>
//                             </div>
//                         </div>
//                         <div className="col">
//                             {/* card */}
//                             <div className="card p-6 card-product">
//                                 <div>
//                                     {" "}
//                                     {/* img */}
//                                     <img
//                                         src="/front/dist/assets/images/stores-logo/stores-logo-2.svg"
//                                         alt=""
//                                         className="rounded-circle icon-shape icon-xl"
//                                     />
//                                 </div>
//                                 <div className="mt-4">
//                                     {/* content */}
//                                     <h2 className="mb-1 h5">
//                                         <a href="#!" className="text-inherit">
//                                             DealShare Mart
//                                         </a>
//                                     </h2>
//                                     <div className="small text-muted">
//                                         <span className="me-2">Alcohol</span>
//                                         <span className="me-2">Groceries</span>
//                                     </div>
//                                     <div className="py-3">
//                                         <ul className="list-unstyled mb-0 small">
//                                             <li>Delivery</li>
//                                             <li>Pickup available</li>
//                                         </ul>
//                                     </div>
//                                     <div>
//                                         {/* badge */}{" "}
//                                         <div className="badge text-bg-light border">
//                                             7.2 mi away
//                                         </div>
//                                     </div>
//                                 </div>
//                             </div>
//                         </div>
//                         <div className="col">
//                             {/* card */}
//                             <div className="card p-6 card-product">
//                                 <div>
//                                     {" "}
//                                     {/* img */}
//                                     <img
//                                         src="/front/dist/assets/images/stores-logo/stores-logo-3.svg"
//                                         alt=""
//                                         className="rounded-circle icon-shape icon-xl"
//                                     />
//                                 </div>
//                                 <div className="mt-4">
//                                     {/* content */}
//                                     <h2 className="mb-1 h5">
//                                         <a href="#!" className="text-inherit">
//                                             DMart
//                                         </a>
//                                     </h2>
//                                     <div className="small text-muted">
//                                         <span className="me-2">Groceries</span>
//                                         <span className="me-2">Bakery</span>
//                                         <span>Deli</span>
//                                     </div>
//                                     <div className="py-3">
//                                         <ul className="list-unstyled mb-0 small">
//                                             <li>
//                                                 <span className="text-primary">
//                                                     Delivery by 10:30pm
//                                                 </span>
//                                             </li>
//                                             <li>Pickup available</li>
//                                         </ul>
//                                     </div>
//                                     <div>
//                                         {/* badge */}{" "}
//                                         <div className="badge text-bg-light border">
//                                             9.3 mi away
//                                         </div>
//                                     </div>
//                                 </div>
//                             </div>
//                         </div>
//                         <div className="col">
//                             {/* card */}
//                             <div className="card p-6 card-product">
//                                 <div>
//                                     {" "}
//                                     {/* img */}
//                                     <img
//                                         src="/front/dist/assets/images/stores-logo/stores-logo-4.svg"
//                                         alt=""
//                                         className="rounded-circle icon-shape icon-xl"
//                                     />
//                                 </div>
//                                 <div className="mt-4">
//                                     {/* content */}
//                                     <h2 className="mb-1 h5">
//                                         <a href="#!" className="text-inherit">
//                                             Blinkit Store
//                                         </a>
//                                     </h2>
//                                     <div className="small text-muted">
//                                         <span className="me-2">Meal Kits</span>
//                                         <span className="me-2">
//                                             Prepared Meals
//                                         </span>{" "}
//                                         <span>Organic</span>
//                                     </div>
//                                     <div className="py-3">
//                                         <ul className="list-unstyled mb-0 small">
//                                             <li>Delivery</li>
//                                             <li>Pickup available</li>
//                                         </ul>
//                                     </div>
//                                     <div>
//                                         {/* badge */}{" "}
//                                         <div className="badge text-bg-light border">
//                                             40.5 mi away
//                                         </div>
//                                     </div>
//                                 </div>
//                             </div>
//                         </div>
//                     </div>
//                 </div>
//             </section>

//             <MainFooter />
//         </>
//     );
// }
// export default Categories;
