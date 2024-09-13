import React, { useState } from 'react';
import './Highlighter.scss';

import Navbar from '../../components/NavBar/Navbar';
import TextInput from '../../components/TextInput/TextInput';
import TextDisplay from '../../components/Result/Result';
import Analysis from '../../components/Analysis/Analysis';
import { keywordGroups } from '../../data/keywordGroups';

import experience from '../../utils/experience';

const Highlighter = () => {
    const [text, setText] = useState('');
    const [highlightedText, setHighlightedText] = useState('');
    const [stats, setStats] = useState([]);

    const highlightKeywords = (inputText) => {
        console.log(experience(inputText));
        let outputText = inputText;
        let keywordStats = [];

        keywordGroups.forEach(group => {
            group.keywords.forEach(keyword => {
                const regex = new RegExp(`\\b(${keyword})(?:s)?(?![\\w#])[.,]?`, 'gi');
                const matches = inputText.match(regex);
                const count = matches ? matches.length : 0;
                if (count > 0) {
                    keywordStats.push({ keyword, count, color: group.color, category: group.category });
                    outputText = outputText.replace(regex, `<span class="fw-bold" style="color: ${group.color}; border-style: solid; border-color: ${group.color}; border-width: 1px;">$1</span>`);
                }
            });
        });

        // Sort stats in descending order by count
        keywordStats.sort((a, b) => b.count - a.count);
        setHighlightedText(outputText);
        setStats(keywordStats);

        //console.log(keywordStats)
    };

    const clearInput = () => {
        setText('');
        setHighlightedText('');
        setStats([]);
    };


    return (
        <div className='disable-scroll-page'>
            <Navbar />

            <div className='container-fluid'>
                <div className='row py-3'>
                    <div className='col-lg-6'>
                        <div className='mb-3'>
                            <TextInput text={text} setText={setText} triggerHighlight={() => highlightKeywords(text)} />
                        </div>
                        <div className='mb-3'>
                            <TextDisplay highlightedText={highlightedText}  onClearInput={clearInput} />
                        </div>
                    </div>

                    <div className='col-lg-6'>
                        <div className='mb-3'>
                            <Analysis stats={stats} />    
                        </div>
                    </div>

                </div>
            </div>
        </div>
    );
};

export default Highlighter;
