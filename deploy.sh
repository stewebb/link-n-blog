#!/bin/bash

# Source folders
SRC_THEME_DIR="theme/"
SRC_STYLE_DIR="styles/"

# Destination folders
THEME_NAME="link-n-blog"
DIST_THEME_ROOT="/home/vboxuser/MSX/wordpress/wp-content/themes/"
DIST_THEME_DIR="${DIST_THEME_ROOT}${THEME_NAME}/"

# Step 2: compile SCSS
cd "$SRC_STYLE_DIR" || exit
npm install
npm start
cd ..

# Step 3: copy theme files
sudo rm -rf "$DIST_THEME_DIR"
sudo mkdir -p "$DIST_THEME_DIR"

sudo cp -r "$SRC_THEME_DIR." "$DIST_THEME_DIR"
sudo cp -r "$SRC_STYLE_DIR/dist/lnb.min.css" "$DIST_THEME_DIR/style.css"