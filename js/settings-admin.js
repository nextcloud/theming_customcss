
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
	const style = document.createElement('style');
	style.type = 'text/css';
	style.id = 'previewStylesCustom';
	document.head.appendChild(style);

	const button = document.querySelector('#theming-customcss button');
	button.addEventListener('click', (e) => {
		const content = document.querySelector('#theming-customcss-input').value;
		OCP.AppConfig.setValue('theming_customcss', 'customcss', content, {
			success: () => {
				OC.msg.finishedSuccess('#theming-customcss_settings_msg', t('theming_customcss', 'Saved'));
				document.querySelectorAll('link[href*="theming_customcss/styles"]').forEach((el) => el.remove());
				style.textContent = content;
				OCP.AppConfig.setValue('theming_customcss', 'cachebuster', `${Date.now()}`);
			},
			error: () => {
				OC.msg.finishedError('#theming-customcss_settings_msg', t('theming_customcss', 'Error'));
			}
		});
		OC.msg.startSaving('#theming-customcss_settings_msg');
	});
});