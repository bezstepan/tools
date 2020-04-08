const pad = require('locutus/php/strings/str_pad');

async function generateGtin(length) {
  var string = '';
  for (let i = 0; i < length - 1; i++)
    string = string + Math.floor(Math.random() * 10);
  string = pad(string, 13, '0', 'STR_PAD_LEFT');
  string = pad(string, 14, '0', 'STR_PAD_RIGHT');
  return await addCheckDigit(string);
}

async function addCheckDigit(string) {
  let array = Array.from(string);
  var sum = 0;
  for (let i = 0; i < array.length - 1; i++) {
    if ((array.length + i) % 2 == 0) {
      sum += parseInt(array[i]) * 3;
    } else {
      sum += parseInt(array[i]);
    }
  }
  array[array.length - 1] = (10 - (sum % 10)) % 10;
  return array.join('');
}

module.exports = {
  generateGtin,
};
