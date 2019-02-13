module.exports = function () {
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

    // paths.bootstrap = {
    //     style:  scss + 'bootstrap.scss',
    //     script: js + raw + 'bootstrap.js',
    //     opts:   scss + '_site-settings.scss',
    // }

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
            dir + '**/index.tpl',
            '!' + assets + '**/*',
            '!' + dir + 'inc/**/*.tpl'
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

    if( paths.bootstrap ) {
        paths.src.styles.push('!' + paths.bootstrap.style);

        paths.watch.styles.push('!' + paths.bootstrap.style);
        paths.watch.scripts.push('!' + paths.bootstrap.script)
    }

    return paths;
};


