# Changelog
All notable changes to this project will be documented in this file.

The format is based on [Keep a Changelog](http://keepachangelog.com/)
and this project adheres to [Semantic Versioning](http://semver.org/).

## [v1.9.0 (2022-05-03](https://github.com/nunomaduro/termwind/compare/v1.8.0...v1.9.0)
### Added
- Add `hidden` class by @xiCO2k in https://github.com/nunomaduro/termwind/pull/134
- Add `justify-center` class by @xiCO2k in https://github.com/nunomaduro/termwind/pull/135

### Fixed
- Fixed `justify-*` round calculations by @xiCO2k in https://github.com/nunomaduro/termwind/pull/136
- Fixed `<br>` with classes in [eb2132f](https://github.com/nunomaduro/termwind/commit/eb2132f43d3d7b59c9daa07c13bf7c08d26eda5b)
- Fixed inheritance issues on `justify-*` classes [d050cba](https://github.com/nunomaduro/termwind/commit/d050cba3079efecaaf7ac5bc0b3626b66575903f)

## [v1.8.0 (2022-04-22](https://github.com/nunomaduro/termwind/compare/v1.7.0...v1.8.0)
### Added
- Add `justify-around` and `justify-evenly` classes by @xiCO2k in https://github.com/nunomaduro/termwind/pull/133

## [v1.7.0 (2022-03-30](https://github.com/nunomaduro/termwind/compare/v1.6.2...v1.7.0)
### Added
- Add `justify-between` class in https://github.com/nunomaduro/termwind/pull/129

### Fixed
- `<hr />` width not repecting parent width by @xiCO2k in https://github.com/nunomaduro/termwind/pull/130

## [v1.6.2 (2022-03-18](https://github.com/nunomaduro/termwind/compare/v1.6.1...v1.6.2)
### Fixed
- Fixes support for HTML tags on TableCells by @xiCO2k in https://github.com/nunomaduro/termwind/pull/128

## [v1.6.1 (2022-03-17)](https://github.com/nunomaduro/termwind/compare/v1.6.0...v1.6.1)
### Fixed
- `href` needes to be escaped by @xiCO2k in [9771606](https://github.com/nunomaduro/termwind/commit/ffa0e9f2d9f74df7839055a122aad2e9d9771606)

## [v1.6.0 (2022-02-24)](https://github.com/nunomaduro/termwind/compare/v1.5.0...v1.6.0)
### Added
- Add `MediaQuery` Support by @xiCO2k in https://github.com/nunomaduro/termwind/pull/126
- Upgrade `PHPStan` to v1.0 by @xiCO2k in https://github.com/nunomaduro/termwind/pull/127

## [v1.5.0 (2022-02-14)](https://github.com/nunomaduro/termwind/compare/v1.4.3...v1.5.0)
### Added
- Adds Laravel `TermwindServiceProvider` by @xiCO2k in https://github.com/nunomaduro/termwind/pull/123

## [v1.4.3 (2022-02-03)](https://github.com/nunomaduro/termwind/compare/v1.4.2...v1.4.3)
### Fixed
- Fixes bug having multiple margins while using `width` with `my` by @xiCO2k in https://github.com/nunomaduro/termwind/pull/120

## [v1.4.2 (2022-01-29)](https://github.com/nunomaduro/termwind/compare/v1.4.1...v1.4.2)
### Fixed
- `max-w` with `w-{fraction}` childs by @xiCO2k in https://github.com/nunomaduro/termwind/pull/118

## [v1.4.1 (2022-01-29)](https://github.com/nunomaduro/termwind/compare/v1.4.0...v1.4.1)
### Fixed
- `<href>` with more width that the parent element by @xiCO2k in https://github.com/nunomaduro/termwind/pull/117

## [v1.4.0 (2022-01-26)](https://github.com/nunomaduro/termwind/compare/v1.3.0...v1.4.0)
### Added
- Add support for `space-y` and `space-x`. by @xiCO2k in https://github.com/nunomaduro/termwind/pull/115

## [v1.3.0 (2022-01-12)](https://github.com/nunomaduro/termwind/compare/v1.2.0...v1.3.0)
### Added
- Add `ask()` method. by @xiCO2k in https://github.com/nunomaduro/termwind/pull/112
- Add `max-w-{width}` class. by @xiCO2k in https://github.com/nunomaduro/termwind/pull/111
- Add support for `py`, `pt` and `pb`. by @xiCO2k in https://github.com/nunomaduro/termwind/pull/113

## [v1.2.0 (2021-12-16)](https://github.com/nunomaduro/termwind/compare/v1.1.0...v1.2.0)
### Added
- Add `terminal()->clear()` method. by @xiCO2k in https://github.com/nunomaduro/termwind/pull/107
- Added support for HTML5 tags by @opuu in https://github.com/nunomaduro/termwind/pull/110

### Fixed
- Fix typo in README.md by @marcreichel in https://github.com/nunomaduro/termwind/pull/106
- Fix function_exists() checks by @mabar in https://github.com/nunomaduro/termwind/pull/108
- Fix bug when using emojis with `w-full`. ([f2f426](https://github.com/nunomaduro/termwind/commit/f2f4261f9e2af1181a2816748fac7a6015316f8a))

## [v1.1.0 (2021-12-06)](https://github.com/nunomaduro/termwind/compare/v1.0.0...v1.1.0)
### Added
- Support for Symfony 6 components ([67b9a9](https://github.com/nunomaduro/termwind/commit/67b9a9bab640dde70220d5b415378fe8be311a79))

## v1.0.0 (2021-12-06)

### Added
- Stable version
