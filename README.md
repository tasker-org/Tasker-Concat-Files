#Tasker: Concatenate files

Task which will be concatenate your files for task manager Tasker

###Example of usage
1. Register task into Tasker bootstrap (~/repo/scripts/build.php):
```php
<?php

require_once __DIR__ . '/../libs/server/autoload.php';

$tasker = new \Tasker\Tasker();
$tasker->addConfig(__DIR__ . '/../config/tasker.json')
	->registerTask(new \Tasker\Concat\ConcatFilesTask);
$tasker->run();
```php

2. Create config file **tasker.json**
```json
{
  "concatFiles": {
    "www/build/app.js": [
      "libs/client/angular/angular.min.js",
      "libs/client/angular-resource/angular-resource.min.js"
    ]
  }
}
```json

3. Run Tasker

`php ~/repo/scripts/build.php`

