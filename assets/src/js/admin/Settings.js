/* Dependencies */
import { __ } from '@wordpress/i18n';
import {
	Button,
	TextControl,
	Notice,
	ToggleControl,
} from '@wordpress/components';
import { useState, useEffect } from 'react';
import apiFetch from '@wordpress/api-fetch';

import '../../scss/admin/style.scss';

function Settings() {
	const [ isSubmitted, setIsSubmitted ] = useState( false );
	const [ isChanged, setIsChanged ] = useState( false );
	const [ settings, setSettings ] = useState( {
		widget_enable: false,
		instagram_username: '',
		instagram_access_token: '',
	} );
	const [ noticeType, setNoticeType ] = useState( '' );
	const [ notice, setNotice ] = useState( '' );

	useEffect( () => {
		/**
		 * Fetching the api data for settings.
		 */
		apiFetch( {
			path: '/instagram-feed/v1/settings',
		} )
			.then( ( resp ) => {
				setSettings( resp );
			} )
			.catch( ( err ) => {} );
	}, [] );

	/**
	 * Save Settings
	 */
	const saveSettings = () => {
		setIsSubmitted( true );

		let data = {
			settings: settings,
		};

		apiFetch( {
			path: '/instagram-feed/v1/settings',
			method: 'POST',
			data: data,
		} )
			.then( ( resp ) => {
				setIsSubmitted( false );

				setSettings( resp );

				setNoticeType( 'success' );
				setNotice( __( 'Updated Successfully!', 'insta-api-feed' ) );
				setIsChanged( false );
			} )
			.catch( ( err ) => {
				setIsSubmitted( false );
				setNoticeType( 'error' );
				setNotice( __( err.message, 'insta-api-feed' ) );
				setIsChanged( false );
			} );
	};

	/**
	 * Render notice data.
	 *
	 * @returns
	 */
	const renderNotice = () => {
		if ( '' === notice ) {
			return;
		}

		return (
			<div className="instagram-feed-notice-conatiner">
				<Notice
					status={ noticeType }
					onRemove={ () => setNotice( '' ) }
				>
					{ notice }
				</Notice>
			</div>
		);
	};

	/**
	 * Update state on change value.
	 *
	 * @param {*} key
	 * @param {*} value
	 *
	 * @returns void
	 */
	const onChangeValue = ( key, value ) => {
		setSettings( {
			...settings,
			[ key ]: value,
		} );

		setIsChanged( true );
	};

	return (
		<>
			<div className="settings_container__general">
				{ renderNotice() }

				<div className="input-container">
					<div className="form-inputs">
						<div className="group">
							<p className="components-base-control__label">
								{ __(
									'Widget Enable/Disable',
									'insta-api-feed'
								) }
							</p>

							<ToggleControl
								label={ __(
									'Enable Widget',
									'insta-api-feed'
								) }
								checked={ settings?.widget_enable ?? false }
								onChange={ () =>
									onChangeValue(
										'widget_enable',
										! settings?.widget_enable
									)
								}
							/>
						</div>

						<div className="group">
							<TextControl
								label={ __(
									'Instagram Username / ID',
									'insta-api-feed'
								) }
								className={ 'instagram-feed-text-input' }
								value={ settings?.instagram_username }
								onChange={ ( value ) =>
									onChangeValue( 'instagram_username', value )
								}
							/>
						</div>

						<div className="group">
							<TextControl
								label={ __(
									'Instagram API Access Token',
									'insta-api-feed'
								) }
								className={ 'instagram-feed-text-input' }
								value={ settings?.instagram_access_token }
								onChange={ ( value ) =>
									onChangeValue(
										'instagram_access_token',
										value
									)
								}
							/>
						</div>

						<div className="group">
							<label className="components-base-control__label">
								Shortcode Usage
							</label>
							<div
								className="description"
								dangerouslySetInnerHTML={ {
									__html: instagramFeed?.shortcode_help_text,
								} }
							></div>
						</div>
					</div>
				</div>

				<Button
					type="submit"
					isPrimary={ true }
					onClick={ () => saveSettings() }
					isBusy={ isSubmitted }
					disabled={ isSubmitted || ! isChanged }
				>
					{ isSubmitted
						? __( 'Saving', 'insta-api-feed' )
						: __( 'Save', 'insta-api-feed' ) }
				</Button>
			</div>
		</>
	);
}

export default Settings;
