<?php

declare(strict_types=1);

/*
 * This file is part of the SvcAvatar bundle.
 *
 * (c) 2025 Sven Vetter <dev@sv-systems.com>.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Svc\AvatarBundle\Twig;

use Twig\Extension\RuntimeExtensionInterface;

/**
 * Twig runtime for generating avatar URLs and IMG tags using ui-avatars.com API.
 */
class AvatarRuntime implements RuntimeExtensionInterface
{
    final public const ROOT_URL = 'https://ui-avatars.com/api/';

    public function __construct(private int $iconSize, private string $backgroundColor, private ?string $fontColor, private bool $rounded, private bool $bold, private bool $retina)
    {
    }

    /**
     * Generate an avatar URL for the given name.
     *
     * @param string|null $name       The name or email to generate avatar for (will be sanitized)
     * @param int|null    $size       Avatar size in pixels (default: configured size)
     * @param string|null $background Hex background color without # (default: configured or 'random')
     * @param string|null $fontColor  Hex font color without # (default: configured)
     * @param bool|null   $rounded    Whether to generate circular avatar (default: configured)
     * @param bool|null   $bold       Whether to use bold font (default: configured)
     *
     * @return string The generated avatar URL or empty string if name is empty
     */
    public function avatarURL(?string $name = null, ?int $size = null, ?string $background = null, ?string $fontColor = null, ?bool $rounded = null, ?bool $bold = null): string
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
        $useBold = $bold ?? $this->bold;
        if ($useBold) {
            $values['bold'] = 'true';
        }

        return self::ROOT_URL . '?' . http_build_query($values);
    }

    /**
     * Generate a complete IMG HTML tag for the given name.
     *
     * @param string|null $name       The name or email to generate avatar for (will be sanitized and HTML-escaped)
     * @param int|null    $size       Avatar size in pixels (default: configured size)
     * @param string|null $background Hex background color without # (default: configured or 'random')
     * @param string|null $fontColor  Hex font color without # (default: configured)
     * @param bool|null   $rounded    Whether to generate circular avatar (default: configured)
     * @param bool|null   $bold       Whether to use bold font (default: configured)
     * @param bool|null   $retina     Whether to optimize for retina displays (default: configured)
     *
     * @return string The generated IMG tag with proper HTML escaping or empty string if name is empty
     */
    public function avatarImg(?string $name = null, ?int $size = null, ?string $background = null, ?string $fontColor = null, ?bool $rounded = null, ?bool $bold = null, ?bool $retina = null): string
    {
        if (!$name) {
            return '';
        }
        $name = strip_tags($name);
        $escapedName = htmlspecialchars($name, ENT_QUOTES, 'UTF-8');
        $size = $size ?? $this->iconSize;
        $useRetina = $retina ?? $this->retina;
        $sizeRet = $size * ($useRetina ? 2 : 1);

        $tag = '<img src="' . htmlspecialchars($this->avatarURL($name, $sizeRet, $background, $fontColor, $rounded, $bold), ENT_QUOTES, 'UTF-8') .
          '" height="' . $size .
          '" width="' . $size .
          '" alt="' . $escapedName . '"' .
          ' title="' . $escapedName . '"' .
          '>';

        return $tag;
    }
}
