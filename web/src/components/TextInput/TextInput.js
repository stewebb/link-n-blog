// src/components/TextInput.js
import React from 'react';
import { Link } from 'react-router-dom';

import ReactQuill from 'react-quill';
import 'react-quill/dist/quill.snow.css';
import './TextInput.scss'

const TextInput = ({ text, setText, triggerHighlight }) => {

    
    return (
        <div className="card">
                
            <div className='card-header custom-card-header d-flex align-items-center justify-content-between'>
                <h5 className='mb-0'>Text input</h5>
                <div className="btn-group" role="group"> 
                    <Link className='btn btn-outline-secondary btn-sm' to="/">Set Keywords</Link>
                    <button className='btn btn-outline-primary btn-sm' onClick={triggerHighlight}>Highlight Me!</button>
                </div>
            </div>

            <div className="card-body">
                <ReactQuill
                    value={text}
                    onChange={setText}
                    placeholder="Type or paste text here..."
                    theme="snow"
                    modules={{
                    toolbar: [
                        [{ 'header': [1, 2, false] }],
                        ['bold', 'italic', 'underline', 'strike', 'blockquote'],
                        [{ 'list': 'ordered'}, { 'list': 'bullet' }],
                        ['clean']
                    ]
                    }}
                />
                 
                
                {/*
                <div className='d-flex justify-content-center'>
                    <button onClick={triggerHighlight} className='btn btn-outline-primary'>Highlight Me!</button>
                </div>
                */}
                
            </div>
        </div>
    );
};

export default TextInput;
