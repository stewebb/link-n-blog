import React from 'react';
import { Link } from 'react-router-dom';

const Hero = ({ logo, title, description, link }) => {
    return (
        <div className='row py-5 bg-white'>
            <div className='text-center mb-3'>
                <img src={logo} style={{maxWidth: '150px'}} />
            </div>

            <div className='text-center mb-1'>
                <h2 className='text-dark fw-bold fraunces-font'>{title}</h2>
            </div>

            <div className='text-center mb-3'>
                <span className='text-secondary fw-bold fs-4 fst-italic'>{description}</span>
            </div>

            <div className='text-center'>
                <Link className='btn btn-outline-primary btn-lg' to={`/${link}`}>Get Started</Link>
            </div>
        </div>
    );
};

export default Hero;