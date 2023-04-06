/* Dependencies */
import { __ } from '@wordpress/i18n';

import Settings from './Settings';
import '../../scss/admin/style.scss';

function App() {
	return (
		<>
			<div className="wrap">
				<h2 className="instagram-feed-settings-heading dashicons-before dashicons-instagram">
					{ __( 'Instagram API Feed', 'insta-api-feed' ) }
				</h2>

				<div className="settings_container">
					<Settings />
				</div>
			</div>
		</>
	);
}

export default App;
