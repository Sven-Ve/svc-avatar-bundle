<?php

declare(strict_types=1);

/*
 * This file is part of the SvcAvatar bundle.
 *
 * (c) 2026 Sven Vetter <dev@sv-systems.com>.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Svc\AvatarBundle\Twig\Service;

use PHPUnit\Framework\TestCase;
use Svc\AvatarBundle\Twig\AvatarRuntime;

/**
 * testing the Avatar Runtime class.
 */
final class AvatarRuntimeTest extends TestCase
{
    private AvatarRuntime $avatarRuntime;

    protected function setUp(): void
    {
        $this->avatarRuntime = new AvatarRuntime(32, 'ff0000', 'fff', false, false, true);
    }

    public function testURLEmptyName(): void
    {
        $url = $this->avatarRuntime->avatarURL();
        $this->assertEmpty($url);
    }

    public function testURLWithoutParameter(): void
    {
        $url = $this->avatarRuntime->avatarURL('test');
        $this->assertSame($this->avatarRuntime::ROOT_URL . '?name=test&size=32&background=ff0000&color=fff', $url);
    }

    public function testURLWithSize(): void
    {
        $url = $this->avatarRuntime->avatarURL('test', 100);
        $this->assertSame($this->avatarRuntime::ROOT_URL . '?name=test&size=100&background=ff0000&color=fff', $url);
    }

    public function testURLWithBackGround(): void
    {
        $url = $this->avatarRuntime->avatarURL('test', null, 'ffffff');
        $this->assertSame($this->avatarRuntime::ROOT_URL . '?name=test&size=32&background=ffffff&color=fff', $url);
    }

    public function testURLWithFontColor(): void
    {
        $url = $this->avatarRuntime->avatarURL('test', null, null, 'ffffff');
        $this->assertSame($this->avatarRuntime::ROOT_URL . '?name=test&size=32&background=ff0000&color=ffffff', $url);
    }

    public function testURLWithRounded(): void
    {
        $url = $this->avatarRuntime->avatarURL('test', null, null, null, true);
        $this->assertSame($this->avatarRuntime::ROOT_URL . '?name=test&size=32&background=ff0000&color=fff&rounded=true', $url);

        $url = $this->avatarRuntime->avatarURL('test', null, null, null, null);
        $this->assertSame($this->avatarRuntime::ROOT_URL . '?name=test&size=32&background=ff0000&color=fff', $url);

        $url = $this->avatarRuntime->avatarURL('test', null, null, null, false);
        $this->assertSame($this->avatarRuntime::ROOT_URL . '?name=test&size=32&background=ff0000&color=fff', $url);
    }

    public function testURLWithBold(): void
    {
        $url = $this->avatarRuntime->avatarURL('test', null, null, null, null, true);
        $this->assertSame($this->avatarRuntime::ROOT_URL . '?name=test&size=32&background=ff0000&color=fff&bold=true', $url);

        $url = $this->avatarRuntime->avatarURL('test', null, null, null, null, null);
        $this->assertSame($this->avatarRuntime::ROOT_URL . '?name=test&size=32&background=ff0000&color=fff', $url);

        $url = $this->avatarRuntime->avatarURL('test', null, null, null, null, false);
        $this->assertSame($this->avatarRuntime::ROOT_URL . '?name=test&size=32&background=ff0000&color=fff', $url);
    }

    public function testURLWithMultipleParameters(): void
    {
        $url = $this->avatarRuntime->avatarURL('test', 50, 'abc123', '000', true, true);
        $this->assertSame($this->avatarRuntime::ROOT_URL . '?name=test&size=50&background=abc123&color=000&rounded=true&bold=true', $url);
    }

    public function testURLSanitizesHtmlTags(): void
    {
        $url = $this->avatarRuntime->avatarURL('<script>alert(1)</script>test');
        $this->assertSame($this->avatarRuntime::ROOT_URL . '?name=alert%281%29test&size=32&background=ff0000&color=fff', $url);
    }

    public function testTagWithoutParameter(): void
    {
        $url = $this->avatarRuntime->avatarImg('test');
        $this->assertSame('<img src="' . $this->avatarRuntime::ROOT_URL . '?name=test&amp;size=64&amp;background=ff0000&amp;color=fff" height="32" width="32" alt="test" title="test">', $url);
    }

    public function testTagWithSize(): void
    {
        $url = $this->avatarRuntime->avatarImg('test', 100);
        $this->assertSame('<img src="' . $this->avatarRuntime::ROOT_URL . '?name=test&amp;size=200&amp;background=ff0000&amp;color=fff" height="100" width="100" alt="test" title="test">', $url);
    }

    public function testTagEmptyName(): void
    {
        $url = $this->avatarRuntime->avatarImg();
        $this->assertEmpty($url);
    }

    public function testTagWithBold(): void
    {
        $url = $this->avatarRuntime->avatarImg('test', null, null, null, null, true);
        $this->assertSame('<img src="' . $this->avatarRuntime::ROOT_URL . '?name=test&amp;size=64&amp;background=ff0000&amp;color=fff&amp;bold=true" height="32" width="32" alt="test" title="test">', $url);
    }

    public function testTagWithRetinaDisabled(): void
    {
        $url = $this->avatarRuntime->avatarImg('test', 50, null, null, null, null, false);
        $this->assertSame('<img src="' . $this->avatarRuntime::ROOT_URL . '?name=test&amp;size=50&amp;background=ff0000&amp;color=fff" height="50" width="50" alt="test" title="test">', $url);
    }

    public function testTagWithRetinaEnabled(): void
    {
        $url = $this->avatarRuntime->avatarImg('test', 50, null, null, null, null, true);
        $this->assertSame('<img src="' . $this->avatarRuntime::ROOT_URL . '?name=test&amp;size=100&amp;background=ff0000&amp;color=fff" height="50" width="50" alt="test" title="test">', $url);
    }

    public function testTagEscapesHtmlInAttributes(): void
    {
        $url = $this->avatarRuntime->avatarImg('test\' onload="alert(1)');
        $this->assertStringContainsString('alt="test&#039; onload=&quot;alert(1)"', $url);
        $this->assertStringContainsString('title="test&#039; onload=&quot;alert(1)"', $url);
        $this->assertStringNotContainsString('onload="alert', $url);
    }

    public function testTagEscapesHtmlInSrc(): void
    {
        $url = $this->avatarRuntime->avatarImg('test&param=value');
        $this->assertStringContainsString('src="', $url);
        $this->assertStringContainsString('&amp;', $url);
    }

    public function testTagWithAllParameters(): void
    {
        $url = $this->avatarRuntime->avatarImg('test', 64, 'abc', 'def', true, true, false);
        $this->assertSame('<img src="' . $this->avatarRuntime::ROOT_URL . '?name=test&amp;size=64&amp;background=abc&amp;color=def&amp;rounded=true&amp;bold=true" height="64" width="64" alt="test" title="test">', $url);
    }
}
