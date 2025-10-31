# CLAUDE.md

This file provides guidance to Claude Code (claude.ai/code) when working with code in this repository.

## Project Overview

SvcAvatarBundle is a Symfony bundle that generates avatar URLs and IMG tags using the ui-avatars.com API service. The bundle provides Twig functions (`avatar_url` and `avatar_img`) to display user avatars based on names or email addresses.

**Supported Symfony Versions:** 6.3+ and 7.x
**PHP Version:** 8.2+

## Development Commands

### Testing
```bash
# Run PHPUnit tests
composer test
# Or directly:
vendor/bin/simple-phpunit
```

### Static Analysis
```bash
# Run PHPStan (Level 6)
composer phpstan
# Or directly:
vendor/bin/phpstan analyse src/ --level 6 -c .phpstan.neon
```

### Code Style
```bash
# PHP-CS-Fixer is located at
/opt/homebrew/bin/php-cs-fixer
```

### Dependencies
```bash
# Install dependencies
composer install
```

## Architecture

### Bundle Structure

The bundle follows the modern Symfony bundle architecture (version 4.0+) using `AbstractBundle`:

1. **SvcAvatarBundle** (`src/SvcAvatarBundle.php`): Main bundle class that:
   - Defines configuration schema in `configure()` method
   - Loads services and injects configuration into `AvatarRuntime` via `loadExtension()` method
   - Uses Symfony's new bundle configuration system (requires Symfony >=6.1)

2. **Twig Extension** (`src/Twig/AvatarExtension.php`):
   - Registers two Twig functions: `avatar_url` and `avatar_img`
   - Functions are marked as safe for HTML output

3. **Twig Runtime** (`src/Twig/AvatarRuntime.php`):
   - Core logic for generating URLs and IMG tags
   - Constructs URLs for ui-avatars.com API
   - Handles default configuration and parameter overrides
   - Supports retina displays by doubling image resolution for `avatar_img`
   - **Security**: All user input is sanitized with `strip_tags()` and HTML-escaped with `htmlspecialchars()` to prevent XSS attacks

### Configuration Flow

1. User defines configuration in `config/packages/svc_avatar.yaml`
2. Bundle's `configure()` method defines the schema with defaults
3. Bundle's `loadExtension()` method injects configuration into `AvatarRuntime` constructor
4. `AvatarRuntime` uses injected defaults and allows per-call overrides

### Key Configuration Parameters

- `fontcolor`: Hex color for font (without #) - Validated to be 3 or 6 character hex value
- `backgroundcolor`: Hex color for background or "random" (default: "random") - Validated to be 3 or 6 character hex value or "random"
- `size`: Avatar size in pixels (default: 64, min: 16)
- `rounded`: Boolean for circular avatars (default: false)
- `bold`: Boolean for bold font (default: false) - **Can now be overridden per function call**
- `retina`: Boolean to optimize for retina displays (default: true) - **Only affects `avatar_img`, can be overridden per call**

### Function Parameters

Both `avatar_url()` and `avatar_img()` accept these optional parameters:
- `name` (required): Name or email to generate avatar for
- `size`: Avatar size in pixels
- `background`: Hex background color without #
- `fontColor`: Hex font color without #
- `rounded`: Boolean for circular avatar
- `bold`: Boolean for bold font

Additionally, `avatar_img()` accepts:
- `retina`: Boolean to enable/disable retina optimization (doubles the src size while keeping display size)

### Service Registration

Services are defined in `config/services.yaml` with autowiring enabled:
- `AvatarExtension`: Tagged as `twig.extension`
- `AvatarRuntime`: Tagged as `twig.runtime`

## Testing

Tests are located in `tests/Twig/AvatarRuntimeTest.php` and cover:
- URL generation with various parameter combinations (18 tests, 25 assertions)
- IMG tag generation with proper HTML escaping
- Parameter override behavior for all parameters including `bold` and `retina`
- Edge cases (empty names, null values)
- **Security**: XSS protection through HTML escaping
- **Security**: HTML tag sanitization with `strip_tags()`
- Multiple parameter combinations
- Retina display handling

## Security Considerations

This bundle implements several security measures:

1. **XSS Protection**: All user-provided names are:
   - Sanitized with `strip_tags()` to remove HTML tags
   - Escaped with `htmlspecialchars()` when used in HTML attributes
   - Properly encoded in URLs with `http_build_query()`

2. **Input Validation**: Configuration values are validated:
   - `fontcolor` must be a valid 3 or 6 character hex value (without #)
   - `backgroundcolor` must be either "random" or a valid hex value
   - `size` must be >= 16

3. **HTML Output**: The `avatar_img()` function generates HTML with:
   - Consistent double-quoted attributes
   - All special characters properly escaped
   - Safe handling of all user input

## Code Quality

- **PHPStan Level 6**: All code passes strict static analysis
- **PHP-CS-Fixer**: Code follows PSR standards
- **Type Safety**: Strict types enabled, full type hints on all methods
- **Documentation**: Complete PHPDoc comments for IDE support

## External Dependencies

- **UI Avatars API**: `https://ui-avatars.com/api/` - Third-party service for avatar generation
- Parameters are passed as query strings to this service
