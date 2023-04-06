const fs = require( 'fs' );
const path = require( 'path' );
const minimist = require( 'minimist' );
const shell = require( 'shelljs' );

function resolve( ...paths ) {
	return path.resolve( __dirname, ...paths );
}

const DEST = resolve( 'instagram-api-feed' );
const packageInfo = JSON.parse( fs.readFileSync( 'package.json' ) );
const args = minimist( process.argv.slice( 2 ) );

let version = packageInfo.version;

const semverRegex = /^((([0-9]+)\.([0-9]+)\.([0-9]+)(?:-([0-9a-zA-Z-]+(?:\.[0-9a-zA-Z-]+)*))?)(?:\+([0-9a-zA-Z-]+(?:\.[0-9a-zA-Z-]+)*))?)$/;

if ( args.version && args.version.match( semverRegex ) ) {
	const currentVersion = version;
	version = args.version;

	console.log( 'Updating plugin version number' );

	shell.exec(
		`sed -i '' 's/"version": "${ currentVersion }"/"version": "${ version }"/g' package.json`
	);
	shell.exec(
		`sed -i '' 's/* Version: ${ currentVersion }/* Version: ${ version }/g' instagram-api-feed.php`
	);
	shell.exec( `npm install` );
}

console.log( 'Installing composer without dev dependencies...' );

shell.exec( `composer install --optimize-autoloader --no-dev` );

const zip = `instagram-api-feed-${ version }.zip`;

console.log( 'Cleaning the build directory' );
shell.rm( '-rf', DEST );
shell.rm( '-f', resolve( 'instagram-api-feed-*.zip' ) );
shell.mkdir( '-p', DEST + '/assets' );

const include = [
	'assets/css',
	'assets/js',
	'includes',
	'languages',
	'templates',
	'vendor',
	'composer.json',
	'index.php',
	'instagram-api-feed.php',
	'README.md',
	'readme.txt',
];

console.log( 'Copying files...' );

include.forEach( ( item ) => {
	shell.cp( '-r', resolve( '../', item ), resolve( DEST, item ) );
} );

// removing main.assets.pho file which is not necessary.
shell.rm( '-f', resolve( DEST + '/assets/js/main.asset.php' ) );

if ( args.zip ) {
	console.log( 'Making zip...' );
	shell.exec( `cd ${ resolve() } && zip ${ zip } instagram-api-feed -rq` );

	shell.rm( '-rf', resolve( DEST ) );
}

console.log( 'Done.' );
