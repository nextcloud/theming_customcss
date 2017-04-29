
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
$(document).ready(function () {
	$('html > head').append($('<style type="text/css" id="previewStylesCustom"></style>'));
	$('#theming-customcss button').click(function (e) {
		var content = $('#theming-customcss-input').val();
		OCP.AppConfig.setValue('theming_customcss', 'customcss', content, {
			success: function () {
				OC.msg.finishedSuccess('#theming-customcss_settings_msg', t('theming_customcss', 'Saved'));
				$('link[href*="theming_customcss/styles"]').remove();
				$('#previewStylesCustom').replaceWith($('<style type="text/css" id="previewStylesCustom">'+content+'</style>'));
				OCP.AppConfig.setValue('theming_customcss', 'cachebuster', Date.now);
			},
			error: function () {
				OC.msg.finishedError('#theming-customcss_settings_msg', t('theming_customcss', 'Error'));
			}
		});
		OC.msg.startSaving('#theming-customcss_settings_msg');
	});
});
