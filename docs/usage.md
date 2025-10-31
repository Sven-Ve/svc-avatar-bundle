# Usage

## Define your settings
```yaml
# /config/packages/svc_avatar.yaml
# Default configuration for "SvcAvatarBundle"
svc_avatar:

    # Hex color for the font, without the hash (#)
    # Must be a valid 3 or 6 character hex color (e.g., 'fff' or 'ffffff')
    fontcolor:            ~

    # Hex color for the image background, without the hash (#)
    # Can be 'random' or a valid 3 or 6 character hex color (e.g., 'abc' or 'abc123')
    # Default: random
    backgroundcolor:      random

    # Integer specifying the image size in pixels
    # Minimum: 16
    # Default: 64
    size:                 64

    # Boolean specifying if the returned image should be a circle
    # Default: false
    rounded:              false

    # Boolean specifying if the returned letters should use a bold font
    # Default: false
    bold:                 false

    # Boolean specifying if we optimize for retina display (double the image resolution)
    # Only used in the avatar_img tag
    # Default: true
    retina:               true
```

## Display the avatar in a twig template

### Getting the url for an avatar

The `avatar_url` function generates just the URL to the avatar image.

```twig
<img src='{{ avatar_url("Sven.Vetter@gmail.com") }}' width=32 height=32>
```

**Available parameters:**
- `name` (required): Name or email to generate avatar for
- `size`: Avatar size in pixels (default: configured size)
- `background`: Hex background color without # (default: configured or 'random')
- `fontColor`: Hex font color without # (default: configured)
- `rounded`: Whether to generate circular avatar (default: configured)
- `bold`: Whether to use bold font (default: configured)

**Example with parameters:**
```twig
{{ avatar_url("John Doe", size=64, background='abc123', fontColor='ffffff', rounded=true, bold=true) }}
```

### Getting the img tag for an avatar

The `avatar_img` function generates a complete HTML `<img>` tag with proper escaping.

```twig
{{ avatar_img("Sven.Vetter@gmail.com", size=32) }}
```

**Available parameters:**
- `name` (required): Name or email to generate avatar for
- `size`: Avatar size in pixels (default: configured size)
- `background`: Hex background color without # (default: configured or 'random')
- `fontColor`: Hex font color without # (default: configured)
- `rounded`: Whether to generate circular avatar (default: configured)
- `bold`: Whether to use bold font (default: configured)
- `retina`: Whether to optimize for retina displays (default: configured)

**Example with multiple parameters:**
```twig
{{ avatar_img("Sven.Vetter@gmail.com", size=32, background='ffff00', fontColor='ffffff', rounded=true, bold=true) }}
```

**Example with retina disabled:**
```twig
{{ avatar_img("Jane Smith", size=48, retina=false) }}
```

## Security

All user input is automatically sanitized and HTML-escaped to prevent XSS attacks:
- HTML tags are stripped from names using `strip_tags()`
- All HTML attributes are properly escaped using `htmlspecialchars()`
- Special characters in URLs and attributes are safely encoded

