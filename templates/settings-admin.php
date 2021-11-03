<?php
/**
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
script('theming_customcss', 'settings-admin');
style('theming_customcss', 'settings-admin');
?>
<div id="theming-customcss" class="section">
	<h2 class="inlineblock"><?php p($l->t('Custom CSS')); ?></h2>
        <p class="settings-hint"><?php p($l->t('You can specify your own CSS here. Be aware that this might break something after upgrade.')); ?></p>
		<div id="theming-customcss_settings_msg" class="msg success inlineblock" style="display: none;">Saved</div>
	<div>
		<textarea id="theming-customcss-input" placeholder="<?php p($l->t('Insert your custom CSS here …')); ?>"><?php p($_['customcss']) ?></textarea>
		<button class="primary"><?php p($l->t('Save')); ?></button>
	</div>
</div>
