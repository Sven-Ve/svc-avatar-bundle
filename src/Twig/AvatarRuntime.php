<?php

namespace Svc\AvatarBundle\Twig;

use Twig\Extension\RuntimeExtensionInterface;

class AvatarRuntime implements RuntimeExtensionInterface
{
  final public const ROOT_URL = 'https://ui-avatars.com/api/';

  public function __construct(private int $iconSize, private string $backgroundColor, private ?string $fontColor, private bool $rounded, private bool $bold)
  {
  }

  public function avatarURL(?string $name = null, ?int $size = null, ?string $background = null, ?string $fontColor = null, ?bool $rounded = null): string
  {
    if (!$name) {
      return '';
    }

    $values = [
      'name' => strip_tags($name),
      'size' => $size ?? $this->iconSize,
      'background' => $background ?? $this->backgroundColor,
    ];

    if ($fontColor ?? $this->fontColor) {
      $values['color'] = $fontColor ?? $this->fontColor;
    }
    if (!($rounded === false) && ($rounded || $this->rounded)) {
      $values['rounded'] = 'true';
    }
    if ($this->bold) {
      $values['bold'] = 'true';
    }

    return self::ROOT_URL . '?' . http_build_query($values);
  }
}
