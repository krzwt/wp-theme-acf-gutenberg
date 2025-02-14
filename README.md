# Run Command

## Usage

1. Install Dev Depedencies
```sh
npm install 
// or 
yarn install
```
2. To start development and server for live preview
```sh
npm run dev 
// or 
yarn dev
```

# Configuration

To change the path of files and destination/build folder, edit options in **config.js** file
```sh
module.exports = {
	paths: {
		root: ".",
		src: {
			base: "./source",
			scss: "./source/scss",
			js: "./source/js",
		},
		dest: {
			base: "./assets",
			css: "./assets/css",
			js: "./assets/js",
		}
	}
}
```
