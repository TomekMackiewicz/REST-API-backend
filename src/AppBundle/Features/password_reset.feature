Feature: Handle password changing via the RESTful API

  In order to help users quickly regain access to their account
  As a client software developer
  I need to be able to let users request a password reset


  Background:
    Given there are Users with the following details:
      | id | username | email          | password | confirmation_token |
      | 1  | peter    | peter@test.com | testpass |                    |
      | 2  | john     | john@test.org  | johnpass | some-token-string  |
     And I set header "Content-Type" with value "application/json"


  Scenario: Can request a password reset for a valid username
    When I send a "POST" request to "/password/reset/request" with body:
      """
      { "username": "peter" }
      """
    Then the response code should be 200
     And the response should contain "An email has been sent. It contains a link you must click to reset your password."
