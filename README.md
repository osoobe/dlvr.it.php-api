# osoobe/dlvrit-api

PHP Library for dlvr.it API


### dlvr.it API class

see https://api.dlvrit.com/1/help for Dlvir.it API Specification

Using the API
- Currently 'xml' (default) and 'json' formats are supported. The format is specified by changing the extension of the method name (e.g. .xml or .json)
- Variables are passed to the API via POST
- Your dlvr.it api key can be found in your dlvr.it account at Settings -> Account.

```
@method array|string getRoutes()         List routes.
@method array|string getAccounts()       List accounts.
@method array|string postToRoute()       Post to route or queue.
@method array|string postToAccount()     Post to account.
@method array|string urlShortener()      URL Shortener.
```
