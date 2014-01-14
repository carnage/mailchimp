mailchimp
=========

A pure ZF2 implementation of the Mailchimp API, hacked together from the official API. Features full IDE support for all API methods and has no external dependancies (Except ZF2).

to use enable the module in your application.ini and create a mailchimp.local.php file in your ZF2 config dir with the following:


return array('mailchimp' => array('api'=>array('api-key'=>'yourapikey')));



I'll add composer support asap.
