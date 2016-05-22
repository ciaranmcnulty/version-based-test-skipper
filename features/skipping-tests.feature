Feature: Skipping tests based on tags

  Scenario: Test matches tag
    Given I have a test tagged "php:~5.6"
    And the current version of PHP is "5.7.1"
    When I run the tests
    Then the test should not be skipped

  Scenario: Test does not match tag
    Given I have a test tagged "php:~7.0"
    And the current version of PHP is "5.7.1"
    When I run the tests
    Then the test should be skipped
