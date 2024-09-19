import React from "react";

const VideoPlayer = ({ videoId }) => {
    return (
        <div className="embed-responsive embed-responsive-16by9">
            <iframe
                title="YouTube Video Player"
                className="embed-responsive-item"
                src={`https://www.youtube.com/embed/${videoId}`}
                allowFullScreen
            ></iframe>
        </div>
    );
};

export default VideoPlayer;
