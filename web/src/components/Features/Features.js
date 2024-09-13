import FeatureItem from "../FeatureItem/FeatureItem";

const Features = () => {

    //const rootStyle = getComputedStyle(document.documentElement);
    //const primaryColor = rootStyle.getPropertyValue('--bs-primary').trim();
    
    return (
        <div className="row">

            <h2 className='fraunces-font fw-bold'>Features</h2>

            <FeatureItem 
                feature='Instant Skill Identification' 
                icon='fas fa-search' 
                description='Quickly finds and highlights the key skills needed for job applications from any job description.'
            />

            <FeatureItem 
                feature='Tailored for Tech Jobs'
                icon='fas fa-laptop-code'
                description='Perfect for tech industry job seekers looking to identify relevant IT skills.'
            />

            <FeatureItem 
                feature='Personalize Your Experience'
                icon='fas fa-tools'
                description='Soon you will be able to add your own skills to focus on the roles you want.'
            />

            <FeatureItem 
                feature='Easy to Use'
                icon='fas fa-user-friends'
                description='Simple and intuitive design makes it easy for anyone to start using immediately.'
            />

            <FeatureItem 
                feature='Smooth and Interactive'
                icon='fas fa-arrow-pointer'
                description='Enjoy a seamless and engaging experience as you navigate through the application.'
            />

            <FeatureItem 
                feature='No Downloads Required'
                icon='fas fa-cloud'
                description='Use the application fully online without needing to install anything on your computer.'
            />
        </div>
    )
}

export default Features;