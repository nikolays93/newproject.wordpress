import { src, dest, watch, parallel, series } from "gulp";
import gulpif from "gulp-if";
import browsersync from "browser-sync";
import autoprefixer from "gulp-autoprefixer";
import babel from "gulp-babel";
import browserify from "browserify";
import watchify from "watchify";
import source from "vinyl-source-stream";
import buffer from "vinyl-buffer";
import uglify from "gulp-uglify";
import sass from "gulp-sass";
import mincss from "gulp-clean-css";
import sourcemaps from "gulp-sourcemaps";
import rename from "gulp-rename";
import imagemin from "gulp-imagemin";
import imageminPngquant from "imagemin-pngquant";
import imageminZopfli from "imagemin-zopfli";
import imageminMozjpeg from "imagemin-mozjpeg";
import imageminGiflossy from "imagemin-giflossy";
import favicons from "gulp-favicons";
import svgSprite from "gulp-svg-sprite";
import replace from "gulp-replace";
import rigger from "gulp-rigger";
import plumber from "gulp-plumber";
import debug from "gulp-debug";
import clean from "gulp-clean";
import yargs from "yargs";

global.dir += 'wp-content/themes/project/';

export const getPaths = () => {
    const assets = dir + 'assets/';
    const scss   = dir + 'styles/';
    const js     = dir + 'assets/';
    const img    = dir + 'img/';

    /** Need global */
    $.assets = assets;

    // @todo
    // const fonts  = dir + 'assets/fonts/';
    const raw = '_source/';

    let paths = {};

    paths.bootstrap = {
        style:  scss + 'bootstrap.scss',
        script: js + raw + 'bootstrap.js',
        opts:   scss + '_site-settings.scss',
    }

    paths.build = {
        // clean: ["./dist/*", "./dist/.*"],
        general:  dir,
        styles:   dir,
        scripts:  js,
        favicons: dir + "img/favicons/",
        images:   img,
        sprites:  dir + "img/sprites/",
    }

    paths.src = {
        html: [
            dir + 'index.tpl'
        ],
        styles: [
            dir + '**/*.scss',
            '!' + assets + '**/*',
            '!' + scss + '**/*'
        ],
        scripts: js + raw + 'main.js',
        favicons: img + raw + 'icons/favicon.{jpg,jpeg,png,gif}',
        images: [
            img + raw + '**/*.{jpg,jpeg,png,gif,svg}',
            '!' + img + raw + 'icons/svg/*',
            '!' + img + raw + 'icons/favicon.{jpg,jpeg,png,gif}'
        ],
        sprites: img + raw + 'icons/svg/*',
        server_config: dir + ".htaccess"
    }

    paths.watch = {
        html: [
            dir + 'index.tpl'
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

    if( paths.bootstrap ) {
        paths.src.styles.push('!' + paths.bootstrap.style);

        paths.watch.styles.push('!' + paths.bootstrap.style);
        paths.watch.scripts.push('!' + paths.bootstrap.script);
    }

    return paths;
};
const paths = getPaths();

export const bootstrapStyle = () => src(paths.bootstrap.style)
    .pipe(plumber())
    .pipe(sourcemaps.init())
    .pipe(sass())
    // .pipe(gulpif(production, autoprefixer({
    //     browsers: ["last 12 versions", "> 1%", "ie 8", "ie 7"]
    // })))
    // .pipe(gulpif(!production, browsersync.stream()))
    // .pipe(gulpif(production, mincss({
    //     compatibility: "ie8", level: {
    //         1: {
    //             specialComments: 0,
    //             removeEmpty: true,
    //             removeWhitespace: true
    //         },
    //         2: {
    //             mergeMedia: true,
    //             removeEmpty: true,
    //             removeDuplicateFontRules: true,
    //             removeDuplicateMediaBlocks: true,
    //             removeDuplicateRules: true,
    //             removeUnusedAtRules: false
    //         }
    //     }
    // })))
    // .pipe(gulpif(production, rename({
    //     suffix: ".min"
    // })))
    .pipe(plumber.stop())
    // .pipe(gulpif(!production, sourcemaps.write("./maps/")))
    .pipe(dest($.assets))
    .pipe(debug({
        "title": "Boostrap CSS files"
    }))
    .on("end", () => browsersync.reload);

export const bootstrapScript = () => browserify({
        entries: paths.bootstrap.script,
        debug: true
    })
    .bundle()
    .pipe(source("bootstrap.js"))
    .pipe(buffer())
    .pipe(gulpif(!production, sourcemaps.init()))
    // @todo
    // .pipe(rigger())
    .pipe(babel())
    .pipe(gulpif(production, uglify()))
    .pipe(gulpif(production, rename({
        suffix: ".min"
    })))
    .pipe(gulpif(!production, sourcemaps.write("./maps/")))
    .pipe(dest($.assets))
    .pipe(debug({
        "title": "Boostrap JS files"
    }))
    .on("end", browsersync.reload);

global.additionalTasks = series(
    parallel(bootstrapStyle)
    // , // bootstrapScript
    // parallel(watchBootstrap)
);

global.additionalWatch = () => {
    watch([paths.bootstrap.style, paths.bootstrap.opts], bootstrapStyle);
    // watch(paths.bootstrap.script, bootstrapScript);
};