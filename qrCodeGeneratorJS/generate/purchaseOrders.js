const EVT = require('../api');

const config = require('../config');

async function generate(product) {
  const factory = config.factory;
  const purchaseOrder = randomPurchaseOrder(10);
  var payload;
  if (Array.isArray(product)) {
    payload = getMultBody(
      purchaseOrder,
      factory,
      config.productAmountOfThngs,
      product,
    );
  } else {
    payload = getGeneralBody(
      purchaseOrder,
      factory,
      config.productAmountOfThngs,
      product,
    );
  }

  const createPO = await EVT.operatorApp.purchaseOrder().create(payload);

  if (createPO.length) {
    console.log('Purchase order exists, retrying');
    await generatePurchaseOrder(product, factory);
  } else {
    await console.log(`created purchase order: ${purchaseOrder}`);
  }
  return purchaseOrder;
}

function randomPurchaseOrder(length) {
  const digits = [0, 1, 2, 3, 4, 5, 6, 7, 8, 9];
  var randomPO = '';
  for (let i = 0; i < length; i++) {
    randomPO += digits[Math.floor(Math.random() * digits.length)];
  }
  return randomPO;
}

function getGeneralBody(purchaseOrder, factory, thngsAmount, product) {
  const body = {
    id: purchaseOrder,
    version: '1',
    status: 'open',
    purchaser: 'purchaser',
    description: 'test purposes',
    type: '123',
    issueDate: '2019-06-03',
    parties: [
      {
        id: 'gs1:01:996459',
        type: 'ship-to',
      },
      {
        id: factory,
        type: 'ship-from',
      },
      {
        id: 'gs1:008:999997',
        type: 'supplier',
      },
    ],
    lines: [
      {
        id: '00001',
        quantity: thngsAmount,
        exportDate: '2019-06-02',
        deliveryDate: '2019-06-09',
        product: `gs1:01:${product}`,
      },
    ],
    tags: ['generator'],
  };
  return body;
}

function getMultBody(purchaseOrder, factory, thngsAmount, product) {
  const body = {
    id: purchaseOrder,
    version: '1',
    status: 'open',
    purchaser: 'purchaser',
    description: 'test purposes',
    type: '123',
    issueDate: '2019-06-03',
    parties: [
      {
        id: 'gs1:01:996459',
        type: 'ship-to',
      },
      {
        id: factory,
        type: 'ship-from',
      },
      {
        id: 'gs1:008:999997',
        type: 'supplier',
      },
    ],
    lines: [
      {
        id: '00001',
        quantity: thngsAmount,
        exportDate: '2019-06-02',
        deliveryDate: '2019-06-09',
        product: `gs1:01:${product[0]}`,
      },
      {
        id: '00002',
        quantity: thngsAmount,
        exportDate: '2019-06-09',
        deliveryDate: '2019-06-10',
        product: `gs1:01:${product[1]}`,
      },
      {
        id: '00003',
        quantity: thngsAmount,
        exportDate: '2019-06-09',
        deliveryDate: '2019-06-10',
        product: `gs1:01:${product[2]}`,
      },
      {
        id: '00004',
        quantity: thngsAmount,
        exportDate: '2019-06-09',
        deliveryDate: '2019-06-10',
        product: `gs1:01:${product[3]}`,
      },
    ],
    tags: ['generator'],
  };
  return body;
}

module.exports = {
  generate,
};
