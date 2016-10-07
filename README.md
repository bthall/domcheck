# domcheck.php

Easily fetch domain expiration dates from CLI

Current version: `1.1`

## Usage:

```bash
./domcheck.php example.com
```

## TLDs currently supported:
* com
* co
* info
* me
* mobi
* net
* org
* tv
* xxx

## Recent changes:
* Updated README
* Updated getExpiration() to use preg_match
* Broke functions out into their own file

## Upcoming changes:
* Allowing arguments, including `help`
