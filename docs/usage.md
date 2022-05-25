# Usage

## Define your settings 
```yaml
# /config/packages/svc_avatar.yaml
# Default configuration for "SvcAvatarBundle"
svc_avatar:

    # Hex color for the font, without the hash (#)
    fontcolor:            ~

    # Hex color for the image background, without the hash (#). Default: random
    backgroundcolor:      random

    # Integer specifying the image size
    size:                 64

    # Boolean specifying if the returned image should be a circle. Default: false
    rounded:              false

    # Boolean specifying if the returned letters should use a bold font. Default: false
    bold:                 false

    # Boolean specifying if we optimize for a retina display (double the image resolution, only used in the avatar_img tag). Default: true
    retina:               true
```

## Display the avatar in a twig template

### Getting the url for an avatar

```twig
    <img src='{{ avatar_url("Sven.Vetter@gmail.com") }}' width=32 height=32>
```

### Getting the img tag for an avatar

```twig
    {{ avatar_img("Sven.Vetter@gmail.com", size=32) }}
```

### Parameter

see config parameter, you can overwrite it

Example:
```twig
    {{ avatar_img("Sven.Vetter@gmail.com", size = 32, background = ffff00, fontColor = ffffff, rounded = true) }}
```

