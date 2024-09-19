import React from "react";

const Rating = ({ value, color, onClick }) => {
    value = value == null ? 0 : value;

    const fullStars = parseInt(value);
    const halfStar = value - fullStars >= 0.5 ? true : false;
    const emptyStars = 5 - fullStars - (halfStar ? 1 : 0);

    return (
        <div>
            {[...Array(fullStars)].map((e, i) => (
                <i
                    className="bi bi-star-fill"
                    key={`full-${i}`}
                    style={{ color: color, cursor: "pointer" }}
                    onClick={() => onClick(i + 1)}
                />
            ))}
            {halfStar && (
                <i
                    className="bi bi-star-half"
                    style={{ color: color, cursor: "pointer" }}
                    onClick={() => onClick(fullStars + 0.5)}
                />
            )}
            {emptyStars > 0 &&
                [...Array(emptyStars)].map((e, i) => (
                    <i
                        className="bi bi-star"
                        key={`empty-${i}`}
                        style={{ color: color, cursor: "pointer" }}
                        onClick={() => onClick(fullStars + i + 1)}
                    />
                ))}
        </div>
    );
};

export default Rating;
