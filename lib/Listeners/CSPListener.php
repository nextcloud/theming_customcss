<?php
declare(strict_types=1);

namespace OCA\ThemingCustomCss\Listeners;

use OCP\AppFramework\Http\ContentSecurityPolicy;
use OCP\EventDispatcher\Event;
use OCP\EventDispatcher\IEventListener;
use OCP\Security\CSP\AddContentSecurityPolicyEvent;

/**
 * Allows the self-hosted Sass.js Web Worker to run by explicitly setting
 * 'worker-src' in the Content Security Policy. Nextcloud's default policy
 * doesn't grant Workers 'self' access without this exception.
 */
class CSPListener implements IEventListener {
	public function handle(Event $event): void {
		if (!($event instanceof AddContentSecurityPolicyEvent)) {
			return;
		}

		$policy = new ContentSecurityPolicy();
		$policy->addAllowedWorkerSrcDomain('\'self\'');
		$event->addPolicy($policy);
	}
}
