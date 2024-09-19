import React from "react";
import NavbarSearch from "../components/layout/partials/navbarSearch";
import MainNavbar from "../components/layout/partials/mainNavbar";
import MainFooter from "../components/layout/partials/mainFooter";
import HomeSignup from "../components/layout/partials/homeSignup";
import HomeShopCart from "../components/layout/partials/homeShopCart";
import VideoPlayer from "../components/shared/videoPlayer";

const videos = [
    {
        title: "How to install Redbrand Barbed Wire",
        videoId: "GvHf2Kiyfb4",
    },
    {
        title: "How to install Redbrand Wire Field Fence",
        videoId: "ysGIoTsmbUI",
    },
    {
        title: "How to install Redbrand Vertical Mesh Wire Fencing",
        videoId: "ShamCUzm1P0",
    },
    {
        title: "Redbrand Capabilities Tour",
        videoId: "DThstj9v0NY",
    },
    {
        title: "Vicebite Ground Support Bracket Video",
        videoId: "xI2Ui_fOrWs",
    },
    {
        title: "Vicebite Angled Stay Assembly Bracket Video",
        videoId: "XqRu0uzwMWI",
    },
    {
        title: "Vicebite Low Backing Post Bracket Video",
        videoId: "FMynbFdK3l4",
    },
    {
        title: "Vicebite Horizontal Bracing Video",
        videoId: "aHDkr8KC7mg",
    },
];

function InstallationGuide() {
    const renderVideoRows = () => {
        const rows = [];
        let row = [];

        for (let i = 0; i < videos.length; i++) {
            row.push(
                <div key={i} className="col-md-4 mb-4">
                    <VideoPlayer videoId={videos[i].videoId} />
                    <div className="mt-2">{videos[i].title}</div>
                </div>
            );

            if (row.length === 3 || i === videos.length - 1) {
                rows.push(
                    <div
                        key={i}
                        className={`row ${rows.length === 0 ? "mt-4" : ""}`}
                    >
                        {row}
                    </div>
                );
                row = [];
            }
        }

        return rows;
    };
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
            <div className="container">{renderVideoRows()}</div>

            <MainFooter />
        </>
    );
}

export default InstallationGuide;
