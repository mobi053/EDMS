// import React, { useState } from "react";
// import { Carousel, CarouselItem } from "react-bootstrap";

// const ProductSlider = (props) => {
//     const [currentImage, setCurrentImage] = useState(0);

//     const handleThumbnailClick = (index) => {
//         setCurrentImage(index);
//     };

//     return (
//         <div className="col-md-6">
//             {/* img slide */}
//             <div className="product" id="product">
//                 {props.images[currentImage] && (
//                     <div
//                         className="zoom"
//                         onmousemove="zoom(event)"
//                         style={{
//                             backgroundImage: `url(front/dist/assets/images/products/product-single-img-1.jpg)`,
//                         }}
//                     >
//                         {/* img */}
//                         <img
//                             src="/front/dist/assets/images/products/product-single-img-1.jpg"
//                             alt=""
//                         />
//                     </div>
//                 )}
//             </div>

//             {/* product tools */}
//             <div className="product-tools">
//                 <div className="thumbnails row g-3" id="productThumbnails">
//                     {props.images.map((image, index) => (
//                         <div className="col-3" key={index}>
//                             <div
//                                 className="thumbnails-img"
//                                 onClick={() => handleThumbnailClick(index)}
//                             >
//                                 {/* img */}
//                                 <img
//                                     src={`/storage/images/${image.path}`}
//                                     alt=""
//                                 />
//                             </div>
//                         </div>
//                     ))}
//                 </div>
//             </div>
//         </div>
//     );
// };

// export default ProductSlider;

// import React, { useState } from "react";
// // import { Carousel, CarouselItem } from "react-bootstrap";

// import {
//     Carousel,
//     CarouselItem,
//     CarouselControl,
//     CarouselIndicators,
// } from "react-bootstrap";

// const ProductSlider = ({ images }) => {
//     const [activeIndex, setActiveIndex] = useState(0);
//     const [animating, setAnimating] = useState(false);

//     const items = images.map((image) => {
//         return (
//             <CarouselItem key={image.id}>
//                 <img
//                     src={`/storage/images/${image.path}`}
//                     alt=""
//                     className="d-block w-100"
//                 />
//             </CarouselItem>
//         );
//     });

//     const thumbs = images.map((image, index) => {
//         return (
//             <li
//                 key={image.id}
//                 onClick={() => {
//                     if (!animating) {
//                         setActiveIndex(index);
//                     }
//                 }}
//                 className={activeIndex === index ? "active" : ""}
//             >
//                 <img
//                     src={`/storage/images/${image.path}`}
//                     alt=""
//                     className="d-block w-100"
//                 />
//             </li>
//         );
//     });

//     const next = () => {
//         if (animating) return;
//         const nextIndex =
//             activeIndex === items.length - 1 ? 0 : activeIndex + 1;
//         setActiveIndex(nextIndex);
//     };

//     const previous = () => {
//         if (animating) return;
//         const nextIndex =
//             activeIndex === 0 ? items.length - 1 : activeIndex - 1;
//         setActiveIndex(nextIndex);
//     };

//     const goToIndex = (newIndex) => {
//         if (animating) return;
//         setActiveIndex(newIndex);
//     };

//     const slides = items.length > 1 && (
//         <Carousel
//             activeIndex={activeIndex}
//             next={next}
//             previous={previous}
//             interval={false}
//         >
//             <CarouselIndicators
//                 items={items}
//                 activeIndex={activeIndex}
//                 onClickHandler={goToIndex}
//             />
//             {items}
//             <CarouselControl
//                 direction="prev"
//                 directionText="Previous"
//                 onClickHandler={previous}
//             />
//             <CarouselControl
//                 direction="next"
//                 directionText="Next"
//                 onClickHandler={next}
//             />
//         </Carousel>
//     );

//     const thumbnails = items.length > 1 && (
//         <ul className="thumbnails">{thumbs}</ul>
//     );

//     return (
//         <div className="product-slider">
//             {slides}
//             {thumbnails}
//         </div>
//     );
// };

// export default ProductSlider;
import React, { useState } from "react";
import ImageGallery from "react-image-gallery";
import "react-image-gallery/styles/css/image-gallery.css";

const ProductSlider = ({ images }) => {
    const [selectedIndex, setSelectedIndex] = useState(0);

    const slides = images.map((image) => ({
        original: `/storage/images/${image.path}`,
        thumbnail: `/storage/images/${image.path}`,
    }));

    const handleThumbnailClick = (event, index) => {
        event.preventDefault();
        setSelectedIndex(index);
    };

    return (
        <div className="product-slider">
            <ImageGallery
                items={slides}
                showPlayButton={false}
                showFullscreenButton={false}
                showNav={false}
                showThumbnails={true}
                thumbnailPosition={"bottom"}
                thumbnailHoverSlideDelay={0}
                thumbnailClass={"product-thumbnail"}
                selectedIndex={selectedIndex}
                onThumbnailClick={handleThumbnailClick}
            />
        </div>
    );
};

export default ProductSlider;
