<?php
/**
 * @copyright Copyright (c) 2020 Julius Härtl <jus@bitgrid.net>
 *
 * @author Julius Härtl <jus@bitgrid.net>
 *
 * @license GNU AGPL version 3 or any later version
 *
 * This program is free software: you can redistribute it and/or modify
 * it under the terms of the GNU Affero General Public License as
 * published by the Free Software Foundation, either version 3 of the
 * License, or (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
 * GNU Affero General Public License for more details.
 *
 * You should have received a copy of the GNU Affero General Public License
 * along with this program. If not, see <http://www.gnu.org/licenses/>.
 *
 */

declare(strict_types=1);


namespace OCA\ThemingCustomCss\Listeners;


use OCA\ThemingCustomCss\AppInfo\Application;
use OCP\App\IAppManager;
use OCP\AppFramework\Http\Events\BeforeLoginTemplateRenderedEvent;
use OCP\AppFramework\Http\Events\BeforeTemplateRenderedEvent;
use OCP\EventDispatcher\Event;
use OCP\EventDispatcher\IEventListener;
use OCP\IConfig;
use OCP\IURLGenerator;
use OCP\Util;

class BeforeTemplateRenderedListener implements IEventListener {

	/** @var IAppManager */
	private $appManager;
	/** @var IConfig */
	private $config;
	/** @var IURLGenerator */
	private $urlGenerator;

	public function __construct(
		IAppManager $appManager,
		IConfig $config,
		IURLGenerator $urlGenerator
	) {
		$this->appManager = $appManager;
		$this->config = $config;
		$this->urlGenerator = $urlGenerator;
	}

	public function handle(Event $event): void {
		if (!$event instanceof BeforeTemplateRenderedEvent && !$event instanceof BeforeLoginTemplateRenderedEvent) {
			return;
		}

		if (!$this->appManager->isEnabledForUser(Application::APP_ID)) {
			return;
		}

		$linkToCSS = $this->urlGenerator->linkToRoute(
			'theming_customcss.Theming.getStylesheet',
			[
				'v' => $this->config->getAppValue('theming_customcss', 'cachebuster', '0'),
			]
		);
		Util::addHeader(
			'link',
			[
				'rel' => 'stylesheet',
				'href' => $linkToCSS,
			]
		);
	}
}
