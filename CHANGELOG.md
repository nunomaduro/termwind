# Changelog
All notable changes to this project will be documented in this file.

The format is based on [Keep a Changelog](http://keepachangelog.com/)
and this project adheres to [Semantic Versioning](http://semver.org/).

## [v2.1.0 (2024-09-05)](https://github.com/nunomaduro/termwind/compare/v2.0.1...v2.1.0)

### Added
- Adds a `parse` function by @lukeraymonddowning in https://github.com/nunomaduro/termwind/pull/184

## [v1.15.1 (2023-02-08)](https://github.com/nunomaduro/termwind/compare/v1.15.0...v1.15.1)

### Fixed
- Fix `justify-*` classes with only one child by @xiCO2k in https://github.com/nunomaduro/termwind/pull/165

## [v1.15.0 (2022-12-20)](https://github.com/nunomaduro/termwind/compare/v1.14.2...v1.15.0)
### Added
- Autocomplete for `ask` method by @fabio-ivona in https://github.com/nunomaduro/termwind/pull/153

### Fixed
- Fix types by @fabio-ivona in https://github.com/nunomaduro/termwind/pull/158

## [v1.14.2 (2022-10-28)](https://github.com/nunomaduro/termwind/compare/v1.14.1...v1.14.2)
### Fixed
- Allow to use `SymfonyStyle` ask method if exists by @xiCO2k in https://github.com/nunomaduro/termwind/pull/156

## [v1.14.1 (2022-10-17)](https://github.com/nunomaduro/termwind/compare/v1.14.0...v1.14.1)
### Fixed
- Fix `truncate` to work well with `w-full` or `w-division`. by @xiCO2k in https://github.com/nunomaduro/termwind/pull/155

## [v1.14.0 (2022-08-01)](https://github.com/nunomaduro/termwind/compare/v1.13.0...v1.14.0)
### Added
- Add support for `w-auto`. by @xiCO2k in https://github.com/nunomaduro/termwind/pull/148
- Add full ANSI color support by @AdamGaskins in https://github.com/nunomaduro/termwind/pull/147

### Fixed
- Fixes bug when using `truncate` with paddings by @xiCO2k in https://github.com/nunomaduro/termwind/pull/149
- Fixes `orange` color by @AdamGaskins and @xiCO2k in https://github.com/nunomaduro/termwind/pull/146 and [4d36921](https://github.com/nunomaduro/termwind/commit/4d36921692248b8d5532d1230f98f59e32896f04)

## [v1.13.0 (2022-07-01)](https://github.com/nunomaduro/termwind/compare/v1.12.0...v1.13.0)
### Added
- Add `min-w-{width}` class by @xiCO2k in (https://github.com/nunomaduro/termwind/pull/143)

### Fixed
- `flex-1` with over `COLUMN` size content by @xiCO2k in (https://github.com/nunomaduro/termwind/pull/142)


## [v1.12.0 (2022-06-27)](https://github.com/nunomaduro/termwind/compare/v1.11.1...v1.12.0)
### Added
- Support for verbosity levels (https://github.com/nunomaduro/termwind/commit/70b564814adb42c98b68cd3f1c2fd4b74ad86eea)

## [v1.11.1 (2022-06-17)](https://github.com/nunomaduro/termwind/compare/v1.11.0...v1.11.1)
### Fixed
- `truncate` only truncates text and not the styling by @xiCO2k in (https://github.com/nunomaduro/termwind/commit/840a9e9d8809603f11d19fe5336270eb96a8d3a8)

## [v1.11.0 (2022-06-17)](https://github.com/nunomaduro/termwind/compare/v1.10.1...v1.11.0)
### Fixed
- Allow `truncate` to be used without params by @xiCO2k in (https://github.com/nunomaduro/termwind/pull/139)

## [v1.10.1 (2022-05-11)](https://github.com/nunomaduro/termwind/compare/v1.10.0...v1.10.1)
### Fixed
- Allow `w-0` to be set by @xiCO2k in [89f4b87](https://github.com/nunomaduro/termwind/commit/89f4b87becc2483d2dbd9daa90f01a8b6472e141)

## [v1.10.0 (2022-05-11)](https://github.com/nunomaduro/termwind/compare/v1.9.0...v1.10.0)
### Added
- Add `flex` and `flex-1` classes by @xiCO2k in https://github.com/nunomaduro/termwind/pull/137
- Add `content-repeat-['.']` class by @xiCO2k in https://github.com/nunomaduro/termwind/pull/138

## [v1.9.0 (2022-05-03)](https://github.com/nunomaduro/termwind/compare/v1.8.0...v1.9.0)
### Added
- Add `hidden` class by @xiCO2k in https://github.com/nunomaduro/termwind/pull/134
- Add `justify-center` class by @xiCO2k in https://github.com/nunomaduro/termwind/pull/135

### Fixed
- Fixed `justify-*` round calculations by @xiCO2k in https://github.com/nunomaduro/termwind/pull/136
- Fixed `<br>` with classes in [eb2132f](https://github.com/nunomaduro/termwind/commit/eb2132f43d3d7b59c9daa07c13bf7c08d26eda5b)
- Fixed inheritance issues on `justify-*` classes [d050cba](https://github.com/nunomaduro/termwind/commit/d050cba3079efecaaf7ac5bc0b3626b66575903f)

## [v1.8.0 (2022-04-22)](https://github.com/nunomaduro/termwind/compare/v1.7.0...v1.8.0)
### Added
- Add `justify-around` and `justify-evenly` classes by @xiCO2k in https://github.com/nunomaduro/termwind/pull/133

## [v1.7.0 (2022-03-30)](https://github.com/nunomaduro/termwind/compare/v1.6.2...v1.7.0)
### Added
- Add `justify-between` class in https://github.com/nunomaduro/termwind/pull/129

### Fixed
- `<hr />` width not respecting parent width by @xiCO2k in https://github.com/nunomaduro/termwind/pull/130

## [v1.6.2 (2022-03-18)](https://github.com/nunomaduro/termwind/compare/v1.6.1...v1.6.2)
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
