const fs = require('fs');
const config = require('./config');

const product = require('./create/products');
const purchaseOrder = require('./create/purchaseOrders');
const thng = require('./create/thngs');

function createCodesDirs() {
  try {
    fs.rmdirSync('./codes', { recursive: true });
  } catch (e) {
    console.log(e);
  }

  fs.mkdirSync('./codes');
}

async function start() {
  createCodesDirs();

  purchaseOrder.multProduct(config.purchaseOrderForMultProducts);

  product.scopedEan8(config.ean8);
  product.scopedEan13(config.ean13);
  product.scopedUpcA(config.upca);
  product.notScopedEan13(config.productNotAssignedToApp);

  thng.thngs24Encoded(config.Thngs24Encoded, config.factory);
  thng.thngs24NotEncoded(config.Thngs24NotEncoded, config.factory);
  thng.notEncodedThngs(config.notEncodedThngs, config.factory);
  thng.thngNotExists(config.thngNotFound);
  thng.thngsAssignedToAnotherFactory(
    config.thngsAssignedToAnotherFactory,
    config.dummyFactory,
  );
  thng.thngsAssignedToFactory(config.thngsAssignedToFactory, config.factory);
  thng.non15Thngs(config.thngNon15, config.factory);
}

start();
