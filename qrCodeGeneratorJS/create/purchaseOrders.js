const { substr } = require('locutus/php/strings');

const order = require('../generate/purchaseOrders');
const createProduct = require('../generate/products');
const images = require('./images');

async function multProduct(enabled) {
  if (!enabled) return;

  var product;
  var products = [];

  for (let i = 0; i < 2; i++) {
    product = await createProduct.generate(12);
    await images.makeBarCodeProduct12(substr(product, 2));
    products.push(product);
  }
  for (let i = 0; i < 2; i++) {
    product = await createProduct.generate(13);
    await images.makeBarCodeProduct13(substr(product, 1));
    products.push(product);
  }
  const purchaseOrder = await order.generate(products);
  await images.createPurchaseWithMultProducts(purchaseOrder, products);
}

async function purchaseOrderForProduct(product) {
  const purchaseOrder = await order.generate(product);
  await images.makeQrCodePurchaseOrder(purchaseOrder, product);
}

module.exports = {
  multProduct,
  purchaseOrderForProduct,
};
