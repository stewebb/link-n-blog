cd msx-wp-theme
npm install
npm run build-css
cd ..

#sudo rsync -av --exclude='node_modules' msx-wp-theme/ wordpress/wp-content/themes/


sudo rm -rf wordpress/wp-content/themes/msx-wp-theme/
sudo mkdir wordpress/wp-content/themes/msx-wp-theme/
sudo cp -r msx-wp-theme/includes wordpress/wp-content/themes/msx-wp-theme/
sudo cp msx-wp-theme/index.php wordpress/wp-content/themes/msx-wp-theme/
sudo cp -r msx-wp-theme/functions.php wordpress/wp-content/themes/msx-wp-theme/
sudo cp -r msx-wp-theme/style.css wordpress/wp-content/themes/msx-wp-theme/