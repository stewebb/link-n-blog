<img src="./assets/LNB_Wide.png" alt="Link 'n' Blog" style="max-width: 400px;">

**Link 'n' Blog** is a custom WordPress plugin that allows users to create a personalized landing page, with advanced features such as image covers, customizable links, and the ability to bundle external links with internal WordPress pages.

<!--
## Features

- **Customizable Front Page**: Create a front page where you can add multiple links with image covers. Users can also add a customizable hero section in HTML format via the WordPress admin panel.
- **Flexible Links**: Add links to any website, including internal WordPress pages and external sites.
- **External Link Enhancements**: For external links, a "Learn More" button can direct visitors to an internal page for additional content.
- **Image Cover Support**: Each link can have an optional image cover for a more visually engaging experience.
- **Highly Customizable**: Adjust the appearance of your front page with extensive SCSS options to suit your branding needs.
- **Seamless Link Management**: Add, edit, or remove links easily through the WordPress admin panel.
- **Max Privacy**: By default, the theme does not include any commercial tracking. Admins have the option to add ad or tracking links via the WordPress admin panel, but this is fully under their control.

## Prerequisites

- **WordPress** installed and running.
- **Timber Plugin** installed for templating with Twig. You can install it via the WordPress admin panel or by downloading from the [Timber Plugin repository](https://wordpress.org/plugins/timber-library/).
- **Node.js** installed to compile SCSS and JavaScript assets.

## Installation

1. Clone the repository into your local machine:
    ```bash
    git clone https://github.com/stewebb/link-n-blog.git
    ```

2. Copy the theme's files into your WordPress theme folder:
    ```bash
    cp -R link-n-blog wp-content/themes/link-n-blog
    ```

3. Navigate to the theme's `assets` directory:
    ```bash
    cd assets
    ```

4. (Optional) Open `styles/includes/_style.scss` and modify the `$primary` color variable to customize the theme's primary color:
    ```scss
    $primary: #525174; // Change this to your preferred primary color.
    ```

5. Install the required dependencies and build the assets:
    ```bash
    npm install
    npm start
    ```

6. After the build completes, copy the compiled `dist/css` and `dist/js` files to your theme's `assets` folder:
    ```bash
    cp -R dist/css dist/js ../
    ```

7. Activate the theme in the WordPress admin panel under **Appearance > Themes**.

## Usage

1. Go to **Appearance > Customize** to set up your links, blog bundles, and image covers.
2. Add links by specifying whether they are internal (WordPress blog pages) or external.
3. For external links, optionally include a "Learn More" button to direct visitors to a related internal page.
4. Customize the appearance of the front page using SCSS variables.

## Development

This theme is built with WordPress and Timber (Twig) to enable easy templating and customization.

To contribute or make custom changes:

1. Ensure you have Node.js installed for SCSS compilation.
2. Run the following command to watch SCSS files:
    ```bash
    npm run watch
    ```

## License

This project is licensed under the MIT License. See the [LICENSE](LICENSE) file for details.

## Contributing

Contributions are welcome! Please open an issue or submit a pull request if you have improvements or feature requests.

-->