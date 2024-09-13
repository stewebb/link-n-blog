function experience(jobDescription) {
    // Define a regex pattern to find phrases related to years of experience
    //const pattern = /(\d+)\s+years? of experience/gi;
    //const pattern2 = /experiences?\s*[^a-z0-9]*\s*(\d+)\s*years?/gi;

    const pattern = /(\d+)\s+years? of experience|experiences?\s*[^a-z0-9]*\s*(\d+)\s*years?/gi;
  
    // Search for all matches
    let matches = [...jobDescription.matchAll(pattern)];
    
    // Map matches to extract the number of years, if any
    const years = matches.map(match => parseInt(match[1], 10));
  
    // Filter out invalid years if needed
    const validYears = years.filter(year => !isNaN(year));
  
    // Return the minimum or a specific range of years
    if (validYears.length > 0) {
        const minYears = Math.min(...validYears);
        const maxYears = Math.max(...validYears);
        return { minYears, maxYears };
    }

    else {
        return null;
    }
  
    // If no valid years found, return undefined or a default value
    //return undefined;
}
  
// Example usage
//const jobDesc = "Candidates should have at least 5 years of experience in software development.";
//const experienceRequired = extractExperience(jobDesc);
//console.log(experienceRequired);
  
export default experience;