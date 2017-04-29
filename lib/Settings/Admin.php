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

namespace OCA\ThemingCustomCss\Settings;

use OCA\Theming\ThemingDefaults;
use OCP\AppFramework\Http\TemplateResponse;
use OCP\IConfig;
use OCP\IL10N;
use OCP\IURLGenerator;
use OCP\Settings\ISettings;

class Admin implements ISettings {
	/** @var IConfig */
	private $config;
	/** @var IL10N */
	private $l;
	/** @var ThemingDefaults */
	private $themingDefaults;
	/** @var IURLGenerator */
	private $urlGenerator;

	public function __construct(IConfig $config,
								IL10N $l,
								ThemingDefaults $themingDefaults,
								IURLGenerator $urlGenerator) {
		$this->config = $config;
		$this->l = $l;
		$this->themingDefaults = $themingDefaults;
		$this->urlGenerator = $urlGenerator;
	}

	/**
	 * @return TemplateResponse
	 */
	public function getForm() {
		$customcss = $this->config->getAppValue('theming_customcss', 'customcss', '');

		$parameters = [
			'customcss' => $customcss
		];

		return new TemplateResponse('theming_customcss', 'settings-admin', $parameters, '');
	}

	/**
	 * @return string the section ID, e.g. 'sharing'
	 */
	public function getSection() {
		return 'theming';
	}

	/**
	 * @return int whether the form should be rather on the top or bottom of
	 * the admin section. The forms are arranged in ascending order of the
	 * priority values. It is required to return a value between 0 and 100.
	 *
	 * E.g.: 70
	 */
	public function getPriority() {
		return 10;
	}

}
