var elixir = require("laravel-elixir");

require("laravel-elixir-webpack");
// require("laravel-elixir-rollup");

elixir(function(mix) {
	mix.webpack("app.js");
});