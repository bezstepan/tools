const EVT = require('../api');

async function generate(encode = true, length = 15, factory = '') {
  const thng = randomThng(length);
  const payload = {
    identifiers: { 'gs1:21': thng },
    customFields: {
      test: 'purposes',
      factory: factory,
    },
    tags: [factory, 'action:encodings'],
    name: `testThng: ${thng}`,
  };

  const response = await EVT.trustedApp
    .thng()
    .setFilter(`identifiers.gs1:21=${thng}`)
    .read();

  if (response.length) {
    console.log('thng already exists... retrying');
    generate(encode, length, factory);
  } else {
    console.log('creating thng ' + thng);
    const createdThng = await EVT.trustedApp.thng().create(payload);

    if (encode) {
      console.log('encoding thng ' + thng);
      await EVT.trustedApp
        .thng(createdThng.id)
        .action('encodings')
        .create({ type: 'encoodings' });
    }
  }
  return thng;
}

function randomThng(length) {
  var chars = [
    'A',
    'B',
    'C',
    'D',
    'E',
    'F',
    'G',
    'H',
    'I',
    'J',
    'K',
    'L',
    'M',
    'N',
    'O',
    'P',
    'Q',
    'R',
    'S',
    'T',
    'U',
    'V',
    'W',
    'x',
    'Y',
    'Z',
    '0',
    '1',
    '2',
    '3',
    '4',
    '5',
    '6',
    '7',
    '8',
    '9',
  ];
  var randomThng = '';
  for (let i = 0; i < length; i++) {
    randomThng += chars[Math.floor(Math.random() * chars.length)];
  }
  return randomThng;
}

module.exports = {
  generate,
};
