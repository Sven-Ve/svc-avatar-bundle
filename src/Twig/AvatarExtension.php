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

use Twig\Extension\AbstractExtension;
use Twig\TwigFunction;

class AvatarExtension extends AbstractExtension
{
    public function getFunctions(): array
    {
        return [
            new TwigFunction('avatar_url', [AvatarRuntime::class, 'avatarURL'], ['is_safe' => ['html']]),
            new TwigFunction('avatar_img', [AvatarRuntime::class, 'avatarImg'], ['is_safe' => ['html']]),
        ];
    }
}
