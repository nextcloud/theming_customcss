/*
 * @copyright Copyright (c) 2017 Julius Härtl <jus@bitgrid.net>
 *
 * @author Julius Härtl <jus@bitgrid.net>
 *
 * @license GNU AGPL version 3 or any later version
 *
 *  This program is free software: you can redistribute it and/or modify
 *  it under the terms of the GNU Affero General Public License as
 *  published by the Free Software Foundation, either version 3 of the
 *  License, or (at your option) any later version.
 *
 *  This program is distributed in the hope that it will be useful,
 *  but WITHOUT ANY WARRANTY; without even the implied warranty of
 *  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 *  GNU Affero General Public License for more details.
 *
 *  You should have received a copy of the GNU Affero General Public License
 *  along with this program. If not, see <http://www.gnu.org/licenses/>.
 *
 */
document.addEventListener('DOMContentLoaded', () => {
	const isDarkMode = 
		window.matchMedia('(prefers-color-scheme: dark)').matches ||
		document.body.dataset.theme === 'dark' ||
		document.body.hasAttribute('data-theme-dark');

	ace.config.set('basePath', OC.filePath('theming_customcss', 'js/vendor', 'ace'));
	const editor = ace.edit('theming-customcss-editor');
	editor.setTheme(isDarkMode ? 'ace/theme/clouds_midnight' : 'ace/theme/clouds');
	editor.session.setMode('ace/mode/scss');
	editor.setOptions({
		fontSize: '13px',
		tabSize: 2,
		useSoftTabs: true,
		wrap: true,
		showPrintMargin: false,
	});

	const style = document.createElement('style');
	style.type = 'text/css';
	style.id = 'previewStylesCustom';
	document.head.appendChild(style);

	// sass.js auto-detects its script location unreliably. Set worker path explicitly.
	Sass.setWorkerUrl(OC.filePath('theming_customcss', 'js/vendor', 'sass.worker.js'));

	// Sass instance with Web Worker is created lazily on first save, not on page load.
	let sass = null;

	const button = document.querySelector('#theming-customcss button');
	button.addEventListener('click', () => {
		const content = editor.getValue();
		OC.msg.startSaving('#theming-customcss_settings_msg');

		if (!sass) {
			sass = new Sass();
		}

		sass.compile(content, (result) => {
			if (result.status !== 0) {
				OC.msg.finishedError(
					'#theming-customcss_settings_msg',
					t('theming_customcss', 'SCSS could not be compiled: {message}', { message: result.message })
				);
				return;
			}

			const compiled = result.text;

			// Store raw SCSS first, then compiled CSS. Update live preview and cache
			// only after both config values succeed.
			OCP.AppConfig.setValue('theming_customcss', 'customscss', content, {
				success: () => {
					OCP.AppConfig.setValue('theming_customcss', 'customcss', compiled, {
						success: () => {
							OC.msg.finishedSuccess('#theming-customcss_settings_msg', t('theming_customcss', 'Saved'));
							document.querySelectorAll('link[href*="theming_customcss/styles"]').forEach((el) => el.remove());
							style.textContent = compiled;
							OCP.AppConfig.setValue('theming_customcss', 'cachebuster', `${Date.now()}`);
						},
						error: () => {
							OC.msg.finishedError('#theming-customcss_settings_msg', t('theming_customcss', 'Error'));
						}
					});
				},
				error: () => {
					OC.msg.finishedError('#theming-customcss_settings_msg', t('theming_customcss', 'Error'));
				}
			});
		});
	});
});
