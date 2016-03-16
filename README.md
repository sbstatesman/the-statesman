# The Statesman
A WordPress theme for The Statesman — Stony Brook University's campus newspaper.

## Getting Started
1. Make sure you have Node.js installed. Install [Gulp](https://www.npmjs.com/package/gulp) globally using `npm install --global gulp-cli`.

2. After [installing WordPress](http://codex.wordpress.org/Installing_WordPress), download the theme to `wp-content/themes`.

3. Run `npm install` in the project root to download dependancies. Remember to run `gulp` after making any changes.

4. In the WordPress dashboard under "tools", use the [import](http://codex.wordpress.org/Importing_Content) plugin to upload the xml file in the `assets` directory. This file contains sample posts from www.sbstatesman.com with the categories and tags used by the theme.

5. Since no featured images are included in the xml file, you can [install](http://codex.wordpress.org/Managing_Plugins#Installing_Plugins) the [Quick Featured Images](https://wordpress.org/plugins/quick-featured-images/) plugin to set a placeholder. The `assets/default-feature-image.png` file works well for this.

6. The theme links to two pages: "About" and "Police Blotter." You will need to [create](https://codex.wordpress.org/Pages#Creating_Pages) these pages manually for the links to work.

## Theme Development
Read the WordPress [Theme Developer Handbook](https://developer.wordpress.org/themes/getting-started/) to learn more about how the theme works and how to add to it. Official development work is done by the [Statesman Web & Graphics Section](https://www.facebook.com/groups/statesmanweb/).