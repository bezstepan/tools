const generateThng = require('../generate/thngs');
const images = require('./images');

const DEFAULT_LENGTH = 15;
const LENGTH_14 = 14;
const LENGTH_24 = 24;

function thngNotExists(enabled) {
  if (enabled) {
    createThng('notExists');
  }
}

function notEncodedThngs(amount, factory) {
  for (let i = 0; i < amount; i++) {
    createThng('notEncodedThngs', factory);
  }
}

function non15Thngs(enabled, factory) {
  if (enabled) {
    createThng('non15', factory);
  }
}

function thngsAssignedToFactory(amount, factory) {
  for (let i = 0; i < amount; i++) {
    createThng('thngsAssignedToFactory', factory);
  }
}

function thngsAssignedToAnotherFactory(amount, factory) {
  for (let i = 0; i < amount; i++) {
    createThng('thngsAssignedToAnotherFactory', factory);
  }
}

function thngs24Encoded(amount, factory) {
  for (let i = 0; i < amount; i++) {
    createThng('24ThngsEncoded', factory);
  }
}

function thngs24NotEncoded(amount, factory) {
  for (let i = 0; i < amount; i++) {
    createThng('24ThngsNotEncoded', factory);
  }
}

async function createThng(type, factory) {
  let thng = '';

  switch (type) {
    case 'notExists':
      thng = 'AAAAABBBBBCCCCC';
      images.makeNotExistThng(thng);
      break;
    case 'notEncodedThngs':
      thng = await generateThng.generate(false, DEFAULT_LENGTH, factory);
      images.makeNotEncodedThng(thng, DEFAULT_LENGTH, factory);
      break;
    case 'non15':
      thng = await generateThng.generate(true, LENGTH_14, factory);
      images.makeNon15Thngs(thng, LENGTH_14, factory);
      break;
    case 'thngsAssignedToFactory':
      thng = await generateThng.generate(true, DEFAULT_LENGTH, factory);
      images.makeThngsForFactory(thng, DEFAULT_LENGTH, factory);
      break;
    case 'thngsAssignedToAnotherFactory':
      thng = await generateThng.generate(true, DEFAULT_LENGTH, factory);
      images.makeThngsForFactory(thng, DEFAULT_LENGTH, factory);
      break;
    case '24ThngsEncoded':
      thng = await generateThng.generate(true, LENGTH_24, factory);
      images.makeThngsForFactory(thng, LENGTH_24, factory);
      break;
    case '24ThngsNotEncoded':
      thng = await generateThng.generate(false, LENGTH_24, factory);
      images.makeNotEncodedThng(thng, LENGTH_24, factory);
      break;
    default:
      break;
  }
}

module.exports = {
  thngs24Encoded,
  thngs24NotEncoded,
  non15Thngs,
  notEncodedThngs,
  thngNotExists,
  thngsAssignedToAnotherFactory,
  thngsAssignedToFactory,
};
