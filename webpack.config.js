const Encore = require('@symfony/webpack-encore');

// Manually configure the runtime environment if not already configured yet
if (!Encore.isRuntimeEnvironmentConfigured()) {
    Encore.configureRuntimeEnvironment(process.env.NODE_ENV || 'dev');
}

Encore
    // directory where compiled assets will be stored
    .setOutputPath('public/build/')

    // public path used by the web server to access the output path
    .setPublicPath('/build')

    // only needed for CDN's or subdirectory deploy
    //.setManifestKeyPrefix('build/')

    /*
     * ENTRY CONFIG
     */
    .addEntry('app', './assets/app.js')

    // Split chunks for better optimization
    .splitEntryChunks()

    // Symfony UX / Stimulus
    .enableStimulusBridge('./assets/controllers.json')

    // Runtime chunk
    .enableSingleRuntimeChunk()

    /*
     * FEATURE CONFIG
     */
    .cleanupOutputBeforeBuild()

    .enableSourceMaps(!Encore.isProduction())

    .enableVersioning(Encore.isProduction())

    .configureBabelPresetEnv((config) => {
        config.useBuiltIns = 'usage';
        config.corejs = '3.38';
    })

// Uncomment if you use Sass/SCSS
//.enableSassLoader()

// Uncomment if you use TypeScript
//.enableTypeScriptLoader()

// Uncomment if you use React
//.enableReactPreset()

// Uncomment if you need jQuery globally
//.autoProvidejQuery()
;

module.exports = Encore.getWebpackConfig();