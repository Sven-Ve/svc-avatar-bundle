# Architecture

## Bundle Structure

The bundle follows modern Symfony bundle architecture (4.0+) using `AbstractBundle`:

1. **SvcAvatarBundle** (`src/SvcAvatarBundle.php`): Main bundle class
   - Defines configuration schema in `configure()` method
   - Loads services and injects configuration via `loadExtension()`

2. **Twig Extension** (`src/Twig/AvatarExtension.php`):
   - Registers `avatar_url` and `avatar_img` Twig functions
   - Functions marked as safe for HTML output

3. **Twig Runtime** (`src/Twig/AvatarRuntime.php`):
   - Core logic for URL and IMG tag generation
   - Constructs URLs for ui-avatars.com API
   - Handles configuration defaults and parameter overrides
   - Supports retina displays (doubles resolution for `avatar_img`)

## Configuration Flow

1. User defines configuration in `config/packages/svc_avatar.yaml`
2. Bundle's `configure()` validates schema with defaults
3. `loadExtension()` injects configuration into `AvatarRuntime`
4. `AvatarRuntime` uses defaults, allows per-call overrides

## Service Registration

Services defined in `config/services.yaml` with autowiring:
- `AvatarExtension`: Tagged as `twig.extension`
- `AvatarRuntime`: Tagged as `twig.runtime`

## Security Measures

1. **XSS Protection**: User input sanitized with `strip_tags()` and escaped with `htmlspecialchars()`
2. **Input Validation**: Colors validated as hex values, size minimum enforced
3. **URL Encoding**: Parameters encoded via `http_build_query()`

## External Dependencies

- **UI Avatars API**: `https://ui-avatars.com/api/`
