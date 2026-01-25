# CLAUDE.md

## Commands

```bash
composer test                    # Run tests
composer phpstan                 # Run PHPStan
/opt/homebrew/bin/php-cs-fixer   # PHP-CS-Fixer location
```

## Project Constraints

- PHP 8.2+, Symfony 6.3+ and 7.x
- PHPStan Level 6
- Uses modern Symfony bundle architecture with `AbstractBundle`

## Decisions Made

- UI Avatars API at `https://ui-avatars.com/api/`
- XSS protection: `strip_tags()` + `htmlspecialchars()` for all user input
- Retina support doubles resolution in `avatar_img` only
- Configuration validation: hex colors (3 or 6 chars), size minimum 16
