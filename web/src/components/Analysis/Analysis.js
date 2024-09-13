import React from 'react';
//import experience from '../../utils/experience';

import './Analysis.scss';

const hexToRGBA = (hex, alpha = 1) => {
    const r = parseInt(hex.slice(1, 3), 16);
    const g = parseInt(hex.slice(3, 5), 16);
    const b = parseInt(hex.slice(5, 7), 16);
    return `rgba(${r}, ${g}, ${b}, ${alpha})`;
};

const Analysis = ({ stats }) => {
    // Function to group stats by category
    const groupedStats = stats.reduce((acc, item) => {
        if (!acc[item.category]) {
            acc[item.category] = { items: [], color: item.color }; // Initialize with the first item's color
        }
        acc[item.category].items.push(item);
        return acc;
    }, {});

    return (
        <div className="card">
            <div className='card-header custom-card-header d-flex align-items-center justify-content-between'>
                <h5 className='mb-0'>Analysis</h5>
            </div>
            <div className="card-body statistics-box">
                
                    <div className='row'>
                        {Object.keys(groupedStats).map((category, idx) => (
                            <div key={idx} className='col-xl-3 col-lg-3 col-md-6 col-xs-6 col-sm-6'> {/* Grid columns for layout */}
                                <div className='category-section mb-3' style={{ backgroundColor: hexToRGBA(groupedStats[category].color, 0.1) }}>

                                    {/* Category Name */}
                                    <span className='fw-bold px-2' style={{ color: groupedStats[category].color }}>
                                        {category}
                                    </span>

                                    {/* Keyword List */}
                                    <ul className="list-group px-2 py-1">
                                        {groupedStats[category].items.map((item, index) => (
                                            <li key={index} className="list-group-item">
                                                <span className="keyword">{item.keyword}</span>&nbsp;
                                                <span className="badge rounded-pill" style={{backgroundColor: item.color}}>{item.count}</span>
                                            </li>
                                        ))}
                                    </ul>
                                </div>
                            </div>
                        ))}
                    </div>
                
            </div>
        </div>
    );
};

export default Analysis;
