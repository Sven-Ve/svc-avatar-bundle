<?php

declare(strict_types=1);

namespace Svc\AvatarBundle\Twig\Service;

use PHPUnit\Framework\TestCase;
use Svc\AvatarBundle\Twig\AvatarRuntime;

/**
 * testing the Avatar Runtime class.
 */
final class AvatarRuntimeTest extends TestCase
{
  private $avatarRuntime;

  public function setup(): void
  {
    $this->avatarRuntime = new AvatarRuntime(32, 'ff0000', 'fff', false, false);
  }

  public function testURLWithoutParameter(): void
  {
    $url = $this->avatarRuntime->avatarURL('test');
    $this->assertSame($url, $this->avatarRuntime::ROOT_URL . '?name=test&size=32&background=ff0000&color=fff');
  }

  public function testURLWithSize(): void
  {
    $url = $this->avatarRuntime->avatarURL('test', 100);
    $this->assertSame($url, $this->avatarRuntime::ROOT_URL . '?name=test&size=100&background=ff0000&color=fff');
  }

  public function testURLWithBackGround(): void
  {
    $url = $this->avatarRuntime->avatarURL('test', null, 'ffffff');
    $this->assertSame($url, $this->avatarRuntime::ROOT_URL . '?name=test&size=32&background=ffffff&color=fff');
  }

  public function testURLWithFontColor(): void
  {
    $url = $this->avatarRuntime->avatarURL('test', null, null, 'ffffff');
    $this->assertSame($url, $this->avatarRuntime::ROOT_URL . '?name=test&size=32&background=ff0000&color=ffffff');
  }

  public function testURLWithRounded(): void
  {
    $url = $this->avatarRuntime->avatarURL('test', null, null, null, true);
    $this->assertSame($url, $this->avatarRuntime::ROOT_URL . '?name=test&size=32&background=ff0000&color=fff&rounded=true');

    $url = $this->avatarRuntime->avatarURL('test', null, null, null, null);
    $this->assertSame($url, $this->avatarRuntime::ROOT_URL . '?name=test&size=32&background=ff0000&color=fff');

    $url = $this->avatarRuntime->avatarURL('test', null, null, null, false);
    $this->assertSame($url, $this->avatarRuntime::ROOT_URL . '?name=test&size=32&background=ff0000&color=fff');
  }
}
