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
# Run PHPStan
composer phpstan
# Or directly:
vendor/bin/phpstan analyse src/ --level 5 -c .phpstan.neon
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

### Configuration Flow

1. User defines configuration in `config/packages/svc_avatar.yaml`
2. Bundle's `configure()` method defines the schema with defaults
3. Bundle's `loadExtension()` method injects configuration into `AvatarRuntime` constructor
4. `AvatarRuntime` uses injected defaults and allows per-call overrides

### Key Configuration Parameters

- `fontcolor`: Hex color for font (without #)
- `backgroundcolor`: Hex color for background (default: "random")
- `size`: Avatar size in pixels (default: 64, min: 16)
- `rounded`: Boolean for circular avatars (default: false)
- `bold`: Boolean for bold font (default: false)
- `retina`: Boolean to optimize for retina displays (default: true, only affects `avatar_img`)

### Service Registration

Services are defined in `config/services.yaml` with autowiring enabled:
- `AvatarExtension`: Tagged as `twig.extension`
- `AvatarRuntime`: Tagged as `twig.runtime`

## Testing

Tests are located in `tests/Twig/AvatarRuntimeTest.php` and cover:
- URL generation with various parameter combinations
- IMG tag generation
- Parameter override behavior
- Edge cases (empty names, null values)

## External Dependencies

- **UI Avatars API**: `https://ui-avatars.com/api/` - Third-party service for avatar generation
- Parameters are passed as query strings to this service
