REST-API-backend
==========

A Symfony 3 REST project with FosRest Bundle, backend for AngularJS app.

Bazinga faker:
php bin/console faker:populate
<br>
message	"Full authentication is re…to access this resource."
<br>
https://codereviewvideos.com/course/fosuser-fosrest-lexikjwt-user-login-registration-api/video/password-management-reset-password-part-1
<br>
https://github.com/codereviewvideos/fos-rest-and-user-bundle-integration/blob/master/app/config/routing_rest.yml
<br>
Scenario: Can request a password reset for a valid username                                                           # src/AppBundle/Features/password_reset.feature:16
    When I send a "POST" request to "/password/reset/request" with body:                                                # AppBundle\Features\Context\RestApiContext::iSendARequestWithBody()
      """
      { "username": "john" }
      """
    Then the response code should be 200                                                                                # AppBundle\Features\Context\RestApiContext::theResponseCodeShouldBe()
      Failed asserting that 500 is identical to 200.
    And the response should contain "An email has been sent. It contains a link you must click to reset your password."
<br>
php vendor/bin/behat


