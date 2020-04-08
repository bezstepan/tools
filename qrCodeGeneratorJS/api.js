const EVT = require('evrythng');

const config = require('./config');

EVT.setup({
  url: config.url,
  geolocation: false,
});

const trustedApp = new EVT.TrustedApplication(config.trustedApiKey);
const operatorApp = new EVT.Operator(config.operatorApiKey);

module.exports = {
  trustedApp,
  operatorApp,
};
