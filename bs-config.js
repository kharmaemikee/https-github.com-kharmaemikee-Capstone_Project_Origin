module.exports = {
    proxy: "http://127.0.0.1:8000", // Laravel development server
    files: [
        "resources/views/**/*.blade.php",
        "resources/css/**/*.css",
        "resources/js/**/*.js",
        "public/css/**/*.css",
        "public/js/**/*.js"
    ],
    watchOptions: {
        ignoreInitial: true,
        ignored: [
            "node_modules/**",
            "vendor/**",
            "storage/**",
            "bootstrap/cache/**"
        ]
    },
    port: 3000,
    open: true,
    notify: true,
    reloadDelay: 500,
    logLevel: "info",
    logPrefix: "Browsersync",
    logConnections: true,
    logFileChanges: true
};
