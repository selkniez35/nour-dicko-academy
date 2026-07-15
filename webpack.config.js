import Encore from '@symfony/webpack-encore';

if (!Encore.isRuntimeEnvironmentConfigured()) {
    Encore.configureRuntimeEnvironment(process.env.NODE_ENV || 'dev');
}

Encore
    .setOutputPath('public/build/')
    .setPublicPath('/build')

    .addEntry('app', './assets/app.js')
    .addEntry('dashboard-eleve', './assets/js/dashboard-eleve.js')
    .addEntry('dashboard-enseignant', './assets/js/dashboard-enseignant.js')
    .addEntry('dashboard-admin', './assets/js/dashboard-admin.js')
    .addEntry('admin-students', './assets/js/admin-students.js')

    .splitEntryChunks()
    .enableSingleRuntimeChunk()

    .cleanupOutputBeforeBuild()

    .enableSourceMaps(!Encore.isProduction())
    .enableVersioning(Encore.isProduction())

    // 🔥 IMPORTANT FIX STIMULUS
    .enableStimulusBridge('./assets/controllers.json')

    .configureBabel((config) => {
        config.plugins.push(['polyfill-corejs3', { method: 'usage-global', version: '3.49' }]);
    })
;

export default Encore.getWebpackConfig();
