<?php

namespace Svc\AvatarBundle\Twig;

use Twig\Extension\AbstractExtension;
use Twig\TwigFunction;

class AvatarExtension extends AbstractExtension
{

  public function getFunctions(): array
  {
    dd("ja");
    return [
      new TwigFunction('avatar_url', [$this, 'avatarURL'] , ['is_safe' => ['html']]),
      // 
    ];
  }

  public function avatarURL(?string $name = null): string
  {
    if (!$name) {
      return "";
    }

    return "https://ui-avatars.com/api/?" . http_build_query([
      "name" =>strip_tags($name),
      "size" => "64",
      "background" => "ff0000",
      "hier" => "ja",
    ]);
  }
}
