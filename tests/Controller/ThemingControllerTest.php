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
namespace OCA\ThemingCustomCss\Tests\Controller;

use OC\L10N\L10N;
use OC\Template\SCSSCacher;
use OCA\ThemingCustomCss\Controller\ThemingController;
use OCP\AppFramework\Http;
use OCP\AppFramework\Utility\ITimeFactory;
use OCP\Files\IAppData;
use OCP\Files\NotFoundException;
use OCP\Files\SimpleFS\ISimpleFile;
use OCP\IConfig;
use OCP\IL10N;
use OCP\IRequest;
use Test\TestCase;

class ThemingControllerTest extends TestCase {
	/** @var IRequest|\PHPUnit_Framework_MockObject_MockObject */
	private $request;
	/** @var IConfig|\PHPUnit_Framework_MockObject_MockObject */
	private $config;
	/** @var \OCP\AppFramework\Utility\ITimeFactory */
	private $timeFactory;
	/** @var IL10N|\PHPUnit_Framework_MockObject_MockObject */
	private $l10n;
	/** @var ThemingController */
	private $themingController;
	/** @var IAppData|\PHPUnit_Framework_MockObject_MockObject */
	private $appData;
	/** @var SCSSCacher */
	private $scssCacher;

	public function setUp() {
		$this->request = $this->createMock(IRequest::class);
		$this->config = $this->createMock(IConfig::class);
		$this->timeFactory = $this->createMock(ITimeFactory::class);
		$this->l10n = $this->createMock(L10N::class);
		$this->appData = $this->createMock(IAppData::class);
		$this->scssCacher = $this->createMock(SCSSCacher::class);

		$this->timeFactory->expects($this->any())
			->method('getTime')
			->willReturn(123);

		$this->themingController = new ThemingController(
			'theming',
			$this->request,
			$this->config,
			$this->timeFactory,
			$this->l10n,
			$this->appData,
			$this->scssCacher
		);

		return parent::setUp();
	}

	public function testGetStylesheet() {

		$this->config->expects($this->at(0))
			->method('getAppValue')
			->with('theming_customcss', 'customcss', '')
			->willReturn('* { background-color: black; }');

		$response = new DataDisplayResponse('* { background-color: black; }', Http::STATUS_OK, ['Content-Type' => 'text/css']);
		$response->cacheFor(86400);
		$expires = new \DateTime();
		$expires->setTimestamp($this->timeFactory->getTime());
		$expires->add(new \DateInterval('PT24H'));
		$response->addHeader('Expires', $expires->format(\DateTime::RFC1123));
		$response->addHeader('Pragma', 'cache');
		$actual = $this->themingController->getStylesheet();
		$this->assertEquals($response, $actual);
	}

}
