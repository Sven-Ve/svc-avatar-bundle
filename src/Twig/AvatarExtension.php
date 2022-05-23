<?php

namespace Svc\AvatarBundle\Twig;

use Twig\Extension\AbstractExtension;
use Twig\TwigFunction;

class AvatarExtension extends AbstractExtension
{
  public function getFunctions(): array
  {
    return [
      new TwigFunction('avatar_url', [AvatarRuntime::class, 'avatarURL'], ['is_safe' => ['html']]),
    ];
  }
}
