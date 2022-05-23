<?php

namespace Svc\AvatarBundle;

use Symfony\Component\HttpKernel\Bundle\Bundle;

class SvcAvatarBundle extends Bundle
{
  public function getPath(): string
  {
    return \dirname(__DIR__);
  }
}
