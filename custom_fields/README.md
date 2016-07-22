This plugin allows you to define custom fields in your template,
which will be editable in the plugin settings.

You can define available fields with their default values
by using the following code:

`<?php
 $customFields->add([
 	'firstPageTitle' => 'Homepage',
 	'ctaLink' => '#contact',
 	'ctaText' => 'Contact',
 ]);
 ?>`
 
 After that, you can acces those fields within your template
 with the following code:
 
 `<?php
  echo $customFields->get('myfield');
  ?>`