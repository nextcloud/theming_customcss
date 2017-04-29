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

namespace OCA\ThemingCustomCss\Controller;

use OC\Template\SCSSCacher;
use OCP\AppFramework\Controller;
use OCP\AppFramework\Http;
use OCP\AppFramework\Http\DataDisplayResponse;
use OCP\AppFramework\Http\NotFoundResponse;
use OCP\AppFramework\Utility\ITimeFactory;
use OCP\Files\IAppData;
use OCP\IConfig;
use OCP\IL10N;
use OCP\IRequest;

class ThemingController extends Controller {
	/** @var ITimeFactory */
	private $timeFactory;
	/** @var IL10N */
	private $l10n;
	/** @var IConfig */
	private $config;
		/** @var IAppData */
	private $appData;
	/** @var SCSSCacher */
	private $scssCacher;

	/**
	 * ThemingController constructor.
	 *
	 * @param string $appName
	 * @param IRequest $request
	 * @param IConfig $config
	 * @param ITimeFactory $timeFactory
	 * @param IL10N $l
	 * @param IAppData $appData
	 * @param SCSSCacher $scssCacher
	 */
	public function __construct(
		$appName,
		IRequest $request,
		IConfig $config,
		ITimeFactory $timeFactory,
		IL10N $l,
		IAppData $appData,
		SCSSCacher $scssCacher
	) {
		parent::__construct($appName, $request);

		$this->timeFactory = $timeFactory;
		$this->l10n = $l;
		$this->config = $config;
		$this->appData = $appData;
		$this->scssCacher = $scssCacher;
	}

	/**
	 * @NoCSRFRequired
	 * @PublicPage
	 *
	 * @return DataDisplayResponse|NotFoundResponse
	 */
	public function getStylesheet() {
		// TODO: compile SCSS and cache that as a file
		$customCss = $this->config->getAppValue('theming_customcss', 'customcss', '');
		$response = new DataDisplayResponse($customCss, Http::STATUS_OK, ['Content-Type' => 'text/css']);
		$response->cacheFor(86400);
		$expires = new \DateTime();
		$expires->setTimestamp($this->timeFactory->getTime());
		$expires->add(new \DateInterval('PT24H'));
		$response->addHeader('Expires', $expires->format(\DateTime::RFC1123));
		$response->addHeader('Pragma', 'cache');
		return $response;
	}
}
