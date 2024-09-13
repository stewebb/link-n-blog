import React, { useState } from 'react';

import './FeatureItem.scss';

// Function to lighten a color by a given percentage
const lightenColor = (color, percent) => {
  const num = parseInt(color.replace("#",""), 16),
        amt = Math.round(2.55 * percent),
        R = (num >> 16) + amt,
        B = (num >> 8 & 0x00FF) + amt,
        G = (num & 0x0000FF) + amt;

  return "#" + (0x1000000 + (R < 255 ? R : 255) * 0x10000 + (B < 255 ? B : 255) * 0x100 + (G < 255 ? G : 255)).toString(16).slice(1);
};

// Function to get text color based on background
const getTextColorBasedOnBackground = (color) => {
  // Dummy function; add actual logic to determine text color based on background
  return color; // Placeholder return
};

function FeatureItem({ feature, icon, description }) {
    const [overlayBgColor, setOverlayBgColor] = useState('');

    //const boxBgColor = lightenColor(bgColor, 40);
    //const btnBgColor = getTextColorBasedOnBackground(boxBgColor);

    
    //console.log("Primary color is:", primaryColor);

    //const handleMouseOver = () => {
    //    setOverlayBgColor(bgColor);
    //};

    return (
        
        <div className="col-lg-4 col-sm-6 menu-col">

            <div className="item">
                <div className='text-center py-5 px-2'>
                    <div className='mb-3 text-primary'>
                        <i className={`${icon} big-icon`}></i>
                    </div>
                    <div className='fs-5 fraunces-font text-secondary'>
                        {feature}
                    </div>
                </div>

                <div className="overlay" 
                    //onMouseOver={handleMouseOver}
                    //onMouseOut={() => setOverlayBgColor('')}
                    //style={{ backgroundColor: overlayBgColor }}
                >

                <div className='mx-2 fw-bold text-secondary'>
                    {description}
                </div>
                    

                    {/*
                    <div className="btn-group" role="group">
                        <button type="button" className={`btn btn-outline-primary`}>
                            Visit
                        </button>

                        <button type="button" className={`btn btn-outline-primary`}>
                            About
                        </button>

                        <button type="button" className={`btn btn-outline-primary`}>
                            Share
                        </button>
                    </div>
                    */}
                </div>
            </div>
        </div>
  );
}

export default FeatureItem;
