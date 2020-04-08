## purpose

Simplify data generating process for mobile app testing

## requirements

1. Node ^13.1.0
2. yarn
3. PHP ^7.4.0 (optional, will be required only for stability testing)

## setup

#### Install homebrew

```
/usr/bin/ruby -e "$(curl -fsSL https://raw.githubusercontent.com/Homebrew/install/master/install)"
```

#### Install Node

```
$ brew install node
$ brew update
$ brew doctor
$ brew upgrade
$ brew upgrade node
```

#### Install Yarn

```
$ npm -g install yarn
```

#### Install php (optional)

```
$ brew install php
```

## config

#### Location

```
./config.js
```

#### Variables explanation

* **url:** api address (string)
* **operatorApiKey:** operator API key (string)
* **trustedApiKey:** trusted APP key (string)
* **factory:** factory for which the tool will create all artifacts (string)
* **dummyFactory:** not existing factory for several negatives (string)
* **upca:** 12 digits bar code (int, amount)
* **ean13:** 13 digits bar code (int, amount)
* **ean8:** 8 digits bar code, _negative_ (int, amount)
* **productAmountOfThngs:** amount of thngs which will be reqired to fulfill the line order on PO (int, amount)
* **thngsAssignedToFactory:** amount of 15 length thngs assigned to the factory (int, amount)
* **notEncodedThngs:** amount of 15 length thngs assigned to the factory, but not encoded, _negative_ (int, amount)
* **thngsAssignedToAnotherFactory:** amount of thngs assigned to the dummyFactory, _negative_ (string)
* **Thngs24Encoded:** amount of 24 length thngs assigned to the factory (int, amount)
* **Thngs24NotEncoded:** amount of 24 length thngs assigned to the factory, but not encoded, _negative_ (int, amount)
* **purchaseOrderForMultProducts:** creates PO with several products (boolean)
* **productNotAssignedToApp:** creates product which is not scoped to the app, _negative_ (boolean)
* **thngNotFound:** creates not existing thng, _negative_ (boolean)
* **thngNon15:** creates not 15 or not 24 length thng, _negative_ (boolean)

#### Config example

```
module.exports = {
  url: 'https://api.evrythng.com/',
  operatorApiKey:
    'fakeOperatorKey',
  trustedApiKey:
    'fakeTrustedKey',
  factory: 'factory:1110000007',
  dummyFactory: 'factory:dummy',
  upca: 1,
  ean13: 1,
  ean8: 1,
  productNotAssignedToApp: true,
  purchaseOrderForMultProducts: true,
  productAmountOfThngs: 10,
  thngsAssignedToFactory: 40,
  thngNotFound: true,
  thngNon15: true,
  notEncodedThngs: 1,
  thngsAssignedToAnotherFactory: 2,
  Thngs24Encoded: 4,
  Thngs24NotEncoded: 1,
};
```

## Working with a script

#### Installing dependencies

1. Install dependencies:

```
$ cd scripts/test_data_generator
$ yarn
```

#### Create a bundle for testing

1. Fill the config file with valid values

2. Run command:

```
$ node index.js
```

3. All artifacts will be stored in ./codes

#### Start stability testing

1. Run ./stability.sh (requires operator API key, trusted API key, factory, amount of thngs)

2. Go to: localhost:8000/index.php in your browser.
