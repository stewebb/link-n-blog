import React from 'react';
import './Result.scss'

const TextDisplay = ({ highlightedText, onClearInput }) => {
    return (
        <div className="card">
            <div className='card-header custom-card-header d-flex align-items-center justify-content-between'>
                <h5 className='mb-0'>Results</h5>
                <button className='btn btn-outline-secondary btn-sm' onClick={onClearInput}>Clear</button>
            </div>

            <div className="card-body result-box">
                <div
                    dangerouslySetInnerHTML={{ __html: highlightedText }}
                    style={{ whiteSpace: 'pre-wrap' }}
                />
            </div>
        </div>
    );
};

export default TextDisplay;
