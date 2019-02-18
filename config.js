import { src, dest, watch, parallel, series } from "gulp";

module.exports = function () {
    // @todo move assets
    global.dir += 'wp-content/themes/project/';

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

        global.additionalTasks = parallel(bootstrapStyle, bootstrapScript);
        // [
        //     ,
        //     parallel(watchBootstrap)
        // ];
    }

    return paths;
};

export const bootstrapStyle = () => src(paths.bootstrap.style)
    .pipe(plumber())
    .pipe(gulpif(!production, sourcemaps.init()))
    .pipe(sass())
    .pipe(gulpif(production, autoprefixer({
        browsers: ["last 12 versions", "> 1%", "ie 8", "ie 7"]
    })))
    .pipe(gulpif(!production, browsersync.stream()))
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

export const watchBootstrap = () => {
    watch([paths.bootstrap.style, paths.bootstrap.opts], bootstrapStyle);
    watch(paths.bootstrap.script, bootstrapScript);
};