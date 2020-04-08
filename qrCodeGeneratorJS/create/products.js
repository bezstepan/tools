const { substr } = require('locutus/php/strings');

const product = require('../generate/products');
const purchaseOrder = require('./purchaseOrders');
const images = require('./images');

function scopedEan8(amount) {
  for (let i = 0; i < amount; i++) createProduct(8);
}

function scopedEan13(amount) {
  for (let i = 0; i < amount; i++) createProduct(13);
}

function scopedUpcA(amount) {
  for (let i = 0; i < amount; i++) createProduct(12);
}

function notScopedEan13(enabled) {
  if (enabled) {
    createProduct(13, enabled);
  }
}

async function createProduct(length, noScope = false) {
  const temp = await product.generate(length, noScope);

  switch (length) {
    case 8:
      await images.makeBarCodeProduct8(substr(temp, 6));
      break;
    case 12:
      await images.makeBarCodeProduct12(substr(temp, 2));
      break;
    case 13:
      await images.makeBarCodeProduct13(substr(temp, 1));
      break;
  }

  await purchaseOrder.purchaseOrderForProduct(temp);
}

module.exports = {
  scopedEan8,
  scopedEan13,
  scopedUpcA,
  notScopedEan13,
};
