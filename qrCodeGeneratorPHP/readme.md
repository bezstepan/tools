

## purpose

Simplify data generating process for mobile app testing

## setup

Required tools:
1. php

```
brew install php
```

2. wget

```
Brew install wget 
```

3. codeception

```
wget https://codeception.com/codecept.phar
chmod +x codecept.phar
mv codecept.phar /usr/local/bin/codecept
```

4. composer

```
brew install composer
```

## environment 
all configs are stored in tests/api.suite.yml
basic example set up for evtact environment, but it is possible to create variables for different environments
	
## start
0. clone this repository 

1. perform cleaning commands:

```
rm -rf vendor composer.lock
```

2. setup dependencies

```
composer install
```

3. setup environment variables in tests/api.suite.yml (or create new environment)

4. run barcode and Qr code genaration

```
codecept run api --env evtact bulkCreationCest
```

where evtact is env variable from api.suite.yml

5. result will be stored in codes

## Onboarding bundle

0. setup project, instruction is above

1. run ./onboarding.sh (requires operator API key, trusted API key, factory, projectID)

2. check codes folder for images

## Stability bundle

0. setup php, instruction is above

1. run ./stability.sh (requires operator API key, trusted API key, factory, projectID, amount of thngs)

2. go to: localhost:8000/data.php in your browser.

3. enjoy testing