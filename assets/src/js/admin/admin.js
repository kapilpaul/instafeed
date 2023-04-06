/**
 * External dependencies
 */
import $ from 'jquery';

/**
 * WordPress dependencies
 */
const { render } = wp.element;
import App from './App';

let instgramFeedSettingsContainer = document.getElementById(
	'instagram-feed-setting-container'
);

if ( instgramFeedSettingsContainer ) {
	render( <App />, instgramFeedSettingsContainer );
}
