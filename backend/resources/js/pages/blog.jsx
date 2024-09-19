// import React from "react";
// import NavbarSearch from "../components/layout/partials/navbarSearch";
// import MainNavbar from "../components/layout/partials/mainNavbar";
// import MainFooter from "../components/layout/partials/mainFooter";
// import HomeSignup from "../components/layout/partials/homeSignup";
// import HomeShopCart from "../components/layout/partials/homeShopCart";

// function Blog() {
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

//             <>
//                 <div className="mt-4">
//                     <div className="container">
//                         <div className="row ">
//                             <div className="col-12">
//                                 {/* breadcrumb */}
//                                 <nav aria-label="breadcrumb">
//                                     <ol className="breadcrumb mb-0">
//                                         <li className="breadcrumb-item">
//                                             <a href="#!">Home</a>
//                                         </li>
//                                         <li className="breadcrumb-item">
//                                             <a href="#!">Blog</a>
//                                         </li>
//                                         <li
//                                             className="breadcrumb-item active"
//                                             aria-current="page"
//                                         >
//                                             Freshcart Blog
//                                         </li>
//                                     </ol>
//                                 </nav>
//                             </div>
//                         </div>
//                     </div>
//                 </div>
//                 {/* section */}
//                 <section className="mt-8">
//                     <div className="container">
//                         <div className="row">
//                             {/* logo */}
//                             <div className="col-12">
//                                 <h1 className="fw-bold">FreshCart Blog</h1>
//                             </div>
//                         </div>
//                     </div>
//                 </section>
//                 {/* section */}
//                 <section className="mt-6 mb-lg-14 mb-8">
//                     {/* container */}
//                     <div className="container">
//                         <div className="row d-flex align-items-center mb-8">
//                             <div className="col-12 col-md-12 col-lg-8">
//                                 <a href="#!">
//                                     {/* img */}
//                                     <div className="img-zoom">
//                                         <img
//                                             src="/front/dist/assets/images/blog/blog-large.jpg"
//                                             alt=""
//                                             className="img-fluid w-100"
//                                         />
//                                     </div>
//                                 </a>
//                             </div>
//                             {/* text */}
//                             <div className="col-12 col-md-12 col-lg-4">
//                                 <div className="ps-lg-8 mt-8 mt-lg-0">
//                                     <h2 className="mb-3">
//                                         <a href="#!" className="text-inherit">
//                                             Garlic Cream Bucatini with Peas and
//                                             Asparagus
//                                         </a>
//                                     </h2>
//                                     <p>
//                                         Lorem ipsum dolor sit amet, consectetur
//                                         adipiscing elit. Nunc ac erat ut neque
//                                         bibendum egestas sed quis justo. Integer
//                                         non rhoncus diam. Nullam eget dapibus
//                                         lectus, vitae condimentum sem.
//                                     </p>
//                                     <div className="d-flex justify-content-between text-muted">
//                                         <span>
//                                             <small>25 April 2023</small>
//                                         </span>
//                                         <span>
//                                             <small>
//                                                 Read time:{" "}
//                                                 <span className="text-dark fw-bold">
//                                                     6min
//                                                 </span>
//                                             </small>
//                                         </span>
//                                     </div>
//                                 </div>
//                             </div>
//                         </div>
//                         {/* row */}
//                         <div className="row">
//                             <div className="col-12 col-md-6 col-lg-4 mb-8">
//                                 <div className="mb-4">
//                                     <a href="#!">
//                                         {/* img */}
//                                         <div className="img-zoom">
//                                             <img
//                                                 src="/front/dist/assets/images/blog/blog-img-1.jpg"
//                                                 alt=""
//                                                 className="img-fluid w-100"
//                                             />
//                                         </div>
//                                     </a>
//                                 </div>
//                                 {/* text */}
//                                 <div className="mb-3">
//                                     <a href="#!">Recipes</a>
//                                 </div>
//                                 {/* text */}
//                                 <div>
//                                     <h2 className="h5">
//                                         <a href="#!" className="text-inherit">
//                                             Harissa Chickpeas with Whipped Feta
//                                         </a>
//                                     </h2>
//                                     <p>
//                                         In et eros dapibus, facilisis ipsum sit
//                                         amet, tempor dolor. Donec sed nisi
//                                         gravida, molestie dolor molestie, congue
//                                         sapien.
//                                     </p>
//                                     <div className="d-flex justify-content-between text-muted mt-4">
//                                         <span>
//                                             <small>22 April 2023</small>
//                                         </span>
//                                         <span>
//                                             <small>
//                                                 Read time:{" "}
//                                                 <span className="text-dark fw-bold">
//                                                     12min
//                                                 </span>
//                                             </small>
//                                         </span>
//                                     </div>
//                                 </div>
//                             </div>
//                             <div className="col-12 col-md-6 col-lg-4 mb-8">
//                                 <div className="mb-4">
//                                     <a href="#!">
//                                         {/* img */}
//                                         <div className="img-zoom">
//                                             <img
//                                                 src="/front/dist/assets/images/blog/blog-img-2.jpg"
//                                                 alt=""
//                                                 className="img-fluid w-100"
//                                             />
//                                         </div>
//                                     </a>
//                                 </div>
//                                 {/* text */}
//                                 <div className="mb-3">
//                                     <a href="#!">Recipes</a>
//                                 </div>
//                                 {/* text */}
//                                 <div>
//                                     <h2 className="h5">
//                                         <a href="#!" className="text-inherit">
//                                             Almond Butter Chocolate Chip
//                                             Zucchini Bars
//                                         </a>
//                                     </h2>
//                                     <p>
//                                         Lorem ipsum dolor sit amet, consectetur
//                                         adipiscing elitaenean sit amet tincidunt
//                                         ellentesque aliquet ligula in ultrices
//                                         congue.
//                                     </p>
//                                     <div className="d-flex justify-content-between text-muted mt-4">
//                                         <span>
//                                             <small>20 April 2023</small>
//                                         </span>
//                                         <span>
//                                             <small>
//                                                 Read time:{" "}
//                                                 <span className="text-dark fw-bold">
//                                                     8min
//                                                 </span>
//                                             </small>
//                                         </span>
//                                     </div>
//                                 </div>
//                             </div>
//                             <div className="col-12 col-md-6 col-lg-4 mb-8">
//                                 <div className="mb-4">
//                                     <a href="#!">
//                                         {/* img */}
//                                         <div className="img-zoom">
//                                             <img
//                                                 src="/front/dist/assets/images/blog/blog-img-1.jpg"
//                                                 alt=""
//                                                 className="img-fluid w-100"
//                                             />
//                                         </div>
//                                     </a>
//                                 </div>
//                                 {/* text */}
//                                 <div className="mb-3">
//                                     <a href="#!">Company</a>
//                                 </div>
//                                 <div>
//                                     {/* text */}
//                                     <h2 className="h5">
//                                         <a href="#!" className="text-inherit">
//                                             Spicy Shrimp Tacos Garlic Cilantro
//                                             Lime Slaw
//                                         </a>
//                                     </h2>
//                                     <p>
//                                         Lorem ipsum dolor sit amet, consectetur
//                                         adipiscing elitaenean sit amet tincidunt
//                                         ellentesque aliquet ligula in ultrices
//                                         congue.
//                                     </p>
//                                     <div className="d-flex justify-content-between text-muted mt-4">
//                                         <span>
//                                             <small>18 April 2023</small>
//                                         </span>
//                                         <span>
//                                             <small>
//                                                 Read time:{" "}
//                                                 <span className="text-dark fw-bold">
//                                                     5min
//                                                 </span>
//                                             </small>
//                                         </span>
//                                     </div>
//                                 </div>
//                             </div>
//                             <div className="col-12 col-md-6 col-lg-4 mb-8">
//                                 <div className="mb-4">
//                                     <a href="#!">
//                                         {/* img */}
//                                         <div className="img-zoom">
//                                             <img
//                                                 src="/front/dist/assets/images/blog/blog-img-4.jpg"
//                                                 alt=""
//                                                 className="img-fluid w-100"
//                                             />
//                                         </div>
//                                     </a>
//                                 </div>
//                                 {/* text */}
//                                 <div className="mb-3">
//                                     <a href="#!">Recipes</a>
//                                 </div>
//                                 <div>
//                                     {/* text */}
//                                     <h2 className="h5">
//                                         <a href="#!" className="text-inherit">
//                                             Red Chile Chicken Tacos with Creamy
//                                             Corn
//                                         </a>
//                                     </h2>
//                                     <p>
//                                         Lorem ipsum dolor sit amet, consectetur
//                                         adipiscing elitaenean sit amet tincidunt
//                                         ellentesque aliquet ligula in ultrices
//                                         congue.
//                                     </p>
//                                     <div className="d-flex justify-content-between text-muted mt-4">
//                                         <span>
//                                             <small>16 April 2023</small>
//                                         </span>
//                                         <span>
//                                             <small>
//                                                 Read time:{" "}
//                                                 <span className="text-dark fw-bold">
//                                                     9min
//                                                 </span>
//                                             </small>
//                                         </span>
//                                     </div>
//                                 </div>
//                             </div>
//                             <div className="col-12 col-md-6 col-lg-4 mb-8">
//                                 <div className="mb-4">
//                                     <a href="#!">
//                                         {/* img */}
//                                         <div className="img-zoom">
//                                             <img
//                                                 src="/front/dist/assets/images/blog/blog-img-5.jpg"
//                                                 alt=""
//                                                 className="img-fluid w-100"
//                                             />
//                                         </div>
//                                     </a>
//                                 </div>
//                                 <div className="mb-3">
//                                     <a href="#!">Retailer</a>
//                                 </div>
//                                 <div>
//                                     {/* text */}
//                                     <h2 className="h5">
//                                         <a href="#!" className="text-inherit">
//                                             Basic + Awesome Broccoli Cheese Soup
//                                         </a>
//                                     </h2>
//                                     <p>
//                                         Lorem ipsum dolor sit amet, consectetur
//                                         adipiscing elitaenean sit amet tincidunt
//                                         ellentesque aliquet ligula in ultrices
//                                         congue.
//                                     </p>
//                                     <div className="d-flex justify-content-between text-muted mt-4">
//                                         <span>
//                                             <small>12 April 2023</small>
//                                         </span>
//                                         <span>
//                                             <small>
//                                                 Read time:{" "}
//                                                 <span className="text-dark fw-bold">
//                                                     12min
//                                                 </span>
//                                             </small>
//                                         </span>
//                                     </div>
//                                 </div>
//                             </div>
//                             <div className="col-12 col-md-6 col-lg-4 mb-8">
//                                 <div className="mb-4">
//                                     <a href="#!">
//                                         {/* img */}
//                                         <div className="img-zoom">
//                                             <img
//                                                 src="/front/dist/assets/images/blog/blog-img-6.jpg"
//                                                 alt=""
//                                                 className="img-fluid w-100"
//                                             />
//                                         </div>
//                                     </a>
//                                 </div>
//                                 {/* text */}
//                                 <div className="mb-3">
//                                     <a href="#!">Recipes</a>
//                                 </div>
//                                 <div>
//                                     {/* text */}
//                                     <h2 className="h5">
//                                         <a href="#!" className="text-inherit">
//                                             No-Boil Baked Penne with Meatballs{" "}
//                                         </a>
//                                     </h2>
//                                     <p>
//                                         Nulla consectetur sapien a libero
//                                         imperdiet posuere. Donec sollicitudin,
//                                         turpis sit amet sollicitudin tristique,
//                                         metus eros euismod tortor
//                                     </p>
//                                     <div className="d-flex justify-content-between text-muted mt-4">
//                                         <span>
//                                             <small>14 April 2023</small>
//                                         </span>
//                                         <span>
//                                             <small>
//                                                 Read time:{" "}
//                                                 <span className="text-dark fw-bold">
//                                                     6min
//                                                 </span>
//                                             </small>
//                                         </span>
//                                     </div>
//                                 </div>
//                             </div>
//                             <div className="col-12 col-md-6 col-lg-4 mb-8">
//                                 <div className="mb-4">
//                                     <a href="#!">
//                                         {/* img */}
//                                         <div className="img-zoom">
//                                             <img
//                                                 src="/front/dist/assets/images/blog/blog-img-7.jpg"
//                                                 alt=""
//                                                 className="img-fluid w-100"
//                                             />
//                                         </div>
//                                     </a>
//                                 </div>
//                                 {/* text */}
//                                 <div className="mb-3">
//                                     <a href="#!">Recipes</a>
//                                 </div>
//                                 <div>
//                                     {/* text */}
//                                     <h2 className="h5">
//                                         <a href="#!" className="text-inherit">
//                                             Red Chile Chicken Tacos with Creamy
//                                             Corn
//                                         </a>
//                                     </h2>
//                                     <p>
//                                         Lorem ipsum dolor sit amet, consectetur
//                                         adipiscing elitaenean sit amet tincidunt
//                                         ellentesque aliquet ligula in ultrices
//                                         congue.
//                                     </p>
//                                     <div className="d-flex justify-content-between text-muted mt-4">
//                                         <span>
//                                             <small>16 April 2023</small>
//                                         </span>
//                                         <span>
//                                             <small>
//                                                 Read time:{" "}
//                                                 <span className="text-dark fw-bold">
//                                                     9min
//                                                 </span>
//                                             </small>
//                                         </span>
//                                     </div>
//                                 </div>
//                             </div>
//                             <div className="col-12 col-md-6 col-lg-4 mb-8">
//                                 <div className="mb-4">
//                                     <a href="#!">
//                                         {/* img */}
//                                         <div className="img-zoom">
//                                             <img
//                                                 src="/front/dist/assets/images/blog/blog-img-8.jpg"
//                                                 alt=""
//                                                 className="img-fluid w-100"
//                                             />
//                                         </div>
//                                     </a>
//                                 </div>
//                                 {/* text */}
//                                 <div className="mb-3">
//                                     <a href="#!">Retailer</a>
//                                 </div>
//                                 <div>
//                                     {/* text */}
//                                     <h2 className="h5">
//                                         <a href="#!" className="text-inherit">
//                                             Basic + Awesome Broccoli Cheese Soup
//                                         </a>
//                                     </h2>
//                                     <p>
//                                         Lorem ipsum dolor sit amet, consectetur
//                                         adipiscing elitaenean sit amet tincidunt
//                                         ellentesque aliquet ligula in ultrices
//                                         congue.
//                                     </p>
//                                     <div className="d-flex justify-content-between text-muted mt-4">
//                                         <span>
//                                             <small>12 April 2023</small>
//                                         </span>
//                                         <span>
//                                             <small>
//                                                 Read time:{" "}
//                                                 <span className="text-dark fw-bold">
//                                                     12min
//                                                 </span>
//                                             </small>
//                                         </span>
//                                     </div>
//                                 </div>
//                             </div>
//                             <div className="col-12 col-md-6 col-lg-4 mb-8">
//                                 <div className="mb-4">
//                                     <a href="#!">
//                                         {/* img */}
//                                         <div className="img-zoom">
//                                             <img
//                                                 src="/front/dist/assets/images/blog/blog-img-9.jpg"
//                                                 alt=""
//                                                 className="img-fluid w-100"
//                                             />
//                                         </div>
//                                     </a>
//                                 </div>
//                                 <div className="mb-3">
//                                     <a href="#!">Recipes</a>
//                                 </div>
//                                 <div>
//                                     {/* text */}
//                                     <h2 className="h5">
//                                         <a href="#!" className="text-inherit">
//                                             No-Boil Baked Penne with Meatballs{" "}
//                                         </a>
//                                     </h2>
//                                     <p>
//                                         Nulla consectetur sapien a libero
//                                         imperdiet posuere. Donec sollicitudin,
//                                         turpis sit amet sollicitudin tristique,
//                                         metus eros euismod tortor
//                                     </p>
//                                     <div className="d-flex justify-content-between text-muted mt-4">
//                                         <span>
//                                             <small>14 April 2023</small>
//                                         </span>
//                                         <span>
//                                             <small>
//                                                 Read time:{" "}
//                                                 <span className="text-dark fw-bold">
//                                                     6min
//                                                 </span>
//                                             </small>
//                                         </span>
//                                     </div>
//                                 </div>
//                             </div>
//                             <div className="col-12">
//                                 <nav>
//                                     {/* pagination */}
//                                     <ul className="pagination">
//                                         <li className="page-item disabled">
//                                             <a
//                                                 className="page-link  mx-1 "
//                                                 href="#"
//                                                 aria-label="Previous"
//                                             >
//                                                 <i className="feather-icon icon-chevron-left" />
//                                             </a>
//                                         </li>
//                                         <li className="page-item ">
//                                             <a
//                                                 className="page-link  mx-1 active"
//                                                 href="#"
//                                             >
//                                                 1
//                                             </a>
//                                         </li>
//                                         <li className="page-item">
//                                             <a
//                                                 className="page-link mx-1 text-body"
//                                                 href="#"
//                                             >
//                                                 2
//                                             </a>
//                                         </li>
//                                         <li className="page-item">
//                                             <a
//                                                 className="page-link mx-1 text-body"
//                                                 href="#"
//                                             >
//                                                 ...
//                                             </a>
//                                         </li>
//                                         <li className="page-item">
//                                             <a
//                                                 className="page-link mx-1 text-body"
//                                                 href="#"
//                                             >
//                                                 12
//                                             </a>
//                                         </li>
//                                         <li className="page-item">
//                                             <a
//                                                 className="page-link mx-1 text-body"
//                                                 href="#"
//                                                 aria-label="Next"
//                                             >
//                                                 <i className="feather-icon icon-chevron-right" />
//                                             </a>
//                                         </li>
//                                     </ul>
//                                 </nav>
//                             </div>
//                         </div>
//                     </div>
//                 </section>
//             </>

//             <MainFooter />
//         </>
//     );
// }
// export default Blog;
