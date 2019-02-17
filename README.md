# RESTful API

- device list
- view, add, edit and delete devices
- the channel list of the specified device, including the latest values
- view, add and change channels of a given device
- a list of values for a given channel for a specified time interval
+ custom model logic 

![preview](https://raw.githubusercontent.com/cyberpaste/restful-api/master/preview.png)

## Install

0) clone repo ```git clone https://github.com/cyberpaste/restful-api``` + Docker-compose + yii2 standart install
1) run command ``` composer update  ```
2) run command ``` yii migrate ```
5) try service (main page swagger documentation with all methods)

## Tests
1) ``` cd frontend ``` 
2) ``` php ../yii_test migrate ```
3) ``` sh ../vendor/bin/codecept run tests/unit/modules ```