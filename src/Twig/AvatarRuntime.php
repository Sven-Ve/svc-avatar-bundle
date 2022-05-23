<?php

namespace Svc\AvatarBundle\Twig;

use Twig\Extension\RuntimeExtensionInterface;

class AvatarRuntime implements RuntimeExtensionInterface
{
  public function __construct(private int $iconSize, private string $backgroundColor, private ?string $fontColor, private bool $rounded, private bool $bold)
  {
  }


  public function avatarURL(?string $name = null): string
  {
    if (!$name) {
      return '';
    }

    $values = [
      'name' => strip_tags($name),
      'size' => $this->iconSize,
      'background' => $this->backgroundColor,
    ];

    if ($this->fontColor) {
      $values['color'] = $this->fontColor;
    }
    if ($this->rounded) {
      $values['rounded'] = 'true';
    }
    if ($this->bold) {
      $values['bold'] = 'true';
    }

    return 'https://ui-avatars.com/api/?' . http_build_query($values);
  }
}
