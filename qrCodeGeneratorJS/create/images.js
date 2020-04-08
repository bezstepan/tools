const QRCode = require('qrcode');
const fs = require('fs');
const barcode = require('bwip-js');

const preffix = 'https://j.tn.gg/';

async function makeBarCodeProduct13(data) {
  const buf = await barcode.toBuffer({
    bcid: 'ean13',
    text: data,
    includetext: true,
    textxalign: 'center',
    backgroundcolor: 'FFFFFF',
  });
  await fs.writeFile(
    `./codes/product-ean13-${data}.png`,
    buf,
    err => err && console.error(err),
  );
  console.log(`EAN13 created: ${data}`);
}

async function makeBarCodeProduct12(data) {
  const buf = await barcode.toBuffer({
    bcid: 'upca',
    text: data,
    includetext: true,
    textxalign: 'center',
    backgroundcolor: 'FFFFFF',
  });
  await fs.writeFileSync(
    `./codes/product-upca-${data}.png`,
    buf,
    err => err && console.error(err),
  );
  console.log(`UPCA created: ${data}`);
}

async function makeBarCodeProduct8(data) {
  const buf = await barcode.toBuffer({
    bcid: 'ean8',
    text: data,
    includetext: true,
    textxalign: 'center',
    backgroundcolor: 'FFFFFF',
  });
  await fs.writeFile(
    `./codes/product-ean8-${data}.png`,
    buf,
    err => err && console.error(err),
  );
  console.log(`EAN8 created: ${data}`);
}

async function makeQrCodePurchaseOrder(data, product) {
  await QRCode.toFile(`./codes/po-${data}-pr-${product}.png`, [
    { data: `${data}` },
  ]);
  console.log(`Purchase order image created: ${data}`);
}

async function createPurchaseWithMultProducts(data, product) {
  await QRCode.toFile(
    `./codes/po-${data}-pr-${product[0]}-${product[1]}-${product[2]}-${product[3]}.png`,
    [{ data: `${data}` }],
  );
  console.log(`Purchase order for multiple products created: ${data}`);
}

async function makeNotExistThng(data) {
  await QRCode.toFile(`./codes/thng-non-existing-${data}.png`, [
    { data: `${preffix}${data}` },
  ]);
  console.log(`Not existing thng created: ${data}`);
}

async function makeNotEncodedThng(data, length, factory) {
  await QRCode.toFile(
    `./codes/thng-notEncoded-${factory}-${length}-${data}.png`,
    [{ data: `${preffix}${data}` }],
  );
  console.log('Not encoded thng created: ' + data);
}

async function makeNon15Thngs(data, length, factory) {
  await QRCode.toFile(
    `./codes/thng-not-15-encoded-${factory}-${length}-${data}.png`,
    [{ data: `${preffix}${data}` }],
  );
  console.log('Not 15 chars thng created: ' + data);
}

async function makeThngsForFactory(data, length, factory) {
  await QRCode.toFile(`./codes/thng-encoded-${factory}-${length}-${data}.jpg`, [
    { data: `https://j.tn.gg/${data}` },
  ]);
  console.log('Thng assigned to factory: ' + data);
}

module.exports = {
  makeBarCodeProduct13,
  makeBarCodeProduct12,
  makeBarCodeProduct8,
  makeQrCodePurchaseOrder,
  createPurchaseWithMultProducts,
  makeNotExistThng,
  makeNotEncodedThng,
  makeNon15Thngs,
  makeThngsForFactory,
};
