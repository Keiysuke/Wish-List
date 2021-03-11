//Imports
const { Op } = require('sequelize');
const ProductWebsiteModel = require('../models').product_website_model;
const asyncLib = require('async');
const Flash = require('../middlewares/Flash');

//Routes
module.exports = {
    create: function (req, res) {
        const product_id = req.body.product_id;
        const website_id = req.body.website_id;
        const price = req.body.price;
        const url = req.body.url;
        const available_date = req.body.available_date;
        const expiration_date = req.body.expiration_date;

        if (product_id == null || website_id == null || price == null)
            return Flash.msg(res, 400, 'parameter product_id, website_id and price are necessary');

        asyncLib.waterfall([
            //On vérifie que le produit n'est pas déjà lié à ce site web
            function (done) {
                ProductWebsiteModel.findOne({
                    'attributes': ['id'],
                    'where': { 'product_id': product_id, 'website_id': website_id }
                })
                    .then((websiteHasProductFound) => { done(websiteHasProductFound); })
                    .catch((err) => { return Flash.msg(res, 404, 'unable to verify link between website and product', err); })
            },
            //On créé le lien entre le produit et le site
        ], function (websiteHasProduct) {
            if (websiteHasProduct)
                return Flash.msg(res, 409, 'product is already linked to that website');

            ProductWebsiteModel.create({
                'product_id' : product_id,
                'website_id' : website_id,
                'price' : price,
                'url': url,
                'available_date' : available_date,
                'expiration_date' : expiration_date,
            })
                .then(function (newWebsiteHasProduct) {
                    return Flash.msg(res, 201, { 'idWebsite': newWebsiteHasProduct.id })
                })
                .catch((err) => { return Flash.msg(res, 404, 'error on creating link between product and website', err); })
        })
    },
    update: function (req, res) {
        const id = req.body.id;
        const website_id = req.body.website_id;
        const price = req.body.price;
        const url = req.body.url;
        const available_date = req.body.available_date;
        const expiration_date = req.body.expiration_date;

        if (id == null || website_id == null || price == null)
            return Flash.msg(res, 400, 'parameter id, website_id and price are necessary');

        asyncLib.waterfall([
            //On vérifie que le lien existe
            function (done) {
                ProductWebsiteModel.findOne({
                    'attributes': ['id'],
                    'where': { 'id': id }
                })
                    .then((websiteHasProductFound) => { done(websiteHasProductFound); })
                    .catch((err) => { return Flash.msg(res, 404, 'unable to verify link between website and product', err); })
            },
            //On met à jour les infos du lien
        ], function (websiteHasProductFound) {
            if (!websiteHasProductFound)
                return Flash.msg(res, 409, 'this link does not exist');

                websiteHasProductFound.update({
                'website_id' : (website_id ? website_id : websiteHasProductFound.website_id),
                'price' : (price ? price : websiteHasProductFound.price),
                'url': (url ? url : websiteHasProductFound.url),
                'available_date' : (available_date ? available_date : websiteHasProductFound.available_date),
                'expiration_date' : (expiration_date ? expiration_date : websiteHasProductFound.expiration_date),
            })
                .then(function (newWebsiteHasProduct) {
                    return Flash.msg(res, 201, { 'idWebsiteHasProduct': newWebsiteHasProduct.id })
                })
                .catch((err) => { return Flash.msg(res, 404, 'error on updating link between product and website', err); })
        })
    },
    findAll: function (req, res) {
        const limit = parseInt(req.body.limit);
        const offset = parseInt(req.body.offset);
        const where = req.body.where;
        const order = req.body.order;

        let whereCondition = {};

        if (where) {
            whereCondition = where.split(',').map(conds => {
                const cond = conds.split(':');
                if (cond[0] == 'id')
                    return { [cond[0]]: { [Op.like]: '%' + cond[1] + '%' } }
                else
                    return { [cond[0]]: cond[1] }
            })
        }
        
        ProductWebsiteModel.findAll({
            'limit': (!isNaN(limit)) ? limit : null,
            'offset': (!isNaN(offset)) ? offset : null,
            'order': [(order != null) ? order.split(':') : ['id', 'ASC']],
            'where': whereCondition
        })
            .then(function (websiteHasProductFound) {
                return Flash.msg(res, 201, {
                    'count': websiteHasProductFound.length,
                    'results':
                    websiteHasProductFound.map(r => {
                            return {
                                'id': r.id,
                                'product_id': r.product_id,
                                'website_id': r.website_id,
                                'price': r.price,
                                'net_url': r.url,
                                'available_date': r.available_date,
                                'expiration_date': r.expiration_date,
                                'url': '/api/websites/products/' + r.id,
                            }
                        })
                });
            })
            .catch((err) => { return Flash.msg(res, 500, 'error on getting all products from websites', err); })
    },
    findOne: function (req, res) {
        var id = req.params.id;

        //On vérifie que ce lien existe
        ProductWebsiteModel.findOne({
            'attributes': ['id', 'product_id', 'website_id', 'price', 'url', 'available_date', 'expiration_date'],
            'where': { 'id': id },
        })
            .then(function (linkFound) {
                return Flash.msg(res, 201, {
                    'id': linkFound.id,
                    'product_id': linkFound.product_id,
                    'website_id': linkFound.website_id,
                    'price': linkFound.price,
                    'net_url': linkFound.url,
                    'available_date': linkFound.available_date,
                    'expiration_date': linkFound.expiration_date,
                })
            })
            .catch((err) => { return Flash.msg(res, 404, 'this link between a product and a website does not exist', err); })
    }
}