

## purpose

Simplify data generating process for sql databases

## setup

Required tools:
**java** ^8

```
brew tap adoptopenjdk/openjdk
brew cask install adoptopenjdk8
```
	
## start

0. clone this repository 

1. build the app

2. run in terminal

## Arguments

The tool requires input from a keyboard.
You will require to input values each time when the app asks you for info.

#### Operator

Right now only *insert* is implemented.

#### Randomizers

1. rand_text
2. rand_int
3. rand_email
4. rand_hex 

Option: ///value flag, which will generate a value with exact lenght.

## Example

```
Please enter operator. Available operators: insert
insert
Please enter table name:
test
Please enter fields, quantity of fields and values should be same:
test1,test2,test3
Enter string in this format: value,value,value
If you want random value use: rand_text (for random string), rand_int (for random int up to 1000), rand_email (for random email), rand_hex (for HEX)
You could use this sign rand_text///30 to receive random string with 30 chars length
rand_int///30,rand_text,rand_email
Check your request
insert into
test
test1,test2,test3
values
rand_int///30,rand_text,rand_email
Are you sure? y/n
y
Please enter number of lines:
10
```

Output: 

```
INSERT INTO `test`
(`test1`,`test2`,`test3`)
VALUES
('844857161529545518419063203717','SIZ9B353YXGGPMD74AOK','E0H4JH8BOZWN24HMNLDG@test.ru'),
('482988125374867831603676063215','GIL6BKNVI2JKB5N2X7U4','JB6J2BA8140E7J06BYHZ@test.ru'),
('818974078182716013839329959346','ULZEV79WPFQ05O8I25FB','4KQ8WQOPT8JR67MX63EL@test.ru'),
('439144102734257171759688175097','ZGV6FWH4UYYVQPRGD8QJ','CJ83YV001SDVYS21L3HX@test.ru'),
('700673490654237387193857139015','21ZNE0U62V53RSJF8BZQ','6YL4DD3LJ43XYS97Q4ZH@test.ru'),
('472677582757268082012448378439','X91XAMQXX7FY13C1PHPY','UQYQT8XYADH3FPIGTQ2F@test.ru'),
('247503753154441760997976500413','1KUSDBE592G1PULGFA20','LPMTOUOGSZSGDS3VCA8P@test.ru'),
('193720128363504936353671310831','UR2GVAS1OF1MH1UUS61P','Y1I09JXZB71VCEDYFXUP@test.ru'),
('230383607613687191504385665237','PY3Y0I2KQ5S19644EVXI','IYFYTVJFTB0XALO9Q9FV@test.ru'),
('520582035470363210199948244548','Y3VW422P2ALT3VS0TY8M','FE1FSI78Q5QZ2VY0Z4N1@test.ru');
```

#### Note

If you will use strict value during enter value phase, then this value will be used in all columns with the same name. 

Example:

```
Enter string in this format: value,value,value
If you want random value use: rand_text (for random string), rand_int (for random int up to 1000), rand_email (for random email), rand_hex (for HEX)
You could use this sign rand_text///30 to receive random string with 30 chars length
1234,rand_text,rand_email
```

Output:

```
INSERT INTO `test`
(`test1`,`test2`,`test3`)
VALUES
('1234','SIZ9B353YXGGPMD74AOK','E0H4JH8BOZWN24HMNLDG@test.ru');
```