#!/bin/bash

# Variables
THEME_PATH="wordpress/wp-content/themes/msx-wp-theme/"
SOURCE_PATH="msx-wp-theme/"

# Compile SCSS
cd msx-wp-theme
npm install
npm run build-css
cd ..

# Copy theme files
sudo rm -rf "$THEME_PATH"
sudo mkdir -p "$THEME_PATH"

sudo cp -r  "${SOURCE_PATH}includes"        "$THEME_PATH"
sudo cp     "${SOURCE_PATH}index.php"       "$THEME_PATH"
sudo cp     "${SOURCE_PATH}functions.php"   "$THEME_PATH"
sudo cp     "${SOURCE_PATH}style.css"       "$THEME_PATH"
sudo cp     "${SOURCE_PATH}style.css.map"   "$THEME_PATH"