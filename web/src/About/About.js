import './About.scss'

const About = () => {
    return (
        <div className="row py-4">
            <h2 className='fraunces-font fw-bold text-primary mb-3'>About</h2>
            
            <div className="fs-5">
                <p>
                    <span className="fw-bold text-primary">MSH (My Skill Highlighter)</span> is a simple yet powerful React application designed to help job seekers effortlessly extract key skills and keywords from job descriptions.
                </p>
                
                <p>
                    Whether you're tailoring your resume or preparing for an interview, MSH saves time by highlighting the essential skills and qualifications employers are looking for.
                </p>
            </div>
        </div>
    );
}

export default About;