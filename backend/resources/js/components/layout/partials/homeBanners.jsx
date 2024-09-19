import React from "react";
import { Link } from "react-router-dom";
import { useNavigate } from "react-router-dom";

function HomeBanners() {
    return (
        <div className="container">
            <div className="row">
                <div className="col-12 col-md-6 mb-3 mb-lg-0">
                    <div>
                        <div
                            className="py-10 px-8 rounded"
                            style={{
                                background:
                                    "url(/front/dist/assets/images/banner/img5.jpg)no-repeat",
                                backgroundSize: "cover",
                                backgroundPosition: "center",
                            }}
                        >
                            <div>
                                <h3 className="fw-bold mb-1 text-white">
                                    Security Fencing
                                </h3>
                                {/* <p className="mb-4">
                                    Get Upto{" "}
                                    <span className="fw-bold">30%</span> Off
                                </p> */}
                                {/* <a href="#!" className="btn btn-dark">
                                    Shop Now
                                </a> */}
                                <Link to={"/products"} className="btn btn-dark">
                                    Shop Now
                                </Link>
                            </div>
                        </div>
                    </div>
                </div>
                <div className="col-12 col-md-6 ">
                    <div>
                        <div
                            className="py-10 px-8 rounded"
                            style={{
                                background:
                                    "url(/front/dist/assets/images/banner/img4.jpg)no-repeat",
                                backgroundSize: "cover",
                                backgroundPosition: "center",
                            }}
                        >
                            <div>
                                <h3 className="fw-bold mb-1 text-white">
                                    Weldmesh
                                </h3>
                                {/* <p className="mb-4">
                                    Get Upto{" "}
                                    <span className="fw-bold">25%</span> Off
                                </p> */}
                                {/* <a href="#!" className="btn btn-dark">
                                    Shop Now
                                </a> */}
                                <Link to={"/products"} className="btn btn-dark">
                                    Shop Now
                                </Link>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    );
}
export default HomeBanners;
