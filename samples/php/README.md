PHP Samples Configuration
=========================

Installation
------------

Samples require https://github.com/guzzle/guzzle
You can install it via composer.

create-new-webhook.php
----------------------

Rename config.dist.php to config.php and fill with your data.

CALLBACK_URL is the url where you want to receive callbacks.
FOr testing you can use your own http://requestb.in

You only can run the script one with the same event-address. The second time the blockcypher.com API will respond with

{"error":"Hook for url http://requestb.in/172t5up1 and filter event=new-pool-tx&addr=1HB5XMLmzFVj8ALj6mfBsbifRoD4miY36v already exists."}
