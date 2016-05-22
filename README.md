[![Build Status](https://travis-ci.org/ciaranmcnulty/version-based-test-skipper.svg?branch=master)](https://travis-ci.org/ciaranmcnulty/version-based-test-skipper)

A library for skipping tests based on PHP version in tags

The ultimate aim is to support multiple testing tools, for now just Behat is supported

## Installation

`composer require --dev ciaranmcnulty/versionbasedtestskipper`

## Using with Behat

Edit your `behat.yml`:

```yml
default:
  extensions:
    Cjm\Behat\VersionBasedTestSkipperExtension: ~
```

Use composer-style constraints to tag your scenarios:

```gherkin
@php:~7.0.1
Scenario: will only run in PHP 7.0.1 or greater
```
