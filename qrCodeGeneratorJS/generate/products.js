const EVT = require('../api');

const gtin = require('./gtin');

async function generate(productLength = 13, noScope = false) {
  let productGen;
  const colors = [
    'Black6 N8 white16 123456789012345678901234567890',
    'White',
    'Red',
  ];
  const sizes = ['Size5 N7 Size14 123456789012345678901234567890', 'M', 'L'];
  var product = await gtin.generateGtin(productLength);
  const payload = {
    identifiers: { 'gs1:01': product },
    customFields: {
      test: 'purposes',
      size: sizes[Math.floor(Math.random() * 3)],
      color: colors[Math.floor(Math.random() * 3)],
    },
    name: 'name:' + product,
  };
  if (noScope) {
    productGen = await EVT.operatorApp.product().create(payload);
    if (productGen.error) {
      await console.log('Something went wrong... skipping');
    } else {
      await console.log(`created product: ${product}`);
    }
  } else {
    productGen = await EVT.trustedApp.product().create(payload);
    if (productGen.error) {
      await console.log('Something went wrong... skipping');
    } else {
      await console.log(`created product: ${product}`);
    }
  }

  return product;
}

module.exports = {
  generate,
};
