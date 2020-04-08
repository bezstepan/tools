#!/bin/bash

# constants
#
EL=$'\n'

# functions
#
# Displays help information about script usage
function display_help() {
    echo "Usage: ./create.sh [options...]"
    echo "Options:"
    echo " -o operator API key"
    echo " -t trusted API key"
    echo " -f factory"
    echo " -tn amount of thngs"
    exit 0
}

# Parses '... "key":"value" ...' string and return the value of the particular key
# Params:
#   $1 string to parse
#   $2 key to find
function parse_field() {
    echo "$1" | grep "\"$2\"" | sed s/.*\"$2\":\"// | sed s/\".*//
}

# Validates if value is equal to expected and ends with error if not
# Params:
#   $1 expected value
#   $2 actual value
#   $3 message to display in case of error
function assert() {
    if [ "$1" != "$2" ]; then
        echo "Error: $3"
        exit 1
    fi
}

# Validates whether the value is not empty and ends with an error in case it is empty.
# Params:
#   $1 actual value
#   $2 message to display in case of error
function assert_not_empty() {
    if [ -z "$1" ]; then
        echo "Error: $2"
        exit 1
    fi
}

# Parses cli arguments and return value if found. Key and value have to be
# separated by space.
# Params:
#   $1 string with arguments to parse
#   $2 key of the argument
function parse_arg() {
    echo " $1" | grep -e " $2 " | sed s/.*[[:space:]]$2[[:space:]]// | sed s/-.*//
}

# parse cli arguments
ARGS=" $@"

#parse help request
if [[ "$1" == "-h" ]] || [[ -z "$@" ]]; then display_help; fi

OPERATOR_API_KEY=$(parse_arg "$ARGS" "-o"); assert_not_empty "$OPERATOR_API_KEY" "operator API key not defined"
TRUSTED_API_KEY=$(parse_arg "$ARGS" "-t"); assert_not_empty "$TRUSTED_API_KEY" "trusted api key not defined"
FACTORY=$(parse_arg "$ARGS" "-f"); assert_not_empty "$FACTORY" "factory not defined"
THNGS=$(parse_arg "$ARGS" "-tn"); assert_not_empty "$THNGS" "amount of thngs not defined"

OPERATOR_API_KEY="$(echo -e "${OPERATOR_API_KEY}" | tr -d '[:space:]')"
TRUSTED_API_KEY="$(echo -e "${TRUSTED_API_KEY}" | tr -d '[:space:]')"
FACTORY="$(echo -e "${FACTORY}" | tr -d '[:space:]')"
THNGS="$(echo -e "${THNGS}" | tr -d '[:space:]')"
#adding data to config
echo "
module.exports = {
  url: 'https://api.evrythng.com/',
  operatorApiKey: '$OPERATOR_API_KEY',
  trustedApiKey: '$TRUSTED_API_KEY',
  factory: 'factory:$FACTORY',
  dummyFactory: 'factory:dummy',
  upca: 0,
  ean13: 1,
  ean8: 0,
  productNotAssignedToApp: false,
  purchaseOrderForMultProducts: false,
  productAmountOfThngs: $THNGS,
  thngsAssignedToFactory: $THNGS,
  thngNotFound: false,
  thngNon15: false,
  notEncodedThngs: 0,
  thngsAssignedToAnotherFactory: 0,
  Thngs24Encoded: 0,
  Thngs24NotEncoded: 0,
}
" > ./config.js

node index.js

php -S localhost:8000