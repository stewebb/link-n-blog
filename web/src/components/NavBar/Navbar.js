import React from 'react';
import { Link, useLocation } from 'react-router-dom';
import logo from '../../assets/images/MSH_Wide.png';
import './Navbar.scss';

// Navbar Component
const Navbar = () => {

    const location = useLocation();
    const currentPath = location.pathname;

    return (
        <nav className="navbar navbar-expand-sm no-padding pt-0 pb-0">
            <div className="container-fluid d-flex align-items-center">

                {/* Logo */}
                <div className="d-flex align-items-center">
                    <img src={logo} style={{ maxHeight: '40px' }} alt="Logo" />
                </div>

                {/* Navbar Toggler */}
                <button
                    className="navbar-toggler ms-auto"
                    type="button"
                    data-bs-toggle="collapse"
                    data-bs-target="#navbarNav"
                    aria-controls="navbarNav"
                    aria-expanded="false"
                    aria-label="Toggle navigation"
                >
                    <span className="navbar-toggler-icon"></span>
                </button>

                {/* Navbar Items */}
                <div className="collapse navbar-collapse" id="navbarNav">
                    <ul className="navbar-nav me-auto">
                        <li className="nav-item">
                            <Link className={`nav-link navbar-border ${currentPath === '/' ? 'active' : ''}`} to="/">Home</Link>
                        </li>
                        <li className="nav-item">
                            <Link className={`nav-link navbar-border ${currentPath === '/highlighter' ? 'active' : ''}`} to="/highlighter">Highlighter</Link>
                        </li>
                        
                    </ul>

                    <ul className="navbar-nav ms-auto">
                        <li className="nav-item">
                            <a className="nav-link navbar-border" href="https://github.com/stewebb/MSH" target="_blank" rel="noopener noreferrer">
                                <i class="fa-brands fa-github"></i>
                            </a>
                        </li>
                    </ul>
                </div>
            </div>
        </nav>
    );
};

export default Navbar;