const path = require("path");

module.exports = (env, argv) => {
  const isProduction = argv.mode === "production";

  return {
    target: "web",
    entry: {
      main: path.resolve(__dirname, "js", "main.js"),
      login: path.resolve(__dirname, "js", "login.js"),
      registro: path.resolve(__dirname, "js", "registro.js"),
      pliticayterminos: path.resolve(__dirname, "js", "pliticayterminos.js"),
    },
    output: {
      path: path.resolve(__dirname, "public", "dist"),
      filename: "[name].js",
      clean: true,
    },
    devtool: isProduction ? false : "source-map",
    optimization: {
      minimize: isProduction,
    },
    stats: "errors-warnings",
  };
};
