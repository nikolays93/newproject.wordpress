"use strict";

import { src, dest, watch, parallel, series } from "gulp";
import gulpif from "gulp-if";
import browsersync from "browser-sync";
import autoprefixer from "gulp-autoprefixer";
import uglify from "gulp-uglify";
import sass from "gulp-sass";
import groupmediaqueries from "gulp-group-css-media-queries";
import mincss from "gulp-clean-css";
import sourcemaps from "gulp-sourcemaps";
import rename from "gulp-rename";
import favicons from "gulp-favicons";
import svgSprite from "gulp-svg-sprite";
import replace from "gulp-replace";
import rigger from "gulp-rigger";
import plumber from "gulp-plumber";
import debug from "gulp-debug";
import clean from "gulp-clean";
import yargs from "yargs";
import smartgrid from "smart-grid";

global.dir += 'wp-content/themes/project/';

/**
 * Variables
 */
global.raw    = '_source/';

global.assets = dir + 'assets/';
global.scss   = dir + 'styles/';
global.js     = dir + 'assets/';
global.img    = dir + 'img/';

global.paths.bootstrap = {
    style:  scss + 'module/bootstrap.scss',
    script: js + raw + 'bootstrap.js',
    opts:   scss + '_site-settings.scss',
};

global.paths.build = {
    // clean: ["./dist/*", "./dist/.*"],
    general:  dir,
    styles:   dir,
    scripts:  js,
    favicons: dir + "img/favicons/",
    images:   img,
    sprites:  dir + "img/sprites/",
};

global.paths.src = {
    html: [
        dir + '**/index.tpl',
        '!' + dir + 'inc/**/*.tpl'
    ],
    styles: [
        dir + '**/*.scss',
        '!' + scss + '**/*'
    ],
    scripts: js + raw + 'main.js',

    sprites: img + raw + 'icons/**/*.svg',
    favicons: img + raw + 'icons/favicon.{jpg,jpeg,png,gif}',
    images: [
        img + raw + '**/*.{jpg,jpeg,png,gif,svg}'
    ],
}

global.paths.watch = {
    html: [
        dir + '**/index.tpl',
        dir + 'inc/**/*.tpl'
    ],
    styles: [
        dir + '*.scss',
        scss + '**/*.scss'
    ],
    scripts: [
        js + raw + '**/*.js',
        js + raw + 'inc/**/*.js',
    ]
}

/**
 * Prepare patchs
 */
global.paths.src.html.push(  '!' + assets + '**/*');
global.paths.src.styles.push('!' + assets + '**/*');

global.paths.src.images.push('!' + paths.src.sprites);
global.paths.src.images.push('!' + paths.src.favicons);

if( global.paths.bootstrap ) {
    global.paths.src.styles.push('!' + paths.bootstrap.style);

    global.paths.watch.styles.push('!' + paths.bootstrap.style);
    global.paths.watch.scripts.push('!' + paths.bootstrap.script)
}

/**
 * Methods
 */
export const bootstrapStyle = () => src(paths.bootstrap.style)
    .pipe(plumber())
    .pipe(gulpif(!production, sourcemaps.init()))
    .pipe(sass())
    .pipe(groupmediaqueries())
    .pipe(gulpif(production, autoprefixer({
        browsers: ["last 12 versions", "> 1%", "ie 8", "ie 7"]
    })))
    .pipe(gulpif(production, mincss({
        compatibility: "ie8", level: {
            1: {
                specialComments: 0,
                removeEmpty: true,
                removeWhitespace: true
            },
            2: {
                mergeMedia: true,
                removeEmpty: true,
                removeDuplicateFontRules: true,
                removeDuplicateMediaBlocks: true,
                removeDuplicateRules: true,
                removeUnusedAtRules: false
            }
        }
    })))
    .pipe(gulpif(production, rename({
        suffix: ".min"
    })))
    .pipe(plumber.stop())
    .pipe(gulpif(!production, sourcemaps.write("./maps/")))
    .pipe(dest(assets))
    .pipe(debug({
        "title": "Boostrap CSS files"
    }))
    .on("end", () => browsersync.reload);

export const bootstrapScript = () => src(paths.bootstrap.script)
    .pipe(plumber())
    .pipe(rigger())
    .pipe(gulpif(!production, sourcemaps.init()))
    .pipe(gulpif(production, uglify()))
    .pipe(gulpif(production, rename({
        suffix: ".min"
    })))
    .pipe(gulpif(!production, sourcemaps.write("./maps/")))
    .pipe(dest(assets))
    .pipe(debug({
        "title": "JS files"
    }))
    .on("end", browsersync.reload);

export const smartGrid = cb => {
    smartgrid(scss + 'utils', {
        outputStyle: "scss",
        filename: "_smart-grid",
        columns: 12, // number of grid columns
        offset: "30px", // gutter width
        mobileFirst: true,
        container: {
            fields: "15px"
        },
        breakPoints: {
            xs: {
                width: "320px"
            },
            sm: {
                width: "576px"
            },
            md: {
                width: "768px"
            },
            lg: {
                width: "992px"
            },
            xl: {
                width: "1200px"
            }
        }
    });
    cb();
};

/**
 * Assets
 */
export const bsStyle = () => src('./node_modules/bootstrap/scss/**/*')
    .pipe(dest(scss + 'module/bootstrap/'));

export const bsScript = () => src('./node_modules/bootstrap/js/dist/**/*')
    .pipe(dest(assets + 'bootstrap/'));

export const popper = () => src('./node_modules/popper.js/dist/umd/**/*')
    .pipe(dest(assets + 'popper.js/'));

export const fancybox = () => src('./node_modules/@fancyapps/fancybox/dist/**/*')
    .pipe(dest(assets + 'fancybox/'));

export const hamburgers = () => src('./node_modules/hamburgers/_sass/hamburgers/**/*')
    .pipe(dest(scss + 'module/hamburgers/'));

export const jquery = () => src('./node_modules/jquery/dist/**/*')
    .pipe(dest(assets + 'jquery/'));

export const slick = () => src('./node_modules/slick-carousel/slick/**/*')
    .pipe(dest(assets + 'slick/'));


export const additionalAssetsTasks = parallel(
    bsStyle,
    bsScript,
    popper,
    fancybox,
    hamburgers,
    jquery,
    slick
);

export const additionalTasks = parallel(
    smartGrid,
    bootstrapStyle,
    bootstrapScript
);

export const additionalWatch = () => {
    watch([paths.bootstrap.style, paths.bootstrap.opts], bootstrapStyle);
    watch(paths.bootstrap.script, bootstrapScript);
};