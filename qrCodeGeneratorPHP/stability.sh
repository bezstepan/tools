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
    echo " -p project ID"
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
PROJECT=$(parse_arg "$ARGS" "-p"); assert_not_empty "$PROJECT" "project id not defined"
FACTORY=$(parse_arg "$ARGS" "-f"); assert_not_empty "$FACTORY" "factory not defined"
THNGS=$(parse_arg "$ARGS" "-tn"); assert_not_empty "$THNGS" "amount of thngs not defined"

if test -f "tests/api.suite.yml.bac"; then
    echo "tests/api.suite.yml.bac exist, SAVE IT!"
else
cp tests/api.suite.yml tests/api.suite.yml.bac
fi
#adding data to config
echo "
# Codeception Test Suite Configuration
#
# Suite for acceptance tests.
# Perform tests in browser using the PhpBrowser or PhpBrowser.
# If you need both PhpBrowser and PHPBrowser tests - create a separate suite.

actor: AcceptanceTester
modules:
    enabled:
        - PhpBrowser:
            url: 'https://thng-access-api-evtci.elastic.evrythng.net/'
        - Asserts
        - Sequence
        - \Helper\Acceptance
        - \Helper\CurlHelper
        - \Helper\CurlDataHelper
        - \Helper\GenerateGtin

# env-depended
env:   
    stab:
        modules:
            enabled:
                - PhpBrowser:
                    url: "https://api.evrythng.com/"
                - \Helper\ConfigHelper:
                    operatorApiKey: $OPERATOR_API_KEY
                    trustedApiKey: $TRUSTED_API_KEY
                    projectId: $PROJECT
                    thngsAssignedToFactory: $THNGS
                    ean13: 1
                    factory: "factory:$FACTORY"
                    factoryValue: "$FACTORY"
                    purchaseOrderAmountOfThngs: $THNGS
" > tests/api.suite.yml

codecept run api --env stab bulkCreationCest

php -S localhost:8000