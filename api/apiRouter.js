//Imports
const express = require('express');
const productsCtrl = require('./routes/productsCtrl');
const websitesCtrl = require('./routes/websitesCtrl');
const productWebsiteCtrl = require('./routes/productWebsiteCtrl');
const purchasesCtrl = require('./routes/purchasesCtrl');
const sellingsCtrl = require('./routes/sellingsCtrl');
const sellStatesCtrl = require('./routes/sellStatesCtrl');
const productStatesCtrl = require('./routes/productStatesCtrl');

//Router
exports.router = (function () {
    const apiRouter = express.Router();

    //Products routes
    apiRouter.route('/products/create').post(productsCtrl.create);
    apiRouter.route('/products/update').put(productsCtrl.update);
    apiRouter.route('/products').get(productsCtrl.findAll);
    apiRouter.route('/products/:id').get(productsCtrl.findOne);

    //WebsiteHasProduct routes
    apiRouter.route('/websites/products/link').post(productWebsiteCtrl.create);
    apiRouter.route('/websites/products/update').put(productWebsiteCtrl.update);
    apiRouter.route('/websites/products').get(productWebsiteCtrl.findAll);
    apiRouter.route('/websites/products/:id').get(productWebsiteCtrl.findOne);
    //Websites routes
    apiRouter.route('/websites/create').post(websitesCtrl.create);
    apiRouter.route('/websites/update').put(websitesCtrl.update);
    apiRouter.route('/websites').get(websitesCtrl.findAll);
    apiRouter.route('/websites/:id').get(websitesCtrl.findOne);

    //Purchases routes
    apiRouter.route('/purchases/create').post(purchasesCtrl.create);
    apiRouter.route('/purchases/update').put(purchasesCtrl.update);
    apiRouter.route('/purchases').get(purchasesCtrl.findAll);
    apiRouter.route('/purchases/:id').get(purchasesCtrl.findOne);
    
    //Selling routes
    apiRouter.route('/selling/create').post(sellingsCtrl.create);
    apiRouter.route('/selling/update').put(sellingsCtrl.update);
    apiRouter.route('/selling').get(sellingsCtrl.findAll);
    apiRouter.route('/selling/:id').get(sellingsCtrl.findOne);

    //Sell States routes
    apiRouter.route('/categories/states/sell/create').post(sellStatesCtrl.create);
    apiRouter.route('/categories/states/sell/update').put(sellStatesCtrl.update);
    apiRouter.route('/categories/states/sell').get(sellStatesCtrl.findAll);
    apiRouter.route('/categories/states/sell/:id').get(sellStatesCtrl.findOne);

    //Product States routes
    apiRouter.route('/categories/states/products/create').post(productStatesCtrl.create);
    apiRouter.route('/categories/states/products/update').put(productStatesCtrl.update);
    apiRouter.route('/categories/states/products').get(productStatesCtrl.findAll);
    apiRouter.route('/categories/states/products/:id').get(productStatesCtrl.findOne);

    return apiRouter;
})();