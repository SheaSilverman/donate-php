# Donate PHP

My campaign donation page: [https://donate.sheasilverman.com](https://donate.sheasilverman.com)

### About

My name is [Shea Silverman](http://sheasilverman.com), and I am running for Florida's House of Representatives in District 49.  I am running as/with no party affiliation.  

This tool is simple to use.  It integrates with your Stripe account, and uses Stripe metadata to keep track of occupation, employer, and e-mail address.  You can then export from Stripe that info to file your campaign finance reports.

### Configuration

Your server must be running SSL (https), PHP5 and have php-curl installed (most do).

You need to first copy / rename config.py.template to config.py

Then edit these variables:

$header = "HEADER TEXT";  - This will be the text that appears on the top of the site.

$footer = "Political advertisement paid for and approved by FOOTER TEXT"; - This is your footer text.

$STRIPE_SECRET_KEY = "SECRET KEY"; - This will be your Stripe secret key, starts with sk_

$STRIPE_PUBLIC_KEY = "PUBLIC KEY"; - This will be your Stripe public key, starts with pk_

### Issues

If you are getting 500 errors it is most likely because your server does not have php-curl installed.

### License

* Bootstrap Framework - MIT license
* Stripe PHP library - MIT license
* Donate PHP, created by Shea Silverman - MIT license

